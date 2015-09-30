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
        //echo $query . "<br>";
        
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
