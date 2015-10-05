<?php
    include "excel_reader2.php";
    include "function.php";
    ini_set('max_execution_time', 300);
    error_reporting(0);
    $connect = database_connect();
    $ID = time();

    $data_primer    = new Spreadsheet_Excel_Reader($_FILES['primer']['tmp_name']);
    
    $baris_primer   = $data_primer->rowcount($sheet_index=0);
    $kolom_primer   = $data_primer->colcount($sheet_index=0);
    
    $sukses_primer  = 0;
    $gagal_primer   = 0;
    
    //untuk file snp, mengetahui letak cell colom apa aja
    for($i = 1; $i <= $kolom_primer; $i++)
    {
        $nama = $data_primer -> val(1,$i);
        $nama = strtolower($nama);
        //echo $nama . "<br>";
        if ($nama == 'nama_primer') {
            $primer = $i;
        }
        if ($nama = 'forward_sequence') {
            $forward = $i;
        }
        if ($nama = 'reverse_sequence') {
            $reverse = $i;
        }
    }

    /*
        echo $primer  . '<br>';
        echo $forward  . '<br>';
        echo $reverse  . '<br>';
    // */

    for($j = 2; $j <= $baris_primer; $j++)
    {
        $primer_tabel = $data_primer->val($j,$primer);
        $forward_tabel = strtolower($data_primer->val($j,$forward));
        $reverse_tabel = strtolower($data_primer->val($j,$reverse));

        $query =    "INSERT INTO `primer`(`primer_id`, `primer`, `forward`, `reverse`) 
                    VALUES (" . $ID . ",". "\"" . $primer_tabel . "\",\"" . $forward_tabel . "\",\"" . $reverse_tabel . 
                    "\")";
        //echo $query . "<br>"; break;
        
        $hasil = mysql_query($query);
        //*
        //echo mysql_error();
        if($hasil)
        {
            $sukses_primer++;
        }
        else
        {
            $gagal_primer++;
            echo "<div class='alert alert-warning' role='alert'> Row nomor " . $j . " Tidak bisa terupload </div>";
        }
        //echo $sukses_snp . "<br>";
        //echo $gagal_snp . "<br>";
        //break;
        //*/
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PALMADB - Upload SNP</title>

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
                <a class="navbar-brand" href="index.html">Home</a>
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
                <h1>Hasil Upload</h1>
                <?php
                    $total_data = $baris_primer - 1;
                    echo "<div class='alert alert-success' role='alert'>Sukses upload " . $sukses_primer . " dari " . $total_data . "</div>";
                    echo "<a class='btn btn-primary btn-lg' href=\"resultPRIMER.php?ID=". $ID ."\" role=button>See Result</a>"
                ?>
            </div>
        </div>
        <!-- /.row -->
    <table class="table table-hover">
        
    </table>
    </div>
    <!-- /.container -->


    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
