<?php
/**
 * Class: Class: Content Model for generation of view content for Administrator Home
 *
 * @author gerry.guinane
 * 
 */

class AdminHome extends Model{
    
//CLASS properties
        protected $db;                //MySQLi object: the database connection ( 
        protected $pageTitle;         //String: containing page title
        protected $pageHeading;       //String: Containing Page Heading
        protected $panelHead_1;       //String: Panel 1 Heading
        protected $panelHead_2;       //String: Panel 2 Heading
        protected $panelHead_3;       //String: Panel 3 Heading
        protected $panelContent_1;    //String: Panel 1 Content
        protected $panelContent_2;    //String: Panel 2 Content     
        protected $panelContent_3;    //String: Panel 3 Content
    
//CLASS methods
        //METHOD: constructor 
	function __construct($user,$pageTitle,$pageHead){   
            parent::__construct('AdminHome',$user);

            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();

            //set the DECOND panel content
            $this->setPanelHead_2();
            $this->setPanelContent_2();
        
            //set the THIRD panel content
            $this->setPanelHead_3();
            $this->setPanelContent_3();
	} 
        //END METHOD: constructor 
      
        //SETTER METHODS
        
        //Headings
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       
        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
                $this->panelHead_1='<h3>P21 Web App</h3>';
        }//end METHOD - //set the panel 1 heading
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){ 
                if ($this->user->getUserType()==='ADMIN'){ //An ADMIN is logged in 
                    $this->panelContent_1.='<p>You are currently logged in as ADMIN.';
                }
            }
            else{ //User is not logged in
                $this->panelContent_1.='<p>You must log in to use this system.';  
            }
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading
            if($this->loggedin){
                $this->panelHead_2='<h3>Welcome</h3>';
            }
            else{        
                $this->panelHead_2='<h3>Login required</h3>';
            }
        }//end METHOD - //set the panel 2 heading    
        public function setPanelContent_2(){//set the panel 2 content
            //get the Middle panel content
            if($this->loggedin){
                
                if ($this->user->getUserType()==='ADMIN'){ //An ADMIN is logged in
                    $this->panelContent_2='Thank you <b>'.$this->user->getUserFirstName().' '.$this->user->getUserLastName() .'</b> for logging in successfully as a ADMIN to the P21 Web App. Please use the links above to manage projects, users and the system. <br><br>Don\'t forget to logout when you are done.';
                }  
            }
            else{  //User is not logged in        
                $this->panelContent_2='You are required to login - Please use the link above to login';
            }
        }//end METHOD - //set the panel 2 content  
        
        //Panel 3
        public function setPanelHead_3(){ //set the panel 3 heading
            if($this->loggedin){      
                $this->panelHead_3='<h3>Application Setup</h3>';
            } 
        } //end METHOD - //set the panel 3 heading  
        public function setPanelContent_3(){ //set the panel 2 content
                $this->panelContent_3.='<p>To set up this application read the following <a href="readme/installation.html" target=”_blank” >SETUP INSTRUCTIONS</a></p>';            
        }  //end METHOD - //set the panel 2 content        
       
         //GETTER METHODS
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        public function getPanelHead_3(){return $this->panelHead_3;}
        public function getPanelContent_3(){return $this->panelContent_3;}
 
        
        //END GETTER METHODS        
        
}//end class
        