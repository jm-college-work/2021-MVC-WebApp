<?php

class CountyTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'CountyTable');
    }
    //END METHOD: Construct
   
    
    
    //METHOD: getRecordByID($idcounty)
    /**
     * Returns a partial record (countyName only by ID)
     * 
     * @param string $idcounty
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($idcounty){
        $sql="SELECT countyName FROM county WHERE idcounty='$idcounty'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($userID
    

     
    
    //METHOD: deleteRecordbyID($idcounty)
     /**
     * Performs a DELETE query for a single record ($idcounty).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $idcounty  String containing ID of county record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($idcounty){
        
        if($this->getRecordByID($userID)){ //confirm the record exists before deletig
            $sql = "DELETE FROM county WHERE ID='$idcounty'";
            $this->db->query($sql); //delete the record
            return true;
        }
        else{
            return false;
        }       
    }
     //END METHOD: deleteRecordbyID($userID) 
   
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * idcounty,countyName columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT idcounty,countyName FROM county';
        $rs=$this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getAllRecords()
    
     //METHOD:    addRecord($postArray,$encryptPW)
    /**
     * Inserts a new record in the table. 
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['county'] string County Name
     * 
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $countyName= addslashes($county);
        
        
        //construct the INSERT SQL
        $sql="INSERT INTO county (countyName) VALUES ('$countyName')";   
       
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)   

   
    
}

