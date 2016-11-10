<?php
$titrePage = "BioFroce3 - Panier";
require 'inc/header.php';
require 'inc/functions.php';
require_once 'inc/db.php';
$req = "SELECT p.idProduit, p.qteProduit, a.libProduit, a.prixProduit FROM panier p JOIN produits a ON a.idProduit = p.idProduit WHERE p.idClient = :idClient AND p.validePanier = 0 ORDER BY a.idCategorie ASC, p.idProduit ASC";
$stmt = $pdo->prepare($req);
$stmt->execute(array('idClient' => $_SESSION['idClient']));
$panierClient = $stmt->fetchAll(PDO::FETCH_ASSOC);
$serial = serialize($panierClient);
file_put_contents('monfichier.txt', $serial);
echo "<h1>Panier</h1>";

// echo "<pre>";
// print_r($panierClient);
// echo "</pre>";
// echo $panierClient[0]['libProduit'];
echo '<table class="table table-striped">
        <thead>
        <tr>
          <th>Designation</th>
          <th>Quantité</th>
          <th class="text-right">Prix</th>
          <th class="text-right">Prix total</th>
          <th class="text-center">Action</th>
        </tr></thead><tbody>';
$total = 0;
foreach ($panierClient as $key => $value) {
  echo "<tr>";
  echo '<td>'.$panierClient[$key]['libProduit'].'</td>';
  echo '<td class="text-center"><form method="post" action="updatecart.php"><input type="hidden" name="produit" value="'.$panierClient[$key]['idProduit'].'"><input type="number" min="0" name="quantite" value="'.$panierClient[$key]['qteProduit'].'"><input type="submit" name="btnSub" value="Modifier" class="btn btn-xs btn-primary"></form></td>';
  echo '<td class="text-right">'.number_format($panierClient[$key]['prixProduit'], 2, ',', ' ').' €</td>';
  echo '<td class="text-right">'.number_format(($panierClient[$key]['prixProduit'] * $panierClient[$key]['qteProduit']), 2, ',', ' ').' €</td>';
  echo '<td class="text-center"><form method="post" action="deletecart.php"><input type="hidden" name="produit" value="'.$panierClient[$key]['idProduit'].'"><input type="submit" name="btnSub" value="Supprimer" class="btn btn-xs btn-danger"></form></td>';
  echo "</tr>";
  $total += $panierClient[$key]['prixProduit'] * $panierClient[$key]['qteProduit'];
}
echo "</tbody>";
echo "</tfoot>";
echo "<tr>";
echo '<td colspan="3"><strong> Prix total </strong></td>';
echo '<td colspan ="2"><strong>'.number_format($total, 2, ',', ' ').' €</strong></td>';
echo "</tr>";
echo "</tfoot></table>";

?>

<form action="/your-charge-code" method="POST" id="payment-form">
  <span class="payment-errors"></span>

  <div class="form-row">
    <label>
      <span>Card Number</span>
      <input type="text" size="20" data-stripe="number">
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>Expiration (MM/YY)</span>
      <input type="text" size="2" data-stripe="exp_month">
    </label>
    <span> / </span>
    <input type="text" size="2" data-stripe="exp_year">
  </div>

  <div class="form-row">
    <label>
      <span>CVC</span>
      <input type="text" size="4" data-stripe="cvc">
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>Billing Zip</span>
      <input type="text" size="6" data-stripe="address_zip">
    </label>
  </div>

  <input type="submit" class="submit" value="Submit Payment">
</form>

<?php
echo '<form method="post" action="validCart.php"><div class="form-group text-center"><button type="submit" name="btnSub" class="btn btn-primary">Valider ma commande</button></div></form>';

require 'inc/footer.php'
?>
