<?php
/**
 * 
 * Class: Base class for Controllers
 * 
 * @author Gerry Guinane
 * 
 */

class Controller {
    //class properties
    /**
     *
     * @var boolean $userLoggedIn  - user logged in state 
     * @var string $controllerType  - identifies the type of controller
     * 
     */
    protected $userLoggedIn; //boolean - user logged in state
    private $controllerType; //String - identifies the type of controller
	
    //constructor method
    /**
     * 
     * @var boolean $userLoggedInState  - user logged in state 
     * @var string $controllerType  - identifies the type of controller
     * 
     */
    function __construct($controllerType,$loggedInState) {  //constructor  
        //initialise the model
        $this->userLoggedIn=$loggedInState;
        $this->controllerType=$controllerType;
    } //end METHOD - constructor
        

    //METHOD: getPageContent()
    /**
     * 
     * @param Model $contentMod Content Model
     * @param Model $navMod Navigation Model
     * @return Array $data array 
     * 
     */
    protected function getPageContent($contentMod,$navMod) {
        //get the content from the navigation model - put into the $data array for the view:
        $data['menuNav'] = $navMod->getMenuNav();       // an array of menu items and associated URLS
        //get the content from the page content model  - put into the $data array for the view:
        $data['pageTitle'] = $contentMod->getPageTitle();
        $data['pageHeading'] = $contentMod->getPageHeading();
        $data['panelHead_1'] = $contentMod->getPanelHead_1(); // A string containing the LHS panel heading/title
        $data['panelHead_2'] = $contentMod->getPanelHead_2();
        $data['panelHead_3'] = $contentMod->getPanelHead_3(); // A string containing the RHS panel heading/title
        $data['panelContent_1'] = $contentMod->getPanelContent_1();     // A string intended of the Left Hand Side of the page
        $data['panelContent_2'] = $contentMod->getPanelContent_2();     // A string intended of the Left Hand Side of the page
        $data['panelContent_3'] = $contentMod->getPanelContent_3();     // A string intended of the Right Hand Side of the page
        return $data;
        
    }
    //END METHOD: getPageContent()
        
          
    //METHOD: debug()
    public function debug() {   //Diagnostics/debug information - dump the application variables if DEBUG mode is on

        echo '<!--CONTROLLER CLASS PROPERTY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #22AAAA">'; //outer DIV green blue

            echo '<h2>'.strtoupper($this->controllerType).' Controller Class - Debug information</h2><br>';

            //SECTION 1
            echo '<section style="background-color: #AABBCC">'; //light blue
                echo '<h3>'.strtoupper($this->controllerType).' Controller (CLASS) properties</h3>';
                
                
                echo '<h4>User Logged in Status:</h4>';
                if ($this->userLoggedIn) {
                    echo 'User Logged In state is TRUE ($loggedin) <br>';
                } else {
                    echo 'User Logged In state is FALSE ($loggedin) <br>';
                }

                echo '<h4>$postArray Values (user input - values entered in any form)</h4>';
                echo '<pre>';
                var_dump($this->postArray);
                echo '</pre>';
                echo '<br>';

                echo '<h4>$getArray Values (user input - page selected)</h4>';
                echo '<pre>';
                var_dump($this->getArray);
                echo '</pre>';
                echo '<br>';

                echo '<h4>$data Array Values (Array of Values passed to view)</h4>';
                echo '<pre>';
                var_dump($this->viewData);
                echo '</pre>';
                echo '<br>';

            echo '</section>';

            //SECTION 2
            echo '<section style="background-color: #AABBCC">'; //light blue
                echo '<h4>Controller - Class Objects</h4>';
                echo '<pre>';
                foreach($this->controllerObjects as $object){$object->getDiagnosticInfo();}
                echo '</pre>';
            echo '</section>';
                       
            echo '</div>';  //END outer DIV
            echo '<!-- END GENERAL CONTROLLER CLASS PROPERTY SECTION  -->';
        
    }
    //END METHOD: debug()
    
    
} //end CLASS