<?php
require_once 'inc/db.php';
require_once 'inc/functions.php';

if(!empty($_POST)){
  session_start();
  $req1= 'SELECT photoProduit FROM produits WHERE idProduit = ?';
  $stmt1 = $pdo->prepare($req1);
  $stmt1->execute(array($_POST['categorie']));
  $result = $stmt1->fetch();
  $photo = $result['photoProduit'];
  $filename = "img/{$photo}";
  unlink($filename);
  $req = "DELETE FROM produits WHERE idProduit = ?";
  $stmt = $pdo->prepare($req);
  $stmt->execute(array($_POST['categorie']));
  $_SESSION['flash']['success'] = 'Produit supprimé avec succès';
  header('Location: admin.php');
}
