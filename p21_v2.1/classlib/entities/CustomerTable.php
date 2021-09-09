<?php
/**
 * Class: Table entity class for interfacing to the Customer Table
 * 
 * @author Gerry Guinane
 * 
 */

class CustomerTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'customer');
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
        
        $sql="SELECT FirstName,LastName FROM customer WHERE ID='$userID' AND PassWord='$password'";
        $rs=$this->db->query($sql);
       
        if($rs->num_rows===1){
            return true;
        }
        else{
            return false;
        }
        
    }
    //END METHOD: 
    
    public function changePassword($postArray,$user){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
    
        //add escape to special characters      
        $pass1= addslashes($pass1);
        $pass2= addslashes($pass2);
        $password= addslashes($password);
        $ID=$user->getUserID();

        //check old password is valid before changing
        if($this->validate_login($ID, $password, $user->getPWEncrypted())){
                         
            //encrypt the password if required
            if($user->getPWEncrypted()){
                $pass1 = hash('ripemd160', $pass1);       
            }  
            
            //construct the UPDATE SQL 
            $sql="UPDATE customer SET PassWord='$pass1' WHERE ID='$ID'";   
            //execute the insert query
            $rs=$this->db->query($sql); 
            //check the insert query worked
            if ($this->db->affected_rows===1){return TRUE;}else{return FALSE;}
        }
        else{return FALSE;}  //user did not provide valid old password
    }
    //END METHOD: changePassword($postArray,$user)    
    
    //METHOD: getRecordByID($userID)
    /**
     * Returns a record (FirstName and LastName only by ID
     * 
     * @param string $userID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($userID){
        $sql="SELECT ID,FirstName,LastName,email,mobile,idcounty FROM customer WHERE ID='$userID'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($userID
    
    
    
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
            $sql = "DELETE FROM customer WHERE ID='$userID'";
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
     * ID,Firstname and Lastname columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT ID,FirstName,LastName FROM customer';
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
        $county=(integer) $county;  //idcounty is an integer value only
        
        //check is password encryption is required
        if($encryptPW){//encrypt the password
        $password = hash('ripemd160', $pass1);       
        } 
        
        //construct the INSERT SQL
        $sql="INSERT INTO customer (ID,FirstName,LastName,PassWord,email,mobile,idcounty) VALUES ('$ID','$firstName','$lastName','$password','$email','$mobile',$county)";   
       
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
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
         * $postArray['county'] integer idcounty
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
        $county=(integer) $county;  //idcounty is an integer value only
                
        //construct the INSERT SQL                    
        $sql="UPDATE customer SET FirstName='$firstName',LastName='$lastName',email='$email',mobile='$mobile',idcounty=$county WHERE ID='$ID'";   
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($this->db->affected_rows===1){return TRUE;}else{return FALSE;}
    }
    //END METHOD: updateRecord($postArray)
   
    
}

