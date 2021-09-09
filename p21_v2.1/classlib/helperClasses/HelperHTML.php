<?php

/** 
 * Class: Helper class for regular HTML generation such as html tables
 * 
 * Automates some common HTML generating tasks
 * 
 **/
Class HelperHTML {
    
    
    
   
    public static function generateTABLE($resultSet){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table='';  //start with an empty string
        
        if($resultSet){ //check that a valid resultset has been passed to this method
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table class="table table-striped">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $value){
                $table.=  "<td>$value</td>";
                }
            $table.=  '</tr>';
        }
        $table.=  '</table>';
        }
        else{
            $table='Sorry - there is no data available matching your query at this time';
        }
        return $table;
    }
    
    public static function generateCHAT($resultSet,$userID){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $text='<div class="container-fluid" style="background-color:darkblue">';  //set up the target div
        $text.=  "</br>";
        if($resultSet){ //check that a valid resultset has been passed to this method

        $resultSet->data_seek(0);  //point to the first row in the result set

        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            
            if($row['SenderID']===$userID){  //current user sent the message
                $from = '<b><font color="green">From Me :</font></b>' ;
                $to='<b><font color="gray">To:'.$row['Recipient'].'</font></b> ';
                //$text.= '<b><font color="green">From Me :</font></b> ';
                //$text.= '<b><font color="red">To '.$row['Recipient'].':</font> </b> ';
            }
            else if($row['Recipient']===$userID){ //current user is the intended resipient
                $to = '<b><font color="green">To:Me</font></b>' ;
                $from='<b><font color="red">'.$row['UserName'].'</font></b> ';
                
                //$text.= '<b><font color="green">To Me :</font></b> ';
                //$text.= '<b><font color="red">'.$row['UserName'].':</font> </b> ';

                }
            else{
//                $text.= '<b><font color="gray">From:'.$row['UserName'].':</font> </b> ';
//                $text.= '<b><font color="gray">->To:ALL :</font></b> ';
                $to='<b><font color="gray">To All</font></b> ';
                $from=$row['UserName'];
                
                
            }
            $text.= '<font color="gray">'.$row['Sent'].'</font> ';
            
            $text.= $from;
            $text.= $to;
            $text.= '</br><font color="white">'.$row['Message_Content'].'</em></font>';
            $text.=  "</br>";
            }
        }
        else{
            $text='No live chat data available at this time';
        }
        $text.=  "</br>";
        $text.='</div></div>';
        return $text;
    }    
    
    public static function generateSelectTABLE($resultSet,$selectKeyField,$pageID,$buttonText){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table='';  //start with an empty string
        
        if($resultSet){ //check that a valid resultset has been passed to this method
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table class="table table-striped">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table.=  "<th>Select</th>";
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $key=>$value){  //generate the data columns
                $table.=  "<td>$value</td>";
                }
            foreach($row as $key=>$value){ //generate the selector button with the hidden key value
                if ($key==='msgID'){
                    $table.=  "<td>";
                    // "$value</td>";
                    $table.=  '<form action="index.php?pageID='.$pageID.'" method="post">';    
                    $table.=  '<input type="submit" type="button" value="'.$buttonText.'" name="btnRecordSelected">'; 
                    $table.=  '<input type="hidden" value="'.$value.'" name="recordSelected">'; 
                    $table.=  '</form>';    
                    $table.=  '</td>';
                }
                }                
                
                
                
            $table.=  '</tr>';
        }
        $table.=  '</table>';
        }
        else{
            $table='Sorry - there is no data available matching your query at this time';
        }
        return $table;
    }
    
}


