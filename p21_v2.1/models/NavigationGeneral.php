<?php
/**
 * Class: Navigation of general (non logged in) users -This class is used to generate navigation menu items in an an array for the view.
 * 
 * @author gerry.guinane
 * 
 */

class NavigationGeneral {
    
//CLASS properties
        protected $loggedin; //boolean - user logged in state
        protected $modelType; //String - identifues the type of model 
        protected $pageID;   //String: currently selected page
        protected $menuNav;  //Array: array of menu items    
        protected $user;     //User: object of User class
        
//CLASS methods	

	//METHOD: constructor 
	function __construct($user,$pageID) {               
            $this->loggedin=$user->getLoggedInState();
            $this->modelType='NavigationGeneral';
            $this->user=$user;
            $this->pageID=$pageID;
            $this->setmenuNav();
	}
        //END METHOD: constructor 
      
        //METHOD: setmenuNav()
        public function setmenuNav(){//set the menu items depending on the users selected page ID
            
            //empty string for menu items
            $this->menuNav='';

            if($this->loggedin){ 
                //redirect to main index.php page
                header("Location:". $_SERVER['PHP_SELF']);
            }
            else{
            //handlers for not logged in user
            switch ($this->pageID) {
                case "home":
                    $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                    break;
                case "login":
                    $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                    break;  
                default:
                    $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                    break;
                }//end switch
            }
              
        } 
        //END METHOD: setmenuNav()
        
        //METHOD: getMenuNav()
        public function getMenuNav(){return $this->menuNav;}    
        //END METHOD: getMenuNav()
    
        //METHOD: getDiagnosticInfo()
        public function getDiagnosticInfo(){

            echo '<!-- NAVIGATION GENERAL CLASS PROPERTY SECTION  -->';
                echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
                    
                    echo '<h3>NAVIGATION GENERAL (CLASS) properties</h3>';
                    echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
                    echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';                        
                    echo "<tr><td>pageID</td>   <td>$this->pageID</td></tr>";
                    echo "<tr><td>menuNav</td>  <td>$this->menuNav      </td></tr>";
                    echo '</table>';
                    echo '<p><hr>';
                echo '</div>';            
            echo '<!-- END NAVIGATION CLASS PROPERTY SECTION  -->';
            
 }      
        //END METHOD:  getDiagnosticInfo() 
        //     
        //END GETTER METHODS
 
}//end class
        