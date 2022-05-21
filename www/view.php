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

    <link rel="stylesheet" href="app/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&family=Source+Sans+Pro:wght@400&display=swap" rel="stylesheet">
</head>

<body>
<?
$arResult = new Api\Classes\DataBase\TableSet();
$arResult = $arResult->detailNews($_GET['id']);
?>
<div class="content">
    <section class="content-news">
        <div class="content-news__title">
            <h1><?=$arResult['title'];?></h1>
        </div>
            <div class="list-news">
                <div class="list-news__items">
                    <div class="news-items__text">
                        <?=$arResult['content'];?>
                    </div>
                </div>
            </div>
        <a href="/" ><div class="news-pagination__title">Все новости >></div></a>
    </section>
</div>

</body>

</html>