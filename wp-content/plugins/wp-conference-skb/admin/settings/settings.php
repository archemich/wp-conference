<?php
class ConfSettings
{
    public function __construct()
    {
        add_option('conf_notifier');
        add_action('admin_init', array($this, 'save_settings'));
        add_action('init', array($this, 'send_message'));
        add_action('admin_menu', array($this,'top_submenu'));
    }


    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Настройки',
            'Настройки',
            'manage_options',
            'conference_settings',
            array($this, 'top_submenu_html')
        );
    }


    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <h1>Conference Настройки</h1>

            <form method="post" action="">
                <input type="checkbox" name="notifier" id="" <?php if(get_option('conf_notifier')) echo('checked')?>> Включить уведомление

                <input type="submit" name="save_settings" value="Сохранить изменения">
            </form>
            <form method="post" action="">
                <input type="submit" name="send_message" value="Отправить сообщение">
            </form>
            <?php if(isset($_POST['saved'])) {?> <h3>Изменения сохранены</h3> <?php } ?>
                
        </div>
        <?php
    }
    

    public function save_settings()
    {
        if(isset($_POST['save_settings'])){
            if($_POST['notifier']) update_option('conf_notifier', true);
            else update_option('conf_notifier', false);
            $_POST['saved'] = true;
        }
    }
    public function send_message()
    {
        if(isset($_POST['send_message'])){
            $res = ConfNotifier::send_test();
            if($res) {
                echo 'Message has sent';
            }
            else { echo 'Message has not sent';}
        }
        
    }
}