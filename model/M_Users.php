<?php


//
// Менеджер пользователей
//
class M_Users 
{	
    private static $instance;	// экземпляр класса
    private $msql;				// драйвер БД
    private $sid;				// идентификатор текущей сессии
    private $uid;				// идентификатор текущего пользователя
    private $onlineMap;			// карта пользователей online
    

    //
    // Получение экземпляра класса
    // результат	- экземпляр класса MSQL
    //
    public static function Instance()
    {
        if (self::$instance == null){
                self::$instance = new M_Users();
        }
        return self::$instance;
    }

    //
    // Конструктор
    //
    private function __construct()
    {
        $this->msql = M_MSQL::Instance();
        $this->sid = null;
        $this->uid = null;
        $this->onlineMap = null;
    }

    //
    // Очистка неиспользуемых сессий
    // 
    public function ClearSessions()
    {
        $min = date('Y-m-d H:i:s', time() - 60 * 20); 			
        $t = "time_last < '%s'";
        $where = sprintf($t, $min);
        $this->msql->Del('sessions', $where);
    }

    public function setNewPassword($id_user, $password){
        $temp = "id_user = '%d'";
        $where = sprintf($temp, $id_user);
        
        return (bool)(($this->msql->Update('users', array('password'=>$password), $where))*1 > 0);
    }
    
    //
    // Авторизация
    // $login 		- логин
    // $password 	- пароль
    // $remember 	- нужно ли запомнить в куках
    // результат	- true или false
    //
    public function Login($login, $password, $remember = true)
    {
            // вытаскиваем пользователя из БД 
            $user = $this->GetByLogin($login);

            if ($user == null)
                    return false;

            $id_user = $user['id_user'];

            // проверяем пароль
            if ($user['password'] != md5($password))
                    return false;

            // запоминаем имя и md5(пароль)
            if ($remember)
            {
                    $expire = time() + 3600 * 24 * 100;
                    setcookie('login', $login, $expire);
                    setcookie('password', md5($password), $expire);
            }		

            // открываем сессию и запоминаем SID
            $this->sid = $this->OpenSession($id_user);

            return true;
    }
        
    public function checkRegistreation($login, $password, $confirm_password, $telephone)
    {

            $result = ['login' => $login, 'password' => null, 'confirm_password' => null,
                'telephone' => $telephone];

              //проверяем login на валидность
            if (!filter_var($login, FILTER_VALIDATE_EMAIL)){
                $result['message']['login'] = 'Это не может быть email';
            }
            else{
                if ($this->checkLogin($login)){
                    $result['message']['login'] = 'Логин занят';
                }
            }
            

            //TODO проверяем пароль на валидность
            if (!preg_match('~[0-9a-zA-Z]{6,15}~', $password)){
                $result['message']['password'] = 'Пароль должен содержать только латинские буквы и цифры от 6 до 15 знаков';
            }
                 
            // проверяем пароли
            if ($password != $confirm_password){
                $result['message']['confirm_password'] = 'Пароли несовпадают';
            }
            

                    
	    //проверяем пароль на валидность
            if (!preg_match('~[0-9]{12,15}~', $telephone)){
                $result['message']['telephone'] = 'проверьте правильность номера (международный формат без "+")'; 
            }
            else{
                //проверяем наличие телефона в базе
                if($this->findTelephone($telephone)){
                    $result['message']['telephone'] = 'Номер уже зарегестрирован';
                } 
            }

            return $result;
    }
    
    public function registreation($login, $password, $telephone, $name, $second)
    {
        $obj = ['user_name' => $name, 'user_second_name' => $second, 'login' => $login, 'password' => md5($password), 'telephone' => $telephone]; 
        $result = $this->msql->Insert('users', $obj);
        M_Lib::addLog($obj);
        return $result;
    }
    
    
    
    //
    // Выход
    //
    public function Logout()
    {
            setcookie('login', '', time() - 1);
            setcookie('password', '', time() - 1);
            unset($_COOKIE['login']);
            unset($_COOKIE['password']);
            unset($_SESSION['sid']);		
            $this->sid = null;
            $this->uid = null;
    }

    //
    // Получение пользователя
    // $id_user		- если не указан, брать текущего
    // результат	- объект пользователя
    //
    public function Get($id_user = null)
    {	
            // Если id_user не указан, берем его по текущей сессии.
            if ($id_user == null)
                    $id_user = $this->GetUid();

            if ($id_user == null)
                    return null;

            // А теперь просто возвращаем пользователя по id_user.
            $t = "SELECT * FROM users WHERE id_user = '%d'";
            $query = sprintf($t, $id_user);
            $result = $this->msql->Select($query);
            return $result[0];	
    }

    //
    // Получает пользователя по логину 
    //
    public function GetByLogin($login)
    {	
            $t = "SELECT * FROM users WHERE login = '%s'";
            $query = sprintf($t, mysql_real_escape_string($login));
            $result = $this->msql->Select($query);
            return $result[0];
    }
    public function checkLogin($login)
    {	
            $t = "SELECT COUNT(*) FROM users WHERE login = '%s'";
            $query = sprintf($t, mysql_real_escape_string($login));
            $result = $this->msql->Select($query);
            return $result[0]['COUNT(*)'] > 0;
    }
    
    public function findTelephone($telephone)
    {	
            $t = "SELECT COUNT(*) FROM users WHERE telephone = '%s'";
            $query = sprintf($t, $telephone);
            $result = $this->msql->Select($query);
            return $result[0]['COUNT(*)'] > 0;
    }
    
    
     public function getUserNameByLogin(){
            $login = $this->Get();
            $t = "SELECT `user_name` FROM users WHERE login = '%s'";
            $query = sprintf($t, mysql_real_escape_string($login['login']));
            $result = $this->msql->Select($query);

            return $result[0]['user_name'];
     }		
    //
    // Проверка наличия привилегии
    // $priv 		- имя привилегии
    // $id_user		- если не указан, значит, для текущего
    // результат	- true или false
    //
    public function Can($priv, $id_user = null){		
        if ($id_user == null) {
            $id_user = $this->GetUid();
        }

        if ($id_user == null) {
            return false;
        }

        $t = "SELECT count(*) as cnt FROM privs2roles p2r
                      LEFT JOIN users u ON u.id_role = p2r.id_role
                      LEFT JOIN privs p ON p.id_priv = p2r.id_priv 
                      WHERE u.id_user = '%d' AND p.priv_name = '%s'";

            $query  = sprintf($t, $id_user, $priv);
            $result = $this->msql->Select($query);

            return ($result[0]['cnt'] > 0);
    }


    public function getUserPrivs($id_user = null){		
        if ($id_user === null) {
            $id_user = $this->GetUid();
        }

        if ($id_user === null) {
            return false;
        }

        $t = "SELECT privs.priv_name FROM privs2roles JOIN users USING(id_role) 
                      JOIN privs USING(id_priv) 
                      WHERE id_user = '%d'";

            $query  = sprintf($t, $id_user);
            $result = $this->msql->Select($query);
            $userPrivs = array();
            foreach ($result as $value){
                $userPrivs[$value['priv_name']] = true;
            }

            return $userPrivs;
    }

    public function getUserGroups($id_user) {

        $temp = "SELECT DISTINCT id_group, group_name FROM transactions LEFT JOIN groups USING (id_group) WHERE id_user = '%d'";
        $query = sprintf($temp, $id_user);

        $result = $this->msql->Select($query);
 
        $groups = array();
        if($result != null){
            foreach ($result as $value){
                if($value['id_group'] != 0 || $value['id_group'] != null){
                    $groups[$value['id_group']] = $value['group_name'];
                }
            }
        }
       
        return $groups;

    }
    
    public function getActualUserGroupName($id_user) {
        $temp = "SELECT group_name FROM groups RIGHT JOIN users USING(id_group)"
                . " WHERE id_user = '%d'";
        $query = sprintf($temp, $id_user);

        $result = $this->msql->Select($query);
        $groupName =  $result[0]['group_name'];
        if ($groupName == '') {
            $groupName = '-';
        }
        return $groupName;

    }
    
    //
    // Проверка активности пользователя
    // $id_user		- идентификатор
    // результат	- true если online
    //
    public function IsOnline($id_user){		
            if ($this->onlineMap == null){	    
                $t = "SELECT DISTINCT id_user FROM sessions";		
                $query  = sprintf($t, $id_user);
                $result = $this->msql->Select($query);

                foreach ($result as $item) {
                $this->onlineMap[$item['id_user']] = true;
                }
            }

            return ($this->onlineMap[$id_user] != null);
    }



            //
    // Получение id текущего пользователя
    // результат	- UID
    //
    public function GetUid() {	
        // Проверка кеша.
        if ($this->uid != null) {
            return $this->uid;
        }

        // Берем по текущей сессии.
        $sid = $this->GetSid();

        if ($sid === null) {
            return null;
        }

        $t = "SELECT id_user FROM sessions WHERE sid = '%s'";
        $query = sprintf($t, mysql_real_escape_string($sid));
        $result = $this->msql->Select($query);

        // Если сессию не нашли - значит пользователь не авторизован.
        if (count($result) === 0) {
            return null;
        }

        // Если нашли - запоминм ее.
        $this->uid = intval($result[0]['id_user']);
        return $this->uid;
    }

//
// Функция возвращает идентификатор текущей сессии
// результат	- SID
//
private function GetSid(){
        // Проверка кеша.
        if ($this->sid != null) {
            return $this->sid;
        }

        // Ищем SID в сессии.
        $sid = $_SESSION['sid'];

        // Если нашли, попробуем обновить time_last в базе. 
        // Заодно и проверим, есть ли сессия там.
        if ($sid != null)
        {
                $session = array();
                $session['time_last'] = date('Y-m-d H:i:s'); 			
                $t = "sid = '%s'";
                $where = sprintf($t, mysql_real_escape_string($sid));
                $affected_rows = $this->msql->Update('sessions', $session, $where);

                if ($affected_rows == 0){
                    $t = "SELECT count(*) FROM sessions WHERE sid = '%s'";		
                    $query = sprintf($t, mysql_real_escape_string($sid));
                    $result = $this->msql->Select($query);

                    if ($result[0]['count(*)'] === 0) {
                        $sid = null;
                    }
                }			
        }		

        // Нет сессии? Ищем логин и md5(пароль) в куках.
        // Т.е. пробуем переподключиться.
        if ($sid == null && isset($_COOKIE['login'])) {
                $user = $this->GetByLogin($_COOKIE['login']);

                if ($user != null && $user['password'] == $_COOKIE['password']) {
                    $sid = $this->OpenSession($user['id_user']);
                }
        }

        // Запоминаем в кеш.
        if ($sid != null)
                $this->sid = $sid;

        // Возвращаем, наконец, SID.
        return $sid;		
    }

    //
    // Открытие новой сессии
    // результат	- SID
    //
    private function OpenSession($id_user) {
        // генерируем SID
        $sid = $this->GenerateStr(10);

        // вставляем SID в БД
        $now = date('Y-m-d H:i:s'); 
        $session = array();
        $session['id_user'] = $id_user;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['time_last'] = $now;				
        $this->msql->Insert('sessions', $session); 

        // регистрируем сессию в PHP сессии
        $_SESSION['sid'] = $sid;				

        // возвращаем SID
        return $sid;	
    }

    //
    // Генерация случайной последовательности
    // $length 		- ее длина
    // результат	- случайная строка
    //
    private function GenerateStr($length = 10) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;  

        while (strlen($code) < $length) 
        $code .= $chars[mt_rand(0, $clen)];  

        return $code;
    }


}
