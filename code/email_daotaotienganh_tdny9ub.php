<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);


function where_col($bien, $col)
{
	if (empty($bien)) {
		return "";
	} else {
		return " and " . $col . " = " . $bien . " ";
	}
}

if (isset($_GET['insert'])) {
	$this->layout('Student/layout2');
	$hv = implode(',', json_decode($_POST['danhsachtn'], true));
	$hocvien = select_list($conn, "select * from tyj7o9k where Tyj7o9k_id in (" . $hv . ")");
	$url = 'http://service.sms.fpt.net/oauth2/token';
	$data = array(
		"grant_type" => "client_credentials",
		"client_id" => "1476D3b5e609c54b257c5896c8D503a7f2ca66a4",
		"client_secret" => "8b7A77f6d531f5C2b8778880f1bd200194D47d42c5ccf00b31060b278c45de59095adffa",
		"scope" => "send_brandname_otp",
		"session_id" => "789dC48b88e54f58ece5939f14a"
	);
	$data = json_encode($data);
	$ch = curl_init('http://service.sms.fpt.net/oauth2/token');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data))
	);
	$a = curl_exec($ch);
	$b = json_decode($a, true);

	foreach ($hocvien as $value) {

		$data2 = [
			"access_token" => $b['access_token'],
			"session_id" => "789dC48b88e54f58ece5939f14a",
			"BrandName" => "ENTA.EDU.VN",
			"Phone" => $value['Tyj7o9k_u2O5HC'],
			"Message" => base64_encode($_POST['noidungtn'])];
		$data2 = json_encode($data2);
		$ch1 = curl_init('http://service.sms.fpt.net/api/push-brandname-otp');
		curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $data2);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data2))
		);
		$a1 = curl_exec($ch1);
		$b1 = json_decode($a1, true);
		echo json_encode($b1);

		$data = [
			"Tkrji65_85aNq6" => $value['Tyj7o9k_u2O5HC'],
			"Tkrji65_4Jpvb9" => $_POST['noidungtn'],
			"Tkrji65_L1oPFQ" => $today,
			"Tkrji65_nIhOHL" => json_encode($b1),
			"owner" => $User,
		];
		insertdb($conn, 'tkrji65', $data);
	}
	exit();
}
if (isset($_GET['vebangtn'])) {
	$this->layout('Student/layout2');

	$loptn = $_POST['loptn'];
	$trangthaitn = $_POST['trangthaitn'];
	if (empty($loptn) && empty($trangthaitn)) {
		echo "<code>Không có dữ liệu phù hợp</code>";
	} else {
		if (!empty($loptn) && !empty($trangthaitn)) {
			$sql = "select * from tyzh5in inner join tyj7o9k on Tyj7o9k_id = Tyzh5in_yBpzNV where 0=0 " . where_col($loptn, "Tyzh5in_CBpWtZ") . where_col($trangthaitn, "Tyj7o9k_OVrMbk");
		} elseif (!empty($loptn) && empty($trangthaitn)) {
			$sql = "select * from tyzh5in inner join tyj7o9k on Tyj7o9k_id = Tyzh5in_yBpzNV where 0=0 " . where_col($loptn, "Tyzh5in_CBpWtZ");
		} elseif (empty($loptn) && !empty($trangthaitn)) {
			$sql = "select * from tyj7o9k where 0=0 " . where_col($trangthaitn, "Tyj7o9k_OVrMbk");
		}
		$hs = select_list($conn, $sql);
		?>
        <div class="row">
            <div class="col-md-12" style="text-align: right; padding-bottom: 10px;">
                <button class="btn btn-danger" type="button" id="select-all">Chọn tất cả</button>
            </div>
        </div>
        <table id="bangtn" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã học sinh</th>
                <th>Ngày bắt đầu học</th>
                <th>Ngày kết thúc học</th>
                <th>SĐT</th>
                <th>Số tiền còn lại</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php
			$stt = 0;
			foreach ($hs as $value) {
				$stt++;
				?>
                <tr>
                    <td><?= $stt ?></td>
                    <td><?= $value['Tyj7o9k_zn9b8t'] ?></td>
                    <td><?= date('d/m/Y', strtotime($value['Tyzh5in_nDJKWy'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($value['Tyzh5in_UBtu3G'])) ?></td>
                    <td><?= $value['Tyj7o9k_u2O5HC'] ?></td>
                    <td><?= number_format($value['Tyzh5in_kh7xNP']) ?></td>
                    <td><input type="checkbox" class="form-check-input " name="checkboxaaaa"
                               id="<?= $value['Tyj7o9k_id'] ?>" onchange="checkbox(<?= $value['Tyj7o9k_id'] ?>)">
                    </td>
                </tr>
				<?php
			}

			?>
            <input type="hidden" name="danhsachtn" id="danhsachtn" value="[]">
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        <script type="text/javascript">
            $('#select-all').click(function (event) {

                $(':checkbox').each(function () {
                    //console.log(this.id);
                    this.checked = true;
                    checkbox(this.id);

                });
            });

            function checkbox(id) {
                if ($('#' + id).is(':checked')) {
                    var a = $.parseJSON($('#danhsachtn').val());
                    a.push(id);
                    $('#danhsachtn').val(JSON.stringify(a));
                } else {
                    var a = $.parseJSON($('#danhsachtn').val());
                    for (var i = a.length - 1; i >= 0; i--) {
                        if (a[i] == id) {
                            a.splice(i, 1);
                            $('#danhsachtn').val(JSON.stringify(a));
                        }
                    }
                }
            }
        </script>
		<?php
	}
	exit;
}
if (isset($_GET['insert2'])) { //???
    $this->layout('Student/layout2');
	$hv = implode(',', json_decode($_POST['danhsach'], true));
	$hocvien = select_list($conn, "select * from tyj7o9k where Tyj7o9k_id in (" . $hv . ")");
	foreach ($hocvien as $value) {
		$to[] = $value['Tyj7o9k_7T60hy'];
	}
	$tamp = $to;
	$to = implode(';', $to);
	$tieude = $_POST['tieude'];
	$noidung = $_POST['noidung'];
	if (empty($_POST['emailgui'])) {
		$from = [
			"username" => "coquynhielts@gmail.com",
			"password" => "H@dequynhs@u",
			"sendname" => "Trung tâm ngoại ngữ Enta",
		];
	} else {
		$emailgui1 = select_info($conn, "select * from trdwfas where trdwfas_id = " . $_POST['emailgui']);
		$from = [
			"username" => $emailgui1['Trdwfas_lzavd9'],
			"password" => $emailgui1['Trdwfas_04cGCp'],
			"sendname" => $emailgui1['Trdwfas_1NbLhR'],
			"host" => $emailgui1['Trdwfas_tIWqk2'],
			"secure" => $emailgui1['Trdwfas_jbo7My'],
			"port" => $emailgui1['Trdwfas_xtwzu8'],
		];
	}

	$data = [
		"Th75nkx_UtWi0F" => $tieude,
		"Th75nkx_p8MjyC" => $noidung,
		"Th75nkx_fZOmLQ" => $datetoday,
		"Th75nkx_w3Iant" => $to
	];
	insertdb($conn, 'th75nkx', $data);
	$id = lastinsertid($conn);
	uploadfile($dbname, 'th75nkx', $id, 'dinhkem', __FILE__);

	$a = getlistfile($dbname, 'Th75nkx', $id, __FILE__);

	$files = [
		implode(';', $a),
	];
    foreach ($tamp as $val){
        sendmail($from, $val, $tieude, $noidung, $files);
    }
	exit();
}
if (isset($_GET['vebang'])) {
	$this->layout('Student/layout2');

	$lop = $_POST['lop'];
	$trangthai = $_POST['trangthai'];
	if (empty($lop) && empty($trangthai)) {
		echo "<code>Không có dữ liệu phù hợp</code>";
	} else {
		if (!empty($lop) && !empty($trangthai)) {
			$sql = "select * from tyzh5in inner join tyj7o9k on Tyj7o9k_id = Tyzh5in_yBpzNV where 0=0 " . where_col($lop, "Tyzh5in_CBpWtZ") . where_col($trangthai, "Tyj7o9k_OVrMbk");
		} elseif (!empty($lop) && empty($trangthai)) {
			$sql = "select * from tyzh5in inner join tyj7o9k on Tyj7o9k_id = Tyzh5in_yBpzNV where 0=0 " . where_col($lop, "Tyzh5in_CBpWtZ");
		} elseif (empty($lop) && !empty($trangthai)) {
			$sql = "select * from tyj7o9k where 0=0 " . where_col($trangthai, "Tyj7o9k_OVrMbk");
		}
		$hs = select_list($conn, $sql);

		?>
        <div class="row">
            <div class="col-md-12" style="text-align: right; padding-bottom: 10px;">
                <button class="btn btn-danger" type="button" id="select-all">Chọn tất cả</button>
            </div>
        </div>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mã học sinh</th>
                <th>Ngày bắt đầu học</th>
                <th>Ngày kết thúc học</th>
                <th>Email</th>
                <th>Số tiền còn lại</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php
			$stt = 0;
			foreach ($hs as $value) {
				$stt++;
				?>
                <tr>
                    <td><?= $stt ?></td>
                    <td><?= $value['Tyj7o9k_zn9b8t'] ?></td>
                    <td><?= date('d/m/Y', strtotime($value['Tyzh5in_nDJKWy'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($value['Tyzh5in_UBtu3G'])) ?></td>
                    <td><?= $value['Tyj7o9k_7T60hy'] ?></td>
                    <td><?= number_format($value['Tyzh5in_kh7xNP']) ?></td>
                    <td><input type="checkbox" class="form-check-input " name="checkboxaaaa"
                               id="<?= $value['Tyj7o9k_id'] ?>" onchange="checkbox(<?= $value['Tyj7o9k_id'] ?>)">
                    </td>
                </tr>
				<?php
			}

			?>
            <input type="hidden" name="danhsach" id="danhsach" value="[]">
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        <script type="text/javascript">
            $('#select-all').click(function (event) {

                $(':checkbox').each(function () {
                    //console.log(this.id);
                    this.checked = true;
                    checkbox(this.id);

                });
            });

            function checkbox(id) {
                if ($('#' + id).is(':checked')) {
                    var a = $.parseJSON($('#danhsach').val());
                    a.push(id);
                    $('#danhsach').val(JSON.stringify(a));
                } else {
                    var a = $.parseJSON($('#danhsach').val());
                    for (var i = a.length - 1; i >= 0; i--) {
                        if (a[i] == id) {
                            a.splice(i, 1);
                            $('#danhsach').val(JSON.stringify(a));
                        }
                    }
                }
            }
        </script>
		<?php
	}
	exit;
}
?>
<style>
    .chosen-container {
        width: 100% !important;
    }
</style>
<div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
    <div class="box-header with-border">
        <h3 class="box-title">Giao diện gửi email/tin nhắn</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Gửi email</a></li>
            <li><a data-toggle="tab" href="#menu1">Gửi tin nhắn</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Giao diện gửi mail</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>  <!-- /.box-tools -->
                    </div> <!-- /.box-header -->
                    <div class="box-body">
                        <form id="frmguimail" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lớp</label>
                                        <select class="form-control chosen-select" name="lop" id="lop"
                                                onchange="vebang()">
                                            <option value="0">---</option>
											<?php
											$lop = getlist($conn, 'tjxzrka');
											foreach ($lop as $value) {
												?>
                                                <option value="<?= $value['Tjxzrka_id'] ?>"><?= $value['Tjxzrka_siRo6k'] ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select class="form-control chosen-select" name="trangthai" id="trangthai"
                                                onchange="vebang()">
                                            <option value="0">---</option>
											<?php
											$trangthai = getlistdataman($conn, 'Tyj7o9k_OVrMbk');
											foreach ($trangthai as $value) {
												?>
                                                <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tiêu đề</label>
                                        <input type="text" name="tieude" id="tieude" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email gửi:</label>
                                        <select class="form-control chosen-select" id="emailgui" name="emailgui">
                                            <option value="0">---</option>
											<?php
											$email = select_list($conn, "select * from trdwfas");
											foreach ($email as $value) {
												?>
                                                <option value="<?= $value["Trdwfas_id"] ?>"><?= $value["Trdwfas_lzavd9"] ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Đính kèm</label>
                                        <input type="file" name="dinhkem[]" id="dinhkem" class="form-control"
                                               multiple="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nội dung</label>
                                        <textarea class="form-control" name="noidung" id="noidung"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="showbang">

                            </div>
                        </form>
                    </div> <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button class="btn btn-primary" type="button" onclick="guimail()">Gửi</button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <script src="/js/makealert.js" type="text/javascript"></script>
                <script type="text/javascript">
                    $(function () {
                        CKEDITOR.replace('noidung');
                    })

                    function vebang() {
                        var lop = $('#lop').val();
                        var trangthai = $('#trangthai').val();
                        var emailgui = $('#emailgui').val();
                        $.ajax({
                            url: "tdny9ub?vebang",
                            dataType: "text",
                            data: {lop: lop, trangthai: trangthai, emailgui: emailgui},
                            type: "POST",
                            success: function (data) {
                                $('#showbang').html(data);
                            },
                            error: function () {
                            }
                        })
                    }

                    function guimail() {
                        var formData = new FormData($('#frmguimail')[0]);
                        formData.append('a', $('#danhsach').val());
                        formData.append('noidung', CKEDITOR.instances['noidung'].getData());
                        if(CKEDITOR.instances['noidung'].getData() =='' || CKEDITOR.instances['noidung'].getData() == null){
                            makeAlertright('Vui lòng nhập nội dung',1000);
                            return;
                        }
                        $.ajax({
                            type: 'post',
                            url: 'tdny9ub?insert2',
                            data: formData,
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                makeSAlertright('Gửi thành công!', 5000);
                                window.setTimeout(function () {
                                    //location.reload()
                                }, 1000);
                            }
                        }); //End Ajax
                    }; //End submit
                </script>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Giao diện gửi tin nhắn</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>  <!-- /.box-tools -->
                    </div> <!-- /.box-header -->
                    <div class="box-body">
                        <form id="frmguimailtn" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lớp</label>
                                        <select class="form-control chosen-select" name="loptn" id="loptn"
                                                onchange="vebangtn()">
                                            <option value="0">---</option>
											<?php
											$loptn = getlist($conn, 'tjxzrka');
											foreach ($loptn as $value) {
												?>
                                                <option value="<?= $value['Tjxzrka_id'] ?>"><?= $value['Tjxzrka_siRo6k'] ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select class="form-control chosen-select" name="trangthaitn" id="trangthaitn"
                                                onchange="vebangtn()">
                                            <option value="0">---</option>
											<?php
											$trangthaitn = getlistdataman($conn, 'Tyj7o9k_OVrMbk');
											foreach ($trangthaitn as $value) {
												?>
                                                <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4">
									<div class="form-group">
										<label>Tiêu đề</label>
										<input type="text" name="tieude" id="tieude" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Đính kèm</label>
										<input type="file" name="dinhkem[]" id="dinhkem" class="form-control" multiple="">
									</div>
								</div> -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nội dung</label>
                                        <textarea class="form-control" name="noidungtn" id="noidungtn"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div id="showbangtn">

                            </div>
                        </form>
                    </div> <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button class="btn btn-primary" type="button" onclick="guimailtn()">Gửi</button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <script src="/js/makealert.js" type="text/javascript"></script>
                <script type="text/javascript">
                    // $(function(){
                    // 	CKEDITOR.replace( 'noidungtn' );
                    // })
                    function vebangtn() {
                        var loptn = $('#loptn').val();
                        var trangthaitn = $("#trangthaitn").val();
                        $.ajax({
                            url: "?vebangtn",
                            dataType: "text",
                            data: {loptn: loptn, trangthaitn: trangthaitn},
                            type: "POST",
                            success: function (data) {
                                $('#showbangtn').html(data);
                            },
                            error: function () {
                            }
                        })
                    }

                    function guimailtn() {
                        var formData = new FormData($('#frmguimailtn')[0]);
                        formData.append('a', $('#danhsachtn').val());
                        // formData.append('noidungtn',CKEDITOR.instances['noidungtn'].getData());
                        $.ajax({
                            type: 'post',
                            url: '?insert',
                            data: formData,
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                makeSAlertright('Thành công', 1000);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                                // makeSAlertright('Thêm mới thành công!', 5000);
                                // window.setTimeout(function(){location.reload()},1000);
                            }
                        }); //End Ajax
                    }; //End submit
                </script>
            </div>
        </div>
    </div> <!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-body -->
</div><!-- /.box -->
