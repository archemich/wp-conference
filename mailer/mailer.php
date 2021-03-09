<?php
class ConfMail 
{
    public function __construct()
    {
        add_action('admin_menu', array($this,'top_submenu'));
    }

    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Conference Mailer',
            'Conference Mailer',
            'manage_options',
            'conference_mailer',
            array($this, 'top_submenu_html')
        );
    }

    public function top_submenu_html()
    {
        echo("");
    
    }
}