<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ConfStats 
{
    

    public function __construct()
    {
        add_action('init', array($this, 'export_users'));
        add_action('init', array($this, 'export_applications'));
        add_action('init', array($this, 'export_reports'));
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
            
                <input type="submit" name="export_reports" value="Скачать доклады">
            </form>
        </div> 
        <?php
    }


    public function export_users()
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
        }
    }

    public function export_applications()
    {
        if(isset($_POST['export_applications']))
        {
            global $wpdb;
            $tempdir = 'applications';
            $tempdir_path = dirname(__FILE__) . '/'. $tempdir;
            if(is_dir($tempdir_path)) {
                removeDir($tempdir_path);
            }
            @mkdir($tempdir_path);
            $applications = $wpdb->get_results('SELECT id, post_author FROM wp_posts WHERE post_type = "application";');
            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Фамилия');
            $active_sheet->setCellValue('B1', 'Имя');
            $active_sheet->setCellValue('C1', 'Отчество');
            $active_sheet->setCellValue('D1', 'Дата рождения');
            $active_sheet->setCellValue('E1', 'Город');
            $active_sheet->setCellValue('F1', 'Основное место работы');
            $active_sheet->setCellValue('G1', 'Основное место работы (Аббревиатура)');
            $active_sheet->setCellValue('H1', 'Должность');
            $active_sheet->setCellValue('I1', 'Ученая степень');
            $active_sheet->setCellValue('J1', 'Ученое звание');
            $active_sheet->setCellValue('K1', 'Телефон рабочий');
            $active_sheet->setCellValue('L1', 'Телефон для связи на конференции');
            $active_sheet->setCellValue('M1', 'E-Mail');
            $active_sheet->setCellValue('N1', 'Форма участия');
            $active_sheet->setCellValue('O1', 'Хочет получить печатное издание');
            $active_sheet->setCellValue('P1', 'Ознакомлен с пользовательским соглашением');
            $row_index = 2;

            foreach($applications as $application) {
                $user = get_userdata($application->post_author);
                $usermeta = get_user_meta($user->id);
                $active_sheet->setCellValue('A'.$row_index, $user->last_name);
                $active_sheet->setCellValue('B'.$row_index, $user->first_name);
                $active_sheet->setCellValue('C'.$row_index, $usermeta['otchestvo'][0]);
                $active_sheet->setCellValue('D'.$row_index, $usermeta['data_rozhdenia'][0]);
                $active_sheet->setCellValue('E'.$row_index, $usermeta['gorod'][0]);
                $active_sheet->setCellValue('F'.$row_index, $usermeta['organizaciya'][0]);
                $active_sheet->setCellValue('G'.$row_index, $usermeta['organizaciya_abbreviatura'][0]);
                $active_sheet->setCellValue('H'.$row_index, $usermeta['dolzhnost'][0]);
                $active_sheet->setCellValue('I'.$row_index, $usermeta['uchenaya_stepen'][0]);
                $active_sheet->setCellValue('J'.$row_index, $usermeta['uchenoe_zvanie'][0]);
                $active_sheet->setCellValue('K'.$row_index, $usermeta['telephon_rabochiy'][0]);
                $active_sheet->setCellValue('L'.$row_index, $usermeta['telephon_conferencia'][0]);
                $active_sheet->setCellValue('M'.$row_index, $usermeta['email'][0]);
                $active_sheet->setCellValue('N'.$row_index, $usermeta['forma_uchastia'][0]);
                $active_sheet->setCellValue('O'.$row_index, $usermeta['pechatnoe_izdanie'][0]);
                $active_sheet->setCellValue('P'.$row_index, $usermeta['soglashenie'][0]);
            
                $row_index++;
                }

            $writer = IOFactory::createWriter($doc, 'Xlsx');
            $writer->save($tempdir_path.'/applications.xlsx');
        }
    }


    public function export_reports()
    {
        if(isset($_POST['export_reports']))
        {
            global $wpdb;
            $tempdir = 'reports';
            $tempdir_path = dirname(__FILE__) . '/'. $tempdir;
            if(is_dir($tempdir_path)) {
                removeDir($tempdir_path);
            }

            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Конференция');
            $active_sheet->setCellValue('B1', 'Направление работы');
            $active_sheet->setCellValue('C1', 'Автор');
            $active_sheet->setCellValue('D1', 'Название доклада');
            $active_sheet->setCellValue('E1', 'Организация аббревиатура');
            $active_sheet->setCellValue('F1', 'Город');
            $active_sheet->setCellValue('G1', 'Статус');
            $row_index = 2;

            @mkdir($tempdir_path);
            $reports = $wpdb->get_results('SELECT a.id, a.post_author, a.post_title, a.post_status, b.id as pdf_id, c.meta_value as pdf_path FROM wp_posts a JOIN wp_posts b on b.post_parent = a.id JOIN wp_postmeta c ON c.post_id = b.id WHERE a.post_type = "report";');
            foreach($reports as $report) {
                $pdf_path = wp_upload_dir()['basedir'] .'/'. $report->pdf_path;
                $user = get_userdata($report->post_author);
                $usermeta = get_user_meta($user->id);
            
                $postmeta = get_post_meta($report->id);
                $post_title = str_replace(' ','_',$report->post_title);
                $filename =  $user->last_name.'_'. $user->first_name. '_'.$post_title . '_report';
                $ext = pathinfo($pdf_path)['extension'];
                copy($pdf_path, $tempdir_path .'/' . $filename .'.'. $ext);
                $active_sheet->setCellValue('A'.$row_index, $postmeta['lokalnaya_conferencia'][0]);
                $active_sheet->setCellValue('B'.$row_index, $postmeta['napravlenie'][0]);
                $active_sheet->setCellValue('C'.$row_index, $user->last_name. ' '. $user->first_name. ' ' . $usermeta['otchestvo'][0]);
                $active_sheet->setCellValue('D'.$row_index, $report->post_title);
                $active_sheet->setCellValue('E'.$row_index, $usermeta['organizaciya_abbreviatura'][0]);
                $active_sheet->setCellValue('F'.$row_index, $usermeta['gorod'][0]);
                if ($report->post_status == 'publish')
                    $active_sheet->setCellValue('G'.$row_index, 'Принят');
                else if ($report->post_status == 'pending')
                    $active_sheet->setCellValue('G'.$row_index, 'На модерации');
                $row_index++;
                }

            $writer = IOFactory::createWriter($doc, 'Xlsx');
            $writer->save($tempdir_path.'/reports.xlsx');
            
            
            
            
           

            // header("Pragma: public");
            // header("Expires: 0");
            // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            // header("Cache-Control: public");
            // header("Content-Description: File Transfer");
            // header("Content-type: application/zip");
            // header("Content-Disposition: attachment; filename=".$zipname);
            // header("Content-Transfer-Encoding: binary");
            // header("Content-Length: ".filesize($zippath));
            // @readfile($zippath);

        }
    }
}

