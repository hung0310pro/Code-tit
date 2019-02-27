<?php require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET["xem"])) {
    $this->layout('Student/layout2');
    $hocsinh = $_POST["hocsinh"];
    $truong = $_POST["truong"];
    $chuongtrinh = $_POST["chuongtrinh"];
    $trangthai = $_POST["trangthai"];

    $hocsinh = (empty($hocsinh)) ? "0=0" : "T61r5ki_seUcOQ=" . $hocsinh;
    $truong = (empty($truong)) ? "0=0" : "T61r5ki_SeqsGi=" . $truong;
    $chuongtrinh = (empty($chuongtrinh)) ? "0=0" : "T61r5ki_dxaG5j=" . $chuongtrinh;
    $trangthai = (empty($trangthai)) ? "0=0" : "T61r5ki_NTqmcU=" . $trangthai;

    $sql = "select * from t61r5ki where " . $hocsinh . " and " . $truong . " and " . $trangthai . " and " . $chuongtrinh;

    $hoso = select_list($conn, $sql);


    $listhocsinh = select_list($conn, "select * from tgb4tei");

    ?>
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>Hồ sơ</th>
            <th>Tổng số CV</th>
            <th>CV hoàn thiện</th>
            <th>CV Đang thực hiên</th>
            <th>CV yêu cầu xử lí</th>
            <th>CV hủy</th>
            <th>Tổng % hoàn thành</th>
            <th>Trạng thái</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($hoso as $value) {
            $chitiet = select_list($conn, "select * from tlkvhg9 where Tlkvhg9_6NkZWK =" . $value['T61r5ki_id']);
            $tenhocsinh = select_info($conn, "select * from tgb4tei where tgb4tei_id =" . $value['T61r5ki_seUcOQ']); // cái mã khi trỏ chuột vào cái tên của nó thì có số id ở dưới
            // còn cái tgb4tei_id thì phải như thế vì khi trỏ vào cái tên của mã này nó không có cái id ở dưới
            $cvht = select_info($conn, "select count(*) as sl from tlkvhg9 where Tlkvhg9_VEUdAQ = 574 and Tlkvhg9_6NkZWK = " . $value['T61r5ki_id']);
            $cvdth = select_info($conn, "select count(*) as sl2 from tlkvhg9 where Tlkvhg9_VEUdAQ = 573 and Tlkvhg9_6NkZWK = " . $value['T61r5ki_id']);
            $cvycxl = select_info($conn, "select count(*) as sl3 from tlkvhg9 where Tlkvhg9_VEUdAQ = 572 and Tlkvhg9_6NkZWK =  " . $value['T61r5ki_id']);
            $cvhuy = select_info($conn, "select count(*) as sl4 from tlkvhg9 where Tlkvhg9_VEUdAQ = 575 and Tlkvhg9_6NkZWK = " . $value['T61r5ki_id']);

            $tonght = ($cvht["sl"] / (count($chitiet))) * 100;

            $trangthai1 = select_info($conn, "select * from dataman where Id = " . $value["T61r5ki_NTqmcU"]);
            ?>
            <tr>
                <td><?= $tenhocsinh["Tgb4tei_Dr8XU4"]; ?></td>
                <td><?= count($chitiet) ?></td>

                <td><?= $cvht['sl']; ?></td>
                <td><?= $cvdth['sl2']; ?></td>
                <td><?= $cvycxl['sl3']; ?></td>
                <td><?= $cvhuy['sl4']; ?></td>
                <td><?= $tonght; ?>%</td>
                <td><?= $trangthai1['Value']; ?></td> <!--trong bảng dataman-->
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>




    <?php
    exit;
}
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <label for="">Học sinh</label>
                <select name="hocsinh" id="hocsinh" class="form-control chosen-select">
                    <option value="0">---</option>
                    <?php
                    $danhsachhoso = select_list($conn, "select * from tgb4tei");
                    foreach ($danhsachhoso as $value) {
                        ?>
                        <option value="<?= $value["Tgb4tei_id"]; ?>"><?= $value["Tgb4tei_Dr8XU4"]; ?></option>
                        <?php

                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Trường</label>
                <select name="truong" id="truong" class="form-control chosen-select">
                    <option value="0">---</option>
                    <?php
                    $danhsachhoso = select_list($conn, "select * from tdj3ex5");
                    foreach ($danhsachhoso as $value) {
                        ?>
                        <option value="<?= $value["Tdj3ex5_id"]; ?>"><?= $value["Tdj3ex5_EriRyp"]; ?></option>
                        <?php

                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Chương trình</label>
                <select name="chuongtrinh" id="chuongtrinh" class="form-control chosen-select">
                    <option value="0">---</option>
                    <?php
                    $danhsachhoso = select_list($conn, "select * from tpn3b1z");
                    foreach ($danhsachhoso as $value) {
                        ?>
                        <option value="<?= $value["Tpn3b1z_id"]; ?>"><?= $value["Tpn3b1z_kHDasl"]; ?></option>
                        <?php

                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="">Trạng thái</label>
                <select name="trangthai" id="trangthai" class="form-control chosen-select">
                    <option value="0">---</option>
                    <?php
                    $danhsachhoso = select_list($conn, "select * from dataman where  Data_field = 'Tlkvhg9_VEUdAQ' ");
                    foreach ($danhsachhoso as $value) {
                        ?>
                        <option value="<?= $value["Id"]; ?>"><?= $value["Value"]; ?></option>
                        <?php

                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <button class="btn btn-success" style="margin-top:25px;" name="xem" id="xem">Xem</button>
        </div>

    </div>
</div> <!-- /.box-body -->
<div class="box-footer">
    <div id="vebang"></div>
</div><!-- /.box-body -->
</div><!-- /.box -->

<script>
    $("#xem").click(function () {
        var hocsinh = $("#hocsinh").val();
        var truong = $("#truong").val();
        var chuongtrinh = $("#chuongtrinh").val();
        var trangthai = $("#trangthai").val();
        $.ajax({
            url: "?xem",
            dataType: "html",
            data: {hocsinh: hocsinh, truong: truong, chuongtrinh: chuongtrinh, trangthai: trangthai},
            type: "POST",
            success: function (data) {

                $("#vebang").html(data);

            },
            error: function () {
            }
        });

    });
</script>

<?php

?>

