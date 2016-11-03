<?php $titrePage = "Accueil BioForce3" ?>
<?php require 'inc/header.php' ?>

<?php
if (!empty($_POST)) {
  $errors =  array();
  // VALIDATION DU USERNAME
  if (empty($_POST['name']) || !preg_match('/^[a-zA-Z]+$/', $_POST['name'])) {
    $errors['name'] = "Votre nom n'est pas valide";
  } else {
    $name = $_POST['name'];
    }
  }
  //VALIDATION DU PRENOM

  if (empty($_POST['firstname']) || !preg_match('/^[a-zA-Z]+$/', $_POST['firstname'])) {
    $errors['firstname'] = "Votre prénom n'est pas valide";
  } else {
    $firstname = $_POST['firstname'];
    }

//VALIDATION DE LA VILLE

if (empty($_POST['city']) || !preg_match('/^[a-zA-Z]+$/', $_POST['city'])) {
  $errors['city'] = "Votre Ville n'est pas valide";
} else {
  $city = $_POST['city'];
  }

  //VALIDATION DE CODE POSTALE



  //VALIDATION DE L'EMAIL

  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Votre email n'est pas valide";
  }else {
    $req = $pdo->prepare('SELECT idClient FROM clients WHERE emailClient = ?');
    $req->execute([$_POST['email']]);
    $email = $req->fetch();
    if ($email) {
      $errors['email'] = "Cet email est déjà associé à un compte";
    }
  }
 //VALIDATION DU PASSWORD
  if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
    $errors['password'] = "Votre mot de passe n'est pas valide";
  }

  if (empty($errors)) {

    $req = $pdo->prepare('INSERT INTO clients SET nomClient = ?, prenomClient = ?, PassClient = ?, adresseClient = ?, cpClient = ?, villeClient = ?, emailClient= ?');
    // HASSHAGE DU PASSWORD
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    // CREATION DU TOKEN DE 60 CARACTERE
    // $token = str_random(60);
    $req->execute([$_POST['name'], $_POST['firstname'], $password, $_POST['address'], $_POST['zip'], $_POST['city'], $_POST['email']]);
    //RECUPERATION DU DERNIER ID DE LA BASE
    $user_id = $pdo->lastInsertId();
    //ENVOI DU MAIL DE CONFIRMATION
    // mail($_POST['email'], "Confirmation de votre compte', 'Afin de valider votre compte, merci de cliquer sur ce lien \n\nhttp://localhost/espacemenbre/confirm.php?id=$user_id&token=$token");
    // $_SESSION['flash']['success'] = 'un email de confirmation vous a été envoyé';
    header('location: index.php');
    exit();
    // die('<div class="alert alert-success text-center"><p>Votre compte à bien été créé</p></div>');
  }





?>

<form class="" action="" method="post">
  <div class="form-group">
    <label for="">Nom</label>
    <input type="text" name="name" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Prénom</label>
    <input type="text" name="firstname" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Adresse</label>
    <input type="text" name="address" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Code postal</label>
    <input type="number" name="zip" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Ville</label>
    <input type="text" name="city" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Email</label>
    <input type="email" name="email" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Mot de passe</label>
    <input type="password" name="password" value="" class="form-control"  />
  </div>
  <div class="form-group">
    <label for="">Confirmer votre mot de passe</label>
    <input type="password" name="password_confirm" value="" class="form-control"  />
  </div>
  <button type="submit" class="btn btn-primary" >M'inscire</button>
</form>

<?php require 'inc/footer.php' ?>
