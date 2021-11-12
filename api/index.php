<?php
header('Content-Type: application/json');
try {
    $db = new PDO("sqlite:".__DIR__."/bdd_villes.sqlite3");
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $return["sucess"] =true;
     $return["message"] ='Connexion okay';
 }   catch (Exception $e) {
    $return["sucess"] =false;
    $return["message"] ='Connexion impossible';
     exit;
 }
 
 $req = $db->prepare("SELECT * FROM villes");
 $req->execute();

 if( !empty($_GET['ville']) ){
    echo $_GET['ville'];
	$req = $db->prepare("SELECT * FROM `villes` WHERE `nom` LIKE :ville");
	$req->bindParam(':ville', $_GET['ville']);
} else {
    $req = $db->prepare("SELECT * FROM villes");
}

$req->execute();
$return["result"]["villes"] = $req->fetchAll();

 echo json_encode($return);