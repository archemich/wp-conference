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
                            ?>Имя пользователя <input name="username" list="user">
                            <datalist id="user"><?php
                            foreach($users as $user) {   
                                    $userdata = get_userdata($user->id); 
                                    $usermeta = get_user_meta($user->id);
                                    ?>
                                    <option value=
                                    <?php echo "\"";
                                    if (!empty($userdata->first_name) && !empty($userdata->last_name)) {
                                        echo $userdata->first_name.' '. (isset($usermeta['otchestvo'][0]) ? ($usermeta['otchestvo'][0]). ' ' : '') .$userdata->last_name; 
                                    }
                                    else {echo $userdata->display_name;}
                                    echo "\"";
                                    ?>></option><?php
                            }
                            ?>
                            </datalist>
                        </div>
                        <div class="initials">
                        Инициалы <input type="text" name="initials" id="">
                        </div>
                        <div class="conference-list">
                            <?php $conferences = get_categories( [
                                'taxonomy' => 'subject',
                                'hide_empty' => false,
                                'parent' => 0,
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

                        <div class="subject-list">
                            <?php $subjects = get_categories( [
                                'taxonomy' => 'subject',
                                'hide_empty' => false,
                                'child_of' => 0,
                                'hierarchical' => true,
                                'orderby' => 'parent']);
                            ?>Направления <input name="subject" list="subjects">
                            <datalist id="subjects"><?php
                            foreach($subjects as $subject) {
                                    ?>
                                    <option value=
                                    <?php 
                                    echo "\"";
                                    echo $subject->name;
                                    echo "\"";
                                    ?>></option><?php
                            }
                            ?>
                            </datalist>
                        </div>
                        <div class="report_name">
                            Название доклада <input type="text" name="report_name" id="">
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
        if (isset($_POST['generate_invitation_for_user']))
        {
            $templateProcessor = new TemplateProcessor(dirname(__FILE__).'/Template.docx');
            if(isset($_POST['username'])) $templateProcessor->setValue('name', $_POST['username']);
            if(isset($_POST['initials'])) $templateProcessor->setValue('initials', $_POST['initials']);
            if(isset($_POST['conference'])) $templateProcessor->setValue('conference', $_POST['conference']);
            if(isset($_POST['subject'])) $templateProcessor->setValue('subject', $_POST['subject']);
            if(isset($_POST['report_name'])) $templateProcessor->setValue('report_name', $_POST['report_name']);

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


    public static function generate_invitation($name = null, $initials = null, $conference = null, $subject = null, $report_name = null)
    {
            $templateProcessor = new TemplateProcessor(dirname(__FILE__).'/Template.docx');
            isset($name) ?? $templateProcessor->setValue('name', $name);
            isset($initials) ?? $templateProcessor->setValue('initials', $initials);
            isset($conference) ?? $templateProcessor->setValue('conference', $conference);
            isset($report_name) ?? $templateProcessor->setValue('report_name', $report_name);

            return $templateProcessor;
    }
}