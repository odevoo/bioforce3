<?php
require_once 'inc/db.php';
require_once 'inc/functions.php';

debug($_POST);

if(!empty($_POST)){
  session_start();

  $rqProduits = 'SELECT idProduit, libProduit, descProduit, photoProduit, prixProduit FROM produits WHERE idCategorie = ?';
  $req = $pdo->prepare($rqProduits);
  $req->execute(array($_POST['categorie']));
  $listeProduits = $req->fetchAll(PDO::FETCH_ASSOC);
  if ($listeProduits) {
    $_SESSION['flash']['danger'] = 'Cette catégorie comporte des produits, veuillez les supprimer avant de supprimer la categorie';
    header('Location: admin.php');
    exit();
  } else {
    $req = "DELETE FROM categories WHERE idCategorie = ?";
    $stmt = $pdo->prepare($req);
    $stmt->execute(array($_POST['categorie']));
    $_SESSION['flash']['success'] = 'Catégorie supprimée avec succès';
    header('Location: admin.php');

  }

}
