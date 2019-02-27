<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['checktime'])):
	$this->layout('Student/layout2');

	$thuhocid = $_POST['thuhocid'];
	$giobd = $_POST['giobd'];
	$giokt = $_POST['giokt'];
	$phongid = $_POST['phongid'];
	$gvid = $_POST['gvid'];
	$ngaybd = $_POST['ngaybd'];
	$sql = 'select * from t61inym 
inner JOIN tfupt39 ON tfupt39_id = T61inym_5q3PiO 
where 
        T61inym_N5wAck = ' . $thuhocid . ' 
         AND ( T61inym_vnKYeO >= "' . $giobd . '"  ) AND (T61inym_oFuc8h <= "' . $giokt . '" )
         and (T61inym_Ea0SrX = ' . $phongid . ' or T61inym_YLKzQa = ' . $gvid . ' )
         and ("' . $ngaybd . '" >= Tfupt39_9c2InL 
         or "' . $ngaybd . '" <= Tfupt39_6382Bt  )';
	$check = select_list($conn, $sql);

	//echo  $sql;
	if (count($check) > 0) {
		$result = 1;
	} else {
		$result = 2;
	};
	echo $result;
	exit;
endif;

if (isset($_GET['tinhngaykt'])) {
	$this->layout('Student/layout2');
	
	$arraytkb = json_decode($_POST['thoigianhoc'], true);

	function doithu($thu)
	{
		switch ($thu) {
			case 8://cn
				$dayinweek = 0;
				break;
			case 2://2
				$dayinweek = 1;
				break;
			case 3://3
				$dayinweek = 2;
				break;
			case 4://4
				$dayinweek = 3;
				break;
			case 5://5
				$dayinweek = 4;
				break;
			case 6://6
				$dayinweek = 5;
				break;
			case 7://7
				$dayinweek = 6;
				break;
		}
		return $dayinweek;
	}

	$flag = 0;
	$dem = 0;
	while ($dem < $_POST['sogiohoc']) {
		$ngayloop = date('Y-m-d', strtotime('+' . $flag . ' day', strtotime($_POST['ngaybd'][0])));
		foreach ($arraytkb as $val) {
			if (date('w', strtotime($ngayloop)) == doithu($val['thuhoc'])) {
				$dem += $val['sogiobuoi'];
			}
		}

		$flag++;
		if ($flag >= 1000) {
			echo "loop!";
			break;
		}
	}

	echo json_encode($ngayloop);

	exit;
	//thiswork
}

if (isset($_GET['taolop'])) {
	$this->layout('Student/layout2');

	$insertdata = makedatanl($conn, 'tfupt39', $_POST);
	$insertdata['owner'] = $User;
	insertdb($conn, "tfupt39", $insertdata);// insert lớp học
	$id = lastinsertid($conn);

	$cno = select_info($conn, $sql = "select * from cno where Modulename = 'sttlophoc'")['Cno'] + 1;
	query($conn, "update cno set Cno = " . $cno . " where Modulename = 'sttlophoc'");

	$infoLop = select_info($conn, $sql = 'select * from tfupt39 WHERE Tfupt39_id = "' . $id . '"');

	$thoikb = '';
	$demthu = 0;
	$thoigianhoc = json_decode($_POST['thoigianhoc'], true);

	$sothu = count($thoigianhoc);
	foreach ($thoigianhoc as $val) {
		$demthu++;
		$insertdatatgh = array(
			"T61inym_N5wAck" => $val['thuhoc'],
			"T61inym_oFuc8h" => $val['giobd'],
			"T61inym_vnKYeO" => $val['giokt'],
			"T61inym_z6Dvqw" => $val['trogiang'],
			"T61inym_Ea0SrX" => $val['phong'],
			"T61inym_YLKzQa" => $val['giaovien'],
			"T61inym_jmyCGi" => $val['sogiobuoi'],
			"T61inym_5q3PiO" => $id,
			"owner" => $User
		);
		insertdb($conn, "t61inym", $insertdatatgh);// insert thời khóa biểu theo thứ

		$thoikb .= $val['thuhoctext'] . ' - ' . date('H:i', strtotime($val['giobd'])) . ' - ' . date('H:i', strtotime($val['giokt'])) . ' - ' . $val['phongtext'] . ($sothu == $demthu ? "" : " / ");
	}

	$insertdata = array(
		"Tfupt39_hORQMX" => $thoikb
	);
	$wheredata = array(
		"Tfupt39_id" => $id
	);
	updatedb($conn, "tfupt39", array("where" => $wheredata, "data" => $insertdata));
	//query($conn, "update tfupt39 set Tfupt39_id = Tfupt39_id where Tfupt39_id = " . $id);

	$info_lop = select_info($conn, $sql = "select * from tfupt39 where tfupt39_id = " . $id);

	$dshs_data = json_decode($_POST['dshs'], true);
	foreach ($dshs_data as $item) {
		$hocvien = select_info($conn, $sql = "select * from tqhnyx4 where Tqhnyx4_id = " . $item['mahocvien']);
		$datains = [
			"Tw5emz1_CTPw4t" => $item['mahocvien'],
			"Tw5emz1_yj3zTl" => $hocvien['Tqhnyx4_a3IJ7h'],
			"Tw5emz1_KILBiu" => $hocvien['Tqhnyx4_wf9cA3'],
			"Tw5emz1_SgCZFq" => $hocvien['Tqhnyx4_xSAYHe'],
			"Tw5emz1_rK3hYq" => $info_lop['Tfupt39_9c2InL'],
			"Tw5emz1_Th6uEy" => $info_lop['Tfupt39_6382Bt'],
			"Tw5emz1_x4DCNG" => $info_lop['Tfupt39_bLWh5x'],
			"Tw5emz1_h0FGwq" => $info_lop['Tfupt39_bLWh5x'] * $info_lop['Tfupt39_F03ecR'],
			"Tw5emz1_EcRTSX" => $hocvien['Tqhnyx4_wkreu2'],
			"Tw5emz1_1ky04K" => $hocvien['Tqhnyx4_jQtwMp'],
			"Tw5emz1_N5iux8" => $id,
			"owner" => $User,
		];
		insertdb($conn, "tw5emz1", $datains);
	}


	exit;
}

if (isset($_GET['changeKhoahoc'])) {
	$this->layout('Student/layout2');

	$dskn = select_list($conn, $sql = "select * from tw5412b where Tw5412b_8urhgS = " . $_POST['khoahoc']);

	echo json_encode($dskn);

	exit;
}

if (isset($_GET['hienmalop'])) {
	$this->layout('Student/layout2');

	$trinhdo = select_info($conn, $sql = "select * from tzqp3mr where Tzqp3mr_id = " . $_POST['trinhdo'])['Tzqp3mr_NaR1k2'];

	$cno = select_info($conn, $sql = "select * from cno where Modulename = 'sttlophoc'")['Cno'] + 1;

	echo $trinhdo . ' - ' . $cno;

	exit;
}

if (isset($_GET['changeKynang'])) {
	$this->layout('Student/layout2');

	$re = select_list($conn, $sql = "select * from tzqp3mr where Tzqp3mr_v2VJMP = " . $_POST['kynang']);

	echo json_encode($re);

	exit;
}

if (isset($_GET['changeTrinhdo'])) {
	$this->layout('Student/layout2');

	$re = select_info($conn, $sql = "select * from tzqp3mr where Tzqp3mr_id = " . $_POST['trinhdo']);

	$dshs = select_list($conn, $sql = "select * from t6ewfr3 inner join tqhnyx4 on tqhnyx4_id = T6ewfr3_LRKdDa where T6ewfr3_YCU42W = " . $_POST['trinhdo']." and T6ewfr3_ODNk4W = 18");

	$arr = [];
	$arr['thongtin'] = $re;
	$arr['dshs'] = $dshs;

	echo json_encode($arr);

	exit;
}

if (isset($_GET['tinhgiokt'])) {
	$this->layout('Student/layout2');

	$sogiobuoi = str_replace(',', '.', $_POST['sogiobuoi']) * 60 * 60;
	$giobd = strtotime($_POST['giobd']);

	$giokt = date('H:i:s', $sogiobuoi + $giobd);

	echo json_encode($giokt);

	exit;
}

if (isset($_GET['clickChontatca'])) {
	$this->layout('Student/layout2');

	$dshs = select_list($conn, $sql = "select * from t6ewfr3 inner join tqhnyx4 on tqhnyx4_id = T6ewfr3_LRKdDa where T6ewfr3_YCU42W = " . $_POST['trinhdo']." and T6ewfr3_ODNk4W = 18");

	if ($dshs) {
		foreach ($dshs as $value) {
			$a = [
				"mahocvien" => $value['Tqhnyx4_id'],
				"mahocvientext" => $value['Tqhnyx4_HLr597'],
			];
			$b[] = $a;
		}
	} else {
		$b = [];
	}

	echo json_encode($b);

	exit;
}


?>
<div class="col-lg-12">
    <div class="box box-solid box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Thông tin lớp</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <form id="fmthongtinlop">

                <div class="col-sm-3" style="height:85px">
                    <div class="form-group">
                        <label for="T2fl9rv_ClvGYy">Mã lớp học</label>
                        <input type="text" name="Tfupt39_Iipc8P" class="form-control" id="Tfupt39_Iipc8P" readonly>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Khóa học</label>
                        <select name="khoahoc" id="khoahoc" class="form-control chosen-select"
                                onchange="changeKhoahoc()">
                            <option value="0">---</option>
							<?php
							$dskh = select_list($conn, $sql = "select * from tyug9kx");
							foreach ($dskh as $item) {
								?>
                                <option value="<?= $item['Tyug9kx_id'] ?>"><?= $item['Tyug9kx_40SF5Y'] ?></option>
								<?php
							}
							?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Kỹ năng</label>
                        <select name="Tfupt39_g5n3Zc" id="Tfupt39_g5n3Zc" class="form-control chosen-select"
                                onchange="changeKynang()">
                            <option value="0">---</option>

                        </select>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Trình độ</label>
                        <select name="Tfupt39_FKYz9D" id="Tfupt39_FKYz9D" class="form-control chosen-select" onchange="hienmalop();changeTrinhdo()">
                            <option value="0">---</option>

                        </select>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Ngày bắt đầu</label>
                        <input type="date" name="Tfupt39_9c2InL" class="form-control" id="Tfupt39_9c2InL">
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Ngày kết thúc</label>
                        <input type="date" name="Tfupt39_6382Bt" class="form-control" id="Tfupt39_6382Bt" readonly>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Sỹ số tối đa</label>
                        <input type="number" name="Tfupt39_myU01N" class="form-control" id="Tfupt39_myU01N" readonly>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Số buổi</label>
                        <input type="number" name="Tfupt39_lnR1F8" class="form-control" id="Tfupt39_lnR1F8" readonly>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Số giờ học</label>
                        <input type="number" name="Tfupt39_bLWh5x" class="form-control" id="Tfupt39_bLWh5x" readonly>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Học phí/giờ</label>
                        <input type="text" name="Tfupt39_F03ecR" class="form-control" id="Tfupt39_F03ecR" readonly>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Trạng thái</label>
                        <select name="Tfupt39_4BKlXg" id="Tfupt39_4BKlXg" class="form-control chosen-select">
                            <option value="0">---</option>
							<?php
							$trangthai = getlistdataman($conn, "Tfupt39_4BKlXg");
							foreach ($trangthai as $item) {
								?>
                                <option value="<?= $item['Id'] ?>" <?= $item['Id'] == 15 ? "selected" : "" ?>><?= $item['Value'] ?></option>
								<?php
							}
							?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3" style="height:85px">
                    <div class="form-group input-group-sm">
                        <label>Loại lớp</label>
                        <select name="Tfupt39_CnkKdL" id="Tfupt39_CnkKdL" class="form-control chosen-select">
                            <option value="0">---</option>
							<?php
							$loailop = select_list($conn, $sql = "select * from txy6uew");
							foreach ($loailop as $item) {
								?>
                                <option value="<?= $item['Txy6uew_id'] ?>"><?= $item['Txy6uew_N42TFq'] ?></option>
								<?php
							}
							?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="T2fl9rv_pJOs3y">Chi tiết</label>
                        <textarea name="Tfupt39_7XFwQq" rows="3" class="form-control" id="Tfupt39_7XFwQq"></textarea>
                    </div>
                </div>

            </form>
        </div> <!-- /.box-body -->
    </div><!-- /.box -->
</div>

<style>
    .col-lg-3, .col-lg-6 {
        height: 80px;
    }
</style>

<div class="col-lg-7">
    <div class="box box-solid box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Thời gian học</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
			<?php
			$cdata = array(
				array(
					'name' => 'thuhoc',
					'id' => 'thuhoc',
					'code' => 'T61inym_N5wAck',
					'show' => 'Thứ trong tuần',
					'type' => 'chose',
					'wid' => 3,
					'option' => 'onchange="checktime()"',
					'reset' => 'yes',
					'require' => 'yes',
				),
				array(
					'name' => 'sogiobuoi',
					'id' => 'sogiobuoi',
					'show' => 'Số giờ/buổi',
					'type' => 'text',
					'wid' => 3,
					'option' => 'onchange="checktime();tinhgiokt()"',
					'reset' => 'yes',
					'require' => 'yes',
				),
				array(
					'name' => 'giobd',
					'id' => 'giobd',
					'show' => 'Giờ bắt đầu',
					'type' => 'time',
					'wid' => 3,
					'option' => 'onchange="checktime();tinhgiokt()"',
					'reset' => 'yes',
					'require' => 'yes',
				),
				array(
					'name' => 'giokt',
					'id' => 'giokt',
					'show' => 'Giờ kết thúc',
					'type' => 'time',
					'wid' => 3,
					'option' => 'onchange="checktime()" readonly',
					'reset' => 'yes',
					'require' => 'yes',
				),
				array(
					'name' => 'giaovien',
					'id' => 'giaovien',
					'code' => 'T61inym_YLKzQa',
					'show' => 'Giáo viên',
					'type' => 'chose',
					'wid' => 3,
					'option' => 'onchange="checktime()"',
					'reset' => 'yes',
					'require' => 'yes',
				), array(
					'name' => 'trogiang',
					'id' => 'trogiang',
					'code' => 'T61inym_z6Dvqw',
					'show' => 'Trợ giảng',
					'type' => 'chose',
					'wid' => 3,
					'option' => '',
					'reset' => 'yes',
					'require' => 'no',
				),
				array(
					'name' => 'phong',
					'id' => 'phong',
					'code' => 'T61inym_Ea0SrX',
					'show' => 'Phòng',
					'type' => 'chose',
					'wid' => 3,
					'option' => 'onchange="checktime()"',
					'reset' => 'yes',
					'require' => 'yes',
				),
			);
			$onadd = '$(function(){
       $("#btntinhngaykt").show();
    });';
			drawformandlist($conn, $cdata, 'thoigianhoc', 'idsua', 'idbtadd', 'fname', $onadd);
			?>
        </div> <!-- /.box-body -->
        <div class="box-footer">
            <center>
                <button style="display: none" id="btntinhngaykt" class="btn btn-danger" onclick="tinhngaykt()">Tính ngày
                    kết thúc
                </button>
            </center>
        </div>
    </div><!-- /.box -->

</div>
<div class="col-lg-5">
    <div class="box box-solid box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Danh sách học viên</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3 pull-right">
                    <button class="btn btn-primary" id="chontatca" onclick="clickChontatca()">Chọn tất cả</button>
                </div>
            </div>
			<?php
			$cdata = array(
				array(
					'name' => 'mahocvien',
					'id' => 'mahocvien',
					'show' => 'Mã học viên',
					'type' => 'chose',
					'code' => 'T6ewfr3_LRKdDa',
					'wid' => 6,
					'option' => '',
					'reset' => 'yes',
					'require' => 'yes',
				),
			);
			$onaddhs = '';
			$ondelhs = '';
			$onediths = '';
			drawformandlist($conn, $cdata, 'dshs', 'idsuahs', 'idbtaddhs', 'fnamehs', $onaddhs, $ondelhs, $onediths);

			?>
        </div> <!-- /.box-body -->
    </div><!-- /.box -->
</div>
<div class="col-lg-12">
    <div class="box box-solid box-primary">
        <div class="box-body">
            <center>
                <button id="btnhoantat" onclick="fchoantat()" class="btn btn-primary">Hoàn tất</button>
            </center>
        </div> <!-- /.box-body -->
    </div><!-- /.box -->
</div>
<script>

    $(function () {
        $('#idbtadd').prop('disabled', true);

        $('#mahocvien').empty().trigger("chosen:updated");
    });

    function clickChontatca() {
        var trinhdo = $('#Tfupt39_FKYz9D').val();
        if (trinhdo != 0) {
            $.ajax({
                url: "/tu76k8t?clickChontatca",
                //async: false,
                dataType: "json",
                data: {trinhdo: trinhdo},
                type: "POST",
                success: function (data) {
                    $('#dshs').val('[]');

                    $('#dshs').val(JSON.stringify(data));
                    vebangfnamehs();

                    $('#mahocvien').val('').trigger("chosen:updated");
                },
                error: function () {
                }
            });
        } else {
            makeAlertright("Chưa chọn Kỹ năng", 2000);
        }
    }

    function hienmalop() {
        var trinhdo = $('#Tfupt39_FKYz9D').val();

        if (trinhdo != 0) {
            $.ajax({
                url: "/tu76k8t?hienmalop",
                //async: false,
                dataType: "text",
                data: {trinhdo: trinhdo},
                type: "POST",
                success: function (data) {
                    $('#Tfupt39_Iipc8P').val(data);
                },
                error: function () {
                }
            });
        } else {
            $('#Tfupt39_Iipc8P').val('');
        }
    }

    function changeKhoahoc() {
        var khoahoc = $('#khoahoc').val();

        if (khoahoc == 0) {
            $('#Tfupt39_g5n3Zc').empty();
            $('#Tfupt39_g5n3Zc').append($("<option></option>")
                .attr("value", 0)
                .text('---'));
            $('#Tfupt39_g5n3Zc').trigger("chosen:updated");

            hienmalop();
        } else {
            $.ajax({
                url: "/tu76k8t?changeKhoahoc",
                //async: false,
                dataType: "json",
                data: {khoahoc: khoahoc},
                type: "POST",
                success: function (data) {
                    $('#Tfupt39_g5n3Zc').empty();
                    $('#Tfupt39_g5n3Zc').append($("<option></option>")
                        .attr("value", 0)
                        .text('---'));
                    $.each(data, function (key, value) {
                        $('#Tfupt39_g5n3Zc').append($("<option></option>")
                            .attr("value", value.Tw5412b_id)
                            .text(value.Tw5412b_COyZef));
                    });
                    $('#Tfupt39_g5n3Zc').trigger("chosen:updated");

                    hienmalop();
                },
                error: function () {
                }
            });
        }

    }

    function changeKynang() {
        var kynang = $("#Tfupt39_g5n3Zc").val();

        if (kynang == 0) {
            $('#Tfupt39_FKYz9D').empty();
            $('#Tfupt39_FKYz9D').append($("<option></option>")
                .attr("value", 0)
                .text('---'));
            $('#Tfupt39_FKYz9D').trigger("chosen:updated");

            hienmalop();
        } else {
            $.ajax({
                url: "/tu76k8t?changeKynang",
                //async: false,
                dataType: "json",
                data: {kynang: kynang},
                type: "POST",
                success: function (data) {
                    $('#Tfupt39_FKYz9D').empty();
                    $('#Tfupt39_FKYz9D').append($("<option></option>")
                        .attr("value", 0)
                        .text('---'));
                    $.each(data, function (key, value) {
                        $('#Tfupt39_FKYz9D').append($("<option></option>")
                            .attr("value", value.Tzqp3mr_id)
                            .text(value.Tzqp3mr_XcQsjT));
                    });
                    $('#Tfupt39_FKYz9D').trigger("chosen:updated");

                    hienmalop();
                },
                error: function () {
                }
            });
        }
    }

    function changeTrinhdo() {
        var trinhdo = $("#Tfupt39_FKYz9D").val();

        if (trinhdo == 0) {
            $('#Tfupt39_myU01N').val('');
            $('#Tfupt39_lnR1F8').val('');
            $('#Tfupt39_bLWh5x').val('');
            $('#Tfupt39_F03ecR').val('');

            $('#mahocvien').empty().trigger("chosen:updated");
        } else {
            $.ajax({
                url: "/tu76k8t?changeTrinhdo",
                //async: false,
                dataType: "json",
                data: {trinhdo: trinhdo},
                type: "POST",
                success: function (data) {
                    $('#Tfupt39_myU01N').val(data.thongtin.Tzqp3mr_Lw2HOX * 1);
                    $('#Tfupt39_lnR1F8').val(data.thongtin.Tzqp3mr_3QHtpm * 1);
                    $('#Tfupt39_bLWh5x').val(data.thongtin.Tzqp3mr_KXtQDY * 1);
                    $('#Tfupt39_F03ecR').val(addcomma(data.thongtin.Tzqp3mr_rqBOwb * 1));

                    $('#mahocvien').empty();
                    $.each(data.dshs, function (key, value) {
                        $('#mahocvien').append($("<option></option>")
                            .attr("value", value.Tqhnyx4_id)
                            .text(value.Tqhnyx4_HLr597));
                    });
                    $('#mahocvien').trigger("chosen:updated");
                },
                error: function () {
                }
            });
        }
    }

    function tinhgiokt() {
        var sogiobuoi = $('#sogiobuoi').val();
        var giobd = $('#giobd').val();

        if (sogiobuoi == '' || giobd == '') {
            $('#giokt').val('');
        } else {
            $.ajax({
                url: "/tu76k8t?tinhgiokt",
                //async: false,
                dataType: "json",
                data: {sogiobuoi: sogiobuoi, giobd: giobd},
                type: "POST",
                success: function (data) {
                    $('#giokt').val(data);
                },
                error: function () {
                }
            });
        }
    }

    function checktime() {
        //lay cac gia tri can them
        var thuhocid = $('#thuhoc').val();
        var giobd = $('#giobd').val();
        var giokt = $('#giokt').val();
        var phongid = $('#phong').val();
        var gvid = $('#giaovien').val();
        var ngaybd = $('#Tfupt39_9c2InL').val();

        if (ngaybd == '') {
            makeAlertright("Chưa chọn Ngày bắt đầu", 2000);
            $('#idbtadd').prop('disabled', true);

            return;
        }

        $.ajax({
            url: "?checktime",
            dataType: "text",
            data: {
                thuhocid: thuhocid,
                giobd: giobd,
                giokt: giokt,
                phongid: phongid,
                gvid: gvid,
                ngaybd: ngaybd
            },
            type: "POST",
            success: function (data) {
                if (data == 1) {
                    makeAlertright("Lỗi trùng giờ,vui lòng kiểm tra lại thời khoá biểu!", 2000);
                    $('#idbtadd').prop('disabled', true);

                } else {
                    makeSAlertright("Không trùng!", 2000);
                    $('#idbtadd').prop('disabled', false);
                }
            },
            error: function () {
            }
        });
    }

    function tinhngaykt() {
        var ngaybd = [$('#Tfupt39_9c2InL').val()];
        var sogiohoc = $('#Tfupt39_bLWh5x').val();
        var thoigianhoc = $('#thoigianhoc').val();
        if (ngaybd == '') {
            makeAlertright("Chưa chọn Ngày bắt đầu", 3000);
            return;
        }
        $.ajax({
            url: "?tinhngaykt",
            dataType: "json",
            data: {ngaybd: ngaybd, sogiohoc: sogiohoc, thoigianhoc: thoigianhoc},
            type: "POST",
            success: function (data) {
                makeSAlertright('Tính ngày kết thúc thành công', 1000);
                $('#Tfupt39_6382Bt').val(data);
            },
            error: function () {
            }
        });

    }

    function fchoantat() {
        var tenlop = $('#Tfupt39_Iipc8P').val();
        var ngaybd = $('#Tfupt39_9c2InL').val();
        var ngaykt = $('#Tfupt39_6382Bt').val();
        var trangthai = $('#Tfupt39_4BKlXg').val();
        var loailop = $('#Tfupt39_CnkKdL').val();
        var thoigianhoc = $('#thoigianhoc').val();
        var trinhdo = $('#Tfupt39_FKYz9D').val();

        if (tenlop == '' || ngaybd == '' || ngaykt == '' || trangthai == 0 || loailop == 0 || thoigianhoc == '[]' || trinhdo == 0) {
            makeAlertright("Vui lòng điền đầy đủ thông tin.", 3000);
            return;
        }

        var formData = new FormData($('#fmthongtinlop')[0]);
        formData.append('thoigianhoc', $('#thoigianhoc').val());
        formData.append('dshs', $('#dshs').val());

        $('#btnhoantat').prop('disabled', true);
        $.ajax({
            type: 'post',
            url: 'tu76k8t?taolop',
            data: formData,
            //async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                makeSAlertright("Thành công ", 5000);

                setTimeout(function () {
                    location.reload();
                }, 700);
                /* window.setTimeout(function(){location.reload()},1000);*/
            }
        }); /// /End Ajax


    }
</script>

<style>
    .modal123 {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, .8) url('/img/loadding.gif') 50% 50% no-repeat;
    }

    /* When the body has the loading class, we turn
	   the scrollbar off with overflow:hidden */
    body.loading .modal123 {
        overflow: hidden;
    }

    /* Anytime the body has the loading class, our
	   modal element will be visible */
    body.loading .modal123 {
        display: block;
    }
</style>
<script>
    $body = $("body");
    $(document).on({
        ajaxStart: function () {
            $body.addClass("loading");
        },
        ajaxStop: function () {
            $body.removeClass("loading");
        }
    });
</script>
<div class="modal123"><!-- Place at bottom of page --></div>
