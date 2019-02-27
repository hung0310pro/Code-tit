<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
if (isset($_GET['xoa'])) {
    $this->layout('Student/layout2');
    $sohopdong1 = $_POST['shd'];
    $khaibaomucdoad1 = select_list($conn, "select * from t2iyewk where T2iyewk_MY95mk is null or T2iyewk_MY95mk = 0 and T2iyewk_lqXuDe = '" . $sohopdong1 . "' and T2iyewk_id not in (" . implode(',', $_POST['mangid']) . ")");
    ?>
    <div class="col-md-12" id="bangcapdo">
        <h4>Khai báo danh mục cấp độ áp dụng</h4>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>Cấp độ</th>
                <th>Học phí học viên</th>
                <th>Học phí GV(Trực tiếp)</th>
                <th>Học phí GV(online)</th>
                <th>Số điểm tiêu hao/ 1 hs</th>
                <th>action</th>
            </tr>
            </thead>

            <?php

            $i = 0;
            foreach ($khaibaomucdoad1 as $value) {
                $i++;
                ?>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" name="hocphihocvien<?= $i ?>" id="hocphihocvien<?= $i ?>"
                               value="<?= number_format($value['T2iyewk_IE8eZw']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="text" name="hocphigvtt<?= $i ?>" id="hocphigvtt<?= $i ?>"
                               value="<?= number_format($value['T2iyewk_s8ZaJT']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="text" name="hocphigvoln<?= $i ?>" id="hocphigvoln<?= $i ?>"
                               value="<?= number_format($value['T2iyewk_xBu5Ho']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>

                        <input type="number" name="diemtieuhao<?= $i ?>" id="diemtieuhao<?= $i ?>"
                               value="<?= $value['T2iyewk_POY0AI'] ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td><a class="btn btn-danger" id="xoa<?= $value['T2iyewk_id'] ?>"
                           onclick="xoa(<?= $value['T2iyewk_id'] ?>,<?= $_POST['shd'] ?>)">Xóa</a></td>

                </tr>
                <?php
            }
            ?>
            <input type="hidden" name="sodong" id="sodong" value="<?= $i ?>">
        </table>
    </div>
    <script>

        function xoa(idxoa, shd) {
            var xoa = JSON.parse($("#idxoa1").val());
            xoa.push(idxoa);
            $('#idxoa1').val(JSON.stringify(xoa));
            var mangid = JSON.parse($('#idxoa1').val());
            $.ajax({
                url: "?xoa",
                dataType: "html",
                data: {mangid: mangid, shd: shd},
                type: "POST",
                success: function (data) {
                    $('#bangcapdo').html(data);
                },
                error: function () {
                }
            });
        }
    </script>
    <?php
    exit;
}

if (isset($_GET['xoa1'])) {
    $this->layout('Student/layout2');
    $sohopdong1 = $_POST['shd'];
    $khaibaomucdoad1 = select_list($conn, "select * from tqjg3ms where Tjq3fax_yLlpYN is null or Tjq3fax_yLlpYN = 0 and Tjq3fax_yLlpYN = '" . $sohopdong1 . "' and Tqjg3ms_id not in (" . implode(',', $_POST['mangid']) . ")");
    ?>

    <div id="bangcapdo1">
        <h4>Phần khai báo phí chuyên môn</h4>
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang2" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>STT</th>
                <th>Thời kì</th>
                <th>% Mức phí tối thiểu</th>
                <th>Năm</th>
                <th>Từ ngày</th>
                <th>Đến ngày</th>
                <th>Thêm</th>
                <th>Xóa</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <?php
            $i = 0;
            foreach ($mocphicm as $value) {
                $i++;
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td>

                        <input type="text" name="thoiki<?= $i ?>" id="thoiki<?= $i ?>"
                               value="<?= $value['Tjq3fax_sPum7r'] ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>

                    <td>
                        <input type="text" name="muctt<?= $i ?>" id="muctt<?= $i ?>"
                               value="<?= number_format($value['Tjq3fax_zQdeWs']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="text" name="nam<?= $i ?>" id="nam<?= $i ?>" onchange="namcm(<?= $i ?>)"
                               value="1" class="form-control" style="text-align: center;border: none;">
                    </td>

                    <td>
                        <input type="date" name="tungay<?= $i ?>" id="tungay<?= $i ?>" class="tungaycm"
                               value="<?= $value['Tjq3fax_wV8MpK'] ?>" class="form-control"
                               style="text-align: center;border: none;">

                    </td>

                    <td>

                        <input type="date" name="denngay<?= $i ?>" id="denngay<?= $i ?>"
                               class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td><a class="btn btn-primary" id="them"
                           onclick="them(<?= $value['Tjq3fax_id'] ?>,<?= $_POST['sohopdong'] ?>)">Thêm</a></td>
                    <td><a class="btn btn-danger" id="xoa"
                           onclick="xoa1(<?= $value['Tjq3fax_id'] ?>,<?= $_POST['sohopdong'] ?>)">Xóa</a></td>
                </tr>
            <?php } ?>
            </tfoot>
            <input type="hidden" name="sodong1" id="sodong1" value="<?= $i ?>">
        </table>
    </div>
    <script>
        function xoa1(idxoa, shd) {
            var xoa = JSON.parse($("#idxoa2").val());
            xoa.push(idxoa);
            $('#idxoa2').val(JSON.stringify(xoa));
            var mangid = JSON.parse($('#idxoa2').val());
            $.ajax({
                url: "?xoa1",
                dataType: "html",
                data: {mangid: mangid, shd: shd},
                type: "POST",
                success: function (data) {
                    $('#bangcapdo1').html(data);
                },
                error: function () {
                }
            });
        }
    </script>
    <?php
    exit;
}
?>


<?php


if (isset($_POST['submitform'])) {
    $this->layout('Student/layout2');

    $insertdatacu = array(
        "Tl1c3tp_B3tDbA" => 8,
    );
    $wheredata = array(
        "Tl1c3tp_dGNluj" => $_POST['shd'],
    );
    updatedb($conn, "tl1c3tp", array("where" => $wheredata, "data" => $insertdatacu));


    $insertdata = array(
        "Tl1c3tp_dGNluj" => $_POST['shd'],
        "Tl1c3tp_TQD89S" => $_POST['spl'],
        "Tl1c3tp_3IgAT9" => $_POST['tggh'],
        "Tl1c3tp_o1xSrA" => $_POST['pgh'],
        "Tl1c3tp_YANayZ" => $_POST['nbd'],
        "Tl1c3tp_dSUugV" => $_POST['nkt'],
        "Tl1c3tp_B3tDbA" => 7,
        "owner" => $User

    );
    insertdb($conn, "tl1c3tp", $insertdata);
    $lastID = lastinsertid($conn);


    for ($i = 1; $i <= $_POST['sodong']; $i++) {
        $insertdata = array(
            "T2iyewk_lqXuDe" => $_POST['shd'],
            "T2iyewk_MY95mk" => $lastID,
            "T2iyewk_IE8eZw" => $_POST['hocphihocvien' . $i],
            "T2iyewk_s8ZaJT" => $_POST['hocphigvtt' . $i],
            "T2iyewk_xBu5Ho" => $_POST['hocphigvoln' . $i],
            "T2iyewk_POY0AI" => $_POST['diemtieuhao' . $i],
            "owner" => $User

        );
        insertdb($conn, "t2iyewk", $insertdata);
    }

    /*$data = json_decode($_POST['data'], true);
    $data1 = json_decode($_POST['data1'], true);*/

    for ($i = 1; $i <= $_POST['sodong1']; $i++) {
        $insertdata = array(
            "Tjq3fax_XCB2u7" => $_POST['shd'],
            "Tjq3fax_sPum7r" => $_POST['thoiki' . $i],
            "Tjq3fax_yLlpYN" => $lastID,
            "Tjq3fax_zQdeWs" => $_POST['muctt' . $i],
            "Tjq3fax_wV8MpK" => $_POST['tungay' . $i],
            "Tjq3fax_t3TsZu" => $_POST['denngay' . $i],
            "owner" => $User
        );
        insertdb($conn, "tjq3fax", $insertdata);
    }


    for ($i = 1; $i <= $_POST['sodong2']; $i++) {
        $insertdata = array(
            "Tgbvxz7_ZyCWVq" => $_POST['shd'],
            "Tgbvxz7_BgnpAZ" => $lastID,
            "Tgbvxz7_kmHxeT" => $_POST['tu2' . $i],
            "Tgbvxz7_dF8DGE" => $_POST['den2' . $i],
            "Tgbvxz7_ATSPR6" => $_POST['hocphi2' . $i],
            "owner" => $User

        );

        insertdb($conn, "tgbvxz7", $insertdata);
    }


    exit;
}

if (isset($_GET['sohopdong1'])) {
    $this->layout('Student/layout2');
    $sohopdong = $_POST['sohopdong'];
    $mocphicm = select_list($conn, "select * from tjq3fax where Tjq3fax_yLlpYN is null or Tjq3fax_yLlpYN = 0 and Tjq3fax_XCB2u7 = " . $sohopdong);
    $khaibaodmtt = select_list($conn, "select * from tgbvxz7 where Tgbvxz7_BgnpAZ is null or Tgbvxz7_BgnpAZ = 0 and Tgbvxz7_ZyCWVq = " . $sohopdong);
    $khaibaomucdoad = select_list($conn, "select * from t2iyewk where T2iyewk_MY95mk is null or T2iyewk_MY95mk = 0 and T2iyewk_lqXuDe = " . $sohopdong);


    /*   $kbphicm1 = [];
        foreach ($mocphicm as $value) {

        $kbphicm[0] = $value['Tjq3fax_sPum7r'];
        $kbphicm[1] = $value['Tjq3fax_zQdeWs'];
        $kbphicm[2] = $value['Tjq3fax_wV8MpK'];
        $kbphicm[3] = $value['Tjq3fax_t3TsZu'];
        $kbphicm1[] = $kbphicm;

    }*/

    /*   $khaibaodmtt1 = [];
        foreach ($khaibaodmtt as $value) {

        $khaibaodmtt2[0] = $value['Tgbvxz7_kmHxeT'];
        $khaibaodmtt2[1] = $value['Tgbvxz7_dF8DGE'];
        $khaibaodmtt2[2] = $value['Tgbvxz7_ATSPR6'];
        $khaibaodmtt1[] = $khaibaodmtt2;

    }*/


    ?>
    <div>
        <h4>Phần khai báo phí chuyên môn</h4>
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang2" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>STT</th>
                <th>Thời kì</th>
                <th>% Mức phí tối thiểu</th>
                <th>Năm</th>
                <th>Từ ngày</th>
                <th>Đến ngày</th>
                <th>Thêm</th>
                <th>Xóa</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <?php
            $i = 0;
            foreach ($mocphicm as $value) {
                $i++;
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td>

                        <input type="text" name="thoiki<?= $i ?>" id="thoiki<?= $i ?>"
                               value="<?= $value['Tjq3fax_sPum7r'] ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>

                    <td>
                        <input type="text" name="muctt<?= $i ?>" id="muctt<?= $i ?>"
                               value="<?= number_format($value['Tjq3fax_zQdeWs']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="text" name="nam<?= $i ?>" id="nam<?= $i ?>" onchange="namcm(<?= $i ?>)"
                               value="1" class="form-control" style="text-align: center;border: none;">
                    </td>

                    <td>
                        <input type="date" name="tungay<?= $i ?>" id="tungay<?= $i ?>" class="tungaycm"
                               value="<?= $value['Tjq3fax_wV8MpK'] ?>" class="form-control"
                               style="text-align: center;border: none;">

                    </td>

                    <td>

                        <input type="date" name="denngay<?= $i ?>" id="denngay<?= $i ?>"
                               class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td><a class="btn btn-primary" id="them"
                           onclick="them(<?= $value['Tjq3fax_id'] ?>,<?= $_POST['sohopdong'] ?>)">Thêm</a></td>
                    <td><a class="btn btn-danger" id="xoa"
                           onclick="xoa1(<?= $value['Tjq3fax_id'] ?>,<?= $_POST['sohopdong'] ?>)">Xóa</a></td>
                </tr>
            <?php } ?>
            </tfoot>
            <input type="hidden" name="sodong1" id="sodong1" value="<?= $i ?>">
        </table>


    </div>

    <div>
        <h4>Khai báo đạt mốc phí chuyên môn</h4>
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <table id="bang3" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>Từ</th>
                <th>Đến</th>
                <th>% Học phí</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <?php
            $i = 0;
            foreach ($khaibaodmtt as $val) {
                $i++;
                ?>
                <tr>
                    <td>

                        <input type="number" name="tu2<?= $i ?>" id="tu2<?= $i ?>"
                               value="<?= (int)$val['Tgbvxz7_kmHxeT'] ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="number" name="den2<?= $i ?>" id="den2<?= $i ?>"
                               value="<?= (int)$val['Tgbvxz7_dF8DGE'] ?>" class="form-control"
                               style="text-align: center;border: none;">

                    </td>
                    <td>
                        <input type="number" name="hocphi2<?= $i ?>" id="hocphi2<?= $i ?>"
                               value="<?= (int)$val['Tgbvxz7_ATSPR6'] ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                </tr>
            <?php } ?>
            </tfoot>
            <input type="hidden" name="sodong2" id="sodong2" value="<?= $i ?>">
        </table>

        <!-- <script>
        $(function () {
        $('#bang1').DataTable();
        });
        </script>-->
    </div>

    <div class="col-md-12" id="bangcapdo">
        <h4>Khai báo danh mục cấp độ áp dụng</h4>
        <table id="bang1" class="table table-bordered table-striped table-hover text-center">
            <thead>
            <tr>
                <th>Cấp độ</th>
                <th>Học phí học viên</th>
                <th>Học phí GV(Trực tiếp)</th>
                <th>Học phí GV(online)</th>
                <th>Số điểm tiêu hao/ 1 hs</th>
                <th>action</th>
            </tr>
            </thead>

            <?php

            $i = 0;
            foreach ($khaibaomucdoad as $value) {
                $i++;
                ?>
                <tr>
                    <td></td>
                    <td>

                        <input type="text" name="hocphihocvien<?= $i ?>" id="hocphihocvien<?= $i ?>"
                               value="<?= number_format($value['T2iyewk_IE8eZw']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="text" name="hocphigvtt<?= $i ?>" id="hocphigvtt<?= $i ?>"
                               value="<?= number_format($value['T2iyewk_s8ZaJT']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="text" name="hocphigvoln<?= $i ?>" id="hocphigvoln<?= $i ?>"
                               value="<?= number_format($value['T2iyewk_xBu5Ho']) ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td>
                        <input type="number" name="diemtieuhao<?= $i ?>" id="diemtieuhao<?= $i ?>"
                               value="<?= (int)$value['T2iyewk_POY0AI'] ?>" class="form-control"
                               style="text-align: center;border: none;">
                    </td>
                    <td><a class="btn btn-danger" id="xoa"
                           onclick="xoa(<?= $value['T2iyewk_id'] ?>,<?= $_POST['sohopdong'] ?>)">Xóa</a></td>

                </tr>
                <?php
            }
            ?>
            <input type="hidden" name="sodong" id="sodong" value="<?= $i ?>">
        </table>
    </div>

    <?php
    exit;
}
?>

<?php
if (isset($_GET['thoigiangh'])) {
    $nam = $_POST['thoigiangiahan'];
    $ngaybd = $_POST['ngaybd'];
    $nam1 = $nam * 31536000;
    $date1 = strtotime($ngaybd);
    $date2 = abs($date1 + $nam1);
    $date3 = floor($date2 / (60 * 60 * 24));
    $date = strftime("%Y-%m-%d", $date2);
    echo $date;
    exit;
}

if (isset($_GET['sohopdong2'])) {
    $this->layout('Student/layout2');
    $sohopdong1 = $_POST['sohopdong'];
    $ngaykthd = select_info($conn, "select * from te4u9at where Te4u9at_id = " . $sohopdong1)['Te4u9at_JKxYnI'];
    $date = strtotime(date('Y-m-d', strtotime($ngaykthd)) . "+1 day");
    $date = strftime("%Y-%m-%d", $date);
    echo $date; // phải echo ra thì nó ms gán được vào cái data1 ở dưới
    exit;
}

if (isset($_GET['sohopdong3'])) {
    $namcm = $_POST['nam2'];
    $tungay = $_POST['tungay2'];
    $namcm1 = $namcm * 31536000;
    $date1 = strtotime($tungay);
    $date2 = abs($date1 + $namcm1);
    $date3 = floor($date2 / (60 * 60 * 24));
    $date = strftime("%Y-%m-%d", $date2);
    echo json_encode($date);
    exit;
}

if (isset($_GET['namcm1'])) {
    $namcm = $_POST['namcm'];
    $tungay = $_POST['tungay'];
    $namcm1 = $namcm * 31536000;
    $date1 = strtotime($tungay);
    $date2 = abs($date1 + $namcm1);
    $date3 = floor($date2 / (60 * 60 * 24));
    $date = strftime("%Y-%m-%d", $date2);
    echo $date;
    exit;
}

?>


<div class="box box-primary">
    <div class="box-header with-border" style="background: #3c8dbc;">
        <h3 class="box-title" style="color: white;">Form gia hạn hợp đồng</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <form id="frmsubmit">
        <div class="box-body">
            <input type="hidden" id="idxoa1" value="[0]">
            <input type="hidden" id="idxoa2" value="[0]">
            <div class="col-sm-3 input-group-sm">
                <label>Số hợp đồng</label>
                <select class="form-control chosen-select" onchange="sohopdong()" id="shd" name="shd">
                    <option value="0">---</option>
                    <?php
                    $shd = select_list($conn, "select * from te4u9at");
                    foreach ($shd as $val) {
                        ?>
                        <option value="<?= $val['Te4u9at_id'] ?>"><?= $val['Te4u9at_dsypND'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-3 input-group-sm">
                <label>Số phụ lục</label>
                <input type="text" class="form-control" required id="spl" name="spl">
            </div>
            <div class="col-sm-3 input-group-sm">
                <label>Thời gian gia hạn(năm)</label>
                <input type="number" class="form-control" id="tggh" name="tggh" onchange="sonam()">
            </div>
            <div class="col-sm-3 input-group-sm">
                <label>Phí gia hạn</label>
                <input type="text" class="form-control" id="pgh" name="pgh">
            </div>

            <div class="col-sm-3">
                <label>Ngày bắt đầu</label>
                <input type="date" class="form-control" id="nbd" name="nbd">
            </div>
            <div class="col-sm-3">
                <label>Ngày kết thúc</label>
                <input type="date" class="form-control" id="nkt" name="nkt">
            </div>

        </div> <!-- /.box-body -->
        <div class="box-footer">

            <div id="show"></div>
        </div><!-- /.box-body -->

        <div class="box boxbox" id="box1" style="display: none;">
            <div class="box-body" style="background: honeydew">
                <div id="bangcapdo"></div>
            </div> <!-- /.box-body -->
        </div><!-- /.box -->
        <div class="box boxbox" id="box1" style="display: none;">
            <div class="box-body" style="background: honeydew">
                <div id="bangcapdo1"></div>
            </div> <!-- /.box-body -->
        </div>

        <div class="box-footer" style="text-align: center;display: none" id="divxacnhan">
            <button class="btn btn-success" name="xacnhan" id="xacnhan">Xác nhận</button>
        </div><!-- /.box-body -->
    </form>
</div><!-- /.box -->
<script src="/js/makealert.js" type="text/javascript"></script>
<script>
    function sohopdong() {
        $('#divxacnhan').css('display', 'none');
        var sohopdong = $("#shd").val();
        $.ajax({
            url: "?sohopdong1",
            dataType: "text",
            data: {sohopdong: sohopdong},
            type: "POST",
            success: function (data) {

                $('#show').html(data);
                $('#divxacnhan').css('display', 'block');
            },
            error: function () {
            }
        });

        $.ajax({
            url: "?sohopdong2", // chú ý. tính được năm + vs ngày ở ô từ ngày ra ô ngày đến
            // đoạn kia là mình lấy được số dòng của table bt rồi dòng nào tính dòng ấy
            dataType: "text",
            data: {sohopdong: sohopdong},
            type: "POST",
            success: function (data1) {
                $('#nbd').val(data1.trim());
                var a = $("#sodong1").val();

                for (i = 1; i <= a; i++) {
                    tinhdenngay(i);
                }
            },
            error: function () {
            }
        });


    }

    function tinhdenngay(value) {
        //  var j = i;
        var tungay2 = $("#tungay" + value).val();
        var nam2 = $("#nam" + value).val();
        $.ajax({
            url: "?sohopdong3",
            dataType: "json",
            data: {tungay2: tungay2, nam2: nam2},
            type: "POST",
            success: function (data2) {

                $('#denngay' + value).val(data2);
                //  }
            },
            error: function () {
            }
        });
    }

    function namcm(i) {
        var namcm = $("#nam" + i).val();
        var tungay = $("#tungay" + i).val();
        $.ajax({
            url: "?namcm1",
            dataType: "text",
            data: {namcm: namcm, tungay: tungay},
            type: "POST",
            success: function (data) {
                var today1 = moment(data).format('YYYY-MM-DD');
                $("#denngay" + i).val(today1);
            },
            error: function () {
            }
        });

    }


    function sonam() {
        var thoigiangiahan = $("#tggh").val();
        var ngaybd = $("#nbd").val();
        $.ajax({
            url: "?thoigiangh",
            dataType: "text",
            data: {thoigiangiahan: thoigiangiahan, ngaybd: ngaybd},
            type: "POST",
            success: function (data) {
                var today = moment(data).format('YYYY-MM-DD');
                $("#nkt").val(today);
            },
            error: function () {
            }
        });
    }

    function xoa(idxoa, shd) {
        var xoa = JSON.parse($("#idxoa1").val());
        xoa.push(idxoa);
        $('#idxoa1').val(JSON.stringify(xoa));
        var mangid = JSON.parse($('#idxoa1').val());
        $.ajax({
            url: "?xoa",
            dataType: "html",
            data: {mangid: mangid, shd: shd},
            type: "POST",
            success: function (data) {
                $('#bangcapdo').html(data);
            },
            error: function () {
            }
        });
    }



    $('#frmsubmit').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('submitform', '');
        $.ajax({
            type: 'post',
            url: '/tqjg3ms',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                makeSAlertright("Thành công", 3000);
                window.setTimeout(function () {
                    location.reload()
                }, 1000);
            }
        }); //End Ajax
    }); //End submit


</script>

