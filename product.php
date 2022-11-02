<?php
require "inc/config.inc.php";
require "inc/link.inc.php";
?>

<?php
if(empty($_GET) && htmlspecialchars($_SERVER['PHP_SELF']) != MAIN_PAGE) {
    header("Location: " . MAIN_PAGE);
    exit;
}
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
    <link rel="stylesheet" href="css/style_product2.css">
    <!-- Подключение css-файла для зумирования изображений-->
    <link rel="stylesheet" href="css/magnify.css">
    <!-- Подключение Noty для уведомлений -->
    <link rel="stylesheet" href="css/jquery.noty.css">
    <!-- Подключение jQuery через CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Мой интернет-магазин на PHP</title>
</head>
<body>
    <header>
        <?php require "header.php"; ?>
    </header>
    <main>
        <div class="layout">
            <div class="product">
                <!-- Картинки -->
                <div class="product__images">
                    <div class="product__images-list">
                        <?php
                        $product_main = getMainCategoryPreviewPictureProduct(clearInt($_GET['id']));
                        if($product_main === false) {echo "ERROR!"; exit;}
                        if(!count($product_main)) {echo header("Location: " . ERROR_404_PATH); exit;}

                        $product_else_categories = getElseCategoriesProduct(clearInt($_GET['id']));
                        if($product_else_categories === false) {echo "ERROR!"; exit;}

                        $product_else_pictures = getElsePicturesProduct(clearInt($_GET['id']));
                        if($product_else_pictures === false) {echo "ERROR!"; exit;}
                        ?>

                        <?php
                        if(!isset($_GET['cat_name'])) {
                            header("Location: " . ERROR_404_PATH);
                            exit;
                        } else {
                            if(!clearStr($_GET['cat_name']) || clearInt($_GET['cat_name'])) {
                                header("Location: " . ERROR_404_PATH);
                                exit;
                            }

                            $count_identity = count($product_main) + count($product_else_categories);
                            if($_GET['cat_name'] != $product_main[0]['main_category'])
                                $count_identity--;

                            if(!count($product_else_categories)) {
                                foreach($product_else_categories as $category) {
                                    if($_GET['cat_name'] != $category['dlc_category'])
                                        $count_identity--;
                                }
                            }

                            if($count_identity == 0) {
                                header("Location: " . ERROR_404_PATH);
                                exit;
                            }
                        }

                        if(!isset($_GET['id'])) {
                            header("Location: " . ERROR_404_PATH);
                            exit;
                        } else {
                            if(!clearInt($_GET['id'])) {
                                header("Location: " . ERROR_404_PATH);
                                exit;
                            }

                            if($_GET['id'] <= 0) {
                                header("Location: " . ERROR_404_PATH);
                                exit;
                            }
                        }
                        ?>

                        <?=
                            '<div class="product__image product__image--size">
                                <img id="img1" class="product__image-zoom product__image--size" src="' . IMG_LOCATION . '/' . $product_main[0]['main_category'] . '/' . $product_main[0]['main_picture'] . '" alt="1">
                            </div>'
                        ?>

                        <?php
                            if(count($product_else_pictures)) {
                                $count = 0;
                                foreach ($product_else_pictures as $picture):
                                $count++;
                        ?>
                            <div class="product__image product__image_size">
                                <img id="img<?=$count?>" class="product__image-zoom product__image--size" src="<?=IMG_LOCATION?>/<?=$product_main[0]['main_category']?>/<?=$picture['dlc_picture']?>" alt="<?=$count?>">
                            </div>
                        <?php
                                endforeach;
                            }
                        ?>
                    </div>

                    <?=
                    '<div class="product__images-zoom">
                                <img id="zoom" class="product__images-zoom magnify-image" src="' . IMG_LOCATION . '/' . $product_main[0]['main_category'] . '/' . $product_main[0]['main_picture'] . '" alt="z">
                            </div>'
                    ?>
                </div>

                <!-- Информациоя о товаре -->
                <div class="product__info">
                    <div class="product__title product__title--pos">
                        <?=$product_main[0]['main_category'] . " " . $product_main[0]['name']?>
                    </div>
                    <div class="product__links product__links--pos">
                        <a class="product__link product__link--dec" href="<?=PRODUCTS_PAGE?>?cat_id=<?=$product_main[0]['id_category']?>&page=<?=1?>">
                            <?=$product_main[0]['main_category'] . " " . $product_main[0]['name']?>
                        </a>
                        <?php
                            if(count($product_else_categories)) {
                                foreach ($product_else_categories as $category):
                        ?>

                            <a class="product__link product__link--dec" href="<?=PRODUCTS_PAGE?>?cat_id=<?=$category['id_category']?>&page=<?=1?>">
                                <?=$category['dlc_category'] . " " . $category['name']?>
                            </a>

                        <?php
                                endforeach;
                            }
                        ?>
                    </div>
                    <div class="product__price product__price--pos">
                        <div class="product__sale">
                            <div class="product__price-old">
                                <?=$product_main[0]['price']?>
                            </div>
                            <div class="product__price-new">
                                <?=$product_main[0]['price_discount']?> ₽
                            </div>
                        </div>
                        <div class="product__price-promocode">
                            <?=$product_main[0]['price_promocode']?> ₽ <span class="product__text-promocode product__text-promocode--dec">- с промокодом</span>
                        </div>
                    </div>
                    <div class="product__delivery-layer product__delivery-layer-pos">
                        <div class="product__delivery-info">
                            <div class="product__delivery-info-item">
                                <img src="data/yes.png" alt="Да/Нет">
                                В наличии в магазине <a class="product__delivery-info-link product__delivery-info-link--dec" href="https://www.lamoda.ru" target="_blank">Lamoda</a>
                            </div>
                            <div class="product__delivery-info-item">
                                <img src="data/hard_car.png" alt="Грузовик">
                                Бесплатная доставка
                            </div>
                        </div>
                    </div>
                    <div class="product__num-counter product__num-counter--pos">
                        <button id="minus" class="product__num-minus" type="button">
                            <span class="product__num-minus-txt">-</span>
                        </button>
                        <div class="product__count" name="count">
                            <span id="count" class="product__count-current">1</span>
                        </div>
                        <button id="plus" class="product__num-plus" type="button">
                            <span class="product__num-plus-txt">+</span>
                        </button>
                    </div>
                    <div class="product__buy product__buy--pos">
                        <button id="buy" class="product__buy-button" type="button" name="buttonBuy">
                            Купить
                        </button>
                        <button class="product__selected-button" type="button" name="buttonSelected">
                            В избранное
                        </button>
                    </div>
                    <div class="product__description">
                        <?=$product_main[0]['description']?>
                    </div>
                    <div class="product__shares">
                        <span class="product__share-text">Поделиться:</span>
                        <div class="product__share-list">
                            <a class="product__share product__share--dec" href="#5">
                                <img class="product__share-img1 product__share-img--dec" src="data/vk.png" alt="ВКонтакте">
                            </a>
                            <a class="product__share product__share--dec" href="#6">
                                <img class="product__share-img2 product__share-img--dec" src="data/google.png" alt="Google">
                            </a>
                            <a class="product__share product__share--dec" href="#7">
                                <img class="product__share-img3 product__share-img--dec" src="data/facebook.png" alt="Facebook">
                            </a>
                            <a class="product__share product__share_dec" href="#8">
                                <img class="product__share-img4 product__share-img--dec" src="data/twitter.png" alt="Twitter">
                            </a>
                        </div>
                        <div class="product__share-count">
                            <div class="product__share-count-triangle"></div>
                            <span class="product__share-count-current">123</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php require "footer.php"; ?>
    </footer>

    <script src="js/script.js"></script>
    <script type="text/javascript" src="js/counter_script.js"></script>
    <script src="js/counter.js"></script>
    <!-- Подключение js-файла для зумирования изображений-->
    <script type="text/javascript" src="js/jquery.magnify.js"></script>
    <!-- Подключение Noty для уведомлений -->
    <script type="text/javascript" src="js/jquery.noty.min.js"></script>
    <script type="text/javascript" src="js/jquery.noty.js"></script>
</body>
</html>