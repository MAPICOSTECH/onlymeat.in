<?php

namespace Helpers;

class Mailer {

    //check login
    public static function getNewUserRegistrationEmail() {
        return "Dear <<USER_NAME>>,
    
<strong>Welcome to <<APP_NAME>>!!</strong>
        
        
";
    }


    public static function sendMail($fromEmailID, $toEmailID, $subject, $mailMessage, $isHTML = true, $ccReply = '', $attachmentFileName = '', $attachmentMimeType = '') {

        $mailMessage = str_replace('<<GEOMETRY_WEBSITE_URL>>', GEOMETRY_BASE_URL, $mailMessage); //if not supplied

        /* Add style information to message before sending the email */
        $mailMessage = '<div align="center" style="border:2px solid #dceadc;padding:40px;background:#FFFFFF;margin:40px;">
			<div align="left" style="color:black;font-family:arial;font-size:10pt;">' .
                nl2br($mailMessage) . '<br /> <br /> </div></div>';

        if (APPLICATION_ENV != 'production') {
            \Helpers\Watchlist::add(\Helpers\Utilities::emailPreview($fromEmailID, $toEmailID, $subject, $mailMessage), 'Email');
            return;
        }

        $mailHeaders = array('From' => $fromEmailID,
            'To' => $toEmailID,
            'CC' => $ccReply,
            'Subject' => $subject,
            'Content-Type' => 'text/html;');

        if (!class_exists('Mail'))
            include_once(GEOMETRY_APP_LOCATION . '/includes/mail/MailS/Mail.php');

        $smtp = Mail::factory('smtp', array('host' => SMTP_HOST,
                    'auth' => false,
                    'username' => '',
                    'password' => ''));

        if ($ccReply != '')
            $toEmailID.=', ' . $ccReply;

        if ($attachmentFileName != '') { //if there is attachment
            if (!class_exists('Mail_mime'))
                include_once(GEOMETRY_APP_LOCATION . '/include/mail/MailM/mime.php');

            $mime = new Mail_mime();
            $mime->setHTMLBody($mailMessage);
            $mime->addAttachment($attachmentFileName, $attachmentMimeType);
            $mailMessage = $mime->get();
            $mailHeaders = $mime->headers($mailHeaders);
        }

        $mail = $smtp->send($toEmailID, $mailHeaders, $mailMessage);

        if (PEAR::isError($mail)) {
            return array('Error' => $mail->getMessage());
        } else {
            return true;
        }
    }

}
