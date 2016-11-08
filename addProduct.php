<?php
session_start();
require_once 'inc/functions.php';
require_once'inc/db.php';

if (!empty($_POST)) {
  debug($_POST);
  debug($_FILES);
  $lib = $_POST['lib'];
  $des = $_POST['desProd'];
  $price = $_POST['price'];
  $cat = $_POST['cat'];
  $filename = $_FILES['file']['name'];

  $path = "img/{$filename}";
  $move = move_uploaded_file($_FILES['file']['tmp_name'], $path);
  if ($move) {
    $req = $pdo->prepare('INSERT INTO produits SET descProduit = ?, idCategorie = ?, libProduit = ?, photoProduit = ?, prixProduit = ?');
    $req->execute([$des, $cat, $lib, $filename, $price]);
    $_SESSION['flash']['success'] = 'Produit ajouté avec succès';
    header('location: admin.php');
    exit();
  }else {
    $_SESSION['flash']['danger'] = "Vous n'avez pas rempli tous les champs";
    header('location: admin.php');
  }

}
