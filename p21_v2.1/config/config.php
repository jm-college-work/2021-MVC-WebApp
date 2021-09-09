<?php
//configuration settings for this web application
//these are defined as global constants which will be available 
//in ALL SCRIPTS, CLASSES and FUNCTIONS

define ('DEBUG_MODE',false);  //True for DEBUG mode turned on
define ('ENCRYPT_PW',true);  //True if Passwords are hash encrypted

//AJAX Configuration
define ('CHAT_ENABLED',false);  //True if AJAX Chat  is enabled

$serverIP_address='http://192.168.0.135';  //network address of the Apache Server
$root_path='/nsync2021/Framework_08/'; //path from htdocs folder to the default page (usually index.php) of this web application

define ('__THIS_URI_ROOT',$serverIP_address.$root_path);  //Define root URL folder for this website




