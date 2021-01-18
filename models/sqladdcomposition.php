<?php
require_once 'sqlparameters.php';
//Déclaration variables
$fileName = $_FILES['file']['name'];
$compositionStyle = $_POST['compositionStyle'] ?? '';
//explode afin de récupérer le titre du fichier sans l'extension
$title = explode('.', $fileName);
try {
    $stmt = $db->prepare('SELECT `title` FROM `compositions`  WHERE `title` LIKE :title');
    if ($stmt->execute(array(':title' => $title[0])) && $row = $stmt->fetch()) {
        //Si le titre de la composition existe déjà en BDD on avertit l'utilisateur
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <p>La composition " <b>' .$title[0]. '</b> " existe déjà, merci de chosir un autre nom.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
    //Si le titre de la composition n'existe pas en BDD
    else{
        //Insertion en BDD : table `categories`
        try {
            $sth = $db->prepare('INSERT INTO `categories` (`title`, `style`) VALUES (:title, :style)');
            $sth->bindValue(':title', $title[0], PDO::PARAM_STR);
            $sth->bindValue(':style', $compositionStyle, PDO::PARAM_STR);
            $sth->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
//Récupération en BDD : id de la compo dans la table `categories`
        try {
            $stmt = $db->prepare('SELECT `id`, `style` FROM `categories`  WHERE `title` LIKE :title');
            if ($stmt->execute(array(':title' => $title[0])) && $row = $stmt->fetch()) {
                $idComposition = $row['id'];
                $compositionStyle = $row['style'];
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
//Insertion en BDD : table `compositions`
        try {
            $sth = $db->prepare('INSERT INTO `compositions` (`title`, `file`, `chords`, `instrumentsUsed`, `id_users`, `id_categories`) VALUES (:title, :file, :chords, :instrumentsUsed, :idUser, :idCategory)');
            $sth->bindValue(':title', $title[0], PDO::PARAM_STR);
            $sth->bindValue(':file', 'uploads/_'. $fileName, PDO::PARAM_STR);
            $sth->bindValue(':chords', $compositionChords, PDO::PARAM_STR);
            $sth->bindValue(':instrumentsUsed', $compositionInstruments, PDO::PARAM_STR);
            $sth->bindValue(':idUser', $id, PDO::PARAM_INT);
            $sth->bindValue(':idCategory', $idComposition, PDO::PARAM_INT);
            $sth->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
//récupération de l'id de la composition grâce au titre afin de rediriger vers la page de la composition
        try {
            $sth = $db->prepare('SELECT `id` FROM `compositions` WHERE `title` = :title');
            $sth->bindValue(':title', $title[0], PDO::PARAM_STR);
            $sth->execute();
            $composition = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Erreur : " . $e->getMessage();
        }
//Stockage de l'id dans une variable $id
        foreach ($composition as $rowInfo){
            $id = $rowInfo['id'];
        }
//Message de retour utilisateur comme quoi la composition a bien été enregistrée avec lien vers la page composition.php
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <p>Votre composition " <a href="composition.php?id=' .$id. '"><i>' .$title[0]. '</i></a> " a bien été enregistrée.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
//Si le titre de la composition n'existe pas en BDD
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}