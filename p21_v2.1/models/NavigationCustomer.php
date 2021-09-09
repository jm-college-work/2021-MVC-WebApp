<?php
/**
 * Class: Navigation of Customer users -This class is used to generate navigation menu items in an an array for the view.
 * 
 * @author gerry.guinane
 * 
 */

class NavigationCustomer {
    
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
            $this->modelType='NavigationCustomer';
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
                //handlers for logged in user
                switch ($this->pageID) {
                    case "home":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=dashboard">Dashboard</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">Messages</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=myAccount">My Account</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "dashboard":                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewProjects">View Projects</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=addProject">Add Project</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteProject">Delete Project</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "viewProjects":                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=addProject">Add Project</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteProject">Delete Project</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "addProject":                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewProjects">View Projects</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteProject">Delete Project</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "deleteProject":                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewProjects">View Projects</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=addProject">Add Project</a></li>';                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    
                    //My Account 
                    case "myAccount":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=editAccount">Edit Details</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=changePassword">Password Change</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "editAccount":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=editAccount">Edit Details</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=changePassword">Password Change</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "changePassword":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=editAccount">Edit Details</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=changePassword">Password Change</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    
                    //Messages
                    case "messages":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=livechat">Live Chat</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewMsgs">View</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=sendMsg">Send</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteMsg">Delete</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "livechat":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=livechat">Live Chat</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewMsgs">View</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=sendMsg">Send</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteMsg">Delete</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "viewMsgs":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=livechat">Live Chat</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewMsgs">View</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=sendMsg">Send</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteMsg">Delete</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "sendMsg":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=livechat">Live Chat</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewMsgs">View</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=sendMsg">Send</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteMsg">Delete</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "deleteMsg":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=livechat">Live Chat</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=viewMsgs">View</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=sendMsg">Send</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=deleteMsg">Delete</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;                                            
                    default:
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">Messages</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=myAccount">My Account</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    }//end switch                
            }
            else{
                //redirect to main index.php page
                header("Location:". $_SERVER['PHP_SELF']);
            }        
        } 
        //END METHOD: setmenuNav()
        
        //METHOD: getMenuNav()
        public function getMenuNav(){return $this->menuNav;}    
        //END METHOD: getMenuNav()
    
        //METHOD: getDiagnosticInfo()
        public function getDiagnosticInfo(){

            echo '<!-- NAVIGATION CUSTOMER CLASS PROPERTY SECTION  -->';
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
        