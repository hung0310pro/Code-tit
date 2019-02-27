<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['velai'])) {
    $this->layout('Student/layout2');
    $capdo1 = $_POST['capdo1'];
    $buoi_tl1 = select_list($conn, "select * from tyhguxq where Tyhguxq_WjdFRr = '" . $capdo1 . "' ");
    $mang1 = [];
    $mang2 = [];
    foreach ($buoi_tl1 as $value) {
        $mang1 = select_info($conn, "select * from tyhguxq INNER JOIN ts34phc ON tyhguxq_id = Ts34phc_kglFwn where Ts34phc_kglFwn = " . $value['Tyhguxq_id'] . " ORDER BY Ts34phc_crd DESC");
        $mang2[] = $mang1;
    }


    usort($mang2, function ($a, $b) {
        return $b['Ts34phc_id'] - $a['Ts34phc_id'];
    });

    ?>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="container">
                <div class="col-md-3">
                    <label>Tên tài liệu</label>
                    <input type="text" id="tailieu" name="tailieu" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Link</label>
                    <input type="text" id="link1" name="link1" class="form-control">
                </div>
            </div>
            <div class="container">
                <div class="col-md-3">
                    <label>Đính kèm</label>
                    <input type="FILE" id="dinhkem" name="dinhkem[]" class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Loại tài liệu</label>
                    <select class="form-control chosen-select" id="loaitl" name="loaitl">
                        <option value="0">---</option>
                        <?php
                        $loaitl = select_list($conn, "select * from dataman where Data_field = 'Ts34phc_ajURmc'");
                        foreach ($loaitl as $value) {
                            ?>
                            <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" style="margin-top: 25px;">
                    <button class="btn btn-success" type="submit">Thêm</button>
                </div>
            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>Buổi số</th>
            <th>Loại tài liệu</th>
            <th>Tên Tài Liệu</th>
            <th>Link</th>
            <th>DownLoad</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($mang2 as $value) {
            $a = 0;
            $listbuoi1 = select_list($conn, "select * from ts34phc where Ts34phc_kglFwn = '" . $value['Tyhguxq_id'] . "' ");
            foreach ($listbuoi1 as $val) {
                $code = 'p5ihfe';
                $idds = $val["Ts34phc_id"];
                $module = 'ts34phc';
                $Id = $idds;
                $f = __FILE__;
                $listfile = getlistfile($code, $module, $Id, $f);
                $a++;
                ?>
                <tr>
                    <?php
                    if ($a == 1) {
                        ?>
                        <td rowspan="<?= count($listbuoi1) ?>"><?= $value['Tyhguxq_WZLp6e'] ?></td>
                        <?php
                    }
                    ?>
                    <td><?= $val['Ts34phc_ajURmc'] ?></td>
                    <td><?= $val['Ts34phc_TFgDbz'] ?></td>
                    <td><?= $val['Ts34phc_2tNyBY'] ?></td>
                    <?php
                    foreach ($listfile as $value1) {
                        $ten = explode('=', $value1);
                        ?>
                        <td><a href="/com/download/<?= $val['Ts34phc_id'] ?>/Ts34phc/ts34phc/?file=<?= $ten[1] ?>"
                               target="_blank"><i
                                        class="fa fa-download" aria-hidden="true"></i></a></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <?php
    exit;
}

if (isset($_POST['submitform'])) {
    $this->layout('Student/layout2');


    $data = array(
        "Ts34phc_kglFwn" => $_POST['buoi'],
        "Ts34phc_TFgDbz" => $_POST['tailieu'],
        "Ts34phc_2tNyBY" => $_POST['link1'],
        "Ts34phc_ajURmc" => $_POST['loaitl'],
    );
    insertdb($conn, "ts34phc", $data);
    $idis = lastinsertid($conn);

    $name = "dinhkem";
    $Id = $idis;
    $f = __FILE__;
    uploadfile("p5ihfe", 'Ts34phc', $Id, $name, $f);

    exit;
}

if (isset($_GET['choncd2'])) {
    $this->layout('Student/layout2');
    $capdo = $_POST['capdo'];
    $buoi_tl = select_list($conn, "select * from tyhguxq where Tyhguxq_WjdFRr = " . $capdo);
    ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div class="container">
                <div class="col-md-3">
                    <label>Tên tài liệu</label>
                    <input type="text" id="tailieu" name="tailieu" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Link</label>
                    <input type="text" id="link1" name="link1" class="form-control">
                </div>
            </div>
            <div class="container">
                <div class="col-md-3">
                    <label>Đính kèm</label>
                    <input type="file" id="dinhkem" name="dinhkem[]" class="form-control" multiple>
                </div>

                <div class="col-md-3">
                    <label>Loại tài liệu</label>
                    <select class="form-control chosen-select" id="loaitl" name="loaitl">
                        <option value="0">---</option>
                        <?php
                        $loaitl = select_list($conn, "select * from dataman where Data_field = 'Ts34phc_ajURmc'");
                        foreach ($loaitl as $value) {
                            ?>
                            <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" style="margin-top: 25px;">
                    <button class="btn btn-success" type="submit">Thêm</button>
                </div>
            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>Buổi số</th>
            <th>Loại tài liệu</th>
            <th>Tên Tài Liệu</th>
            <th>Link</th>
            <th>DownLoad</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($buoi_tl as $value) {
            $a = 0;
            $listbuoi = select_list($conn, "select * from ts34phc where Ts34phc_kglFwn = " . $value['Tyhguxq_id']);
            foreach ($listbuoi as $val) {

                $code = 'p5ihfe';
                $idds = $val["Ts34phc_id"];
                $module = 'ts34phc';
                $Id = $idds;
                $f = __FILE__;
                $listfile = getlistfile($code, $module, $Id, $f);
                $a++;
                ?>
                <tr>
                    <?php
                    if ($a == 1) {
                        ?>
                        <td rowspan="<?= count($listbuoi) ?>"><?= $value['Tyhguxq_WZLp6e'] ?></td>
                        <?php
                    }
                    ?>
                    <td><?= $val['Ts34phc_ajURmc'] ?></td>
                    <td><?= $val['Ts34phc_TFgDbz'] ?></td>
                    <td><?= $val['Ts34phc_2tNyBY'] ?></td>
                    <?php
                    foreach ($listfile as $value1) {
                        $ten = explode('=', $value1);
                        ?>
                        <td><a href="/com/download/<?= $val['Ts34phc_id'] ?>/Ts34phc/ts34phc/?file=<?= $ten[1] ?>"
                               target="_blank"><i
                                        class="fa fa-download" aria-hidden="true"></i></a></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <?php
    exit;
}

if (isset($_GET['choncd1'])) {
    $this->layout('Student/layout2');
    $capdo = $_POST['capdo'];
    $cd_buoi = select_list($conn, "select * from tyhguxq where Tyhguxq_WjdFRr = " . $capdo);
    echo json_encode($cd_buoi);
    exit;
}

if (isset($_GET['chonct1'])) {
    $this->layout('Student/layout2');
    $chuongtrinh = $_POST['chuongtrinh'];
    $ct_cd = select_list($conn, "select * from tvhe3u5 where Tvhe3u5_kgHfMq = " . $chuongtrinh);
    echo json_encode($ct_cd);
    exit;
}

?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Giao diện khai báo tài liệu</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <form id="formsm" enctype="multipart/form-data">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Chương trình</label>
                    <select class="form-control chosen-select" id="chuongtrinh" name="chuongtrinh" onchange="chonct()">
                        <option value="0">---</option>
                        <?php
                        $chuongtrinh = select_list($conn, "select * from tnqoxu5");
                        foreach ($chuongtrinh as $value) {
                            ?>
                            <option value="<?= $value['Tnqoxu5_id'] ?>"><?= $value['Tnqoxu5_1MbqVF'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Cấp độ</label>
                    <select class="form-control chosen-select" id="capdo" name="capdo" onchange="choncd()">
                        <option value="0">---</option>
                        <?php
                        $capdo = select_list($conn, "select * from tvhe3u5");
                        foreach ($capdo as $value) {
                            ?>
                            <option value="<?= $value['Tvhe3u5_id'] ?>"><?= $value['Tvhe3u5_FRPB8w'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Buổi</label>
                    <select class="form-control chosen-select" id="buoi" name="buoi">
                        <option value="0">---</option>
                        <?php
                        $sobuoi = select_list($conn, "select * from tyhguxq");
                        foreach ($sobuoi as $value) {
                            ?>
                            <option value="<?= $value['Tyhguxq_id'] ?>"><?= $value['Tyhguxq_WZLp6e'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
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

    function chonct() {
        var chuongtrinh = $("#chuongtrinh").val();
        $.ajax({
            url: "/tigbmtn?chonct1",
            dataType: "json",
            data: {chuongtrinh: chuongtrinh},
            type: "POST",
            success: function (data) {
                $('#capdo').empty();
                $('#capdo').append($('<option>').attr('value', 0).text('---'));
                $.each(data, function (key, value) {
                    $('#capdo').append($("<option></option>")
                        .attr("value", value.Tvhe3u5_id)
                        .text(value.Tvhe3u5_FRPB8w));
                });
                $('#capdo').trigger("chosen:updated");
            },
            error: function () {
            }
        });
    }

    function choncd() {
        var capdo = $("#capdo").val();
        $.ajax({
            url: "/tigbmtn?choncd1",
            dataType: "json",
            data: {capdo: capdo},
            type: "POST",
            success: function (data) {
                $('#buoi').empty();
                $('#buoi').append($('<option>').attr('value', 0).text('---'));
                $.each(data, function (key, value) {
                    $('#buoi').append($("<option></option>")
                        .attr("value", value.Tyhguxq_id)
                        .text(value.Tyhguxq_WZLp6e));
                });
                $('#buoi').trigger("chosen:updated");
            },
            error: function () {
            }
        });

        $.ajax({
            url: "/tigbmtn?choncd2",
            dataType: "text",
            data: {capdo: capdo},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });

    }

    $('#formsm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('submitform', '');
        $.ajax({
            type: 'post',
            url: '/tigbmtn',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                makeSAlertright("Thêm thành công", 5000);
                velai1();
            }
        }); //End Ajax
    }); //End submit

    function velai1() {
        var capdo1 = $("#capdo").val();
        $.ajax({
            url: "/tigbmtn?velai",
            dataType: "text",
            data: {capdo1: capdo1},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }


</script>
