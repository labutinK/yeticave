<form class="form form--add-lot container <? if($errors) echo 'form--invalid' ?>" action="/add.php" method="post" enctype="multipart/form-data">
    <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <? if($errors['lot-title']) echo 'form__item--invalid'; ?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot-title" placeholder="Введите наименование лота" value="<?=filter_input(INPUT_POST, 'lot-title');?>">
            <? if($errors['lot-title']):?>
                <span class="form__error"><?=$errors['lot-title'];?></span>
            <?endif;?>
        </div>
        <div class="form__item <? if($errors['category_id']) echo 'form__item--invalid'; ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category_id">
                <option value="0">Выберите категорию</option>
                <?php foreach ($categories as $cat): ?>
                    <option <? if($cat['id'] == filter_input(INPUT_POST, 'category_id')) echo 'selected';?> value="<?= $cat['id']; ?>"><?= $cat['name_category']; ?></option>
                <?php endforeach; ?>
            </select>
            <? if($errors['category_id']):?>
            <span class="form__error"><?=$errors['category_id'];?></span>
            <?endif;?>
        </div>
    </div>
    <div class="form__item form__item--wide <? if($errors['lot_description']) echo 'form__item--invalid'; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="lot_description" placeholder="Напишите описание лота"><?=filter_input(INPUT_POST, 'lot_description');?></textarea>
        <? if($errors['lot_description']):?>
            <span class="form__error"><?=$errors['lot_description'];?></span>
        <?endif;?>
    </div>
    <div class="form__item form__item--file <? if($errors['lot-picture']) echo 'form__item--invalid'; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" name="lot-picture" value="">
            <label for="lot-img">
                Добавить
            </label>
        </div>
        <? if($errors['lot-picture']):?>
            <span class="form__error"><?=$errors['lot-picture'];?></span>
        <?endif;?>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <? if($errors['start_price']) echo 'form__item--invalid'; ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="start_price" placeholder="0" value="<?=filter_input(INPUT_POST, 'start_price');?>">
            <? if($errors['start_price']):?>
                <span class="form__error"><?=$errors['start_price'];?></span>
            <?endif;?>
        </div>
        <div class="form__item form__item--small <? if($errors['step']) echo 'form__item--invalid'; ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="step" placeholder="0" value="<?=filter_input(INPUT_POST, 'step');?>">
            <? if($errors['step']):?>
                <span class="form__error"><?=$errors['step'];?></span>
            <?endif;?>
        </div>
        <div class="form__item <? if($errors['date_finish']) echo 'form__item--invalid'; ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="date_finish"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=filter_input(INPUT_POST, 'date_finish');?>">
            <? if($errors['date_finish']):?>
                <span class="form__error"><?=$errors['date_finish'];?></span>
            <?endif;?>
        </div>
    </div>
    <? if($errors): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <? endif;?>
    <button type="submit" class="button">Добавить лот</button>
</form>
