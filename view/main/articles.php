<li>
    <h3>
        <a href="index.php?p=article&amp;id=<?= $article['id'] ?>">
        <?= $article['title'] ?></a>
    </h3>

    <i>Publié le <?= $article['date_time_publication'] ?> par <a href="index.php?p=profile&amp;userid=<?= $article['author_id'] ?>"><?= $author['username'] ?>.</a><br>
    <?php if(!is_null($article['date_time_update'])) { ?>
        Dernière modification le <?= $article['date_time_update'] ?><br>
    <?php } ?></i><br>

    <img src="<?= $currentPicturePath ?>" width="200">

    <p><?= $contentPart ?>
    <?php if($contentPart != $article['content']) { echo '...'; } ?><br><i><a href="index.php?p=article&amp;id=<?= $article['id'] ?>">Lire la suite</a></i></p>

    <?php if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email']) AND $article['author_id'] == $_SESSION['id']) { ?>

        <p>
            <a href="index.php?p=article_edition&amp;edit=<?= $article['id'] ?>">Modifier | </a>
            <a href="index.php?p=remove_article&amp;id=<?= $article['id'] ?>">Supprimer</a>
        </p>
                        
    <?php } ?>
</li>