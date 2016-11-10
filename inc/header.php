
<?php
//Si il n'y a pas de $_SESSION demarrée, on n'en start une
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title><?php echo $titrePage ?></title>

  <!-- Bootstrap core CSS -->
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
  <?php
  if (!isset($_SESSION['css'])) {$_SESSION['css'] = 1;}


  if ($_SESSION['css'] == 2) {
    echo '<link href="css/app2.css" rel="stylesheet">';
  } else if ($_SESSION['css'] == 3){
    echo '<link href="css/app3.css" rel="stylesheet">';
  } else {
    echo '<link href="css/app.css" rel="stylesheet">';
  } ?>
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <?php require_once 'inc/db.php' ?>
  <nav class="navbar navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" >
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">BioForce3</a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <!-- On n'affichie une navbar different en fonction de la présence ou non d'une authentification active -->
          <?php if (isset($_SESSION['auth'])): ?>

            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="register.php"><span class="glyphicon glyphicon-glass"></span> Categorie<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php
                $req = $pdo->query('SELECT idCategorie, libCategorie FROM categories');
                $listCategory = $req->fetchAll(PDO::FETCH_ASSOC);
                foreach ($listCategory as $category) {
                  echo '<li><a href="produit.php?cat='.$category['idCategorie'].'">'.$category['libCategorie'].'</a></li>';
                }
                ?>
              </ul>
            </li>
            <li> <a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"> </span> Panier <?php
            require_once 'inc/db.php';
            $req = $pdo->query('SELECT COUNT(idProduit) FROM panier WHERE idClient = '.$_SESSION['idClient'].' AND validePanier = 0');
            $nbrArticle = $req->fetchColumn(0);
            echo '<span class="label label-danger label-as-badge">'.$nbrArticle.'</span>';

            ?></a></li>
            <li><a href="contact.php"><span class='glyphicon glyphicon-envelope'></span> Contact</a></li>
            <li><a href="admin.php"><span class='glyphicon glyphicon-cog'></span> Admin</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Se deconnecter</a></li>
          <?php else: ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="register.php"><span class="glyphicon glyphicon-glass"></span> Categorie <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php
                $req = $pdo->query('SELECT idCategorie, libCategorie FROM categories');
                $listCategory = $req->fetchAll(PDO::FETCH_ASSOC);
                foreach ($listCategory as $category) {
                  echo '<li><a href="produit.php?cat='.$category['idCategorie'].'">'.$category['libCategorie'].'</a></li>';
                }
                ?>
              </ul>
            </li>

            <li><a href="register.php"><span class='glyphicon glyphicon-user'></span> S'inscrire</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-off"></span> Se connecter</a></li>
            <li><a href="contact.php"><span class='glyphicon glyphicon-envelope'></span> Contact</a></li>
          <?php endif; ?>
        </ul>
        <form class="navbar-form navbar-right" action="produit.php" method="post">
          <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Produit" id="inputSearch" required>
          </div>
          <button type="submit" class="btn btn-primary" id="btnSearch">Rechercher</button>
        </form>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <div class="container">


    <!-- AFFICHAGE DES MSG DE LA VARIABLE SESSION -->

    <?php if (isset($_SESSION['flash'])): ?>
      <?php foreach ($_SESSION['flash'] as $type => $message): ?>

        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>

      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
    <?php endif ?>
