<style>
/* 404 */
.erreur_404 {
    min-height: 500px;
    background: url(public/img/banner.avif) center center no-repeat;
    background-size: cover;
}

.erreur_404 div h1,
.erreur_404 div p,
.erreur_404 div a {
    color: var(--white-color);
}

.erreur_404 div {
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.erreur_404 div h1 {
    font-size: 5em;
}

.erreur_404 div p {
    font-size: 1.2em;
    margin-bottom: 15px;
}
</style>

<div class="erreur_404">
    <div>
        <h1>Erreur 404</h1>
        <p>Cette page n'existe pas</p>
        <a href="?url=accueil" class="btn">Revenir à l'accueil</a>
    </div>
</div>