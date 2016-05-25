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

            if(isset($_POST['registration'])){
                $this->content = json_encode($_POST);//$this->registrate($_POST['login'], $_POST['pass'], $_POST['tel'], $_POST['email']);
               
            }
            if(isset($_POST['login'])){
                $this->content = $this->checkLogin($_POST['login']);//$this->registrate($_POST['login'], $_POST['pass'], $_POST['tel'], $_POST['email']);
               
            }
            if(isset($_POST['telephone'])){
                $this->content = $this->checkPhone($_POST['telephone']);//$this->registrate($_POST['login'], $_POST['pass'], $_POST['tel'], $_POST['email']);
               
            }
            
            
        }
        
       
    }

    
    
    private function checkLogin($login){
        $result = $this->mUser->checkPhone($login);
        
        $result = (!$result)?array():$result; 
        return json_encode($result);
    }
    private function checkPhone($tel){
        $result = $this->mUser->checkPhone($tel);
        
        $result = (!$result)?array():$result; 
        return json_encode($result);
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