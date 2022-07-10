<div class="container">
    <section class="lots">
        <? if(empty($lots)): ?>
        <h2>Ничего не найдено по вашему запросу</h2>
        <? else:?>
        <h2>Результаты поиска по запросу «<span><?=$q; ?></span>»</h2>
        <? endif; ?>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lot['img']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $lot["name_category"]; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="/lot.php?ID=<?= $lot['id']; ?>"><?= htmlspecialchars($lot["title"]); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= format_price(htmlspecialchars($lot["start_price"])); ?></span>
                            </div>
                            <?php $date_finish = expiration_calc(htmlspecialchars($lot["date_finish"])) ?>
                            <div class="lot__timer timer <?php if ($date_finish['hours'] < 15): ?>timer--finishing<?php endif; ?>">
                                <? echo $date_finish['hours'] . " : " . $date_finish['minutes']; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>

