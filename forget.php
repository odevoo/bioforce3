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
    // session_start();
    $reset_token = str_random(60);
    $pdo->prepare('UPDATE clients SET token = ?, lost = 1 WHERE idClient = ?')->execute([$reset_token, $user['idClient']]);
    ////////////////////////////////////////////////
    require 'inc/phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.orange.fr;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'emmanuel.landry@wanadoo.fr';                 // SMTP username
    $mail->Password = 'Agoria78';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('emmanuel.landry@gmail.com', 'BioForce3');
    $mail->addAddress("{$user['emailClient']}");     // Add a recipient
            // Name is optional


    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Reset du password';
    $mail->Body    = "http://localhost/bioforce3/reset.php?id={$user['idClient']}&token=$reset_token";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent';
    }
    ////////////////////////////////////////////////
    // mail($_POST['email'], "Reinitialisation de votre mot de passe', 'Afin de reinitialiser votre mot de passe, merci de cliquer sur ce lien \n\nhttp://localhost/espacemenbre/reset.php?id={$user->id}&token=$reset_token");
    $_SESSION['flash']['success'] = 'Un email contenant un lien pour changer votre mot de passe vous a été envoyé';
    header('location: index.php');
    exit();
  }else {
    $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet e-mail';
  }
}

?>

<?php require "inc/header.php";

?>

<?php
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

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
