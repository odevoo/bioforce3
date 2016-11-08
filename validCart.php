<?php
session_start();
require_once 'inc/functions.php';
require_once 'inc/db.php';

if(!empty($_POST)) {
  $req1 = 'SELECT * FROM panier WHERE idClient = ? AND validePanier = 0';
  $stmt1 = $pdo->prepare($req1);
  $stmt1->execute(array($_SESSION['idClient']));
  $cart = $stmt1->fetchAll();
  if ($cart) {
    $req = 'UPDATE panier SET validePanier = 1 WHERE idClient = ? AND validePanier = 0';
    $stmt = $pdo->prepare($req);
    $stmt->execute(array($_SESSION['idClient']));
    $_SESSION['flash']['success'] = "Votre commande a été validée";
    header('Location: cart.php');
  } else {
    $_SESSION['flash']['danger'] = "Votre panier est vide";
    header('Location: cart.php');
  }

}
