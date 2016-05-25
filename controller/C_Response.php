<?php
class C_Response extends C_Controller{
    private $content;
    private $mUser;
    
    function __construct() {
        parent::__construct();
        $this->mUser = M_Users::Instance();

    }
   
    protected function OnInput() {
        parent::OnInput();
        if($this->IsPost()){
            if(isset($_POST['reg'])){
                $this->content = $this->registrate($_POST['login'], $_POST['pass'], $_POST['tel'], $_POST['email']);
               
            }
            
            
        }
        
       
    }
    

    private function registrate($login, $pass, $tel){

         //$result[] = $this->mUser->registrate($login, $pass, $tel);

//        if(count($result) > 0){
//            
//            return json_encode($result);
//        }
//        else {
            return json_encode(array());
//        }
}
    

    
    protected function OnOutput() {
        parent::OnOutput();

        echo $this->content;
        
    }

}