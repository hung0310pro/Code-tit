<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['submitform1'])) {
	$this->layout('Student/layout2');
	$capdo = $_POST['capdoph'];
	$a = json_decode($_POST['manghv']);
	$mang = array();
	foreach ($a as $value) {
		$gio = explode("-", $value);
		$mang[] = $gio;
	}

	foreach ($mang as $val) {
		$thu = select_info($conn, "select * from dataman where Data_field = 'Tea4boi_BFMxnI' and Id = " . $val[1]);
		$thu1 = select_info($conn, "select * from t3j8pki where T3j8pki_J0oAnj = '" . $thu['Value'] . "'");
		$data1 = array(
			"Tknbf4s_jVMxtF" => $_POST['tenhocsinhid'],
			"Tknbf4s_cuGSFs" => $val[0],
			"Tknbf4s_Ti0WFw" => $thu1['T3j8pki_id'],
		);
		insertdb($conn, "tknbf4s", $data1);
	}

	$data = array(
		"Tb7jng8_TNJVqj" => $_POST['tenhocsinhid'],
		"Tb7jng8_uy92l0" => $_POST['makh'],
		"Tb7jng8_zOHXyw" => $capdo,
		"Tb7jng8_NyitX2" => $_POST['ngaydk'],
		"Tb7jng8_agyfp5" => 120,
	);
	insertdb($conn, "tb7jng8", $data);


	exit;
}

if (isset($_POST['submitform'])) {
	$this->layout('Student/layout2');
	$capdo = $_POST['capdoph'];
	$array = [];
	for ($i = 1; $i <= $_POST['dong']; $i++) {

		for ($j = 1; $j <= 7; $j++) {
			if (!empty($_POST['checkboxname' . $j . $i]) || $_POST['checkboxname' . $j . $i] != "") {
				$lophoc = select_list($conn, $sql = "select * from tjxzrka left join tea4boi on Tjxzrka_id = Tea4boi_6Zfvbk where Tjxzrka_HFkZI3 = '" . $capdo . "' and Tea4boi_BFMxnI = '" . $_POST['checkboxname' . $j . $i] . "' and Tea4boi_1QDuhM = '" . $_POST['khunggio' . $i] . "'");
				$array[] = $lophoc;
			}
		}

	}


	?>

    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>Tên lớp</th>
            <th>Cấp độ</th>
            <th>Ngày học trong tuần</th>
            <th>Khung giờ</th>
            <th>Đăng ký học</th>
        </tr>
        </thead>
        <tbody>
		<?php
		foreach ($array as $val) {
			$val = array_filter($val);
			if (!empty($val)) {
				foreach ($val as $value) {
					$capdo1 = select_info($conn, "select * from tbxn8g3 where Tbxn8g3_id = " . $capdo);
					$thuph = select_list($conn, "select * from tea4boi where Tea4boi_6Zfvbk = '" . $value['Tea4boi_6Zfvbk'] . "' and Tea4boi_qV5vOC = '" . $value['Tea4boi_qV5vOC'] . "'");
					?>
                    <tr>
                        <td><?= $value['Tjxzrka_siRo6k'] ?></td>
                        <td><?= $capdo1['Tbxn8g3_hd7g3Q'] ?></td>
                        <td>
							<?php
							$a = count($thuph);
							$stt = 0;
							foreach ($thuph as $value1) {
								$stt++;
								$thu = select_info($conn, "select * from dataman where Data_field = 'Tea4boi_BFMxnI' and Id = " . $value1['Tea4boi_BFMxnI']);
								if ($stt < $a) {
									echo $thu['Value'] . ", ";
								} else {
									echo $thu['Value'];
								}


							}
							?>
                        </td>
                        <td>
							<?php
							$a1 = count($thuph);
							$stt1 = 0;
							foreach ($thuph as $value1) {
								$stt1++;
								if (isset($value1['Tea4boi_1QDuhM'])) {
									$thu1 = select_info($conn, "select * from toe8vya where Toe8vya_id = " . $value1['Tea4boi_1QDuhM']);
								}
								if ($stt1 < $a1) {
									echo $thu1['Toe8vya_D1leM7'] . ", ";
								} else {
									echo $thu1['Toe8vya_D1leM7'];
								}


							}
							?>
                        </td>
                        <td><a href="/t1obv9d?" target="_blank"><i class="fa fa-arrow-circle-right"
                                                                   aria-hidden="true"></i></a></td>
                    </tr>
					<?php
				}

			}
		}
		?>
        </tbody>
    </table>
    <div id="okok">
        <span style="margin-left: 5px;color: #333300;font-size: 15px;">Nếu bạn không muốn đăng ký học thì lưu thông tin dưới đây</span><br>
        <button type="submit" class="btn btn-primary" style="margin-left: 5px;margin-top: 10px;"
                onclick=" checklich1()">Lưu thông tin
        </button>
    </div>

	<?php


	exit;
}

if (isset($_GET['checkph'])) {
	$this->layout('Student/layout2');
	$makh = $_POST['makh'];
	if ($makh != 0) {
		$list = select_info($conn, "select * from t8i7smn inner join tyj7o9k on Tyj7o9k_CIxaNf = T8i7smn_id where T8i7smn_id = " . $makh);
		$array = array(
			"tenhocvien" => $list['Tyj7o9k_Tn14gX'],
			"tenhocvienid" => $list['Tyj7o9k_id'],
		);

		echo json_encode($array);
	}
	exit;
}

?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">THÔNG TIN ĐĂNG KÝ HỌC VÀ THỜI GIAN HỌC</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <!--   <form id="formsm1">-->

    <form id="formsm">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Mã khách hàng</label>
                    <select class="form-control chosen-select" id="makh" name="makh" onchange="chonphuhuynh()">
                        <option value="0">---</option>
						<?php
						$makh = select_list($conn, "select * from t8i7smn");
						foreach ($makh as $value) {
							?>
                            <option value="<?= $value['T8i7smn_id'] ?>"><?= $value['T8i7smn_ZwjayB'] ?></option>
							<?php
						}
						?>

                    </select>
                </div>

                <div class="col-md-3">
                    <label>Tên học sinh</label>
                    <input type="text" readonly id="tenhocsinh" name="tenhocsinh" class="form-control">
                    <input type="hidden" id="tenhocsinhid" name="tenhocsinhid" class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Cấp độ phù hợp</label>
                    <select class="form-control chosen-select" id="capdoph" name="capdoph">
                        <option value="0">---</option>
						<?php
						$capdo = select_list($conn, "select * from tbxn8g3");
						foreach ($capdo as $value) {
							?>
                            <option value="<?= $value['Tbxn8g3_id'] ?>"><?= $value['Tbxn8g3_hd7g3Q'] ?></option>
							<?php
						}
						?>

                    </select>
                </div>

                <div class="col-md-3">
                    <label>Ngày đăng ký</label>
                    <input type="date" id="ngaydk" name="ngaydk" class="form-control">
                </div>
            </div>

            <div style="margin-top: 40px;">
                <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
                <script src="plugins/datatables/jquery.dataTables.js"></script>
                <script src="plugins/datatables/dataTables.bootstrap.js"></script>
                <h3 class="box-title" style="font-size: 16px;"><i class="fa fa-bars" aria-hidden="true"></i> THỜI
                    GIAN
                    HỌC
                </h3>
                <table id="bang1" class="table table-bordered table-striped table-hover text-center">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Thứ 2</th>
                        <th>Thứ 3</th>
                        <th>Thứ 4</th>
                        <th>Thứ 5</th>
                        <th>Thứ 6</th>
                        <th>Thứ 7</th>
                        <th>Chủ Nhật</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					$i = 0;
					$khunggio = select_list($conn, "select * from toe8vya order by Toe8vya_id desc");
					foreach ($khunggio as $value) {
						$i++;
						?>
                        <tr>
                            <td>
								<?= $value['Toe8vya_D1leM7'] ?>
                                <input type="hidden" value="<?= $value['Toe8vya_id'] ?>" id="khunggio<?= $i ?>"
                                       name="khunggio<?= $i ?>">
                            </td>
                            <td><input type="checkbox" name="checkboxname1<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-53" class="chonkh"
                                       value="53"></td>
                            <td><input type="checkbox" name="checkboxname2<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-54" class="chonkh"
                                       value="54"></td>
                            <td><input type="checkbox" name="checkboxname3<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-55" class="chonkh"
                                       value="55"></td>
                            <td><input type="checkbox" name="checkboxname4<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-56" class="chonkh"
                                       value="56"></td>
                            <td><input type="checkbox" name="checkboxname5<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-57" class="chonkh"
                                       value="57"></td>
                            <td><input type="checkbox" name="checkboxname6<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-58" class="chonkh"
                                       value="58"></td>
                            <td><input type="checkbox" name="checkboxname7<?= $i ?>"
                                       id="<?= $value['Toe8vya_id'] ?>-59" class="chonkh"
                                       value="59"></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
                <input type="hidden" id="dong" name="dong" value="<?= $i ?>">
                <input type="hidden" id="manghv" name="manghv" value="[]">
            </div>
            <div style="text-align: center">
                <button class="btn btn-success" type="button" onclick="checklich()">Xác Nhận</button>
            </div>
    </form>

    <!--  </form>-->
</div> <!-- /.box-body -->
<div class="box-footer">
    <div id="show"></div>
</div><!-- /.box-body -->
</div><!-- /.box -->

<script src="/js/makealert.js" type="text/javascript"></script>
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

    function chonphuhuynh() {
        var makh = $("#makh").val();
        $.ajax({
            url: "/t1ihqes?checkph",
            dataType: "json",
            data: {makh: makh},
            type: "POST",
            success: function (data) {
                $("#tenhocsinh").val(data.tenhocvien);
                $("#tenhocsinhid").val(data.tenhocvienid);
            },
            error: function () {
            }
        });
    }

    function checklich() {
        var formData = new FormData($('#formsm')[0]);
        formData.append('submitform', '');
        $.ajax({
            type: 'post',
            url: '/t1ihqes',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#show").html(data);
            }
        }); //End Ajax
    }


    function checklich1() {
        var formData = new FormData($('#formsm')[0]);
        $.ajax({
            type: 'post',
            url: '?submitform1',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                makeSAlertright("thành công", 5000);
                window.setTimeout(function () {
                    location.reload()
                }, 1000);
            }
        }); //End Ajax
    }

</script>
