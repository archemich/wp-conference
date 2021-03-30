<?php
class ConfAdmin
{
    public $confHelper = null;
    public $confSettings = null;
    public $confStats = null;
    public $confTemplateEngine = null;
    public $confBulks = null;


    public function __construct()
    {
        add_action('admin_menu', array($this, 'top_menu'));
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
        global $wpdb;
        $users_count = $wpdb->get_results('SELECT COUNT(*) as amount FROM wp_users JOIN wp_usermeta on (wp_usermeta.meta_key = "wp_user_level" and wp_usermeta.user_id = wp_users.id) WHERE wp_usermeta.meta_value <=7;')[0]->amount;
        $application_count = $wpdb->get_results('SELECT COUNT(*) as amount FROM wp_posts where post_type = "application";')[0]->amount;
        $report_count = $wpdb->get_results('SELECT COUNT(*) as amount FROM wp_posts where post_type = "report";')[0]->amount;
        ?>
        <div class="wrap">
        <h2>Conference</h2>
        <h3>Пользователей зарегистрировано: <?=$users_count?></h3>
        <h3>Заявок подано: <?=$application_count?></h3>
        <h3>Докладов подано: <?=$report_count?></h3>
        </div>
        <?php
    }


    private function init_subplugins()
    {
        require_once(CONFERENCE__PLUGIN_DIR . 'admin/bulks/bulks.php');
        $this->confBulks = new ConfBulks();

        require_once(CONFERENCE__PLUGIN_DIR . 'admin/stats/stats.php');
        $this->confStats = new ConfStats();

        require_once(CONFERENCE__PLUGIN_DIR . 'admin/template_engine/template_engine.php');
        $this->confTemplateEngine = new ConfTemplateEngine();

        require_once(CONFERENCE__PLUGIN_DIR . 'admin/settings/settings.php');
        $this->confSettings = new ConfSettings();

        require_once(CONFERENCE__PLUGIN_DIR . 'admin/helper/helper.php');
        $this->confHelper = new ConfHelper();
    }
}