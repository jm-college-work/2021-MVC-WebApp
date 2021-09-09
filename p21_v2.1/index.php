<?php

// Join session between client and server
session_start();

//load application configuration
include_once 'config/config.php';
include_once 'config/database.php';

//Base Classes
include_once 'classlib/baseClasses/Controller.php';
include_once 'classlib/baseClasses/Model.php';
include_once 'classlib/baseClasses/TableEntity.php';

//System Classes
include_once 'classlib/system/Session.php';
include_once 'classlib/system/User.php';

//helper classes
include ('classlib/helperClasses/HelperHTML.php');

//Database Table Entities
include_once 'classlib/entities/ProjectTable.php';
include_once 'classlib/entities/CustomerTable.php';
include_once 'classlib/entities/AdminTable.php';
include_once 'classlib/entities/CountyTable.php';
include_once 'classlib/entities/ChatMsgTable.php';

//Controller Clases for specific user types
include_once 'controllers/GeneralController.php';
include_once 'controllers/CustomerController.php';
include_once 'controllers/AdminController.php';

//Navigation models
include_once 'models/NavigationGeneral.php';
include_once 'models/NavigationCustomer.php';
include_once 'models/NavigationAdmin.php';

//Page models - Common
include_once 'models/GeneralHome.php';
include_once 'models/UnderConstruction.php';
include_once 'models/Login.php';

//forms
include_once 'forms/Form.php';

//Page models - ADMIN user
include_once 'models/AdminManageProjects.php';
include_once 'models/AdminHome.php';
include_once 'models/AccountAdminCustomer.php';
include_once 'models/ManageUsers.php';

//Page models CUSTOMER
include_once 'models/CustomerDashboard.php';
include_once 'models/CustomerHome.php';
include_once 'models/CustomerMyAccount.php';
include_once 'models/CustomerMessages.php';


//attempt to connect to the MySQL Server (with error reporting supression '@')
@$db=new mysqli($DBServer, $DBUser, $DBPass, $DBName, $DBportNr);
//check if there is an error in the connection
if($db->connect_errno){  
    if (DEBUG_MODE){
        $msg = '<h3>Unable to make Database Connection</h3>';
        //report on connection issue
        $msg.= '<p>There has been a proble making connection to MySQL Server - MySQLi Error message:';
        $msg.= '<ul>';
        $msg.= '<li>MySQLi Error Number  : ' . $db->connect_errno. '</li>';
        $msg.= '<li>MySQLi Error Message : '.$db->connect_error. '</li>';
        $msg.= '</ul>';
    
    }
    else{
        $msg= '<h4>Oops - something is not working!</h4>';
    }
    exit($msg);  //the script exits here if no database connection can be made
}

@$db->query("SET NAMES 'utf8'"); //make sure database connection is set to support UTF8 characterset

//Create the new session object
$session = new Session();
$session->setChatEnabledState(CHAT_ENABLED);
$user = new User($session, $db, ENCRYPT_PW);


if ($user->getLoggedInState()) {
    //load the appropriate controller depending on the user type
    //
    //
 
    switch ($user->getUserType()) {       

        case "CUSTOMER":  //create new STUDENT controller
            $controller = new CustomerController($user, $db);
            break;

        case "ADMIN":  //create new STUDENT controller
            $controller = new AdminController($user, $db);
            break;        
        
        default :  //create new general/not logged in controller
            //unidentified user type  - force logout to reset system state
            $user->logout();
            $controller = new GeneralController($user, $db);
            break;
    }
}
 else {
    //user is not logged in
    //create new general/not logged in controller
    $controller = new GeneralController($user, $db);
}


//run the application
$controller->run();

//Debug information
if (DEBUG_MODE) { 
    //Comment out whichever info you dont want to use.
    

    echo '<section>';
        echo '<!-- The Debug SECTION  of index.php-->';
        echo '<div class="container-fluid"   style="background-color: #AA44AA">'; //outer DIV

        echo '<h2>Index.php - Debug information</h2><br>';

        echo '<section style="background-color: #AAAAAA">';
            echo '<pre><h5>SESSION Class</h5>';
            $session->getDiagnosticInfo();
            echo '</pre>';
        echo '</section>';

        echo '<section style="background-color: #AAAAAA">';
            echo '<pre><h5>USER Class</h5>';
            $user->getDiagnosticInfo();
            echo '</pre>';
        echo '</section>';            

        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- $_COOKIE ARRAY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>$_COOKIE Array values</h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
            foreach($_COOKIE as $key=>$value){
                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
            echo '</table><hr>';
            echo '<!-- END $_COOKIE ARRAY SECTION  -->';
        echo '</section>'; 
        
        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- $_SESSION ARRAY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>$_SESSION Array values</h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
            foreach($_SESSION as $key=>$value){
                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
            echo '</table><hr>';
            echo '<!-- END $_SESSION ARRAY SECTION  -->';
        echo '</section>'; 
   
        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- $_POST ARRAY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>$_POST Array values</h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
            foreach($_POST as $key=>$value){
                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
            echo '</table><hr>';
            echo '<!-- END $_POST ARRAY SECTION  -->';
        echo '</section>';         
       
        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- $_GET ARRAY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>$_GET Array values</h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
            foreach($_GET as $key=>$value){
                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
            echo '</table><hr>';
            echo '<!-- END $_GET ARRAY SECTION  -->';
        echo '</section>';  

        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- config.php GLOBAL variables  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>GLOBAL variables (config/config.php) </h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
                echo '<tr><td>ENCRYPT_PW</td><td>'.ENCRYPT_PW.'</td></tr>';
                echo '<tr><td>CHAT_ENABLED</td><td>'.CHAT_ENABLED.'</td></tr>';
                echo '<tr><td>__THIS_URI_ROOT</td><td>'.__THIS_URI_ROOT.'</td></tr>';
            echo '</table><hr>';
            echo '<!-- END config.php GLOBAL variables  -->';
        echo '</section>';  
        
        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- DATABASE Configuration (config/database.php)  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>DATABASE Configuration (config/database.php) </h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
                echo '<tr><td>MySQL Server IP Address</td><td>'.$DBServer.'</td></tr>';
                echo '<tr><td>MySQL Server PORT Number</td><td>'.$DBportNr.'</td></tr>';
                echo '<tr><td>User ID</td><td>'.$DBUser.'</td></tr>';
                echo '<tr><td>Password</td><td>'.$DBPass.'</td></tr>';
                echo '<tr><td>Database Name</td><td>'.$DBName.'</td></tr>';
            echo '</table><hr>';
            echo '<!-- END DATABASE Configuration (config/database.php)  -->';
        echo '</section>';
        
    echo '</section>';
    
    echo '</section>';
    echo '</br>';
    echo '</div>';
    //controller class debug info        
    $controller->debug();

};
echo '</body></html>'; //end of HTML Document

//close or release any open connections/resources
//close the DB Connection
$db->close();
