<?php

if(!empty($_POST)) {
  session_start();
  require 'inc/db.php';
  $req = 'INSERT INTO categories SET libCategorie = ?';
  $stmt = $pdo->prepare($req);
  $stmt->execute(array($_POST['cat']));
  $_SESSION['flash']['success'] = 'Catégorie ajoutée avec succès';
  header('Location: admin.php');

}
