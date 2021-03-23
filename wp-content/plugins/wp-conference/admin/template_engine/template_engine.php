<?php
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;

class ConfTemplateEngine
{
    public function __construct()
    {
        add_action('init', array($this, 'generate_invitation_manual'));
        add_action('admin_menu', array($this,'top_submenu'));
        
        wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
    }


    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Шаблонизатор документов',
            'Шаблонизатор документов',
            'manage_options',
            'conference_template_engine',
            array($this, 'top_submenu_html')
        );
    }


    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
        <h2>Conference Шаблонизатор документов</h2>
            <form action="" method="post" >
                <input type="text" name="name">Имя<br>
                <input type="text" name="conference">Конференция<br>
                <input type="submit" name="generate_invitation_manual" value="Сгенерировать Word документ">
           </form>
        </div> 
        <?php
    }

    public function generate_invitation_manual(){
        if (isset($_POST['generate_invitation_manual'])) {
            $templateProcessor = new TemplateProcessor(dirname(__FILE__).'/Template.docx');
            $templateProcessor->setValue('name', $_POST['name']);
            $templateProcessor->setValue('conference', $_POST['conference']);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="conf_invitation'.$name.'.docx"');
            header('Cache-Control: max-age=0');
            $templateProcessor->saveAs('php://output');
        }
    }

    public static function generate_invitation($name, $conference)
    {
            $templateProcessor = new TemplateProcessor(dirname(__FILE__).'/Template.docx');
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('conference', $conference);

            return $templateProcessor;
    }
}