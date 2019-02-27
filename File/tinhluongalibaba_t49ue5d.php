<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

function layttid($conn, $module, $id, $field)
{
	if ($id != '') {
		$sql = 'select * from ' . $module . ' where ' . $module . '_id = ' . $id;
		$info = select_info($conn, $sql);
		return $info[$field];
	} else {
		return '';
	}
}

if (isset($_GET['xuatexcel'])) {
	$this->layout('Student/layout2');
	$thang = $_GET['thang'];
	$ngaydauthang = date('Y-m-d', strtotime(date('Y-m-01', strtotime($thang))));
	$ngaycuoithang = date("Y-m-t", strtotime($thang));

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=data.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	?>
    <div class="col-md-12" style="overflow-x: scroll;margin-top: 15px;">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <center><h3>Báo cáo tính lương bộ phận kinh doanh</h3></center>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center"
               style="font-family: 'Times New Roman';width: 100%;font-size: larger" border="1" cellspacing="0">
            <thead>
            <tr>
                <th>STT</th>
                <th>MÃ NV</th>
                <th>Chi nhánh</th>
                <th>Họ và tên</th>
                <th>Chức vụ</th>
                <th>Mã chức vụ</th>
                <th>Tình trạng</th>
                <th>Lương cơ bản</th>
                <th>Lương trách nhiệm</th>
                <th>Lương theo ngày công</th>
                <th>Thưởng bước chân</th>
                <th>Lương KPI</th>
                <th>Tiền thưởng gia hạn</th>
                <th>Thưởng sĩ số lớp trung bình</th>
                <th>Lương dạy tại các đơn vị liên kết</th>
                <th>Sinh trắc vân tay</th>
                <th>công dạy part time 20.000đ</th>
                <th>Lương trợ giảng (GV Part time)</th>
                <th>Thưởng cho trợ giảng/lễ tân dựa trên số HV toàn CN</th>
                <th>Thưởng tuyển dụng</th>
                <th>Thưởng khai trương</th>
                <th>Lương khác</th>
                <th>Hỗ trợ đi lại</th>
                <th>Điện thoại</th>
                <th>Trừ khác</th>
				<?php
				$a = 26;
				$listcot = select_list($conn, "select * from t8s267u left join t1xs6iy on T8s267u_id = T1xs6iy_ViFbjy order by T8s267u_7p0wbU asc");
				foreach ($listcot as $val) {
					$a++;
					?>
                    <th><?= $val['T8s267u_oCyQn4'] ?><br><?= $val['T1xs6iy_Scfp8B'] ?></th>
					<?php
				}
				?>
                <th>Tổng lương</th>
            </tr>
            <tr>
                <th><span style="color: red;">[0]</span></th>
                <th><span style="color: red;">[1]</span></th>
                <th><span style="color: red;">[2]</span></th>
                <th><span style="color: red;">[3]</span></th>
                <th><span style="color: red;">[4]</span></th>
                <th><span style="color: red;">[5]</span></th>
                <th><span style="color: red;">[6]</span></th>
                <th><span style="color: red;">[7]</span></th>
                <th><span style="color: red;">[8]</span></th>
                <th><span style="color: red;">[9]</span></th>
                <th><span style="color: red;">[10]</span></th>
                <th><span style="color: red;">[11]</span></th>
                <th><span style="color: red;">[12]</span></th>
                <th><span style="color: red;">[13]</span></th>
                <th><span style="color: red;">[14]</span></th>
                <th><span style="color: red;">[15]</span></th>
                <th><span style="color: red;">[16]</span></th>
                <th><span style="color: red;">[17]</span></th>
                <th><span style="color: red;">[18]</span></th>
                <th><span style="color: red;">[19]</span></th>
                <th><span style="color: red;">[20]</span></th>
                <th><span style="color: red;">[21]</span></th>
                <th><span style="color: red;">[22]</span></th>
                <th><span style="color: red;">[23]</span></th>
                <th><span style="color: red;">[24]</span></th>
				<?php
				$a = 24;
				$listcot = select_list($conn, "select * from t8s267u order by T8s267u_7p0wbU desc");
				foreach ($listcot as $val) {
					$a++;
					?>
                    <th><span style="color: red;">[<?= $a ?>]</span></th>
					<?php
				}
				?>
                <th><span style="color: red;">[28]</span></th>

            </tr>
            </thead>
            <tbody>
			<?php
			$nhanvien = select_list($conn, "select * from tuxrdif");
			$a = 0;
			$tongtatca = 0;
			foreach ($nhanvien as $value) {
				$a++;
				$dulieunv = select_info($conn, "select * from tciajwg where Tciajwg_id = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$trangthai = select_info($conn, "select * from dataman where Id = '" . $dulieunv['Tciajwg_grKyWh'] . "'");
				$luongcb = select_info($conn, "select * from trljq1p where Trljq1p_4KtMGq = '" . $value['Tuxrdif_KPjwc9'] . "'");

				if (!isset($luongcb['Trljq1p_KshifC']) && empty($luongcb['Trljq1p_KshifC'])) {
					$luongcb['Trljq1p_KshifC'] = 0;
				}
				if (!isset($luongcb['Trljq1p_CgotTR']) && empty($luongcb['Trljq1p_CgotTR'])) {
					$luongcb['Trljq1p_CgotTR'] = 0;
				}

				$lichlamviec = select_list($conn, "select * from ty1hkmi where Ty1hkmi_NhSVlU = '" . $value['Tuxrdif_KPjwc9'] . "' and Ty1hkmi_rkPXsS >= '" . $ngaydauthang . "' and Ty1hkmi_AWaZnT <= '" . $ngaycuoithang . "'");


				$chitieutheonv = select_info($conn, "select * from txvf82s where Txvf82s_wx07Ii = '" . $value['Tuxrdif_KPjwc9'] . "' and Txvf82s_v78Awo >= '" . $ngaydauthang . "' and Txvf82s_OfhHAb <= '" . $ngaycuoithang . "'");

				$tongdoanhthunv = select_info($conn, "select SUM(Tdrni78_fzRkEM) as tongdt from tdrni78 left join t9jrlb7 on T9jrlb7_id = Tdrni78_PYrBpR where T9jrlb7_BJOgCZ = '" . $value['Tuxrdif_KPjwc9'] . "' and Tdrni78_pEzf7v between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$tyledoanhthu = ($tongdoanhthunv['tongdt'] / $chitieutheonv['Txvf82s_ZYrbPO']) * 100;

				$mucthuong = select_list($conn, "select * from t6ykwd8 where T6ykwd8_IHQEKS <= '" . $tyledoanhthu . "' order by T6ykwd8_IHQEKS desc limit 1");

				$luongkpi = 0;
				foreach ($mucthuong as $value7) {
					$luongkpi = ($tongdoanhthunv['tongdt'] * $value7['T6ykwd8_IZn69G']) / 100;
				}

				$nguoiban = select_info($conn, "select SUM(T916rxn_gctPa2) as tienbanvt from t916rxn where T916rxn_DacuS4 between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and T916rxn_p20QnX = '" . $value['Tuxrdif_KPjwc9'] . "'");

				$nguoidoc = select_info($conn, "select SUM(T916rxn_gctPa2) as tiendocvt from t916rxn where T916rxn_DacuS4 between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and T916rxn_6rlB3q = '" . $value['Tuxrdif_KPjwc9'] . "'");

				$doanhthudoc = select_info($conn, "select * from tjz9g2t where Tjz9g2t_E4LP8n = 71");
				$doanhthuban = select_info($conn, "select * from tjz9g2t where Tjz9g2t_E4LP8n = 72");

				$tienban = ($nguoiban['tienbanvt'] * $doanhthuban['Tjz9g2t_f4qw0k']) / 100;
				$tiendoc = ($nguoidoc['tiendocvt'] * $doanhthudoc['Tjz9g2t_f4qw0k']) / 100;

				$tongtienvantay = $tienban + $tiendoc;

				$thuongtd = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tientd from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 67  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$thuongkt = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tienkt from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 68  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$thuongkh = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tienkh from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 70  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$thuonghtdl = select_info($conn, $sql = "select SUM(Tp8lgec_PQ8sZI) as tienhtdl from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 69  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				
				$thuongbc = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tienhbc from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 66 and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");

				if (!isset($thuongbc['tienhbc']) && empty($thuongbc['tienhbc'])) {
					$thuongbc['tienhbc'] = 0;
				}

				$truluong = select_info($conn, "select SUM(Tkryv3j_4q8tQF) as tientru from tkryv3j where Tkryv3j_icE84B = '" . $value['Tuxrdif_KPjwc9'] . "' and Tkryv3j_jotU4m between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$tonggio = 0;
				$manggiodukien = [];
				foreach ($lichlamviec as $value1) {
					$chitiettugio = select_list($conn, $sql = "select * from tlfibmu where Tlfibmu_xr3Etg = '" . $value1['Ty1hkmi_id'] . "'");

					$tongtugio1 = 0;
					$tongdengio1 = 0;
					foreach ($chitiettugio as $value2) {
						$tugio1 = date("H", strtotime($value2['Tlfibmu_w1qhka']));
						$tuphut1 = date("i", strtotime($value2['Tlfibmu_w1qhka']));

						$dengio1 = date("H", strtotime($value2['Tlfibmu_Y2LsHj']));
						$denphut1 = date("i", strtotime($value2['Tlfibmu_Y2LsHj']));

						$tongtu = $tugio1 * 3600 + $tuphut1 * 60;
						$tongden = $dengio1 * 3600 + $denphut1 * 60;

						$tongtugio1 = $tongtugio1 + $tongtu;
						$tongdengio1 = $tongdengio1 + $tongden;
					}
					$hieu = ($tongdengio1 - $tongtugio1) / 3600;

					$key = $value1['Ty1hkmi_NhSVlU'];
					if (isset($manggiodukien[$key])) {
						if (empty($manggiodukien[$key]['soluong'])) {
							$manggiodukien[$key]['soluong'] = 0;
						}
						$manggiodukien[$key]['soluong'] += $hieu;
					} else {
						$manggiodukien[$key]['soluong'] = $hieu;
					}
				}

				foreach ($manggiodukien as $value4) {
					$tien1gio = $luongcb['Trljq1p_KshifC'] / $value4['soluong'];
				}

				$giolamthute = select_list($conn, "select * from tf26boi where Tf26boi_uAnqat = '" . $value['Tuxrdif_KPjwc9'] . "' and Tf26boi_QpxCbt between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$tongtugiott1 = 0;
				$tongdengiott1 = 0;
				foreach ($giolamthute as $value5) {
					$tugiott1 = date("H", strtotime($value5['Tf26boi_ZnHjFX']));
					$tuphuttt1 = date("i", strtotime($value5['Tf26boi_ZnHjFX']));
					$phutvaomuon = $value5['Tf26boi_7WNt5O'] * 60;
					$phutvesom = $value5['Tf26boi_RAexj6'] * 60;
					$dengiott1 = date("H", strtotime($value5['Tf26boi_NQfEer']));
					$denphuttt1 = date("i", strtotime($value5['Tf26boi_NQfEer']));

					$tongtutt = $tugiott1 * 3600 + $tuphuttt1 * 60 + $phutvaomuon;
					$tongdentt = $dengiott1 * 3600 + $denphuttt1 * 60 - $phutvesom;

					$tongtugiott1 = $tongtugiott1 + $tongtutt;
					$tongdengiott1 = $tongdengiott1 + $tongdentt;
				}

				$hieutt = ($tongdengiott1 - $tongtugiott1) / 3600;

				$luongtheocong = $tien1gio * $hieutt;

				?>
                <tr>
                    <td><?= $a ?></td>
                    <td><?= layttid($conn, 'tciajwg', $value['Tuxrdif_KPjwc9'], 'Tciajwg_QbBpW2') ?></td>
                    <td><?= layttid($conn, 't7f6ahi', $value['Tuxrdif_Jwgexb'], 'T7f6ahi_RhkLDj') ?></td>
                    <td><?= layttid($conn, 'tciajwg', $value['Tuxrdif_KPjwc9'], 'Tciajwg_syP2YI') ?></td>
                    <td><?= layttid($conn, 't39kug1', $dulieunv['Tciajwg_movGJ8'], 'T39kug1_vRBEdu') ?></td>
                    <td><?= layttid($conn, 't39kug1', $dulieunv['Tciajwg_movGJ8'], 'T39kug1_FjKI6g') ?></td>
                    <td><?= $trangthai['Value'] ?></td>
                    <td><?= number_format($luongcb['Trljq1p_KshifC']) ?><?php $col[7] = $luongcb['Trljq1p_KshifC'] ?></td>
                    <td><?= number_format($luongcb['Trljq1p_CgotTR']) ?><?php $col[8] = $luongcb['Trljq1p_CgotTR'] ?></td>
                    <td><?= number_format($luongtheocong) ?><?php $col[9] = $luongtheocong ?></td>
                    <td><?= number_format($thuongbc['tienbc']) ?><?php $col[10] = $thuongbc['tienbc'] ?></td>
                    <td><?= number_format($luongkpi) ?><?php $col[11] = $luongkpi ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($tongtienvantay) ?><?php $col[15] = $tongtienvantay ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($thuongtd['tientd']) ?><?php $col[19] = $thuongtd['tientd'] ?></td>
                    <td><?= number_format($thuongkt['tienkt']) ?><?php $col[20] = $thuongkt['tienkt'] ?></td>
                    <td><?= number_format($thuongkh['tienkh']) ?><?php $col[21] = $thuongkh['tienkh'] ?></td>
                    <td><?= number_format($thuonghtdl['tienhtdl']) ?><?php $col[22] = $thuonghtdl['tienhtdl'] ?></td>
                    <td><?= $dulieunv['Tciajwg_ux7qOp'] ?></td>
                    <td><?= number_format($truluong['tientru']) ?><?php $col[24] = $truluong['tientru'] ?></td>
					<?php
					$b = 24;
					foreach ($listcot as $value9) {
						$b++;
						$ct = select_info($conn, "select * from t8s267u left join t1xs6iy on T8s267u_id = T1xs6iy_ViFbjy where T8s267u_7p0wbU = '" . $b . "'");

						if ($ct['T1xs6iy_Scfp8B'] != "" && $ct['T1xs6iy_Scfp8B'] != null) {
							$str = "(" . $ct['T1xs6iy_Scfp8B'] . ")";
							$pt1 = "/x/i";
							$str = preg_replace($pt1, "*", $str);
							$pt2 = "/([a-z])+/i";
							$str = preg_replace($pt2, "\$$0", $str);
							$pt3 = "/([0-9])+%/";
							$str = preg_replace($pt3, "($0/100)", $str);
							$pt4 = "/%/";
							$str = preg_replace($pt4, "", $str);
							$e = "\$comm = $str;";
							eval($e);
						} else {
							$comm = '';
						}

						?>
                        <td>
							<?= number_format($comm) ?><?php $col[$b] = $comm ?>
                        </td>
						<?php
					}
					$tongtatca = $col[9] + $col[10] + $col[11] + $col[8] + $col[15] + $col[19] + $col[20] + $col[21] + $col[22] - $col[24] + $col[25] + $col[26] + $col[27];
					?>
                    <td><?= number_format($tongtatca) ?></td>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
    </div>
	<?php
	exit;
}

if (isset($_GET['xemdulieu1'])) {
	$this->layout('Student/layout2');
	$thang = $_POST['thang'];
	$ngaydauthang = date('Y-m-d', strtotime(date('Y-m-01', strtotime($thang))));
	$ngaycuoithang = date("Y-m-t", strtotime($thang));


	?>
    <div class="col-md-12" style="overflow-x: scroll;margin-top: 15px;">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>STT</th>
                <th>MÃ NV</th>
                <th>Chi nhánh</th>
                <th>Họ và tên</th>
                <th>Chức vụ</th>
                <th>Mã chức vụ</th>
                <th>Tình trạng</th>
                <th>Lương cơ bản</th>
                <th>Lương trách nhiệm</th>
                <th>Lương theo ngày công</th>
                <th>Thưởng bước chân</th>
                <th>Lương KPI</th>
                <th>Tiền thưởng gia hạn</th>
                <th>Thưởng sĩ số lớp trung bình</th>
                <th>Lương dạy tại các đơn vị liên kết</th>
                <th>Sinh trắc vân tay</th>
                <th>công dạy part time 20.000đ</th>
                <th>Lương trợ giảng (GV Part time)</th>
                <th>Thưởng cho trợ giảng/lễ tân dựa trên số HV toàn CN</th>
                <th>Thưởng tuyển dụng</th>
                <th>Thưởng khai trương</th>
                <th>Lương khác</th>
                <th>Hỗ trợ đi lại</th>
                <th>Điện thoại</th>
                <th>Trừ khác</th>
				<?php
				$a = 26;
				$listcot = select_list($conn, "select * from t8s267u left join t1xs6iy on T8s267u_id = T1xs6iy_ViFbjy order by T8s267u_7p0wbU asc");
				foreach ($listcot as $val) {
					$a++;
					?>
                    <th><?= $val['T8s267u_oCyQn4'] ?><br><?= $val['T1xs6iy_Scfp8B'] ?></th>
					<?php
				}
				?>
                <th>Tổng lương</th>
            </tr>
            <tr>
                <th><span style="color: red;">[0]</span></th>
                <th><span style="color: red;">[1]</span></th>
                <th><span style="color: red;">[2]</span></th>
                <th><span style="color: red;">[3]</span></th>
                <th><span style="color: red;">[4]</span></th>
                <th><span style="color: red;">[5]</span></th>
                <th><span style="color: red;">[6]</span></th>
                <th><span style="color: red;">[7]</span></th>
                <th><span style="color: red;">[8]</span></th>
                <th><span style="color: red;">[9]</span></th>
                <th><span style="color: red;">[10]</span></th>
                <th><span style="color: red;">[11]</span></th>
                <th><span style="color: red;">[12]</span></th>
                <th><span style="color: red;">[13]</span></th>
                <th><span style="color: red;">[14]</span></th>
                <th><span style="color: red;">[15]</span></th>
                <th><span style="color: red;">[16]</span></th>
                <th><span style="color: red;">[17]</span></th>
                <th><span style="color: red;">[18]</span></th>
                <th><span style="color: red;">[19]</span></th>
                <th><span style="color: red;">[20]</span></th>
                <th><span style="color: red;">[21]</span></th>
                <th><span style="color: red;">[22]</span></th>
                <th><span style="color: red;">[23]</span></th>
                <th><span style="color: red;">[24]</span></th>
				<?php
				$a = 24;
				$listcot = select_list($conn, "select * from t8s267u order by T8s267u_7p0wbU desc");
				foreach ($listcot as $val) {
					$a++;
					?>
                    <th><span style="color: red;">[<?= $a ?>]</span></th>
					<?php
				}
				?>
                <th><span style="color: red;">[28]</span></th>

            </tr>
            </thead>
            <tbody>
			<?php
			$nhanvien = select_list($conn, "select * from tuxrdif");
			$a = 0;
			$tongtatca = 0;
			foreach ($nhanvien as $value) {
				$a++;
				$dulieunv = select_info($conn, "select * from tciajwg where Tciajwg_id = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$trangthai = select_info($conn, "select * from dataman where Id = '" . $dulieunv['Tciajwg_grKyWh'] . "'");
				$luongcb = select_info($conn, "select * from trljq1p where Trljq1p_4KtMGq = '" . $value['Tuxrdif_KPjwc9'] . "'");

				if (!isset($luongcb['Trljq1p_KshifC']) && empty($luongcb['Trljq1p_KshifC'])) {
					$luongcb['Trljq1p_KshifC'] = 0;
				}
				if (!isset($luongcb['Trljq1p_CgotTR']) && empty($luongcb['Trljq1p_CgotTR'])) {
					$luongcb['Trljq1p_CgotTR'] = 0;
				}

				$lichlamviec = select_list($conn, "select * from ty1hkmi where Ty1hkmi_NhSVlU = '" . $value['Tuxrdif_KPjwc9'] . "' and Ty1hkmi_rkPXsS >= '" . $ngaydauthang . "' and Ty1hkmi_AWaZnT <= '" . $ngaycuoithang . "'");


				$chitieutheonv = select_info($conn, "select * from txvf82s where Txvf82s_wx07Ii = '" . $value['Tuxrdif_KPjwc9'] . "' and Txvf82s_v78Awo >= '" . $ngaydauthang . "' and Txvf82s_OfhHAb <= '" . $ngaycuoithang . "'");

				$tongdoanhthunv = select_info($conn, "select SUM(Tdrni78_fzRkEM) as tongdt from tdrni78 left join t9jrlb7 on T9jrlb7_id = Tdrni78_PYrBpR where T9jrlb7_BJOgCZ = '" . $value['Tuxrdif_KPjwc9'] . "' and Tdrni78_pEzf7v between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$tyledoanhthu = ($tongdoanhthunv['tongdt'] / $chitieutheonv['Txvf82s_ZYrbPO']) * 100;

				$mucthuong = select_list($conn, "select * from t6ykwd8 where T6ykwd8_IHQEKS <= '" . $tyledoanhthu . "' order by T6ykwd8_IHQEKS desc limit 1");

				$luongkpi = 0;
				foreach ($mucthuong as $value7) {
					$luongkpi = ($tongdoanhthunv['tongdt'] * $value7['T6ykwd8_IZn69G']) / 100;
				}

				$nguoiban = select_info($conn, "select SUM(T916rxn_gctPa2) as tienbanvt from t916rxn where T916rxn_DacuS4 between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and T916rxn_p20QnX = '" . $value['Tuxrdif_KPjwc9'] . "'");

				$nguoidoc = select_info($conn, "select SUM(T916rxn_gctPa2) as tiendocvt from t916rxn where T916rxn_DacuS4 between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and T916rxn_6rlB3q = '" . $value['Tuxrdif_KPjwc9'] . "'");

				$doanhthudoc = select_info($conn, "select * from tjz9g2t where Tjz9g2t_E4LP8n = 71");
				$doanhthuban = select_info($conn, "select * from tjz9g2t where Tjz9g2t_E4LP8n = 72");

				$tienban = ($nguoiban['tienbanvt'] * $doanhthuban['Tjz9g2t_f4qw0k']) / 100;
				$tiendoc = ($nguoidoc['tiendocvt'] * $doanhthudoc['Tjz9g2t_f4qw0k']) / 100;

				$tongtienvantay = $tienban + $tiendoc;

				$thuongtd = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tientd from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 67  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$thuongkt = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tienkt from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 68  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$thuongkh = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tienkh from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 70  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");
				$thuonghtdl = select_info($conn, $sql = "select SUM(Tp8lgec_PQ8sZI) as tienhtdl from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 69  and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");


				$thuongbc = select_info($conn, "select SUM(Tp8lgec_PQ8sZI) as tienhbc from tp8lgec where Tp8lgec_cER1YL between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tp8lgec_73KxNp = 66 and Tp8lgec_sovymw = '" . $value['Tuxrdif_KPjwc9'] . "'");

				if (!isset($thuongbc['tienhbc']) && empty($thuongbc['tienhbc'])) {
					$thuongbc['tienhbc'] = 0;
				}

				$truluong = select_info($conn, "select SUM(Tkryv3j_4q8tQF) as tientru from tkryv3j where Tkryv3j_icE84B = '" . $value['Tuxrdif_KPjwc9'] . "' and Tkryv3j_jotU4m between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$tonggio = 0;
				$manggiodukien = [];
				foreach ($lichlamviec as $value1) {
					$chitiettugio = select_list($conn, $sql = "select * from tlfibmu where Tlfibmu_xr3Etg = '" . $value1['Ty1hkmi_id'] . "'");

					$tongtugio1 = 0;
					$tongdengio1 = 0;
					foreach ($chitiettugio as $value2) {
						$tugio1 = date("H", strtotime($value2['Tlfibmu_w1qhka']));
						$tuphut1 = date("i", strtotime($value2['Tlfibmu_w1qhka']));

						$dengio1 = date("H", strtotime($value2['Tlfibmu_Y2LsHj']));
						$denphut1 = date("i", strtotime($value2['Tlfibmu_Y2LsHj']));

						$tongtu = $tugio1 * 3600 + $tuphut1 * 60;
						$tongden = $dengio1 * 3600 + $denphut1 * 60;

						$tongtugio1 = $tongtugio1 + $tongtu;
						$tongdengio1 = $tongdengio1 + $tongden;
					}
					$hieu = ($tongdengio1 - $tongtugio1) / 3600;

					$key = $value1['Ty1hkmi_NhSVlU'];
					if (isset($manggiodukien[$key])) {
						if (empty($manggiodukien[$key]['soluong'])) {
							$manggiodukien[$key]['soluong'] = 0;
						}
						$manggiodukien[$key]['soluong'] += $hieu;
					} else {
						$manggiodukien[$key]['soluong'] = $hieu;
					}
				}

				foreach ($manggiodukien as $value4) {
					$tien1gio = $luongcb['Trljq1p_KshifC'] / $value4['soluong'];
				}

				$giolamthute = select_list($conn, "select * from tf26boi where Tf26boi_uAnqat = '" . $value['Tuxrdif_KPjwc9'] . "' and Tf26boi_QpxCbt between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$tongtugiott1 = 0;
				$tongdengiott1 = 0;
				foreach ($giolamthute as $value5) {
					$tugiott1 = date("H", strtotime($value5['Tf26boi_ZnHjFX']));
					$tuphuttt1 = date("i", strtotime($value5['Tf26boi_ZnHjFX']));
					$phutvaomuon = $value5['Tf26boi_7WNt5O'] * 60;
					$phutvesom = $value5['Tf26boi_RAexj6'] * 60;
					$dengiott1 = date("H", strtotime($value5['Tf26boi_NQfEer']));
					$denphuttt1 = date("i", strtotime($value5['Tf26boi_NQfEer']));

					$tongtutt = $tugiott1 * 3600 + $tuphuttt1 * 60 + $phutvaomuon;
					$tongdentt = $dengiott1 * 3600 + $denphuttt1 * 60 - $phutvesom;

					$tongtugiott1 = $tongtugiott1 + $tongtutt;
					$tongdengiott1 = $tongdengiott1 + $tongdentt;
				}

				$hieutt = ($tongdengiott1 - $tongtugiott1) / 3600;

				$luongtheocong = $tien1gio * $hieutt;

				?>
                <tr>
                    <td><?= $a ?></td>
                    <td><?= layttid($conn, 'tciajwg', $value['Tuxrdif_KPjwc9'], 'Tciajwg_QbBpW2') ?></td>
                    <td><?= layttid($conn, 't7f6ahi', $value['Tuxrdif_Jwgexb'], 'T7f6ahi_RhkLDj') ?></td>
                    <td><?= layttid($conn, 'tciajwg', $value['Tuxrdif_KPjwc9'], 'Tciajwg_syP2YI') ?></td>
                    <td><?= layttid($conn, 't39kug1', $dulieunv['Tciajwg_movGJ8'], 'T39kug1_vRBEdu') ?></td>
                    <td><?= layttid($conn, 't39kug1', $dulieunv['Tciajwg_movGJ8'], 'T39kug1_FjKI6g') ?></td>
                    <td><?= $trangthai['Value'] ?></td>
                    <td><?= number_format($luongcb['Trljq1p_KshifC']) ?><?php $col[7] = $luongcb['Trljq1p_KshifC'] ?></td>
                    <td><?= number_format($luongcb['Trljq1p_CgotTR']) ?><?php $col[8] = $luongcb['Trljq1p_CgotTR'] ?></td>
                    <td><?= number_format($luongtheocong) ?><?php $col[9] = $luongtheocong ?></td>
                    <td><?= number_format($thuongbc['tienbc']) ?><?php $col[10] = $thuongbc['tienbc'] ?></td>
                    <td><?= number_format($luongkpi) ?><?php $col[11] = $luongkpi ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($tongtienvantay) ?><?php $col[15] = $tongtienvantay ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($thuongtd['tientd']) ?><?php $col[19] = $thuongtd['tientd'] ?></td>
                    <td><?= number_format($thuongkt['tienkt']) ?><?php $col[20] = $thuongkt['tienkt'] ?></td>
                    <td><?= number_format($thuongkh['tienkh']) ?><?php $col[21] = $thuongkh['tienkh'] ?></td>
                    <td><?= number_format($thuonghtdl['tienhtdl']) ?><?php $col[22] = $thuonghtdl['tienhtdl'] ?></td>
                    <td><?= $dulieunv['Tciajwg_ux7qOp'] ?></td>
                    <td><?= number_format($truluong['tientru']) ?><?php $col[24] = $truluong['tientru'] ?></td>
					<?php
					$b = 24;
					foreach ($listcot as $value9) {
						$b++;
						$ct = select_info($conn, "select * from t8s267u left join t1xs6iy on T8s267u_id = T1xs6iy_ViFbjy where T8s267u_7p0wbU = '" . $b . "'");

						if ($ct['T1xs6iy_Scfp8B'] != "" && $ct['T1xs6iy_Scfp8B'] != null) {
							$str = "(" . $ct['T1xs6iy_Scfp8B'] . ")";
							$pt1 = "/x/i";
							$str = preg_replace($pt1, "*", $str);
							$pt2 = "/([a-z])+/i";
							$str = preg_replace($pt2, "\$$0", $str);
							$pt3 = "/([0-9])+%/";
							$str = preg_replace($pt3, "($0/100)", $str);
							$pt4 = "/%/";
							$str = preg_replace($pt4, "", $str);
							$e = "\$comm = $str;";
							eval($e);
						} else {
							$comm = '';
						}

						?>
                        <td>
							<?= number_format($comm) ?><?php $col[$b] = $comm ?>
                        </td>
						<?php
					}
					$tongtatca = $col[9] + $col[10] + $col[11] + $col[8] + $col[15] + $col[19] + $col[20] + $col[21] + $col[22] - $col[24] + $col[25] + $col[26] + $col[27];
					?>
                    <td><?= number_format($tongtatca) ?></td>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12" style="margin-top: 30px;">
        <a href="?xuatexcel&thang=<?= $_POST['thang'] ?>" class="btn btn-primary" target="_blank">Xuất Excel</a>
    </div>
	<?php
	exit;
}

?>

<div class="box box-solid box-info" style="border: 1px solid #367fa9">
    <div class="box-header with-border" style="background: #367fa9">
        <h3 class="box-title">Báo cáo tính lương bộ phận kinh doanh </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-3">
                <label>Chọn tháng</label>
                <input type="month" id="thang" name="thang" class="form-control">
            </div>
            <div class="col-md-3" style="margin-top: 21px;">
                <button class="btn btn-primary" onclick="xemdulieu()" type="button">Xem</button>
            </div>
        </div>
    </div> <!-- /.box-body -->
    <div class="box-footer">
        <div id="show">
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<script src="/js/makealert.js" type="text/javascript"></script>
<script>
    function xemdulieu() {
        var thang = $("#thang").val();
        $.ajax({
            url: "?xemdulieu1",
            dataType: "text",
            data: {thang: thang},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }
</script>
