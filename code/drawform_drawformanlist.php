<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);

?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <?php
        $notshow = array(
            "Thspwae_jbHRKU" => 1,
            "Thspwae_snoChp" => 2,
        );

        $option = array(
            "Thspwae_ijnftV" => "onchange=thaydoi()",
        );

        $fastadd = array(  // cái fastadd này nó sẽ hiển thị ra dữ liệu rồi khi ấn thêm
            // thì nó sẽ thêm vào cái bảng gốc mà bảng thspwae liên kết chức năng tới là bảng taml258
            "Thspwae_ijnftV" => true,
        );
        drawform($conn, "thspwae", $option, $l = 3, $notshow, $fastadd, $fid = '');

        selectbox5($conn, "Thspwae_ijnftV", $option, "3", $label = 'hihi', $id = '');
        // $id là nối chuỗi vs id ban đầu
        // $option cx là mảng viết hàm js Thspwae_ijnftV cột liên kết chức năng
        ?>
        <button style="background-color: aqua;" id="submit">Nút đổi màu</button>

    </div> <!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>  <!-- /.box-tools -->
    </div> <!-- /.box-header -->
    <div class="box-body">
        <?php

        $data1 = array(
            array(
                'name' => 'sanpham',
                'id' => 'sanpham',
                'show' => 'sản phẩm',
                'type' => 'chose',
                'wid' => 3,
                'option' => '',
                'reset' => 'yes',
                'require' => 'no',
                'code' => 'Thspwae_ijnftV',
            ),

            array(
                'name' => 'soluong',
                'id' => 'soluong',
                'show' => 'số lượng',
                'type' => 'number',
                'wid' => 3,
                'option' => 'onchange = "tinhtongtien()"',
                'reset' => 'yes',
                'require' => 'yes',
            ),

            array(
                'name' => 'gia',
                'id' => 'gia',
                'show' => 'giá',
                'type' => 'number',
                'wid' => 3,
                'option' => 'onchange = "tinhtongtien()"',
                'reset' => 'yes',
                'require' => 'no',
            ),

            array(
                'name' => 'tongtien1',
                'id' => 'tongtien1',  // muốn thể hiện tính tổng tiền ở chỗ này thì
                // phải viết 1 hàm js tính tổng tiền sau đó viết như mấy cái option ở trên
                'show' => 'tổng tiền',
                'type' => 'number',
                'wid' => 3,
                'option' => '',
                'reset' => 'yes',
                'require' => 'no',
            )
        );

        drawformandlist($conn, $data1, 'iddata1', 'idsua1', 'idbtadd1', 'fname1', $ona);
        $option = array();


        ?>

    </div> <!-- /.box-body -->
    <div class="box-footer"> 
    </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
    function thaydoi() {
        $("#submit").css("background", "red");
    }
</script>



