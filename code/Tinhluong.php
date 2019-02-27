<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['xuatexcel'])) {
	$this->layout('Student/layout2');
	$ngaydauthang = date('Y-m-d', strtotime($_GET['thang']));
	$ngaycuoithang = date("Y-m-t", strtotime($_GET['thang']));
	$mau = $_GET['maubl'];

	$nhavien = select_list($conn, "select * from tc5nuv1 left join tktfc7p on Tktfc7p_id = Tc5nuv1_U2alAw where Tc5nuv1_ieEhs1 = 642");

	$listtieude = select_list($conn, "select * from t83zasd where T83zasd_R1P8Zf = '" . $mau . "' order by T83zasd_qGmAUs asc");

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=data.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	?>
    <div class="col-md-12" style="overflow-x: scroll;">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <center><h3>BẢNG TÍNH LƯƠNG NHÂN VIÊN THÁNG <?= $monthnow ?>/<?= $yearnow ?></h3></center>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center"
               style="font-family: 'Times New Roman';width: 100%;font-size: larger" border="1" cellspacing="0">
            <thead>
            <tr>
                <th rowspan="2">STT</th>
                <th rowspan="2">Số hợp đồng</th>
                <th rowspan="2">Họ tên nhân viên</th>
                <th rowspan="2">Bộ phận</th>
                <th rowspan="2">Chức vụ</th>
                <th rowspan="2">Lương cơ bản</th>
                <th rowspan="2">Tổng số ngày làm thực tế</th>
                <th rowspan="2">Nghỉ phép có lương</th>
                <th rowspan="2">Lương thực làm</th>
                <th colspan="3">Phụ cấp</th>
                <th colspan="3">Thưởng</th>
                <th colspan="2">KPI</th>
				<?php
				$a1 = 16;
				foreach ($listtieude as $value) {

					?>
                    <th rowspan="2"><?= $value['T83zasd_UFbvp4'] ?><br><span><?= $value['T83zasd_0UvuwY'] ?></span>
                    </th>
					<?php
				}
				?>
            </tr>

            <tr>
                <th>Ăn trưa</th>
                <th>Công tác</th>
                <th>Phụ cấp khác</th>
                <th>Số hồ sơ trong tháng</th>
                <th>KPI</th>
                <th>Thưởng tháng (Theo KPI)</th>
                <th>Thưởng hỗ trợ theo vị trí cấp bậc</th>
                <th>Số tiền trừ</th>
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
				<?php
				$a1 = 16;
				foreach ($listtieude as $value) {
					$a1++;
					?>
                    <th><span
                                style="color: red;">[<?= $value['T83zasd_qGmAUs'] ?>]</span>
                    </th>
					<?php
				}
				?>
            </tr>

            </thead>
            <tbody>
			<?php
			$a = 0;
			foreach ($nhavien as $value) {
				$a++;
				$tennv = select_info($conn, "select * from tktfc7p where Tktfc7p_id = '" . $value['Tc5nuv1_U2alAw'] . "'");

				$bophan = select_info($conn, "select * from tjvcqbf where Tjvcqbf_id = '" . $tennv['Tktfc7p_PQMO0K'] . "'");

				$chucvu = select_info($conn, "select * from tswb8fg where Tswb8fg_id = '" . $tennv['Tktfc7p_NuY4ib'] . "'");

				$chamcong = select_info($conn, "select count(*) as slcc  from txayrdn where Txayrdn_owner = '" . $value['Tktfc7p_id'] . "' and Txayrdn_PVbi1o between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");
				$ngaynghi = select_info($conn, "select SUM(Ttlqkxd_fXaxDR) as snn from ttlqkxd where Ttlqkxd_BGiCEI = '" . $value['Tc5nuv1_U2alAw'] . "' and Ttlqkxd_MbNp6h between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$luongthuclam = ($value['Tc5nuv1_6yezl8'] / 24) * ($chamcong['slcc'] + $ngaynghi['snn']);

				$sohoso = select_info($conn, $sql = "select count(*) as slhoso from t61r5ki left join tlkvhg9 on T61r5ki_id = Tlkvhg9_6NkZWK where Tlkvhg9_y7T2qa = '" . $value['Tc5nuv1_U2alAw'] . "' and Tlkvhg9_MxUBPa between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$sohoso1 = select_info($conn, $sql = "select SUM(Tlkvhg9_BkqdlN) as diemhths from t61r5ki left join tlkvhg9 on T61r5ki_id = Tlkvhg9_6NkZWK where Tlkvhg9_y7T2qa = '" . $value['Tc5nuv1_U2alAw'] . "' and Tlkvhg9_MxUBPa between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tlkvhg9_VEUdAQ = 574");

				$phucap = select_info($conn, "select * from twi4lvz left join tpzcsl3 on Twi4lvz_id = Tpzcsl3_DubCMx where Tpzcsl3_5knspv = '" . $ngaydauthang . "' and Tpzcsl3_tgp4lI = '" . $ngaycuoithang . "'and Tpzcsl3_Ab3Pno = '" . $value['Tc5nuv1_U2alAw'] . "' and Twi4lvz_id = 1");

				$phucap1 = select_info($conn, "select * from twi4lvz left join tpzcsl3 on Twi4lvz_id = Tpzcsl3_DubCMx where Tpzcsl3_5knspv = '" . $ngaydauthang . "' and Tpzcsl3_tgp4lI = '" . $ngaycuoithang . "'and Tpzcsl3_Ab3Pno = '" . $value['Tc5nuv1_U2alAw'] . "' and Twi4lvz_id = 2");

				$diemtrudimuon = select_info($conn, "select SUM(Txayrdn_dp0rTS) as diemtrudm from txayrdn where Txayrdn_owner = '" . $value['Tktfc7p_id'] . "' and Txayrdn_PVbi1o between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$diembophan = select_info($conn, "select * from tjvcqbf where Tjvcqbf_id = '" . $tennv['Tktfc7p_PQMO0K'] . "'");

				$diemkpi = $diembophan['Tjvcqbf_rulDcI'] + $sohoso1['diemhths'] - $diemtrudimuon['diemtrudm'];

				$thuongtheocapbac = select_info($conn, "select * from tswb8fg where Tswb8fg_id = '" . $tennv['Tktfc7p_NuY4ib'] . "'");


				$tienthuongthangapi = select_info($conn, "select * from t75asqp where '" . $diemkpi . "' between T75asqp_ywIXVE and T75asqp_ofmeDy");

				if ($tienthuongthangapi['T75asqp_nRdgLs'] == 663) {
					$tienthangkpi1 = $tienthuongthangapi['T75asqp_SrTqtm'];
				} else {
					$tienthangkpi2 = $tienthuongthangapi['T75asqp_SrTqtm'];
				}

				?>
                <tr>
                    <td><?= $a ?></td>
                    <td>
						<?= $value['Tc5nuv1_pgoYiy'] ?>
                        <input type="hidden" name="sohopdong<?= $a ?>" value="<?= $value['Tc5nuv1_pgoYiy'] ?>">
                    </td>
                    <td>
						<?= $tennv['Tktfc7p_p3VMRN'] ?>
                        <input type="hidden" name="tennv<?= $a ?>" value="<?= $tennv['Tktfc7p_id'] ?>">
                    </td>
                    <td>
						<?= $bophan['Tjvcqbf_yIv9u1'] ?>
                        <input type="hidden" name="bophan<?= $a ?>" value="<?= $bophan['Tjvcqbf_id'] ?>">
                    </td>
                    <td>
						<?= $chucvu['Tswb8fg_NqcIpj'] ?>
                        <input type="hidden" name="chucvu<?= $a ?>" value="<?= $chucvu['Tswb8fg_id'] ?>">
                    </td>
                    <td>
						<?= number_format($value['Tc5nuv1_6yezl8']) ?><?php $col[5] = $value['Tc5nuv1_6yezl8'] ?>
                        <input type="hidden" name="luongcb<?= $a ?>" value="<?= $value['Tc5nuv1_6yezl8'] ?>">
                    </td>
                    <td>
						<?= (int)$chamcong['slcc'] ?><?php $col[6] = $chamcong['slcc'] ?>
                        <input type="hidden" name="ngaylamtt<?= $a ?>" value="<?= $chamcong['slcc'] ?>">
                    </td>
                    <td>
						<?= $ngaynghi['snn'] ?><?php $col[7] = $ngaynghi['snn'] ?>
                        <input type="hidden" name="ngaynghi<?= $a ?>" value="<?= $ngaynghi['snn'] ?>">
                    </td>
                    <td>
						<?= number_format($luongthuclam) ?><?php $col[8] = $luongthuclam ?>
                        <input type="hidden" name="luongthuclam<?= $a ?>" value="<?= $luongthuclam ?>">
                    </td>
                    <td>
						<?= number_format($value['Tc5nuv1_ZOMkCN']) ?><?php $col[9] = $value['Tc5nuv1_ZOMkCN'] ?>
                        <input type="hidden" name="antrua<?= $a ?>" value="<?= $value['Tc5nuv1_ZOMkCN'] ?>">
                    </td>
                    <!--ăn trưa-->
                    <td>
						<?= number_format($phucap['Twi4lvz_zAThMl']) ?><?php $col[10] = $phucap['Twi4lvz_zAThMl'] ?>
                        <input type="hidden" name="congtac<?= $a ?>" value="<?= $phucap['Twi4lvz_zAThMl'] ?>">
                    </td>
                    <td>
						<?= number_format($phucap1['Twi4lvz_zAThMl']) ?><?php $col[11] = $phucap1['Twi4lvz_zAThMl'] ?>
                        <input type="hidden" name="phucapkhac<?= $a ?>" value="<?= $phucap1['Twi4lvz_zAThMl'] ?>">
                    </td>
                    <td>
						<?= $sohoso['slhoso'] ?><?php $col[12] = $sohoso['slhoso'] ?>
                        <input type="hidden" name="sohoso<?= $a ?>" value="<?= $sohoso['slhoso'] ?>">
                    </td>
                    <td>
						<?= $diemkpi ?><?php $col[13] = $diemkpi ?>
                        <input type="hidden" name="diemkpi<?= $a ?>" value="<?= $diemkpi ?>">
                    </td> <!--kpi-->
                    <td>
						<?= number_format($tienthangkpi1) ?><?php $col[14] = $tienthangkpi1 ?>
                        <input type="hidden" name="thuongthangkpi<?= $a ?>" value="<?= $tienthangkpi1 ?>">
                    </td>
                    <!--thưởng theo tháng kpi-->
                    <td><?= number_format($thuongtheocapbac['Tswb8fg_SNKeWH']) ?><?php $col[15] = $thuongtheocapbac['Tswb8fg_SNKeWH'] ?>
                        <input type="hidden" name="thuonghotro<?= $a ?>"
                               value="<?= $thuongtheocapbac['Tswb8fg_SNKeWH'] ?>">
                    </td>
                    <td>
						<?= number_format($tienthangkpi2) ?><?php $col[16] = $tienthangkpi2 ?>
                        <input type="hidden" name="sotientru<?= $a ?>"
                               value="<?= $tienthangkpi2 ?>">
                    </td>
					<?php
					$b = 16;
					foreach ($listtieude as $value) {
						$b++;
						$ct = select_info($conn, "select * from t83zasd where T83zasd_R1P8Zf = '" . $mau . "' and T83zasd_qGmAUs = '" . $b . "'");
						if ($ct['T83zasd_0UvuwY'] != "" && $ct['T83zasd_0UvuwY'] != null) {
							$str = "(" . $ct['T83zasd_0UvuwY'] . ")";
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
							<?= number_format($comm) ?>
                            <input type="hidden" name="cot<?= $a . $b ?>" value="<?= $comm ?>">
                        </td>
						<?php
					}
					?>
                    <td></td>
                    <td></td>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
        <input type="hidden" name="dong" value="<?= $a ?>">
    </div>
	<?php
	exit;
}

if (isset($_GET['xacnhan3'])) {
	$this->layout('Student/layout2');
	$ngaydauthang = date('Y-m-d', strtotime($_POST['thang']));
	$ngaycuoithang = date("Y-m-t", strtotime($_POST['thang']));
	$data = array(
		"Tgdvk6b_nOrFG4" => $_POST['tieudebl'],
		"Tgdvk6b_MHW2oF" => $datetoday,
		"Tgdvk6b_qADJFS" => $ngaydauthang,
		"Tgdvk6b_HA7DEM" => $ngaycuoithang,
	);
	insertdb($conn, "tgdvk6b", $data);
	$idnv = lastinsertid($conn);

	echo $idnv;

	for ($i = 1; $i <= $_POST['dong']; $i++) {
		$data1 = array(
			"Tjozigr_0EvWFa" => $idnv,
			"Tjozigr_mXNrHL" => $_POST['luongcb' . $i],
			"Tjozigr_mYG8Wv" => $_POST['luongthuclam' . $i],
			"Tjozigr_2YKbEF" => $_POST['antrua' . $i],
			"Tjozigr_A0DK86" => $_POST['phucapkhac' . $i],
			"Tjozigr_HaEAeP" => $_POST['congtac' . $i],
			"Tjozigr_scLUwu" => $_POST['thuongthangkpi' . $i],
			"Tjozigr_2NJuVU" => $_POST['thuonghotro' . $i],
			"Tjozigr_A50YOT" => $_POST['sohoso' . $i],
			"Tjozigr_EhSywv" => $_POST['ngaylamtt' . $i],
			"Tjozigr_gsb9jl" => $_POST['ngaynghi' . $i],
			"Tjozigr_I3aCcE" => $_POST['diemkpi' . $i],
			"Tjozigr_4siwe1" => $_POST['bophan' . $i],
			"Tjozigr_0MbqNC" => $_POST['chucvu' . $i],
			"Tjozigr_SMu8CZ" => $_POST['sohopdong' . $i],
			"Tjozigr_KoA4dm" => $_POST['tennv' . $i],
			"Tjozigr_cpsihz" => $_POST['cot17' . $i],
			"Tjozigr_d6g2Ke" => $_POST['cot18' . $i],
			"Tjozigr_DrUX4P" => $_POST['cot19' . $i],
			"Tjozigr_qCgkhI" => $_POST['cot20' . $i],
			"Tjozigr_81KDIu" => $_POST['cot21' . $i],
			"Tjozigr_2qEhkZ" => $_POST['cot22' . $i],
			"Tjozigr_RQl7np" => $_POST['cot23' . $i],
			"Tjozigr_Sq0eUa" => $_POST['cot24' . $i],
			"Tjozigr_Ts7Syf" => $_POST['cot25' . $i],
			"Tjozigr_CUdzmv" => $_POST['cot26' . $i],
			"Tjozigr_F6ZCrs" => $_POST['cot27' . $i],
			"Tjozigr_FgGsiy" => $_POST['cot28' . $i],
			"Tjozigr_s5bDM3" => $_POST['cot29' . $i],
		);
		insertdb($conn, "tjozigr", $data1);
	}

	exit;
}

if (isset($_GET['xem1'])) {
	$this->layout('Student/layout2');
	$ngaydauthang = date('Y-m-d', strtotime($_POST['thang']));
	$ngaycuoithang = date("Y-m-t", strtotime($_POST['thang']));
	$mau = $_POST['maubl'];

	$nhavien = select_list($conn, "select * from tc5nuv1 left join tktfc7p on Tktfc7p_id = Tc5nuv1_U2alAw where Tc5nuv1_ieEhs1 = 642");

	$listtieude = select_list($conn, "select * from t83zasd where T83zasd_R1P8Zf = '" . $mau . "' order by T83zasd_qGmAUs asc");


	?>
    <div class="col-md-12" style="overflow-x: scroll;">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th rowspan="2">STT</th>
                <th rowspan="2">Số hợp đồng</th>
                <th rowspan="2">Họ tên nhân viên</th>
                <th rowspan="2">Bộ phận</th>
                <th rowspan="2">Chức vụ</th>
                <th rowspan="2">Lương cơ bản</th>
                <th rowspan="2">Tổng số ngày làm thực tế</th>
                <th rowspan="2">Nghỉ phép có lương</th>
                <th rowspan="2">Lương thực làm</th>
                <th colspan="3">Phụ cấp</th>
                <th colspan="3">Thưởng</th>
                <th colspan="2">KPI</th>
				<?php
				$a1 = 16;
				foreach ($listtieude as $value) {

					?>
                    <th rowspan="2"><?= $value['T83zasd_UFbvp4'] ?><br><span><?= $value['T83zasd_0UvuwY'] ?></span>
                    </th>
					<?php
				}
				?>
            </tr>

            <tr>
                <th>Ăn trưa</th>
                <th>Công tác</th>
                <th>Phụ cấp khác</th>
                <th>Số hồ sơ trong tháng</th>
                <th>KPI</th>
                <th>Thưởng tháng (Theo KPI)</th>
                <th>Thưởng hỗ trợ theo vị trí cấp bậc</th>
                <th>Số tiền trừ</th>
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
				<?php
				$a1 = 16;
				foreach ($listtieude as $value) {
					$a1++;
					?>
                    <th><span
                                style="color: red;">[<?= $value['T83zasd_qGmAUs'] ?>]</span>
                    </th>
					<?php
				}
				?>
            </tr>

            </thead>
            <tbody>
			<?php
			$a = 0;
			foreach ($nhavien as $value) {
				$a++;
				$tennv = select_info($conn, "select * from tktfc7p where Tktfc7p_id = '" . $value['Tc5nuv1_U2alAw'] . "'");

				$bophan = select_info($conn, "select * from tjvcqbf where Tjvcqbf_id = '" . $tennv['Tktfc7p_PQMO0K'] . "'");

				$chucvu = select_info($conn, "select * from tswb8fg where Tswb8fg_id = '" . $tennv['Tktfc7p_NuY4ib'] . "'");

				$chamcong = select_info($conn, "select count(*) as slcc  from txayrdn where Txayrdn_owner = '" . $value['Tktfc7p_id'] . "' and Txayrdn_PVbi1o between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");
				$ngaynghi = select_info($conn, "select SUM(Ttlqkxd_fXaxDR) as snn from ttlqkxd where Ttlqkxd_BGiCEI = '" . $value['Tc5nuv1_U2alAw'] . "' and Ttlqkxd_MbNp6h between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$luongthuclam = ($value['Tc5nuv1_6yezl8'] / 24) * ($chamcong['slcc'] + $ngaynghi['snn']);

				$sohoso = select_info($conn, $sql = "select count(*) as slhoso from t61r5ki left join tlkvhg9 on T61r5ki_id = Tlkvhg9_6NkZWK where Tlkvhg9_y7T2qa = '" . $value['Tc5nuv1_U2alAw'] . "' and Tlkvhg9_MxUBPa between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$sohoso1 = select_info($conn, $sql = "select SUM(Tlkvhg9_BkqdlN) as diemhths from t61r5ki left join tlkvhg9 on T61r5ki_id = Tlkvhg9_6NkZWK where Tlkvhg9_y7T2qa = '" . $value['Tc5nuv1_U2alAw'] . "' and Tlkvhg9_MxUBPa between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "' and Tlkvhg9_VEUdAQ = 574");

				$phucap = select_info($conn, "select * from twi4lvz left join tpzcsl3 on Twi4lvz_id = Tpzcsl3_DubCMx where Tpzcsl3_5knspv = '" . $ngaydauthang . "' and Tpzcsl3_tgp4lI = '" . $ngaycuoithang . "'and Tpzcsl3_Ab3Pno = '" . $value['Tc5nuv1_U2alAw'] . "' and Twi4lvz_id = 1");

				$phucap1 = select_info($conn, "select * from twi4lvz left join tpzcsl3 on Twi4lvz_id = Tpzcsl3_DubCMx where Tpzcsl3_5knspv = '" . $ngaydauthang . "' and Tpzcsl3_tgp4lI = '" . $ngaycuoithang . "'and Tpzcsl3_Ab3Pno = '" . $value['Tc5nuv1_U2alAw'] . "' and Twi4lvz_id = 2");

				$diemtrudimuon = select_info($conn, "select SUM(Txayrdn_dp0rTS) as diemtrudm from txayrdn where Txayrdn_owner = '" . $value['Tktfc7p_id'] . "' and Txayrdn_PVbi1o between '" . $ngaydauthang . "' and '" . $ngaycuoithang . "'");

				$diembophan = select_info($conn, "select * from tjvcqbf where Tjvcqbf_id = '" . $tennv['Tktfc7p_PQMO0K'] . "'");

				$diemkpi = $diembophan['Tjvcqbf_rulDcI'] + $sohoso1['diemhths'] - $diemtrudimuon['diemtrudm'];

				$thuongtheocapbac = select_info($conn, "select * from tswb8fg where Tswb8fg_id = '" . $tennv['Tktfc7p_NuY4ib'] . "'");


				$tienthuongthangapi = select_info($conn, "select * from t75asqp where '" . $diemkpi . "' between T75asqp_ywIXVE and T75asqp_ofmeDy");

				if ($tienthuongthangapi['T75asqp_nRdgLs'] == 663) {
					$tienthangkpi1 = $tienthuongthangapi['T75asqp_SrTqtm'];
				} else {
					$tienthangkpi2 = $tienthuongthangapi['T75asqp_SrTqtm'];
				}

				?>
                <tr>
                    <td><?= $a ?></td>
                    <td>
						<?= $value['Tc5nuv1_pgoYiy'] ?>
                        <input type="hidden" name="sohopdong<?= $a ?>" value="<?= $value['Tc5nuv1_pgoYiy'] ?>">
                    </td>
                    <td>
						<?= $tennv['Tktfc7p_p3VMRN'] ?>
                        <input type="hidden" name="tennv<?= $a ?>" value="<?= $tennv['Tktfc7p_id'] ?>">
                    </td>
                    <td>
						<?= $bophan['Tjvcqbf_yIv9u1'] ?>
                        <input type="hidden" name="bophan<?= $a ?>" value="<?= $bophan['Tjvcqbf_id'] ?>">
                    </td>
                    <td>
						<?= $chucvu['Tswb8fg_NqcIpj'] ?>
                        <input type="hidden" name="chucvu<?= $a ?>" value="<?= $chucvu['Tswb8fg_id'] ?>">
                    </td>
                    <td>
						<?= number_format($value['Tc5nuv1_6yezl8']) ?><?php $col[5] = $value['Tc5nuv1_6yezl8'] ?>
                        <input type="hidden" name="luongcb<?= $a ?>" value="<?= $value['Tc5nuv1_6yezl8'] ?>">
                    </td>
                    <td>
						<?= (int)$chamcong['slcc'] ?><?php $col[6] = $chamcong['slcc'] ?>
                        <input type="hidden" name="ngaylamtt<?= $a ?>" value="<?= $chamcong['slcc'] ?>">
                    </td>
                    <td>
						<?= $ngaynghi['snn'] ?><?php $col[7] = $ngaynghi['snn'] ?>
                        <input type="hidden" name="ngaynghi<?= $a ?>" value="<?= $ngaynghi['snn'] ?>">
                    </td>
                    <td>
						<?= number_format($luongthuclam) ?><?php $col[8] = $luongthuclam ?>
                        <input type="hidden" name="luongthuclam<?= $a ?>" value="<?= $luongthuclam ?>">
                    </td>
                    <td>
						<?= number_format($value['Tc5nuv1_ZOMkCN']) ?><?php $col[9] = $value['Tc5nuv1_ZOMkCN'] ?>
                        <input type="hidden" name="antrua<?= $a ?>" value="<?= $value['Tc5nuv1_ZOMkCN'] ?>">
                    </td>
                    <!--ăn trưa-->
                    <td>
						<?= number_format($phucap['Twi4lvz_zAThMl']) ?><?php $col[10] = $phucap['Twi4lvz_zAThMl'] ?>
                        <input type="hidden" name="congtac<?= $a ?>" value="<?= $phucap['Twi4lvz_zAThMl'] ?>">
                    </td>
                    <td>
						<?= number_format($phucap1['Twi4lvz_zAThMl']) ?><?php $col[11] = $phucap1['Twi4lvz_zAThMl'] ?>
                        <input type="hidden" name="phucapkhac<?= $a ?>" value="<?= $phucap1['Twi4lvz_zAThMl'] ?>">
                    </td>
                    <td>
						<?= $sohoso['slhoso'] ?><?php $col[12] = $sohoso['slhoso'] ?>
                        <input type="hidden" name="sohoso<?= $a ?>" value="<?= $sohoso['slhoso'] ?>">
                    </td>
                    <td>
						<?= $diemkpi ?><?php $col[13] = $diemkpi ?>
                        <input type="hidden" name="diemkpi<?= $a ?>" value="<?= $diemkpi ?>">
                    </td> <!--kpi-->
                    <td>
						<?= number_format($tienthangkpi1) ?><?php $col[14] = $tienthangkpi1 ?>
                        <input type="hidden" name="thuongthangkpi<?= $a ?>" value="<?= $tienthangkpi1 ?>">
                    </td>
                    <!--thưởng theo tháng kpi-->
                    <td><?= number_format($thuongtheocapbac['Tswb8fg_SNKeWH']) ?><?php $col[15] = $thuongtheocapbac['Tswb8fg_SNKeWH'] ?>
                        <input type="hidden" name="thuonghotro<?= $a ?>"
                               value="<?= $thuongtheocapbac['Tswb8fg_SNKeWH'] ?>">
                    </td>
                    <td>
						<?= number_format($tienthangkpi2) ?><?php $col[16] = $tienthangkpi2 ?>
                        <input type="hidden" name="sotientru<?= $a ?>"
                               value="<?= $tienthangkpi2 ?>">
                    </td>
					<?php
					$b = 16;
					foreach ($listtieude as $value) {
						$b++;
						$ct = select_info($conn, "select * from t83zasd where T83zasd_R1P8Zf = '" . $mau . "' and T83zasd_qGmAUs = '" . $b . "'");
						if ($ct['T83zasd_0UvuwY'] != "" && $ct['T83zasd_0UvuwY'] != null) {
							$str = "(" . $ct['T83zasd_0UvuwY'] . ")";
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
							<?= number_format($comm) ?>
                            <input type="hidden" name="cot<?= $b . $a ?>" value="<?= $comm ?>">
                        </td>
						<?php
					}
					?>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
        <input type="hidden" name="dong" value="<?= $a ?>">
    </div>
    <div class="col-sm-12" style="padding: 20px;">
        <button type="button" class="btn btn-primary" id="hoanthanh" onclick="clickluu()">Lưu</button>
        <a href="?xuatexcel&thang=<?= $_POST['thang'] ?>&maubl=<?= $_POST['maubl'] ?>" class="btn btn-primary"
           style="margin-left: 10px;">Xuất excel
        </a>
    </div>
	<?php
	exit;
}

?>

<form id="formsm">
    <div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
        <div class="box-header with-border">
            <h3 class="box-title">Giao diện tính lương</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label>Tiêu đề bảng lương <span style="color: red;">*</span></label>
                    <input type="text" id="tieudebl" name="tieudebl" class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Tháng</label>
                    <input type="month" id="thang" name="thang" class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Mẫu bảng lương</label>
                    <select id="maubl" name="maubl" class="form-control chosen-select">
                        <option value="0">---</option>
						<?php
						$maubl = select_list($conn, "select * from txcdqwg");
						foreach ($maubl as $value) {
							?>
                            <option value="<?= $value['Txcdqwg_id'] ?>"><?= $value['Txcdqwg_cxoKeS'] ?></option>
							<?php
						}
						?>
                    </select>
                </div>

                <div class="col-md-3" style="margin-top: 22px;">
                    <button class="btn btn-primary" type="button" onclick="xem()">Xem</button>
                </div>
            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer">
            <div id="show"></div>

        </div><!-- /.box-body -->
    </div><!-- /.box -->
</form>

<script src="/js/makealert.js" type="text/javascript"></script>
<script>
    function xem() {
        var thang = $("#thang").val();
        var maubl = $("#maubl").val();
        $.ajax({
            url: "?xem1",
            dataType: "text",
            data: {thang: thang, maubl: maubl},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }

    function clickluu() {
        var tieudebl = $("#tieudebl").val();
        var formData = new FormData($('#formsm')[0]);
        if (tieudebl == "" || tieudebl == null) {
            makeAlertright('Bạn chưa điền tiêu đề', 3000);
        } else {
            $.ajax({
                type: 'post',
                url: '?xacnhan3',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    makeSAlertright('Thành công', 3000);
                    window.setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            }); //End Ajax
        }
    }

</script>


