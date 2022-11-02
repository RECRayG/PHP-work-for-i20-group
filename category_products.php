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

            <?php
            $list_products = array();

            isset($_GET['page']) ? $current_page = $_GET['page'] : $current_page = 1;
            if(!clearInt($_GET['page'])) {header("Location: " . ERROR_404_PATH); exit;};

            if(empty($_GET['cat_id'])) {
                header("Location: " . ERROR_404_PATH);
                exit;
            } else {
                if(!clearInt($_GET['cat_id'])) {
                    header("Location: " . ERROR_404_PATH);
                    exit;
                }
                if($_GET['cat_id'] <= 0) {
                    header("Location: " . ERROR_404_PATH);
                    exit;
                }
            }

            $count_products = getCountProductsFromCategory($_GET['cat_id']);
            $count_pages = ceil($count_products / PRODUCTS_LIMIT);
            if($current_page > $count_pages)
                $current_page = $count_pages;
            if($_GET['page'] <= 0 || $_GET['page'] > $count_pages) {
                header("Location: " . ERROR_404_PATH);
                exit;
            }

            foreach($list as $item) :
                if($item['id_category'] === $_GET['cat_id']) {
                    $list_products = getProductsLimitFromCategory($_GET['cat_id'], $current_page);
                    break;
                }
            endforeach;

            if($list_products === false) {echo "ERROR!"; exit;}
            if(!count($list_products)) {echo "Товаров нет :("; }


            ?>
            <div class="products__container-row">
                <?php
                    foreach($list_products as $item):
                    if($item['is_active'] != 0) {
                ?>
                    <div class="products__container-main">
                        <div class="products__container-main-image">
                            <a href="product.php?cat_id=<?=$_GET['cat_id']?>&id=<?=$item['id_product']?>">
                                <img src="<?=IMG_LOCATION . "/" . getMainCategoryNameByProduct($item['id_product']) . "/" . $item['picture_src']?>" alt="<?=$item['picture_alt']?>" title="<?=$item['picture_alt']?>">
                            </a>
                            <div class="products__container-category-bottom">
                                <div class="products__container-product-category">
                                    <?=getMainCategoryNameByProduct($item['id_product'])?>
                                </div>
                                <div class="products__container-product-name">
                                    <?=$item['name']?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                    else {
                ?>
                        <div class="products__container-main">
                            <div class="products__container-main-image">
                                    <img class="products__container-image-no-active" src="<?=IMG_LOCATION . "/" . $item['category_name'] . "/" . $item['picture_src']?>" alt="<?=$item['picture_alt']?>" title="<?=$item['picture_alt']?>">
                                        <h6 class="products__container-text-no-active">
                                            <span>Нет в наличии</span>
                                        </h6>
                                <div class="products__container-category-bottom">
                                    <div class="products__container-product-category products__container-category-bottom--no-active">
                                        <?=$item['category_name']?>
                                    </div>
                                    <div class="products__container-product-name products__container-category-bottom--no-active">
                                        <?=$item['name']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>
                <?php endforeach; ?>
            </div>
            <div class="container__navigation">
                <nav class="navigation">
                    <ul class="navigation__page">
                        <?php
                        require "pagination_init.php";
                        global $back;
                        global $forward;
                        global $start_page;
                        global $end_page;
                        global $pages_left;
                        global $pages_right;
                        ?>

                        <?=$start_page?><?=$back?><?=$pages_left?>
                        <li class="navigation__item">
                            <a class="navigation__link navigation__link--active">
                                <?=$current_page?>
                            </a>
                        </li>
                        <?=$pages_right?><?=$forward?><?=$end_page?>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
    <footer>
        <?php require "footer.php";?>
    </footer>
<script src="js/script.js"></script>
</body>
</html>