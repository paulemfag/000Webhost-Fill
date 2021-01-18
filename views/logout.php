<?php
//Quand on se déconnecte (bouton 'me déconnecter' dans le menu)
session_start();
//Détruit toutes les données enregistrées dans la session
session_destroy();
//redirige vers la page index.php
header('Location:../index.php');
exit();