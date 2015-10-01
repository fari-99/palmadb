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
                <h1 class="text-center">Search SNP</h1>
                <form class="form-horizontal" action="#" method="POST">
                    <div class="form-group">
                        <label for="data" class="col-sm-1 control-label">Data</label>
                        <div class="col-sm-3">
                            <select name="dataID" id="data" class="form-control">
                                <?php
                                $query = "SELECT DISTINCT `snp_id` FROM `snp`";
                                $dataSNP = mysql_query($query);
                                echo '<option>All</option>';
                                while($r=mysql_fetch_array($dataSNP)){
                                    echo '
                                    <option>'. $r['snp_id'] .'</option>
                                    ';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="chr" class="col-sm-1 control-label">Chromosom</label>
                        <div class="col-sm-3">
                            <select name="chromosom" id="chr" class="form-control">
                                <?php
                                $query = "SELECT DISTINCT `chr` FROM `snp` ORDER BY `chr` ASC";
                                $dataSNP = mysql_query($query);
                                echo '<option>All</option>';
                                while($r=mysql_fetch_array($dataSNP)){
                                    echo '
                                    <option>'. $r['chr'] .'</option>
                                    ';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label class="col-sm-1 control-label">Position</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="posStart" name="posStart" class="col-sm-1 control-label">Start</label>
                            <div class="col-sm-3">
                                <?php
                                    $query = "SELECT DISTINCT `pos` FROM `snp` ORDER BY `pos` ASC LIMIT 0,1";
                                    $minimumPos = mysql_query($query);
                                    $r=mysql_fetch_array($minimumPos);
                                    echo '<input type="text" class="form-control" name="posStart" id="posStart" placeholder="Minimum Pos = '.$r['pos'].'">';
                                ?>                                
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="posStart" class="col-sm-1 control-label">End</label>
                            <div class="col-sm-3">
                                <?php
                                    $query = "SELECT DISTINCT `pos` FROM `snp` ORDER BY `pos` DESC LIMIT 0,1";
                                    $minimumPos = mysql_query($query);
                                    $r=mysql_fetch_array($minimumPos);
                                    echo '<input type="text" class="form-control" name="posEnd" id="posStart" placeholder="Maximum Pos = '.$r['pos'].'">';
                                ?>                                
                            </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-3">
                            <a class="btn btn-info" href="advancedSearchSNP.php" role="button">Advanced Search</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
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
