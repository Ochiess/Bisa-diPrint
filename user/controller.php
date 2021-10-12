<?php 

require '../koneksi.php';

if (isset($_POST['req'])) {
	header('Content-type: application/json');
	if($_POST['req'] == 'getNumberPage') {
		$file = $_FILES['file'];
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		if ($ext == 'docx' || $ext == 'doc') {
			$countPage = CountPagesDocx($file['tmp_name']);
		} else if ($ext == 'pdf') {
			$countPage = CountPdfPages($file['tmp_name']);			
		}
		echo json_encode($countPage);
	}

	if($_POST['req'] == 'getJenisKertas') {
		$id = $_POST['id'];
		$jenis_kertas = mysqli_query($conn, "SELECT * FROM jenis_kertas WHERE id='$id'");
		$dta = mysqli_fetch_assoc($jenis_kertas);
		echo json_encode($dta);
	}

	if($_POST['req'] == 'getJenisJilid') {
		$id = $_POST['id'];
		$jilid = mysqli_query($conn, "SELECT * FROM jilid WHERE id='$id'");
		$dta = mysqli_fetch_assoc($jilid);
		echo json_encode($dta);
	}

	if($_POST['req'] == 'getUkuranFoto') {
		$id = $_POST['id'];
		$ukuran_foto = mysqli_query($conn, "SELECT * FROM ukuran_foto WHERE id='$id'");
		$dta = mysqli_fetch_assoc($ukuran_foto);
		echo json_encode($dta);
	}
}

// Get count number of page docx and doc file
function CountPagesDocx($filename)
{
	$zip = new ZipArchive();

	if($zip->open($filename) === true)
	{  
		if(($index = $zip->locateName('docProps/app.xml')) !== false)
		{
			$data = $zip->getFromIndex($index);
			$zip->close();

			$xml = new SimpleXMLElement($data);
			return get_object_vars($xml->Pages)[0];
		}
		$zip->close();
	}
	return 0;
}

// Get count number of page pdf file
function CountPdfPages($filename) {
	$pdftext = file_get_contents($filename);
	$num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
	return $num;
}
?>