<?php
/**
 * 
 * Class: Base class for Models
 * 
 * @author Gerry Guinane
 * 
 */

class Model {
    /**
     *
     * @var boolean $loggedin;  - user logged in state
     * @var boolean $userLoggedIn  - user logged in state 
     * @var string $modelType  - identifies the type of model (eg USER, ADMINISTRATOR)
     * 
     */
    protected $loggedin; //boolean - user logged in state
    protected $user; //user Class - user logged in state
    protected $modelType; //String - identifues the type of model (eg USER, ADMINISTRATOR)
	
    //constructor method
    /**
     * 
     * @param string $modelType  - identifies the type of model (eg USER, ADMINISTRATOR)
     * @param User $user - the current user
     * 
     */
    function __construct($modelType,$user) {  //constructor  
        //initialise the model
        $this->loggedin=$user->getLoggedInState();
        $this->user=$user;
        $this->modelType=$modelType;
    } //end METHOD - constructor
        
    public function getDiagnosticInfo(){
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
            echo '<h3>'.strtoupper($this->modelType).'  (MODEL CLASS) properties</h3>';
            echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            echo "<tr><td>pageTitle</td>    <td>".$this->pageTitle."</td></tr>";
            echo "<tr><td>pageHeading</td>  <td>".$this->pageHeading."</td></tr>";
            echo "<tr><td>panelHead_1</td>  <td>$this->panelHead_1</td></tr>";
            echo "<tr><td>panelContent_1</td><td>$this->panelContent_1</td></tr>";
            echo "<tr><td>panelHead_2</td>  <td>$this->panelHead_2</td></tr>";
            echo "<tr><td>panelContent_2</td><td>$this->panelContent_2</td></tr>";
            echo "<tr><td>panelHead_3</td>  <td>$this->panelHead_3</td></tr>";
            echo "<tr><td>panelContent_3</td><td>$this->panelContent_3</td></tr>";
            echo "<tr><td></td><td>         </td></tr>";
            echo "<tr><td></td><td>         </td></tr>";
            echo '</table>';
            echo '<p><hr>';
        echo '</div>';
    }//END METHOD:  getDiagnosticInfo()
} //end CLASS

