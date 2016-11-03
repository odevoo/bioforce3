<?php
session_start();
if (!empty($_POST)) {
  $idBtn = array_keys($_POST['btn']);
  $idProduit = $idBtn[0];
  $quantite = $_POST['quantite'][$idProduit];
  $idClient = $_SESSION['idClient'];
  require_once 'inc/db.php';
  unset($_SESSION['cartupdate']);
  $req = $pdo->prepare('SELECT idProduit, qteProduit FROM panier WHERE idClient = ? AND validePanier = 0');
  $req->execute(array($idClient));
  $listCart = $req->fetchAll();

  foreach ($listCart as $key => $value) {
    if ($idProduit == $value['idProduit']) {
      $quantite += $value['qteProduit'];
      $req = "UPDATE panier SET qteProduit = ? WHERE idProduit = ? AND idClient = ? AND validePanier = 0";
      $stmt = $pdo->prepare($req);
      $stmt->execute(array($quantite, $idProduit, $idClient));
      $_SESSION['cartupdate'] = 'ok';
      header('location: produit.php?cat='.$_POST['cat']);
      exit();
    }

  }

  if (!isset($_SESSION['cartupdate'])) {
    $req = $pdo->prepare('INSERT INTO panier(idClient, idProduit, qteProduit) VALUES(:idClient, :idProduit, :qteProduit)');
    $req->execute(array(':idClient' => $idClient, ':idProduit' => $idProduit, ':qteProduit' => $quantite));
  }



// echo $_SESSION['cartupdate'] ;
  header('location: produit.php?cat='.$_POST['cat']);


}


?>
