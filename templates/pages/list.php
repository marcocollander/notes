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
                case 'deleted':
                    echo 'Notatka została usunięta';
                    break;
                case 'edited':
                    echo 'Notatka została zaktualizowana';
                    break;
            }
        }
        ?>
    </div>

    <?php
    $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'title';
        $order = $sort['order'] ?? 'desc';

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 10;
        $currentPage = $page['number'] ?? 1;
        $pages = $page['pages'] ?? 1;
        ?>

    <div>
        <form action="/" method="GET">
            <div class="form form--sorted">
            <div class="form__item">
                <div>Sortuj po:</div>
                <label>Tytule: <input name="sortby" type="radio"
                                      value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
                <label>Dacie: <input name="sortby" type="radio"
                                     value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
            </div>
            <div class="form__item">
                <div>Kierunek sortowania</div>
                <label>Malejąco: <input name="sortorder" type="radio"
                                        value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
                <label>Rosnąco: <input name="sortorder" type="radio"
                                       value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
            </div>
            <div class="form__item">
                <div>Rozmiar paczki</div>
                <label>1 <input name="pagesize" type="radio" value="1" <?php echo $size === 1 ? 'checked' : '' ?> /></label>
                <label>5 <input name="pagesize" type="radio" value="5" <?php echo $size === 5 ? 'checked' : '' ?> /></label>
                <label>10 <input name="pagesize" type="radio" value="10" <?php echo $size === 10 ? 'checked' : '' ?> /></label>
                <label>25 <input name="pagesize" type="radio" value="25" <?php echo $size === 25 ? 'checked' : '' ?> /></label>
            </div>
            </div>
            <input class="btn-note btn-note--return" type="submit" value="Wyślij"/>
        </form>
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
            $title = substr($note['title'], 0, 13);
            ?>
            <tr>
                <td><?php echo (int)$note['id'] ?></td>
                <td title="<?= htmlentities($note['title']) ?>"><?php echo htmlentities($title) . '...' ?></td>
                <td><?php echo htmlentities($date) ?></td>
                <td>
                    <a href="/?action=show&id=<?php echo (int)$note['id'] ?>">
                        <button class="btn-note">Pokaż</button>
                    </a>
                    <a href="/?action=delete&id=<?php echo $note['id'] ?>">
                        <button class="btn-note">Usuń</button>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</article>

