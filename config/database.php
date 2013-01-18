<?php

	// default database	

	define('DB_DRIVER','mysqli');
	define('DB_CLASS','MysqliDriver');
	define('DB_HOST','localhost');
	define('DB_NAME','food');
	define('DB_USER','root');
	define('DB_PASS','');
	define("DB_ENCODING","utf8");
	
	// only for sqlite
	define('DB_PATH','localhost');