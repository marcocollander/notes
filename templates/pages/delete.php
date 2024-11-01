<article class="section__page section__page--note">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
        <ul class="note-items">
            <li class="note-items__item">Id: <?php echo $note['id'] ?></li>
            <li class="note-items__item">Tytuł: <?php echo $note['title'] ?></li>
            <li class="note-items__item">
                <pre><?php echo $note['description'] ?></pre>
            </li>
            <li class="note-items__item">Zapisano: <?php echo $note['created'] ?></li>
        </ul>
        <form class="form form--delete" method="POST" action="/?action=delete">
            <input name="id" type="hidden" value="<?php echo $note['id'] ?>" />
            <input class="btn-note btn-note--return" type="submit" value="Usuń" />
        </form>
    <?php else : ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="/">
        <button class="btn-note btn-note--return">Powrót do listy notatek</button>
    </a>
</article>
