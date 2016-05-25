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

            if(isset($_POST['registration_test'])){

                $this->content = $this->registrate_test($_POST['login']);
            }
            if(isset($_POST['registration'])){

                $this->content = $this->registrate($_POST['login'], $_POST['password'], 
                        $_POST['telephone'], $_POST['user_name'], $_POST['user_second_name']);
            }
            if(isset($_POST['check'])){

                if(isset($_POST['login'])){
                    $this->content = $this->checkLogin($_POST['login']);

                }
                if(isset($_POST['telephone'])){
                    $this->content = $this->checkPhone($_POST['telephone']);

                }
            }
            
        }
        
       
    }

    
    
    private function checkLogin($login){
        $result = $this->mUser->checkLogin($login);
        return json_encode($result);
    }
    private function checkPhone($tel){
        $result = $this->mUser->checkPhone($tel); 
        return json_encode($result);
    }
    private function registrate($login, $password, $telephone, $name, $second){

        $result = $this->mUser->registreation($login, $password, $telephone, $name, $second);
                
        return json_encode($result);

}
    public function registrate_test() {
        //M_Lib::addLog($_POST['login']);
        $code = md5(date('d-m-Y[H-i]'));
        $sender = new M_Sender($_POST['login'], $code); 
        $sender->start();
        return json_encode($sender->getLog());
    }
    
    
    public function registration() {
        $regestration = $this->mUsers->checkRegistreation($_POST['login'], $_POST['password'],
        $_POST['confirm_password'], $_POST['telephone']);


        if(count($regestration['message']) > 0){
          
            foreach ($regestration as $key => $value) {
                if($key != 'message' && $value != null){
                    
                }
                if($regestration['message'][$key] != null){
                    
                }
            }
        }
        else{
            if($this->mUsers->registreation($regestration['login'], $_POST['password'], 
                    $regestration['telephone'], $_POST['user_name'], $_POST['user_second_name'])){
                $mSender = M_Sender::Instance();

            }
        }


        header("Location: $this->controllerPath");
        die(); 
    }
    
    protected function OnOutput() {
        parent::OnOutput();

        echo $this->content;
        

    }

}