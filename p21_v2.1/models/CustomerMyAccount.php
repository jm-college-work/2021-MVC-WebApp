<?php
/**
 * Class: UnderConstruction Model - provides generic under construction content
 *
 * @author gerry.guinane
 * 
 */

class CustomerMyAccount extends Model{

//CLASS properties
    protected $pageTitle;         //String: containing page title
    protected $pageHeading;       //String: Containing Page Heading
    protected $db; //MySQLi: database connection object
    protected $postArray; //Array: copy of the $_POST array
    protected $pageID; //String : currently selected pageID
    protected $panelHead_1;       //String: Panel 1 Heading
    protected $panelHead_2;       //String: Panel 2 Heading
    protected $panelHead_3;       //String: Panel 3 Heading
    protected $panelContent_1;    //String: Panel 1 Content
    protected $panelContent_2;    //String: Panel 2 Content     
    protected $panelContent_3;    //String: Panel 3 Content    

//CLASS methods	
    //METHOD: constructor 
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID) {   
        parent::__construct('CustomerMyAccount',$user);
        
//Initialise class members
        $this->db=$db;
        $this->postArray=$postArray;
        $this->pageID=$pageID;
        
        //set the PAGE title
        $this->setPageTitle($pageTitle);

        //set the PAGE heading
        $this->setPageHeading($pageHead);

        //Initialise class members
        $this->user=$user;
        $this->db=$db;
        $this->pageID=$pageID;
        
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
        switch ($this->pageID) {
            case "myAccount":
                $this->panelHead_1='<h3>Manage My Account</h3>'; 
                break;
            case "editAccount":
                $this->panelHead_1='<h3>Edit My Account</h3>'; 
                break;
            case "changePassword":
                $this->panelHead_1='<h3>Change My Password</h3>'; 
                break;
            default:
                $this->panelHead_1='<h3>Manage My Account</h3>'; 
                break;
            }//end switch       
    }//end METHOD - //set the panel 1 heading
    public function setPanelContent_1(){//set the panel 1 content
        switch ($this->pageID) {
            case "myAccount":
                $this->panelContent_1='Use the links above to manage and make changes to your registered account'; 
                break;
            case "editAccount": 
                $countyTable=new CountyTable($this->db);
                $userTable=new CustomerTable($this->db);
                $thisUserRecord=$userTable->getRecordByID($this->user->getUserID());
                $this->panelContent_1=Form::form_edit_account($countyTable,$thisUserRecord,$this->pageID); 
                break;
            case "changePassword":
                $this->panelContent_1=Form::form_password_change($this->pageID); 
                break;
            default:
                $this->panelContent_1='Manage My Account'; 
                break;
            }//end switch  
    }//end METHOD - //set the panel 1 content        

    //Panel 2
    public function setPanelHead_2(){ //set the panel 2 heading
        switch ($this->pageID) {
            case "myAccount":
                $this->panelHead_2='<h3>Manage My Account</h3>'; 
                break;
            case "editAccount":
                
                $this->panelHead_2='<h3>Edit Account Result</h3>'; 
                break;
            case "changePassword":
                $this->panelHead_2='<h3>Password Change Result</h3>'; 
                break;
            default:
                $this->panelHead_2='<h3>Manage My Account</h3>'; 
                break;
            }//end switch
    }//end METHOD - //set the panel 2 heading        
    public function setPanelContent_2(){//set the panel 2 content
        switch ($this->pageID) {

            case "myAccount":
                $this->panelContent_2='myAccount'; 
                break;
            case "editAccount":
                if (isset($this->postArray['btnUpdateAccount'])){
                    $userTable=new CustomerTable($this->db);
                    if($userTable->updateRecord($this->postArray)){
                        $this->panelContent_2='Record Updated';
                        $this->setPanelContent_1();  //refresh panel 1 data after change
                    }
                    else{
                        $this->panelContent_2='Unable to update record or no new values entered';
                    }

                }
                else{
                    $this->panelContent_2='editAccount';  
                }
                break;
            case "changePassword":
                if (isset($this->postArray['btnChangePW'])){
                    
                    //check both new passwords match 
                    if($this->postArray['pass1']===$this->postArray['pass2']){
                        $userTable=new CustomerTable($this->db);
                        if($userTable->changePassword($this->postArray,$this->user)){
                            $this->panelContent_2='Password changed - next time you log in use the new password';
                        }
                        else{
                            $this->panelContent_2='Unable to change password - check you have entered the correct OLD password';
                        }                        
                        
                    }
                    else{
                        $this->panelContent_2='Passwords DONT match';
                    }
                }
                else{
                    $this->panelContent_2='To change your password - enter the new password TWICE along with your OLD password for authorisation.';  
                }
                break;
            default:
                $this->panelContent_2='myAccount'; 
                break;
            }//end switch
    }//end METHOD - //set the panel 2 content  

    //Panel 3
    public function setPanelHead_3(){ //set the panel 3 heading
        if($this->loggedin){
            $this->panelHead_3='<h3>Panel 3</h3>';   
        }
        else{        
            $this->panelHead_3='<h3>Panel 3</h3>'; 
        }
    } //end METHOD - //set the panel 3 heading
    public function setPanelContent_3(){ //set the panel 2 content
        if($this->loggedin){
            $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged ON state.";;
        }
        else{        
            $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";;
        }
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
        
        
}//end class
        