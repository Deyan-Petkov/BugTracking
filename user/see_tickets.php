<?php
session_start();
// Check if user is logged in using the session variable
$_SESSION['logged_in'] = 1;
if ($_SESSION['logged_in'] != 1 && $_SESSION['priviledge'] != '3') {
    echo "<script type='text/javascript'>window.location.href = '../user_login.php';</script>";
} else {
    // Makes it easier to read
    $user_id = $_SESSION['user_id'];
    // $last_name = $_SESSION['last_name'];//no such column
    // $first_name = $_SESSION['name'];//dont need it here 

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
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    <link rel="stylesheet" href="/assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="/assets/css/luka.css"/>

    <!--
    Datatable plugin
    -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css"/>

</head>
<body class="is-preload">

<?php

include '../include/header.php'; ?>

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
            <h2>See all tickets</h2>
            <p>Please provide details for new ticket.</p>
        </header>
        <div class="">
            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Resolved</th>
                    <th>See Details</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';

                $result = $mysqli->query("SELECT * FROM tickets WHERE submitted_by='$user_id' ORDER BY date DESC");


                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr><td>'. $row['id'] .'</td>';
                    echo '<td>' . $row['title'] . '</td>';
                    echo '<td>'. $row['date'] .'</td>';
                    echo '<td>'. $row['resolved'] .'</td>';
                    echo '<td><a href="../seeTicket.php?id='. $row['id'] .'"><button value="Details" class="primary" >Details</button></a> </td>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


<?php include '../include/footer.php'; ?>

<!-- Scripts -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/browser.min.js"></script>
<script src="/assets/js/breakpoints.min.js"></script>
<script src="/assets/js/util.js"></script>
<script src="/assets/js/main.js"></script>
<!-- Datatable scripts-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>

</body>
</html>