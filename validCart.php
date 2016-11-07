<?php
session_start();
require_once 'inc/functions.php';
require_once 'inc/db.php';

if(!empty($_POST)) {
 $req = 'UPDATE panier SET validePanier = 1 WHERE idClient = ? AND validePanier = 0';
  $stmt = $pdo->prepare($req);
  $stmt->execute(array($_SESSION['idClient']));
  $_SESSION['flash']['success'] = "Votre commande a été validée";
  header('Location: cart.php');
}
