<?php


 //   $sender = new Sender(); 
//    $sender->start();
//    echo $sender->getLog();
   
class M_Sender {

    private $website;
    private $send_to;
    private $from;
    
    private $full_path;
    private $file;
    private $delete_backup;    
    
    private $logPage;

            
    public function __construct($send_to)
    {

        $this->logPage = '';
        /***************************************************
                E-mail settings
        ****************************************************/
        $this->website = 'f-i.ho.ua';       // Your site's domain (without www. part)
        $this->send_to = $send_to;  // backup file will be sent to?
        $this->from = 'f-i@' . $this->website;    // some hosting providers won’t let you send backups from invalid e-mail address



        /***************************************************
            Misc options
        ****************************************************/



        // Full path to folder where you are running the script, usually "/home/username/public_html"
        // (mt) servers have something like "/nfs/c01/h01/mnt/12345/domains/yourdomain.mobi/html/tools/backup2mail"

        $this->file = 'f-i'; 

        $this->delete_backup	= true;							
            // delete gziped database from server after sending?
						
        // send follow-up report?
            // - true = send log file to an e-mail after each backup transfer
            // - false = don't send log file, just leave it on the server   
    }
/*
 * 
 *
 */
    
private function date_stamp() {
	$backup_date = date('d-m-Y[H-i]');
	$this->logPage .=  'Database backup date: ' . $backup_date . ' ' . "\n";
	return $backup_date;
}


    private function send_mail() {
        $html = '<html><head></head><body><DIV>Активация аккаунта MIND_BODY<DIV></body></html>';
        
        
        
        $EOL = "\r\n";

        $message = "База ннада?";
        $subject = 'Активация Mind-Body';

        $boundary = '_1_' . md5(date('r', time())) . '_2_'; // рандомное число
        $headers = "From: " . $this->from . $EOL; // см. наиболее часто используемые заголовки
        $headers .= "Reply-To: " . $this->from . $EOL;
        $headers .= "MIME-Version: 1.0" . $EOL;
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";

        $body = "--$boundary" . $EOL; 

        $body .= "Content-Type: text/plain; charset=\"utf-8\"" . $EOL;
        $body .= "Content-Transfer-Encoding: 7bit" . $EOL . $EOL;
        $body .= $message . $EOL; 

        $body .= "--$boundary" . $EOL;

        $body .= "Content-Type: text/html; charset=\"utf-8\"" . $EOL;
        $body .= "Content-Transfer-Encoding: base64" . $EOL . $EOL;
        $body .= chunk_split(base64_encode($html)) . $EOL . $EOL;


        $body .= "--$boundary--";

        $this->logPage .=  $subject . '';
        if (mail($this->send_to, $subject, $body, $headers)) {
                $sent = 'Yes';		
        }
        else {
            $sent = 'NO';
        }

        $this->logPage .=  'Sent? ' . $sent . $EOL;    
    }




public function start() {
    error_reporting(E_ALL);
    $this->send_mail();
}
public function getLog() {
    return $this->logPage;
}



}
