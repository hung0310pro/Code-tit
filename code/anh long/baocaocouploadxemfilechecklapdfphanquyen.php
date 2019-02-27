<?php
// muốn mà upload mà nó hiển thị luôn ở model thì mình cần viết lại lần 2 của cái đoạn upload
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
if (isset($_GET["xem"])) {
    $this->layout('Student/layout2');
    $idloaitailieu = $_GET["loaitailieu"];

    $danhsachtailieu = select_list($conn, "select * from t38uhwe where T38uhwe_UCh8Kb = " . $idloaitailieu);
    $loaitailieu2 = select_info($conn, "select * from dataman where Id = " . $idloaitailieu);
    ?>
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <div class="col-md-9">
        <table id="bang2" class="table table-bordered table-striped table-hover text-center" style="margin-top: 7px;">
            <thead>
            <tr>
                <th>Danh sách tài liệu loại <?= $loaitailieu2["Value"] ?></th>
            </tr>
            </thead>
            <?php
            foreach ($danhsachtailieu as $val) {
                ?>
                <tr>
                    <td><a onclick="hienthi(<?= $val['T38uhwe_id'] ?>)"
                           href="javascript:void(0)"><?= $val["T38uhwe_dzbiNW"] ?></a></td>
                </tr>
            <?php } ?>

        </table>
    </div>
    <script>
        $(function () {
            $('#bang2').DataTable();
        });
    </script>
    <?php
    exit;
}
if (isset($_GET['idfile_cv11'])) :  // lần 2
$this->layout('Student/layout2');
    $code = '71m4k5';
    $idds = $_POST["idfile_cv"];
    $module = 'T38uhwe';
    $Id = $idds;
    $f = __FILE__;
    $listanh = getlistfile($code, $module, $Id, $f);

    foreach ($listanh as $val) { ?>
        <div class="container">
            <div class="col-md-1"><i class="fa fa-folder-open-o" aria-hidden="true"></i></div>
            <?php
            $ten = explode('=', $val);
            ?>
            <div class="col-md-7"><?= $ten[1] ?></div>

            <div class="col-md-3">
                <a style="position:relative;left: -13px;display: <?= (substr($ten[1], -3) == 'PDF' || substr($ten[1], -3) == 'pdf') ? '' : "none;" ?>"
                   target="_blank" class="btn"
                   href="/pdfview.php?fileurl=/com/download/<?php echo $Id; ?>/T38uhwe/t38uhwe/?file=<?php echo $ten[1]; ?>"
                   data-toggle="modal">
                    <span title="Xem nhanh" class="fa fa-eye" aria-hidden="true"></span></a>
                <a href="/com/download/<?= $Id ?>/T38uhwe/t38uhwe/?file=<?= $ten[1] ?>"><i class="fa fa-download"
                                                                                           aria-hidden="true"></i></a>
            </div>
        </div>
        <?php
    }

    ?>
    <div>

        <h4>Upload file</h4>
        <form id="form_upload_file" enctype="multipart/form-data">
            <input type="hidden" name="id_upload_filecv" id="id_upload_filecv" value="<?= $Id ?>">
            <div class="form-group">
                <label class="control-label col-sm-2" style="margin-top: 10px;">Tải tệp lên</label>
                <div class="col-sm-4">
                    <input type="file" id="upload_filecv" multiple="multiple" name="upload_filecv[]"
                           style="float:left; margin-top: 10px;">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success btn-sm" style="margin-top: 5px;" type="button" onclick="upload1()">
                        Tải lên
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function upload1() {
            var formData = new FormData($('#form_upload_file')[0]);
            $.ajax({
                type: 'post',
                url: '?taifile',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        makeSAlertright("Upload thành công !", 5000);
                        $.ajax({
                            url: "?idfile_cv11",
                            dataType: "html",
                            data: {idfile_cv: <?= $Id ?>},
                            type: "post",
                            success: function (data) {
                               /* window.setTimeout(function () {
                                    location.reload()
                                }, 1000);*/
                               $("#nhapthongtin").html(data);

                            },
                            error: function () {
                            }
                        });
                    }

                }
            }); //End Ajax
        }
    </script>
</div>
<?php
exit;
endif; // hết lần 2
if (isset($_GET['hienthi'])) { // lần 1
    $this->layout('Student/layout2');
    $code = '71m4k5';
    $idds = $_POST["iddanhsach"];
    $module = 'T38uhwe';
    $Id = $idds;
    $f = __FILE__;
    $listanh = getlistfile($code, $module, $Id, $f); // hôm nào pr thử cái $listanh
    foreach ($listanh as $val) { ?>
        <div class="container">
            <div class="col-md-1"><i class="fa fa-folder-open-o" aria-hidden="true"></i></div>
            <?php
            $ten = explode('=', $val); // $ten[1] là tên file ví dụ Book1.xlsx, hoặc b3.docx
            //Ngu Phap TOEIC hay.pdf,substr($ten[1], -3) là lấy đc đoạn pdf
            ?>
            <div class="col-md-7"><?= $ten[1] ?></div>

            <div class="col-md-3">
                <a style="position:relative;left: -13px;display: <?= (substr($ten[1], -3) == 'PDF' || substr($ten[1], -3) == 'pdf') ? '' : "none;" ?>"
                   target="_blank" class="btn"
                   href="/pdfview.php?fileurl=/com/download/<?php echo $Id; ?>/T38uhwe/t38uhwe/?file=<?php echo $ten[1]; ?>"
                   data-toggle="modal"> // phần download

                    <span title="Xem nhanh" class="fa fa-eye" aria-hidden="true"></span></a>
                <a href="/com/download/<?= $Id ?>/T38uhwe/t38uhwe/?file=<?= $ten[1] ?>"><i class="fa fa-download"
                                                                                           aria-hidden="true"></i></a>
            </div>
        </div>
        <?php
    }
    $infouser = select_info($conn,"select * from user where Id = ".$User);
    if($infouser['Per'] == "admin" ){ // nếu là admin ms hiện ra upload
    ?>

    <div>

        <h4>Upload file</h4>
        <form id="form_upload_file" enctype="multipart/form-data">
            <input type="hidden" name="id_upload_filecv" id="id_upload_filecv" value="<?= $Id ?>">
            <div class="form-group">
                <label class="control-label col-sm-2" style="margin-top: 10px;">Tải tệp lên</label>
                <div class="col-sm-4">
                    <input type="file" id="upload_filecv" multiple="multiple" name="upload_filecv[]"
                           style="float:left; margin-top: 10px;">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success btn-sm" style="margin-top: 5px;" type="button" onclick="upload1()">
                        Tải lên
                    </button>
                </div>
            </div>
        </form>
    </div>
        <?php } ?>
    <script>
        function upload1() {
            var formData = new FormData($('#form_upload_file')[0]);
            $.ajax({
                type: 'post',
                url: '?taifile',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        makeSAlertright("Upload thành công !", 5000);
                        $.ajax({  //???
                            url: "?idfile_cv11",
                            dataType: "html",
                            data: {idfile_cv: <?= $Id ?>},
                            type: "post",
                            success: function (data) {
                               /* window.setTimeout(function () {
                                    location.reload()
                                }, 1000);*/
                               $("#nhapthongtin").html(data);

                            },
                            error: function () {
                            }
                        });
                    }

                }
            }); //End Ajax
        }
    </script>
    <?php
    exit;
}
if (isset($_GET['taifile'])) {
    $this->layout('Student/layout2');
    $idhs = $_POST['id_upload_filecv'];
    $code = '71m4k5';
    $module = 'T38uhwe';
    $Id = $idhs;
    $f = __FILE__;
    $name = 'upload_filecv';
    uploadfile($code, $module, $Id, $name, $f);
    echo json_encode(1);
    exit;
}
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Giao diện xem và upload tài liệu</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js"></script>
        <div class="col-md-3">
            <table id="bang1" class="table table-bordered table-striped table-hover text-center">
<thead>  <tr>
                    <th>Loại tài liệu</th>
                </tr>
</thead>
<tbody>
                <?php
                $loaitailieu = select_list($conn, "select * from dataman where Data_field = 'T38uhwe_UCh8Kb'");
                foreach ($loaitailieu as $value) {
                    ?>
                    <tr>
                        <td><a onclick="xem(<?= $value['Id'] ?>)" id="loaitailieu"
                               name="loaitailieu" style="cursor: pointer;"><?= $value["Value"] ?></a></td>
                    </tr>
                    <?php
                }
                ?>
</tbody>
            </table>
        </div>

        <script>
            $(function () {
                //$('#bang1').DataTable();
            });
        </script>
        <div id="vebang"></div>
    </div> <!-- /.box-body -->
    <div class="box-footer">

    </div><!-- /.box-body -->
</div><!-- /.box -->

<div id="modalthongtin" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">File tài liệu</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="nhapthongtin">

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script src="/js/makealert.js" type="text/javascript"></script>

<script>
    function xem(id) {
        var loaitailieu = id;
        $.ajax({
            url: "?xem",
            dataType: "text",
            data: {loaitailieu: loaitailieu},
            type: "GET",
            success: function (data) {
                $("#vebang").html(data);
            },
            error: function () {
            }
        });

    }

    function hienthi(iddanhsach) {
        $.ajax({
            url: "?hienthi",
            dataType: "text",
            data: {iddanhsach: iddanhsach},
            type: "POST",
            success: function (data) {
                $('#nhapthongtin').html(data);
                $('#modalthongtin').modal();
            },
            error: function () {
            }
        });


    }
</script>






