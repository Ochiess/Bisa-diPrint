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
		$delivery = $_POST['delivery'];

		mysqli_query($conn, "INSERT INTO cetak VALUES(NULL, '$user_id', '$agen_id', '$layanan', '', '$catatan', '$waktu_pesanan', '$waktu_pengambilan', '$harga', '$metode_pembayaran', '', '$delivery', '')");
		$cetak_id = mysqli_insert_id($conn);
		$users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='$user_id'"));
		$nama_user = str_replace(' ', '-', $users['nama_lengkap']);

		// Seleksi Layanan
		if ($layanan == 'dokumen') {
			// SET FILE
			$file = $_FILES['dokumen']['name'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$nama_file = "Dokumen-".$nama_user."-".date('dmY-Hi').".".$ext;
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
			$nama_file = "Foto-".$nama_user."-".date('dmY-Hi').".".$ext;
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
			if ($metode_pembayaran == 'member') {
				$member = mysqli_query($conn, "SELECT * FROM member WHERE user_id='$user_id'");
				$mbr = mysqli_fetch_assoc($member);
				$saldo = $mbr['saldo'] - $harga;
				$saldo_digunakan = $mbr['saldo_digunakan'] + $harga;
				mysqli_query($conn, "UPDATE member SET saldo='$saldo', saldo_digunakan='$saldo_digunakan' WHERE user_id='$user_id'");
			}

			$status = 'review';
			$payment_token = null;
		}

		mysqli_query($conn, "UPDATE cetak SET file='$nama_file', payment_token='$payment_token', status='$status' WHERE id='$cetak_id'");
		echo json_encode([
			"token" => $payment_token,
			"agen_id" => $agen_id
		]);
	} else if ($_POST['req'] == 'topUp') {
		$user_id = $_POST['user_id'];
		$price = $_POST['price'];
		$paket = $_POST['paket'];
		$payment_id = rand().sprintf('%05s', $user_id);
		$created_at = date('Y-m-d H:i:s');

		// Midtrans Config
		$transaction_details = [
			'order_id' => $payment_id
		];

		$item_details[] = [
			'id' => $user_id,
			'price' => (int)$price,
			'quantity' => 1,
			'name' => $paket
		];

		// Fill transaction details
		$transaction = [
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
		];

		$cek = mysqli_query($conn, "SELECT * FROM member WHERE user_id='$user_id'");
		$cek = mysqli_fetch_assoc($cek);
		if (!$cek) {
			$payment_token = Snap::getSnapToken($transaction);
			mysqli_query($conn, "INSERT INTO member VALUES (NULL, '$user_id', 0, 0, '$price', '$payment_id', '$payment_token', '$created_at', 'regist')");
		} else if ($cek && $cek['status'] == 'active') {
			$payment_token = Snap::getSnapToken($transaction);
			mysqli_query($conn, "UPDATE member SET topup='$price', payment_id='$payment_id', payment_token='$payment_token', created_at='$created_at', status='renew'");
		} else {
			$payment_token = null;
		}

		echo json_encode([
			"token" => $payment_token
		]);
	}
}
?>