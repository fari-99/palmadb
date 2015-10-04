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
                                    echo "<input type='text' class='form-control' name='posStart' id='posStart' placeholder='Minimum Pos = ".$r['pos']."'>";
                                ?>                                
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="posEnd" class="col-sm-1 control-label">End</label>
                            <div class="col-sm-3">
                                <?php
                                    $query = "SELECT DISTINCT `pos` FROM `snp` ORDER BY `pos` DESC LIMIT 0,1";
                                    $minimumPos = mysql_query($query);
                                    $r=mysql_fetch_array($minimumPos);
                                    echo "<input type='text' class='form-control' name='posEnd' id='posEnd' placeholder='Maximum Pos = ".$r['pos']."'>";
                                ?>                                
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="ref" class="col-sm-1 control-label">Referensi</label>
                            <div class="col-sm-3">
                                <?php
                                    if(empty($_POST['ref']))
                                        echo '<input type="text" class="form-control" name="ref" id="ref" placeholder="Ex : C">';
                                    else
                                        echo '<input type="text" class="form-control" name="ref" id="ref" placeholder="'.$_POST['ref'].'">';
                                ?>                                
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="alt" class="col-sm-1 control-label">Alternative</label>
                            <div class="col-sm-3">
                                <?php
                                    if(empty($_POST['alt']))
                                        echo '<input type="text" class="form-control" name="alt" id="alt" placeholder="Ex : G">';
                                    else
                                        echo '<input type="text" class="form-control" name="alt" id="alt" placeholder="'.$_POST['alt'].'">';
                                ?>                                
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="indel" class="col-sm-1 control-label">Indel</label>
                            <div class="col-sm-3">
                                <label class='checkbox-inline'>
                                    <input type='checkbox' id='indel' name='indel0' value='0' <?php if(isset($_POST['indel0'])) echo 'checked';?> > 0
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="indel" name="indel1" value="1" <?php if(isset($_POST['indel1'])) echo 'checked';?> > 1
                                </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-3">
                           <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
        <?php
            if($_POST['submit'] == "Submit"){
                $query = "SELECT * FROM `snp` WHERE ";
                if($_POST['dataID'] != "All")
                    $query .= "`snp_id` = '" . $_POST['dataID'] . "' AND ";

                if($_POST['chromosom'] != "All")
                    $query .= "`chr` = '" . $_POST['chromosom'] . "' AND ";

                if(!empty($_POST['posStart']) && !empty($_POST['posEnd']))
                    $query .= "`pos` BETWEEN " . $_POST['posStart'] . " AND " . $_POST['posEnd'];
                elseif (!empty($_POST['posStart'])) {
                    $query .= "`pos` >= " . $_POST['posStart'];
                }
                elseif (!empty($_POST['posEnd'])) {
                    $query .= "`pos` <= " . $_POST['posEnd'];
                }

                if((!empty($_POST['posStart'] || !empty($_POST['posEnd']))) && !empty($_POST['ref']))
                    $query .= " AND ";

                if(!empty($_POST['ref']))
                    $query .= "`ref` LIKE '%". $_POST['ref'] ."%'";

                if(((!empty($_POST['posStart'] || !empty($_POST['posEnd']))) || !empty($_POST['ref'])) && !empty($_POST['alt']))
                    $query .= " AND ";

                if(!empty($_POST['alt']))
                    $query .= "`alt` LIKE '%". $_POST['alt'] ."%'";

                if(((!empty($_POST['posStart'] || !empty($_POST['posEnd']))) || !empty($_POST['ref'])) && (!empty($_POST['indel1']) || !empty($_POST['indel0'])))
                    $query .= " AND ";

                if(isset($_POST['indel0']) && isset($_POST['indel1'])){
                    break;
                }
                elseif(isset($_POST['indel0'])){
                    $query .= "`indel` = " . $_POST['indel0'];
                }
                elseif(isset($_POST['indel1'])){
                    $query .= "`indel` = " . $_POST['indel1'];
                }
                echo $query;
        ?>        
            <div class="col-sm-12">
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
                    $tampil     = mysql_query($query);

                    $no = $posisi + 1;
                    while ($r=mysql_fetch_array($tampil)){
                        //echo strlen($r['flanking_left']); break;
                        echo '
                            <tr>
                                <td>'. $no .'</td>
                                <td>'. $r['sample_id'] .'</td>
                                <td>'. $r['chr'] .'</td>
                                <td>'. $r['pos'] .'</td>
                                <td>'. $r['ref'] .'</td>
                                <td>'. $r['alt'] .'</td>
                                <td>'. $r['indel'] .'</td>
                                <td>'. strtoupper($r['flanking_left']) .'</td>
                                <td>'. strtoupper($r['flanking_right']) .'</td>
                                <td>'. $r['gene'] .'</td>
                                <td>'. $r['description'] .'</td>
                            </tr>
                        ';
                        $no++;
                    }
                }
                ?>
                </table>
            </div>
    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>