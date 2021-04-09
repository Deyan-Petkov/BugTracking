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
		session_start();
		$_SESSION['logged_in'] = 0;
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

						<h2>Ticketing</h2>

						<p>Best ticketing solution for all kinds of businesses.</p>

					</header>

					<div class="highlights">

						<section>

							<div class="content">

								<header>

									<a href="/user_login.php" class="icon fa-user"><span class="label">Icon</span></a>

									<h3>User login</h3>

								</header>

								<p>Please login if you are the user.</p>

							</div>

						</section>

                        <section>

                            <div class="content">

                                <header>

                                    <a href="/staff_login.php" class="icon fa-vcard-o"><span class="label">Icon</span></a>

                                    <h3>Staff login</h3>

                                </header>

                                <p>Please login if you are staff.</p>

                            </div>

                        </section>

                        <section>

                            <div class="content">

                                <header>

                                    <a href="#" class="icon fa-files-o"><span class="label">Icon</span></a>

                                    <h3>About us</h3>

                                </header>

                                <p>Read more about us.</p>

                            </div>

                        </section>



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