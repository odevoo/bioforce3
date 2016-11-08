<?php

if(!empty($_POST['cat'])) {
  session_start();
  require 'inc/db.php';
  $req = 'INSERT INTO categories SET libCategorie = ?';
  $stmt = $pdo->prepare($req);
  $stmt->execute(array($_POST['cat']));
  $_SESSION['flash']['success'] = 'Catégorie ajoutée avec succès';
  header('Location: admin.php');

} else {
  session_start();
  $_SESSION['flash']['danger'] = "Vous n'avez pas rempli tous les champs";
  header('Location: admin.php');
}
