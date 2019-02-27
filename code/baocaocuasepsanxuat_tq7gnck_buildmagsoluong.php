<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);


if (isset($_GET['xembaocao1'])) {
	$this->layout('Student/layout2');
	$nhacungcap = $_POST['nhacungcap'];
	$hopdong = $_POST['hopdong'];
	$dulieuhopdong = select_list($conn, "select * from thca3w5 where Thca3w5_1j90M3 = '" . $hopdong . "'");
	$thanhtoangcngoai = select_info($conn, "select sum(Tkpd5sf_I0xn9v) as thanhtoangcngoai from tkpd5sf where Tkpd5sf_ijbvua = '" . $hopdong . "'");
	$mang = [];
	foreach ($dulieuhopdong as $value) {
		$listsanpham = select_info($conn, "select * from tnyqzar where Tnyqzar_id = '" . $value['Thca3w5_hibSPH'] . "'");
		$key = $listsanpham['Tnyqzar_L3pEa2'];
		if (isset($mang[$key])) {
			if (empty($mang[$key]['soluong'])) {
				$mang[$key]['soluong'] = 0;
			}
			$mang[$key]['soluong'] += $value['Thca3w5_HIatvi'];
			$mang[$key]['dongia'] = $value['Thca3w5_SulX2c'];
			$mang[$key]['vat'] = $value['Thca3w5_COsWaw'];
		} else {
			$mang[$key]['soluong'] = $value['Thca3w5_HIatvi'];
			$mang[$key]['dongia'] = $value['Thca3w5_SulX2c'];
			$mang[$key]['vat'] = $value['Thca3w5_COsWaw'];
		}
	}

	?>
    <div class="col-md-12">
        <div class="col-md-12">
            <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
            <script src="plugins/datatables/jquery.dataTables.js"></script>
            <script src="plugins/datatables/dataTables.bootstrap.js"></script>
            <table id="bang1" class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Số lượng theo hợp đồng</th>
                    <th>Đơn giá</th>
                    <th>VAT</th>
                    <th>Số lượng bán thành phẩm đã giao</th>
                    <th>Số lượng Bán thành phẩm đã nhận</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$tienthanhtoan = 0;
				$tienhopdong = 0;
				foreach ($mang as $key => $value) {
					$sanpham = select_info($conn, "select * from t3k5at6 where T3k5at6_id = '" . $key . "'");
					$donvi = select_info($conn, "select * from tmtkvcd where Tmtkvcd_id = '" . $sanpham['T3k5at6_BtHhD0'] . "'");

					$soluongbangiao = select_info($conn, "select SUM(Tm8zbgv_mu6qcM) as soluonggiao from tm8zbgv left join tvqg48n on Tvqg48n_id = Tm8zbgv_K2Wkxs where Tm8zbgv_P0LM2x = '" . $key . "' and Tvqg48n_7r6fIj = '" . $hopdong . "'");

					$soluonggiacongngoai = select_info($conn, "select SUM(Tqnz5sr_YoSDh3) as soluongnhap from tqnz5sr left join tz71swx on Tz71swx_id = Tqnz5sr_iBqlXg where Tqnz5sr_7I5lNs = '" . $key . "' and Tz71swx_Ko4OQb = '" . $hopdong . "'");
					$tientt = $soluongbangiao['soluonggiao'] * $value['dongia'] + $soluongbangiao['soluonggiao'] * $value['dongia'] * $value['vat'] / 100;
					$tienhd = $value['soluong'] * $value['dongia'] + $value['soluong'] * $value['dongia'] * $value['vat'] / 100;
					$tienthanhtoan = $tienthanhtoan + $tientt;
					$tienhopdong = $tienhopdong + $tienhd;
					?>
                    <tr>
                        <td><?= $sanpham['T3k5at6_dTg4pb'] ?></td>
                        <td><?= $donvi['Tmtkvcd_EAt92q'] ?></td>
                        <td><?= (int)$value['soluong'] ?></td>
                        <td><?= number_format($value['dongia']) ?></td>
                        <td><?= $value['vat'] ?></td>
                        <td><?= (int)$soluongbangiao['soluonggiao'] ?></td>
                        <td><?= (int)$soluonggiacongngoai['soluongnhap'] ?></td>
                    </tr>
					<?php
				}
				?>
                </tbody>
            </table>
        </div>
		<?php
		$dulieubang2 = select_list($conn, "select * from txunrk8 where Txunrk8_hTYxer = '" . $hopdong . "'");

		$mang1 = [];
		foreach ($dulieubang2 as $value) {
			$sanphambang2 = select_list($conn, "select * from tekajvf where Tekajvf_viNfnG = '" . $value['Txunrk8_9REGUo'] . "'");
			foreach ($sanphambang2 as $val) {
				$key = $val['Tekajvf_HGo6OF'];
				if (isset($mang1[$key])) {
					if (empty($mang[$key]['soluong'])) {
						$mang1[$key]['soluong'] = 0;
					}
					$mang1[$key]['soluong'] += $val['Tekajvf_23YZvm'];
				} else {
					$mang1[$key]['soluong'] = $val['Tekajvf_23YZvm'];
				}
			}
		}
		

		?>
        <div class="col-md-12">
            <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
            <script src="plugins/datatables/jquery.dataTables.js"></script>
            <script src="plugins/datatables/dataTables.bootstrap.js"></script>
            <table id="bang2" class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Vật tư</th>
                    <th>Đơn vị</th>
                    <th>Số lượng đã giao</th>
                </tr>
                </thead>
                <tbody>
				<?php
				foreach ($mang1 as $key => $value) {
					$sanpham1 = select_info($conn, $sql = "select * from t3k5at6 where T3k5at6_id = '" . $key . "'");

					$donvi1 = select_info($conn, "select * from tmtkvcd where Tmtkvcd_id = '" . $sanpham1['T3k5at6_BtHhD0'] . "'");
					?>
                    <tr>
                        <td><?= $sanpham1['T3k5at6_dTg4pb'] ?></td>
                        <td><?= $donvi1['Tmtkvcd_EAt92q'] ?></td>
                        <td><?= (int)$value['soluong'] ?></td>
                    </tr>
					<?php
				}
				?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12" style="margin-top: 30px;">
        <div class="col-md-12">
            <b style="font-size: 17px;">Tổng giá trị hợp đồng : <?= number_format($tienhopdong) ?>.</b><br>
            <b style="font-size: 17px;">Tổng giá trị thanh toán
                : <?= number_format($thanhtoangcngoai['thanhtoangcngoai']) ?>.</b><br>
            <b style="font-size: 17px;">Tổng giá trị đã hoàn thành : <?= number_format($tienthanhtoan) ?>.</b>
        </div>
    </div>
	<?php
	exit;
}

if (isset($_GET['nhacungcap1'])) {
	$this->layout('Student/layout2');
	$hopdong = select_list($conn, "select * from tl3jvkh where Tl3jvkh_GtRArV = '" . $_POST['nhacungcap'] . "'");
	echo json_encode($hopdong);
	exit;
}

?>

<div class="box box-solid box-info" style="box-shadow: 5px 10px 10px #a9a9a9">
    <div class="box-header with-border">
        <h3 class="box-title">Báo cáo hợp đồng gia công ngoài</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <div class="col-sm-3">
            <div class="form-group input-group-sm">
                <label>Nhà cung cấp</label>
                <select name="nhacungcap" id="nhacungcap" onchange="chonnhacungcap();xembaocao()"
                        class="form-control chosen-select">
                    <option value="0">--Chọn LSX--</option>
					<?php
					$nhacungcap = select_list($conn, "select * from tc2qij1");
					foreach ($nhacungcap as $val) {
						?>
                        <option value="<?= $val['Tc2qij1_id'] ?>"><?= $val['Tc2qij1_CMYfrJ'] ?></option>
						<?php
					}
					?>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group input-group-sm">
                <label>Hợp đồng</label>
                <select name="hopdong" id="hopdong"
                        class="form-control chosen-select" onchange="xembaocao()">
                    <option value="0">--Chọn HĐ--</option>
                </select>
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
    function chonnhacungcap() {
        var nhacungcap = $("#nhacungcap").val();
        $.ajax({
            url: "?nhacungcap1",
            dataType: "json",
            data: {nhacungcap: nhacungcap},
            type: "POST",
            success: function (data) {
                $('#hopdong').empty();
                $('#hopdong').append($('<option>').attr('value', 0).text('--Chọn HĐ--'));
                $.each(data, function (key, value) {
                    $('#hopdong').append($("<option></option>")
                        .attr("value", value.Tl3jvkh_id)
                        .text(value.Tl3jvkh_Bk8eJq));
                });
                $('#hopdong').trigger("chosen:updated");
            },
            error: function () {
            }
        });
    }

    function xembaocao() {
        var nhacungcap = $("#nhacungcap").val();
        var hopdong = $("#hopdong").val();
        if (nhacungcap != 0 && hopdong != 0) {
            $.ajax({
                url: "?xembaocao1",
                dataType: "text",
                data: {nhacungcap: nhacungcap, hopdong: hopdong},
                type: "POST",
                success: function (data) {
                    $("#show").html(data);
                },
                error: function () {
                }
            });
        }
    }
</script>
