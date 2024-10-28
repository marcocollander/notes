<h2 class="section__heading"> Nowa notatka </h2>
<article class="section__page">
    <form class="form" action="/?action=create" method="post">
        <fieldset class="form__fieldset">
            <legend>Wpisz dane notatki</legend>
            <ul class="form__list">
                <li class="form__list-item">
                    <label for="title">Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="field-long">
                </li>
                <li class="form__list-item">
                    <label for="description">Treść: </label>
                    <textarea name="description" id="description" class="textarea" rows="15">

                    </textarea>
                </li>
                <li class="form__list-item">
                    <input type="submit" value="Submit">
                </li>
            </ul>
        </fieldset>
    </form>
</article>

