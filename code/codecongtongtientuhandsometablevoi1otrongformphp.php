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
                <?php
                selectpwa($conn, 'T1ij9ke_eA0nK7', 'Tài khoản'); ?>

            </div>
            <div class="col-lg-3">
                <?php
                $option = 'onchange = "kiemtra22()"';
                selectpwa($conn, 'Tyzh5in_yBpzNV', 'Thêm mới học sinh', $option);
                ?>
            </div>
            <div class="col-lg-3">
                <?php
                $sql = "select * from tjxzrka WHERE Tjxzrka_owner = " . $User . " ";
                $query = select_list($conn, $sql);
                ?>
                <label>Lớp </label> <a href="http://dev.faceworks.vn:8833/tz6glvo" class="fa fa-plus"> </a>
                <select name="lop" id="lop" class="form-control chosen-select" onchange="kiemtra22()">
                    <option value="0">---</option>
                    <?php foreach ($query as $val) { ?>
                        <option " value="<?= $val['Tjxzrka_id'] ?>"><?= $val['Tjxzrka_siRo6k'] ?></option>
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
                'Tjxzrka_d5K0fr' => 2,
                'Tjxzrka_52QR0T' => 2,
                'Tjxzrka_LGoNvl' => 2,
                'Tjxzrka_SnHWDc' => 2,
                'Tjxzrka_1iQlGB' => 2,
            );
            $option = array(

                "Tjxzrka_nKldo4" => 'onkeyup="tinhtoan()"',

            );
            drawform($conn, 'tjxzrka', $option, 3, $notshow); ?>
            <div class="col-lg-3">
                <div class="form-group">

                    <label>Giảm trừ(TM)</label>
                    <input type="text" name="giamtru" onkeyup="tinhtoan()" class="form-control" id="giamtru">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">

                    <label>Giảm trừ(%)</label>
                    <input type="text" name="giamtrupt" onkeyup="tinhtoan()" class="form-control"
                           id="giamtrupt">
                </div>
            </div>


            <div class="col-lg-3">
                <div class="form-group">
                    <label>Tổng phải thanh toán</label>
                    <input type="text" name="tongphaithanhtoan" class="form-control" id="tongphaithanhtoan"
                           readonly>
                    <input type="hidden" name="tongphaithanhtoanhd" class="form-control" id="tongphaithanhtoanhd"
                    >
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
            <div class="col-lg-3">
                <div class="form-group">

                    <label>Ngày bắt đầu</label>
                    <input type="date" name="ngaybd" class="form-control" id="ngaybd" onchange="ngaybatdau()">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">

                    <label>Ngày kết thúc</label>
                    <input type="date" name="ngaykt" class="form-control" id="ngaykt">
                </div>
            </div>
            <?php selectbox5($conn, 'T9jinw6_v67upW', '', 3) ?>
            <?php selectbox5($conn, 'Tyzh5in_7QrYAo', '', 3) ?>
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
    <?php
    if (isset($_GET['id'])) {
        ?>
        <script>
            $('#Tyzh5in_yBpzNV').val(<?= $_GET['id'] ?>).trigger('chosen:updated');
        </script>
        <?php
    } else if (isset($_GET['id2'])) {
        ?>
        <script>
            $('#Tyzh5in_yBpzNVTyj7o9k_CIxaNf').val(<?= $_GET['id2'] ?>).trigger('chosen:updated');
        </script>
        <?php
    }
    ?>
    <script>
        $('.col-sm-3').css('height', '83px');
        $('.col-lg-3').css('height', '83px');


        function ngaybatdau() {
            var idlop = $('#lop').val();
            $.ajax({
                url: "?tinhngayketthuc",
                dataType: "json",
                data: {idlop: idlop},
                type: "POST",
                success: function (data) {
                    $('#ngaykt').val(data);
                },
                error: function () {
                }
            });

        }

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
            $.ajax({
                url: 't1obv9d?layttlop',
                type: 'post',
                data: {'lop': lop},
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
                    tinhtoan();
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

        function tinhtoan() {
            var b = document.getElementById("Tjxzrka_nKldo4").value;
            var c = null;
            if (b != null && b != '')
                c = b.replace(/,/g, "");
            else
                c = null;
            console.log(c);
            var a = c.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById("Tjxzrka_nKldo4").value = a;
            var sobuoi = $('#Tjxzrka_nKldo4').val().replace(/,/g, "");
            var tien1buoi = $('#Tjxzrka_lyEj7Z').val().replace(/,/g, "");
            var giamtru = $('#giamtru').val().replace(/,/g, "");
            var giamtrupt = $('#giamtrupt').val().replace(/,/g, "");
            var thanhtoan = $('#thanhtoan').val().replace(/,/g, "");
            var phaidong = sobuoi * tien1buoi - giamtru * 1 - (giamtrupt * (sobuoi * tien1buoi) / 100);
            var conlai = phaidong - thanhtoan;
            $('#giamtru').val(addcomma(giamtru));
            $('#thanhtoan').val(addcomma(thanhtoan));
            $('#tongphaithanhtoan').val(addcomma(phaidong));
            $('#conlai').val(addcomma(conlai));
            sotienconlai();
        }

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
            <h3 class="box-title">Các khoản thu khác</h3>
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
                    var check = 0;
                    var tongtiencuoi = 0;
                    var tongtientheokhoahoc = 0;
                    hot.addHook('afterChange', function (changes, src) {
                        if (check == 0) {
                            tongtientheokhoahoc = rmcomma($("#tongphaithanhtoan").val());
                            $("#tongphaithanhtoanhd").val(tongtientheokhoahoc);
                        }
                        check = 1;
                        var hottamp = hot.getData();
                        tongtientheokhoahoc = $("#tongphaithanhtoanhd").val();
                        //console.log(setter);
                        //console.log(changes, src);
                        if (!setter) {
                            setter = true;

                            changedRowStartingZero = changes[0][0];
                            changedRow = changedRowStartingZero;

                            console.log('-------');

                            var currentRow = changedRow;

                            var tongtamp = 0;
                            var soluong = hot.getDataAtCell(currentRow, 2);
                            var dongia = hot.getDataAtCell(currentRow, 1);
                            var giamtrutm = hot.getDataAtCell(currentRow, 3);
                            var vat = hot.getDataAtCell(currentRow, 4);
                            var tong = (soluong * 1 * dongia * 1 - giamtrutm) + (soluong * 1 * dongia * 1 * vat / 100);
                            hottamp[currentRow][5] = tong;
                            hot.loadData(hottamp);
                            var adv = hot.getData();
                            //console.log(adv);
                            $.each(adv, function (key, value) {
                                if (value[5] != null) {
                                    tongtamp += value[5] * 1;
                                }
                            });
                            tongtiencuoi = tongtamp + tongtientheokhoahoc * 1;
                            $('#tongphaithanhtoan').val(addcomma(tongtiencuoi));
                            sotienconlai();
                        } else {
                            setter = false;

                        }
                    });


                </script>