<?php
// SI LA VARIABLE $_SESSION COMPORTE DES INFORMATIONS ON EFFECTUE LES OPERATIONS SUIVANTES
if (!empty($_POST) && !empty($_POST['email'])) {
  require_once "inc/db.php";
  require_once 'inc/functions.php';
  session_start();
  $req = $pdo->prepare('SELECT * FROM clients WHERE emailClient = ?');
  $req->execute([$_POST['email']]);
  $user = $req->fetch();
  if ($user) {
    session_start();
    $reset_token = str_random(60);
    $pdo->prepare('UPDATE clients SET token = ? WHERE idClient = ?')->execute([$reset_token, $user['id']]);
    // mail($_POST['email'], "Reinitialisation de votre mot de passe', 'Afin de reinitialiser votre mot de passe, merci de cliquer sur ce lien \n\nhttp://localhost/espacemenbre/reset.php?id={$user->id}&token=$reset_token");
    // $_SESSION['flash']['success'] = 'Un email contenant un lien pour changer votre mot de passe vous a été envoyé';
    header('location: account.php');
    exit();
  }else {
    $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet e-mail';
  }
}

 ?>

<?php require "inc/header.php";

?>

<h1>Mot de passe oublié</h1>

<form class="" action="" method="post">
  <div class="form-group">
    <label for="">Email</label>
    <input type="email" name="email" value="" class="form-control"  />
  </div>
  <button type="submit" class="btn btn-primary" >Réinitialiser mon mot de passe</button>
</form>


<?php require "inc/footer.php" ?>
