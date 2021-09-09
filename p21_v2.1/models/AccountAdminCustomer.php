<?php
/**
 * Class: Content Model for generation of view content for Account Administration
 *
 * @author gerry.guinane
 * 
 */

class AccountAdminCustomer extends Model{
    
//CLASS properties
    protected $db;                //MySQLi object: the database connection ( 
    protected $pageTitle;         //String: containing page title
    protected $pageHeading;       //String: Containing Page Heading
    protected $postArray;         //Array: Containing copy of $_POST array
    protected $panelHead_1;       //String: Panel 1 Heading
    protected $panelHead_2;       //String: Panel 2 Heading
    protected $panelHead_3;       //String: Panel 3 Heading
    protected $panelContent_1;    //String: Panel 1 Content
    protected $panelContent_2;    //String: Panel 2 Content     
    protected $panelContent_3;    //String: Panel 3 Content  
    protected $user; //User class object
    
        
//CLASS methods	


	//METHOD: constructor 
	function __construct($postArray,$pageTitle,$pageHead,$database, $user)
	{   
            parent::__construct('AccountAdminCustomer',$user);
            
            $this->db=$database;
            
            $this->user=$user;

            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //get the postArray
            $this->postArray=$postArray;
            
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
        
        //setter methods
        
        //headings
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       
        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
                $this->panelHead_1='<h3>Customer Registration Form</h3>'; 
        }//end METHOD - //set the panel 1 heading
        public function setPanelContent_1(){//set the panel 1 content 
            $countyTable=new CountyTable($this->db);
            $this->panelContent_1 = Form::form_register($countyTable,'registerCustomer');           
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading                   
            $this->panelHead_2='<h3>Registration Result</h3>'; 
        }//end METHOD - //set the panel 2 heading     
        public function setPanelContent_2(){//set the panel 2 content
            //process the registration button
            if (isset($this->postArray['btnRegister'])){  //check the button is pressed
                
                if ($this->postArray['pass1']===$this->postArray['pass2']){  //verify passwords match
                    //process the registration data
                    $this->panelContent_2='Passwords Match<br>';
                    $this->panelContent_2.='User ID   : '.$this->postArray['ID'].'<br>';
                    $this->panelContent_2.='Firstname : '.$this->postArray['firstName'].'<br>';
                    $this->panelContent_2.='Lastname  : '.$this->postArray['lastName'].'<br>';
                    $this->panelContent_2.='Password1 : '.$this->postArray['pass1'].'<br>';
                    $this->panelContent_2.='Password2 : '.$this->postArray['pass2'].'<br>';
                    

                    $customerTable=new CustomerTable($this->db);
                    if ($customerTable->addRecord($this->postArray,$this->user->getPWEncrypted())){  //call the user::registration() method.                    
                        $this->panelContent_2.='REGISTRATION SUCCESSFUL - please log in<br>';
                        }
                    else{
                        $this->panelContent_2.='REGISTRATION NOT SUCCESSFUL<br>';
                        }                     
                }
                else{
                    $this->panelContent_2='Passwords DONT Match<br>';
                    $this->panelContent_2.='User ID   : '.$this->postArray['ID'].'<br>';
                    $this->panelContent_2.='Firstname : '.$this->postArray['firstName'].'<br>';
                    $this->panelContent_2.='Lastname  : '.$this->postArray['lastName'].'<br>';
                    $this->panelContent_2.='Password1 : '.$this->postArray['pass1'].'<br>';
                    $this->panelContent_2.='Password2 : '.$this->postArray['pass2'].'<br>';                    
                }
            }
            else{
                $this->panelContent_2='Please enter details in the form';
            }           
        }//end METHOD - //set the panel 2 content  
        
        //Panel 3
        public function setPanelHead_3(){ //set the panel 3 heading       
                $this->panelHead_3='<h3>Panel 3</h3>';             
        } //end METHOD - //set the panel 3 heading
        public function setPanelContent_3(){ //set the panel 2 content      
                $this->panelContent_3='Panel 3 content - under construction';
        }  //end METHOD - //set the panel 2 content        
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        public function getPanelHead_3(){return $this->panelHead_3;}
        public function getPanelContent_3(){return $this->panelContent_3;}
        public function getUser(){return $this->user;}

        
}//end class
        