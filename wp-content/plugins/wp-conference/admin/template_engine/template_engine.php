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
                <input type="text" name="first_name">Имя
                <input type="submit" name="generate_invitation_manual" value="Сгенерировать Word документ">
           </form>
        </div> 
        <?php
    }

    public function generate_invitation_manual(){echo '';}

    public static function generate_invitation($first_name)
    {
            $templateProcessor = new TemplateProcessor(dirname(__FILE__).'/Template.docx');
            $templateProcessor->setValue('first_name', $first_name);
            return $templateProcessor;
    }
}