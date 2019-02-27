<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

function s1970($ngay, $hsi = 'no')
{
	if ($ngay == '0000-00-00' || $ngay == '1970-01-01' || $ngay == '01-01-1970' || $ngay == '' || $ngay == '0000-00-00 00:00:00') {
		$ngaykihda = '';
	} else {
		if ($hsi == 'no') {
			$ngaykihda = date('d-m-Y', strtotime($ngay));
		} else {
			$ngaykihda = date('d-m-Y H:i:s', strtotime($ngay));
		}
	}
	return $ngaykihda;
}

function ExecQuerySelect($conn, $namemodul)
{
	$sql = "select * from '" . $namemodul . "'";
	$res = mysqli_query($conn, $sql);
	if (mysqli_errno($conn) != 0)
		return 'Error query: ' . mysqli_error($conn);

	$dataRes = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$dataRes[] = $row;
	}
	mysqli_free_result($res);
	return $dataRes;
}

if (isset($_GET['xacnhan3'])) {
	$this->layout('Student/layout2');
	$data = array(
		"T529w7o_TwHMca" => $_POST['taikhoan'],
		"T529w7o_BbEG1R" => $_POST['ngaythanhtoan'],
		"T529w7o_uhpmMJ" => rmcomma($_POST['sotien']),
		"T529w7o_Ij7QBc" => $_POST['khachhang'],
		"T529w7o_Jcb3sw" => $_POST['sochungtu'],
	);
	insertdb($conn, "t529w7o", $data);
	$id = lastinsertid($conn);

	for ($i = 1; $i <= $_POST['dong']; $i++) {
		$data1 = array(
			"T8h23bk_bOj4fS" => $id,
			"T8h23bk_jmMD8h" => $_POST['hopdong' . $i],
			"T8h23bk_i20JAh" => rmcomma($_POST['sotientt' . $i]),
			"T8h23bk_2W9SIA" => $_POST['ghichu' . $i],
		);
		insertdb($conn, "t8h23bk", $data1);
	}
	exit;
}

if (isset($_GET['chonkhachhang1'])) {
	$this->layout('Student/layout2');
	$listdonhang = select_list($conn, "select * from t4xbo1h where T4xbo1h_gQazj1 = '" . $_POST['khachhang'] . "' and T4xbo1h_9Fzusy > T4xbo1h_HQRNyO order by T4xbo1h_id desc");
	?>
    <div class="col-md-12">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>Hợp đồng</th>
                <th>Ngày ký</th>
                <th>Giá trị hợp đồng</th>
                <th>Số tiền đã thanh toán</th>
                <th>Số tiền thanh toán</th>
                <th>Ghi chú</th>
            </tr>
            </thead>
            <tbody>
			<?php
			$a = 0;
			foreach ($listdonhang as $value) {
				$a++;
				$sohieu = $value['T4xbo1h_9Fzusy'] - $value['T4xbo1h_HQRNyO'];
				?>
                <tr>
                    <td>
						<?= $value['T4xbo1h_dzK8xm'] ?>
                        <input type="hidden" style="border: none;" class="form-control" id="hopdong<?= $a ?>"
                               name="hopdong<?= $a ?>" value="<?= $value['T4xbo1h_id'] ?>">
                    </td>
                    <td><?= s1970($value['T4xbo1h_snaO94']) ?></td>
                    <td>
						<?= number_format($value['T4xbo1h_9Fzusy']) ?>
                        <input type="hidden" style="border: none;" class="form-control" id="giathd<?= $a ?>"
                               name="giathd<?= $a ?>">
                        <input type="hidden" style="border: none;" class="form-control" id="sohieu<?= $a ?>"
                               name="sohieu<?= $a ?>" value="<?= $sohieu ?>">
                    </td>
                    <td>
						<?= number_format($value['T4xbo1h_HQRNyO']) ?>
                        <input type="hidden" style="border: none;" class="form-control" id="tientt<?= $a ?>"
                               name="tientt<?= $a ?>">
                    </td>
                    <td>
                        <input type="text" style="border: none;" class="form-control" id="sotientt<?= $a ?>"
                               name="sotientt<?= $a ?>" onchange="tinhtiendaphanbo()" onkeyup="addcomma1(this)">
                    </td>
                    <td>
                        <textarea class="form-control" id="ghichu<?= $a ?>"
                                  name="ghichu<?= $a ?>" style="border: none;"></textarea>
                    </td>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
        <input type="hidden" id="dong" name="dong" value="<?= $a ?>">
    </div>
    <div class="col-md-12" style="margin-top: 20px;text-align: center;">
        <button class="btn btn-primary" type="button" onclick="xacnhan2()">Xác nhận</button>
    </div>
	<?php
	exit;
}

?>

<form id="bangchitiet">
    <div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
        <div class="box-header with-border">
            <h3 class="box-title">Thanh toán</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-sm-3">
                    <div class="form-group input-group-sm">
                        <label>Khách hàng</label>
                        <select name="khachhang" id="khachhang"
                                class="form-control chosen-select" onchange="chonkhachhang()">
                            <option value="0">--Chọn KH--</option>
							<?php
							$khachhang = select_list($conn, "select * from tbsr3u5");
							foreach ($khachhang as $val) {
								?>
                                <option value="<?= $val['Tbsr3u5_id'] ?>"><?= $val['Tbsr3u5_s2turQ'] ?></option>
								<?php
							}
							?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group input-group-sm">
                        <label>Tài khoản</label>
                        <select name="taikhoan" id="taikhoan"
                                class="form-control chosen-select">
                            <option value="0">--Chọn TK--</option>
							<?php
							$taikhoan = select_list($conn, "select * from tagtzkq");
							foreach ($taikhoan as $val) {
								?>
                                <option value="<?= $val['Tagtzkq_id'] ?>"><?= $val['Tagtzkq_KpemZL'] ?></option>
								<?php
							}
							?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group input-group-sm">
                        <label>Số chứng từ</label>
                        <input type="text" id="sochungtu" name="sochungtu" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group input-group-sm">
                        <label>Số tiền</label>
                        <input type="text" id="sotien" name="sotien" class="form-control" onkeyup="addcomma1(this)">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-sm-3">
                    <div class="form-group input-group-sm">
                        <label>Số tiền đã phân bổ</label>
                        <input type="text" id="sotiendaphanbo" name="sotiendaphanbo" class="form-control" readonly>
                        <input type="hidden" id="sotienhieu" name="sotienhieu" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group input-group-sm">
                        <label>Ngày thanh toán</label>
                        <input type="date" id="ngaythanhtoan" name="ngaythanhtoan" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3" style="margin-top: 20px;">
                    <div class="form-group input-group-sm">
                        <button type="button" class="btn btn-primary" onclick="phanbotien()">Phân bổ tự động</button>
                    </div>
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
    function chonkhachhang() {
        var khachhang = $("#khachhang").val();
        $.ajax({
            url: "?chonkhachhang1",
            dataType: "text",
            data: {khachhang: khachhang},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }

    function phanbotien() {
        $("#sotienhieu").val(0);
        var dong = $("#dong").val();
        for (var i = dong; i >= 1; i--) {
            $("#sotientt" + i).val(0);
        }
        var sotien = rmcomma($("#sotien").val());
        if (sotien == null || sotien == "" || sotien == 0) {
            makeAlertright('Nhập tiền để phẩn bổ', 3000);
        } else {
            if (dong == null || dong == "") {
                makeAlertright('Chọn khách hàng để phân bổ', 3000);
            } else {
                var i = dong;
                var sohieu = $("#sohieu" + i).val();
                var hieu2so = sotien - sohieu;
                if (hieu2so == 0 || hieu2so < 0) {
                    $("#sotientt" + i).val(addcomma(sotien));
                    var a = i - 1;
                    if (a > 0) {
                        for (var j = i - 1; j >= 1; j--) {
                            $("#sotientt" + j).val(0);
                        }
                    }
                    $("#sotienhieu").val(0);
                } else if (hieu2so > 0) {
                    $("#sotienhieu").val(hieu2so);
                    $("#sotientt" + i).val(addcomma(sohieu));
                    phanbotien22();
                }
            }
            tinhtiendaphanbo();
        }
    }

    function phanbotien22() {
        var dong = $("#dong").val();
        for (var i = dong - 1; i >= 1; i--) {
            var sotienhieu = $("#sotienhieu").val();
            var sohieu = $("#sohieu" + i).val();
            var hieu2so = sotienhieu - sohieu;
            if (hieu2so == 0 || hieu2so < 0) {
                $("#sotientt" + i).val(addcomma(sotienhieu));
                $("#sotienhieu").val(0);
                var a = i - 2;
                if (a > 0) {
                    for (var j = a; j >= 1; j--) {
                        $("#sotientt" + j).val(0);
                    }
                }
                break;
            } else if (hieu2so > 0) {
                console.log("bbbb");
                $("#sotientt" + i).val(addcomma(sohieu));
                $("#sotienhieu").val(hieu2so);
            }
        }
        tinhtiendaphanbo();
    }

    function tinhtiendaphanbo() {
        var dong = $("#dong").val();
        var tong = 0;
        for (var i = 1; i <= dong; i++) {
            var sotientt = rmcomma($("#sotientt" + i).val());
            tong += sotientt * 1;
        }
        $("#sotiendaphanbo").val(addcomma(tong));
    }

    function xacnhan2() {
        var formData = new FormData($('#bangchitiet')[0]);
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
