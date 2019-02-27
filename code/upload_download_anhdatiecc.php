<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

$group = getsystemuser($conn, "tzm9s3f", "Tzm9s3f_xObL2i", $User);

$checkpermission2 = select_info($conn, $sql = 'select * from tdgvye4 join tmvigs5 on Tdgvye4_id = Tmvigs5_L5E3Md where Tmvigs5_VbyYDB = "' . $group['Per'] . '" and Tdgvye4_sQzp3Z = "tigbmtn"');


if ($checkpermission2['Tmvigs5_Imz1RU'] == 65) {
    $chuongtrinh = select_list($conn, "select * from tnqoxu5");
} else {
    if (isset($checkpermission2['Tmvigs5_id'])) {
        $chuongtrinh1 = select_list($conn, "select * from tk2h1ic where Tk2h1ic_lQLJ1E = " . $checkpermission2['Tmvigs5_id']);
        $chuongtrinh = [];
        foreach ($chuongtrinh1 as $value) {
            $chuongtrinh2 = select_info($conn, "select * from tnqoxu5 where Tnqoxu5_id = " . $value['Tk2h1ic_NCW8yY']);
            $chuongtrinh[] = $chuongtrinh2;
        }
    }
}

if (isset($_GET['velai'])) {
    $this->layout('Student/layout2');
    $capdo1 = $_POST['capdo1'];
    $giaoan = $_POST['giaoan'];
    $buoi_tl1 = select_list($conn, "select * from tyhguxq where Tyhguxq_WjdFRr = '" . $capdo1 . "'  and Tyhguxq_TI0EZJ = '" . $giaoan . "'");

    $mang1 = [];
    $mang2 = [];
    foreach ($buoi_tl1 as $value) {
        $mang1 = select_info($conn, "select * from tyhguxq INNER JOIN ts34phc ON tyhguxq_id = Ts34phc_kglFwn where Ts34phc_kglFwn = " . $value['Tyhguxq_id'] . " and Ts34phc_5P1nfw = '" . $giaoan . "' ORDER BY Ts34phc_crd DESC");
        $mang2[] = $mang1;
    }

    usort($mang2, function ($a, $b) {
        return $b['Ts34phc_id'] - $a['Ts34phc_id'];
    });

    ?>
    <style>
        a {
            cursor: pointer;
        }
    </style>
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
            <div class="col-md-3">
                <label>Ghi chú</label>
                <input type="text" id="ghichu" name="ghichu" class="form-control">
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
            <th>Ghi chú</th>
            <th>Link</th>
            <th>DownLoad</th>
            <th>Xóa</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($mang2 as $value) {
            $a = 0;
            $listbuoi1 = select_list($conn, "select * from ts34phc where Ts34phc_kglFwn = '" . $value['Tyhguxq_id'] . "' order by Ts34phc_id DESC");
            foreach ($listbuoi1 as $val) {
                $code = 'p5ihfe';
                $idds = $val["Ts34phc_id"];
                $module = 'ts34phc';
                $Id = $idds;
                $f = __FILE__;
                $listfile = getlistfile($code, $module, $Id, $f);
                $a++;
                $loaitailieu = select_info($conn, "select * from dataman where Data_field = 'Ts34phc_ajURmc' and Id = " . $val['Ts34phc_ajURmc']);
                ?>
                <tr>
                    <?php
                    if ($a == 1) {
                        ?>
                        <td rowspan="<?= count($listbuoi1) ?>"><?= $value['Tyhguxq_WZLp6e'] ?></td>
                        <?php
                    }
                    ?>
                    <td><?= $loaitailieu['Value'] ?></td>
                    <td><?= $val['Ts34phc_TFgDbz'] ?></td>
                    <td><?= $val['Ts34phc_wKX9oD'] ?></td>
                    <td><a target="_blank" href="<?= $val['Ts34phc_2tNyBY'] ?>"><?= $val['Ts34phc_2tNyBY'] ?></a></td>
                    <td>
                        <?php
                        foreach ($listfile as $value1) {
                            $ten = explode('=', $value1);
                            ?>
                            <a href="/com/download/<?= $val['Ts34phc_id'] ?>/Ts34phc/ts34phc/?file=<?= $ten[1] ?>"
                               target="_blank"><i
                                        class="fa fa-download" aria-hidden="true"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                    <td><a class="btn btn-danger" onclick="xoa1(<?= $val['Ts34phc_id'] ?>)">Xóa</a></td>
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
        "Ts34phc_5P1nfw" => $_POST['giaoan'],
        "Ts34phc_wKX9oD" => $_POST['ghichu'],
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
    $giaoan = $_POST['giaoan'];
    $buoi_tl = select_list($conn, "select * from tyhguxq where Tyhguxq_WjdFRr = '" . $capdo . "' and Tyhguxq_TI0EZJ = '" . $giaoan . "'");
    $mang1 = [];
    $mang2 = [];
    foreach ($buoi_tl as $value) {
        $mang1 = select_info($conn, "select * from tyhguxq INNER JOIN ts34phc ON tyhguxq_id = Ts34phc_kglFwn where Ts34phc_kglFwn = " . $value['Tyhguxq_id'] . " and Ts34phc_5P1nfw = '" . $giaoan . "' ORDER BY Ts34phc_crd DESC");
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
                <div class="col-md-3">
                    <label>Ghi chú</label>
                    <input type="text" id="ghichu" name="ghichu" class="form-control">
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
            <th>Ghi chú</th>
            <th>Link</th>
            <th>DownLoad</th>
            <th>Xóa</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($mang2 as $value) {
            $a = 0;
            $listbuoi = select_list($conn, "select * from ts34phc where Ts34phc_kglFwn = '" . $value['Tyhguxq_id'] . "' order by Ts34phc_id DESC");
            foreach ($listbuoi as $val) {

                $code = 'p5ihfe';
                $idds = $val["Ts34phc_id"];
                $module = 'ts34phc';
                $Id = $idds;
                $f = __FILE__;
                $listfile = getlistfile($code, $module, $Id, $f);
                $a++;
                $loaitailieu = select_info($conn, "select * from dataman where Data_field = 'Ts34phc_ajURmc' and Id = " . $val['Ts34phc_ajURmc']);
                ?>
                <tr>
                    <?php
                    if ($a == 1) {
                        ?>
                        <td rowspan="<?= count($listbuoi) ?>"><?= $value['Tyhguxq_WZLp6e'] ?></td>
                        <?php
                    }
                    ?>
                    <td><?= $loaitailieu['Value'] ?></td>
                    <td><?= $val['Ts34phc_TFgDbz'] ?></td>
                    <td><?= $val['Ts34phc_wKX9oD'] ?></td>
                    <td><a target="_blank" href="<?= $val['Ts34phc_2tNyBY'] ?>"><?= $val['Ts34phc_2tNyBY'] ?></a></td>
                    <td>
                        <?php
                        foreach ($listfile as $value1) {
                            $ten = explode('=', $value1);
                            ?>
                            <a href="/com/download/<?= $val['Ts34phc_id'] ?>/Ts34phc/ts34phc/?file=<?= $ten[1] ?>"
                               target="_blank"><i
                                        class="fa fa-download" aria-hidden="true"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                    <td><a class="btn btn-danger" onclick="xoa1(<?= $val['Ts34phc_id'] ?>)">Xóa</a></td>
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

if (isset($_GET['chongiaoan1'])) {
    $this->layout('Student/layout2');
    $capdo = $_POST['capdo'];
    $giaoan = $_POST['giaoan'];
    $buoi = select_list($conn, "select * from tyhguxq where Tyhguxq_WjdFRr = '" . $capdo . "' and Tyhguxq_TI0EZJ = '" . $giaoan . "'");
    echo json_encode($buoi);
    exit;
}

if (isset($_GET['choncd1'])) {
    $this->layout('Student/layout2');
    $capdo = $_POST['capdo'];
    $chuongtrinh = $_POST['chuongtrinh'];

    $cd_buoi = select_list($conn, "select * from te7o3jt where Te7o3jt_IXVqRj = '" . $capdo . "' and Te7o3jt_t125q7 = " . $chuongtrinh);

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
                            <option value="<?= $value['Tvhe3u5_id'] ?>"><?= $value['Tvhe3u5_FRPB8w'] ?>
                                -<?= $value['Tvhe3u5_6RVOGZ'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Giáo án</label>
                    <select class="form-control chosen-select" id="giaoan" name="giaoan" onchange="chongiaoan()">
                        <option value="0">---</option>
                        <?php
                        $sobuoi = select_list($conn, "select * from te7o3jt");
                        foreach ($sobuoi as $value) {
                            ?>
                            <option value="<?= $value['Te7o3jt_id'] ?>"><?= $value['Te7o3jt_ofS89V'] ?></option>
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

    /*function xoa1(id) {
        var idxoa = id;
        var capdo1 = $("#capdo").val();
        var giaoan = $("#giaoan").val();
        var a = false;
        if (confirm("bạn có muốn thật sự xóa không")) {
            a = true;
        } else {
            a = false;
        }
        if (a == true) {
            $.ajax({
                url: "/tigbmtn?xoa",
                dataType: "text",
                data: {idxoa: idxoa, capdo1: capdo1, giaoan: giaoan},
                type: "POST",
                success: function (data) {
                    $("#show").html(data);

                },
                error: function () {
                }
            });
        }

    }*/


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
                        .text(value.Tvhe3u5_FRPB8w + "-" + value.Tvhe3u5_6RVOGZ));
                });
                $('#capdo').trigger("chosen:updated");
            },
            error: function () {
            }
        });
    }

    function chongiaoan() {
        var capdo = $("#capdo").val();
        var chuongtrinh = $("#chuongtrinh").val();
        var giaoan = $("#giaoan").val();
        $.ajax({
            url: "/tigbmtn?chongiaoan1",
            dataType: "json",
            data: {capdo: capdo, chuongtrinh: chuongtrinh, giaoan: giaoan},
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
            data: {capdo: capdo, giaoan: giaoan},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });

    }

    function choncd() {
        var capdo = $("#capdo").val();
        var chuongtrinh = $("#chuongtrinh").val();
        $.ajax({
            url: "/tigbmtn?choncd1",
            dataType: "json",
            data: {capdo: capdo, chuongtrinh: chuongtrinh},
            type: "POST",
            success: function (data) {
                $('#giaoan').empty();
                $('#giaoan').append($('<option>').attr('value', 0).text('---'));
                $.each(data, function (key, value) {
                    $('#giaoan').append($("<option></option>")
                        .attr("value", value.Te7o3jt_id)
                        .text(value.Te7o3jt_ofS89V));
                });
                $('#giaoan').trigger("chosen:updated");
            },
            error: function () {
            }
        });


    }

    $('#formsm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('submitform', '');
        var buoi = $("#buoi").val();
        if (buoi != 0) {
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
        } else {
            makeAlertright("bạn phải chọn số buổi", 5000);
        }
    }); //End submit

    function velai1() {
        var capdo1 = $("#capdo").val();
        var giaoan = $("#giaoan").val();
        $.ajax({
            url: "/tigbmtn?velai",
            dataType: "text",
            data: {capdo1: capdo1, giaoan: giaoan},
            type: "POST",
            success: function (data) {
                $("#show").html(data);
            },
            error: function () {
            }
        });
    }


</script>
