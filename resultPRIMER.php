<?php
    include "function.php";
    error_reporting(0);
    $connect = database_connect();
    $ID = $_GET["ID"];

    $query = "SELECT * FROM `primer` WHERE `primer_id` = " . $ID;
    $hasil = mysql_query($query);
    $jmlData = mysql_num_rows($hasil);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PALMADB - Result SNP</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <?php include "nav.php";?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Hasil Upload ID <?php echo $ID;?> </h1>
                <table class="table table-hover">
                    <tr>
                        <th>No</th>
                        <th>PRIMER</th>
                        <th>forward</th>
                        <th>REVERSE</th>
                    </tr>
                <?php
                    $paging     = new Paging;
                    $batas      = 10;
                    $posisi     = $paging->cariPosisi($batas);
                    $query      = 'SELECT * FROM `primer` where `primer_id` = ' . $ID . ' LIMIT ' . $posisi . ',' . $batas;
                    //echo $query; break;
                    $tampil     = mysql_query($query);

                    $no = $posisi + 1;
                    while ($r=mysql_fetch_array($tampil)){
                        //echo strlen($r['forward']); break;
                        echo '
                            <tr>
                                <td>'. $no .'</td>
                                <td>'. $r['primer'] .'</td>
                                <td>'. strtoupper($r['forward']) .'</td>
                                <td>'. strtoupper($r['reverse']) .'</td>
                            </tr>
                        ';
                        $no++;
                    }
                ?>
                </table>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <?php
                    $jmlHalaman = $paging->jumlahHalaman($jmlData,$batas);
                    $linkHalaman = $paging->navHalaman($_GET['halaman'], $jmlHalaman, $ID);
                    echo "$linkHalaman";
    ?>


    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
