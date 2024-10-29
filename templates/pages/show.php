<h2 class="section__heading">Notatka</h2>

<article class="section__page section__page--note">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
        <ul class="note-items">
            <li>Numer notatki: <?php echo (int) $note['id'] ?></li>
            <li>Tytuł: <?php echo htmlentities($note['title']) ?></li>
            <li>
                <p><?php echo htmlentities($note['description']) ?></p>
            </li>
            <li>Zapisano: <?php echo htmlentities($note['created']) ?></li>
        </ul>
    <?php else : ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="/">
        <button class="btn-note btn-note--return">Powrót do listy notatek</button>
    </a>
</article>
