<!-- Header -->
<header id="header">
    <a class="logo" href="index.php">Ticketing</a>
    <nav>
        <a href="#menu">Menu</a>
    </nav>
</header>

<!-- Nav -->
<nav id="menu">
    <ul class="links">
        <li><a href="index.php">Home</a></li>
        <?php
        if ( $_SESSION['logged_in'] != 1) {
            echo "<li><a href=\"/user_login.php\">User login</a></li>";
            echo "<li><a href=\"/staff_login.php\">Staff login</a></li>";
        }
        else{
            echo "<li><a href=\"/libs/logout.php\">Logout</a></li>";
        }
        ?>
        <li><a href="elements.html">Elements</a></li>
        <li><a href="generic.html">Generic</a></li>
    </ul>
</nav>