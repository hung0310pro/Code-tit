<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
if (isset($_GET['xoa'])) { // chú ý 9
    $this->layout('Student/layout2');
    $sohopdong1 = $_POST['shd'];
    $khaibaomucdoad1 = select_list($conn, "select * from t2iyewk where T2iyewk_lqXuDe = '" . $sohopdong1 . "' and T2iyewk_id not in (" . implode(',', $_POST['mangid']) . ")");


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
                        <a href="javascript:;" id="T2iyewk_IE8eZw<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_IE8eZw" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"> <?= $value['T2iyewk_IE8eZw'] ?></a>
                        <script>
                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";
                                $("#T2iyewk_IE8eZw<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?php $value['T2iyewk_id'] ?>?fastadd=yes&type=number&fieldname=T2iyewk_IE8eZw",
                                    type: "text",
                                    pk: "T2iyewk_IE8eZw",
                                });
                            });
                        </script>

                        <input type="hidden" name="hocphihocvien<?= $i ?>" id="hocphihocvien<?= $i ?>"
                               value="<?= $value['T2iyewk_IE8eZw'] ?>">
                    </td>
                    <td>
                        <a href="javascript:;" id="T2iyewk_s8ZaJT<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_s8ZaJT" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"><?= $value['T2iyewk_s8ZaJT'] ?></a>
                        <script>

                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";

                                $("#T2iyewk_s8ZaJT<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?=$value['T2iyewk_id']?>?fastadd=yes&type=number&fieldname=T2iyewk_s8ZaJT",
                                    type: "text",
                                    pk: "T2iyewk_s8ZaJT",
                                });
                            });

                        </script>
                        <input type="hidden" name="hocphigvtt<?= $i ?>" id="hocphigvtt<?= $i ?>"
                               value="<?= $value['T2iyewk_s8ZaJT'] ?>">
                    </td>
                    <td>
                        <a href="javascript:;" id="T2iyewk_xBu5Ho<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_xBu5Ho" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"><?= $value['T2iyewk_xBu5Ho'] ?></a>
                        <script>

                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";

                                $("#T2iyewk_xBu5Ho<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?=$value['T2iyewk_id']?>?fastadd=yes&type=number&fieldname=T2iyewk_xBu5Ho",
                                    type: "text",
                                    pk: "T2iyewk_xBu5Ho",
                                });
                            });

                        </script>

                        <input type="hidden" name="hocphigvoln<?= $i ?>" id="hocphigvoln<?= $i ?>"
                               value="<?= $value['T2iyewk_xBu5Ho'] ?>">
                    </td>
                    <td>
                        <a href="javascript:;" id="T2iyewk_POY0AI<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_POY0AI" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"> <?= $value['T2iyewk_POY0AI'] ?></a>
                        <script>

                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";

                                $("#T2iyewk_POY0AI<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?=$value['T2iyewk_id']?>?fastadd=yes&type=number&fieldname=T2iyewk_POY0AI",
                                    type: "text",
                                    pk: "T2iyewk_POY0AI",
                                });
                            });

                        </script>

                        <input type="hidden" name="diemtieuhao<?= $i ?>" id="diemtieuhao<?= $i ?>"
                               value="<?= $value['T2iyewk_POY0AI'] ?>"></td>
                    <td><a class="btn btn-danger" id="xoa<?= $value['T2iyewk_id'] ?>"
                           onclick="xoa(<?= $value['T2iyewk_id'] ?>,<?= $_POST['sohopdong'] ?>)">Xóa</a></td>

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
            var mangid = JSON.parse($('#idxoa1').val()); // đối tượng json 
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
?>
<?php


if (isset($_POST['submitform'])) { // chú ý 5
    $this->layout('Student/layout2');

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $insertdata = array(
        "Tl1c3tp_dGNluj" => $_POST['shd'],
        "Tl1c3tp_TQD89S" => $_POST['spl'],
        "Tl1c3tp_3IgAT9" => $_POST['tggh'],
        "Tl1c3tp_o1xSrA" => $_POST['pgh'],
        "Tl1c3tp_YANayZ" => $_POST['nbd'],
        "Tl1c3tp_dSUugV" => $_POST['nkt']

    );
    insertdb($conn, "tl1c3tp", $insertdata);
    $lastID = lastinsertid($conn); // nhớ lấy cái $lastID lý do xem ở dưới


    for ($i = 1; $i <= $_POST['sodong']; $i++) {  // insert bảng dtable cái i này là đếm số dòng của bảng

        $insertdata = array(
            "T2iyewk_lqXuDe" => $_POST['shd'],
            "T2iyewk_MY95mk" => $lastID,
            "T2iyewk_IE8eZw" => $_POST['hocphihocvien' . $i], // chú ý 7
            "T2iyewk_s8ZaJT" => $_POST['hocphigvtt' . $i],
            "T2iyewk_xBu5Ho" => $_POST['hocphigvoln' . $i],
            "T2iyewk_POY0AI" => $_POST['diemtieuhao' . $i],

        );
        insertdb($conn, "t2iyewk", $insertdata);
    }

    $data = json_decode($_POST['data'], true);
    $data1 = json_decode($_POST['data1'], true);


    foreach ($data as $val) { // insert bảng handsome
        $val = array_filter($val);
        if (!empty($val)) {
            $insertdata = array(
                "Tjq3fax_XCB2u7" => $_POST['shd'],
                "Tjq3fax_sPum7r" => $val[0],
                "Tjq3fax_yLlpYN" => $lastID,
                "Tjq3fax_zQdeWs" => $val[1],
                "Tjq3fax_wV8MpK" => $val[2],
                "Tjq3fax_t3TsZu" => $val[3]
            );
            insertdb($conn, "tjq3fax", $insertdata);
        }
    }

    foreach ($data1 as $val1) {
        $val1 = array_filter($val1);
        if (!empty($val1)) {
            $insertdata = array(
                "Tgbvxz7_ZyCWVq" => $_POST['shd'],
                "Tgbvxz7_BgnpAZ" => $lastID,
                "Tgbvxz7_kmHxeT" => $val1[0],
                "Tgbvxz7_dF8DGE" => $val1[1],
                "Tgbvxz7_ATSPR6" => $val1[2],

            );

            insertdb($conn, "tgbvxz7", $insertdata);
        }
    }


    exit;
}

if (isset($_GET['sohopdong1'])) {  // Chú ý 1
    $this->layout('Student/layout2');
    $sohopdong = $_POST['sohopdong'];
    $mocphicm = select_list($conn, "select * from tjq3fax where Tjq3fax_XCB2u7 = " . $sohopdong);
    $khaibaodmtt = select_list($conn, "select * from tgbvxz7 where Tgbvxz7_ZyCWVq = " . $sohopdong);
    $khaibaomucdoad = select_list($conn, "select * from t2iyewk where T2iyewk_lqXuDe = " . $sohopdong);


    $kbphicm1 = [];
    foreach ($mocphicm as $value) {
        $value = array_filter($value);
        if (!empty($value)) {
            $kbphicm[0] = $value['Tjq3fax_sPum7r'];
            $kbphicm[1] = $value['Tjq3fax_zQdeWs'];
            $kbphicm[2] = $value['Tjq3fax_wV8MpK'];
            $kbphicm[3] = $value['Tjq3fax_t3TsZu'];
            $kbphicm1[] = $kbphicm;
        }
    }

    $khaibaodmtt1 = [];
    foreach ($khaibaodmtt as $value) {
        $value = array_filter($value);
        if (!empty($value)) {
            $khaibaodmtt2[0] = $value['Tgbvxz7_kmHxeT'];
            $khaibaodmtt2[1] = $value['Tgbvxz7_dF8DGE'];
            $khaibaodmtt2[2] = $value['Tgbvxz7_ATSPR6'];
            $khaibaodmtt1[] = $khaibaodmtt2;
        }
    }

    ?>
    <div>
        <h4>Phần khai báo phí chuyên môn</h4>
        <div id="example"></div>
        <script src="/handsontable/dist/handsontable.full.js"></script>
        <link rel="stylesheet" media="screen" href="/handsontable/dist/handsontable.full.css">
        <link rel="stylesheet" media="screen" href="/handsontable/plugins/bootstrap/handsontable.bootstrap.css">
        <script src="/js/makealert.js" type="text/javascript"></script>
        <script src="/handsontable/lib/handsontable-chosen-editor.js"></script>

        <script>
            var container = document.getElementById('example');
            var hot = new Handsontable(container, {
                minSpareRows: 1,
                rowHeaders: true,
                stretchH: "all",
                colHeaders: ["Thời kỳ", "% Mức phí tối thiểu", "Từ ngày", "Đến ngày"],
                contextMenu: true,
                columns: [
                    {type: 'text',},
                    {type: 'numeric', format: '0,0'},
                    {type: 'date',},
                    {type: 'date',},

                ]

            });
            hot.loadData(<?=json_encode($kbphicm1) ?>);
        </script>
    </div>

    <div>
        <h4>Khai báo đạt mốc tt</h4>
        <div id="example3"></div>
        <script>
            var container = document.getElementById('example3');
            var hot1 = new Handsontable(container, {
                minSpareRows: 1,
                rowHeaders: true,
                stretchH: "all",
                colHeaders: ["Từ", "Đến", "% học phí"],
                contextMenu: true,
                columns: [
                    {type: 'numeric', format: '0,0'},
                    {type: 'numeric', format: '0,0'},
                    {type: 'numeric', format: '0,0'},

                ]
            });
            hot1.loadData(<?= json_encode($khaibaodmtt1) ?>);
        </script>
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
                    <td></td> <?php // chú ý 6 ô iput...?>
                    <td>
                        <a href="javascript:;" id="T2iyewk_IE8eZw<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_IE8eZw" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"> <?= $value['T2iyewk_IE8eZw'] ?></a>
                        <script>
                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";
                                $("#T2iyewk_IE8eZw<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?php $value['T2iyewk_id'] ?>?fastadd=yes&type=number&fieldname=T2iyewk_IE8eZw",
                                    type: "text",
                                    pk: "T2iyewk_IE8eZw",
                                });
                            });
                        </script>

                        <input type="hidden" name="hocphihocvien<?= $i ?>" id="hocphihocvien<?= $i ?>"
                               value="<?= $value['T2iyewk_IE8eZw'] ?>">
                    </td>
                    <td>
                        <a href="javascript:;" id="T2iyewk_s8ZaJT<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_s8ZaJT" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"><?= $value['T2iyewk_s8ZaJT'] ?></a>
                        <script>

                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";

                                $("#T2iyewk_s8ZaJT<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?=$value['T2iyewk_id']?>?fastadd=yes&type=number&fieldname=T2iyewk_s8ZaJT",
                                    type: "text",
                                    pk: "T2iyewk_s8ZaJT",
                                });
                            });

                        </script>
                        <input type="hidden" name="hocphigvtt<?= $i ?>" id="hocphigvtt<?= $i ?>"
                               value="<?= $value['T2iyewk_s8ZaJT'] ?>">
                    </td>
                    <td>
                        <a href="javascript:;" id="T2iyewk_xBu5Ho<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_xBu5Ho" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"><?= $value['T2iyewk_xBu5Ho'] ?></a>
                        <script>

                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";

                                $("#T2iyewk_xBu5Ho<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?=$value['T2iyewk_id']?>?fastadd=yes&type=number&fieldname=T2iyewk_xBu5Ho",
                                    type: "text",
                                    pk: "T2iyewk_xBu5Ho",
                                });
                            });

                        </script>

                        <input type="hidden" name="hocphigvoln<?= $i ?>" id="hocphigvoln<?= $i ?>"
                               value="<?= $value['T2iyewk_xBu5Ho'] ?>">
                    </td>
                    <td>
                        <a href="javascript:;" id="T2iyewk_POY0AI<?= $value['T2iyewk_id'] ?>" data-type="text"
                           data-pk="T2iyewk_POY0AI" data-original-title="Sửa dữ liệu"
                           class="editable editable-click"> <?= $value['T2iyewk_POY0AI'] ?></a>
                        <script>
                            $(document).ready(function () {
                                $.fn.editable.defaults.mode = "popup";

                                $("#T2iyewk_POY0AI<?=$value['T2iyewk_id']?>").editable({
                                    url: "/t2iyewk/editsmall/<?=$value['T2iyewk_id']?>?fastadd=yes&type=number&fieldname=T2iyewk_POY0AI",
                                    type: "text",
                                    pk: "T2iyewk_POY0AI",
                                });
                            });

                        </script>

                        <input type="hidden" name="diemtieuhao<?= $i ?>" id="diemtieuhao<?= $i ?>"
                               value="<?= $value['T2iyewk_POY0AI'] ?>"></td>
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
if (isset($_GET['thoigiangh'])) {  // chú ý 3
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

if (isset($_GET['sohopdong2'])) {   // chú ý 2
    $this->layout('Student/layout2');
    $sohopdong1 = $_POST['sohopdong'];
    $ngaykthd = select_info($conn, "select * from te4u9at where Te4u9at_id = " . $sohopdong1)['Te4u9at_JKxYnI'];
    $date = strtotime(date('Y-m-d', strtotime($ngaykthd)) . "+1 day");
    $date = strftime("%Y-%m-%d", $date);
    echo $date; // phải echo ra thì nó ms gán được vào cái data1 ở dưới
    exit;
}

?>

<div class="box box-primary">
    <div class="box-header with-border" style="background: #3c8dbc;">
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <form id="frmsubmit"> <?php // chú ý 4(3 bảng ở trên được trả vào <div id="show"></div> trong from này) ?>
        <div class="box-body"> <?php // chú ý 8 ?>
            <input type="text" id="idxoa1" value="[0]" style="display: none;">
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
                <input type="text" class="form-control" id="spl" name="spl">
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

        <div class="box-footer" style="text-align: center;display: none" id="divxacnhan">
            <button class="btn btn-success" name="xacnhan" id="xacnhan">Xác nhận</button>
        </div><!-- /.box-body -->
    </form>
</div><!-- /.box -->

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
            url: "?sohopdong2",
            dataType: "text",
            data: {sohopdong: sohopdong},
            type: "POST",
            success: function (data1) {
                $('#nbd').val(data1.trim());
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
        var data = JSON.stringify(hot.getData());
        var data1 = JSON.stringify(hot1.getData());
        formData.append('data', data);
        formData.append('data1', data1);
        formData.append('submitform', ''); // if(isset(submitform))
        $.ajax({
            type: 'post',
            url: '/tqjg3ms',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {

                //makeSAlertright("Thành công", 3000);
                //window.setTimeout(function(){location.reload()},1000);
            }
        }); //End Ajax
    }); //End submit


</script>

<?php
// Đầu tiên tạo cái giao diện chọn như trong file Excel Phụ lục HĐ
// Khi chọn hợp đồng thì xuất ra 3 bảng là bảng:
// + Khai báo đạt mốc tt
// + Khai báo phí chuyên môn
// + Khai báo cấp độ áp dụng
// Có những đoạn cần chú ý như sau 
// + Chú ý 1 là lấy hết ra khi chọn hợp đồng{
// xong trả kết quả show về là cái  <div id="show"></div> và thêm $('#show').html(data); trong đoạn js
// tiếp đến nút (Xác nhận) thì viết trong (form gia hạn hợp đồng trong excel) vì mình đã show cái div
// có id là show vào trong form đó thì khi có bảng thì ms có nút (Xác nhận) vậy nên trong đoạn js có
// $('#divxacnhan').css('display', 'block');
// 
// còn nữa khi đưa vào handsometable kia thì phải đưa về dạng chuỗi và cách làm mình cho hết mọi giữ liệu sau khi foreach và 1 mảng mình tạo thêm rồi json_encode($khaibaodmtt1) trong bảng (handsom)
// }
// 
// + chú ý 2
// {
// sau khi chọn số hợp đồng thì mình lại gửi ajax nữa là đoạn sohopdong2 vẫn trong cùng hàm sohopdong() để lấy được cái ngày cuối của Hợp đồng và +1 ngày(mình lấy theo 1 hàm trên mạng); sau đó viết
// $('#nbd').val(data1.trim()); vào cái "ajax sohopdong2" tức là gán giá trị của cái ô ngày bắt đầu
//  = cái mình trả về ở chỗ chú ý 2 (nhớ là phải echo ra)
// }
// 
// + chú ý 3{
// tạo 1 đoạn ajax để nhập vào ô thời gian gia hạn(năm) rồi gửi lên rồi mình cộng bt thôi tương tự như
// ở trên và nhớ echo ra nhé, kèm theo đoạn dưới mình phải đưa về dạng Y-M-D 1 lần nữa(thoigiangh)
// }
// 
// + chú ý 4
// {
// đưa tất cả cái Form gia hạn hợp đồng vào 1 form và tất nhiên 3 cái bảng trả về cx trong đó rồi
// đặt id cho form rồi xem cái "ajax tqjg3ms" để mà hiểu cách lấy giữ liệu của bảng handsome, và các bảng trong form là (#frmsubmit là id của form đó), sau khi gửi lên thì như phần ("chú ý 5")
// cái đoạn $lastid là mình lấy cái id truyền vào bảng gốc của nó hay ns cách khác vs bảng tl1c3tp thì cái $lastid là số id chính khóa chính(dữ liệu ngắn) rồi truyền vào các bảng liên quan có cái ô id của bảng tl1c3tp là trường liên kết chức năng ấy
// + Ngoài ra cái đoạn for($i=1)... thì nó đếm dòng thôi ở đoạn chú ý 6   <input type="hidden" name="sodong" id="sodong" value=" $i" tiếp đến có mấy ô input ý xong mình cho name các kiểu ấy kiểu mình đưa form lên bt thôi(vs cái name,id của ô input mình cho cái value cx bằng cái value ở thẻ td ấy xong khi gửi ajax submitform)(cái này làm nhiều rồi mà) rồi lên đoạn chú ý 7 nhé,mấy cái $_POST['hocphihocvien' . $i] là name ô input và thứ tự của dòng ấy.
// }
// chú ý 8
// {
// Còn cái xóa này thì nó xóa chỉ trong đó thôi chứ kp xóa trong database nhớ thêm ô <input type="text" id="idxoa1" value="[0]" style="display: none;"> đoạn ajax có thể hiểu là khi ấn xóa cái nào thì mình cần phải truyền id dòng đó là 1, và id số hợp đồng đó (xem chú ý 9) rồi nó sẽ thêm cái id dòng xóa vào chỗ value ở cái ô input đó rồi mình gửi lên và vẽ lại 1 lần nữa ở trên cùng
// + Nhớ là phải đặt id cho thẻ div quanh bảng đó rồi trả nó về 1 cái div 
// <div class="box boxbox" id="box1" style="display: none;">
            <div class="box-body" style="background: honeydew">
                <div id="bangcapdo"></div>
            </div> <!-- /.box-body -->
        </div><!-- trong form ấy (kiểu nhét cái bảng mới vào đây thôi) và k quên thêm 
         $('#bangcapdo').html(data); vào đoạn ajax
// }


+ lớn hơn là 1
+ xóa đi là 2
+ bắt điền đã thanh toán là 3