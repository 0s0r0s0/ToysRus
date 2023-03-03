<?php require_once 'app/index-code.php'; ?>

<header >
    <div>
        <div id="logo">
            <a href="index.php"><img src="img/logo.jpg"></a>
        </div>
        <nav id="top-bar">
            <ul class="menu">
                <li class="list-toys"><a href="/list.php">Tous les jouets</a></li>
                <li class="list-brands"><a href="#">Par marque▾</a>
                    <ul>
                    <?php brandsGetAll(); ?>
                    </ul>
                </li>
                <li class="list-hidden"></li>
            </ul>
        </nav>
    </div>
</header>
