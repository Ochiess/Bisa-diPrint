<?php

require '../koneksi.php';

if (isset($_POST['req'])) {
	header('Content-type: application/json');

	if ($_POST['req'] == 'getDataPesanan') {
		$id = $_POST['id'];

		// Get Pesanan All
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND (status != 'finish' AND status != 'cancel') ORDER BY id DESC");
		$html_all = '';
		$no = 1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='" . $dta["user_id"] . "'");
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
			else if ($dta['metode_pembayaran'] == 'member') $bayar = ['text-warning', 'Saldo Member'];
			else $bayar = ['text-success', 'Pembayaran Virtual'];

			$html_all .= '
			<tr>
			<td>' . $no . '</td>
			<td>' . $nama_pelanggan . '</td>
			<td>' . ucwords($dta['jenis_layanan']) . '</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($dta['waktu_pesanan'])) . '
			<b>' . date('H:i', strtotime($dta['waktu_pesanan'])) . '</b>
			</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($dta['waktu_pengambilan'])) . '
			<b>' . date('H:i', strtotime($dta['waktu_pengambilan'])) . '</b>
			</td>
			<td>Rp.' . number_format($dta['harga']) . '</td>
			<td class="text-center">
			<span class="' . $bayar[0] . '" style="font-size: 12px;"><b>' . $bayar[1] . '</b></span>
			</td>
			<td>
			<span class="badge ' . $badge . ' badge-pill">' . $dta['status'] . '</span>
			</td>
			<td class="text-center">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail' . $dta['id'] . '"><i class="fa fa-list"></i> Detail</button>
			</td>
			</tr>
			';
			$no++;
		}
		if ($no == 1) {
			$html_all .= '<tr><td colspan="9" class="text-center"><i>Tidak ada data</i></td></tr>';
		}

		// Get Pesanan Review
		// rumus untuk logika prioritas

		// OLD
		// $pesanan = mysqli_query($conn, "SELECT cetak.*, member.status as is_member FROM cetak LEFT JOIN member USING(user_id) WHERE agen_id='$id' AND cetak.status = 'review' ORDER BY is_member='active' DESC, metode_pembayaran='member' DESC, metode_pembayaran='virtual' DESC, waktu_pengambilan ASC");

		// NEW
		$pesanan = mysqli_query($conn, "SELECT cetak.*, member.status, cetak_dokumen.jumlah_halaman as jum_hal, cetak_dokumen.jumlah_rangkap as jum_rangkap, cetak_foto.jumlah_rangkap as ft_rangkap FROM cetak LEFT JOIN member ON cetak.user_id=member.user_id LEFT JOIN cetak_dokumen ON cetak_dokumen.cetak_id=cetak.id LEFT JOIN cetak_foto ON cetak_foto.cetak_id = cetak.id WHERE agen_id='$id' AND cetak.status = 'review' ORDER BY member.status='active' DESC, cetak.metode_pembayaran='member' DESC, cetak.metode_pembayaran='virtual' DESC, jum_hal*jum_rangkap DESC, ft_rangkap DESC, cetak.waktu_pengambilan ASC");

		$html_review = '';
		$no = 1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='" . $dta["user_id"] . "'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';

			if ($dta['jenis_layanan'] == 'dokumen') $file = '../assets/files/dokumen/' . $dta['file'];
			else $file = '../assets/files/foto/' . $dta['file'];

			$catatan = ($dta['catatan'] == '') ? '-' : $dta['catatan'];

			$isProses = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
			if (mysqli_num_rows($isProses) == 0) $info = 'data-info="0"';
			else $info = 'data-info="1"';

			if ($no == 1 && mysqli_num_rows($isProses) == 0) {
				$download = '<a href="' . $file . '" class="btn btn-outline-primary btn-sm" ' . $info . ' download=""><i class="fa fa-download"></i> Download</a>';
				$aksi = '<button class="btn btn-outline-success btn-sm" ' . $info . ' style="font-size: 12px;" data-toggle="modal" data-target=".modal-proses' . $dta['id'] . '"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-outline-danger btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-tolak' . $dta['id'] . '"><i class="fa fa-times-circle"></i></button>';
			} else {
				$download = '<button class="btn btn-outline-primary btn-sm disabled selesaikan" ' . $info . '><i class="fa fa-download"></i> Download</button>';
				$aksi = '<button class="btn btn-outline-success btn-sm disabled selesaikan" ' . $info . ' style="font-size: 12px;"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-outline-danger btn-sm disabled selesaikan" style="font-size: 12px;"><i class="fa fa-times-circle"></i></button>';
			}

			$html_review .= '
			<tr>
			<td>' . $no . '</td>
			<td>' . $nama_pelanggan . '</td>
			<td>' . ucwords($dta['jenis_layanan']) . '</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($dta['waktu_pesanan'])) . '
			<b>' . date('H:i', strtotime($dta['waktu_pesanan'])) . '</b>
			</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($dta['waktu_pengambilan'])) . '
			<b>' . date('H:i', strtotime($dta['waktu_pengambilan'])) . '</b>
			</td>
			<td>' . $catatan . '</td>
			<td class="text-center p-0">
			' . $download . '
			</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail' . $dta['id'] . '"><i class="fa fa-list"></i></button>
			' . $aksi . '
			</td>
			</tr>
			';
			$no++;
		}
		if ($no == 1) {
			$html_review .= '<tr><td colspan="8" class="text-center"><i>Tidak ada data</i></td></tr>';
		}

		// Get Pesanan Proccess
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
		$html_proccess = '';
		foreach ($pesanan as $prs) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='" . $prs["user_id"] . "'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';

			if ($prs['jenis_layanan'] == 'dokumen') $file = '../assets/files/dokumen/' . $prs['file'];
			else $file = '../assets/files/foto/' . $prs['file'];

			$catatan = ($prs['catatan'] == '') ? '-' : $prs['catatan'];
			$isProses = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'proccess'");
			if (mysqli_num_rows($isProses) == 0) $info = 'data-info="0"';
			else $info = 'data-info="1"';

			$html_proccess .= '
			<tr>
			<td>' . $nama_pelanggan . '</td>
			<td>' . ucwords($prs['jenis_layanan']) . '</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($prs['waktu_pesanan'])) . '
			<b>' . date('H:i', strtotime($prs['waktu_pesanan'])) . '</b>
			</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($prs['waktu_pengambilan'])) . '
			<b>' . date('H:i', strtotime($prs['waktu_pengambilan'])) . '</b>
			</td>
			<td>' . $catatan . '</td>
			<td class="text-center p-0">
			<a href="' . $file . '" class="btn btn-outline-primary btn-sm" ' . $info . ' download=""><i class="fa fa-download"></i> Download</a>
			</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail' . $prs['id'] . '"><i class="fa fa-list"></i></button>
			<button class="btn btn-outline-success btn-sm" ' . $info . ' style="font-size: 12px;" data-toggle="modal" data-target=".modal-selesai' . $prs['id'] . '"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-outline-danger btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-tolak' . $prs['id'] . '"><i class="fa fa-times-circle"></i></button>
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
		$no = 1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='" . $dta["user_id"] . "'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';
			$telepon = $usr ? $usr["hp"] : '<i>Tidak tersedia lagi</i>';

			$bayar = [];
			if ($dta['metode_pembayaran'] == 'langsung') $bayar = ['text-primary', 'Bayar Langsung'];
			else $bayar = ['text-success', 'Pembayaran Virtual'];

			if ($dta['delivery'] == 1) $delivery = '<b class="text-info">DIANTAR</b>';
			else $delivery = '<b class="text-secondary">TIDAK</b>';

			$html_done .= '
			<tr>
			<td>' . $no . '</td>
			<td>' . $nama_pelanggan . '</td>
			<td>' . $telepon . '</td>
			<td>' . ucwords($dta['jenis_layanan']) . '</td>
			<td>Rp.' . number_format($dta['harga']) . '</td>
			<td class="text-center">
			<span class="' . $bayar[0] . '" style="font-size: 12px;"><b>' . $bayar[1] . '</b></span>
			</td>
			<td class="text-center">' . $delivery . '</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm mt-1" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail' . $dta['id'] . '"><i class="fa fa-list"></i> Detail</button>
			<button class="btn btn-outline-primary btn-sm mt-1 show-chat" style="font-size: 12px;" data-id="' . $usr['id'] . '"><i class="fa fa-comment"></i> Chat</button>
			<button class="btn btn-outline-success btn-sm mt-1 mb-1 telah-diambil" style="font-size: 12px;" data-id="' . $dta['id'] . '"><i class="fa fa-check"></i> Telah Diambil</button>
			</td>
			</tr>
			';
			$no++;
		}
		if ($no == 1) {
			$html_done .= '<tr><td colspan="8" class="text-center"><i>Tidak ada data</i></td></tr>';
		}

		// Get Pesanan Panding
		$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status = 'panding' ORDER BY id DESC");
		$html_panding = '';
		$no = 1;
		foreach ($pesanan as $dta) {
			$users = mysqli_query($conn, "SELECT * FROM user WHERE id='" . $dta["user_id"] . "'");
			$usr = mysqli_fetch_assoc($users);
			$nama_pelanggan = $usr ? $usr["nama_lengkap"] : '<i>Tidak tersedia lagi</i>';
			$telepon = $usr ? $usr["hp"] : '<i>Tidak tersedia lagi</i>';

			$html_panding .= '
			<tr>
			<td>' . $no . '</td>
			<td>' . $nama_pelanggan . '</td>
			<td>' . $telepon . '</td>
			<td>' . ucwords($dta['jenis_layanan']) . '</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($dta['waktu_pesanan'])) . '
			<b>' . date('H:i', strtotime($dta['waktu_pesanan'])) . '</b>
			</td>
			<td class="text-center">
			' . date('d/m/Y', strtotime($dta['waktu_pengambilan'])) . '
			<b>' . date('H:i', strtotime($dta['waktu_pengambilan'])) . '</b>
			</td>
			<td>Rp.' . number_format($dta['harga']) . '</td>
			<td class="text-center p-0">
			<button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target=".modal-detail' . $dta['id'] . '"><i class="fa fa-list"></i> Detail</button>
			<button class="btn btn-outline-success btn-sm" style="font-size: 12px;" data-id="' . $dta['id'] . '"><i class="fa fa-comment"></i> Chat</button>
			</td>
			</tr>
			';
			$no++;
		}
		if ($no == 1) {
			$html_panding .= '<tr><td colspan="8" class="text-center"><i>Tidak ada data</i></td></tr>';
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

	if ($_POST['req'] == 'updateStatus') {
		$id = $_POST['id'];
		$status = $_POST['status'];

		$query = "UPDATE cetak SET status='$status' WHERE id='$id'";
		if (mysqli_query($conn, $query)) {
			$statusRes = "Berhasil";
			if ($status == 'proccess') $message = 'Pesanan telah diterima, silahkan diproses sesuai detail pesanan';
			else if ($status == 'done') $message = 'Pesanan telah selesai diproses, harap tunggu pelanggan mengkonfirmasi pesanannya';
			else if ($status == 'cancel') $message = 'Pesanan telah dibatalkan, anda tidak dapat memprosesnya lagi';
			else if ($status == 'finish') $message = 'Pesanan telah diambil oleh pelanggan';
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

	if ($_POST['req'] == 'countPesanan') {
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

	if ($_POST['req'] == 'getNotifPesan') {
		$id = $_POST['id'];

		$notif = mysqli_query($conn, "SELECT * FROM notifikasi WHERE to_id='$id' AND (send_by='user' AND type != 'message') ORDER BY status ASC, waktu DESC");
		$content_notif = '';
		foreach ($notif as $dta) {
			if ($dta['status'] == 'new') $new = '<small><span class="badge badge-danger badge-pill pull-right">New</span></small>';
			else $new = '';

			$title = '';
			$icon = '';
			$href = '';

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
                    <a href="#" class="btn text-left updateNotif" data-id="' . $dta['id'] . '" data-href="' . $href . '">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="widget-content-left">
                                        ' . $icon . '
                                    </div>
                                </div>
                                <div class="widget-content-left flex2 row">
                                    <div class="widget-heading  col-12">
                                        ' . $new . ' ' . $title . '
                                    </div>
                                    <div class="widget-subheading opacity-5 text-justify  col-12">
                                    ' . $dta['content'] . '<br>
                                    <small>' . $time . '</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </td>
            </tr>
			';
		}

		if ($content_notif == '') {
			$content_notif = '<h6 class="text-center mt-3"><i>Belum ada notifikasi</i></h6>';
		}

		$pesan = mysqli_query($conn, "SELECT * FROM notifikasi WHERE type = 'message' AND (to_id='$id' OR from_id='$id') ORDER BY
		id DESC");
		$jum_pesan = [];
		foreach ($pesan as $msg) {
			if ($msg['send_by'] == 'agen') $jum_pesan[] = $msg['to_id'];
			else $jum_pesan[] = $msg['from_id'];
		}

		$content_pesan = '';
		foreach (array_unique($jum_pesan) as $key) {
			$pesan_ = mysqli_query($conn, "SELECT * FROM notifikasi WHERE type='message' AND ((from_id='$key' AND to_id='$id') OR
			(from_id='$id' AND to_id='$key')) ORDER BY id DESC");
			$pesan_new = mysqli_query($conn, "SELECT * FROM notifikasi WHERE from_id='$key' AND (status = 'new' AND type='message') ORDER BY id DESC");
			$cnt = mysqli_num_rows($pesan_new);
			$last = mysqli_fetch_assoc($pesan_);

			if (isset($last['id'])) {
				if ($last['send_by'] == 'agen') {
					$user_id = $last['to_id'];
					$text = 'Anda: ' . $last['content'];
				} else {
					$user_id = $last['from_id'];
					$text = $last['content'];
				}

				if (strlen($text) > 35) {
					$cht_content = substr($text, 0, 35) . '...';
				} else {
					$cht_content = $text . "&nbsp;&nbsp;&nbsp;";
				}

				$user = mysqli_query($conn, "SELECT * FROM user WHERE id='$user_id'");
				$usr = mysqli_fetch_assoc($user);

				if (date('Ymd', strtotime($last['waktu'])) == date('Ymd')) $waktu = date('H.i', strtotime($last['waktu']));
				else $waktu = date('d/m/y', strtotime($last['waktu']));

				if ($cnt == 0) {
					$cnt_view = '';
					$time_color = 'secondary';
				} else {
					$cnt_view = '<span class="badge badge-success badge-pill pull-right px-0 py-1">' . $cnt . '</span>';
					$time_color = 'success';
				}

				if (isset($usr['id'])) {
					$photo = $usr['photo'] ? $usr['photo'] : 'default.png';

					$content_pesan .= '
					<tr>
						<td>
							<a href="#" class="btn text-left show-chat w-100" data-id="' . $usr['id'] . '">
								<div class="widget-content p-0">
									<div class="widget-content-wrapper">
										<div class="widget-content-left mr-3">
											<div class="widget-content-left">
												<img width="40" height="40" class="rounded-circle" src="../user/img/' . $photo . '" alt="">
											</div>
										</div>
										<div class="widget-content-left row w-100">
											<div class="widget-heading col-12">
												<small class="pull-right text-' . $time_color . ' ml-0">' . $waktu . '</small>
												' . $usr['nama_lengkap'] . '
											</div>
											<div class="widget-subheading opacity-5 col-12">
												' . $cnt_view . '
												' . $cht_content . '
											</div>
										</div>
									</div>
								</div>
							</a>
						</td>
					</tr>
					';
				}
			}
		}

		if ($content_pesan == '') {
			$content_pesan = '<h6 class="text-center mt-3"><i>Belum ada pesan</i></h6>';
		}

		$response = [
			"notif" => $content_notif,
			"pesan" => $content_pesan,
		];
		echo json_encode($response);
	}

	if ($_POST['req'] == 'getChat') {
		$agen_id = $_POST['agen_id'];
		$user_id = $_POST['user_id'];

		mysqli_query($conn, "UPDATE notifikasi SET status='read' WHERE from_id='$user_id' AND type='message'");

		$user = mysqli_query($conn, "SELECT * FROM user WHERE id='$user_id'");
		$usr = mysqli_fetch_assoc($user);
		$photo = $usr['photo'] ? $usr['photo'] : 'default.png';
		$chat_header = '
		<img class="avatar mr-1" src="../user/img/' . $photo . '">
        <b>' . $usr['nama_lengkap'] . '</b>
		';

		$get_chat = mysqli_query($conn, "SELECT * FROM notifikasi WHERE type='message' AND ((from_id='$user_id' AND
		to_id='$agen_id') OR (from_id='$agen_id' AND to_id='$user_id')) ORDER BY id ASC");

		$date = [];
		foreach ($get_chat as $tgl) {
			$date[] = date('d/m/Y', strtotime($tgl['waktu']));
		}

		$chat_content = '';
		foreach (array_unique($date) as $dat) {
			if ($dat == date('d/m/Y')) $chat_content .= '<div class="media media-meta-day">Hari ini</div>';
			else $chat_content .= '<div class="media media-meta-day">' . $dat . '</div>';
			foreach ($get_chat as $cht) {
				if ($dat == date('d/m/Y', strtotime($cht['waktu']))) {
					if ($cht['send_by'] == 'agen') $set = 'media-chat-reverse';
					else $set = 'media-chat-in justify-content-end';

					$chat_content .= '
					<div class="media media-chat pb-0 pt-0 ' . $set . '">
						<div class="media-body">
							<p>
								<span>' . $cht['content'] . '</span>
								<small class="meta pull-right mt-2">&nbsp;<time>' . date('H.i', strtotime($cht['waktu'])) . '</time></small>
							</p>
						</div>
					</div>
					';
				}
			}
		}

		if ($chat_content == '') {
			$chat_content = '
			<div class="text-center mt-2">
				<i>Belum ada chat. Silahkan mulai obrolan</i>
			</div>
			';
		}

		$response = [
			"header" => $chat_header,
			"content" => $chat_content,
		];
		echo json_encode($response);
	}

	if ($_POST['req'] == 'updateNotif') {
		$id = $_POST['id'];
		mysqli_query($conn, "UPDATE notifikasi SET status='read' WHERE id='$id'");
		echo json_encode(true);
	}

	if ($_POST['req'] == 'createMessage') {
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
			$content = $agen . " telah memproses pesanan anda";
		} else if ($type == 'order_refuse') {
			$title = 'Pesanan Dibatalkan';
		} else if ($type == 'order_done') {
			$title = 'Selesai Diproses';
			$content = $agen . " telah menyelesaikan pesanan anda, silahkan dikonfirmasi";
		} else if ($type == 'message') $title = 'Pesan Baru';

		mysqli_query($conn, "INSERT INTO notifikasi VALUES(NULL, '$send_by', '$from_id', '$to_id', '$type', '$content', 'new', CURRENT_TIMESTAMP)");

		echo json_encode([
			"title" => $title,
			"message" => $content,
		]);
	}
}
