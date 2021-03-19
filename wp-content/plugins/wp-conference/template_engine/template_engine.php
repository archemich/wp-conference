<?php

class ConfTemplateEngine
{
    public function __construct()
    {
        add_action('init', array($this, 'generate_word'));
        add_action('admin_menu', array($this,'top_submenu'));
        
        wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
    }

    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Conference шаблонизатор документов',
            'Conference шаблонизатор документов',
            'manage_options',
            'conference_template_engine',
            array($this, 'top_submenu_html')
        );
    }
    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <form action="" method="post" >
                <input type="text" name="first_name">Имя
                <input type="submit" name="generate_word" value="Сгенерировать Word документ">
           </form>
        </div> 
        <?php
    }

    public function generate_word()
    {
        if(isset($_POST['generate_word'])){
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__).'/Template.docx');
            $templateProcessor->setValue('firstname', $_POST['first_name']);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="conf_invitation'.date('d-m-y').'.docx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templateProcessor, 'Word2007');
            $objWriter->save('php://output');
        }


    }

}