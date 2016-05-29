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
                $mExe = M_Exercises::Instance();
                $this->content['message'] = $this->save($_POST['id_exercise'], $_POST['add_new_ex'], $mExe);
                $this->content = $this->getExercises($mExe);
            }
            if(isset($_POST['del_ex'])){
                $mExe = M_Exercises::Instance();
                $this->content['message'] = $this->deleteExercises($_POST['id_exercise'], $mExe);
                $this->content = $this->getExercises($mExe);
            }
            
        }
        
       
    }

    
    
    private function deleteExercises($id_ex, M_Exercises $mExe){
        $result = $mExe->deleteExercises($id_ex);
        return $result;
    }
    private function getExercises(M_Exercises $mExe){
        $result = $mExe->getExercises();
        return $result;
    }
    private function save($id_ex, $new_ex, M_Exercises $mExe){
       
        $mExe->saveExercises($id_ex, $new_ex);
    }
    private function checkLogin($login){
        $result = $this->mUser->checkLogin($login);
        return $result;
    }
    private function checkPhone($tel){
        $result = $this->mUser->checkPhone($tel); 
        return $result;
    }
    private function registrate($login, $password, $telephone, $name, $second){

        $result = $this->mUser->registration($login, $password, $telephone, $name, $second);
                
        return $result;

}
    public function registrate_test() {
        $code = md5(date('d-m-Y[H-i]'));
        $sender = new M_Sender($_POST['login'], $code); 
        $sender->start();
        return $sender->getLog();
    }
    
    
    
    protected function OnOutput() {
        parent::OnOutput();
        
        
        if(true){
            $json = json_encode($this->content);
        }
        echo $json;
        

    }

}