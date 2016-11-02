<?php $titrePage = "Accueil BioForce3" ?>
<?php require 'inc/header.php' ?>


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
