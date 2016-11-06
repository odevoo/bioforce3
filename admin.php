

<?php
$titrePage = "Bioforce3 - Admin";
session_start();

require_once 'inc/header.php';
require_once 'inc/functions.php';
require_once 'inc/db.php';
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
    <input type="file" name="file" value="" class="form-control"  />
  </div>

  <button type="submit" class="btn btn-primary" >Ajouter</button>
</form>



<?php require_once 'inc/footer.php'; ?>
