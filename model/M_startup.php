<?php

function M_startup()
{
	// Настройки подключения к БД.

        
	$hostname = 'localhost';	
	$username = 'mind-body'; 
	$password = '';
        
	$dbName   = "mind-body";

	
	// Языковая настройка.
	setlocale(LC_ALL, 'ru_RU.utf8');	
	
	// Подключение к БД.
	mysql_connect($hostname, $username, $password) or die('No connect with data base'); 
	mysql_query('SET NAMES utf8');
	mysql_select_db($dbName) or die('No data base');

	// Открытие сессии.
	session_start();		
}
