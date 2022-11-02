<?php
	require "inc/config.inc.php";
	require "inc/link.inc.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="author" content="Averin Matvey Romanovich">
  <meta name="keywords" content="web-shop,web,shop">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <title>Мой интернет-магазин на PHP</title>
</head>
<body>
    <header>
        <?php require "header.php";?>
    </header>
    <main>
        <div class="catalog">
            <?php
                $list = getListCategories();
                if($list === false) {echo "ERROR!"; exit;}
                if(!count($list)) {echo "EMPTY!"; exit;}
            ?>
            <?php require "header_text.php"; ?>
            <div class="catalog__container-row">
                <?php
                foreach($list as $item): ?>
                    <div class="catalog__container-category">
                        <div class="catalog__container-category-image">
                            <a href="category_products.php?cat_id=<?=$item['id_category']?>&page=1"><img src="<?php echo LOGO_LOCATION?><?=$item['category_image']?>" alt="Иконка <?=$item['category_name']?>" title="<?=clearStr(substr($item['description'],0,50)) . "..."?>"></a>
                            <div class="catalog__container-category-bottom">
                                <div class="catalog__container-category-name">
                                    <?=$item['category_name']?>
                                </div>
                                <div class="catalog__container-category-count">
                                   Товаров: <?=$item['count_products']?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <footer>
        <?php require "footer.php";?>
    </footer>
<script src="js/script.js"></script>
</body>
</html>