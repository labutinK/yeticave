<form class="form container <?php if (!empty($errors)) echo 'form--invalid'; ?>" method="post" autocomplete="off">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item  <? if ($errors['email']) echo 'form__item--invalid'; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $_POST['email']; ?>">
        <span class="form__error"><?= $errors['email']; ?></span>
    </div>
    <div class="form__item  <? if ($errors['password']) echo 'form__item--invalid'; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль"
               value="<?= $_POST['password']; ?>">
        <span class="form__error"><?= $errors['password']; ?></span>
    </div>
    <div class="form__item <? if ($errors['name']) echo 'form__item--invalid'; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $_POST['name']; ?>">
        <? if ($errors['name']): ?>
            <span class="form__error"><?= $errors['name']; ?></span>
        <? endif; ?>
    </div>
    <div class="form__item <? if ($errors['message']) echo 'form__item--invalid'; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message"
                  placeholder="Напишите как с вами связаться"><?= $_POST['message']; ?></textarea>
        <span class="form__error"><?= $errors['message']; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
