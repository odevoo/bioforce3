<?php
session_start();
if (!empty($_POST)) {
  $idBtn = array_keys($_POST['btn']);
  $idProduit = $idBtn[0];
  $quantite = $_POST['quantite'][$idProduit];
  $idClient = $_SESSION['idClient'];
  require_once 'inc/db.php';
  unset($_SESSION['cartupdate']);
  $req = $pdo->prepare('SELECT c.idProduit, c.qteProduit, p.idCategorie FROM panier c JOIN produits p WHERE c.idClient = ? AND c.validePanier = 0');
  $req->execute(array($idClient));
  $listCart = $req->fetchAll();
  foreach ($listCart as $key => $value) {
    if ($idProduit == $value['idProduit']) {
      $quantite += $value['qteProduit'];
      $req = "UPDATE panier SET qteProduit = ? WHERE idProduit = ? AND idClient = ? AND validePanier = 0";
      $stmt = $pdo->prepare($req);
      $stmt->execute(array($quantite, $idProduit, $idClient));
      $_SESSION['cartupdate'] = 'ok';
      header('location: produit.php?cat='.$value['idCategorie']);
      exit();
    }
  }
  if (!isset($_SESSION['cartupdate'])) {
    $req1 = $pdo->prepare('SELECT idCategorie FROM produits WHERE idProduit = ?');
    $req1->execute(array($idProduit));
    $idCat = $req1->fetch();

    $req = $pdo->prepare('INSERT INTO panier(idClient, idProduit, qteProduit) VALUES(:idClient, :idProduit, :qteProduit)');
    $req->execute(array(':idClient' => $idClient, ':idProduit' => $idProduit, ':qteProduit' => $quantite));
    header('location: produit.php?cat='.$idCat['idCategorie']);
  }
// echo $_SESSION['cartupdate'] ;
  // header('location: produit.php?cat='.$_POST['cat']);
}
?>
