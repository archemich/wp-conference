<?php

class ConfNotifier
{
    public function __construct()
    {
       
        add_action('save_post', array($this, 'notificate_publish'));
        add_action('delete_post', array($this, 'notificate_delete')) ;
       
    }

    
    public function notificate_publish($post_id)
    {
        if (get_post_status($post_id) == 'publish') {
            $post = get_post($post_id);
            $post_type = $post->post_type;
            $post_title = get_the_title($post_id);
            $post_url = get_permalink( $post_id ); 
            switch ($post_type) {
                case 'application': $message = "Ваша заявка была подана"; break;
                case 'report': $message = "Ваш доклад был отправлен"; break;
                case 'expert_opinion': $message = "Ваше экспертное заключение было отправлено"; break;
                case 'identification_act': $message = "Ваш акт идентификационной экспертизы был отправлен"; break;
                case 'consent': $message = "Ваше согласие на обработку персональных данных отправлено"; break;
                case 'arrival_information': $message = "Ваша информация о прибытии была отправлена"; break;
            }
            $subject = $message;
            $message .= "Ссылка: ". $post_url;
            $userdata = get_userdata($post->post_author);
            wp_mail( $userdata->user_email, $subject, $message );
            wp_mail( get_option('admin_email'), $subject, $message );
        }
        
    }
    

    public function notificate_delete($post_id)
    {
        if (get_post_status($post_id) == 'publish') {
            $post = get_post($post_id);
            $post_type = $post->post_type;
            $post_title = get_the_title($post_id);
            $post_url = get_permalink( $post_id ); 
            switch ($post_type) {
                case 'application': $message = "Ваша заявка была отклонена"; break;
                case 'report': $message = "Ваш доклад был отклонён"; break;
                case 'expert_opinion': $message = "Ваше экспертное заключение было отклонено"; break;
                case 'identification_act': $message = "Ваш акт идентификационной экспертизы был отклонён"; break;
                case 'consent': $message = "Ваше согласие на обработку персональных данных отклонено"; break;
                case 'arrival_information': $message = "Ваша информация о прибытии была отклонена"; break;
            }
            $subject = $message;
            $message .= "Ссылка: ". $post_url;
            $userdata = get_userdata($post->post_author);
            wp_mail( $userdata->user_email, $subject, $message );
            wp_mail( get_option('admin_email'), $subject, $message );

        }
    }
}