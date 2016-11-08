<?php
$titrePage = "Contact - Bioforce3";
require 'inc/header.php';
 ?>

<h1>Nous contacter</h1>

<form class="" action="contact2.php" method="post">
  <div class="form-group">
    <label for="email">Votre adresse email</label>
    <input type="email" name="email" class="form-control" value="" required="">
  </div>
  <div class="form-group">
    <label for="message">Votre message</label>
    <textarea  name="msg" class="form-control" rows="10" required=""></textarea>
  </div>
  <div class="form-group text-center">
    <button class="btn btn-lg btn-primary" type="submit" name="btnSub" value="Envoyer">Envoyer</button>
  </div>
</form>


<?php require 'inc/footer.php' ?>
