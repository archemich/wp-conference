<?php

class ConfSettings
{
    public function __construct()
    {
        add_option('notificator');
        add_action('admin_init', array($this, 'save_settings'));
        add_action('admin_menu', array($this,'top_submenu'));
        
    }



    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Conference Settings',
            'Conference Settings',
            'manage_options',
            'conference_settings',
            array($this, 'top_submenu_html')
        );
    }

    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <h1>Conference settings</h1>

            <form method="post" action="">
                <input type="checkbox" name="notificator" id="" <?php if(get_option('notificator')) echo('checked')?>> Включить уведомление
                <input type="submit" name="save_settings" value="Сохранить изменения">
            </form>
            <?php if(isset($_POST['saved'])) {?> <h3>Изменения сохранены</h3> <?php } ?>
                
        </div>
        <?php
    }
    
    public function save_settings()
    {
        if(isset($_POST['save_settings'])){
            if($_POST['notificator'])
                update_option('notificator', true);
            else
                update_option('notificator', false);
            $_POST['saved'] = true;
        }

    }
}