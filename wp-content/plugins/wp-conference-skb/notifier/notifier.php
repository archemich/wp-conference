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
        if (get_post_status($post_id) == 'pending') {
            $post = get_post($post_id);
            $post_type = $post->post_type;
            $post_title = get_the_title($post_id);
            $post_url = get_permalink( $post_id ); 
            switch ($post_type) {
                case 'application': $message = "Ваша заявка была подана";
                case 'report': $message = "Ваш доклад был отправлен";
                case 'expert_opinion': $message = "Ваше экспертное заключение было отправлено";
                case 'identification_act': $message = "Ваш акт идентификационной экспертизы был отправлен";
                case 'consent': $message = "Ваше согласие на обработку персональных данных отправлено";
                case 'arrival_information': $message = "Ваша информация о прибытии была отправлена";
            }
            $subject = $message;
            $message .= "Ссылка: ". $post_url;
            $userdata = get_userdata($post->post_author);
            wp_mail( $userdata->user_email, $subject, $message );
        }
        
    }
    

    public function notificate_delete($post_id)
    {
        if (get_post_status($post_id) == 'pending') {
            $post = get_post($post_id);
            $post_type = $post->post_type;
            $post_title = get_the_title($post_id);
            $post_url = get_permalink( $post_id ); 
            switch ($post_type) {
                case 'application': $message = "Ваша заявка была отклонена";
                case 'report': $message = "Ваш доклад был отклонён";
                case 'expert_opinion': $message = "Ваше экспертное заключение было отклонено";
                case 'identification_act': $message = "Ваш акт идентификационной экспертизы был отклонён";
                case 'consent': $message = "Ваше согласие на обработку персональных данных отклонено";
                case 'arrival_information': $message = "Ваша информация о прибытии была отклонена";
            }
            $subject = $message;
            $message .= "Ссылка: ". $post_url;
            $userdata = get_userdata($post->post_author);
            wp_mail( $userdata->user_email, $subject, $message );
        }
    }
}