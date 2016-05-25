<?php
//
// Конттроллер страницы-примера.
//
class C_Activate extends C_Base {
    
    // переменные для создания наполнения 


    protected $contVars;
    private $mUsers;




    //
    // Конструктор.
    //
    function __construct($code) 
    {
    	parent::__construct();
       $this->mUsers = M_Users::Instance();
//        $this->needLogin = false;
//    	$this->needTimeTest = true;
//    	$this->needStocks = true;
        $this->controllerPath = "/activate";
        $this->contVars = array('code' =>$code);
    }


    
    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput(){
        
        parent::OnInput();

        
        // Обработка отправки формы.
        if ($this->IsPost()) {
            if(isset($_POST['code'])){
                $this->contVars['isActive'] = $this->activate($_POST['code']);
                
                header("Location: $this->controllerPath/{$_POST['code']}");
                die();
            }


        }
        else
        {
            if(isset($this->contVars['code'])){	
                $this->contVars['isActive'] = $this->activate($this->contVars['code']);
            }
        }
                
        
    }
    private function activate($code){
        $result = $this->mUsers->activate($code);
        return (bool)$result;
    }

    //
    // Виртуальный генератор HTML.
    //
    public function OnOutput() {   	

        //Генерация вложенных шаблонов

        $this->content['container_main'] = $this->View('V/view_activate.php', $this->contVars);
        parent::OnOutput();
        
        
            
    }
            
            
          
 }
