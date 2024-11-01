<h2 class="section__heading">Notatka</h2>

<article class="section__page section__page--note">
    <?php $note = $params['note'] ?? null ?>
    <?php if ($note): ?>
        <ul class="note-items">
            <li class="note-items__item">Numer notatki: <?= (int)$note['id'] ?></li>
            <li class="note-items__item">Tytuł: <?= htmlentities($note['title']) ?></li>
            <li class="note-items__item">
                <p><?= htmlentities($note['description']) ?></p>
            </li>
            <li class="note-items__item">Zapisano: <?= htmlentities($note['created']) ?></li>
        </ul>
        <a href="/?action=edit&id=<?= $note['id'] ?>">
            <button class="btn-note btn-note--return">Edytuj</button>
        </a>
    <?php else: ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif ?>
    <a href="/">
        <button class="btn-note btn-note--return">Powrót do listy notatek</button>
    </a>
</article>
