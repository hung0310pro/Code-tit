<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['checkbaocao1'])) {
    $this->layout('Student/layout2');
    $tungay = $_POST['tuthang1'];
    $denngay = $_POST['denthang1'];
    $linhvuc = $_POST['linhvuc'];

    if ($linhvuc == 0) {
        $linhvucdaotao = select_list($conn, 'select * from tkjziqm');
    } else {
        $linhvucdaotao = select_list($conn, 'select * from tkjziqm where Tkjziqm_id = ' . $linhvuc);
    }
    ?>
    <script type="text/javascript" src="datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="datatables/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="datatables/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="datatables/jszip.min.js"></script>
    <script type="text/javascript" src="datatables/pdfmake.min.js"></script>
    <script type="text/javascript" src="datatables/vfs_fonts.js"></script>
    <script type="text/javascript" src="datatables/buttons.print.min.js"></script>
    <script type="text/javascript" src="datatables/buttons.html5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="datatables/buttons.bootstrap.min.css">
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>STT</th>
            <th>Trung Tâm</th>
            <th>Phiếu Thu</th>
            <th>Người Đóng</th>
            <th>Số Tiền</th>
        </tr>
        </thead>
        <?php
        $stt = 0;
        foreach ($linhvucdaotao as $value) {
            $stt++;
            $phieuthu = select_info($conn, $sql = 'select sum(T8xrg7p_pJZWRD) as tongtien from t8xrg7p where T8xrg7p_If5g2h between "' . $tungay . '" and "' . $denngay . '" and T8xrg7p_tTebdp = ' . $value['Tkjziqm_id']);
            $phieuthu1 = select_info($conn, $sql = 'select * from t8xrg7p where T8xrg7p_If5g2h between "' . $tungay . '" and "' . $denngay . '" and T8xrg7p_tTebdp = ' . $value['Tkjziqm_id']);
            ?>
            <tr>
                <td><?= $stt ?></td>
                <td><?= $value['Tkjziqm_b4etsm'] ?></td>
                <td><?= $phieuthu1['T8xrg7p_ZIVt7W'] ?></td>
                <td><?= $phieuthu1['T8xrg7p_0cryoL'] ?></td>
                <td><?= number_format($phieuthu['tongtien']) ?></td>
            </tr>

            <?php
        }
        ?>

    </table>

    <script>
        $(function () {
            $('#bang1').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'pdf', 'print', {
                    extend: 'excel',
                    text: 'Export To Excel'
                }]
            });
        });
    </script>
    <?php
    exit;
}

/*$arrmau = ['EE0000', 'BB0000', 'FFFF99', 'FFCC66', '99CC33', '66CCCC', 'FF99FF', '009900', '00CCFF', 'FFCCFF', '3333FF', '66CCCC', '339966', 'FFFF33', 'BB0000', '880000', '009900', '660000', '663300', '9933CC', 'FF3366', '666633', 'EE0000', 'BB0000', 'FFFF99', 'FFCC66', '99CC33', '66CCCC', 'FF99FF', '009900', '00CCFF', 'FFCCFF', '3333FF', '66CCCC', '339966', 'FFFF33', 'BB0000', '880000', '009900', '660000', '663300', '9933CC', 'FF3366', '666633', 'EE0000', 'BB0000', 'FFFF99', 'FFCC66', '99CC33', '66CCCC', 'FF99FF', '009900', '00CCFF', 'FFCCFF', '3333FF', '66CCCC', '339966', 'FFFF33', 'BB0000', '880000', '009900', '660000', '663300', '9933CC', 'FF3366', '666633'];*/
if (isset($_GET['checkbaocao'])) {
    $this->layout('Student/layout2');
    $tungay = $_POST['tuthang1'];
    $denngay = $_POST['denthang1'];
    $linhvuc = $_POST['linhvuc'];
    
    if ($linhvuc == 0) {
        $linhvucdaotao = select_list($conn, 'select * from tkjziqm');
    } else {
        $linhvucdaotao = select_list($conn, 'select * from tkjziqm where Tkjziqm_id = ' . $linhvuc);
    }

    ?>
    <!-- Styles -->
    <style>
        #chartdiv {
            text-align: center !important;
            width: 50%;
            height: 500px;
        }

        .amcharts-export-menu-top-right {
            top: 10px;
            right: 0;
        }
    </style>

    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <!-- Chart code -->
    <script>
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "marginRight": 70,
            "dataProvider": [
                <?php
                $i = 0;
                foreach ($linhvucdaotao as $val){
                $phieuthu = select_info($conn, $sql = 'select sum(T8xrg7p_pJZWRD) as tongtien from t8xrg7p where T8xrg7p_If5g2h between "' . $tungay . '" and "' . $denngay . '" and T8xrg7p_tTebdp = ' . $val['Tkjziqm_id']);
                ?>
                {
                    "country": "<?= $val['Tkjziqm_b4etsm'] ?>",
                    "visits": "<?= $phieuthu['tongtien'] ?>",
                    "color": "#EE0000"
                },
                <?php
                $i++;
                }
                ?>
            ],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "visits"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "country",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
            },
            "export": {
                "enabled": true
            }

        });
    </script>

    <!-- HTML -->
    <div style="text-align: center;margin: auto;">
        <div id="chartdiv"></div>
    </div>
    <?php
    exit;
}

?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Báo cáo doanh thu theo lĩnh vực</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <label>Từ Tháng</label>
                <input type="date" id="tuthang" name="tuthang" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Đến Tháng</label>
                <input type="date" id="denthang" name="denthang" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Lĩnh vực</label>
                <select class="form-control chosen-select" id="linhvuc" name="linhvuc">
                    <option>---</option>
                    <option value="0">Tất Cả</option>
                    <?php
                    $linhvuc = select_list($conn, 'select * from tkjziqm');
                    foreach ($linhvuc as $value) {
                        ?>
                        <option value="<?= $value['Tkjziqm_id'] ?>"><?= $value['Tkjziqm_b4etsm'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3" style="margin-top: 20px;">
                <button class="btn btn-success" onclick="checkbaocao()">Xem báo cáo</button>
            </div>
        </div>

    </div> <!-- /.box-body -->
    <div class="box-footer">
        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css"
              media="all"/>
        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
        <div id="vebang"></div>
        <div id="show"></div>
    </div><!-- /.box-body -->
</div><!-- /.box -->


<script>

    function checkbaocao() {
        var tuthang1 = $("#tuthang").val();
        var denthang1 = $("#denthang").val();
        var linhvuc = $("#linhvuc").val();
        $.ajax({
            url: "/tr16pw2?checkbaocao",
            dataType: "text",
            data: {tuthang1: tuthang1, denthang1: denthang1, linhvuc: linhvuc},
            type: "POST",
            success: function (data) {
                $("#vebang").html(data);
            },
            error: function () {
            }
        });
        checkbaocao2();
    }

    function checkbaocao2() {
        var tuthang1 = $("#tuthang").val();
        var denthang1 = $("#denthang").val();
        var linhvuc = $("#linhvuc").val();
        $.ajax({
            url: "/tr16pw2?checkbaocao1",
            dataType: "text",
            data: {tuthang1: tuthang1, denthang1: denthang1, linhvuc: linhvuc},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }


</script>

