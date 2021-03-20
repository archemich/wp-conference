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
            foreach ($userids as $userid) {
                $userdata = get_userdata($userid);
                $template = ConfTemplateEngine::generate_invitation($userdata->first_name);
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingm');
                header('Content-Disposition: attachment;filename="conf_inv'.$userdata->first_name.date('d-m-y').'.docx"');
                header('Cache-Control: max-age=0');
                $template->saveAs('php://output');
            }
        }
    }
}