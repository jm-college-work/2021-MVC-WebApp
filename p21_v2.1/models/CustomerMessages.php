<?php
/**
 * Class: UnderConstruction Model - provides generic under construction content
 *
 * @author gerry.guinane
 * 
 */

class CustomerMessages extends Model{

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
        parent::__construct('CustomerMessages',$user);
        
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
            
            case "messages":
                $this->panelHead_1='<h3>Messages</h3>';
                break;
            case "livechat":
                $this->panelHead_1='<h3>Live Chat</h3>';
                break;
            case "viewMsgs":
                $this->panelHead_1='<h3>View Messages</h3>';
                break;
            case "sendMsg":
                $this->panelHead_1='<h3>Send Messages</h3>';
                break;
            default:
                $this->panelHead_1='<h3>Messages</h3>';
                break;
            }//end switch       
    }//end METHOD - //set the panel 1 heading
    public function setPanelContent_1(){//set the panel 1 content
        switch ($this->pageID) {
            case "messages":
                $this->panelContent_1='Use the menu items above to use the live chat, and to view, send and delete messages.';
                break;
            case "livechat":
                $this->panelContent_1= Form::form_add_msg($this->pageID);
                //$this->panelContent_1= Form::form_add_msg_predictive($this->pageID);
                break;
            case "viewMsgs":
                $table=new ChatMsgTable($this->db);
                //$rs=$table->getAllRecords();
                $rs=$table->getUserMessages($this->user->getUserID());
                $this->panelContent_1= HelperHTML::generateTABLE($rs);
                break;
            case "deleteMsg":
                $table=new ChatMsgTable($this->db);
                $rs=$table->getUserAuthoredMessages($this->user->getUserID());
                $this->panelContent_1= HelperHTML::generateSelectTABLE($rs,'msgID',$this->pageID,'Delete');
                break;                
            case "sendMsg":
                $this->panelContent_1= Form::form_add_msg($this->pageID);
                break;
            default:
                $this->panelContent_1='Messages';
                break;            
            }//end switch  
    }//end METHOD - //set the panel 1 content        

    //Panel 2
    public function setPanelHead_2(){ //set the panel 2 heading
        switch ($this->pageID) {
            case "messages":
                $this->panelHead_2='<h3>Live Chat Messages</h3>';
                break;
            case "livechat":
                $this->panelHead_2='<h3>Live Chat</h3>';
                break;
            case "viewMsgs":
                $this->panelHead_2='<h3>View Messages</h3>';
                break;
            case "sendMsg":
                $this->panelHead_2='<h3>Send Messages</h3>';
                break;
            case "deleteMsg":
                $this->panelHead_2='<h3>Delete Messages</h3>';
                break;                
            default:
                $this->panelHead_2='<h3>Messages</h3>';
                break;            
            }//end switch
    }//end METHOD - //set the panel 2 heading        
    public function setPanelContent_2(){//set the panel 2 content
        switch ($this->pageID) {
            case "messages":
                $this->panelContent_2='This messages sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;
            case "livechat":
                if (isset($this->postArray['btnAddMsg'])){
                    $table=new ChatMsgTable($this->db);

                    if($table->addRecord($this->postArray,$this->user->getUserID(),$this->user->getUserType(),'CUST001')){
                        
                       //$this->panelContent_2= '<textarea class="form-control" id="message" name="message" rows="3" style="resize:vertical"> <div id="chat">Chat messages will appear here if chat is enabled</div> </textarea>';
                        
                        $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                        $this->panelContent_2.='New Message Sent';
                        
                    }
                    else{
                        $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                        $this->panelContent_2.='Unable to add new message';
                    }
                }
                else{
                    $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                }

                break;
            case "viewMsgs":
                $this->panelContent_2='View Messages';
                break;
            case "sendMsg":
                if (isset($this->postArray['btnAddMsg'])){
                    $table=new ChatMsgTable($this->db);

                    if($table->addRecord($this->postArray,$this->user->getUserID(),$this->user->getUserType(),'CUST001')){
                        $this->panelContent_2='Message Sent';
                    }
                    else{
                        $this->panelContent_2='Unable to update record';
                    }
                }
                else{
                    $this->panelContent_2='Send Messages'; 
                }
                break;
            case "deleteMsg":
                if (isset($this->postArray['btnRecordSelected'])){
                    $table=new ChatMsgTable($this->db);
                    if($table->deleteRecordbyID($this->postArray['recordSelected'])){
                        $this->panelContent_2='Message (msgID=)'.$this->postArray['recordSelected'].' has been deleted';
                        $this->setPanelContent_1(); //update panel 1 content to show updated table of messages

                    }
                    else{
                        $this->panelContent_2='Unable to delete selected record';
                    }
                }
                else{
                    $this->panelContent_2='Delete My Messages'; 
                }
                break;    
                
            default:
                $this->panelContent_2='Messages';
                break;   
            }//end switch
        
    }  //end METHOD - //set the panel 2 content        

    //Panel 3
    public function setPanelHead_3(){ //set the panel 2 heading
        switch ($this->pageID) {
            case "messages":
                $this->panelHead_3='<h3>Messages</h3>';
                break;
            case "livechat":
                $this->panelHead_3='<h3>Live Chat</h3>';
                break;
            case "viewMsgs":
                $this->panelHead_3='<h3>View Messages</h3>';
                break;
            case "sendMsg":
                $this->panelHead_3='<h3>Send Messages</h3>';
                break;
            default:
                $this->panelHead_3='<h3>Messages</h3>';
                break;            
            }//end switch
    }//end METHOD - //set the panel 2 heading        
    public function setPanelContent_3(){//set the panel 2 content
        switch ($this->pageID) {
            case "messages":
                $this->panelContent_3='This messages sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;
            case "livechat":
                $this->panelContent_3='Live chat content';
                break;
            case "viewMsgs":
                $this->panelContent_3='View Messages';
                break;
            case "sendMsg":
                $this->panelContent_3='Send Messages';
                break;
            default:
                $this->panelContent_3='Messages';
                break;   
            }//end switch
        
    }  //end METHOD - //set the panel 3 content    
    
    
    
    
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
        