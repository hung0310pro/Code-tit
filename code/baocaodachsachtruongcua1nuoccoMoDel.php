<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
$truong = select_list($conn, "select * from tubopaz");
if (isset($_GET["hienthinuoc"])) {
    $this->layout('Student/layout2');

    $idnuoc = $_POST["idnuoc"];
    $danhsachtruongcuanuoc = select_list($conn, "select * from tdj3ex5 where Tdj3ex5_NvJ5Rh = " . $idnuoc. " group by Tdj3ex5_BnT0bX");
    ?>
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js"></script>
    <table id="bang1" class="table table-bordered table-striped table-hover text-center">
        <thead>
        <tr>
            <th>Mã Trường</th>
            <th>Tên Trường</th>
            <th>Địa Chỉ chi tiết</th>
            <th>Hình Thức Trường</th>
            <th>Loại Trường</th>
            <th>Thành Phố</th>
            <th>Bang</th>
            <th>Học Phí</th>
            <th>Kỳ Nhập Học</th>
            <th>Tình Trạng</th>
            <th>Tài Liệu</th>
            <th>Đối Tác</th>
            <th>Commission</th>
            <th>Ghi Chú</th>
            <th>Học Bổng</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <?php foreach ($danhsachtruongcuanuoc as $value3) { ?>
            <tr>
                <td><?= $value3["Tdj3ex5_BnT0bX"] ?></td>
                <td><?= $value3["Tdj3ex5_EriRyp"] ?></td>
                <td><?= $value3["Tdj3ex5_vzZ3wW"] ?></td>
                <td><?= $value3["Tdj3ex5_v7Y0Op"] ?></td>
                <td><?= $value3["Tdj3ex5_iolaAG"] ?></td>
                <td><?= $value3["Tdj3ex5_mcWFe1"] ?></td>
                <td><?= $value3["Tdj3ex5_YUyxFW"] ?></td>
                <td><?= $value3["Tdj3ex5_nuQ7ot"] ?></td>
                <td><?= $value3["Tdj3ex5_GzfpaU"] ?></td>
                <td><?= $value3["Tdj3ex5_skyR3T"] ?></td>
                <td><?= $value3["Tdj3ex5_17Jqwa"] ?></td>
                <td><?= $value3["Tdj3ex5_k7w6Lm"] ?></td>
                <td><?= $value3["Tdj3ex5_BUeyWO"] ?></td>
                <td><?= $value3["Tdj3ex5_tOH4mB"] ?></td>
                <td><?= $value3["Tdj3ex5_4BOTmu"] ?></td>
            </tr>
        <?php } ?>
        </tfoot>
    </table>

    <script>
        $(function () {
            $('#bang1').DataTable();
        });
    </script>
    <?php
} else {


    ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Báo cáo số trường của 1 nước</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>  <!-- /.box-tools -->
        </div> <!-- /.box-header -->
        <div class="box-body">
            <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
            <script src="plugins/datatables/jquery.dataTables.js"></script>
            <script src="plugins/datatables/dataTables.bootstrap.js"></script>
            <table id="bang1" class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Tên nước</th>
                    <th>Số lượng trường</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($truong as $value) {
                    $demtruongcuanuoc = select_info($conn, "select count(*) from tdj3ex5 where Tdj3ex5_NvJ5Rh = " . $value["Tubopaz_id"])['count(*)'];
                    ?>
                    <tr>
                        <td><a href="javascript:void(0)"
                               onclick="hienthinuoc(<?= $value["Tubopaz_id"]; ?>)"><?= $value["Tubopaz_uKvGID"]; ?></a>
                        </td>
                        <td><?= $demtruongcuanuoc; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>

            <script>
                $(function () {
                    $('#bang1').DataTable();
                });
            </script>
        </div> <!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-body -->
    </div><!-- /.box -->

<?php } ?>

<div id="modalthongtin" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Danh sách các trường của nước</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="nhapthongtin" style="overflow-x: scroll; overflow-y: scroll">

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
<script> //k cần truyền id gì vào bảng xuất ra trong model vì nó xuất ra khi mình click vào rồi
    function hienthinuoc(idnuoc) {  // tìm cái thẻ a để truyền cái id vào
        $.ajax({
            url: '?hienthinuoc',
            type: 'POST',
            data: {idnuoc: idnuoc},
            success: function (data) {
                $('#nhapthongtin').html(data);  // cái này là xuất cái kết quả ra trong cái model ở cái chỗ  <div id="nhapthongtin" style="overflow-x: scroll; overflow-y: scroll">

                       // </div>
                $('#modalthongtin').modal();  // cái này gọi tới cái model
            }
        });
    }
</script>

