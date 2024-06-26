<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>

        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--<?= $category['character_code']; ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= $category['name_category'] ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($goods as $good): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $good['img']; ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $good["name_category"]; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="/lot.php?ID=<?= $good['id']; ?>"><?= htmlspecialchars($good["title"]); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price(htmlspecialchars($good["start_price"])); ?></span>
                        </div>
                        <?php $res = expiration_calc(htmlspecialchars($good["date_finish"])) ?>
                        <div class="lot__timer timer <?php if ($res['hours'] < 15): ?>timer--finishing<?php endif; ?>">
                            <? echo $res['hours'] . " : " . $res['minutes']; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
