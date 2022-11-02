<?php
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_NAME = "fordump";

const MAIN_PAGE = "/web-shop/products.php";
const PRODUCTS_PAGE = "/web-shop/category_products.php";
const PRODUCT_PAGE = "/web-shop/product.php";
const IMG_LOCATION = "data/";
const LOGO_LOCATION = "data/background&logos/";
const ERROR_404_PATH = "http://localhost/web-shop/errors/error_404.php";

const PRODUCTS_LIMIT = 12;
const MID_LINKS_LIMIT = 3;
const ALL_LINKS_LIMIT = 5;

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());