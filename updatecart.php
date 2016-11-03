<?php
session_start();
require_once 'inc/db.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";

if (!empty($_POST)) {
$idProduit = $_POST['produit'];
$idClient = $_SESSION['idClient'];
$req = "UPDATE panier WHERE idProduit = ? AND idClient = ? AND validePanier = 0";
$stmt = $pdo->prepare($req);
$stmt->execute(array($idProduit, $idClient));



}
header('location: cart.php');



 ?>
