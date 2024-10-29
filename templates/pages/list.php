<h2 class="section__heading">Lista notatek</h2>
<article class="section__page section__page--list">
    <div class="message">
        <?php
        if (!empty($params['error'])) {
            switch ($params['error']) {
                case 'missingNoteId':
                    echo 'Niepoprawny identyfikator notatki';
                    break;
                case 'noteNotFound':
                    echo 'Notatka nie została znaleziona';
                    break;
            }
        }
        ?>
    </div>
    <div class="message">
        <?php
        if (!empty($params['before'])) {
            switch ($params['before']) {
                case 'created':
                    echo 'Notatka zostało utworzona';
                    break;
            }
        }
        ?>
    </div>

    <table class="table">
        <thead class="table__head">
        <tr>
            <th>Id</th>
            <th>Tytuł</th>
            <th>Data</th>
            <th>Opcje</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($params['notes'] ?? [] as $note) : ?>
            <?php
            $date = substr($note['created'], 0, 10);
            $title = substr($note['title'], 0, 10);
            ?>
            <tr>
                <td><?php echo (int)$note['id'] ?></td>
                <td title="<?= htmlentities($note['title'])?>"><?php echo htmlentities($title) . '...' ?></td>
                <td><?php echo htmlentities($date) ?></td>
                <td>
                    <a href="/?action=show&id=<?php echo (int)$note['id'] ?>">
                        <button class="btn-note">Pokaż</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</article>

