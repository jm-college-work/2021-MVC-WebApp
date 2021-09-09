<?php
/**
 * Class: User The user class represents the end user of the application. 
 * 
 * This class is responsible for providing the following functions:
 * 
     * User registration
     * User Login
     * User Logout
     * Persisting user session data by keeping the$_SESSION array up to date
 *
 * @author Gerry Guinane 
 * @version $Revision: 1.0 
 * 
 */
class User {
    
//CLASS properties
    /**
    *
    * @var Session Object   $session The current Session
    * @var MySQLi Object $db the database connection ( 
    * @var String $userID containing User ID
    * @var String $userFirstName  User first name 
    * @var $String userLastName  User Last Name
    * @var String $userType;      User type 
    * @var Array $postArray;     Copy of $_POST array
    * @var boolean$chatEnabled  TRUE if AJAX chat is enabled for this session
    * @var boolean $loggedin  TRUE if user is logged in
    * @var boolean $encryptPW  TRUE if passwords are hash encrypted in DB
    * 
    * 
    */
    protected $session;       //Session Class
    protected $db;            //MySQLi object: the database connection ( 
    protected $userID;        //String: containing User ID
    protected $userFirstName; //String: 
    protected $userLastName;  //String: 
    protected $userType;      //String: usertype is either LECTURER or STUDENT
    protected $postArray;     //Array - copy of $_POST array
    protected $chatEnabled;   //boolean: TRUE if AJAX chat is enabled for this session
    protected $loggedin;
    protected $encryptPW; //boolean true if passwords are hash encrypted in DB

//CLASS methods	

    //METHOD: constructor 
    /**
     * 
     * @param Session Object $session
     * @param MySQLi Object $database
     * @param boolean $encryptPW  TRUE if passwords are hash encrypted in DB
     * 
     * 
     */
    function __construct($session,$database,$encryptPW) {   
        $this->loggedin=$session->getLoggedinState();
        $this->db=$database;
        $this->session=$session;
        
        //get properties from the session object
        $this->userID=$session->getUserID();
        $this->userFirstName=$session->getUserFirstName();
        $this->userLastName=$session->getUserLastName();
        $this->userType=$session->getUserType();
        $this->chatEnabled=$session->getChatEnabledState();
        $this->encryptPW=$encryptPW;
        $this->postArray=array();
    }
    //END METHOD: constructor 

    //METHOD: login($userID, $password)
    /**
     * 
     * @param String $userID
     * @param String $password
     * 
     * @return boolean TRUE if login is successful
     * 
     */
    public function login($userID, $password) {
        //This login function checks both the student and lecturer tables for valid login credentials

        //encrypt the password
        //$password = hash('ripemd160', $password);
        
        //we dont know which type of user is attempting to login
        //need to generate objects to test all three
        $adminTable=new AdminTable($this->db);
        $customerTable= new CustomerTable($this->db);
        // $managerTable= new ManagerTable($this->db);
 
        if($adminTable->validate_login($userID, $password, $this->encryptPW)){  //check if the login details match an ADMIN       
                //query the table for that specific user
                $rs=$adminTable->getRecordByID($userID);
                $row=$rs->fetch_assoc(); //get the users record from the query result  
                                
                //then set the session array property values
                $this->session->setUserID($userID);
                $this->session->setUserFirstName($row['FirstName']);
                $this->session->setUserLastName($row['LastName']);
                $this->session->setUserType('ADMIN'); 
                $this->session->setLoggedinState(TRUE);

                //update the User class properties
                $this->userID=$userID;
                $this->userFirstName=$row['FirstName'];
                $this->userLastName=$row['LastName'];
                $this->userType='ADMIN';
                return TRUE;
            }            
            elseif($customerTable->validate_login($userID, $password,$this->encryptPW)) { //check if the login details match a CUSTOMER
                //query the table for that specific user
                $rs=$customerTable->getRecordByID($userID);
                $row=$rs->fetch_assoc(); //get the users record from the query result                 
                
                //then set the session array property values
                $this->session->setUserID($userID);
                $this->session->setUserFirstName($row['FirstName']);
                $this->session->setUserLastName($row['LastName']);
                $this->session->setUserType('CUSTOMER'); 
                $this->session->setLoggedinState(TRUE);

                //update the User class properties
                $this->userID=$userID;
                $this->userFirstName=$row['FirstName'];
                $this->userLastName=$row['LastName'];
                $this->userType='CUSTOMER';
                return TRUE;                
            }
            else{
                $this->session->setLoggedinState(FALSE);
                $this->loggedin=FALSE;
                return FALSE;
            }
    }
    //END METHOD: login($userID, $password)

    //METHOD: logout()
    /**
     * 
     * @return boolean TRUE if logout is completed
     * 
     */
    public function logout(){
        //
        if($this->session->logout()){return true;}else{return false;}
    }
    //END METHOD: logout()

        
    //setters
    public function setLoginAttempts($num){$this->session->setLoginAttempts($num);}
    public function setChatEnabledState($state){$this->session->setChatEnabledState($state);}
    
    //getters
    public function getLoggedInState(){return $this->session->getLoggedinState();}//end METHOD - getLoggedInState        
    public function getUserID(){return $this->userID;}
    public function getUserFirstName(){return $this->userFirstName;}
    public function getUserLastName(){return $this->userLastName;}
    public function getUserType(){return $this->userType;}
    public function getPWEncrypted(){return $this->encryptPW;}
    public function getLoginAttempts(){return $this->session->getLoginAttempts();}  
    public function getChatEnabledState(){return $this->chatEnabled;}
    public function getDiagnosticInfo(){
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
            echo '<h3>USER (CLASS)  properties</h3>';
            echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            echo "<tr><td>userID  </td><td>$this->userID       </td></tr>";
            echo "<tr><td>userFirstName  </td><td>$this->userFirstName     </td></tr>";
            echo "<tr><td>userLastName  </td><td>$this->userLastName         </td></tr>";
            echo "<tr><td>userType  </td><td>$this->userType         </td></tr>";
            echo "<tr><td>chatEnabled  </td><td>$this->chatEnabled         </td></tr>";
            echo "<tr><td>loggedin  </td><td> $this->loggedin        </td></tr>";
            echo "<tr><td>Password Encryption  </td><td> $this->encryptPW        </td></tr>";
            echo "<tr><td>  </td><td>         </td></tr>";
            echo "<tr><td>  </td><td>         </td></tr>";
            echo "<tr><td>  </td><td>         </td></tr>";
            
            echo '</table>';
            echo '<p><hr>';
        echo '</div>';
    }//END METHOD:  getDiagnosticInfo()

}
