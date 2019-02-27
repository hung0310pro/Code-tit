<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

function ngay($date)
{
	if (!empty($date) and $date != '0000-00-00')
		return date('d-m-Y', strtotime($date));
}


if (isset($_GET['xacnhan3'])) {
	$this->layout('Student/layout2');
	$lop = json_decode($_POST['manghv'], true);

	$data1 = array(
		"Tyu56kv_hTaoJ2" => $_POST['hocsinh'],
		"Tyu56kv_pR5hwu" => $_POST['khoahoc'],
		"Tyu56kv_MEijYH" => $_POST['thoigian1'],
		"Tyu56kv_YyvjEl" => $_POST['thoigian2'],
		"Tyu56kv_36fhR7" => $_POST['ghichu'],
	);
	insertdb($conn, "tyu56kv", $data1);

	$manglop = [];
	foreach ($lop as $value) {
		$mang1 = explode('-', $value);
		$time = select_info($conn, "select * from t9hk7tp where T9hk7tp_id = " . $mang1[1]);
		$ngay1 = strtotime($time['T9hk7tp_MOLdXm']);
		$gio1 = date('H', strtotime($time['T9hk7tp_Rgq0ac']));
		$phut1 = date('i', strtotime($time['T9hk7tp_Rgq0ac']));
		$giay1 = date('s', strtotime($time['T9hk7tp_Rgq0ac']));
		$time1 = $ngay1 + $gio1 * 3600 + $phut1 * 60;
		$date3 = date("Y-m-d H:i:s", $time1);
		$data = array(
			"Tt4r7ax_yuFG7Q" => $_POST['hocsinh'],
			"Tt4r7ax_2hNnRa" => $mang1[0],
			"Tt4r7ax_SJ5RPn" => $date3,
			"Tt4r7ax_rsP9XS" => 35,
		);
		insertdb($conn, "tt4r7ax", $data);
	}


	exit;
}

if (isset($_GET['chonkh'])) {
	$this->layout('Student/layout2');
	$khoahoc = $_POST['khoahoc'];
	$listlop = select_list($conn, "select * from t3h97m5 where T3h97m5_FV6oHE = " . $khoahoc);

	echo json_encode($listlop);
	exit;
}

if (isset($_GET['xemlop'])) {
	$this->layout('Student/layout2');
	$lop = implode(",", $_POST['lop']);


	$arrth = array(
		'1' => 'Thứ 2',
		'2' => 'Thứ 3',
		'3' => 'Thứ 4',
		'4' => 'Thứ 5',
		'5' => 'Thứ 6',
		'6' => 'Thứ 7',
		'0' => 'Chủ nhật',
	);

	$a = -1;
	$mangngay = [];
	for ($i = 1; $i <= 30; $i++) {
		$a++;
		$date = strtotime(date('Y-m-d', strtotime($datetoday)) . "+$a day");
		$date = strftime("%Y-%m-%d", $date);
		$mangngay[] = $date;
	}

	$result = array();
	$arrsl = array();
	$maxa = 0;
	foreach ($arrth as $keyth => $rowth) {
		$key = $keyth;
		foreach ($mangngay as $rowtkb) {
			if ($keyth == getNumWeekday($rowtkb)) {
				$result[$key][] = $rowtkb;
			}
		}
		$counta = count($result[$key]);
		$arrsl[] = $counta;
	}
	$maxa = max($arrsl);
	$so = 0;
	$num = date('w');
	switch ($num) {
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
			$so = $num - 1;
			break;
		case 0:
			$so = 6;
			break;
		case 1:
			$so = 0;
			break;
	}
	for ($i = 1; $i <= $so; $i++) {
		$tamp = [null];
		$result[$i] = array_merge($tamp, $result[$i]);
	}


	?>
    <div class="col-md-12" style="overflow-x: scroll;">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
				<?php
				foreach ($arrth as $value) {
					?>
                    <th><?= $value ?></th>

					<?php
				}
				?>
            </tr>
            </thead>
            <tbody>
			<?php
			for ($i = 0; $i < $maxa; $i++) {
				?>
                <tr>
					<?php
					foreach ($arrth as $keyth => $rowth) {
						if (isset($result[$keyth][$i])) {
							$danhsachlop = select_list($conn, "select * from t9hk7tp where T9hk7tp_A5ZHbk in (" . $lop . ") and T9hk7tp_MOLdXm = '" . $result[$keyth][$i] . "'");
							?>
                            <td>
								<?= ngay($result[$keyth][$i]) ?><br>
								<?php
								if (isset($danhsachlop) && !empty($danhsachlop)) {
									foreach ($danhsachlop as $value) {
										$lop1 = select_info($conn, "select * from t3h97m5 where T3h97m5_id = " . $value['T9hk7tp_A5ZHbk']);
										?>
                                        <input type="checkbox" class="chonkh"
                                               id="<?= $value['T9hk7tp_A5ZHbk'] ?>-<?= $value['T9hk7tp_id'] ?>">-<?= $lop1['T3h97m5_SKfEOh'] ?>
                                        <br>
										<?php
									}
								}
								?>
                            </td>
							<?php
						} else {
							?>
                            <td></td>
							<?php
						}

					}

					?>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
        <input type="hidden" value="[]" id="manghv" name="manghv">
    </div>
    <div class="col-md-12">
        <button class="btn btn-primary" onclick="xacnhan2()" type="button">Xác nhận</button>
    </div>

    <script>
        $('.chonkh').change(function () {
            var id = $(this).attr('id');
            if ($(this).is(':checked')) {
                var manghv = JSON.parse($('#manghv').val());
                manghv.push(id);
                $('#manghv').val(JSON.stringify(manghv));
            } else {
                var manghv = JSON.parse($('#manghv').val());
                for (var i = 0; i < manghv.length; i++) {
                    if (manghv[i] == id) {
                        manghv.splice(i, 1);
                    }
                }
                $('#manghv').val(JSON.stringify(manghv));
            }
        });
    </script>
	<?php
	exit;
}
?>

<form id="formsm">
    <div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
        <div class="box-header with-border">
            <h3 class="box-title">Giao diện đăng ký học thử </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label>Học sinh</label>
                    <select id="hocsinh" name="hocsinh" class="form-control chosen-select">
                        <option value="0">---</option>
						<?php
						$hocsinh = select_list($conn, "select * from tknp81v");
						foreach ($hocsinh as $value) {
							?>
                            <option value="<?= $value['Tknp81v_id'] ?>"><?= $value['Tknp81v_Mkntzg'] ?></option>
							<?php
						}
						?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Khóa học</label>
                    <select id="khoahoc" name="khoahoc" class="form-control chosen-select" onchange="khoahoc1()">
                        <option value="0">---</option>
						<?php
						$khoahoc = select_list($conn, "select * from tizxora");
						foreach ($khoahoc as $value) {
							?>
                            <option value="<?= $value['Tizxora_id'] ?>"><?= $value['Tizxora_GcpBdF'] ?></option>
							<?php
						}
						?>
                    </select>
                </div>


                <div class="col-md-3">
                    <label>Thời gian mong muốn 1</label>
                    <input type="datetime-local" id="thoigian1" name="thoigian1" class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Thời gian mong muốn 2</label>
                    <input type="datetime-local" id="thoigian2" name="thoigian2" class="form-control">
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <div class="col-md-6">
                    <label>Ghi chú</label>
                    <textarea id="ghichu" name="ghichu" class="form-control"></textarea>
                </div>
            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
        <div class="box-header with-border">
            <h3 class="box-title">Chọn lịch học</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label>Lớp</label>
                    <select class="form-control chosen-select" id="lop" name="lop" multiple>
						<?php
						$lop = select_list($conn, "select * from t3h97m5");
						foreach ($lop as $value) {
							?>
                            <option value="<?= $value['T3h97m5_id'] ?>"><?= $value['T3h97m5_SKfEOh'] ?></option>
							<?php
						}
						?>
                    </select>
                </div>

                <div class="col-md-4" style="margin-top: 20px;">
                    <button class="btn btn-primary" onclick="xem()" type="button">Xem</button>
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
    function khoahoc1() {
        var khoahoc = $("#khoahoc").val();
        $.ajax({
            url: "?chonkh",
            dataType: "json",
            data: {khoahoc: khoahoc},
            type: "POST",
            success: function (data) {
                $('#lop').empty();
                $.each(data, function (key, value) {
                    $('#lop').append($("<option></option>")
                        .attr("value", value.T3h97m5_id)
                        .text(value.T3h97m5_SKfEOh));
                });
                $('#lop').trigger("chosen:updated");
            },
            error: function () {
            }
        });
    }

    function xem() {
        var lop = $("#lop").val();
        $.ajax({
            url: "?xemlop",
            dataType: "text",
            data: {lop: lop},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }

    function xacnhan2() {
        var formData = new FormData($('#formsm')[0]);
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


</script>
