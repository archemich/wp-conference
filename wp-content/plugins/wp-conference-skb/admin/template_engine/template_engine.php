<?php
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;

class ConfTemplateEngine
{
    public function __construct()
    {
        add_action('init', array($this, 'generate_invitation_for_user'));
        add_action('init', array($this, 'upload_template'));
        add_action('admin_menu', array($this,'top_submenu'));
        add_action('wp_enqueue_scripts', array($this, 'my_scripts'));
        
    }


    public function my_scripts() 
    {
        wp_register_style( 'template_engine_ui_css', plugin_dir_url(__FILE__) . '/css/template_engine_ui.css' );
        wp_enqueue_style( 'template_engine_ui_css');
        wp_enqueue_script( 'template_engine_ui_js'. plugin_dir_url( __FILE__ ) . 'js/template_engine_ui.js');
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
            <div class="flex">    
                <div id="gen_inv_block">
                    <h3>Генератор приглашений</h3>
                    <form name ="generate_inv" action="" method="post">
                        <div class="users-list">
                            <?php $users = get_users();
                            ?>Имя пользователя <input name="user" list="user">
                            <datalist id="user"><?php
                            foreach($users as $user) {   
                                    $userdata = get_userdata($user->id); 
                                    ?>
                                    <option value=
                                    <?php echo "\"";
                                    if (!empty($userdata->first_name) && !empty($userdata->last_name)) {
                                        echo $userdata->first_name.' '.$userdata->last_name; 
                                    }
                                    else {echo $userdata->display_name;}
                                    echo "\"";
                                    ?>></option><?php
                            }
                            ?>
                            </datalist>
                        </div>
                        <div class="conference-list">
                            <?php $conferences = get_categories( [
                                'taxonomy' => 'subject',
                                'hide_empty' => false,
                                'hierarchical' => true,
                                'orderby' => 'parent']);
                            ?>Конференция <input name="conference" list="conference">
                            <datalist id="conference"><?php
                            foreach($conferences as $conference) {
                                    ?>
                                    <option value=
                                    <?php 
                                    echo "\"";
                                    echo $conference->name;
                                    echo "\"";
                                    ?>></option><?php
                            }
                            ?>
                            </datalist>
                        </div>
                        <input type="submit" name="generate_invitation_for_user" value="Сгенерировать приглашение">
                    </form>
                </div>
                <div class="vl"></div>
                <div id="template-uploader">
                    <h3>Загрузите свой шаблон</h3>
                    <form name="template-uploader" action="" method="post" enctype="multipart/form-data">
                        <input type="file" id="template" name="template_file" accept=".doc,.docx">
                        <input type="submit" name="upload_template">
                    </form>
                </div>
            </div>
        </div> 
        <?php
    }
    
    public function generate_invitation_for_user()
    {
        if (isset($_POST['generate_invitation_for_user']) 
        && (isset($_POST['user'])) && isset($_POST['conference']))
        {
            $templateProcessor = new TemplateProcessor(dirname(__FILE__).'/Template.docx');
            $templateProcessor->setValue('name', $_POST['user']);
            $templateProcessor->setValue('conference', $_POST['conference']);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="conf_invitation'.$_POST['user'].'.docx"');
            header('Cache-Control: max-age=0');
            $templateProcessor->saveAs('php://output');
        }
    }
    
    public function upload_template()
    {
        if(isset($_POST['upload_template'])) {
            $target_dir = dirname(__FILE__);
            $target_file = $target_dir.'/'."template.".pathinfo($_FILES["template_file"]['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["template_file"]["tmp_name"], $target_file);
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