<?php
require_once '../models/sqltopicPagination.php';
require_once '../controllers/form_validation.php';
require_once '../models/sqltopic.php'; 
$title = 'Forum | '. $publicationsList[0]['title'];
require_once 'require/header.php';?>
<div class="container">
    <div class="row bg-light mt-2 opacity">
        <a class="col-2" id="returnArrow" title="Fill | Forum" href="forum.php?page=1"><i class="fas fa-home" style="font-size: 50px;"></i></a>
        <h1 class="col-10"><?= $publicationsList[0]['title'] ?></h1>
    </div>
    <?php if ($topics['id_users'] === $_SESSION['id']): ?>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-danger text-light col-12 mt-2" data-toggle="modal" data-target="#deleteTopicModal">Supprimer le sujet</button>
        <!-- Modal -->
        <div class="modal fade" id="deleteTopicModal" tabindex="-1" role="dialog" aria-labelledby="deleteTopicModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Voulez vous vraiment supprimer ce topic ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <a title="Supprimer le sujet | <?= $publicationsList[0]['title'] ?>" href="?id=<?= $_GET['id'] ?>&page=<?= $_GET['page'] ?>&delete=1" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <form class="mt-3" action="#" method="post" novalidate>
        <div class="form-group">
            <label class="text-light" for="message">Poster un message :</label>
            <span class="text-danger float-right"><?= $errors['message'] ?? '' ?></span>
            <textarea style="resize: none; border: none;" maxlength="500" name="message" id="message" cols="121" rows="5" placeholder="Veuillez saisir un message"><?= $message ?></textarea>
        </div>
        <div class="captcha">
            <div
                class="g-recaptcha"
                data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
                style="display: inline-block;">
            </div>
        </div>
        <div class="form-group">
            <input name="topicMessageSubmit" id="topicMessageSubmit" class="btn btn-outline-success col-12" type="submit" value="Poster le message">
        </div>
    </form>
    <?php //Pagination si il n'y a pas qu'une seule page
    if ($pages > 1) : ?>
        <nav class="col-md-12 mt-2 d-flex justify-content-center">
            <ul class="pagination custom-pagination">
                <?php //Si on ne se trouve pas sur la première page.
                if ($page != 1) : ?>
                    <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                    <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
                <?php endif; ?>
                <li>
                    <select class="form-control" onchange="location = this.value;">
                        <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                            <option value="topic.php?id=<?= $_GET['id'] ?>&page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                        <option value="forum.php?page=<?= $page ?>" disabled selected><?= $page ?></option>
                        <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                            <option value="topic.php?id=<?= $_GET['id'] ?>&page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </li>
                <?php //Si on ne se trouve pas sur la dernière page.
                if ($pages != $page) : ?>
                    <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                    <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php foreach ($publicationsList AS $publication): ?>
    <div class="card mt-2" style="border: none;">
        <div class="card-body compositionsTables">
            <p class="card-text"><i><?= $linkToCompositorProfile ?? $publication['pseudo'] ?>, <?= $publication['published_at'] .' :' ?></i></p>
            <p class="card-text"><?= $publication['message'] ?></p>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php //Pagination si il n'y a pas qu'une seule page
if ($pages > 1) : ?>
    <nav class="col-md-12 mt-2 d-flex justify-content-center">
        <ul class="pagination custom-pagination">
            <?php //Si on ne se trouve pas sur la première page.
            if ($page != 1) : ?>
                <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
            <?php endif; ?>
            <li>
                <select class="form-control" onchange="location = this.value;">
                    <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                        <option value="topic.php?id=<?= $_GET['id'] ?>&page=<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                    <option value="forum.php?page=<?= $page ?>" disabled selected><?= $page ?></option>
                    <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                        <option value="topic.php?id=<?= $_GET['id'] ?>&page=<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </li>
            <?php //Si on ne se trouve pas sur la dernière page.
            if ($pages != $page) : ?>
                <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                <li class="page-item"><a class="page-link" href="topic.php?id=<?= $_GET['id'] ?>&page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif;
require_once 'require/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../vendor/mervick/emojionearea/dist/emojionearea.min.js"></script>
<script src="../assets/js/topic_min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>