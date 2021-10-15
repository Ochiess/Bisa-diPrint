<?php 
// Midtrans
namespace Midtrans;

require('../vendor/midtrans/midtrans-php/Midtrans.php');

Config::$serverKey = "SB-Mid-server-Dlnx31oo8Lqhtlf7OS7FARXd";
Config::$isSanitized = true;

require '../koneksi.php';

if (isset($_POST['req'])) {
	header('Content-type: application/json');
	if ($_POST['req'] == 'storeData') {
		$user_id = $_POST['user_id'];
		$agen_id = $_POST['agen_id'];		
		$layanan = $_POST['layanan'];
		$jumlah_rangkap = $_POST['jumlah_rangkap'];
		$catatan = $_POST['catatan'];
		$waktu_pesanan = date('Y-m-d H:i:s');
		$waktu_pengambilan = $_POST['waktu_pengambilan'];
		$harga = $_POST['harga'];
		$metode_pembayaran = $_POST['metode_pembayaran'];

		mysqli_query($conn, "INSERT INTO cetak VALUES(NULL, '$user_id', '$agen_id', '$layanan', '', '$catatan', '$waktu_pesanan', '$waktu_pengambilan', '$harga', '$metode_pembayaran', '', '')");
		$cetak_id = mysqli_insert_id($conn);

		// Seleksi Layanan
		if ($layanan == 'dokumen') {
			// SET FILE
			$file = $_FILES['dokumen']['name'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$nama_file = "dokumen-".$user_id."-".date('Ymd-Hi').".".$ext;
			$file_tmp = $_FILES['dokumen']['tmp_name'];
			move_uploaded_file($file_tmp, '../assets/files/dokumen/'.$nama_file);

			$warna_tulisan = $_POST['warna_tulisan'];
			$jenis_kertas = $_POST['jenis_kertas'];
			$jilid = $_POST['jilid'];
			$jumlah_halaman = $_POST['jumlah_halaman'];

			mysqli_query($conn, "INSERT INTO cetak_dokumen VALUES(NULL, '$cetak_id', '$warna_tulisan', '$jenis_kertas', '$jilid', '$jumlah_halaman', '$jumlah_rangkap')");
		} else {
			// SET FILE
			$file = $_FILES['foto']['name'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$nama_file = "foto-".$user_id."-".date('Ymd-Hi').".".$ext;
			$file_tmp = $_FILES['foto']['tmp_name'];
			move_uploaded_file($file_tmp, '../assets/files/foto/'.$nama_file);

			$ukuran_foto = $_POST['ukuran_foto'];
			$ganti_latar = $_POST['ganti_latar'];

			mysqli_query($conn, "INSERT INTO cetak_foto VALUES(NULL, '$cetak_id', '$ukuran_foto', '$ganti_latar', '$jumlah_rangkap')");
		}

		// Seleksi Metode Pembayaran
		if ($metode_pembayaran == 'virtual') {
			$status = 'panding';

			// Midtrans Config
			$transaction_details = [
				'order_id' => "KPR-".sprintf('%05s', $cetak_id)
			];

			$item_details[] = [
				'id' => $cetak_id,
				'price' => (int)$harga,
				'quantity' => 1,
				'name' => "Total Pembayaran"
			];

			// Fill transaction details
			$transaction = [
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
			];
			$payment_token = Snap::getSnapToken($transaction);
		} else {
			$status = 'review';
			$payment_token = null;
		}

		mysqli_query($conn, "UPDATE cetak SET file='$nama_file', payment_token='$payment_token', status='$status' WHERE id='$cetak_id'");
		echo json_encode(["token" => $payment_token]);
	}
}
?>