<style>
/* Navbar */
nav {
    position: sticky;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    background: var(--primary-color);
}

nav ul {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

nav ul li a {
    display: block;
    padding: 15px 25px;
    color: var(--white-color);
    font-weight: bold;
}

nav ul li:first-child {
    position: absolute;
    left: 15px;
}

nav ul li:last-child {
    position: absolute;
    right: 15px;
}
</style>

<nav>
    <ul>
        <li>
            <a href="?url=accueil">WebSiteMaker 1.0
            </a>
        </li>
        <li>
            <a href="?url=services">Services</a>
        </li>
        <?php if(empty($_SESSION["user"])) : ?>
        <li>
            <a href="?url=inscription">Inscription</a>
        </li>
        <li>
            <a href="?url=connexion">Connexion</a>
        </li>
        <?php else : ?>
        <li>
            <a href="?url=profil">Profil</a>
        </li>
        <li>
            <a href="?url=deconnexion">Deconnexion</a>
        </li>
        <?php endif; ?>
        <li>
            <a href="?url=contact">Contact</a>
        </li>
    </ul>
</nav>