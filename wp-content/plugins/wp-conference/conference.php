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

    public $confMail = null;
    public $confPostTypes = null;
    public $confSettings = null;
    public $confStats = null;

    public function __construct()
    {
      
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
        require_once(CONFERENCE__PLUGIN_DIR . 'settings/settings.php');
        $this->$confSettings = new ConfSettings();

        
        require_once(CONFERENCE__PLUGIN_DIR . 'post_types/post_types.php');
        $this->$confPostTypes = new ConfPostTypes();


        require_once(CONFERENCE__PLUGIN_DIR . 'stats/stats.php');
        $this->$confStats = new ConfStats();

    
        if(get_option('conf_notifier')) {
            require_once(CONFERENCE__PLUGIN_DIR . 'notifier/notifier.php');
            $this->$confMail = new ConfNotifier();
        }

        require_once(CONFERENCE__PLUGIN_DIR . 'helper/helper.php');
        $this->$confHelper = new ConfHelper();
    }
}


function removeDir($target)
    {
        $directory = new RecursiveDirectoryIterator($target,  FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (is_dir($file)) {
                rmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($target);
    }

$plugin = new ConfPlugin();