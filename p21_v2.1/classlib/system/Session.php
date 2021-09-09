<?php
/**
 * 
 * Class The Session Class is responsible for persistance of user data between page requests. 
 * Data is stored in the superglobal array $_SESSION
 *
 * @author Gerry Guinane 
 * @version $Revision: 1.0 
 * 
 */
class Session { 
    
//CLASS properties
    private $sessionID;         //String : containing the PHPSESSID cookie value 
    private $loggedin;          //Boolean : TRUE is logged in
    private $userID;            //String: containing User ID
    private $userFirstName;     //String: 
    private $userLastName;      //String: 
    private $userType;          //String: usertype is either LECTURER or STUDENT
    private $loginAttempts;     //Integer: count of login attempts
    private $views;             //Integer: count of the number of page views in the current session
    private $lastViewTimestamp; //timestamp of the most recent page view
    private $loginTimestamp;    //timestamp of successful login
    private $chatEnabled;       //Boolean: TRUE if AJAX chat is enabled for this session
   
//CLASS methods	

    //METHOD: constructor 
    public function __construct(){
        //this constructor initialises the $_SESSION variables to initial default values 
        //for first time page visit. 
        //If the page/website has been previously (a valid session key exists) 
        //it retrieves all previously set values from the $_SESSION superglobal array
        
        //set the timestamps
        $this->lastViewTimestamp=date('d/m/Y h:i:s a', time());
        $_SESSION["lastViewTimestamp"]=$this->lastViewTimestamp;

        //get the sessionid from the cookie array
        if (isset($_COOKIE['PHPSESSID'])){
            $this->sessionID=$_COOKIE['PHPSESSID'];
            $_SESSION['sessionID']=$_COOKIE['PHPSESSID'];
        }
        else{
            $this->sessionID=null;
            $_SESSION['sessionID']=null;
        }
              
        //initialise session variables
        if (isset($_SESSION['loggedin'])){
            $this->loggedin=$_SESSION['loggedin'];
        }
        else{
          $_SESSION['loggedin'] = FALSE;
          $this->loggedin=FALSE;
          $this->loginTimestamp=null;
          $_SESSION["loginTimestamp"]=$this->loginTimestamp;
          }
          
        if(isset($_SESSION['views'])){  //keep track of the number of page views
            $_SESSION['views'] = $_SESSION['views']+ 1;
            $this->views=$_SESSION['views'];
        }
        else{
             $_SESSION['views'] = 1; 
             $this->views=$_SESSION['views'];
        }

        if (isset($_SESSION['userID'])){
            $this->userID=$_SESSION['userID'];
        }
        else{
          $_SESSION['userID'] = NULL;
          $this->userID=NULL;
          }
        if (isset($_SESSION['chatEnabled'])){
            $this->chatEnabled=$_SESSION['chatEnabled'];
        }
        else{
          $_SESSION['chatEnabled'] = FALSE;
          $this->chatEnabled=FALSE;
          }
         
        if (isset($_SESSION['loginAttempts'])){
            $this->loginAttempts=$_SESSION['loginAttempts'];
        }
        else{
          $_SESSION['loginAttempts'] = 0;
          $this->loginAttempts=0;
          }
          
          
        if (isset($_SESSION['userFirstName'])){
            $this->userFirstName=$_SESSION['userFirstName'];
        }
        else{
          $_SESSION['userFirstName'] = NULL;
          $this->userFirstName=NULL;
          }
   
        if (isset($_SESSION['userLastName'])){
            $this->userLastName=$_SESSION['userLastName'];
        }
        else{
          $_SESSION['userLastName'] = NULL;
          $this->userLastName=NULL;
          }

        if (isset($_SESSION['userType'])){
            $this->userType=$_SESSION['userType'];
        }
        else{
          $_SESSION['userType'] = NULL;
          $this->userType=NULL;
          }

    }
    //END METHOD: constructor
    
    //METHOD: setLoggedinState($loggedin)
    /**
     * 
     * @param boolean $loggedin 
     *  
     */
    public function setLoggedinState($loggedin){
        //this function can be used to set the logged in state to true or false 
        //when set to false it does not kill the session variables or the session cookie
        //it is used for both successful and failed login attempts
        //
        if($loggedin==TRUE){            
          $_SESSION['loggedin'] = TRUE;
          $this->loggedin= TRUE;  
          $this->loginTimestamp=date('d/m/Y h:i:s a', time());
          $_SESSION["loginTimestamp"]=$this->loginTimestamp;
          
        }
        else{
          $_SESSION['loggedin'] = FALSE;
          $this->loggedin=FALSE;          
          $this->setUserFirstName(NULL);
          $this->setUserLastName(NULL);
          $this->setUserID(NULL);
          $this->setUserType(NULL);     
        }    
    }
    //END METHOD: setLoggedinState($loggedin)
    
    //METHOD:logout()
    /**
     * 
     * @return boolean TRUE when logout is completed
     * 
     */
    public function logout(){
        //this logout function kills all session variables and expires the session cookie on the client machine
        $this->loggedin=FALSE;          
        $this->setUserFirstName(NULL);
        $this->setUserLastName(NULL);
        $this->setUserID(NULL);
        $this->setUserType(NULL);
        $_SESSION = array(); //destroy all of the session variables
        if (ini_get("session.use_cookies")) {  //kill the cookie containing the session ID on the client machine
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
            }
        return true;
    }
    //END METHOD:logout()
    
    //METHOD:setUserID($userID)
    public function setUserID($userID){$this->userID=$userID;$_SESSION['userID']=$userID;}
    //END METHOD:setUserID($userID)
    
    //METHOD:setUserFirstName($firstName)
    public function setUserFirstName($firstName){$this->userFirstName=$firstName;$_SESSION['userFirstName']=$firstName;}
    //END METHOD:setUserFirstName($firstName)
    
    //METHOD:setUserLastName($lastName)
    public function setUserLastName($lastName){$this->userLastName=$lastName;$_SESSION['userLastName'] =$lastName;}
    //END METHOD:setUserLastName($lastName)
    
    //METHOD:setUserType($userType)
    public function setUserType($userType){$this->userType=$userType;$_SESSION['userType'] =$userType;} 
    //END METHOD:setUserType($userType)
    
    //METHOD:setChatEnabledState($state)
    public function setChatEnabledState($state){$this->chatEnabled=$state;$_SESSION['chatEnabled']=$state;}
    //END METHOD:setChatEnabledState($state)
    
    //METHOD:setLoginAttempts($num)
    public function setLoginAttempts($num){
        $this->loginAttempts=$num;
        $_SESSION['loginAttempts']=$num;
    }  
    //END METHOD:setLoginAttempts($num)

    //getter METHODS
    public function getSessionID(){return $this->sessionID;}
    public function getLoggedinState(){return $this->loggedin;}
    public function getChatEnabledState(){return $this->chatEnabled;}
    public function getUserID(){return $this->userID;}
    public function getUserFirstName(){return $this->userFirstName;}
    public function getUserLastName(){return $this->userLastName;}
    public function getUserType(){return $this->userType;}
    public function getLoginAttempts(){return $this->loginAttempts;}
    public function getLastPageViewTimestamp(){return $this->lastViewTimestamp;}
    public function getLoginTimestamp(){return $this->loginTimestamp;}
    public function getDiagnosticInfo(){
            echo '<!-- SESSION CLASS PROPERTY SECTION  -->';
                echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV                    
                    echo '<h3>SESSION (CLASS) properties</h3>';
                    echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
                    echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';                        
                    echo "<tr><td>sessionID  </td>   <td>$this->sessionID    </td></tr>";
                    echo "<tr><td>loggedin  </td>   <td>$this->loggedin    </td></tr>";
                    echo "<tr><td>chatEnabled  </td>   <td>$this->chatEnabled    </td></tr>";
                    echo "<tr><td>userID  </td>   <td>$this->userID    </td></tr>";
                    echo "<tr><td>userFirstName  </td>   <td>$this->userFirstName    </td></tr>";                   
                    echo "<tr><td>userType  </td>   <td>$this->userType    </td></tr>";
                    echo "<tr><td>loginAttempts  </td>   <td>$this->loginAttempts    </td></tr>";
                    echo "<tr><td>lastViewTimestamp  </td>   <td>$this->lastViewTimestamp    </td></tr>";
                    echo "<tr><td>loginTimestamp  </td>   <td>$this->loginTimestamp    </td></tr>";                                       
                    echo '</table>';
                    echo '<p><hr>';
                echo '</div>';            
            echo '<!-- END SESSION CLASS PROPERTY SECTION  -->';
            
 }      //END METHOD:  getDiagnosticInfo()

    
}
