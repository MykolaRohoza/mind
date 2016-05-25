<?php

class M_Sender{
    private static $instance; 	// ссылка на экземпляр класса
    private  	$website = 'mind-body.ho.ua';		    // Your site's domain (without www. part)
    private	$send_to = 'iyaki@rambler.ru';		        // backup file will be sent to?
    private     $from;	// some hosting providers won’t let you send backups from invalid 
     
     
     
    public static function Instance() {
    if (self::$instance == null) {
        self::$instance = new M_Cases_Example();
    }

    return self::$instance;
    }

    //
    // Конструктор
    //
    private function __construct()
    {
        $this->from = 'karevar@' . $this->website;
    }
    
    
    public function send_attachment_mail($send_to) {
	//$send_to, $from, $website, $delete_backup;

	$sent       = 'No';

        $boundary   = md5(uniqid(time()));
        $mailer     = 'Отправлено с сайта MIND-BODY';
        $subject  = 'Активация аккаунта MIND-BODY';

	$headers  = 'From: ' . $from . "\n";
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: multipart/mixed; boundary="' . $boundary . '";' . "\n";
	$headers .= 'This is a multi-part message in MIME format. ';
	$headers .= 'If you are reading this, then your e-mail client probably doesn\'t support MIME.' . "\n";
	$headers .= $mailer . "\n";
	$headers .= '--' . $boundary . "\n";

	$headers .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\n";
	$headers .= 'Content-Transfer-Encoding: 7bit' . "\n";
	$headers .= $body . "\n";


	$headers .= 'Content-Transfer-Encoding: base64' . "\n\n";

	$headers .= '--' . $boundary . '--' . "\n";

	if (mail($send_to, $subject, $body, $headers)) {
		$sent = 'Yes';		
	} 
	
	return $sent;
}
    
        public function send_attachment_phone($send_to) {
	//$send_to, $from, $website, $delete_backup;

	$sent       = 'No';

        $subject  = 'Активация аккаунта MIND-BODY 5908';



	if (mail($send_to, $subject, $body, $headers)) {
		$sent = 'Yes';		
	} 
	
	return $sent;
}
    
}
