<?php
/**
 * Class: Table entity class for interfacing to the Admin Table
 * 
 * @author Gerry Guinane
 * 
 */

class AdminTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'admin');
    }
    //END METHOD: Construct
   
    //METHOD: 
    /**
     * Performs validation of user login credentials
     * 
     * @param string $userID
     * @param string $password
     * @param boolean $encryptPW True if Password is hashed
     * @return boolean Returns TRUE if validation is successful. FALSE for invalid credentials.
     */
    public function validate_login($userID,$password,$encryptPW){  
        
        if($encryptPW){//encrypt the password
        $password = hash('ripemd160', $password);       
        } 
        
        $sql="SELECT FirstName,LastName FROM admin WHERE ID='$userID' AND PassWord='$password'";
        if($rs=$this->db->query($sql)){
            if ($rs->num_rows===1){return $rs;}else{return false;} //only one record should be returned
        }
        else{
            return false;
        }
        
    }
    //END METHOD: 
    
    //METHOD: getRecordByID($userID)
    /**
     * Returns a record (FirstName and LastName only by StudentID
     * 
     * @param string $userID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getFullRecordByID($userID){
        $sql="SELECT ID,FirstName,LastName,email,mobile FROM admin WHERE ID='$userID'";
        if($rs=$this->db->query($sql)){
            if ($rs->num_rows===1){return $rs;}else{return false;}//only one record should be returned
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($userID
    
    //METHOD: getRecordByID($userID)
    /**
     * Returns a record (FirstName and LastName only by StudentID
     * 
     * @param string $userID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($userID){
        $sql="SELECT ID,FirstName,LastName,email,mobile FROM admin WHERE ID='$userID'";
        if($rs=$this->db->query($sql)){
            if ($rs->num_rows===1){return $rs;}else{return false;}//only one record should be returned
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($userID
    
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * ID,Firstname and Lastname columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT ID,FirstName,LastName FROM admin';
        if($rs=$this->db->query($sql)){
            if ($rs->num_rows>0){return $rs;}else{return false;}//at least one record should be returned
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getAllRecords()
    
    //METHOD: deleteRecordbyID($userID)
     /**
     * Performs a DELETE query for a single record ($userID).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $userID  String containing ID of user record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($userID){
        
        if($this->getRecordByID($userID)){ //confirm the record exists before deletig
            $sql = "DELETE FROM admin WHERE ID='$userID'";
            if($this->db->query($sql)){return true;}else {return false;} //try to delete the record
        }
        else{
            return false; //record doesnt exist
        }       
    }
     //END METHOD: deleteRecordbyID($userID) 
    
    //METHOD:    addRecord($postArray,$encryptPW)
    /**
     * Inserts a new record in the table. 
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['ID'] string StudentID
         * $postArray['firstName'] string FirstName
         * $postArray['lastName'] string LastName
         * $postArray['pass1'] string PassWord
         * $postArray['email'] string email
         * $postArray['mobile'] string mobile
     * 
     * @param boolean $encryptPW IF TRUE the password will be hashed in the database record
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray,$encryptPW){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $ID= addslashes($ID);
        $firstName= addslashes($firstName);
        $lastName= addslashes($lastName);
        $email=addslashes($email);
        $mobile=addslashes($mobile);
        $password=addslashes($pass1);
        
        //check is password encryption is required
        if($encryptPW){//encrypt the password
        $password = hash('ripemd160', $pass1);       
        } 
        
        //construct the INSERT SQL                  
        $sql="INSERT INTO admin (ID,FirstName,LastName,PassWord,email,mobile) VALUES ('$ID','$firstName','$lastName','$password','$email','$mobile')";   
       
        //execute the insert query
        //check the insert query worked
        if ($rs=$this->db->query($sql)){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)

    //METHOD:    updateRecord($postArray)
    /**
     * Updates an existing record by ID. Does not change password.  
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['ID'] string StudentID
         * $postArray['firstName'] string FirstName
         * $postArray['lastName'] string LastName
         * $postArray['mobile'] string mobile
     * 
     * @return boolean
     * 
     * 
     */   
    public function updateRecord($postArray){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $firstName= addslashes($firstName);
        $lastName= addslashes($lastName);
        $email=addslashes($email);
        $mobile=addslashes($mobile);
                
        //construct the INSERT SQL                    
        $sql="UPDATE admin SET FirstName='$firstName',LastName='$lastName',email='$email',mobile='$mobile' WHERE ID='$ID'";  
        
        //execute the insert query
        //check the insert query worked
        if ($rs=$this->db->query($sql)){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)

    
}

