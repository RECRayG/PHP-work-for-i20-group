<?php
function clearStr($data) {
	global $link;
	$data = trim(strip_tags($data));
	return mysqli_real_escape_string($link, $data);
}

function clearInt($data) {
	return abs((int)$data);
}

function getListCategories() {
	global $link;
	$sql = "select * from (
			select c.id_category, c.category_name, c.description, c.category_image, count(*) as count_products
			from categories c
			inner join c_pr_identity cpri on cpri.id_category = c.id_category
			inner join products p on p.id_product = cpri.id_product
			group by c.id_category
			UNION ALL
			select c.id_category, c.category_name, c.description, c.category_image, count(*) as count_products
			from categories c
			inner join main_product_category mprc on mprc.id_category = c.id_category
			inner join products p on p.id_product = mprc.id_product
			group by c.id_category) cats
			order by count_products desc, category_name";
			
	if(!$result = mysqli_query($link, $sql))
		return false;
	
	$list = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);

	return $list;
}

function getListAllCategories() {
    global $link;
    $sql = "select distinct id_category, category_name, description, category_image, sum(count_products) as count_products from (
            select c.id_category, c.category_name, c.description, c.category_image, count(cpri.id_category) as count_products
            from categories c
            left join c_pr_identity cpri on cpri.id_category = c.id_category
            left join products p on p.id_product = cpri.id_product
            group by c.id_category
            UNION all
            select c.id_category, c.category_name, c.description, c.category_image, count(mprc.id_category) as count_products
            from categories c
            left join main_product_category mprc on mprc.id_category = c.id_category
            left join products p on p.id_product = mprc.id_product
            group by c.id_category) cats
            group by id_category, category_name, description, category_image
            order by count_products desc, category_name;";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list;
}

function getProductsAllFromCategory($id_category) {
    global $link;
    $sql = "select id_product, name, is_active, picture_src, picture_alt, category_name 
            from (
                select pr.id_product, pr.name, pr.is_active, pic.picture_src, pic.picture_alt, cat.id_category, cat.category_name
                from products pr
                inner join c_pr_identity cpri on cpri.id_product = pr.id_product
                inner join categories cat on cat.id_category = cpri.id_category
                inner join preview_picture_product ppp on ppp.id_product = pr.id_product
                inner join pictures pic on pic.id_picture = ppp.id_picture
                union all
                select pr.id_product, pr.name, pr.is_active, pic.picture_src, pic.picture_alt, cat.id_category, cat.category_name
                from products pr
                inner join main_product_category mpc on mpc.id_product = pr.id_product
                inner join categories cat on cat.id_category = mpc.id_category
                inner join preview_picture_product ppp on ppp.id_product = pr.id_product
                inner join pictures pic on pic.id_picture = ppp.id_picture) products
            where id_category = " . clearInt($id_category) . "
            order by id_product;";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list;
}

function getProductsLimitFromCategory($id_category, $num_page) {
    global $link;
    if(clearInt($num_page) == 0) {
        echo "Отсутствует страница";
        return false;
    }
    $sql = "select id_product, name, is_active, picture_src, picture_alt, category_name 
            from (
                select pr.id_product, pr.name, pr.is_active, pic.picture_src, pic.picture_alt, cat.id_category, cat.category_name
                from products pr
                inner join c_pr_identity cpri on cpri.id_product = pr.id_product
                inner join categories cat on cat.id_category = cpri.id_category
                inner join preview_picture_product ppp on ppp.id_product = pr.id_product
                inner join pictures pic on pic.id_picture = ppp.id_picture
                union all
                select pr.id_product, pr.name, pr.is_active, pic.picture_src, pic.picture_alt, cat.id_category, cat.category_name
                from products pr
                inner join main_product_category mpc on mpc.id_product = pr.id_product
                inner join categories cat on cat.id_category = mpc.id_category
                inner join preview_picture_product ppp on ppp.id_product = pr.id_product
                inner join pictures pic on pic.id_picture = ppp.id_picture) products
            where id_category = " . clearInt($id_category) . "
            order by id_product
            limit " . ((clearInt($num_page) - 1) * PRODUCTS_LIMIT) . ", ". PRODUCTS_LIMIT . ";";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list;
}

function getCountProductsFromCategory($id_category) {
    global $link;
    $sql = "select * from (
			select c.id_category, c.category_name, c.description, c.category_image, count(*) as count_products
			from categories c
			inner join c_pr_identity cpri on cpri.id_category = c.id_category
			inner join products p on p.id_product = cpri.id_product
			group by c.id_category
			UNION ALL
			select c.id_category, c.category_name, c.description, c.category_image, count(*) as count_products
			from categories c
			inner join main_product_category mprc on mprc.id_category = c.id_category
			inner join products p on p.id_product = mprc.id_product
			group by c.id_category) cats
            where id_category = " . clearInt($id_category) . ";";

    if(!$result = mysqli_query($link, $sql))
        return 0;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    if(!count($list)) return 0;
    return $list[0]['count_products'];
}

function getMainCategoryPreviewPictureProduct($id_product) {
    global $link;
    $sql = "select pr.id_product, pr.name, pr.price, pr.price_discount, pr.price_promocode, pr.is_active, pr.description, pic.picture_src as main_picture, pic.picture_alt, cat.id_category, cat.category_name as main_category
            from products pr
            inner join main_product_category mpc on mpc.id_product = pr.id_product
            inner join categories cat on cat.id_category = mpc.id_category
            inner join preview_picture_product ppp on ppp.id_product = pr.id_product
            inner join pictures pic on pic.id_picture = ppp.id_picture
            where pr.id_product = " . clearInt($id_product) . ";";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list;
}

function getElseCategoriesProduct($id_product) {
    global $link;
    $sql = "select pr.id_product, pr.name, pr.is_active, cat.id_category, cat.category_name as dlc_category
            from products pr
            inner join c_pr_identity cpri on cpri.id_product = pr.id_product
            inner join categories cat on cat.id_category = cpri.id_category
            where pr.id_product = " . clearInt($id_product) . ";";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list;
}

function getElsePicturesProduct($id_product) {
    global $link;
    $sql = "select pr.id_product, pr.name, pr.is_active, pic.picture_src as dlc_picture, pic.picture_alt
            from products pr
            inner join pr_pi_identity prpi on prpi.id_product = pr.id_product
            inner join pictures pic on pic.id_picture = prpi.id_picture
            where pr.id_product = " . clearInt($id_product) . ";";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list;
}

// Получение имени главной категории товара
function getMainCategoryNameByProduct($id_product) {
    global $link;
    $sql = "select pr.id_product, pr.name, pr.is_active, pic.picture_src, pic.picture_alt, cat.id_category, cat.category_name
            from products pr
            inner join main_product_category mpc on mpc.id_product = pr.id_product
            inner join categories cat on cat.id_category = mpc.id_category
            inner join preview_picture_product ppp on ppp.id_product = pr.id_product
            inner join pictures pic on pic.id_picture = ppp.id_picture
            where pr.id_product = " . clearInt($id_product) . ";";

    if(!$result = mysqli_query($link, $sql))
        return false;

    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $list[0]['category_name'];
}