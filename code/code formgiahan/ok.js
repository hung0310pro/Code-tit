<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

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


    //$data1 = json_decode($_POST['data1'], true);
    $data = json_decode($_POST['data'], true);

    foreach ($data as $val) {
        $val = array_filter($val);
        if (!empty($val)) {
            $tungay = date("Y-m-d", strtotime($val[3]));
            $denngay = date("Y-m-d", strtotime($val[4]));
            $insertdata = array(

                "Tjq3fax_XCB2u7" => $_POST['shd'],
                "Tjq3fax_sPum7r" => $val[0],
                "Tjq3fax_yLlpYN" => $lastID,
                "Tjq3fax_zQdeWs" => $val[1],
                "Tjq3fax_ieZ6Ga" => $val[2],
                "Tjq3fax_wV8MpK" => $tungay,
                "Tjq3fax_t3TsZu" => $denngay,
            );
            insertdb($conn, "tjq3fax", $insertdata);
        }
    }

    $data1 = json_decode($_POST['data1'], true);
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

    $data2 = json_decode($_POST['data2'], true);
    foreach ($data2 as $val1) {
        $val1 = array_filter($val1);
        if (!empty($val1)) {
            $insertdata = array(
                "T2iyewk_lqXuDe" => $_POST['shd'],
                "T2iyewk_RFSv9n" => $val1[0],
                "T2iyewk_MY95mk" => $lastID,
                "T2iyewk_IE8eZw" => $val1[1],
                "T2iyewk_s8ZaJT" => $val1[2],
                "T2iyewk_xBu5Ho" => $val1[3],
                "T2iyewk_POY0AI" => $val1[4],

            );

            insertdb($conn, "t2iyewk", $insertdata);
        }
    }


    exit;
}

if (isset($_GET['sohopdong1'])) {
$this->layout('Student/layout2');


$sohopdong = $_POST['sohopdong'];
$mocphicm = select_list($conn, "select * from tjq3fax where Tjq3fax_yLlpYN is null or Tjq3fax_yLlpYN = 0 and Tjq3fax_XCB2u7 = " . $sohopdong);
$khaibaodmtt = select_list($conn, "select * from tgbvxz7 where Tgbvxz7_BgnpAZ is null or Tgbvxz7_BgnpAZ = 0 and Tgbvxz7_ZyCWVq = " . $sohopdong);
$khaibaomucdoad = select_list($conn, "select * from t2iyewk where T2iyewk_MY95mk is null or T2iyewk_MY95mk = 0 and T2iyewk_lqXuDe = " . $sohopdong);


$kbphicm1 = [];
foreach ($mocphicm as $value) {
    $tungay = date("d-m-Y", strtotime($value['Tjq3fax_wV8MpK']));
    $nam1 = $value['Tjq3fax_ieZ6Ga'] * 31536000;
    $date1 = strtotime($tungay);
    $date2 = abs($date1 + $nam1);
    $date3 = floor($date2 / (60 * 60 * 24));
    $date = strftime("%Y-%m-%d", $date2);
    $date = date("d-m-Y", strtotime($date));
    $kbphicm[0] = $value['Tjq3fax_sPum7r'];
    $kbphicm[1] = number_format($value['Tjq3fax_zQdeWs']);
    $kbphicm[2] = (int)$value['Tjq3fax_ieZ6Ga'];
    $kbphicm[3] = $tungay;
    $kbphicm[4] = $date;
    $kbphicm1[] = $kbphicm;

}

$khaibaodmtt1 = [];
foreach ($khaibaodmtt as $value) {
    $khaibaodmtt2[0] = $value['Tgbvxz7_kmHxeT'];
    $khaibaodmtt2[1] = $value['Tgbvxz7_dF8DGE'];
    $khaibaodmtt2[2] = $value['Tgbvxz7_ATSPR6'];
    $khaibaodmtt1[] = $khaibaodmtt2;

}

$khaibaocapdoap = [];
foreach ($khaibaomucdoad as $value) {
    $khaibaodmtt2[0] = $value['T2iyewk_RFSv9n'];
    $khaibaodmtt2[1] = number_format($value['T2iyewk_IE8eZw']);
    $khaibaodmtt2[2] = number_format($value['T2iyewk_s8ZaJT']);
    $khaibaodmtt2[3] = number_format($value['T2iyewk_xBu5Ho']);
    $khaibaodmtt2[4] = $value['T2iyewk_POY0AI'];
    $khaibaocapdoap[] = $khaibaodmtt2;

}


?>
<div>
    <h4>Phần khai báo phí chuyên môn</h4>
    <div id="hot2"></div>
    <script>
        var container = document.getElementById('hot2');
        var hot2 = new Handsontable(container, {
            minSpareRows: 2,
            colHeaders: true,
            rowHeaders: true,
            manualRowMove: true,
            manualColumnMove: true,
            manualRowResize: true,
            manualColumnResize: true,
//filters: true,
            contextMenu: true,
            allowInsertRow: false,
            sortIndicator: true,
            autoColumnSize: {
                samplingRatio: 23
            },
            stretchH: "all",
            formulas: true,
            colHeaders: [
                "Thời kì", "% Mức tối thiểu", "Năm", "Từ ngày", "Đến ngày"
            ],
            /* hiddenColumns: {
            columns: [14],
            indicators: true
            },*/columns: [
                {type: 'text'},
                {type: 'text'},
                {type: 'text'},
                {type: 'date', dateFormat: 'MM-DD-YYYY',},
                {type: 'date', dateFormat: 'MM-DD-YYYY',},
            ],
        });


        var setter = false;

        hot2.addHook('afterChange', function (changes, src) {
//console.log(changes, src);
            if (!setter && changes != null) {
                setter = true;
                var mydata = hot2.getData();
                changedRowStartingZero = changes[0][0];
                changedRow = changedRowStartingZero;
                var currentRow = changedRow;
//var nhancong = hot2.getDataAtCell(currentRow, 1);
                var nam = hot2.getDataAtCell(currentRow, 2);
                var tungay = hot2.getDataAtCell(currentRow, 3);
                if (tungay != null) {
                    var tungay1 = tungay.slice(6, 10);
                    var tungay2 = tungay.slice(0, 6);
                    var denngay = tungay1 * 1 + nam * 1;
                    mydata[currentRow][4] = tungay2 + denngay;
                    hot2.loadData(mydata);
                }
                else {
                    mydata[currentRow][4] = null;
                    hot2.loadData(mydata);
                }
            } else {
                setter = false;
            }
//hot2.setDataAtCell(currentRow, 4, thanhtien); chú ý
        });
// cách chuẩn hơn ??? nhân vs 1 nghìn??  // tính ngày tháng 1 năm trong handsome
        hot2.loadData(<?= json_encode($kbphicm1) ?>);

            var currentRow = changedRow;
//var nhancong = hot2.getDataAtCell(currentRow, 1);
                var nam = hot2.getDataAtCell(currentRow, 2);
                var tungay = hot2.getDataAtCell(currentRow, 3);
                if (tungay != null) {
                    var a = new Date(tungay);
                    var b = a.getTime();
                    console.log(b);
                    var nam1 = nam*31536000*1000;
                    var denngay = nam1*1 + b*1;
                    var denngay2 = moment(new Date(denngay)).format("MM-DD-YYYY");
                    mydata[currentRow][4] = denngay2;
                    hot2.loadData(mydata);
                }

                else {
                    mydata[currentRow][4] = null;
                    hot2.loadData(mydata);
                }
    </script>


</div>


<div>
    <h4>Khai báo đạt mốc phí chuyên môn</h4>
    <div id="hot3"></div>

    <script>
        var container = document.getElementById('hot3');
        var hot3 = new Handsontable(container, {
            minSpareRows: 2,
            colHeaders: true,
            rowHeaders: true,
            manualRowMove: true,
            manualColumnMove: true,
            manualRowResize: true,
            manualColumnResize: true,
//filters: true,
            contextMenu: true,
            allowInsertRow: false,
            sortIndicator: true,
            autoColumnSize: {
                samplingRatio: 23
            },
            stretchH: "all",
            formulas: true,
            colHeaders: [
                "Từ", "Đến", "% Học phí"
            ],
            /* hiddenColumns: {
            columns: [14],
            indicators: true
            },*/columns: [
                {type: 'numeric'},
                {type: 'numeric'},
                {type: 'numeric'},
            ],
        });

        hot3.loadData(<?= json_encode($khaibaodmtt1) ?>);
    </script>
</div>

<div>
    <h4>Khai báo danh mục cấp độ áp dụng</h4>
    <div>
        <div id="hot4"></div>

        <script>
            var container = document.getElementById('hot4');
            var hot4 = new Handsontable(container, {
                minSpareRows: 2,
                colHeaders: true,
                rowHeaders: true,
                manualRowMove: true,
                manualColumnMove: true,
                manualRowResize: true,
                manualColumnResize: true,
//filters: true,
                contextMenu: true,
                allowInsertRow: false,
                sortIndicator: true,
                autoColumnSize: {
                    samplingRatio: 23
                },
                stretchH: "all",
                formulas: true,
                colHeaders: [
                    "Cấp độ", "Học phí học viên", "Học phí GV(Trực tiếp)", "Học phí GV(online)", "Số điểm tiêu hao/1hs"
                ],
                /* hiddenColumns: {
                columns: [14],
                indicators: true
                },*/columns: [
                    {type: 'numeric'},
                    {type: 'text'},
                    {type: 'text'},
                    {type: 'text'},
                    {type: 'numeric'},
                ],
            });
            hot4.loadData(<?= json_encode($khaibaocapdoap) ?>);

        </script>
    </div>
    <?php
    exit;
    }
    ?>
    <?php
    /* if (isset($_GET['khaibaocm'])) {
         $nam = $_POST['nam'];
         $tungay = $_POST['tungay'];
         $tungay1 = strtotime($tungay);
         $nam1 = $nam * 31536000;
         $date1 = abs($nam1 + $tungay1);
         $date3 = floor($date1 / (60 * 60 * 24));
         $date = strftime("%d-%m-%Y", $date1);
         echo $date;
         exit;

     }*/

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
                    <input type="date" class="form-control" id="nbd" name="nbd" onchange="sonam()">
                </div>
                <div class="col-sm-3">
                    <label>Ngày kết thúc</label>
                    <input type="date" class="form-control" id="nkt" name="nkt">
                </div>

            </div> <!-- /.box-body -->
            <div class="box-footer">

                <script src="/handsontable/dist/handsontable.full.js"></script>
                <link rel="stylesheet" media="screen" href="/handsontable/dist/handsontable.full.css">
                <link rel="stylesheet" media="screen" href="/handsontable/plugins/bootstrap/handsontable.bootstrap.css">
                <script src="/js/makealert.js" type="text/javascript"></script>
                <script src="/handsontable/lib/handsontable-chosen-editor.js"></script>

                <script src="/js/makealert.js" type="text/javascript"></script>
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
                    console.log(new Date());
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

        /*   function xoa(idxoa, shd) {
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
           }*/


        $('#frmsubmit').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var data = JSON.stringify(hot2.getData());
            var data1 = JSON.stringify(hot3.getData());
            var data2 = JSON.stringify(hot4.getData());
            formData.append('submitform', '');
            formData.append('data', data);
            formData.append('data1', data1);
            formData.append('data2', data2);
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
