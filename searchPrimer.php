<?php
    include "function.php";
    error_reporting(0);
    $connect = database_connect();
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
            <div class="col-sm-12">
                <h1 class="text-center">Search Primer</h1>
                <form class="form-horizontal" action="#" method="GET">
                    <?php
                        if(empty($_GET['primerSearch']) && $_GET['submit']=="Submit"){
                            echo "<div class='form-group has-warning'>
                                    <label for='primerSearch' class='col-sm-2 control-label'>Primer Contain</label>";
                        }
                        else{
                            echo "<div class='form-group'>
                                    <label for='primerSearch' class='col-sm-2 control-label'>Primer Contain</label>";
                        }
                    ?>
                        <div class="col-sm-4 ">
                            <?php
                            $input = "<input type='text' class='form-control' id='primerSearch' name='primerSearch' placeholder='";
                                if(!empty($_GET['primerSearch']) && $_GET['submit']=='Submit'){
                                    $input .= $_GET['primerSearch'];
                                    $input .= "'>";
                                }
                                elseif(empty($_GET['primerSearch']) && $_GET['submit']=="Submit"){
                                    $input .= "Ex : acgtgt";
                                    $input .= "'> <span class='label label-warning'>Tolong isi kotak ini</span>";
                                }
                                else
                                    $input .= "Ex : acgtgt'>";
                            echo $input;
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios" value="1" checked>
                                    All
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios" value="2">
                                    Forward
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios" value="3">
                                    Reverse
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
        <?php
        if(!empty($_GET['primerSearch'])){
            $query = "SELECT * FROM `primer` WHERE ";
            switch ($_GET['optionsRadios']) {
                case 2:
                    $query .= "`forward` LIKE '% ". $_GET['primerSearch'] ."%'";
                    break;
                case 3:
                    $query .= "`reverse` LIKE '%". $_GET['primerSearch'] ."%'";
                    break;
                case 1:
                    $query .= "`forward` LIKE '%". $_GET['primerSearch'] ."%' AND `reverse` LIKE '%". $_GET['primerSearch'] ."%'";
                    break;
            }
            //echo $query;
        ?>
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Primer Name</th>
                    <th>Forward</th>
                    <th>Reverse</th>
                </tr>
        <?php
                $paging     = new Paging;
                $batas      = 10;
                $posisi     = $paging->cariPosisi($batas);
                $jmlData    = mysql_num_rows(mysql_query($query));
                //echo $jmlData;
                $query .= ' LIMIT ' . $posisi . ',' . $batas;
                $tampil     = mysql_query($query);

                $no = $posisi + 1;
                while ($r=mysql_fetch_array($tampil)){
                    //echo strlen($r['flanking_left']); break;
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
        <?php
                $jmlHalaman = $paging->jumlahHalaman($jmlData,$batas);
                $linkHalaman = $paging->navHalamanSearch($_GET['halaman'], $jmlHalaman, $_GET['optionsRadios'], $_GET['primerSearch']);
                echo "$linkHalaman";
        }
        ?>
    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
