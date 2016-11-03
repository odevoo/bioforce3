<?php
session_start();
if (!empty($_POST)) {
$idBtn = array_keys($_POST['btn']);
$idProduit = $idBtn[0];
$quantite = $_POST['quantite'][$idProduit];
$idClient = $_SESSION['idClient'];
require_once 'inc/db.php';

$req = $pdo->prepare('INSERT INTO panier(idClient, idProduit, qteProduit) VALUES(:idClient, :idProduit, :qteProduit)');
$req->execute(array(':idClient' => $idClient, ':idProduit' => $idProduit, ':qteProduit' => $quantite));

header('location: produit.php?cat='.$_POST['cat']);

echo '<pre>';
print_r($_POST);
echo '<pre>';

}


 ?>
