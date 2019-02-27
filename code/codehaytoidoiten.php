<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
function layttid($conn, $module, $id, $field)
{
    if ($id != '') {
        $sql = 'select * from ' . $module . ' where ' . $module . '_id = ' . $id;
        $info = select_info($conn, $sql);
        return $info[$field];
    } else {
        return '';
    }
}

if (isset($_GET['check22'])) {
    $this->layout('Student/layout2');
    $mahocsinh2 = $_POST['mahocsinh2'];
    $lop = $_POST['lop'];
    if ($mahocsinh2 != '' && $lop != '') {
        $data = select_list($conn, "select * from tyzh5in where Tyzh5in_yBpzNV = '$mahocsinh2' and Tyzh5in_CBpWtZ = '$lop'");
        echo json_encode($data);
    }


} else if (isset($_GET['mastcl'])) {
    $this->layout('Student/layout2');
    $luachon = $_POST['luachon'];
    $mahs = $_POST['mahs'];
    $sttt = rmcomma($_POST['sttt']);
    $hsinh = select_info($conn, "select * from tyj7o9k where Tyj7o9k_id=" . $mahs);
    if ($luachon == 1) {
        $conlai = $hsinh['Tyj7o9k_6nhA4w'] - $sttt;
        echo number_format($conlai);
    } else {
        echo number_format($hsinh['Tyj7o9k_6nhA4w']);
    }
    if (isset($_GET['radio'])) {
        $this->layout('Student/layout2');
        $rmahs = $_POST['rmahs'];
        if ($rmahs == "") {
            exit;
        } else {
            $rluachon = $_POST['rluachon'];
            $rthanhtoan = rmcomma($_POST['rthanhtoan']);
            $rhsinh = select_info($conn, "select * from tyj7o9k where Tyj7o9k_id=" . $rmahs);
            if ($rluachon == 1) {
                $rconlai = $rhsinh['Tyj7o9k_6nhA4w'] - $rthanhtoan;
                echo number_format($rconlai);
            } else {
                echo number_format($rhsinh['Tyj7o9k_6nhA4w']);
            }
            exit;
        }
    }

} else if (isset($_GET['mahs'])) {
    $this->layout('Student/layout2');
    $mahs = $_POST['mahs'];
    $hsinh = select_info($conn, "select * from tyj7o9k where Tyj7o9k_id=" . $mahs);
    echo number_format($hsinh['Tyj7o9k_6nhA4w']);

} else if (isset($_GET['submit'])) {
    $this->layout('Student/layout2');
    $databang = json_decode($_POST['databang'], true);
    $mangkhoanthu = array();
    $mangin = [];

    foreach ($databang as $row) {
        $sql = 'select * from tjxzrka where Tjxzrka_id = "' . $row['lop'] . '"';
        $infolop = select_info($conn, $sql);
        $updataa = array(
            "Tyj7o9k_6nhA4w" => rmcomma($row['sotienconlai'])
        );
        $whereupdate = array(
            "Tyj7o9k_id" => $row['mahocsinh']
        );
        updatedb($conn, "tyj7o9k", array("where" => $whereupdate, "data" => $updataa));

        $insert = array(
            "Tyzh5in_yBpzNV" => $row['mahocsinh'],
            "Tyzh5in_CBpWtZ" => $row['lop'],
            "Tyzh5in_Lerjhk" => 60,
            "Tyzh5in_ynvhmD" => $row['noidung'],
            "Tyzh5in_4EsZXf" => rmcomma($row['tongphaithanhtoan']) < 0 ? 0 : rmcomma($row['tongphaithanhtoan']),
            "Tyzh5in_bjuEV8" => rmcomma($row['thanhtoan']),
            "Tyzh5in_kh7xNP" => rmcomma($row['conlai']),
            "owner" => $User
        );
        insertdb($conn, 'tyzh5in', $insert);
        $idhstl = lastinsertid($conn);


        $phiphaidong = array(
            "Tz63xsn_MjCD4g" => $idhstl,
            "Tz63xsn_EIDYSf" => empty($infolop['Tjxzrka_siRo6k']) ? "Học phí: " . $_POST['noidung'] : 'Học phí: Lớp ' . $infolop['Tjxzrka_siRo6k'] . ' + ' . $_POST['noidung'],
            "Tz63xsn_w356lZ" => rmcomma($row['hocphimoibuoi']),
            "Tz63xsn_ahgNFS" => rmcomma($row['sobuoi']),
            "Tz63xsn_mUwNcK" => rmcomma($row['giamtrutienmat']),
            "Tz63xsn_sjRV4o" => 0,
            "Tz63xsn_BEJvIz" => rmcomma($row['tonghocphi']) < 0 ? 0 : rmcomma($row['tonghocphi']),
            "Tz63xsn_Qk5mv7" => $row['handong'],
            "owner" => $User
        );
        insertdb($conn, 'tz63xsn', $phiphaidong);

        $cackhoanthukhac = explode(';', $row['khoanthukhac']);
        foreach ($cackhoanthukhac as $rowcktk) {
            if ($rowcktk != ' ') {
                $khoanthukhac = explode('-', $rowcktk);
                $khoanthuKhac = array(
                    "Tz63xsn_MjCD4g" => $idhstl,
                    "Tz63xsn_EIDYSf" => $khoanthukhac[0],
                    "Tz63xsn_w356lZ" => $khoanthukhac[1],
                    "Tz63xsn_ahgNFS" => $khoanthukhac[2],
                    "Tz63xsn_mUwNcK" => $khoanthukhac[3],
                    "Tz63xsn_sjRV4o" => $khoanthukhac[4],
                    "Tz63xsn_FRtpAe" => $khoanthukhac[5],
                    "Tz63xsn_BEJvIz" => $khoanthukhac[5],
                    "owner" => $User
                );
                $mangkhoanthu[] = $khoanthuKhac;
            }
        }

        // trừ tiền đặt cọc
        $sotiendatcoc2 = rmcomma($row['sotiendatcoc']);

        if ($sotiendatcoc2 > 0) {
            $datcoc = select_list($conn, "select * from thlxe9r inner join t8xrg7p on t8xrg7p_id = Thlxe9r_tPaeHo where Thlxe9r_2cSJWq = " . $row['mahocsinh'] . " and Thlxe9r_DOi2tp = " . $infolop['Tjxzrka_HFkZI3']);

            foreach ($datcoc as $value123):
                $insertdata = array(
                    "Thlxe9r_v06mbi" => $value123['Thlxe9r_rExZcd']
                );
                $wheredata = array(
                    "Thlxe9r_id" => $value123['Thlxe9r_id']
                );

                updatedb($conn, "thlxe9r", array("where" => $wheredata, "data" => $insertdata));
            endforeach;
        }
        $idhss = ($row['mahocsinh'] == '') ? 0 : $row['mahocsinh'];
        $tenhocsinhh = select_info($conn, "select * from tyj7o9k where Tyj7o9k_id = " . $idhss)['Tyj7o9k_Tn14gX'];
        $phieuthu = array(
            "T8xrg7p_cLXlIZ" => $row['taikhoan'],
            "T8xrg7p_pJZWRD" => rmcomma($row['thanhtoan']),
            "T8xrg7p_If5g2h" => $datetoday,
            "T8xrg7p_KgThCX" => empty($infolop['Tjxzrka_siRo6k']) ? "Học phí: " . $_POST['noidung'] : 'Học phí: Lớp ' . $infolop['Tjxzrka_siRo6k'] . ' + ' . $_POST['noidung'],
            "T8xrg7p_0cryoL" => $tenhocsinhh,
        );
        insertdb($conn, 't8xrg7p', $phieuthu);
        $lastPT = lastinsertid($conn);
        $mangin[] = $lastPT;
        $thuhocPhi = array(
            "T9jinw6_vMgiOy" => $idhstl,
            "T9jinw6_PkID8d" => $lastPT,
            "T9jinw6_5iZmTH" => empty($infolop['Tjxzrka_siRo6k']) ? "Học phí: " . $_POST['noidung'] : 'Học phí: Lớp ' . $infolop['Tjxzrka_siRo6k'] . ' + ' . $_POST['noidung'],
            "T9jinw6_Kq71OR" => $datetoday,
            "T9jinw6_o0Qx3N" => rmcomma($row['thanhtoan']),
            "T9jinw6_AjaczC" => $row['handong'],
        );
        insertdb($conn, 't9jinw6', $thuhocPhi);
    }

    foreach ($mangkhoanthu as $rowkhoanthu) {
        if ($rowkhoanthu) {
            insertdb($conn, "tz63xsn", $rowkhoanthu);
        }
    }


    echo implode(',', $mangin);

} else if (isset($_GET['layttlop'])) {
    $this->layout('Student/layout2');
    $data = array();
    $mahocsinh = $_POST['mahocsinh'] == null ? 0 : $_POST['mahocsinh'];
    $lop = $_POST["mahocsinh"];

    if ($lop == 0 || $lop == '' || $lop == null || $mahocsinh == null || $mahocsinh == 0 || $mahocsinh == '') {
        $data = array(
            'Tjxzrka_HFkZI3' => '',
            'Tjxzrka_nKldo4' => 0,
            'Tjxzrka_lyEj7Z' => 0,
            "sotiendatcoc" => 0,
        );
    } else {
        $listlh = select_info($conn, 'select * from tjxzrka where Tjxzrka_id = ' . $_POST['lop']);
        $hpcl = ($listlh['Tjxzrka_lyEj7Z'] / $listlh['Tjxzrka_nKldo4']) * $listlh['Tjxzrka_UAu36P'];

        $sotiendatcoc = select_info($conn, $sql = "select sum(Thlxe9r_rExZcd) from thlxe9r inner join t8xrg7p on t8xrg7p_id = Thlxe9r_tPaeHo where Thlxe9r_2cSJWq = " . $mahocsinh . " and Thlxe9r_DOi2tp = " . $listlh['Tjxzrka_HFkZI3'])['sum(Thlxe9r_rExZcd)'];

        $data = array(
            'Tjxzrka_HFkZI3' => layttid($conn, 'tbxn8g3', $listlh['Tjxzrka_HFkZI3'], 'Tbxn8g3_hd7g3Q'),
            'Tjxzrka_nKldo4' => $listlh['Tjxzrka_nKldo4'],
            'Tjxzrka_lyEj7Z' => $listlh['Tjxzrka_lyEj7Z'],
            "sotiendatcoc" => $sotiendatcoc == null ? 0 : $sotiendatcoc,
        );
    }

    echo json_encode($data);
} else {
    ?>
    <script src="/js/makealert.js" type="text/javascript"></script>
    <script src="/handsontable/dist/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="/handsontable/dist/handsontable.full.css">
    <link rel="stylesheet" media="screen" href="/handsontable/plugins/bootstrap/handsontable.bootstrap.css">
    <script src="/js/makealert.js" type="text/javascript"></script>
    <script src="/handsontable/lib/handsontable-chosen-editor.js"></script>
    <!--dang ki hoc-->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Đăng ký học</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">


            <div class="col-lg-3">
                <?php //???
                selectpwa($conn, 'T1ij9ke_eA0nK7', 'Tài khoản'); ?> 

            </div>
            <div class="col-lg-3">
                <?php
                $option = 'onchange="kiemtra22
                ()"';
                selectpwa($conn, 'Tyzh5in_yBpzNV', 'Thêm mới học sinh', $option);
                ?>
                <script>

                    <?php
                    if (isset($_GET['id'])) {
                    ?>

                    $('#Tyzh5in_yBpzNV').val(<?= $_GET['id'] ?>).trigger('chosen:updated');

                    <?php
                    } else if (isset($_GET['id2'])) {
                    ?>

                    $('#Tyzh5in_yBpzNV').val(<?= $_GET['id2'] ?>).trigger('chosen:updated');

                    <?php
                    }
                    ?>

                </script>
            </div>
            <div class="col-lg-3">
                <?php
                $sql = "select * from tjxzrka";
                $query = select_list($conn, $sql);
                ?>
                <label>Lớp </label> <a href="http://dev.faceworks.vn:8833/tz6glvo" class="fa fa-plus"> </a>
                <select name="lop" id="lop" class="form-control chosen-select" onchange="kiemtra22()">
                    <option value="0">---</option>
                    <?php foreach ($query as $val) { ?>
                        <option value="<?= $val['Tjxzrka_id'] ?>"><?= $val['Tjxzrka_siRo6k'] ?></option>
                    <?php } ?>
                </select>
                <?php

                ?>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <lable>Khóa học</lable>
                    <input type="text" name="txtKhoaHoc" id="txtKhoaHoc" readonly class="form-control">
                </div>
            </div>


            <?php
            $notshow = array(
                'Tjxzrka_HFkZI3' => 1,
                'Tjxzrka_siRo6k' => 2,
                'Tjxzrka_BKZ24z' => 2,
                'Tjxzrka_RGElDT' => 2,
                'Tjxzrka_liMTtb' => 2,
                'Tjxzrka_X05PfA' => 2,
                'Tjxzrka_ayPXq4' => 2,
                'Tjxzrka_pduk2a' => 2,
                'Tjxzrka_UAu36P' => 2,
                'Tjxzrka_3TeKEx' => 2,
                'Tjxzrka_9nyQkz' => 2,
            );
            $option = array(

                "Tjxzrka_lyEj7Z" => 'onkeyup="tinhhocphi()"',
                "Tjxzrka_nKldo4" => 'onkeyup="tinhhocphi()"',
            );
            drawform($conn, 'tjxzrka', $option, 3, $notshow); ?>
            <div class="col-lg-3">
                <div class="form-group">

                    <label>Giảm trừ(TM)</label>
                    <input type="text" name="giamtru" onkeyup="tinhhocphi(); addcomma1(this)" class="form-control"
                           id="giamtru">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Giảm trừ(%)</label>
                    <input type="text" name="giamtrupt" onkeyup="tinhhocphi(); addcomma1(this)" class="form-control"
                           id="giamtrupt">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Tổng khoản phí khác</label>
                    <input type="text" name="tongphikhac" onkeyup="tinhhocphi()" class="form-control"
                           id="tongphikhac" readonly="">
                    <input type="hidden" value="" name="tongphikhac2" id="tongphikhac2">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Tổng học phí</label>
                    <input type="text" name="tonghocphi" class="form-control" id="tonghocphi" readonly="">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Số tiền đặt cọc</label>
                    <input type="text" name="sotiendatcoc" class="form-control" id="sotiendatcoc"
                           readonly>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Tổng phải thanh toán</label>
                    <input type="text" name="tongphaithanhtoan" class="form-control" id="tongphaithanhtoan"
                           readonly>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Thanh toán</label>
                    <input type="text" name="thanhtoan" onkeyup="sotienconlai();addcomma1(this)" class="form-control"
                           id="thanhtoan" value="0">
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">

                    <label>Còn lại</label>
                    <input type="text" name="conlai" class="form-control" id="conlai" readonly>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">

                    <label>Hạn đóng</label>
                    <input type="date" name="handong" class="form-control" id="handong">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="noidung" class="form-control inputcontent1 normal" id="noidung"></textarea>
                </div>
            </div>

        </div> <!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <script>
        $('.col-sm-3').css('height', '85px');
        $('.col-lg-3').css('height', '85px');

        function kiemtra22() {
            var mahocsinh2 = $('#Tyzh5in_yBpzNV').val();
            var lop = $('#lop').val();
            if (mahocsinh2 != '' && lop != '') {
                $.ajax({
                    url: "t1obv9d?check22",
                    dataType: "json",
                    data: {mahocsinh2: mahocsinh2, lop: lop},
                    type: "POST",
                    success: function (data) {
                        sotienkhadung();
                        if (data.length > 0) {
                            makeAlertright("Học sinh này đã có trong lớp bạn đã chọn", 5000);

                        } else {
                            layttlop();
                        }
                    },
                    error: function () {
                    }
                });
            }
        }

        function layttlop() {
            var lop = $('#lop').val();
            var mahocsinh = $("#Tyzh5in_yBpzNV").val();
            $.ajax({
                url: 't1obv9d?layttlop',
                type: 'post',
                data: {'lop': lop, 'mahocsinh': mahocsinh},
                dataType: 'json',
                success: function (data) {
                    $('#txtKhoaHoc').val(data.Tjxzrka_HFkZI3);
                    if (data.Tjxzrka_nKldo4 != 0 || data.Tjxzrka_nKldo4 != '') {
                        $('#Tjxzrka_nKldo4').val(addcomma(data.Tjxzrka_nKldo4 * 1));
                    } else {
                        $('#Tjxzrka_nKldo4').val(0);
                    }
                    if (data.Tjxzrka_lyEj7Z != 0 || data.Tjxzrka_lyEj7Z != '') {
                        $('#Tjxzrka_lyEj7Z').val(addcomma(data.Tjxzrka_lyEj7Z * 1));
                    } else {
                        $('#Tjxzrka_lyEj7Z').val(0);
                    }

                    if (data.sotiendatcoc == 0) {
                        $('#sotiendatcoc').val(0);
                    } else {
                        $('#sotiendatcoc').val(addcomma(Math.round(data.sotiendatcoc)));
                    }

                    tinhhocphi();
                }
            });
        }

        function sotienkhadung() {
            var mahs = $('#Tyzh5in_yBpzNV').val();
            $.ajax({
                url: "?mahs",
                dataType: "text",
                data: {mahs: mahs},
                type: "POST",
                success: function (data) {
                    $("#stkhadung").val(data);
                }
            });
            return false;
        }

        function tinhhocphi() { // chú ý đoạn này có chỗ cộng từ bảng handson vào 1 ô
            // tùy chọn bất kì
            var sb = $('#Tjxzrka_nKldo4').val() * 1;
            var hp = rmcomma($('#Tjxzrka_lyEj7Z').val()) * 1;
            var gttm = rmcomma($('#giamtru').val()) * 1;
            var gtpt = rmcomma($('#giamtrupt').val()) * 1;
            var pk = rmcomma($('#tongphikhac').val()) * 1;
            var coc = rmcomma($('#sotiendatcoc').val()) * 1;
            var tong = (sb * hp) * (1 - gtpt / 100) - gttm + pk;
            var tong1 = (sb * hp) * (1 - gtpt / 100) - gttm;
            var tongptt = tong - coc;
            $('#tonghocphi').val(addcomma(Math.round(tong1)));
            $('#tongphaithanhtoan').val(addcomma(Math.round(tongptt)));
        }


        // function tinhtoan() {
        //     var b = document.getElementById("Tjxzrka_nKldo4").value;
        //     var c = null;
        //     if (b != null && b != '')
        //         c = b.replace(/,/g, "");
        //     else
        //         c = null;
        //     console.log(c);
        //     var a = c.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     document.getElementById("Tjxzrka_nKldo4").value = a;
        //     var sobuoi = $('#Tjxzrka_nKldo4').val().replace(/,/g, "");
        //     var tien1buoi = $('#Tjxzrka_lyEj7Z').val().replace(/,/g, "");
        //     var giamtru = $('#giamtru').val().replace(/,/g, "");
        //     var giamtrupt = $('#giamtrupt').val().replace(/,/g, "");
        //     var thanhtoan = $('#thanhtoan').val().replace(/,/g, "");

        //     if ($('#sotiendatcoc').val() == '' || $('#sotiendatcoc').val() == '0' || $('#sotiendatcoc').val() == 0) {
        //         var sotiendatcoc = 0;
        //     } else {
        //         var sotiendatcoc = parseInt(rmcomma($('#sotiendatcoc').val()));
        //     }
        //     var phaidong = sobuoi * tien1buoi - giamtru * 1 - (giamtrupt * (sobuoi * tien1buoi) / 100) - sotiendatcoc;

        //     var conlai = phaidong - thanhtoan;
        //     $('#giamtru').val(addcomma(giamtru));
        //     $('#thanhtoan').val(addcomma(thanhtoan));
        //     $('#tongphaithanhtoan').val(addcomma(phaidong));
        //     $('#conlai').val(addcomma(conlai));
        //     sotienconlai();

        // }

        /*function sotienconlai() {
         var mahs = $('#Tyzh5in_yBpzNV').val();
         var thanhtoan = $('#thanhtoan').val();
         var luachon = $('input:radio[name=luachon]:checked').val();
         $.ajax({
         url: "?mastcl",
         dataType: "text",
         data: {mahs: mahs, sttt: thanhtoan, luachon: luachon},
         type: "POST",
         success: function (data) {
         $("#stconlai").val(data);
         }
         });
         return false;
         }*/

        function sotienconlai() {
            var thanhtoan = rmcomma($('#thanhtoan').val());
            var stkhadung = rmcomma($('#stkhadung').val());
            var tongphaithanhtoan = rmcomma($('#tongphaithanhtoan').val());
            var conlai = 0;
            var conlai2 = 0;
            if (thanhtoan == '') {
                thanhtoan = 0;
            }
            conlai = stkhadung - thanhtoan;
            if (conlai == 0) {
                conlai = 0;
            } else {
                conlai = addcomma(conlai);
            }
            $('#stconlai').val(conlai);

            conlai2 = tongphaithanhtoan - thanhtoan;
            if (conlai2 == 0) {
                conlai2 = 0;
            } else {
                conlai2 = addcomma(conlai2);
            }
            $('#conlai').val(conlai2);

        }

    </script>
    <!--end dang ki hoc-->

    <!--cac khoan thu khac-->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Các khoản thu khác <b id="tongkhac"></b></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div id="example">
                <script>
                    var container = document.getElementById('example');
                    var hot =
                        new Handsontable(container, {
                            minSpareRows: 1,
                            rowHeaders: true,
                            stretchH: "all",
                            colHeaders: ['Nội dung', 'Ðơn giá', 'Số lượng', 'Giảm trừ tiền mặt', 'VAT', 'Tổng'],
                            contextMenu: true,
                            columns: [
                                {type: 'text'},
                                {type: 'numeric', format: '0,0'},
                                {type: 'numeric', format: '0,0'},
                                {type: 'numeric', format: '0,0'},
                                {type: 'numeric', format: '0,0'},
                                {type: 'numeric', format: '0,0'},
                            ]
                        });
                    var setter = false;
                    var tongtien = 0;
                    hot.addHook('afterChange', function (changes, src) {

                        if (!setter) {
                            setter = true;

                            changedRowStartingZero = changes[0][0];
                            changedRow = changedRowStartingZero;

                            //console.log('-------');

                            var currentRow = changedRow;


                            var soluong = hot.getDataAtCell(currentRow, 2);
                            var dongia = hot.getDataAtCell(currentRow, 1);
                            var giamtrutm = hot.getDataAtCell(currentRow, 3);
                            var vat = hot.getDataAtCell(currentRow, 4);
                            var tien = (soluong * 1 * dongia * 1 - giamtrutm) + (soluong * 1 * dongia * 1 * vat / 100);
                            hot.setDataAtCell(currentRow, 5, tien);
                            tongtien += tien;

                            //console.log(tongtien);
                            //  $('#tongphikhac').val(addcomma(Math.round(tongtien)));
                            tinhtonghandsome();
                            tinhhocphi();


                            setTimeout(function () {
                                var data = hot.getData();

                                var tong = 0;
                                for (var i = 0; i < data.length; i++) {
                                    var thanhtien = data[i][5];
                                    if (thanhtien == null) {
                                        thanhtien = 0;
                                    }
                                    tong = tong * 1 + thanhtien * 1;
                                }
                                $('#tongkhac').html(' - Tổng: ' + addcomma(tong));

                            }, 100);


                        } else {
                            setter = false;

                        }

                        function tinhtonghandsome() {
                            var data1 = hot.getData();
                            var tongtien9 = 0;
                            for (var i = 0; i < data1.length; i++) {
                                var soluong1 = data1[i][2];
                                var dongia1 = data1[i][1];
                                var giamtrutm1 = data1[i][3];
                                var vat1 = data1[i][4];
                                var tien1 = (soluong1 * 1 * dongia1 * 1 - giamtrutm1) + (soluong1 * 1 * dongia1 * 1 * vat1 / 100);
                                tongtien9 += tien1;
                              console.log(tongtien9);
                            }
                            $("#tongphikhac").val(tongtien9);
                        }

                        /*               function tinhtonghandsome() {
                                           var soluong1 = hot.getDataAtCell(currentRow, 2);
                                           var dongia1 = hot.getDataAtCell(currentRow, 1);
                                           var giamtrutm1 = hot.getDataAtCell(currentRow, 3);
                                           var vat1 = hot.getDataAtCell(currentRow, 4);
                                           var tien1 = (soluong * 1 * dongia * 1 - giamtrutm) + (soluong * 1 * dongia * 1 * vat / 100);
                                           $("#tongphikhac").val(tien1);
                                       }*/

                    });


                </script>
            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Số tiền tài khoản khả dụng</label>
                    <input type="text" name="stkhadung" class="form-control"
                           id="stkhadung" readonly>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Số tiền còn lại</label>
                    <input type="text" name="stconlai" class="form-control"
                           id="stconlai" readonly>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="radio">
                    <label><input type="radio" class="luachon" name="luachon" value="1">Sử dụng Tài
                        khoản</label>
                </div>
                <div class="radio">
                    <label><input type="radio" class="luachon" name="luachon" value="2" checked>Không sử dụng
                        tài khoản</label>
                </div>

            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <!--end cac khoan thu khac-->

    <!--them bang-->
    <input type="hidden" id="databang" name="databang" value="[]">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body text-center">
            <button type="button" id="btnHoanThanh" name="btnHoanThanh" onclick="them()" class="btn btn-primary">Thêm
            </button>
        </div> <!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <script>

        function them() {
            var databang = JSON.parse($('#databang').val());
            var taikhoan = $('#T1ij9ke_eA0nK7').val();
            var taikhoantext = $('#T1ij9ke_eA0nK7 :selected').text();
            var mahocsinh = $('#Tyzh5in_yBpzNV').val();
            var mahocsinhtext = $('#Tyzh5in_yBpzNV :selected').text();
            var lop = $('#lop').val();
            var loptext = $('#lop :selected').text();
            var sobuoi = $('#Tjxzrka_nKldo4').val();
            var hocphimoibuoi = $('#Tjxzrka_lyEj7Z').val();
            var giamtrutienmat = $('#giamtru').val();
            var giamtruphantram = $('#giamtrupt').val();
            var thanhtoan = $('#thanhtoan').val();
            var handong = $('#handong').val();
            var noidung = $('#noidung').val();
            var sotienconlai = $('#stconlai').val();
            var tongphaithanhtoan = $('#tongphaithanhtoan').val();
            var tonghocphi = $("#tonghocphi").val();
            var conlai = $('#conlai').val();
            var sotiendatcoc = parseInt(rmcomma($('#sotiendatcoc').val()));

            var khoanthukhac = '';

            var handson = hot.getData();

            $.each(handson, function (key, item) {
                var noidungdong = '';
                var sonull = 0;
                console.log(item);
                $.each(item, function (keycot, itemcot) { //(1)
                    if (itemcot == null || itemcot == '') {
                        sonull++;
                    }
                });
                $.each(item, function (keycot, itemcot) {

                    console.log(sonull);
                    if (sonull < 5) { // số dòng của handsome, check ở đoạn 1 có 5 dòng đấy xem có những dòng nào trống
                        if (itemcot == null || itemcot == '') {
                            itemcot = 0;
                        }
                        noidungdong += itemcot + '-';
                    }

                });

                console.log(noidungdong);
                if (noidungdong != '') {
                    khoanthukhac += noidungdong + '; ';
                }

                console.log('-------------------------------------------------------');
            });
            databang.push({
                taikhoan: taikhoan,
                taikhoantext: taikhoantext,
                mahocsinh: mahocsinh,
                mahocsinhtext: mahocsinhtext,
                lop: lop,
                loptext: loptext,
                sobuoi: sobuoi,
                hocphimoibuoi: hocphimoibuoi,
                giamtrutienmat: giamtrutienmat,
                giamtruphantram: giamtruphantram,
                thanhtoan: thanhtoan,
                handong: handong,
                noidung: noidung,
                khoanthukhac: khoanthukhac,
                sotienconlai: sotienconlai,
                tongphaithanhtoan: tongphaithanhtoan,
                conlai: conlai,
                tonghocphi: tonghocphi,
                sotiendatcoc: sotiendatcoc,
            });
            $('#databang').val(JSON.stringify(databang));
            vebang();

            layttlop();
        }


        function vebang() {
            var databang = JSON.parse($('#databang').val());
            var i = 0;
            var bang = '<table class="table table-bordered text-center"><tr><th>Tài khoản</th><th>Mã học sinh </th><th>Lớp</th><th>Số buổi</th><th>Giảm trừ (TM)</th><th>Giảm trừ (%)</th><th>Số tiền đặt cọc</th><th>Thanh toán</th><th>Hạn đóng</th><th>Nội dung</th><th>Khoản thu khác</th><th></th></tr>';
            $.each(databang, function (key, item) {
                var giamtrutienmat = (item.giamtrutienmat == 0 || item.giamtrutienmat == '') ? 0 : addcomma(item.giamtrutienmat);
                var giamtruphantram = (item.giamtruphantram == 0 || item.giamtruphantram == '') ? 0 : addcomma(item.giamtruphantram);
                var sotiendatcoc = (item.sotiendatcoc == 0 || item.sotiendatcoc == '') ? 0 : addcomma(item.sotiendatcoc);
                bang += '<tr><td>' + item.taikhoantext + '</td><td>' + item.mahocsinhtext + '</td><td>' + item.loptext + '</td><td>' + item.sobuoi + '</td><td>' + giamtrutienmat + '</td><td>' + giamtruphantram + '</td><td>' + sotiendatcoc + '</td><td>' + item.thanhtoan + '</td><td>' + item.handong + '</td><td>' + item.noidung + '</td><td>' + item.khoanthukhac + '</td><td><a onclick="xoa(' + i + ')" class="glyphicon glyphicon-remove"></a></td></tr>';
                i++;
            });
            bang += '</table>';
            $('#divbang').show();  // ở dưới vẽ ra thôi
            $('#bang').html(bang);

            $('#T1ij9ke_eA0nK7').val('').trigger('chosen:updated');
            $('#Tyzh5in_yBpzNV').val('').trigger('chosen:updated');
            $('#lop').val('').trigger('chosen:updated');

        }

        function xoa(i) {
            var databang = JSON.parse($('#databang').val());
            databang.splice(i, 1);
            $('#databang').val(JSON.stringify(databang));
            vebang();
        }
    </script>
    <!--end them bang-->

    <!--bang du lieu-->
    <div class="box" id="divbang" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title">Thông tin</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <div id="bang">

            </div>
        </div> <!-- /.box-body -->
        <div class="box-footer text-center">
            <button type="button" id="btnHoanThanh" name="btnHoanThanh" class="btn btn-primary" onclick="submit()">Hoàn
                thành
            </button>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <script>
        //submit
        function submit() {
            var databang = $('#databang').val();
            //var sotiendatcoc = parseInt(rmcomma($('#sotiendatcoc').val()));
            $.ajax({
                url: 't1obv9d?submit',
                type: 'post',
                data: {'databang': databang},
                dataType: 'text',
                success: function (data) {
                    makeSAlertright('Đã thêm!!', 3000);
                    //console.log(data);
                    setTimeout(function () {
                        window.location.assign('/tkn3h4i?mang=' + data);
                    }, 1000);
                }
            });
        }  //End submit

        $(function () {
            $('.col-lg-3').css('height', '85px');
            $('.col-lg-6').css('height', '85px');
            $('.col-lg-9').css('height', '85px');
            $('.col-sm-3').css('height', '85px');
            $('.col-sm-6').css('height', '85px');
            $('.col-sm-9').css('height', '85px');
        });

    </script>
    <!--end bang du lieu-->

<?php } ?>

