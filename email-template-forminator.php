<?php 
/**
 * Plugin Name: Email Template for Forminator
 */

new EmailTemplate4Forminator;
class EmailTemplate4Forminator{

    public $msg;
    public $template;

    public function __construct(){
        add_filter('forminator_custom_form_mail_user_message', array( $this, 'user_msg'), 10, 5);
        add_filter('forminator_custom_form_mail_admin_message', array( $this, 'admin_msg'), 10, 5);
        add_filter('forminator_email_message', array( $this, 'email4frm_clean'));
    }

    public function admin_msg( $message, $custom_form, $data, $entry, $mail ){
        if ( $custom_form->id === 2523 ) {
            $this->template = plugin_dir_path(__FILE__) .'/template.php';
        } else {
            $this->template = plugin_dir_path(__FILE__) .'/user-template.php';
        }
        $this->msg = $message;
        return $message;
    }

    public function user_msg( $message, $custom_form, $data, $entry, $mail ){
        $this->template = plugin_dir_path(__FILE__) .'/user-template.php';
        $this->msg = $message;
        return $message;
    }

    public function email4frm_clean( $body ){
        $my_template = file_get_contents( $this->template );
        $body = str_replace( '{msg}', $this->msg, $my_template);
        return $body;
    }

}