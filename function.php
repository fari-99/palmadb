<?php
	function database_connect()
	{
		$connect = mysql_connect("localhost","root","");
		if($connect)
		{
			$databaseConnect = mysql_select_db("project");
			if($databaseConnect)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}

	class Paging{
		function cariPosisi($batas){
			if(empty($_GET['halaman'])){
				$posisi = 0;
				$_GET['halaman'] = 1;
			}
			else{
				$posisi = ($_GET['halaman'] - 1) * $batas;
			}
			return $posisi;
		}

		function jumlahHalaman($jmldata, $batas){
			$jmlHalaman = ceil($jmldata/$batas);
			return $jmlHalaman;
		}

		function navHalaman($halamanAktif, $jmlHalaman,$ID){
			$linkHalaman = "";

			$linkHalaman .=	"<nav>
  								<ul class='pagination'>";
			for($i = 1; $i <= $jmlHalaman; $i++){
				//untuk yang tombol previous
				if($i == 1 && $i == $halamanAktif){
					$linkHalaman .=	"<li class='disabled'>
										<a href=\"$_SERVER[PHP_SELF]?halaman=1&ID=".$ID."\" aria-label='Previous'>
											<span aria-hidden='true'>&laquo;</span>
										</a>
									</li>";
				}

				if($i == $halamanAktif){
					$linkHalaman .=	"<li class='active'>
										<a href=\"$_SERVER[PHP_SELF]?halaman=".$i."&ID=".$ID."\">". $i 
											."<span class='sr-only'>(current)</span>
										</a>
									</li>";
				}
				else{
					$linkHalaman .=	"<li>
										<a href=\"$_SERVER[PHP_SELF]?halaman=".$i."&ID=".$ID."\">". $i ."</a>
									</li>";
				}

				if($i == $jmlHalaman && $i == $halamanAktif){
					$linkHalaman .=	"<li class='disabled'>
										<a href=\"$_SERVER[PHP_SELF]?halaman=".$jmlHalaman."&ID=".$ID."\" aria-label='Next'>
											<span aria-hidden='true'>&raquo;</span>
										</a>
									</li>";
				}

				//untuk yang tombol next
			}
			$linkHalaman .=		"</ul>
							</nav>";

			return $linkHalaman;
		}
	}
?>