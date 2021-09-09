<?php
/**
 * Class: Table entity class for interfacing to the Customer Table
 * 
 * @author Gerry Guinane
 * 
 */

class ProjectTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'request');
    }
    //END METHOD: Construct
   
    
    //METHOD: getRecordByID($requestID)
    /**
     * Returns a record  by ID
     * 
     * @param string $requestID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($projectID){
        $sql="SELECT * FROM project WHERE projectID='$projectID'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($requestID)
    
        
    //METHOD: deleteRecordbyID($requestID)
     /**
     * Performs a DELETE query for a single record ($requestID).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $productID  String containing ID of user record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($postArray){
        
        extract($postArray);        
        //add escape to special characters
        $projectID= addslashes($projectID);

        if($this->getRecordByID($projectID)){ //confirm the record exists before deletig
            extract($postArray);        
            //add escape to special characters
            $projectID = addslashes($projectID);

            $sql = "DELETE FROM project WHERE projectID='$projectID'";
            $this->db->query($sql); //delete the record
            return true;
        }
        else{
            return false;
        }       
    }
     //END METHOD: deleteRecordbyID($requestID) 
   
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT * FROM project';
        $rs=$this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getAllRecords()

    //METHOD:    getAllUserRecords() 
    /**
     * Performs a SELECT query to returns all records for a specific user. 
     * 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getAllUserRecords($userID){
        $sql = "SELECT * FROM project WHERE userID = '$userID'";
        $rs = $this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }
    }
    //END METHOD: getAllUserRecords()

     //METHOD:    addRecord($postArray)
    /**
     * Inserts a new record in the table. 
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['requestDescription'] string Description of Request
         * $postArray['requestedBy'] string Requester's Name
     * 
     * @param boolean $encryptPW IF TRUE the password will be hashed in the database record
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray, $userID){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $projectName= addslashes($projectName);
        $projectDescription=addslashes($projectDescription);          
        
        //construct the INSERT SQL
        $sql="INSERT INTO project (name,description,userID) VALUES ('$projectName','$projectDescription','$userID')";   
        
        //execute the insert query
        $rs=$this->db->query($sql); 

        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)   

}

