<h4>
    <a href="index.php?p=article_edition">Nouvel article !</a>
</h4>

<ul>
    <?php while($article = $request->fetch()) { 

        $contentPart = substr($article['content'], 0, 150); 
        $currentPicturePath = ARTICLES_MINIATURES_PATH . $article['id'] . '.jpg'; ?>

    <li>
        <h3>
            <a href="index.php?p=article&amp;id=<?= $article['id'] ?>">
            <?= $article['title'] ?></a>
        </h3>

        <?php if($article['published']) { ?>

            <i>Publié le <?= $article['date_time_publication'] ?><br>
                <?php if(!is_null($article['date_time_update'])) { ?>
                Dernière modification le <?= $article['date_time_update'] ?><br>
                <?php } ?>
            </i><br>

        <?php } else { ?>

            <i>Non publié pour l'instant.<br>
                <a href="index.php?p=profile&amp;userid=<?= $_GET['userid'] ?>&amp;publish=<?= $article['id'] ?>">Publier</a>
            </i><br>

        <?php } ?>

        <img src="<?= $currentPicturePath ?>" width="<?= MINIATURES_WIDTH ?>">

        <p><?= $contentPart ?><?php if($contentPart != $article['content']) { echo '...'; } ?><br /><i><a href="index.php?p=article&amp;id=<?= $article['id'] ?>">Lire la suite</a></i></p>

        <?php if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email']) AND $article['author_id'] == $_SESSION['id']) { ?>

            <p>
                <a href="index.php?p=article_edition&amp;edit=<?= $article['id'] ?>">Modifier | </a>
                <a href="index.php?p=remove_article&amp;id=<?= $article['id'] ?>">Supprimer</a>
            </p>

        <?php } ?>
    </li>
    <?php } ?>
</ul> 