<?php
session_start();

echo "<pre>";
print_r($_POST);
echo "</pre>";

require 'inc/phpmailer/PHPMailerAutoload.php';


$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.orange.fr;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'emmanuel.landry@wanadoo.fr';                 // SMTP username
$mail->Password = 'Agoria78';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;
// Enable TLS encryption, `ssl` also accepted                                      // TCP port to connect to

$mail->setFrom('emmanuel.landry@wanadoo.fr', 'BioForce3');
$mail->addAddress("emmanuel.landry@gmail.com");     // Add a recipient{$user['emailClient']}
// Name is optional


$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Un message provenant de bioforce3';
$mail->Body    = "<html><head><style>{color:blue;}</style></head><body><h1>Message de :{$_POST['email']}</h1><br><br>{$_POST['msg']}</body></html>";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
  echo 'Message could not be sent.';
  echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent';
}
////////////////////////////////////////////////
// mail($_POST['email'], "Reinitialisation de votre mot de passe', 'Afin de reinitialiser votre mot de passe, merci de cliquer sur ce lien \n\nhttp://localhost/espacemenbre/reset.php?id={$user->id}&token=$reset_token");
$_SESSION['flash']['success'] = 'Votre message a été evnoyé';
header('location: index.php');
exit();




?>
