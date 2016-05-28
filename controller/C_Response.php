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
            if(isset($_POST['add_new_ex'])){
                $this->content = json_encode(array(1 => 'упр1', 2 => 'упр2' , 3 => 'упр3' , 4 => $_POST['add_new_ex']));
                $this->content = $this->getExercises($_POST['add_new_ex']);
            }

            
        }
        
       
    }

    
    
    private function getExercises($new_ex){
        $mExe = M_Exercises::Instance();
        $mExe->saveExercises($new_ex);
        $result = $mExe->getExercises();
        return json_encode($result);
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

        $result = $this->mUser->registration($login, $password, $telephone, $name, $second);
                
        return json_encode($result);

}
    public function registrate_test() {
        $code = md5(date('d-m-Y[H-i]'));
        $sender = new M_Sender($_POST['login'], $code); 
        $sender->start();
        return json_encode($sender->getLog());
    }
    
    
    
    protected function OnOutput() {
        parent::OnOutput();

        echo $this->content;
        

    }

}