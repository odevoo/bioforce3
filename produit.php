<?php
$titrePage = 'BioFroce3 - Nos produits';
require 'inc/header.php';



////////////////////////////////////////////////
if (!empty($_POST['search'])) {
  require_once 'inc/db.php';
  $search = htmlentities($_POST['search']);
  $rqProduits = "SELECT idProduit, libProduit, descProduit, photoProduit, prixProduit FROM produits WHERE libProduit LIKE '%$search%'";
  $req = $pdo->prepare($rqProduits);
  $req->execute();
  $listeProduits = $req->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($listeProduits[0])) {
    echo '<form class="form-group" method="post" action="addcart.php">
    <div class="row">';
    foreach ($listeProduits as $index => $produit) {

      echo '<div class="panel panel-default panelprod col-md-4"><div class="panel-body text-center">';
      echo '<h3 class="text-center">'.$produit['libProduit'].'</h3>';
      echo '<img class="img-responsive picprod" src="img/'.$produit['photoProduit'].'">';
      echo "<p>".$produit['descProduit'].'</p>';
      echo '<p class="text-center"><strong>'.$produit['prixProduit'].'</strong></p>';
      if (isset($_SESSION['auth'])) {
        echo '<input class="form-control" type="number" min="0" name="quantite['.$produit['idProduit'].']" placeholder="Quantite"/>
        <button value="commander" class="btn btn-primary btn-cmd form-control" type="submit" name="btn['.$produit['idProduit'].']">Commander</button>';
      } else {
        echo '<p class="text-center alert alert-danger"> Vous devez vous authentifier pour commander</p>';
      }
      echo "</div></div>";
      if (($index + 1) % 3 == 0 && $index !=0) {
        echo '</div><div class="row">';
      }

    }
    echo "</div></form>";

    exit();
  }else {
    $_SESSION['flash']['danger'] = "Aucun produit ne correspond à votre recherche";
    header('Location: index.php');
    exit();
  }



}








//////////////////////////////////////////////////



$idCategorie = htmlentities(strip_tags($_GET['cat']));

$req = $pdo->prepare('SELECT libCategorie FROM categories WHERE idCategorie = :idCategorie');
$req->execute(array(':idCategorie' => $idCategorie ));
$libCategorie = $req->fetchColumn();

echo "<h1>".$libCategorie.'</h1>';





$rqProduits = 'SELECT idProduit, libProduit, descProduit, photoProduit, prixProduit FROM produits WHERE idCategorie = ?';
$req = $pdo->prepare($rqProduits);
$req->execute(array($idCategorie));
$listeProduits = $req->fetchAll(PDO::FETCH_ASSOC);
// $_SESSION['auth'] = 'OK';
// echo "<pre>";
// print_r($listeProduits);
// echo '</pre>';

echo '<form class="form-group" method="post" action="addcart.php">
<input type="hidden" name="cat" value="'.$idCategorie.'"/>
<div class="row">';
foreach ($listeProduits as $index => $produit) {

  echo '<div class="panel panel-default panelprod col-md-4"><div class="panel-body text-center">';
  echo '<h3 class="text-center">'.$produit['libProduit'].'</h3>';
  echo '<img class="img-responsive picprod" src="img/'.$produit['photoProduit'].'">';
  echo "<p>".$produit['descProduit'].'</p>';
  echo '<p class="text-center"><strong>'.$produit['prixProduit'].'</strong></p>';
  if (isset($_SESSION['auth'])) {
    echo '<input class="form-control" type="number" min="0" name="quantite['.$produit['idProduit'].']" placeholder="Quantite"/>
    <button value="commander" class="btn btn-primary btn-cmd form-control" type="submit" name="btn['.$produit['idProduit'].']">Commander</button>';
  } else {
    echo '<p class="text-center alert alert-danger"> Vous devez vous authentifier pour commander</p>';
  }
  echo "</div></div>";
  if (($index + 1) % 3 == 0 && $index !=0) {
    echo '</div><div class="row">';
  }

}
echo "</div></form>";


?>



<?php

require 'inc/footer.php';

?>
