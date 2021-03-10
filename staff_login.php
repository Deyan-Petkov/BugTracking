<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Ticketing</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/bootstrap.css.css" />
	</head>
	<body class="is-preload">

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login'])) { //user logging in

            require 'libs/staff_login.php';

        }
        else{

        }
    }
    include 'include/header.php';?>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h1>Ticketing</h1>
					<p>Best ticketing solution for all kinds of businesses.</p>
				</div>
				<video autoplay loop muted playsinline src="images/banner.mp4"></video>
			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<h2>User login</h2>
						<p>Please login if you are the staff.</p>
					</header>
					<div class="">
                        <form method="post" action="#">
                            <div class="row gtr-uniform">
                                <div class="col-12 col-12-xsmall">
                                    <input type="email" name="email" id="email" value="" placeholder="Email" />
                                </div>
                                <div class="col-12 col-12-xsmall">
                                    <input type="password" name="password" id="password" value="" placeholder="Password" />
                                </div>

                                <!-- Break -->
                                <div class="col-12">
                                    <ul class="actions">
                                        <li><button type="submit" value="Login" class="primary" ></button></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
					</div>
				</div>
			</section>



		<?php include 'include/footer.php';?>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>