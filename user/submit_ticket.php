<?php
session_start();
// Check if user is logged in using the session variable
$_SESSION['logged_in'] = 1;
if ( $_SESSION['logged_in'] != 1 && $_SESSION['priviledge']!='3') {
    echo "<script type='text/javascript'>window.location.href = '../user_login.php';</script>";
}
else {
    // Makes it easier to read
    $user_id = $_SESSION['user_id'];
}
?>
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
        <link rel="stylesheet" href="/assets/css/main.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="/assets/css/luka.css" />
	</head>
	<body class="is-preload">

		<?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['submit'])) { //user logging in

                require 'libs/_submit_ticket.php';

            }
            elseif (isset($_POST['register'])) { //user registering

                require 'register.php';

            }
        }
        include '../include/header.php';?>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h1>Ticketing</h1>
					<p>Best ticketing solution for all kinds of businesses.</p>
				</div>
				<video autoplay loop muted playsinline src="/images/banner.mp4"></video>
			</section>

        <!-- Highlights -->
        <section class="wrapper">
            <div class="inner">
                <header class="special">
                    <h2>New ticket</h2>
                    <p>Please provide details for new ticket.</p>
                </header>
                <div class="">
                    <form action="#" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="row gtr-uniform">
                            <div class="col-12 col-12-xsmall">
                                <input type="text" name="title" id="title" value="" placeholder="Title" />
                            </div>
                            <!--<div class="col-6 col-6-xsmall">
                                <input type="date" name="date" id="date" placeholder="Date" />
                            </div>-->
                            <div class="col-12 col-12-xsmall">
                                <textarea type="description" name="description" id="description" placeholder="Description" ></textarea>
                            </div>

                            <div class="col-12 col-12-xsmall">
                                <input type="file" id="files_[]"
                                       name="files[]" multiple="multiple">
                            </div>

                            <!-- Break -->
                            <div class="col-12">
                                <ul class="actions">
                                    <li><button type="submit" value="Submit" class="primary" name="submit">Submit</button></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>



		<?php include '../include/footer.php';?>

		<!-- Scripts -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>

	</body>
</html>