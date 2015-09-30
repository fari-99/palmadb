<?php
    include "excel_reader2.php";
    include "function.php";
    ini_set('max_execution_time', 300);
    error_reporting(0);
    $connect = database_connect();
    $ID = time();

    $data_snp       = new Spreadsheet_Excel_Reader($_FILES['snp']['tmp_name']);
    
    $baris_snp      = $data_snp->rowcount($sheet_index=0);
    $kolom_snp      = $data_snp->colcount($sheet_index=0);
    
    $sukses_snp     = 0;
    $gagal_snp      = 0;
    
    //untuk file snp, mengetahui letak cell colom apa aja
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
        if($nama == 'sample id')
            $sample_id = $i;
    }

    /*
        echo $sample_id . '<br>';
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
        $sample_id_tabel = $data_snp->val($j,$sample_id);

        $query = "INSERT INTO `snp` (`sample_id`, `chr`, `pos`, `ref`, `alt`, `indel`, `flanking_left`, `flanking_right`, `snp_id`, `gene`, `description`) 
        VALUES (" . "\"" . $sample_id_tabel . "\",\"" . $chr_tabel . "\"," . $pos_tabel . ",\"" . $ref_tabel . "\",\"" . $alt_tabel . "\"," . $indel_tabel . ",\"" . $flanking_left 
        . "\",\"" . $flanking_right . "\"," . $ID . ",\"" . $gene_tabel . "\",\"" . $description_tabel . "\")";
        //echo $query . "<br>";
        //break;
        
        $hasil = mysql_query($query);
        //*
        //echo mysql_error();
        if($hasil)
        {
            $sukses_snp++;
        }
        else
        {
            $gagal_snp++;
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
                <h1>Hasil Upload</h1>
                <?php
                    $total_data = $baris_snp - 1;
                    echo "<div class='alert alert-success' role='alert'>Sukses upload " . $sukses_snp . " dari " . $total_data . "</div>";
                    echo "<a class='btn btn-primary btn-lg' href='resultSNP.php?ID='". $ID ." role=button>See Result</a>"
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
