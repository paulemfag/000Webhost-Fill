<?php
if (isset ($deleteStatus)){
    sleep(2);
    header('location:mypage.php');
    exit();
}
$title = 'Fill | Ma page';
require_once 'require/header.php';
//Si l'utilisateur est un particulier et qu'il n'est pas administrateur.
if($_SESSION['accounttype'] === 'particular' && $_SESSION['role'] === '0'){
    header('location:https://filldemo.000webhostapp.com/views/accueil.php');
   /* exit();*/
}
require_once '../models/sqlmypage.php';
//Message d'alerte en cas de suppression de composition.
echo $deleteStatus ?? '';
?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto"><?= $_SESSION['pseudo'] ?> | Informations personnelles :</h1>
</div>
<!-- container -->
<div class="container bg-light opacity">
    <div class="row">
        <div class="col-12">
            <p><i class="fas fa-address-card"></i><b> Biographie :</b><br><br>
                <?= $biography ?? '' ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p><i class="fas fa-drum"></i><b> Instruments :</b><br><br>
                <?= $instruments ?? '' ?>
            </p>
        </div>
        <div class="col-6">
            <p><i class="fas fa-compact-disc"></i><b> Logiciel :</b><br><br>
                <?= $software ?? '' ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a><i class="fas fa-network-wired"></i><b> Réseaux :</b></a>
            <a title="Profil Facebook de <?= $pseudo ?>" rel="noopener" target="_blank" href="<?= $facebookId ?? '#' ?>"><img
                        src="../assets/img/facebook-logo.png" width="80" height="60" alt="logo_facebook"></a>
            <a title="Profil Twitter de <?= $pseudo ?>" rel="noopener" target="_blank" href="<?= $twitterId ?? '#' ?>"><img
                        src="../assets/img/logo_twitter.png" width="80" height="60" alt="logo_twitter"></a>
            <a title="Modifier mes informations personnelles" class="btn btn-outline-primary float-right mt-3" href="personalInformationsUpdate.php"><i class="far fa-id-card"></i> Modifier mes informations personnelles</a>
        </div>
    </div>
</div>
<div id="compositions" class="container mt-2">
    <div class="row playlistTable text-center">
        <a style="color:  #034f84;" class="col-3 compositionsTablesTextColor float-left"><i class="fas fa-music"></i><b> Composition :</b></a>
        <a style="color:  #034f84;" class="col-2 float-left"><b>Style :</b></a>
        <a style="color:  #034f84;" class="col-5 float-left"><b>Fichier :</b></a>
        <a style="color:  #034f84;" class="col-2"><b>Supprimer :</b></a>
        <?php foreach ($compositionsList as $composition) {
            //récupération du titre sans l'extension de fichier (array)
            $compositionTitle = explode('.', $composition['title']);
            $file = $composition['file'];
            echo '<a style="color:  #034f84;" title="Page composition ' .$compositionTitle[0]. '" href="composition.php?id=' .$composition['id']. '" class="col-3 text-dark">' . $compositionTitle[0] . '</a>' . '
<a title="Page style ' .$composition['style']. '" href="stylePage.php?style=' .$composition['style']. '" class="col-2 text-dark">' .$composition['style']. '</a>
<audio style="height: 20px;" class="float-right col-5" controls>
            <source src="' . $file . '" preload="auto" controls type="audio/mp3">
            </audio>
            <a data-target="#exampleModal" title="Suprimmer la composition : ' .$compositionTitle[0]. '" class="col-1 ml-auto mr-auto btn-sm btn-outline-danger text-center" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-trash-alt"></i></a>
        <div class="modal" tabindex="-1" id="exampleModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-dark text-center col-12">Voulez vous vraiment supprimer la composition :<br><b>" ' .$compositionTitle[0]. ' " </b>?</p>
                        <a title="Annuler la suppression" class="col-5 ml-auto mr-auto btn-sm btn-secondary text-center text-light" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</a>
                        <a title="Suprimmer la composition : ' .$compositionTitle[0]. '" class="col-5 ml-auto mr-auto btn-sm btn-danger text-center" href="?idcomposition=' .$composition['id']. '"><i class="fas fa-trash-alt"></i> Spprimer la composition</a>              
                    </div>
                </div>
            </div>
        </div>';
        } ?>
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
</div>
</html>
