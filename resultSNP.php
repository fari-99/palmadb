<?php
    include "function.php";
    error_reporting(0);
    $connect = database_connect();
    $ID = $_GET["ID"];

    $query = "SELECT * FROM `snp` WHERE `snp_id` = " . $ID;
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
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li class="dropdown">
                        <a id="drop1" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                            aria-expanded="false">
                            Tools
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="drop1">
                            <li><a href="uploadSNP.php">Upload SNP</a></li>
                            <li><a href="uploadPRIMER.php">Upload Primer</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Search</a></li>
                        </ul>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Hasil Upload ID <?php echo $ID;?> </h1>
                <table class="table table-hover">
                    <tr>
                        <th>No</th>
                        <th>Sample ID</th>
                        <th>CHR</th>
                        <th>POS</th>
                        <th>REf</th>
                        <th>ALT</th>
                        <th>INDEL</th>
                        <th>Flanking Left</th>
                        <th>Flanking Right</th>
                        <th>GENE</th>
                        <th>Description</th>
                    </tr>
                <?php
                    $paging     = new Paging;
                    $batas      = 10;
                    $posisi     = $paging->cariPosisi($batas);
                    $query      = 'SELECT * FROM `snp` where `snp_id` = ' . $ID . ' LIMIT ' . $posisi . ',' . $batas;
                    $tampil     = mysql_query($query);

                    $no = $posisi + 1;
                    while ($r=mysql_fetch_array($tampil)){
                        echo '
                            <tr>
                                <td>'. $no .'</td>
                                <td>'. $r['sample_id'] .'</td>
                                <td>'. $r['chr'] .'</td>
                                <td>'. $r['pos'] .'</td>
                                <td>'. $r['ref'] .'</td>
                                <td>'. $r['alt'] .'</td>
                                <td>'. $r['indel'] .'</td>
                                <td>'. $r['flanking_left'] .'</td>
                                <td>'. $r['flanking_right'] .'</td>
                                <td>'. $r['gene'] .'</td>
                                <td>'. $r['description'] .'</td>
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
