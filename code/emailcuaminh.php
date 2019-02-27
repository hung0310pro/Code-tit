<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

if (isset($_GET['gui'])) {
    $this->layout('Student/layout2');

    $tieude = $_POST['tieude'];
    $noidung = $_POST['noidung'];

    /* $from = [
         "username" => "nguyenvantuanc_t59@hus.edu.vn",
         "password" => "nonevermixxx",
         "sendname" => "Hùng test email",
     ];*/

    $to = "hung0210pro@gmail.com";

    sendmail($from, $to, $tieude, $noidung);
    exit;
}


?>

<div class="box">
    <input type="file" placeholder="chọn tệp">
    <div class="box-header with-border">
        <h3 class="box-title">Gửi Email</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-12 container">
            <div class="col-md-3">
                <label>Tiêu đề</label>
                <input type="text" name="tieude" id="tieude" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Nội dung</label>
                <textarea cols="60" rows="5" name="noidung" id="noidung" class="form-control"></textarea>
            </div>
            <div class="col-md-3" style="margin-left: 200px;margin-top: 50px;">
                <button class="btn btn-success" onclick="guiemail()">Gửi</button>
            </div>
        </div>
    </div> <!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-body -->
</div><!-- /.box -->
<script src="/js/makealert.js" type="text/javascript"></script>
<script>
    function guiemail() {
        var noidung = $("#noidung").val();
        var tieude = $("#tieude").val();
        $.ajax({
            url: "?gui",
            dataType: "json",
            data: {noidung: noidung, tieude: tieude},
            type: "POST",
            success: function (data) {
                    makeSAlertright('Đã thêm!!', 3000);
                    window.setTimeout(function () {
                        location.reload()
                    }, 1000);
            },
            error: function () {
            }
        });
    }
</script>


