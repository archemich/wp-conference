<?php
class ConfNotifier
{
    public function __construct()
    {
        add_action('save_post', array($this, 'notificate_publish'));
        add_action('delete_post', array($this, 'notificate_delete'));
    }

    
    public function notificate_publish($post_id)
    {
        $post_title = get_the_title($post_id);
        $post_url = get_permalink( $post_id ); 
        if(get_post_status($post_id) == 'pending')
        {
            $subject = 'Запись была опубликована';
            $message = "Ваша запись была опубликована:\n\n";
            $message .= $post_title . ": " . $post_url;
            wp_mail( get_option('admin_email'), $subject, $message );
        }
    }
    

    public function notificate_delete($post_id)
    {
        $post_title = get_the_title($post_id);
        $post_url = get_permalink( $post_id );
        $subject = 'Запись была отклонена';
        $message = "Ваша запись была отклонена:\n\n";
        $message .= $post_title . ": " . $post_url;
        wp_mail( get_option('admin_email'), $subject, $message );
    }
}