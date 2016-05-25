<?php
//
// Конттроллер страницы-примера.
//
class C_Activate extends C_Base {
    
    // переменные для создания наполнения 


    protected $contVars;




    //
    // Конструктор.
    //
    function __construct($code) 
    {
    	parent::__construct();
//        $this->mUsers = M_Users::Instance();
//        $this->needLogin = false;
//    	$this->needTimeTest = true;
//    	$this->needStocks = true;
//        $this->controllerPath = "/.";
        $this->contVars = $code;
    }


    
    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput(){
        
        parent::OnInput();

        
        // Обработка отправки формы.
        if ($this->IsPost()) {

            header("Location: /");
            die();

        }
        else
        {	
            if ($this->user == null && $this->needLogin)
            {       	
                header("Location: /");
                die();
            }
            // сбор разрешений и организация массивов
//            $this->content['nav']['main'] = 'class="active"';

            
            
           
        }
                
        
    }
    //
    // Виртуальный генератор HTML.
    //
    public function OnOutput() {   	

        //Генерация вложенных шаблонов

        $this->content['container_main'] = $this->View('V/view_main.php', $vars);
        parent::OnOutput();
        
        
            
    }
            
            
          
 }
