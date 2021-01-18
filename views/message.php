<?php
//Si la variable Get 'id' n'est pas définie.
if (!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) {
    //On redirige vers la page 1
    header('location:messagerie.php?page=1');
    exit();
}
//Si la page demandée est inférieure à la première page
if ($_GET['id'] < 1) {
    header('location:?page=1');
    exit();
}
require_once '../models/sqlmessage.php';
$title = 'Message | ' .$object;
require_once 'require/header.php';
?>
<div class="container">
    <h1 class="text-center bg-light col-12 opacity mt-2 ml-auto mr-auto"><?= $object ?></h1>
    <a title="Répondre à <?= $pseudo ?>" href="newmessage.php?id=<?= $expeditorId ?>&object=<?= $object ?>" class="col-12 btn btn-primary">Répondre</a>
    <a data-target="#deleteModal" data-toggle="modal" data-target="#deleteModal" title="Supprimer le message | <?= $object ?>" class="col-12 btn btn-danger text-light mt-2">Supprimer le message</a>
    <div class="modal" tabindex="-1" id="deleteModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-dark text-center col-12">Voulez vous vraiment supprimer le message :<br><b>" <?= $object ?> "</b> ?</p>
                    <a title="Annuler la suppression" class="col-6 btn-sm btn-secondary text-center text-light" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</a>
                    <a title="Suprimmer le message" class="col-6 float-right btn-sm btn-danger text-center" href="message.php?id=<?= $_GET['id'] ?>&delete=ok&objet=<?= $object ?>"><i class="fas fa-trash-alt"></i> Spprimer le message <?= $object ?></a>
                </div>
            </div>
        </div>
    </div>
    <p style="border: none;" class="col-8 bg-info mt-2 mb-0 text-light float-left"><?= $sender .', <i>'. $date ?></i></p>
    <textarea style="border: none;" class="col-12 mt-0 bg-info border-transparent text-light" maxlength="" name="message" id="message" wrap="hard" cols="121" rows="4" disabled><?= $message['message'] ?></textarea>
</div>
<?php require_once 'require/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<?php //Si l'utilisateur requiert la suppression du message, affiche la modal de confirmation.
if (filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_NUMBER_INT)): ?>
<?php endif; ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>

