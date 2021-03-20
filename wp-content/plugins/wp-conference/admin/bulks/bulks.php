<?php
class ConfBulks
{
    public function __construct()
    {
        add_filter('bulk_actions-users', array($this,'register_custom_bulks'));
        add_filter('handle_bulk_actions-users', array($this, 'generate_invitation'), 10, 3);
    }


    public function register_custom_bulks($actions)
    {
        $actions['generate_invitation'] = 'Сгенерировать приглашение';
        return $actions;
    }

    public function generate_invitation($redirect, $doaction, $userids)
    {
        $redirect = remove_query_arg('conf_invitation_generated', $redirect );

        if ($doaction == 'generate_invitation') {
            @mkdir(dirname(__FILE__) . '/temp');
            $zip = new ZipArchive();
            $filepath = dirname(__FILE__)."/temp/invitations.zip";
            $zip->open($filepath, ZipArchive::CREATE);
            foreach ($userids as $userid) {
                $userdata = get_userdata($userid);
                $template = ConfTemplateEngine::generate_invitation($userdata->first_name);
                $template->saveAs(dirname(__FILE__).'/temp/conf_inv'.$userid.$userdata->first_name.date('d-m-y').'.docx');
                $zip->addFile(dirname(__FILE__).'/temp/conf_inv'.$userid.$userdata->first_name.date('d-m-y').'.docx', 'conf_inv'.$userid.$userdata->first_name.date('d-m-y').'.docx');
            }
            $zip->close();
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=invitations.zip");
            header("Content-Length: " . $filepath);

            readfile($filepath);
            removeDir(dirname(__FILE__).'/temp');
        }
    }
}