<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['xacnhan3'])) {
	$this->layout('Student/layout2');

	$noidung = $_POST['noidung'];
	$danhsach = json_decode($_POST['manghv1'], true);
	

	foreach ($danhsach as $val) {
		$mahs = select_info($conn, "select * from tyj7o9k where Tyj7o9k_id = " . $val);
		$data = array(
			"Tj9u7tk_5t9Hne" => $val,
			"Tj9u7tk_PD65tp" => $_POST['lophoc'],
			"Tj9u7tk_2yC5YE" => $_POST['khoahoc'],
			"Tj9u7tk_tVHJOb" => $mahs['Tyj7o9k_u2O5HC'],
			"Tj9u7tk_AIymQ3" => $_POST['noidung'],
			"Tj9u7tk_8Ge0yi" => $today,
		);
		insertdb($conn, "tj9u7tk", $data);
	}
	exit;
}

if (isset($_GET['lophocvskhoahoc1'])) {
	$this->layout('Student/layout2');
	$khoahoc = $_POST['khoahoc'];
	$lophoc = $_POST['lophoc'];

	$danhsachhs = select_list($conn, "select * from tyzh5in where Tyzh5in_uO40Kf = '" . $khoahoc . "' and Tyzh5in_CBpWtZ = '" . $lophoc . "'");

	?>
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>STT</th>
            <th>Tên học sinh</th>
            <th>Số điện thoại</th>
            <th>Chọn</th>
        </tr>
        </thead>
        <tbody>
		<?php
		$stt = 0;
		$j = 0;
		foreach ($danhsachhs as $value) {
			$stt++;
			$mahs = select_info($conn, "select * from tyj7o9k where Tyj7o9k_id = " . $value['Tyzh5in_yBpzNV']);
			?>
            <tr>
                <td><?= $stt ?></td>
                <td>
					<?= $mahs['Tyj7o9k_zn9b8t'] ?>
                    <input type="hidden" id="tenhs<?= $stt ?>" name="tenhs<?= $stt ?>"
                           value="<?= $mahs['Tyj7o9k_zn9b8t'] ?>">
                </td>
                <td>
					<?= $mahs['Tyj7o9k_u2O5HC'] ?>
                    <input type="hidden" id="std<?= $stt ?>" name="std<?= $stt ?>"
                           value="<?= $mahs['Tyj7o9k_u2O5HC'] ?>">
                </td>
                <td><input type="checkbox" id="<?= $value['Tyzh5in_yBpzNV'] ?>"
                           name="<?= $value['Tyzh5in_yBpzNV'] ?>"
                           class="checkhang">
                </td>
                <input type="hidden" value="<?= $value['Tyzh5in_yBpzNV'] ?> " id="mangan<?= $stt ?>">
            </tr>
			<?php
			$j++;
		}
		?>
        </tbody>
    </table>
    <input type="hidden" id="manghv" name="manghv" value="[]">
    <input type="hidden" value="<?= $stt ?>" id="dong" name="dong">
    <div class="col-md-12" style="margin: auto; text-align: center;">
        <button class="btn btn-success" onclick="xacnhan()" type="button">Gửi tin nhắn</button>
    </div>
    <script>
        $('.checkhang').change(function () {
            var id = $(this).attr('id');
            if ($(this).is(':checked')) {
                var manghv = JSON.parse($('#manghv').val());
                manghv.push(id);
                $('#manghv').val(JSON.stringify(manghv));
            } else {
                var manghv = JSON.parse($('#manghv').val());
                for (var i = 0; i < manghv.length; i++) {
                    if (parseInt(manghv[i]) == id) {
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

if (isset($_GET['ckhoahoc'])) {
	$this->layout('Student/layout2');
	$khoahoc = $_POST['khoahoc'];
	if ($khoahoc == 0) {
		$lophoc_khoahoc = select_list($conn, "select * from tjxzrka");
	} else {
		$lophoc_khoahoc = select_list($conn, "select * from tjxzrka where Tjxzrka_HFkZI3	 = " . $khoahoc);
	}

	echo json_encode($lophoc_khoahoc);
	exit;
}

?>

<div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
    <div class="box-header with-border">
        <h3 class="box-title">Form gửi sms</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <form id="formsm">
        <div class="box-body">
            <div class="col-md-12">
                <label>Nội dung tin nhắn</label>
                <textarea class="form-control" id="noidung" name="noidung"></textarea>
            </div>
            <div class="col-md-12" style="margin-top: 25px;">
                <div class="col-md-3">
                    <label>Khóa học</label>
                    <select id="khoahoc" name="khoahoc" class="form-control chosen-select" onchange="chonkhoahoc()">
                        <option value="0">Tất cả</option>
						<?php
						$khoahoc = select_list($conn, "select * from tbxn8g3");
						foreach ($khoahoc as $value) {
							?>
                            <option value="<?= $value['Tbxn8g3_id'] ?>"><?= $value['Tbxn8g3_hd7g3Q'] ?></option>
							<?php
						}
						?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Lớp học</label>
                    <select id="lophoc" name="lophoc" class="form-control chosen-select" onchange="lophocvskhoahoc()">
                        <option value="0">---</option>
						<?php
						$lophoc = select_list($conn, "select * from tjxzrka");
						foreach ($lophoc as $value) {
							?>
                            <option value="<?= $value['Tjxzrka_id'] ?>"><?= $value['Tjxzrka_siRo6k'] ?></option>
							<?php
						}
						?>
                    </select>
                </div>

                <div class="col-md-4" style="margin-top: 21px;" id='danhdau'>
                    <button class="btn btn-danger" id="danhdau1" onclick="danhdau()" type="button">Đánh dấu hết</button>

                </div>

            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer">
            <div id="show"></div>
        </div><!-- /.box-body -->
    </form>
</div><!-- /.box -->

<script src="/js/makealert.js" type="text/javascript"></script>
<script>

    $('#danhdau1').click(function () {
        var dong = $("#dong").val();
        var manghv1 = JSON.parse($('#manghv').val());
        var sohang = manghv1.length;

        if (dong > 0 && sohang == 0) {
            var manghv = JSON.parse($('#manghv').val());
            for (i = 1; i <= dong; i++) {
                var id = $("#mangan" + i).val();
                manghv.push(id);
            }
            $('#manghv').val(JSON.stringify(manghv));
            $("#danhdau1").attr('disabled', 'disabled ');
        }
        if (dong > 0 && sohang > 0) {
            var manghv = JSON.parse($('#manghv').val());
            var sohang1 = manghv.length;
            var dong1 = $("#dong").val();
            for (i = 1; i <= dong1; i++) {
                var id = $("#mangan" + i).val();
                for (j = 0; j < sohang1; j++) {
                    if (parseInt(manghv[j]) == id) {
                        manghv.splice(j, 1);
                    }
                }

            }
            $('#manghv').val(JSON.stringify(manghv));
            $("#danhdau1").attr('disabled', 'disabled ');
            themhet2();
        }
    });

    function themhet2() {
        var dong = $("#dong").val();
        var manghv = JSON.parse($('#manghv').val());
        for (i = 1; i <= dong; i++) {
            var id = $("#mangan" + i).val();
            manghv.push(id);
        }
        $('#manghv').val(JSON.stringify(manghv));
    }


    function chonkhoahoc() {
        var khoahoc = $("#khoahoc").val();
        $.ajax({
            url: "?ckhoahoc",
            dataType: "json",
            data: {khoahoc: khoahoc},
            type: "POST",
            success: function (data) {
                $('#lophoc').empty();
                $('#lophoc').append($('<option>').attr('value', 0).text('---'));
                $.each(data, function (key, value) {
                    $('#lophoc').append($("<option></option>")
                        .attr("value", value.Tjxzrka_id)
                        .text(value.Tjxzrka_siRo6k));
                });
                $('#lophoc').trigger("chosen:updated");
            },
            error: function () {
            }
        });
    }

    function lophocvskhoahoc() {
        var khoahoc = $("#khoahoc").val();
        var lophoc = $("#lophoc").val();
        if (khoahoc != "" && lophoc != "") {
            $.ajax({
                url: "?lophocvskhoahoc1",
                dataType: "text",
                data: {khoahoc: khoahoc, lophoc: lophoc},
                type: "POST",
                success: function (data) {
                    $("#show").html(data);
                },
                error: function () {
                }
            });

        }
    }

    /*function danhdau() {
        var dong = $("#dong").val();
        if (dong > 0) {
            $(".checkhang").attr("checked", "checked");
        }
    }*/


    function xacnhan() {
        var formData = new FormData($('#formsm')[0]);
        var manghv1 = $("#manghv").val();
        formData.append('manghv1', manghv1);
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
                /* window.setTimeout(function () {
					 location.reload()
				 }, 1000);*/
            }
        }); //End Ajax
    }
</script>
