<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ConfStats 
{
    

    public function __construct()
    {
        add_action('init', array($this, 'export_excel'));
        add_action('admin_menu', array($this,'top_submenu'));
        
        wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'css/style.css' );


    }

    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Conference Stats',
            'Conference Stats',
            'manage_options',
            'conference_stats',
            array($this, 'top_submenu_html')
        );
    }
    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <form method="post" action="" name="users" class="stats_form">
                <input type="submit" name="export_users" value="Скачать пользователей">
            </form>
            <form method="post" action="" name="applications" class="stats_form">
                <input type="submit" name="export_applications" value="Скачать заявки">
            </form>
            <form method="post" action="" name="report" class="stats_form">
                <input type="text">
                <input type="checkbox" name="" id="">
                <input type="submit" name="export_reports" value="Скачать доклады">
            </form>
        </div> 
        <?php
    }

    public function setup_scripts()
    {
    }

    public function export_excel()
    {
        if(isset($_POST['export_users'])){
            global $wpdb;
            $res = $wpdb->get_results("SELECT display_name, user_email FROM wp_users;");
            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Name');
            $active_sheet->setCellValue('B1', 'E-mail');
            $row_index = 2;
            foreach($res as $row) {
                $active_sheet->setCellValue('A'.$row_index, $row->display_name);
                $active_sheet->setCellValue('B'.$row_index, $row->user_email);
                $row_index++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="conf_users.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = IOFactory::createWriter($doc, 'Xlsx');
            $writer->save('php://output');
            exit;
        }
    }
}