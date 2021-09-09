<?php

/**
 * Class: Controller for Customer user
 *
 * @author gerry.guinane
 * 
 */
class CustomerController extends Controller {

//CLASS properties
    protected $postArray;     //a copy of the content of the $_POST superglobal array
    protected $getArray;      //a copy of the content of the $_GET superglobal array
    protected $viewData;          //an array containing page content generated using models
    protected $controllerObjects;          //an array containing models used by the controller
    protected $user; //session object
    protected $db;
    protected $pageTitle;

//CLASS methods

    //METHOD: constructor 
    function __construct($user,$db) { 
        parent::__construct('CustomerController',$user->getLoggedinState());
        
        //initialise all the class properties
        $this->postArray = array();
        $this->getArray = array();
        $this->viewData=array();
        $this->controllerObjects=array();
        $this->user=$user;
        $this->db=$db;
        $this->pageTitle='P21';

    }
    //END METHOD: constructor 

    //METHOD: run()
    public function run() {  // run the controller
        $this->getUserInputs();
        $this->updateView();
    }
    //END METHOD: run()

    //METHOD: getUserInputs()
    public function getUserInputs() { // get user input
        //
        //This method is the main interface between the user and the controller.
        //
        //Get the $_GET array values
        $this->getArray = filter_input_array(INPUT_GET) ; //used for PAGE navigation
        
        //Get the $_POST array values
        $this->postArray = filter_input_array(INPUT_POST);  //used for form data entry and buttons
        
    }
    //END METHOD: getUserInputs()

    //METHOD: updateView()
    public function updateView() { //update the VIEW based on the users page selection
        if (isset($this->getArray['pageID'])) { //check if a page id is contained in the URL
            switch ($this->getArray['pageID']) {
                case "home":
                    //create objects to generate view content
                    $contentModel = new CustomerHome($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']));
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view                      
                    break;    
                case "dashboard": 
                    //create objects to generate view content
                    $contentModel = new CustomerDashboard($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php'; //load the view                  
                    break;  
                case "viewProjects": 
                    //create objects to generate view content
                    $contentModel = new CustomerDashboard($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php'; //load the view                  
                    break;
                case "addProject": 
                    //create objects to generate view content
                    $contentModel = new CustomerDashboard($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php'; //load the view                  
                    break;
                case "deleteProject": 
                    //create objects to generate view content
                    $contentModel = new CustomerDashboard($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php'; //load the view                  
                    break;  
                    

                case "newMenuItem": 
                    //create objects to generate view content
                    $contentModel = new UnderConstruction($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php'; //load the view                  
                    break; 
                
                //My Account 
                case "myAccount":
                    //create objects to generate view content
                    $contentModel = new CustomerMyAccount($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "editAccount":
                    //create objects to generate view content
                    $contentModel = new CustomerMyAccount($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                case "changePassword":
                    //create objects to generate view content
                    $contentModel = new CustomerMyAccount($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                case "logout":                    
                    //Change the login state to false
                    $this->user->logout();
                    $this->loggedin=FALSE;

                    //create objects to generate view content
                    $contentModel = new GeneralHome($this->user, $this->pageTitle, 'HOME');
                    $navigationModel = new NavigationGeneral($this->user, 'home');
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php'; //load the view                  
                    break;  
                
                //Messages
                case "chat":
                    //this handler is called by AJAX partial page updater
                    //it doesnt return content to a view
                    //it is used to respond to the AJAX request from the chat script that is embedded in the view
                    $msgTable=new ChatMsgTable($this->db);
                    array_push($this->controllerObjects,$msgTable);
                    $rs=$msgTable->getLatestUserMessages($this->user->getUserID(),10);
                    //echo HelperHTML::generateTABLE($rs);
                    echo HelperHTML::generateCHAT($rs,$this->user->getUserID());

                    break;
                
                case "lookup":
                    //this handler is called by AJAX partial page updater
                    //it doesnt return content to a view
                    //it is used to respond to the AJAX request from the chat script that is embedded in the view
                    //$msgTable=new ChatMsgTable($this->db);
                    //$rs=$msgTable->getLatestUserMessages($this->user->getUserID(),10);
                    //echo HelperHTML::generateTABLE($rs);
                    //echo HelperHTML::generateCHAT($rs,$this->user->getUserID());
                    echo 'VALUE ENTERED='.$this->postArray['keyword'];
                    break;
                
                 case "messages":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "livechat":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                case "viewMsgs":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "sendMsg":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;                
                case "deleteMsg":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;                 
                
                default:
                    //no valid pageID selected by user - default loads HOME page
                    //create objects to generate view content
                    $contentModel = new CustomerHome($this->user, $this->pageTitle, $this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $contentModel = new CustomerHome($this->user, $this->pageTitle, 'HOME');
            $navigationModel = new NavigationCustomer($this->user, 'home');
            array_push($this->controllerObjects,$contentModel,$navigationModel);
            $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
            $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
            //update the view
            include_once 'views/view_navbar_2_panel.php';  //load the view
        }
    }
    //END METHOD: updateView()
       
     
}

//end CLASS
