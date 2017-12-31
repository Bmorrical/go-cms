<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  This is a core go-cms file.  Do not edit if you plan to
     *  ever update your go-cms version.  Changes would be lost.
     */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  LICENSE INFORMATION AND DOCUMENTATION: https://github.com/swiftmailer/swiftmailer
     */


class GO_Postal {

    public $ci;
    public $data;
    public $admin_emails;

    /**
     * $data should contains the following $key => $value
     * 
     * REQUIRED Params
     *
     * @param SendTo  => email recipients
     * @param Subject => email subject
     * @param Message => email message
     *
     * OPTIONAL Params
     *
     * @param FromName => From Name, useful in contact forms | String
     * @param FromEmail => From Email, useful in contact forms | String
     * @param Attachments => Any attachements for the message | Array of attachment paths
     *      $data['Attachments'] = array(
     *          $_SERVER['DOCUMENT_ROOT'] . 'tmp/some_file.pdf',
     *          $_SERVER['DOCUMENT_ROOT'] . 'tmp/some__other_file.pdf'
     *      );
     *
     */

    public function __construct($data){
        require_once(APPPATH.'third_party/swiftmailer/lib/swift_required.php');
        $this->ci = get_instance();
        $this->data = $data;
        $this->admin_emails = $this->ci->config->item('go_enable_go_postal_admin_emails');

        $this->init_postman();
    }

    public function init_postman() {

        if($this->ci->config->item('go_environment') === 'PRODUCTION') {
            $transport = Swift_SmtpTransport::newInstance(
                $this->ci->config->item('go_smtp_production_host'), 
                $this->ci->config->item('go_smtp_production_port'), 
                $this->ci->config->item('go_smtp_production_crpt')
            )->setUsername($this->ci->config->item('go_company_email'))
             ->setPassword($this->ci->config->item('go_company_email_password'));
        } 
        elseif ($this->ci->config->item('go_environment') === 'STAGING') {
            $transport = Swift_SmtpTransport::newInstance(
                $this->ci->config->item('go_smtp_staging_host'), 
                $this->ci->config->item('go_smtp_staging_port'), 
                $this->ci->config->item('go_smtp_staging_crpt')
            )->setUsername($this->ci->config->item('go_company_email'))
             ->setPassword($this->ci->config->item('go_company_email_password'));
        }         
        elseif ($this->ci->config->item('go_environment') === 'DEVELOPMENT') {
            $transport = Swift_SmtpTransport::newInstance(
                $this->ci->config->item('go_smtp_development_host'), 
                $this->ci->config->item('go_smtp_development_port'), 
                $this->ci->config->item('go_smtp_development_crpt')
            )->setUsername($this->ci->config->item('go_company_email'))
             ->setPassword($this->ci->config->item('go_company_email_password'));
        } 
        else return;
        
        $sendTo = preg_replace('/\s+/', '', $this->data["SendTo"]); // remove all whitespace
        $sendTo = strtolower($sendTo);
        $sendTo = explode(",", $sendTo);

        foreach ($sendTo as $email) {  // loop recipients

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {        
                $mailer = Swift_Mailer::newInstance($transport);

                if(empty($this->data["FromEmail"])) { // no FromName in Params, good for system emails

                    $message = Swift_Message::newInstance($this->data["Subject"])
                        ->setFrom(array($this->ci->config->item('go_company_email') => $this->ci->config->item('go_company_name')))
                        ->setTo($email)
                        ->setBody($this->template(), 'text/html'); // n12br is required, otherwise line breaks from JavaScript don't show

                    if(!empty($this->data['Attachments'])) {
                        foreach($this->data['Attachments'] as $attachment) {  // loop attachments
                            $message->attach(Swift_Attachment::fromPath($attachment));
                        }                           
                    } 

                    $mailer->send($message);  

                } else { // good for recipient emails such as contact forms
                    $message = Swift_Message::newInstance($this->data["Subject"])
                        ->setFrom(array($this->data["FromEmail"] => (!empty($this->data["FromName"]) ? $this->data["FromName"] : "")))
                        ->setTo($email)
                        ->setBody($this->template(), 'text/html'); // n12br is required, otherwise line breaks from JavaScript don't show

                    if(!empty($this->data['Attachments'])) {
                        foreach($this->data['Attachments'] as $attachment) {  // loop attachments
                            $message->attach(Swift_Attachment::fromPath($attachment));
                        }                           
                    } 

                    $mailer->send($message);        
                }    
            }
        }

        if(true == $this->admin_emails) {

            $email = $this->ci->config->item('go_admin_email');

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {   
                 
                $mailer = Swift_Mailer::newInstance($transport);
                $message = Swift_Message::newInstance($this->data["Subject"])
                    ->setFrom(array($this->ci->config->item('go_company_email') => $this->ci->config->item('go_company_name')))
                    ->setTo($email)
                    ->setBody($this->template(), 'text/html'); // n12br is required, otherwise line breaks from JavaScript don't show

                    if(!empty($this->data['Attachments'])) {
                        foreach($this->data['Attachments'] as $attachment) {  // loop attachments
                            $message->attach(Swift_Attachment::fromPath($attachment));
                        }                           
                    } 

                $mailer->send($message);            
            }
        }
        return 1;
    }

    public function template() {
       $return = ' 
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <head>
               <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
               <title>'.$this->ci->config->item('go_company_name').'</title>
               <style type="text/css">
                    a {color: #4A72AF;}
                    body {background-color: #e4e4e4;}
                    body, #header h1, #header h2, p {margin: 0; padding: 0;}
                    #main {border: 1px solid #cfcece;}
                    img {display: block; margin: 0 auto;}
                    #top-message p, #bottom-message p{color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
                    #header h1 {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
                    #header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
                    #header p {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 12px;  }
                    h1 {margin: 0 0 -.5em 0;}
                    h2, h3, h4, h5, h6 {margin: 10px 0;}
                    h3 {font-size: 20px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
                    h4 {font-size: 24px; color: #4A72AF !important; font-family: Arial, Helvetica, sans-serif; }
                    h5 {font-size: 18px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
                    p, ul, li, ul li  {font-size: 15px; color: #444444 !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
                    .normaltext{font-size: 13px;}
                    .boldedtext{font-weight: bold;}
                    .pad10 {margin: 10px 0; color: #fff!important;}
                </style>
            </head>
            <body>
                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4">
                    <tr>
                        <td>
                            <table id="top-message" cellpadding="20" cellspacing="0" width="600" align="center">
                                <tr>
                                    <td align="center">
                                    </td>
                                </tr>
                            </table><!-- top message -->
                            <table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
                                <tr>
                                    <td>
                                        <table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="ffffff">
                                            <tr>
                                                <td width="570" align="center" bgcolor="ffffff"><img src="'.$this->ci->config->item('go_logo_email_path').'"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>    
                            <p>&nbsp;</p>           
                            <table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
                                <tr>
                                    <td align="center">
                                        <h3>'.$this->data["Subject"].'</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="560">
                                        ' . nl2br($this->data['Message']) . '
                                    </td>
                                </tr>
                            </table>
                            <br><br><br>
                        </td>
                    </tr>
                </table><!-- main -->
                <table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
                    <tr>
                        <td align="center">
                            <p>&nbsp;</p>
                        </td>
                    </tr>
                </table><!-- top message -->
            </body>
            </html>
        ';

        return $return;    
    }

}