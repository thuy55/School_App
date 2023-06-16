<?php
	require  'Medoo.php';
	use Medoo\Medoo;
	$database = new Medoo([
		'database_type' => 'mysql',
		'database_name' => 'school_hewo_vn',
		'server' => 'localhost',
		'username' => 'school_hewo_vn',
		'password' => 'eclo2023',
		'charset' => 'utf8mb4',
		'port' => 3306,
	]);
?>