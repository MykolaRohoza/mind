<?php
//
// Помощник работы с БД
//
class M_MSQL
{
    private static $instance; 	// ссылка на экземпляр класса
    
    //
	// Получение единственного экземпляра (одиночка)
	//
    
    
	public static function Instance(){
            if (self::$instance == null) {
                self::$instance = new M_MSQL();
            }

            return self::$instance;
	}
	


    /**
     * Создание объекта запрещено
     * Клонирование запрещено
     * сериализация и десеариализация запрещены
     */
    private function __construct(){}
    private function __clone(){}
    private function __sleep(){}
    private function __wakeup(){}

    
    	/** Выборка строк
         * @param String $query  полный текст SQL запроса
         * результат	- массив выбранных объектов
	*/
    public function Select($query){
        $result = mysql_query($query);
        if (!$result) {
            die(mysql_error());
        }

        $n = mysql_num_rows($result);

		$arr = array();
	
            for($i = 0; $i < $n; $i++)
            {
                $row = mysql_fetch_assoc($result);		
                $arr[] = $row;
            }

	return $arr;				
    }
	
	/**
	* Вставка строки
	* @param string $table
         *  имя таблицы
        * @param string[][] $object
         * ассоциативный массив с парами вида "имя столбца - значение"
	* @return int - идентификатор новой строки
	*/
	public function Insert($table, $object)
	{			
		$columns = array();
		$values = array();
	
		foreach ($object as $key => $value)
		{
			$key = mysql_real_escape_string($key . '');
			$columns[] = $key;
			
			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else
			{
				$value = mysql_real_escape_string($value . '');							
				$values[] = "'$value'";
			}
		}
		
		$columns_s = implode(',', $columns);
		$values_s = implode(',', $values);
			
		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysql_query($query);
								
	if (!$result) {
            die(mysql_error());
        }
        return mysql_insert_id();
	}
	
	//
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	//	
	public function Update($table, $object, $where, $pre = false, $cutNull = false)
	{
		$sets = array();
                
		foreach ($object as $key => $value)
		{
			if(!$pre) {
                            $key = mysql_real_escape_string($key . '');
                        }
			if ($value === null)
			{
                            if(!$cutNull) {
                                $sets[] = "$key=NULL";
                            }
			}
			else
			{
				if(!pre) {
                                    $value = mysql_real_escape_string($value . '');					
				}
                                    $sets[] = "$key='$value'";			
			}			
		}
		
		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";

		$result = mysql_query($query);
		
		if (!$result) {
                    die(mysql_error());
                }
        $res = mysql_affected_rows();

        if(!$res && $result) $res = $result;
        return 	$res;
	}
	
	//
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)	
	// результат	- число удаленных строк
	//
        /**
         *  @param String $table 
         *  Название таблицы
         * 
         * 
         */
	public function Del($table, $where){
        $query = "DELETE FROM $table WHERE $where";	
        
            $result = mysql_query($query);
            if (!$result){
                    die(mysql_error());
            }
            return mysql_affected_rows();
	}
        
}
