<?
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/' . $className . '.php';
});
?>
<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>

    <link rel="stylesheet" href="/app/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&family=Source+Sans+Pro:wght@400&display=swap" rel="stylesheet">
</head>

<body>
<?
$arResult = new Api\Classes\DataBase\TableSet();
$arResult = $arResult->selectAllDB();

if (!isset($_GET['all'])) {
    $arResult['ITEMS'] = Api\Classes\DataBase\TableSet::navPages($_GET['page'] ?? 1);
}
?>
<div class="content">
    <section class="content-news">
        <div class="content-news__title">
            <h1>Новости</h1>
        </div>
        <?if (isset($_GET['all'])) {?>
            <a href="<?=$_SERVER['HTTP_REFERER']?>">Свернуть весь список >></a>
        <?}?>
        <div class="news-block">
            <?foreach ($arResult['ITEMS'] as $key => $item):?>
                <div class="list-news">
                    <div class="list-news__items">
                        <div class="list-news__items-head">
                            <div class="news-items__data">
                                <?=$item['DATE']?>
                            </div>
                            <div class="news-items__title">
                                <a href="/view.php?id=<?=$item['ID']?>"><?=$item['NAME']?></a>
                            </div>
                        </div>

                        <div class="news-items__text">
                            <?=$item['PREVIEW_TEXT']?>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
            <div class="news-pagination">
                <div class="news-pagination__title">
                    <h3>Страницы:</h3>
                </div>
                <div class="news-pagination__content">
                    <?for ($i=1; $i <= $arResult['COUNT_PAGES']; $i++):?>
                        <div class="news-pagination__item"><a href="?page=<?=$i?>"><div class="news-nav <?if($_GET['page'] == $i){?> active<?}?>"><?=$i?></div></a></div>
                    <?endfor;?>
                </div>
                <?if (!isset($_GET['all'])) {?>
                    <div class="news-pagination__show-item" data-page-end='<?=$arResult['COUNT_PAGES']?>' data-page="<?=$_GET['page'] ?? 1?>">Показать ещё</div>
                    <a href="?all">Смотреть весь список >></a>
                <?} else {?>
                    <a href="/">Свернуть весь список >></a>
                <?}?>
            </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="app/script.js"></script>

</body>

</html>