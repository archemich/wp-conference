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
            $zip = new ZipArchive();
                $filename = "invitations.zip";
                $tempdir = dirname(__FILE__).'\temp\\';
                @mkdir($tempdir);
                if ($zip->open($tempdir.$filename, ZipArchive::CREATE)!==TRUE) {
                    die("Невозможно открыть <$tempdir.$filename>\n");
                }
            foreach ($userids as $userid) {
                $userdata = get_userdata($userid);
                $conference = 'РиМ-2021';
                $template = ConfTemplateEngine::generate_invitation($userdata->first_name.' '.$userdata->last_name, $conference);
                $template->saveAs($tempdir.$userid.'_inv.docx');
                $zip->addFile($tempdir.$userid.'_inv.docx', $userid.'_inv.docx');
            }
            $zip->close();
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment;filename="conf_invitations.zip"');
            header('Cache-Control: max-age=0');
            readfile($tempdir.$filename);
            removeDir($tempdir);
        }
    }
}