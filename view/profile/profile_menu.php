<a href="index.php">Retour à la page d'acceuil</a>
<h2><?= $user['username'] ?></h2>
<ul>
    <li>
        <h4><a href="index.php?p=profile&amp;&amp;userid=<?= $user['id'] ?>&amp;tab=profile">Profil</a></h4>
    </li>
    <li>
        <h4><a href="index.php?p=profile&amp;userid=<?= $user['id'] ?>&amp;tab=articles">Articles</a></h4>
    </li>
    <li>
        <h4><a href="index.php?p=profile&amp;userid=<?= $user['id'] ?>&amp;tab=settings">Paramètres</a></h4>
    </li>