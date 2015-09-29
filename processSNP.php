<?php
    include "excel_reader2.php";
    include "function.php";
    ini_set('max_execution_time', 300);
    error_reporting(0);
    $connect = database_connect();
    $ID = time();

    if (
        !isset($_FILES['snp']['error']) ||
        is_array($_FILES['snp']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['snp']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    $data_snp       = new Spreadsheet_Excel_Reader($_FILES['snp']['tmp_name']);
    
    $baris_snp      = $data_snp->rowcount($sheet_index=0);
    $kolom_snp      = $data_snp->colcount($sheet_index=0);
    
    $sukses_snp     = 0;
    $gagal_snp      = 0;
    $kode_neu[0] = "A";
    $kode_neu[1] = "C";
    $kode_neu[2] = "G";
    $kode_neu[3] = "T";
    $kode_neu[4] = "-";
    
    //untuk file snp
    for($i = 1; $i <= $kolom_snp; $i++)
    {
        $nama = $data_snp -> val(1,$i);
        $nama = strtolower($nama);
        //echo 'nilai i = ' . $i . ' -> ' . $nama . '<br>';
        if($nama == 'pos')
            $pos = $i;
        if($nama == 'ref')
            $ref = $i;
        if($nama == 'alt')
            $alt = $i;
        if($nama == 'indel')
            $indel = $i;
        if($nama == 'flanking')
            $flanking = $i;
        if($nama == 'gene')
            $gene = $i;
        if($nama == 'decription')
            $description = $i;
        if($nama == 'chr')
            $chr = $i;
    }

    /*
        echo $pos . '<br>';
        echo $ref . '<br>';
        echo $alt . '<br>';
        echo $indel . '<br>';
        echo $flanking . '<br>';
        echo $chr . '<br>';
        echo $description  . '<br>';
        echo $gene  . '<br>';
    // */

    for($j = 2; $j <= $baris_snp; $j++)
    {
        $pos_tabel = $data_snp->val($j,$pos);
        $ref_tabel = $data_snp->val($j,$ref);
        $alt_tabel = $data_snp->val($j,$alt);
        $indel_tabel = $data_snp->val($j,$indel);
            if($indel_tabel == '.') $indel_tabel = 0;
        $flanking_tabel = $data_snp->val($j,$flanking);
        
        $keyword1 = explode("[", $flanking_tabel);
        $flanking_left = $keyword1[0];
        $keyword2 = explode("]", $keyword1[1]);
        $flanking_right = $keyword2[1];
        /*
        echo $flanking_left . "<br>";
        echo $flanking_right . "<br>";
        echo $keyword2[0] . "<br><br>";
        //*/

        $chr_tabel = $data_snp->val($j,$chr);
        $gene_tabel = $data_snp->val($j,$gene);
        $description_tabel = $data_snp->val($j,$description);

        $query = "INSERT INTO `snp` (`sample_id`, `chr`, `pos`, `ref`, `alt`, `indel`, `flanking_left`, `flanking_right`, `snp_id`, `gene`, `description`) 
        VALUES (" . $ID . ",\"" . $chr_tabel . "\"," . $pos_tabel . ",\"" . $ref_tabel . "\",\"" . $alt_tabel . "\"," . $indel_tabel . ",\"" . $flanking_left 
        . "\",\"" . $flanking_right . "\"," . $ID . ",\"" . $gene_tabel . "\",\"" . $description_tabel . "\")";
        echo $query . "<br>";
        break;
        
        $hasil = mysql_query($query);
        //echo mysql_error();
        
        //*
        if($hasil)
            $sukses_snp++;
        else
            $gagal_snp++;
        //break;
        //*/
    }

    echo "<br>" . 'sukses = ' . $sukses_snp . "<br>";
    echo 'gagal = ' . $gagal_snp . "<br>";
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PALMADB - SNP</title>

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
                    <li>
                        <a href="#">Tools</a>
                    </li>
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
                <h1>A Bootstrap Starter Template</h1>
                <p class="lead">Complete with pre-defined file paths that you won't have to change!</p>
                <ul class="list-unstyled">
                    <li>Bootstrap v3.3.1</li>
                    <li>jQuery v1.11.1</li>
                </ul>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>