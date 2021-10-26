<?php 

require '../koneksi.php';

if (isset($_POST['req'])) {
	header('Content-type: application/json');

	if($_POST['req'] == 'getDataPesanan') {
		$id = $_POST['id'];

		// Get Pesanan All
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND (status != 'finish' AND status != 'cancel') ORDER BY id DESC");
		$html_all = '';
		$no=1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';	
			$badge = '';
			$aksi = '';
			if ($dta['status'] == 'panding') $badge = 'badge-warning';
			else if ($dta['status'] == 'review') $badge = 'badge-info';
			else if ($dta['status'] == 'proccess') $badge = 'badge-alternate';
			else if ($dta['status'] == 'done') $badge = 'badge-success';
			
			$bayar = [];
			if ($dta['metode_pembayaran'] == 'langsung') $bayar = ['text-primary', 'Bayar Langsung'];
			else $bayar = ['text-success', 'Pembayaran Virtual'];

			$html_all .= '
			<tr>
			<td>'.$no.'</td>
			<td>'.$nama_pelanggan.'</td>
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
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail'.$dta['id'].'"><i class="fa fa-list"></i> Detail</button>
			</td>
			</tr>
			';
			$no++;
		}

		// Get Pesanan Review
		// rumus untuk logika prioritas
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'review' ORDER BY waktu_pengambilan ASC");
		$html_review = '';
		$no=1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';	

			if ($dta['jenis_layanan'] == 'dokumen') $file = '../assets/files/dokumen/'.$dta['file'];
			else $file = '../assets/files/foto/'.$dta['file'];

			$catatan = ($dta['catatan'] == '') ? '-' : $dta['catatan'];

			$isProses = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
			if (mysqli_num_rows($isProses) == 0) $info = 'data-info="0"';
			else $info = 'data-info="1"';

			if ($no == 1 && mysqli_num_rows($isProses) == 0) {
				$download = '<a href="'.$file.'" class="btn btn-outline-primary btn-sm" '.$info.' download=""><i class="fa fa-download"></i> Download</a>';
				$aksi = '<button class="btn btn-outline-success btn-sm" '.$info.' style="font-size: 12px;" data-toggle="modal" data-target=".modal-proses'.$dta['id'].'"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-outline-danger btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-tolak'.$dta['id'].'"><i class="fa fa-times-circle"></i></button>';
			} else {
				$download = '<button class="btn btn-outline-primary btn-sm disabled selesaikan" '.$info.'><i class="fa fa-download"></i> Download</button>';
				$aksi = '<button class="btn btn-outline-success btn-sm disabled selesaikan" '.$info.' style="font-size: 12px;"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-outline-danger btn-sm disabled selesaikan" style="font-size: 12px;"><i class="fa fa-times-circle"></i></button>';
			}

			$html_review .= '
			<tr>
			<td>'.$no.'</td>
			<td>'.$nama_pelanggan.'</td>
			<td>'.ucwords($dta['jenis_layanan']).'</td>
			<td class="text-center">
			'.date('d/m/Y', strtotime($dta['waktu_pesanan'])).'
			<b>'.date('H:i', strtotime($dta['waktu_pesanan'])).'</b>
			</td>
			<td class="text-center">
			'.date('d/m/Y', strtotime($dta['waktu_pengambilan'])).'
			<b>'.date('H:i', strtotime($dta['waktu_pengambilan'])).'</b>
			</td>
			<td>'.$catatan.'</td>
			<td class="text-center p-0">
			'.$download.'
			</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail'.$dta['id'].'"><i class="fa fa-list"></i></button>
			'.$aksi.'
			</td>
			</tr>
			';
			$no++;
		}

		// Get Pesanan Proccess
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
		$html_proccess = '';
		foreach ($pesanan as $prs) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='".$prs["user_id"]."'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';	

			if ($prs['jenis_layanan'] == 'dokumen') $file = '../assets/files/dokumen/'.$prs['file'];
			else $file = '../assets/files/foto/'.$prs['file'];

			$catatan = ($prs['catatan'] == '') ? '-' : $prs['catatan'];
			$isProses = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
			if (mysqli_num_rows($isProses) == 0) $info = 'data-info="0"';
			else $info = 'data-info="1"';

			$html_proccess .= '
			<tr>
			<td>'.$nama_pelanggan.'</td>
			<td>'.ucwords($prs['jenis_layanan']).'</td>
			<td class="text-center">
			'.date('d/m/Y', strtotime($prs['waktu_pesanan'])).'
			<b>'.date('H:i', strtotime($prs['waktu_pesanan'])).'</b>
			</td>
			<td class="text-center">
			'.date('d/m/Y', strtotime($prs['waktu_pengambilan'])).'
			<b>'.date('H:i', strtotime($prs['waktu_pengambilan'])).'</b>
			</td>
			<td>'.$catatan.'</td>
			<td class="text-center p-0">
			<a href="'.$file.'" class="btn btn-outline-primary btn-sm" '.$info.' download=""><i class="fa fa-download"></i> Download</a>
			</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail'.$prs['id'].'"><i class="fa fa-list"></i></button>
			<button class="btn btn-outline-success btn-sm" '.$info.' style="font-size: 12px;" data-toggle="modal" data-target=".modal-selesai'.$prs['id'].'"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-outline-danger btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-tolak'.$prs['id'].'"><i class="fa fa-times-circle"></i></button>
			</td>
			</tr>
			';
		}
		if (!isset($prs)) {
			$html_proccess .= '<tr><td colspan="7" class="text-center"><i>Tidak ada data</i></td></tr>';
		}

		// Get Pesanan Done
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'done' ORDER BY id DESC");
		$html_done = '';
		$no=1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';
			$telepon = $usr ? $usr["hp"] : '<i>Tidak tersedia lagi</i>';

			$bayar = [];
			if ($dta['metode_pembayaran'] == 'langsung') $bayar = ['text-primary', 'Bayar Langsung'];
			else $bayar = ['text-success', 'Pembayaran Virtual'];

			$html_done .= '
			<tr>
			<td>'.$no.'</td>
			<td>'.$nama_pelanggan.'</td>
			<td>'.$telepon.'</td>
			<td>'.ucwords($dta['jenis_layanan']).'</td>
			<td>Rp.'.number_format($dta['harga']).'</td>
			<td class="text-center">
			<span class="'.$bayar[0].'" style="font-size: 12px;"><b>'.$bayar[1].'</b></span>
			</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail'.$dta['id'].'"><i class="fa fa-list"></i> Detail</button>
			<button class="btn btn-outline-success btn-sm" style="font-size: 12px;" data-id="'.$dta['id'].'"><i class="fa fa-comment"></i> Chat</button>
			</td>
			</tr>
			';
			$no++;
		}

		// Get Pesanan Panding
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'panding' ORDER BY id DESC");
		$html_panding = '';
		$no=1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';
			$telepon = $usr ? $usr["hp"] : '<i>Tidak tersedia lagi</i>';

			$html_panding .= '
			<tr>
			<td>'.$no.'</td>
			<td>'.$nama_pelanggan.'</td>
			<td>'.$telepon.'</td>
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
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail'.$dta['id'].'"><i class="fa fa-list"></i> Detail</button>
			<button class="btn btn-outline-success btn-sm" style="font-size: 12px;" data-id="'.$dta['id'].'"><i class="fa fa-comment"></i> Chat</button>
			</td>
			</tr>
			';
			$no++;
		}

		$data = [
			'all' => $html_all,
			'review' => $html_review,
			'proccess' => $html_proccess,
			'done' => $html_done,
			'panding' => $html_panding,
		];
		echo json_encode($data);
	}

	if($_POST['req'] == 'updateStatus') {
		$id = $_POST['id'];
		$status = $_POST['status'];

		$query = "UPDATE cetak SET status='$status' WHERE id='$id'";
		if (mysqli_query($conn, $query)) {
			$statusRes = "Berhasil";
			if ($status == 'proccess') $message = 'Pesanan telah diterima, silahkan diproses sesuai detail pesanan';
			else if ($status == 'done') $message = 'Pesanan telah selesai diproses, harap tunggu pelanggan mengkonfirmasi pesanannya';
			else if ($status == 'cancel') $message = 'Pesanan telah dibatalkan, anda tidak dapat memprosesnya lagi';
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
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND (status != 'finish' AND status != 'cancel')");
		$all = mysqli_num_rows($pesanan);

		$get_panding = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'panding'");
		$panding = mysqli_num_rows($get_panding);

		$get_review = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'review'");
		$review = mysqli_num_rows($get_review);

		$get_proccess = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
		$proccess = mysqli_num_rows($get_proccess);

		$get_done = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'done'");
		$done = mysqli_num_rows($get_done);

		$notif = mysqli_query($conn, "SELECT * FROM notifikasi WHERE to_id='$id' AND (type != 'message' AND status = 'new')");
		$ntf = mysqli_num_rows($notif);

		$chat = mysqli_query($conn, "SELECT * FROM notifikasi WHERE to_id='$id' AND (type = 'message' AND status = 'new')");
		$jum_pesan = [];
		foreach ($chat as $msg) {
			$jum_pesan[] = $msg['from_id'];
		}
		$cht = count(array_unique($jum_pesan));

		$response = [
			"all" => $all,
			"panding" => $panding,
			"review" => $review,
			"proccess" => $proccess,
			"done" => $done,
			"notif" => $ntf,
			"pesan" => $cht,
		];
		echo json_encode($response);
	}

	if($_POST['req'] == 'getNotifPesan') {
		$id = $_POST['id'];

		$notif = mysqli_query($conn, "SELECT * FROM notifikasi WHERE to_id='$id' AND type != 'message' ORDER BY status ASC, waktu DESC");
		$content_notif = '';
		foreach ($notif as $dta) {
			if ($dta['status'] == 'new') $new = '<small><span class="badge badge-danger badge-pill pull-right">New</span></small>';
			else $new = '';

			if ($dta['type'] == 'live_pay') {
				$title = 'Pesanan Baru';
				$icon = '<div class="font-icon-wrapper font-icon-sm"><i class="pe-7s-print icon-gradient bg-malibu-beach"> </i></div>';
				$href = 'pesanan.php';
			} else if ($dta['type'] == 'virtual_pay') {
				$title = 'Pesanan Baru';
				$icon = '<div class="font-icon-wrapper font-icon-sm"><i class="pe-7s-credit icon-gradient bg-sunny-morning"></i></div>';
				$href = 'pesanan.php?virtual_pay=true';
			} else if ($dta['type'] == 'confirm_pay') {
				$title = 'Pembayaran Dikonfirmasi';
				$icon = '<div class="font-icon-wrapper font-icon-sm"><i class="pe-7s-cash icon-gradient bg-grow-early"> </i></div>';
				$href = 'pesanan.php';
			} else if ($dta['type'] == 'order_cancel') {
				$title = 'Pesanan Dibatalkan';
				$icon = '<div class="font-icon-wrapper font-icon-sm"><i class="pe-7s-close-circle icon-gradient bg-ripe-malin"> </i></div>';
				$href = 'riwayat.php';
			} else if ($dta['type'] == 'order_finish') {
				$title = 'Pesanan Selesai';
				$icon = '<div class="font-icon-wrapper font-icon-sm"><i class="pe-7s-check icon-gradient bg-grow-early"> </i></div>';
				$href = 'riwayat.php';
			} 

			if (date('ymd') == date('ymd', strtotime($dta['waktu']))) {
				$time = date('H.i', strtotime($dta['waktu']));
			} else {
				$time = date('d/m/y', strtotime($dta['waktu']));
			}

			$content_notif .= '
			<tr>
                <td>
                    <a href="#" class="btn text-left updateNotif" data-id="'.$dta['id'].'" data-href="'.$href.'">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="widget-content-left">
                                        '.$icon.'
                                    </div>
                                </div>
                                <div class="widget-content-left flex2 row">
                                    <div class="widget-heading  col-12">
                                        '.$new.' '.$title.'
                                    </div>
                                    <div class="widget-subheading opacity-5 text-justify  col-12">
                                    '.$dta['content'].'<br>
                                    <small>'.$time.'</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </td>
            </tr>
			';
		}

		$content_pesan = '';

		$response = [
			"notif" => $content_notif,
			"pesan" => $content_pesan,
		];
		echo json_encode($response);
	}

	if($_POST['req'] == 'updateNotif') {
		$id = $_POST['id'];
		mysqli_query($conn, "UPDATE notifikasi SET status='read' WHERE id='$id'");
		echo json_encode(true);
	}

	if($_POST['req'] == 'createMessage') {
		$send_by = $_POST['send_by'];
		$from_id = $_POST['from_id'];
		$to_id = $_POST['to_id'];
		$type = $_POST['type'];
		$content = $_POST['content'];

		$agen = mysqli_query($conn, "SELECT * FROM agen WHERE id='$from_id'");
		$agn = mysqli_fetch_assoc($agen);
		$agen = $agn ? $agn['nama_percetakan'] : 'Pencetakan';

		if ($type == 'order_start') {
			$title = 'Pesanan Diproses';
			$content = $agen." telah memproses pesanan anda";
		} else if ($type == 'order_refuse') {
			$title = 'Pesanan Dibatalkan';
		} else if ($type == 'order_done') {
			$title = 'Selesai Diproses';
			$content = $agen." telah menyelesaikan pesanan anda, silahkan dikonfirmasi";
		} else if ($type == 'message') $title = 'Pesan Baru';

		mysqli_query($conn, "INSERT INTO notifikasi VALUES(NULL, '$send_by', '$from_id', '$to_id', '$type', '$content', 'new', CURRENT_TIMESTAMP)");

		echo json_encode([
			"title" => $title,
			"message" => $content,
		]);
	}
}
?>