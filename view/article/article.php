<p><a href="index.php">Retour à la page d'acceuil</a></p>
<div>
    <?php if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) {

        if($article['author_id'] == $_SESSION['id']) { ?>

        <ul>
            <li>
                <a href="index.php?p=article_edition&amp;edit=<?= $article['id'] ?>">Modifier</a>
            </li>
            <li>
                <a href="index.php?p=remove_article&amp;id=<?= $article['id'] ?>">Supprimer</a>
            </li>
        </ul>

    <?php }} ?>
            
    <img src="<?= $currentPicturePath ?>" width=<?= MINIATURES_WIDTH ?>>

    <h3><?= $article['title'] ?></h3>

    <h4>Auteur : <a href="index.php?p=profile&amp;userid=<?= $author['id'] ?>"><?= $author['username'] ?></a></h4>
</div>
<div>
    <p><?= nl2br($article['content']) ?></p>
</div>