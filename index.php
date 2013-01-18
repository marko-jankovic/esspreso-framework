<?php

/* include defined paths */
include_once 'config/defines.php';

/* include defined paths */
include_once 'config/database.php';

/* include autoload (autoload function) */
include_once LIBRARY_PATH . '/autoload.php';

Autoload::getInstance();

/* include routes */
include_once 'config/routes.php';


Espresso_Dispatcher::dispatch();

// test