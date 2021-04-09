<?php
session_start();
// Check if user is logged in using the session variable
$_SESSION['logged_in'] = 1;
if ($_SESSION['logged_in'] != 1 && $_SESSION['privilege'] == '3') {
    echo "<script type='text/javascript'>window.location.href = '../user_login.php';</script>";
} else {
    // Makes it easier to read
    $staff_id = $_SESSION['staff_id'];
    // $last_name = $_SESSION['last_name'];//no such column
    // $first_name = $_SESSION['name'];
    $privilege = $_SESSION['privilege'];
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

    <!--
    Datatable plugin
    -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css" />

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
                <!-- <p>Please provide details for new ticket.</p> -->
            </header>
            <div class="">
                <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Resolved</th>
                            <?php
                            if ($privilege == 1) {
                                echo '<th>Assign to</th>';
                            } else {
                                echo '<th>Assigned to</th>';
                            }
                            ?>
                            <th>Priority</th>
                            <th>See Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';
                        //if superAdmin the show all tickets
                        if ($staff_id == 12) {
                            $result = $mysqli->query("SELECT * FROM tickets ORDER BY date DESC");
                        } else {//else show only assigned to this staff member tickets
                            $result = $mysqli->query("SELECT * FROM tickets where assigned_to = $staff_id ORDER BY date DESC");
                        }


                        while ($row = mysqli_fetch_array($result)) {
                            echo '<tr><td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['title'] . '</td>';
                            echo '<td>' . $row['date'] . '</td>';
                            echo '<td>' . $row['resolved'] . '</td>';

                            if ($privilege == 1) {
                                echo '<td><form name="changeAssigned" id="changeAssigned" action="libs/_change_assigned.php" method="post">
                        <select id="assigned" name="newAssigned" onchange="this.form.submit()">
                        <option value="' . $row['assigned_to'] . '">' . $row['assigned_to'] . '</option>';
                                $staffs = $mysqli->query("SELECT * FROM staff");
                                while ($staff = mysqli_fetch_array($staffs)) {
                                    echo '<option value="' . $staff['id'] . '">' . $staff['name'] . '</option>';
                                }
                                echo '</select>
                        <input type="hidden" value="' . $row['id'] . '" name="id"/>
                        </form></td>';
                            } else {
                                echo '<td>' . $row['assigned_to'] . '</td>';
                            }

                            if ($row['priority'] == '1') {
                                $row['priority'] = 'High';
                            } elseif ($row['priority'] == '2') {
                                $row['priority'] = 'Medium';
                            } elseif ($row['priority'] == '3') {
                                $row['priority'] = 'Low';
                            }
                            echo '<td><form name="changePriority" id="changePriority" action="libs/_change_priority.php" method="post">
                        <select id="priority" name="newPriority" onchange="this.form.submit()">
                        <option value="' . $row['priority'] . '">' . $row['priority'] . '</option>
                        <option value="1">High</option>
                        <option value="2">Medium</option>
                        <option value="3">Low</option>
                        </select>
                        <input type="hidden" value="' . $row['id'] . '" name="id"/>
                        </form></td>';
                            echo '<td><a href="../seeTicket.php?id=' . $row['id'] . '"><button value="Details" class="primary" >Details</button></a> </td>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <?php include '../include/footer.php'; ?>
    <!-- Execute form upon change beeing made-->
    <!--<script>
    $(document).ready(function() {
        $('#priority').on('change', function() {
            document.forms[changePriority].submit();
        });
    });
</script>-->
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