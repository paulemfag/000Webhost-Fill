<?php
try {
    $sth = $db->prepare('SELECT `title` FROM `topics` WHERE `title` = :subject');
    $sth->bindValue(':subject', $subject, PDO::PARAM_STR);
    $sth->execute();
    $topicExist = $sth->fetchAll(PDO::FETCH_ASSOC);
    if ($topicExist){
        $errors['subject'] = '<i class="fas fa-exclamation-triangle"></i> Le sujet ' .$subject. ' exitste déjà.';
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}