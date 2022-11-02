<?php
global $count_products;
global $current_page;
global $count_pages;

$back = '';
$forward = '';
$start_page = '';
$end_page = '';
$pages_left = '';
$pages_right = '';

if($current_page > 1) {
    $back = "<li class='navigation__item'>
                <a class='navigation__link' href='". PRODUCTS_PAGE . "?cat_id=" . clearInt($_GET['cat_id']) . "&page=". ($current_page - 1) . "'>
                   &lt;
                </a>
            </li>";
}

if($current_page < $count_pages) {
    $forward = "<li class='navigation__item'>
                    <a class='navigation__link' href='". PRODUCTS_PAGE . "?cat_id=" . clearInt($_GET['cat_id']) . "&page=". ($current_page + 1) . "'>
                       &gt;
                    </a>
                </li>";
}

if($current_page > MID_LINKS_LIMIT + 1) {
    $start_page = "<li class='navigation__item'>
                        <a class='navigation__link' href='". PRODUCTS_PAGE . "?cat_id=" . clearInt($_GET['cat_id']) . "&page=". (1) . "'>
                           &laquo;
                        </a>
                    </li>";
}

if($current_page < ($count_pages - MID_LINKS_LIMIT)) {
    $end_page = "<li class='navigation__item'>
                    <a class='navigation__link' href='". PRODUCTS_PAGE . "?cat_id=" . clearInt($_GET['cat_id']) . "&page=". ($count_pages) . "'>
                       &raquo;
                    </a>
                 </li>";
}

for($i = MID_LINKS_LIMIT; $i > 0; $i--) {
    if($current_page - $i > 0) {
        $pages_left .= "<li class='navigation__item'>
                            <a class='navigation__link' href='". PRODUCTS_PAGE . "?cat_id=" . clearInt($_GET['cat_id']) . "&page=". ($current_page - $i) . "'> 
                                " .($current_page - $i) ."
                            </a>
                        </li>";
    }
}

for($i = 1; $i <= MID_LINKS_LIMIT; $i++) {
    if($current_page + $i <= $count_pages) {
        $pages_right .= "<li class='navigation__item'>
                            <a class='navigation__link' href='". PRODUCTS_PAGE . "?cat_id=" . clearInt($_GET['cat_id']) . "&page=". ($current_page + $i) . "'> 
                                " .($current_page + $i) ."
                            </a>
                        </li>";
    }
}
?>