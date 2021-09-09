<?php
/**
 * 
 * Class: Base class for Table Entities
 * 
 * @author Gerry Guinane
 * 
 */
class TableEntity {
    
protected $db;
private $tableName;
    
/**
 * 
 * @param type $databaseConnection
 * @param type $tableName
 * 
 */
function __construct ($databaseConnection,$tableName){
    $this->tableName=$tableName;
    $this->db=$databaseConnection;
}    

//table entity methods

/**
 * 
 * @return mysqli_result if TRUE or boolean FALSE
 * 
 */
public function select_all(){
    $sql = "SELECT * FROM  $this->tableName";  //valid query
    if(@$rs=$this->db->query($sql)){  //execute query and check resultset has been returned 
        return $rs;  //Static methods can be called directly - without creating an instance of the class first.
        $rs->free();
    }
    else{  //something went wrong with the SQL query execution 
        return false;  
    }
}


//getters
/**
 * 
 * @return string $this->tableName name of this table entity
 * @access public
 * 
 */
public function get_table_name(){
    return $this->tableName;
}    
    

//METHOD:    getDiagnosticInfo()
/**
 * This is a placeholder for future diagnostics
 *
 */
 public function getDiagnosticInfo(){      
        echo '<!-- TABLE ENTITY CLASS PROPERTY SECTION  -->';
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV

            echo '<h3>TABLE ENTITY CLASS (CLASS) properties</h3>';
            echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';                        
            echo "<tr><td>Entity Table Name</td>   <td>$this->tableName</td></tr>";
            echo '</table>';
            echo '<p><hr>';
        echo '</div>';            
        echo '<!-- END TABLE ENTITY CLASS PROPERTY SECTION  -->';

}   
//END METHOD: getDiagnosticInfo()

    
}
