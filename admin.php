

<?php
$titrePage = "Bioforce3 - Admin";
session_start();

require 'inc/header.php';
require_once 'inc/functions.php';
require_once 'inc/db.php';
?>
<h1>Catégories actuelles</h1>


<?php
$req = $pdo->query('SELECT idCategorie, libCategorie FROM categories');
$listCategory = $req->fetchAll(PDO::FETCH_ASSOC);
echo '<table class="table table-striped"><thead><tr><th>Libele</th><th>Suppression</th></tr></thead><tbody>';
foreach ($listCategory as $category) {
  $cat = $category['idCategorie'];
  echo '<tr><td value="'.$cat.'">'.$category['libCategorie'].'</td><td><form method="post" action="deleteCat.php"><input type="hidden" name="categorie" value="'.$category['idCategorie'].'"/><input type="submit" name="btnSupp" value="Supprimer" class="btn  btn-xs btn-danger"/></form></td></tr>';
}
echo "</tbody></table>";
?>

<h1>Ajouter une catégorie</h1>

<form class="" action="addCat.php" method="post">
  <div class="form-group">
    <input type="text" name="cat" class="form-control" value="">
  </div>
  <div class="form-group">
    <button type="submit" name="btnSub" class="btn btn-primary">Créer categorie</button>
  </div>
</form>


<h1>Produits actuels</h1>

<?php
$rqProduits = 'SELECT idProduit, libProduit, idCategorie, descProduit, photoProduit, prixProduit FROM produits';
$req = $pdo->prepare($rqProduits);
$req->execute();
$listeProduits = $req->fetchAll(PDO::FETCH_ASSOC);

echo '<table class="table table-striped"><thead><tr><th>Libele</th><th>Modification</th><th>Suppression</th></tr></thead><tbody>';
foreach ($listeProduits as $produit) {

  echo '<tr>
  <td>'.$produit['libProduit'].'</td>
  <td><form method="post" action="modifProd.php">
  <input type="hidden" name="categorie" value="'.$produit['idCategorie'].'"/>
  <input type="submit" name="btnSupp" value="Modifier" class="btn  btn-xs btn-warning"/>
  </form>
  </td>
  <td>
  <form method="post" action="deleteProd.php">
  <input type="hidden" name="categorie" value="'.$produit['idProduit'].'"/>
  <input type="submit" name="btnSupp" value="Supprimer" class="btn  btn-xs btn-danger"/>
  </form>
  </td>
  </tr>';
}
echo "</tbody></table>";

?>



<h1>Ajouter un produit</h1>
<form class="" action="addProduct.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="">Libélé du produit</label>
    <input type="text" name="lib" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Déscription du produit</label>
    <textarea type="text" name="desProd" value="" row="20" class="form-control"></textarea>
  </div>
  <div class="form-group">
    <label for="">Prix</label>
    <input type="text" name="price" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Catégorie</label>
    <select class="form-control" name="cat" required>
      <option disabled selected>Selectionnez une catégorie</option>
      <?php
      $req = $pdo->query('SELECT idCategorie, libCategorie FROM categories');
      $listCategory = $req->fetchAll(PDO::FETCH_ASSOC);
      foreach ($listCategory as $category) {
        $cat = $category['idCategorie'];
        echo '<option value="'.$cat.'">'.$category['libCategorie'].'</option>';
      }
      ?>

    </select>
  </div>
  <div class="form-group">
    <label for="">Image du produit</label>
    <input type="file" name="file" value="" class="input-file form-control"  />
  </div>

  <button type="submit" class="btn btn-primary" >Ajouter</button>
</form>



<?php require_once 'inc/footer.php'; ?>
