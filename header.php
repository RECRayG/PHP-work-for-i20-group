<div class="header__container">
    <figure class="header__container-logo header__container-logo--size">
        <a href="products.php"><img id="logo" src="<?php echo LOGO_LOCATION?>rec_logo2.png" alt="logo"></a>
    </figure>
    <?php
        if(isset($_SERVER['HTTP_REFERER']) && isset($_GET['cat_name'])) {
            $urlback = htmlspecialchars($_SERVER['HTTP_REFERER']);
            echo <<< MARK
            <a href='$urlback' class='header__container-history-back'>&lt; Назад</a>
MARK;
        }

        if(isset($_SERVER['HTTP_REFERER']) && isset($_GET['cat_id'])) {
            $main = MAIN_PAGE;
            echo <<< MARK
            <a href='$main' class='header__container-history-back'>&lt; Назад</a>
MARK;
        }
    ?>
    <div class="header__container-buttons">
        <button class="header__container-login" type="button" name="buttonLogin">
            Вход
        </button>
        <button class="header__container-registration" type="button" name="buttonRegistration">
            Регистрация
        </button>
    </div>
</div>