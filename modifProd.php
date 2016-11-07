<?php
$titrePage = 'Modification de produit';
require_once 'inc/db.php';
require 'inc/header.php';
require_once 'inc/functions.php';

if (!empty($_POST['btnMod'])) {

  $lib = $_POST['lib'];
  $des = $_POST['desProd'];
  $price = $_POST['price'];
  $cat = $_POST['cat'];
  $idProduit = $_POST['idProd'];

  if (!empty($_FILES['file']['name'])) {
    unlink($_SESSION['photomod']);
    $filename = $_FILES['file']['name'];

    $path = "img/{$filename}";
    $move = move_uploaded_file($_FILES['file']['tmp_name'], $path);
    if ($move) {
      $req = $pdo->prepare('UPDATE produits SET descProduit = ?, idCategorie = ?, libProduit = ?, photoProduit = ?, prixProduit = ? WHERE idProduit = ?');
      $req->execute([$des, $cat, $lib, $filename, $price, $idProduit]);
      $_SESSION['flash']['success'] = 'Produit modifié avec succès';
      header('location: admin.php');
      exit();
    }

  } else {
    $req = $pdo->prepare('UPDATE produits SET descProduit = ?, idCategorie = ?, libProduit = ?, prixProduit = ? WHERE idProduit = ?');
    $req->execute([$des, $cat, $lib, $price, $idProduit]);
    $_SESSION['flash']['success'] = 'Produit modifié avec succès';
    header('location: admin.php');
    exit();
  }
}

$req = 'SELECT * FROM produits WHERE idProduit = ?';
$stmt = $pdo->prepare($req);
$stmt->execute(array($_POST['categorie']));
$prod = $stmt->fetch();

$photo = $prod['photoProduit'];
$_SESSION['photomod'] = "img/{$photo}";


?>
<h1>Modification du produit</h1>
<form class="" action="" method="post" enctype="multipart/form-data">
  <?php echo '<input type="hidden" name="idProd" value="'.$_POST['categorie'].'">'?>
  <div class="form-group">
    <label for="">Libélé du produit</label><?php
    echo '<input type="text" name="lib" value="'.$prod["libProduit"].'" class="form-control"  />'?>
  </div>
  <div class="form-group">
    <label for="">Déscription du produit</label>
    <?php echo '<input type="text" name="desProd" value="'.$prod["descProduit"].'" row="20" class="form-control"></input>'?>
  </div>
  <div class="form-group">
    <label for="">Prix</label>
    <?php echo '<input type="text" name="price" value="'.$prod['prixProduit'].'" class="form-control"  />'?>
  </div>
  <div class="form-group">
    <label for="">Catégorie</label>
    <select class="form-control" name="cat" required>
      <option disabled>Selectionnez une catégorie</option>
      <?php
      $req = $pdo->query('SELECT idCategorie, libCategorie FROM categories');
      $listCategory = $req->fetchAll(PDO::FETCH_ASSOC);
      foreach ($listCategory as $category) {
        $cat = $category['idCategorie'];
        if ($cat == $_POST['categorie']) {
          echo '<option selected value="'.$cat.'">'.$category['libCategorie'].'</option>';
        }else {
          echo '<option value="'.$cat.'">'.$category['libCategorie'].'</option>';
        }

      }
      ?>

    </select>
  </div>
  <div class="form-group">
    <label for="">Image du produit</label>
    <input type="file" name="file" value="" class="input-file form-control"  />
  </div>

  <button type="submit" value="mod" name="btnMod" class="btn btn-primary" >Modifier</button>
</form>


<?php
require 'inc/footer.php';
?>
