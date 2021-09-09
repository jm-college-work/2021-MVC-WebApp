<?php

/**
 * Class: Controller for General (non logged in) user
 *
 * @author gerry.guinane
 * 
 */
class GeneralController extends Controller {

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
        parent::__construct('General',$user->getLoggedinState());
        $this->user=$user;
        
        //initialise all the class properties
        $this->postArray = array();
        $this->getArray = array();
        $this->viewData=array();
        $this->controllerObjects=array();
        $this->db=$db;
        $this->pageTitle='P21';
  
    }
    //end METHOD - constructor

    //METHOD: run()
    public function run() {  
        $this->getUserInputs();
        $this->updateView();
    }
    //ÈND METHOD: run()


    //METHOD: getUserInputs()
    public function getUserInputs() {
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
                    $contentModel = new GeneralHome($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']));
                    $navigationModel = new NavigationGeneral($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php';  //load the view
                    break;
                case 'login':                    
                    //create objects to generate view content
                    $contentModel = new Login($this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->db,$this->user);
                    $navigationModel = new NavigationGeneral($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php'; //load the view                  
                    break;           
                default:
                    //no page selected 
                    //create objects to generate view content
                    $contentModel = new GeneralHome($this->user,$this->pageTitle, 'HOME');
                    $navigationModel = new NavigationGeneral($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $contentModel = new GeneralHome($this->user, $this->pageTitle, 'HOME');
            $navigationModel = new NavigationGeneral($this->user, 'home');
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
