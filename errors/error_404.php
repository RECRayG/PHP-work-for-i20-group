<?php
    header("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Averin Matvey Romanovich">
    <meta name="keywords" content="error">
    <link rel="stylesheet" href="css/style.css">
    <title>Ошибка: 404</title>
    <style>
        a {
            background-color: transparent;
            -webkit-text-decoration-skip: objects
        }

        a:active,
        a:hover {
            outline-width: 0
        }

        *,
        *:after,
        *:before {
            box-sizing: inherit;
            margin: 0;
            padding: 0;
            color: #000;
        }

        html {
            box-sizing: border-box;
            font-size: 1px !important;
        }

        body {
            font: normal 14rem/21rem Arial, 'Helvetica CY', 'Nimbus Sans L', sans-serif;
            background: url('../data/background&logos/background_catalog.jpg');
        }

        .outer {
            display: table;
            position: absolute;
            top: 0;
            left: -400px;
            height: 100%;
            width: 100%;
        }

        .middle {
            display: table-cell;
            vertical-align: middle;
        }

        .inner {
            margin-left: auto;
            margin-right: auto;
            max-width: 570rem;
            min-width: 360rem;
            padding: 20rem;
        }

        h1 {
            line-height: 18rem;
            font-size: 48rem;
        }

        h2 {
            margin-top: 15rem;
            line-height: 26rem;
            font-size: 26rem;
            margin-bottom: 25rem;
        }

        i {
            border: solid #fff;
            border-width: 0 3rem 3rem 0;
            display: inline-block;
            padding: 3rem;
        }

        .f {
            color: white;
            margin: 50px;
        }

        .s {
            color: white;
        }

        .button {
            position: relative;
            display: inline-block;
            text-decoration: none;
            background-color: #006be5;
            color: white;
            padding: 8rem 16rem;
            border-radius: 5rem;
            overflow: hidden;
            font-size: 16rem;
            font-weight: bold;
            text-shadow: 0px 0px 2px #aa0014;
            margin-left: 150px;
        }

        .left {
            transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
        }
    </style>
</head>
<body>
    <div class='outer'>
        <div class='middle'>
            <div class='inner'>
                <h1 class="f">Ошибка 404! >:(</h1>
                <h2 class="s">Запрашиваемая страница не найдена</h2>
                <?php
                    $main = "/web-shop/products.php";
                    echo <<< MARK
                    <a href='$main' class='button'><i class="left"></i> На главную</a>
MARK;
                ?>
            </div>
        </div>
    </div>
</body>
</html>