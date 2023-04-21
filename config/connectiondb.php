<?php

function connectionDBlocal(){  
    $host="localhost";
    $username="u254141837_chappiev2";
    $password="Tarsierjojo123!";
    $database="u254141837_ojtabulatev2";
    $con =new mysqli($host, $username,$password, $database );
    if($con->connect_error){
       echo $con->connect_error;
    }else{
        return $con;
    }
} 
function connectionDBlocal1(){  
$host="localhost";
$username="root";
$password="";
$database="ojtabulatev2";
$con =new mysqli($host, $username,$password, $database );
if($con->connect_error){
    echo $con->connect_error;
}else{
     return $con;
 }
 echo $con;
} 


?>