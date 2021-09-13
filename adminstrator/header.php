<?php echo $_SESSION['direction']; ?>

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Adminstrator Healty Box
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="../assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />



    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="StyleSheet" href="../assets/alert/css/notify.css" type="text/css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

    <link href="../assets/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../assets/alert/js/notify.js"></script>



    <!-- End Alert  -->
    <link href="../assets/css/material-dashboard-rtl.css" rel="stylesheet" />
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="easySelectStyle/easySelectStyle.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="easySelectStyle/easySelect.js"></script>
    <script>
        function showAddresssDetials(str, lang) {
            if (str.length == 0) {
                document.getElementById("address").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("address").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "./module/place.php?address_id=" + str + "&&lang=" + lang, true);
                xmlhttp.send();
            }
        }
    </script>

    <script>
        function showAddresssDetials2(str, lang, user_area_id) {
            if (str.length == 0) {
                document.getElementById("address").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("address").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "./ajax/items_address.php?address_id=" + str + "&&lang=" + lang + "&&user_area_id=" + user_area_id, true);
                xmlhttp.send();
            }
        }
    </script>



    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    <script>
        function redirectUrl() {
            switch (document.getElementById('print_type').value) {
                case "1":
                    window.open("./module/report_kitchen.php?lang=en", '_blank');

                    break;

                case "2":
                    window.open("./module/report_driver.php?lang=en", '_blank');

                    break;

                case "3":
                    window.open("./module/report_cart.php?lang=en", '_blank');
                    break;
                case "4":
                    window.open("./module/report_kitchen.php?lang=ar", '_blank');

                    break;

                case "5":
                    window.open("./module/report_driver.php?lang=ar", '_blank');
                    break;

                case "6":
                    window.open("./module/report_cart.php?lang=ar", '_blank');
                    //window.location ="./module/report_cart.php?lang=ar";
                    break;
                case "7":
                    window.open("./module/report_cart_windows.php?lang=ar", '_blank');
                    //window.location ="./module/report_cart.php?lang=ar";
                    break;
            }
        }

        function showStat(str) {
            if (str == "") {
                document.getElementById("stat_div").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("stat_div").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajax/view_statisic.php?cap_id=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>

<body>