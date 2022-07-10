USE
yeticave;

INSERT INTO categories (character_code, name_category)
VALUES ('boards', 'Доски и лыжи'),
       ('attachment', 'Крепления'),
       ('boots', 'Ботинки'),
       ('clothing', 'Одежда'),
       ('tools', 'Инструменты'),
       ('other', 'Разное');

INSERT INTO users (email, user_name, user_password, contacts)
VALUES ('vasya09@mail.ru', 'vasya-bo$$', 'vasya-secret', '894343234'),
       ('petya29@mail.ru', 'petya-loh', 'petya-wow', '894376575');

INSERT INTO lots
(title, lot_description, img, start_price, date_finish, step, user_id, category_id)
VALUES ('2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке',
        'img/lot-1.jpg', 10999, '2022-06-10', 500, 1, 1),
       ('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке',
        'img/lot-2.jpg', 159999, '2022-05-20', 1000, 2, 1),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 'Хорошие крепления, надежные и легкие', 'img/lot-3.jpg',
        8000, '2022-06-12', 500, 2, 2),
       ('Ботинки для сноуборда DC Mutiny Charocal', 'Теплые и красивые ботинки', 'img/lot-4.jpg', 10999, '2022-06-13',
        600, 1, 3),
       ('Куртка для сноуборда DC Mutiny Charocal', 'Легкая, теплая и прочная куртка', 'img/lot-5.jpg', 7500,
        '2022-06-14', 500, 1, 4),
       ('Маска Oakley Canopy', 'Желтые очки, все будет веселенькое', 'img/lot-6.jpg', 5400, '2022-05-23', 100, 1, 6);

INSERT INTO bets (price_bet, user_id, lot_id)
VALUES (11000, 1, 1),
       (12000, 2, 1);

--Получаем все категории
select *
from categories;

--Получаем открытые лоты, в каждом получаем название, стартовую цену, ссылку на изображение, название категории
select title, start_price, img, c.name_category, date_finish
FROM lots l
         JOIN categories c ON c.id = l.category_id
WHERE l.date_finish > NOW()
ORDER BY l.date_creation DESC;

--Показываем лот по его ID и получаем название категории, к которой принадлежит лот
SELECT lots.title, lots.lot_description, categories.name_category
FROM lots
         JOIN categories ON lots.category_id = categories.id
WHERE lots.id = 1;

UPDATE lots
SET title = 'Маска Супер'
WHERE id = 6;

--Получаем список ставок для лота по его идентификатору с сортировкой по дате, начиная с самой последней
SELECT bets.date_bet,
       bets.price_bet AS 'Цена ставки', lots.title AS 'Название лота', users.user_name AS 'Имя пользователя'
FROM bets
         JOIN lots ON bets.lot_id = lots.id
         JOIN users ON bets.user_id = users.id
WHERE lots.id = 1
ORDER BY bets.date_bet DESC;




