<?php
/**
 * Plugin Name: Conference
 */


define( 'CONFERENCE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CONFERENCE_VERSION', '4.1.8' );
define( 'CONFERENCE__MINIMUM_WP_VERSION', '4.0' );
define( 'CONFERENCE__PLUGIN_URL', plugin_dir_url(__FILE__) );


class ConfPlugin
{

    public function __construct()
    {
        bloginfo('htps://www.youtube.com/');
        add_action('admin_menu', array($this, 'top_menu'));
        $this->include_libs();
        $this->init_subplugins();
        
    }

    public function top_menu() 
    {
        add_menu_page(
            'Conference',
            'Conference',
            'manage_options',
            'conference_top',
            array($this, 'main_page_html')
        );
    }

    public function main_page_html() 
    {
        ?>
        <div class="wrap"><h1>There will be smthing like</h1></div>
        <?php

    }  

    
    private function include_libs()
    {
        require CONFERENCE__PLUGIN_DIR . 'vendor/autoload.php';
    }


    private function init_subplugins()
    {
        if(get_option('notifier')) {
            require_once(CONFERENCE__PLUGIN_DIR . 'notifier/notifier.php');
            $this->$confMail = new ConfNotifier();
        }

        require_once(CONFERENCE__PLUGIN_DIR . 'stats/stats.php');
        $this->$confStats = new ConfStats();

        require_once(CONFERENCE__PLUGIN_DIR . 'settings/settings.php');
        $this->$confSettings = new ConfSettings();
    }
    
}

$plugin = new ConfPlugin();