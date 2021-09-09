<?php

/**
 * Class: Table entity class for interfacing to the Manager Table
 * 
 * @author Gerry Guinane
 * 
 */

class ChatMsgTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'chatmsg');
    }
    //END METHOD: Construct
   

    
    
    
    //METHOD: getRecordByID($msgID)
    /**
     * Returns a record including message author ID and name
     * 
     * @param string $msgID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($msgID){
        $sql="SELECT msgID,msgText,dateTimestamp,msgAuthorID FROM chatmsg WHERE msgID='$msgID'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($userID
    
    
    
    //METHOD: deleteRecordbyID($msgID)
     /**
     * Performs a DELETE query for a single record ($msgID).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $msgID  String containing ID of user record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($msgID){
        
        if($this->getRecordByID($msgID)){ //confirm the record exists before deletig
            $sql = "DELETE FROM chatmsg WHERE msgID='$msgID'";
            $this->db->query($sql); //delete the record
            return true;
        }
        else{
            return false;
        }       
    }
     //END METHOD: deleteRecordbyID($msgID) 
   
    //METHOD:    getUserMessages($userID) 
    /**
     * Performs a SELECT query to returns all records from the table where messages are TO the specified user or ALL users. 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getUserMessages($userID){
        $sql = "SELECT msgID,dateTimeStamp,msgAuthorID,msgTo,msgText FROM chatmsg WHERE msgTo='$userID' OR msgTo='ALL'";
        $rs=$this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getUserMessages($userID) 
//====
  
//====            
    //METHOD:    getUserMessages($userID,$nrMsgsToGet) 
    /**
     * Performs a SELECT query to returns all records from the table where messages are TO the specified user or ALL users. 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getLatestUserMessages($userID,$nrMsgsToGet){

        //SQL  to select most recent messages ($nrMsgsToGet) to or from the user ($userID) , records are returned in ASCENDING order
        $sql = "SELECT
                    T.SenderID,
                    T.Sent,
                    T.Recipient,
                    T.UserName,
                    T.Message_Content
                FROM 
                 (SELECT 
                    cm.msgID,
                    cm.msgTo AS Recipient,
                    cm.msgAuthorID AS SenderID,
                    CONCAT(au.FirstName,' ',au.LastName) as UserName,
                    cm.dateTimeStamp AS Sent,
                    cm.msgText AS Message_Content
                FROM
                    chatmsg cm,
                    allusers au
                WHERE
                        cm.msgAuthorID=au.ID
                    AND
                    (cm.msgTo = '$userID' OR cm.msgAuthorID='$userID' OR cm.msgTo='ALL')
                ORDER BY msgID DESC
                LIMIT $nrMsgsToGet) AS T
                ORDER BY T.msgID ASC";
 
        $rs=$this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getUserMessages($userID,$userType) 
    
    
    //METHOD:    getUserAuthoredMessages($userID,$userType) 
    /**
     * Performs a SELECT query to returns all records from the table where messages are TO the specified user or ALL users. 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getUserAuthoredMessages($userID){
        $sql = "SELECT msgID,dateTimeStamp,msgAuthorID,msgTo,msgText FROM chatmsg WHERE msgAuthorID='$userID'";
        $rs=$this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getUserMessages($userID,$userType) 
    
    
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table regardless of who messages are addressed to. 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT * FROM chatmsg';
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
    public function addRecord($postArray,$userID,$userType,$msgTo){
        
        //get the values entered in the registration form contained in the $postArray argument     
        extract($postArray);
        
        //add escape to special characters
        $message= addslashes($message);
        $msgTo= addslashes($msgTo);
        
        //check if $msgTo is empty if it is - set it to ALL recipients
        if(!$msgTo) {$msgTo='ALL';}
     
        //construct the INSERT SQL
        $sql="INSERT INTO chatmsg (msgText,msgAuthorID,userType,msgTo) VALUES ('$message','$userID','$userType','$msgTo')";  
       
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
        
    }
    //END METHOD: addRecord($postArray,$encryptPW)   
    
   
    
}

