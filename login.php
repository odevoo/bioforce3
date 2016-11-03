<?php
$titrePage = "BioForce3 Login";
require_once 'inc/functions.php';
reconnect_from_cookie();

if (isset($_SESSION['auth'])) {
  header('location: account.php');
  exit();
}

// SI LA VARIABLE $_SESSION COMPORTE DES INFORMATIONS ON EFFECTUE LES OPERATIONS SUIVANTES
if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
  require_once "inc/db.php";


  $req = $pdo->prepare('SELECT * FROM clients WHERE emailClient = :email');
  $req->execute(['email' => $_POST['email']]);
  $user = $req->fetch();
  if (password_verify($_POST['password'], $user['PassClient'])) {

    $_SESSION['auth'] = $user;
    // echo '<pre>';
    // print_r($_SESSION['auth']);
    // echo '</pre>';
    $_SESSION['nom'] = $user['nomClient'];
    $_SESSION['prenom'] = $user['prenomClient'];
    $_SESSION['idClient'] = $user['idClient'];

    $_SESSION['flash']['success'] = 'Vous êtes connecté';
    // if ($_POST['remember']) {
    //   $remember_token = str_random(250);
    //   $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
    //   setcookie('remember', $user->id.'=='.$remenber_token.sha1($user->id.'clesecurisee'), time() + 60 * 60 * 24 * 7);
    // }
    header('location: index.php');
    exit();
  }else {
    $_SESSION['flash']['danger'] = 'identifiant ou mot de passe incorrecte';
  }
}

?>

<?php require "inc/header.php";

?>

<h1>Se connecter</h1>

<form class="" action="" method="post">
  <div class="form-group">
    <label for="">Email</label>
    <input type="email" name="email" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Mot de passe <a href="forget.php">J'ai oublié mon mot de passe</a></label>
    <input type="password" name="password" value="" class="form-control"  />
  </div>
  <!-- <div class="form-group">
  <label>
  <input type="checkbox" name="remember" value="1">Se souvenir de moi
</label>
</div> -->
<button type="submit" class="btn btn-primary" >Se connecter</button>
</form>


<?php require "inc/footer.php" ?>
