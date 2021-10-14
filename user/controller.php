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

	if($_POST['req'] == 'getDataPesanan') {
		$id = $_POST['id'];
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id' AND (status != 'finish' AND status != 'cancel') ORDER BY id DESC");
		$html = '';
		foreach ($pesanan as $dta) {
			$print = mysqli_query($conn, "SELECT * FROM agen WHERE id='".$dta["agen_id"]."'");
			$prt = mysqli_fetch_assoc($print);
			$nama_percetakan = $prt ? $prt["nama_percetakan"] : '<i>Tidak tersedia lagi</i>';	
			$badge = '';
			$aksi = '';
			if ($dta['status'] == 'panding') {
				$badge = 'badge-warning';
				$aksi = '<button class="btn btn-outline-primary btn-sm bayar" data-token="'.$dta['payment_token'].'" data-id="'.$dta['id'].'" data-kode="KPR-'.sprintf('%05s', $dta['id']).'" style="font-size: 12px;"><i class="fa fa-credit-card"></i> Bayar</button>';
			}
			else if ($dta['status'] == 'review') {
				$badge = 'badge-info';
				$aksi = '<button class="btn btn-outline-danger btn-sm" style="font-size: 12px;" data-toggle="modal" data-target="#modal-batal'.$dta['id'].'"><i class="fa fa-times-circle"></i> Batal</button>';
			}
			else if ($dta['status'] == 'proccess') {
				$badge = 'badge-alternate';
				$aksi = '<button class="btn btn-outline-danger btn-sm btn-disabled disabled" style="font-size: 12px;"><i class="fa fa-times-circle"></i> Batal</button>';
			}
			else if ($dta['status'] == 'done') {
				$badge = 'badge-success';
				$aksi = '<button class="btn btn-outline-success btn-sm" style="font-size: 12px;" data-toggle="modal" data-target="#modal-ambil'.$dta['id'].'"><i class="fa fa-check-circle"></i> Ambil</button>';
			}
			
			$bayar = [];
			if ($dta['metode_pembayaran'] == 'langsung') $bayar = ['text-primary', 'Bayar Langsung'];
			else $bayar = ['text-success', 'Pembayaran Virtual'];

			$html .= '
			<tr>
			<td>'.$nama_percetakan.'</td>
			<td>'.ucwords($dta['jenis_layanan']).'</td>
			<td class="text-center">
			'.date('d/m/Y', strtotime($dta['waktu_pesanan'])).'
			<b>'.date('H:i', strtotime($dta['waktu_pesanan'])).'</b>
			</td>
			<td class="text-center">
			'.date('d/m/Y', strtotime($dta['waktu_pengambilan'])).'
			<b>'.date('H:i', strtotime($dta['waktu_pengambilan'])).'</b>
			</td>
			<td>Rp.'.number_format($dta['harga']).'</td>
			<td class="text-center">
			<span class="'.$bayar[0].'" style="font-size: 12px;"><b>'.$bayar[1].'</b></span>
			</td>
			<td>
			<span class="badge '.$badge.' badge-pill">'.$dta['status'].'</span>
			</td>
			<td class="text-center">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target="#modal-detail'.$dta['id'].'"><i class="fa fa-list"></i> Detail</button>
			'.$aksi.'
			</td>
			</tr>
			';
		}

		if (!isset($dta)) {
			$html .= '
			<tr>
			<td colspan="8" class="text-center"><i>Tidak ada data</i></td>
			</tr>
			';
		}
		echo json_encode($html);
	}

	if($_POST['req'] == 'updateStatus') {
		$id = $_POST['id'];
		$status = $_POST['status'];

		$query = "UPDATE cetak SET status='$status' WHERE id='$id'";
		if (mysqli_query($conn, $query)) {
			$statusRes = "Berhasil";
			if ($status == 'review') $message = 'Pembayaran berhasil, pesanan anda sedang ditinjau.';
			else if ($status == 'cancel') $message = 'Pesanan anda telah dibatalkan';
			else if ($status == 'finish') {
				$message = 'Pesanan anda telah selesai dan telah dikonfirmasi';
				$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE id='$id'");
				$psn = mysqli_fetch_assoc($pesanan);
				if ($psn['metode_pembayaran'] == 'virtual') {
					$agen_id = $psn['agen_id'];
					$payment = mysqli_query($conn, "SELECT * FROM virtual_payment WHERE agen_id='$agen_id'");
					$pay = mysqli_fetch_assoc($payment);
					if ($pay) {
						$saldo = $pay['jumlah_saldo']+$psn['harga'];
						mysqli_query($conn, "UPDATE virtual_payment SET jumlah_saldo='$saldo' WHERE agen_id='$agen_id'");
					} else {
						$saldo = $psn['harga'];
						mysqli_query($conn, "INSERT INTO virtual_payment VALUES(NULL, '$agen_id', '$saldo', '0')");
					}
				}
			}
		} else {
			$statusRes = "Gagal";
			$message = 'Terjadi kesalahan, permintaan anda gagal diproses';
		}
		$res = [
			"status" => $statusRes,
			"message" => $message,
		];
		echo json_encode($res);
	}

	if($_POST['req'] == 'countPesanan') {
		$id = $_POST['id'];
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id' AND (status != 'finish' AND status != 'cancel')");
		$res = mysqli_num_rows($pesanan);
		echo json_encode($res);
	}

	if($_POST['req'] == 'cekStatusPayment') {
		$kode = $_POST['kode'];
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/".$kode."/status",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json",
				"Content-Type: application/json",
				"Authorization: Basic U0ItTWlkLXNlcnZlci1EbG54MzFvbzhMcWh0bGY3T1M3RkFSWGQ6"
			),
		));

		$response = curl_exec($curl);
		echo $response;
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