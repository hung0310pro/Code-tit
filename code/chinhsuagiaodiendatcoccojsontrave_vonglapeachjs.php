<?php
// code iecc, giao diện đặt cọc của đạt
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
if (isset($_GET['username'])) {
    $this->layout('Student/layout2');
    $taikhoan = select_list($conn, "select * from tzm9s3f left join thfx14p on Thfx14p_QBWPxt = Tzm9s3f_S7bo8C where Tzm9s3f_xObL2i = '" . $_POST['username'] . "'"); // chú ý
    echo json_encode($taikhoan);
    exit;
}

if (isset($_GET['username1'])) {
    $this->layout('Student/layout2');

    $khachhang = select_list($conn, "select * from tzm9s3f left join tdksv3f on Tdksv3f_RgrZ3X = Tzm9s3f_S7bo8C left join tr6ya7c on Tr6ya7c_kdJM4F = Tdksv3f_id where Tzm9s3f_xObL2i = '" . $_POST['username'] . "'");

    echo json_encode($khachhang);
    exit;
}


if (isset($_GET['username2'])) {
    $this->layout('Student/layout2');
    /* echo "<pre>";
     print_r($_POST);
     echo "</pre>";*/

    $hocsinh = select_list($conn, "select * from tr6ya7c where Tr6ya7c_kdJM4F = " . $_POST["khachhang"]);
    echo json_encode($hocsinh);
    exit;
}

if (isset($_GET['themmoi'])) {
    $array = json_decode($_GET['iddata'], true);
    foreach ($array as $val) {
        $tenkhachhang = select_info($conn, "select Tdksv3f_mwXc5K from tdksv3f WHERE Tdksv3f_id = '" . $val['Tr6ya7c_kdJM4F'] . "'")['Tdksv3f_mwXc5K'];

        $dataphieuthu = array(
            "T3yhgxb_Ax15Pd" => $val['T3yhgxb_Ax15Pd'],
            "T3yhgxb_5rtlhd" => $tenkhachhang,
            "T3yhgxb_KnOerS" => rmcomma($val['sotien']),
            "T3yhgxb_Q8HjzT" => $datetoday,
            "owner" => $User,
        );
        if (insertdb($conn, "t3yhgxb", $dataphieuthu)) {
            $idphieuthu = $conn->lastInsertId();

            $datadatcoc = array(
                "T3ntx7z_4A7n6i" => $val['Tr6ya7c_kdJM4F'],
                "T3ntx7z_8XEhOD" => $datetoday,
                "T3ntx7z_zUbBux" => rmcomma($val['sotien']),
                "T3ntx7z_X52sAE" => $idphieuthu,
                "T3ntx7z_svQlem" => $val['tenhs'],
                /*"Thlxe9r_G8DS9Q" => $tenkhachhang . "-" . rmcomma($val['sotien']),*/
                "owner" => $User,
            );
            insertdb($conn, "t3ntx7z", $datadatcoc);
            $iddc = lastinsertid($conn);
        }

        /*$datahocsinh = array(
        "Tyj7o9k_Tn14gX" => $val['tenhs'],
        "Tyj7o9k_lLUB7c" => $val['ngaysinh'],
        "Tyj7o9k_CIxaNf" => $khachhang,
        "owner" => $User,
        );
        insertdb($conn, "tyj7o9k", $datahocsinh);
        $idhs = $conn->lastInsertId();*/
        $idhs = $val['tenhs'];

        /*  $datacho = array(
              "T4i7wcj_4tWasG" => $idhs,
              "T4i7wcj_XfDJOV" => $val['Tjxzrka_HFkZI3'],
              "owner" => $User,
          );
          insertdb($conn, "t4i7wcj", $datacho);*/

        $datcoc = select_info($conn, 'select * from  t3ntx7z left join tdksv3f on T3ntx7z_4A7n6i = Tdksv3f_id left join t3yhgxb on T3yhgxb_id = T3ntx7z_X52sAE WHERE T3ntx7z_id = ' . $iddc);
        $ngaythu = $datcoc['T3ntx7z_8XEhOD'];
        $nguoinoptien = $datcoc['Tdksv3f_mwXc5K'];
        $lydothu = $datcoc['T3ntx7z_uGgB8P'];
        $diachi = $datcoc['Tdksv3f_S5tH7K'];
        $sdt = $datcoc['Tdksv3f_IiwHZp'];
        $email = $datcoc['Tdksv3f_ZDbSqd'];
        $sotien = $datcoc['T3ntx7z_zUbBux'];
        $sophieuthu = $datcoc['T3yhgxb_UoCQEK'];
        ?>
        <div style="width: 800px;margin: auto; height: 150px">
            <div style="text-align: right;width: 500px;float: left;">
                <h1 style="margin-right: 10px;"><b style="padding-right: 20px;">PHIẾU ĐẶT CỌC</b></h1>
                <p style="padding-right: 50px">Liên 1: (Lưu nội bộ)</p>
                <p style="text-align:right;padding-right: 20px">Ng&agrave;y <?= date('d', strtotime($ngaythu)) ?>
                    Th&aacute;ng <?= date('m', strtotime($ngaythu)) ?> Năm <?= date('Y', strtotime($ngaythu)) ?></p>
            </div>
            <div style="width: 100px;float: left;margin-top: 20px">Quyển số: <br>Số:<?= $sophieuthu ?></div>
            <div style="width: 200px;float: left;margin-top: 20px">
                Mẫu số: 01 - TT (Ban hành theo
                thông tư số 200/2014/TT-BTC
                ngày 22/12/2014
                của BTC
            </div>
        </div>
        <table align="center" border="0" cellpadding="1" cellspacing="1" style="width:800px">
            <tbody>
            <tr>
                <td>
                    <p>Họ v&agrave; t&ecirc;n người nộp tiền: </p>
                </td>
                <td>
                    <p>Số điện thoại: <?= $sdt ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Địa chỉ: <?= $diachi ?></p>
                </td>
                <td>
                    <p>Email: <?= $email ?></p>
                </td>
            </tr>
            </tbody>
        </table>

        <table align="center" border="0" cellpadding="1" cellspacing="1" style="width:800px">
            <tbody>
            <tr>
                <td>
                    <p>L&yacute; do thu:<?= $lydothu ?> </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Số tiền: <?= number_format($sotien) ?> </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Bằng chữ: <em><?= "(" . number2word($sotien) . ")"; ?></em></p>
                </td>
            </tr>
            </tbody>
        </table>

        <p>&nbsp;</p>

        <table align="center" border="0" cellpadding="1" cellspacing="1" style="width:800px">
            <tbody>
            <tr>
                <td>
                    <p style="text-align:center"><strong>Thủ trưởng</strong></p>

                    <p style="text-align:center"><strong>(đơn vị)</strong></p>
                </td>
                <td>
                    <p style="text-align:center"><strong>Người thu</strong></p>
                </td>
                <td style="text-align:center">
                    <p><strong>Kế to&aacute;n</strong></p>
                </td>
                <td style="text-align:center">
                    <p><strong>Thủ quỹ</strong></p>
                </td>
                <td style="text-align:center">
                    <p><strong>Người nộp tiền</strong></p>
                </td>
            </tr>
            </tbody>
        </table>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <script>
            window.print();
        </script>

        <?php
    }
    exit;

}
if (isset($_GET['layhs'])):
    $this->layout('Student/layout2');
    $tt = select_list($conn, 'select * from tr6ya7c');
    echo json_encode($tt);
    exit;
endif;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">ĐẶT CỌC</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <div>
            <form action="" method="get" id="formthem">
                <!--<?php //selectbox5($conn, 'T8xrg7p_cLXlIZ', null, 3);
                ?>
				<?php //selectbox5($conn, 'Tyj7o9k_CIxaNf', null, 3);
                ?>
                <div class="col-lg-3">
                    <label>Số tiền</label>
                    <input type="text" class="form-control" name="sotien" id="sotien" value="" required>
				</div>-->
                <?php

                $selectuser = select_info($conn, "select * from user where ID = " . $User);

                $cdata = array(
                    array(
                        'name' => 'T3yhgxb_Ax15Pd',
                        'code' => 'T3yhgxb_Ax15Pd',
                        'id' => 'T3yhgxb_Ax15Pd',
                        'show' => 'Tài khoản',
                        'type' => 'chose',
                        'wid' => 3,
                        'option' => '',
                        'reset' => 'no',
                        'require' => 'yes',
                    ),
                    array(
                        'name' => 'Tr6ya7c_kdJM4F',
                        'code' => 'Tr6ya7c_kdJM4F',
                        'id' => 'Tr6ya7c_kdJM4F',
                        'show' => 'Khách hàng',
                        'type' => 'chose',
                        'wid' => 3,
                        'option' => 'onchange="chonkhachhang()"',
                        'reset' => 'no',
                        'require' => 'yes',
                    ),
                    array(
                        'name' => 'sotien',
                        'id' => 'sotien',
                        'show' => 'Số tiền',
                        'type' => 'text',
                        'wid' => 3,
                        'option' => 'onkeyup="roundsotien()"',
                        'reset' => 'yes',
                        'require' => 'yes',
                    ),

                    array(
                        'type' => 'chose',
                        'show' => 'Học sinh',
                        'code' => 'T29seuo_ifJRAD',
                        'id' => 'tenhs',
                        'wid' => 3,
                        'option' => '',
                        'mt' => 3,
                        'reset' => 'no',
                        'require' => 'no',
                        'quickadd' => 3,
                    ),
                    array(
                        'name' => 'ngaysinh',
                        'id' => 'ngaysinh',
                        'show' => 'Ngày cọc',
                        'type' => 'date',
                        'wid' => 3,
                        'option' => '',
                        'reset' => 'yes',
                        'require' => 'yes',
                    ),
                    array(
                        'name' => 'Tjxzrka_HFkZI3',
                        'code' => 'Tjxzrka_HFkZI3',
                        'id' => 'Tjxzrka_HFkZI3',
                        'show' => 'Khoá học',
                        'type' => 'chose',
                        'wid' => 3,
                        'option' => '',
                        'reset' => 'yes',
                        'require' => 'yes',
                    ),

                );
                $onadd = '$(function(){
					$("#btntinhngaykt").show();
					});';
                drawformandlist($conn, $cdata, 'iddata', 'idsua', 'idbtadd', 'fname', $onadd);
                ?>
                <div class="col-lg-12" style="margin-top: 10px">
                    <input type="hidden" value="<?= $selectuser['Per'] ?>" name="username" id="username">
                    <button id="themmoi" name="themmoi" class="btn btn-primary" type="submit"><i
                                class="fa fa-dropbox"></i> Thêm mới
                    </button>
                </div>
            </form>
        </div>
    </div> <!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
    function roundsotien() {
        var sotien = rmcomma($('#sotien').val());
        $('#sotien').val(addcomma(sotien));
    }

    $(function () { // chú ý
        var username = $("#username").val(); // code khi vào trang thì nó sẽ lấy
        // tài khoản, khách hàng theo trung tâm(trung tâm nào dựa vào user của trung tâm ấy)
        // sau đó chọn khách hàng nào thì mình sẽ có học sinh của khách hàng ấy(dùng onchange trong cái của khách hàng) // có cái đoạn echo jsondecode đấy, rồi trả về là nhiều chuỗi thì phải
        // $.each ra rồi append vào 
        // $('#T3yhgxb_Ax15Pd').empty();
              //  $('#T3yhgxb_Ax15Pd').append($('<option>').attr('value', 0).text('---'));
              //  2 dòng trên là gán cho nó cái giá trị là rỗng và --- lúc ban đầu chưa làm gì
        $.ajax({
            url: "?username",
            dataType: "json",
            data: {username: username},
            type: "POST",
            success: function (data) {
                $('#T3yhgxb_Ax15Pd').empty();
                $('#T3yhgxb_Ax15Pd').append($('<option>').attr('value', 0).text('---'));
                // gán cho nó cái giá trị text là --- và value = 0.
                $.each(data, function (key, val) {

                    $('#T3yhgxb_Ax15Pd').append($('<option>').attr('value', val.Thfx14p_id).text(val.Thfx14p_3FjZJz));
                });
                $('#T3yhgxb_Ax15Pd').trigger("chosen:updated");
            },
            error: function () {
            }
        });


        $.ajax({
            url: "?username1",
            dataType: "json",
            data: {username: username},
            type: "POST",
            success: function (data) {
                $('#Tr6ya7c_kdJM4F').empty();
                $('#tenhs').empty();
                $('#Tr6ya7c_kdJM4F').append($('<option>').attr('value', 0).text('---'));
                 $('#tenhs').append($('<option>').attr('value',0).text('---'));
                $.each(data, function (key, val) {

                    $('#Tr6ya7c_kdJM4F').append($('<option>').attr('value', val.Tdksv3f_id).text(val.Tdksv3f_mwXc5K));
                });
                $('#Tr6ya7c_kdJM4F').trigger("chosen:updated");
                $('#tenhs').trigger("chosen:updated");
            },
            error: function () {
            }
        });

    });

    function chonkhachhang() {
        var khachhang = $("#Tr6ya7c_kdJM4F").val();
        //console.log(khachhang);
        $.ajax({
            url: "?username2",
            dataType: "json",
            data: {khachhang: khachhang},
            type: "POST",
            success: function (data) {
                // var hocsinh = $("#tenhs").val();

                $.each(data, function (key, val) {
                    $('#tenhs').append($('<option>').attr('value', val.Tr6ya7c_id).text(val.Tr6ya7c_1kVUmO));
                });
                $('#tenhs').trigger("chosen:updated");
            },
            error: function () {
            }
        });
    }
</script>

