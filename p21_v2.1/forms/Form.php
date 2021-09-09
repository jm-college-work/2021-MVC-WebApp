<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author Gerry
 */
class Form {
    //put your code here
    
public static function form_login($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">ID</label><input required type="text" class="form-control" id="userID" name="userID" >';
        $form.='<label for="password">Password</label><input required type="password" class="form-control" id="password" name="password" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnLogin">Login</button>';
        $form.='</form>';
        return $form;
}    

public static function form_password_change($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="pass1">Enter New Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enter New Password</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='<label for="password">Enter OLD Password</label><input required type="password" class="form-control" id="password" name="password" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnChangePW">Change Password</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdatePW" value="updatePWCancel">Cancel</button>';
        $form.='</form>';
        return $form;
} 


public static function form_edit_account($countyTable,$userRecord, $pageID){
        $countyList=array();
        $i=1;  //array index
        if($rs=$countyTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $countyList[$i]=$row['countyName'];   //build an array of county names $countyList
                $i++;
            }
        } 
        
        $userRecordArray=$userRecord->fetch_assoc();
        extract($userRecordArray); 
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="ID">ID</label><input required readonly type="text" class="form-control"   value="'.$ID.'" id="ID" name="ID" pattern="[a-zA-Z0-9]{5,10}" title="ID (5 to 10 Characters) - Enter Characters A-Z,a-z and/or numbers 0-9">';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control"  value="'.$FirstName.'" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control"   value="'.$LastName.'" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';
        $form.='<label for="county">county</label>';
        $form.='<select class="form-control" id="county" name="county">';
          $form.= '<option value="'.$idcounty.'">'.$countyList[$idcounty].'</option>'; //the displayed value should be the current value in database
          foreach($countyList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  //drop down list of all counties
          }
        $form.='</select>';
        $form.='<label for="email">email</label><input type="text" class="form-control" value="'.$email.'" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" value="'.$mobile.'" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';

        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnUpdateAccount" value="update">Update</button>';
        $form.='</form>';
        
        return $form;
    }



public static function form_register($countyTable,$pageID){
        $countyList=array();
        $i=1;  //array index
        if($rs=$countyTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $countyList[$i]=$row['countyName'];   //build an array of county names $countyList
                $i++;
            }
        } 
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="ID">ID</label><input required type="text" class="form-control" id="ID" name="ID" pattern="[a-zA-Z0-9]{5,10}" title="ID (5 to 10 Characters) - Enter Characters A-Z,a-z and/or numbers 0-9">';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';
        $form.='<label for="county">county</label>';
        $form.='<select class="form-control" id="county" name="county">';
          foreach($countyList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';
        $form.='<label for="email">email</label><input type="text" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';
        $form.='<label for="pass1">Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enterPassword</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnRegister" value="registerLecturer">Register</button>';
        $form.='</form>';
        
        return $form;
    }
    
    
public static function form_add_msg($pageID){
        $form='<div class="container-fluid">';
        $form.='<form method="post" action="index.php?pageID='.$pageID.'">';

        $form.='<div class="form-group">';
        
        $form.='<label for="message">Enter a Message</label><textarea class="form-control" id="message" name="message" rows="3" style="resize:vertical"></textarea> ';
                
        $form.='<label for="msgTo">Addressed To (enter ID or leave blank for ALL)</label><input type="text" class="form-control" id="msgTo" name="msgTo" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnAddMsg">Submit Message</button>';
        $form.='</form>';
        $form.='</div>';
        return $form;
}      

   


}
