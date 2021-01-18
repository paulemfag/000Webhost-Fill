<?php
//Si la variable Get 'page' n'est pas définie.
if (!filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT)){
    //On redirige vers la page 1
    header('location:?page=1');
    exit();
}

//Si la page demandée est inférieure à la première page
if ($_GET['page'] < 1){
    header('location:?page=1');
    exit();
}
//Si la page demandée est supérieure à la dernière page
if ($_GET['page'] > $pages && $pages > 1){
    echo 'test';
    //On redirige vers la dernière page
    header('location:?page=1');
    exit();
}
$title = 'Fill | Messagerie';
require_once 'require/header.php';
require_once '../models/sqlmessageriePagination.php'; 
if($_GET['success'] === '1'){
    echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="far fa-check-circle"></i> Le message " <strong>'. $_GET['objet'] .'</strong> " à bien été supprimé.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
}
?>

<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto"><i class="fas fa-mail-bulk"></i> Messagerie :</h1>
    <a href="newmessage.php" type="submit" class="btn btn-success mr-auto ml-auto col-10" style="button">Envoyer un message</a>
</div>
<div class="container mt-2">
    <div class="row" style="justify-content: center;">
<?php //Pagination si il n'y a pas qu'une seule page
if ($pages > 1) : ?>
        <nav class="col-md-12 mt-2 d-flex justify-content-center">
            <ul class="pagination custom-pagination">
                <?php //Si on ne se trouve pas sur la première page.
                if ($page != 1) : ?>
                    <li class="page-item"><a class="page-link" href="messagerie.php?page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                    <li class="page-item"><a class="page-link" href="messagerie.php?page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
                <?php endif; ?>
                <li>
                    <select class="form-control" onchange="location = this.value;">
                        <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                            <option value="messagerie.php?page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                        <option value="messagerie.php?page=<?= $page ?>" disabled selected><?= $page ?></option>
                        <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                            <option value="messagerie.php?page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </li>
                <?php //Si on ne se trouve pas sur la dernière page.
                if ($pages != $page) : ?>
                    <li class="page-item"><a class="page-link" href="messagerie.php?page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                    <li class="page-item"><a class="page-link" href="messagerie.php?page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
    </div>
</div>
<div class="container">
    <?php require_once '../models/sqlmessagerie.php'; ?>
</div>
<div class="container mt-2">
    <div class="row" style="justify-content: center;">
        <?php //Pagination si il n'y a pas qu'une seule page
        if ($pages > 1) : ?>
            <nav class="col-md-12 mt-2 d-flex justify-content-center">
                <ul class="pagination custom-pagination">
                    <?php //Si on ne se trouve pas sur la première page.
                    if ($page != 1) : ?>
                        <li class="page-item"><a class="page-link" href="messagerie.php?page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                        <li class="page-item"><a class="page-link" href="messagerie.php?page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
                    <?php endif; ?>
                    <li>
                        <select class="form-control" onchange="location = this.value;">
                            <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                                <option value="messagerie.php?page=<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                            <option value="messagerie.php?page=<?= $page ?>" disabled selected><?= $page ?></option>
                            <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                                <option value="messagerie.php?page=<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </li>
                    <?php //Si on ne se trouve pas sur la dernière page.
                    if ($pages != $page) : ?>
                        <li class="page-item"><a class="page-link" href="messagerie.php?page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                        <li class="page-item"><a class="page-link" href="messagerie.php?page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
<?php require_once 'require/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
