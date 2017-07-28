<h4>
    <a href="index.php?p=article_edition">Nouvel article !</a>
</h4>

<?php if(isset($_SESSION['id'])) {

    if(isset($_GET['connected'])) { ?>

        <p><i>Heureux de vous revoir <?= $_SESSION['username'] ?> !</i></p>  <!-- TO DO : Afficher ce message dans un boite en js. -->

    <?php } ?>

    <ul>
        <li><a href="index.php?p=profile&amp;userid=<?= $_SESSION['id'] ?>"><?= $_SESSION['username'] ?></a></li>
        <li><a href="index.php?p=loging_out">Se déconnecter</a></li>
    </ul>

<?php } else { ?>

    <ul>
        <li><a href="index.php?p=registration">S'inscire</a></li>
        <li><a href="index.php?p=loging_in">Se connecter</a></li>
    </ul>

<?php } ?>