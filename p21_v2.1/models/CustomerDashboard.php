<?php
/**
 * Class: UnderConstruction Model - provides generic under construction content
 *
 * @author gerry.guinane
 * 
 */

class CustomerDashboard extends Model{

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
        parent::__construct('Under Construction',$user);
        
//Initialise class members
        $this->user=$user;
        $this->db=$db;
        $this->postArray=$postArray;
        $this->pageID=$pageID;
        
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
        switch ($this->pageID){
            case "dashboard":
                $this->panelHead_1='<h3>P21 Dashboard</h3>';  
                break; 
            case "viewProjects":
                $this->panelHead_1='<h3>Your Projects</h3>';  
                break;
            case "addProject":
                $this->panelHead_1='<h3>New Project Details</h3>';  
                break;    
            case "deleteProject":
                $this->panelHead_1='<h3>Delete Project</h3>';  
                break;         
        }   
             
    }//end METHOD - //set the panel 1 heading
    
    public function setPanelContent_1(){//set the panel 1 content  
        switch ($this->pageID){
            case "dashboard":   
                $this->panelContent_1="Welcome to your P21 Dashboard! From here, you can manage your projects.
                <br><img src=\"https://static.thenounproject.com/png/247210-200.png\">";
                break; 
            case "viewProjects":
                $projects = new ProjectTable($this->db);
                $this->panelContent_1 = HelperHTML::generateTABLE($projects->getAllUserRecords($this->user->getUserID()));
                break;
            case "addProject":
                $this->panelContent_1 = file_get_contents('forms/form_add_project.html');
                break;
            case "deleteProject":
                $this->panelContent_1 = file_get_contents('forms/form_delete_project.html');
                break;
                break;
        }           
    }//end METHOD - //set the panel 1 content        

    //Panel 2
    public function setPanelHead_2(){ //set the panel 2 heading  
        switch ($this->pageID){
            case "dashboard":     
                $this->panelHead_2='<h3>Getting Started</h3>';
                break;
            case "addProject":
                $this->panelHead_2='<h3>Information</h3>';  
                break;   
            case "deleteProject":
                $this->panelHead_2='<h3>Your Projects</h3>';  
                break;           
        }
    }//end METHOD - //set the panel 2 heading   
    
    public function setPanelContent_2(){//set the panel 2 content     
        switch ($this->pageID){
            case "dashboard":     
                $this->panelContent_2="To get started, select one of the options from the navigation bar.";
                break;
            case "addProject":
                if(isset($this->postArray['btnAddProject']))
                {
                    $this->postArray['projectName'];
                    $this->postArray['projectDescription'];                    
                    
                    $projectTable = new ProjectTable($this->db);

                    if($projectTable->addRecord($this->postArray,$this->user->getUserID()))
                    {
                        $this->panelContent_2 = 'Your new project was added successfully!';
                    }
                    else
                    {
                        $this->panelContent_2 = 'Error: Project could not be added. Please try again.';
                    }
                }
                else
                {
                    $this->panelContent_2='Enter new project details in form';
                }                    
                break; 
            case "deleteProject":
                $projects = new ProjectTable($this->db);
                $rs=$projects->getAllUserRecords($this->user->getUserID());
                //$this->panelContent_1= HelperHTML::generateSelectTABLE($rs,'projectID',$this->pageID,'Delete');
                $this->panelContent_2 = HelperHTML::generateTABLE($projects->getAllUserRecords($this->user->getUserID()));
                break;
        }    
        
    }//end METHOD - //set the panel 2 content  

    //Panel 3
    public function setPanelHead_3(){ //set the panel 3 heading     
        switch ($this->pageID)
        {
            case "deleteProject":
                $this->panelHead_3 = '<h3>Information</h3>';
        }
    } //end METHOD - //set the panel 3 heading
    
    public function setPanelContent_3(){ //set the panel 2 content      
        switch ($this->pageID)
        {
            case "deleteProject":
                if(isset($this->postArray['btnDeleteProject']))
                {
                    $this->postArray['projectID'];                                        
                    
                    $projectTable = new ProjectTable($this->db);

                    if($projectTable->deleteRecordbyID($this->postArray))
                    {
                        $this->panelContent_3 = 'The project was deleted! Please refresh the page to update the table.';
                    }
                    else
                    {
                        $this->panelContent_3 = 'Error: Project could not be deleted. Please try again.';
                    }
                }
                else
                {
                    $this->panelContent_3='Enter the ID of the project you want to delete.';
                }                    
                break;          
        }
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
        