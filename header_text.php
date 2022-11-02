<?php
    # Если я нахожусь на главной
    if(empty($_GET) && !isset($_GET['cat_id'])) {
        echo <<<MARK
        <div class="catalog__container">
            <div class="catalog__container-slide">
                <div class="catalog__container-text">
                    Каталог
                </div>
            </div>
        </div>
MARK;
    } else {
        global $list;
        $url = LOGO_LOCATION;
        $category = array();
        foreach($list as $item) {
            if(clearInt($item['id_category']) === clearInt($_GET['cat_id'])) {
                $tmp = pathinfo($item['category_image']);
                $url .= 'background_' . $tmp['filename'] . '.jpg';
                $category = $item;
                break;
            }
        }
        if(mb_substr($url, -4) == ".jpg"):
        echo <<<MARK
        <div class="catalog__container-category-back" style="background: url({$url}) no-repeat;">
            <div class="catalog__container-slide">
                <div class="catalog__container-text">
                    {$category['category_name']}
                </div>
            </div>
            <div class="catalog__container-footer-description">
                Описание раздела
            </div>
            <div class="catalog__container-description">
                {$category['description']}
            </div>
        </div>
MARK;
        else :
            echo "ERROR! Background image Not Found... ";
        endif;
    }
?>
