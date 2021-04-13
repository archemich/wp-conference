<?php

 /**
 * Plugin Name: Conference
 * Description: Плагин для проведения конференций НИИ МВС ЮФУ
 * Requires at least: 5.6
 * Requires PHP:      7.3.21
 * Author URI:  http://kit.sfedu.ru/
 * Author:      СКБ "КИТ"
 * Version:     1.0
 */


define( 'CONFERENCE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CONFERENCE_VERSION', '4.1.8' );
define( 'CONFERENCE__MINIMUM_WP_VERSION', '4.0' );
define( 'CONFERENCE__PLUGIN_URL', plugin_dir_url(__FILE__) );


class ConfPlugin
{
    public $confNotifier = null;
    public $confPostTypes = null;
    public $confAdmin = null;

    public function __construct()
    {
        $this->include_libs();
        $this->init_subplugins();
    }
    

    private function include_libs()
    {
        require CONFERENCE__PLUGIN_DIR . 'vendor/autoload.php';
    }

    // СonfAdmin must be created after ConfPostTypes
    private function init_subplugins()
    {
        require_once(CONFERENCE__PLUGIN_DIR . 'post_types/post_types.php');
        $this->confPostTypes = new ConfPostTypes();
    
        if (get_option('conf_notifier')) {
            require_once(CONFERENCE__PLUGIN_DIR . 'notifier/notifier.php');
            $this->confNotifier = new ConfNotifier();
        }

        require_once(CONFERENCE__PLUGIN_DIR . 'admin/admin.php');
        $this->confAdmin = new ConfAdmin();
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