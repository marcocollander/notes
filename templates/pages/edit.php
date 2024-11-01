<h2 class="section__heading">Edycja notatki</h2>
<article class="section__page">
    <?php if (!empty($params['note'])) : ?>
        <?php $note = $params['note']; ?>
        <form class="form" action="/?action=edit" method="post">
            <input name="id" type="hidden" value="<?php echo $note['id'] ?>"/>
            <ul class="form__list">
                <li class="form__list-item">
                    <label for="title">Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="" value="<?= $note['title'] ?>"/>
                </li>
                <li class="form__list-item">
                    <label for="textarea">Treść</label>
                    <textarea name="description" id="textarea" rows="15" cols="35"><?= $note['description']
                        ?></textarea>
                </li>
                <li class="form__list-item">
                    <input type="submit" value="Submit"/>
                </li>
            </ul>
        </form>
    <?php else : ?>
        <div>
            Brak danych do wyświetlenia
            <a href="/">
                <button class="btn-note">Powrót do listy notatek</button>
            </a>
        </div>
    <?php endif; ?>
</article>
