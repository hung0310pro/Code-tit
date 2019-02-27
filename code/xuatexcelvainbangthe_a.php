 <a href="?xuatexcel&tungay1=<?= $_POST['tungay'] ?>&denngay1=<?= $_POST['denngay'] ?>&<?= http_build_query(array('giaovien1' => $_POST['giaovien'])) ?>"
       class="btn btn-primary">Xuất Excell</a>

       xuất excell vs truyền lên giáo viên là nhiều giáo viên
       $giaovien = $_GET['giaovien1'];
<?php
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
// phần cho in
if(isset($_GET['inbaocao2'])){
      $this->layout('Student/layout2');
    $info = select_info($conn, 'select * from ty4dj1n LEFT JOIN tlikahb ON tlikahb_id = Ty4dj1n_iXsEwW where Ty4dj1n_id = "' . $_GET['sohopdong2'] . '"');
    $listphieuthu = select_list($conn, 'select * from tjhnl6i where Tjhnl6i_SqTeIn = "' . $_GET['sohopdong2'] . '"');
    $songuoithamgia = select_info($conn, 'select COUNT(*) as tong from tufwt62 where Tufwt62_2gXBvH = "' . $_GET['sohopdong2'] . '" GROUP BY Tufwt62_i5WkMU')['tong'];


    $info = select_info($conn, 'select * from tjhnl6i where Tjhnl6i_id = "' . $_GET['sophiethu'] . '"');
    $listpbthuly = select_list($conn, 'select * from tq1xg7e 
		left join tnidq12 on tnidq12_id = Tq1xg7e_UIyERA 
		left join thfabcn on thfabcn_id = Tnidq12_AUTEaY 
		where Tq1xg7e_xQjeJm = "' . $_GET['sophiethu'] . '"');
    $listpbmkt = select_list($conn, 'select * from t9zo7qd 
		left join tnidq12 on tnidq12_id = T9zo7qd_ko1yvh 
		left join thfabcn on thfabcn_id = Tnidq12_AUTEaY 
		where T9zo7qd_A8ruQ7 = "' . $_GET['sophiethu'] . '"');

    ?>
    <style>
        td{
            padding: 4px;
        }
        th{
            padding: 4px;
        }
    </style>
    <table id="bang111" class="table table-bordered table-striped table-hover text-center" border="1" cellpadding="0"
           cellspacing="0">

        <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Ngày kí hợp đồng</th>
            <th>Phí dịch vụ</th>
            <th>Phiếu thu</th>
            <th>Ngày thu</th>
            <th>Số tiền</th>
            <th>Số người tham gia</th>
            <th>Thuế TNDN</th>
            <th>Thuế VAT</th>
            <th>Công ty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tong = 0;
        $tong1 = 0;
        if (count($listphieuthu) > 0) {
            $i = 0;
            $tong += $info['Ty4dj1n_HOugcn'];
            foreach ($listphieuthu as $val) {
                $i++;
                $tong1 += $val['Tjhnl6i_JI5xcy'];
                ?>
                <tr>
                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $info['Tlikahb_8aropb'] ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
                        <?php
                    }
                    ?>
                    <td>
                    <td class="btn btn-danger" onclick="getinfo(<?= $val['Tjhnl6i_id'] ?>)"
                        style="padding: 2px 4px;"><?= $val['Tjhnl6i_n4Ah3f'] ?></td>
                    </td>
                    <td><?= DATE('d-m-Y', strtotime($val['Tjhnl6i_DIsTNw'])) ?></td>
                    <td><?= number_format($val['Tjhnl6i_JI5xcy']) ?></td>

                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $songuoithamgia ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td><?= $info['Tlikahb_8aropb'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>

                <td colspan="3">Chưa có phiếu thu nào của hợp đồng này</td>


                <td><?= $songuoithamgia ?></td>
                <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

            </tr>


            <?php
        }
        ?>
        <tr>
            <td colspan="2">Tổng</td>
            <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong1) ?></td>
            <td><?= $songuoithamgia ?></td>
            <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
            <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
            <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

        </tr>

        </tbody>

    </table>

        <h4><i class="fa fa-info"> Chi tiết phiếu thu: </i> <span class="bs-label label-danger"
                                                              style="padding: 5px;border-radius: 5px;"><?= $info['Tjhnl6i_n4Ah3f'] ?></span>
    </h4>
    <table class="table table-striped table-hover text-center" border="1" cellpadding="0"
           cellspacing="0">
        <thead>
        <tr>
            <th>Phiếu thu</th>
            <th>Ngày chi thù lao</th>
            <th>Nhân viên</th>
            <th>Vị trí</th>
            <th>Số tiền</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        $tong = 0;
        foreach ($listpbthuly as $val) {
            $i++;
            $tong += $val['Tq1xg7e_QPJHMb'];
            ?>


            <tr>
                <td><?= $info['Tjhnl6i_n4Ah3f'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($val['Tq1xg7e_xmFMde'])) ?></td>
                <td><?= $val['Tnidq12_lWKHkQ'] ?></td>
                <td>Thụ lý</td>
                <td><?= number_format($val['Tq1xg7e_QPJHMb']) ?></td>
            </tr>


            <?php
        }
        ?>
        <?php

        foreach ($listpbmkt as $val) {
            $i++;
            $tong += $val['T9zo7qd_CPEJrW'];
            ?>


            <tr>
                <td><?= $info['Tjhnl6i_n4Ah3f'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($val['T9zo7qd_hP1lZA'])) ?></td>
                <td><?= $val['Tnidq12_lWKHkQ'] ?></td>
                <td>Marketing</td>
                <td><?= number_format($val['T9zo7qd_CPEJrW']) ?></td>
            </tr>


            <?php
        }
        ?>


        <tr>
            <td>Tổng</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong) ?></td>
        </tr>

        </tbody>
      <script>
        window.print();
    </script>
    </table>
    <?php
    exit;
}


if(isset($_GET['inbaocao1'])){
     $this->layout('Student/layout2');
    $info = select_info($conn, 'select * from ty4dj1n LEFT JOIN tlikahb ON tlikahb_id = Ty4dj1n_iXsEwW where Ty4dj1n_id = "' . $_GET['sohopdong'] . '"');
    $listphieuthu = select_list($conn, 'select * from tjhnl6i where Tjhnl6i_SqTeIn = "' . $_GET['sohopdong'] . '"');
    $songuoithamgia = select_info($conn, 'select COUNT(*) as tong from tufwt62 where Tufwt62_2gXBvH = "' . $_GET['sohopdong'] . '" GROUP BY Tufwt62_i5WkMU')['tong'];
   
    ?>
      <style>
        td{
            padding: 4px;
        }
        th{
            padding: 4px;
        }
    </style>
    <table id="bang111" class="table table-bordered table-striped table-hover text-center" border="1" cellpadding="0"
           cellspacing="0">

        <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Ngày kí hợp đồng</th>
            <th>Phí dịch vụ</th>
            <th>Phiếu thu</th>
            <th>Ngày thu</th>
            <th>Số tiền</th>
            <th>Số người tham gia</th>
            <th>Thuế TNDN</th>
            <th>Thuế VAT</th>
            <th>Công ty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tong = 0;
        $tong1 = 0;
        if (count($listphieuthu) > 0) {
            $i = 0;
            $tong += $info['Ty4dj1n_HOugcn'];
            foreach ($listphieuthu as $val) {
                $i++;
                $tong1 += $val['Tjhnl6i_JI5xcy'];
                ?>
                <tr>
                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $info['Tlikahb_8aropb'] ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
                        <?php
                    }
                    ?>
                    <td>
                    <td class="btn btn-danger" onclick="getinfo(<?= $val['Tjhnl6i_id'] ?>)"
                        style="
                        padding: 2px 4px;"><?= $val['Tjhnl6i_n4Ah3f'] ?></td>
                    </td>
                    <td><?= DATE('d-m-Y', strtotime($val['Tjhnl6i_DIsTNw'])) ?></td>
                    <td><?= number_format($val['Tjhnl6i_JI5xcy']) ?></td>

                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $songuoithamgia ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td><?= $info['Tlikahb_8aropb'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>

                <td colspan="3">Chưa có phiếu thu nào của hợp đồng này</td>


                <td><?= $songuoithamgia ?></td>
                <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

            </tr>


            <?php
        }
        ?>
        <tr>
            <td colspan="2">Tổng</td>
            <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong1) ?></td>
            <td><?= $songuoithamgia ?></td>
            <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
            <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
            <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

        </tr>

        </tbody>

    </table>
    <script>
        window.print();
    </script>
    <?php

    exit;
}



// phần xuất excell
if (isset($_GET['xuatexcel'])) {
    $this->layout('Student/layout2');
    $info = select_info($conn, 'select * from ty4dj1n LEFT JOIN tlikahb ON tlikahb_id = Ty4dj1n_iXsEwW where Ty4dj1n_id = "' . $_GET['sohopdong2'] . '"');
    $listphieuthu = select_list($conn, 'select * from tjhnl6i where Tjhnl6i_SqTeIn = "' . $_GET['sohopdong2'] . '"');
    $songuoithamgia = select_info($conn, 'select COUNT(*) as tong from tufwt62 where Tufwt62_2gXBvH = "' . $_GET['sohopdong2'] . '" GROUP BY Tufwt62_i5WkMU')['tong'];


    $info = select_info($conn, 'select * from tjhnl6i where Tjhnl6i_id = "' . $_GET['sophiethu'] . '"');
    $listpbthuly = select_list($conn, 'select * from tq1xg7e 
		left join tnidq12 on tnidq12_id = Tq1xg7e_UIyERA 
		left join thfabcn on thfabcn_id = Tnidq12_AUTEaY 
		where Tq1xg7e_xQjeJm = "' . $_GET['sophiethu'] . '"');
    $listpbmkt = select_list($conn, 'select * from t9zo7qd 
		left join tnidq12 on tnidq12_id = T9zo7qd_ko1yvh 
		left join thfabcn on thfabcn_id = Tnidq12_AUTEaY 
		where T9zo7qd_A8ruQ7 = "' . $_GET['sophiethu'] . '"');
   header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=data.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    ?>
    <table id="bang111" class="table table-bordered table-striped table-hover text-center" border="1" cellpadding="0"
           cellspacing="0">

        <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Ngày kí hợp đồng</th>
            <th>Phí dịch vụ</th>
            <th>Phiếu thu</th>
            <th>Ngày thu</th>
            <th>Số tiền</th>
            <th>Số người tham gia</th>
            <th>Thuế TNDN</th>
            <th>Thuế VAT</th>
            <th>Công ty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tong = 0;
        $tong1 = 0;
        if (count($listphieuthu) > 0) {
            $i = 0;
            $tong += $info['Ty4dj1n_HOugcn'];
            foreach ($listphieuthu as $val) {
                $i++;
                $tong1 += $val['Tjhnl6i_JI5xcy'];
                ?>
                <tr>
                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $info['Tlikahb_8aropb'] ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
                        <?php
                    }
                    ?>
                    <td>
                    <td class="btn btn-danger" onclick="getinfo(<?= $val['Tjhnl6i_id'] ?>)"
                        style="padding: 2px 4px;"><?= $val['Tjhnl6i_n4Ah3f'] ?></td>
                    </td>
                    <td><?= DATE('d-m-Y', strtotime($val['Tjhnl6i_DIsTNw'])) ?></td>
                    <td><?= number_format($val['Tjhnl6i_JI5xcy']) ?></td>

                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $songuoithamgia ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td><?= $info['Tlikahb_8aropb'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>

                <td colspan="3">Chưa có phiếu thu nào của hợp đồng này</td>


                <td><?= $songuoithamgia ?></td>
                <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

            </tr>


            <?php
        }
        ?>
        <tr>
            <td colspan="2">Tổng</td>
            <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong1) ?></td>
            <td><?= $songuoithamgia ?></td>
            <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
            <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
            <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

        </tr>

        </tbody>

    </table>

        <h4><i class="fa fa-info"> Chi tiết phiếu thu: </i> <span class="bs-label label-danger"
                                                              style="padding: 5px;border-radius: 5px;"><?= $info['Tjhnl6i_n4Ah3f'] ?></span>
    </h4>
    <table class="table table-striped table-hover text-center" border="1" cellpadding="0"
           cellspacing="0">
        <thead>
        <tr>
            <th>Phiếu thu</th>
            <th>Ngày chi thù lao</th>
            <th>Nhân viên</th>
            <th>Vị trí</th>
            <th>Số tiền</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        $tong = 0;
        foreach ($listpbthuly as $val) {
            $i++;
            $tong += $val['Tq1xg7e_QPJHMb'];
            ?>


            <tr>
                <td><?= $info['Tjhnl6i_n4Ah3f'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($val['Tq1xg7e_xmFMde'])) ?></td>
                <td><?= $val['Tnidq12_lWKHkQ'] ?></td>
                <td>Thụ lý</td>
                <td><?= number_format($val['Tq1xg7e_QPJHMb']) ?></td>
            </tr>


            <?php
        }
        ?>
        <?php

        foreach ($listpbmkt as $val) {
            $i++;
            $tong += $val['T9zo7qd_CPEJrW'];
            ?>


            <tr>
                <td><?= $info['Tjhnl6i_n4Ah3f'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($val['T9zo7qd_hP1lZA'])) ?></td>
                <td><?= $val['Tnidq12_lWKHkQ'] ?></td>
                <td>Marketing</td>
                <td><?= number_format($val['T9zo7qd_CPEJrW']) ?></td>
            </tr>


            <?php
        }
        ?>


        <tr>
            <td>Tổng</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong) ?></td>
        </tr>

        </tbody>

    </table>
    <?php
    exit;

}

if (isset($_GET["xuat1bang"])) {

    $this->layout('Student/layout2');
    $info = select_info($conn, 'select * from ty4dj1n LEFT JOIN tlikahb ON tlikahb_id = Ty4dj1n_iXsEwW where Ty4dj1n_id = "' . $_GET['sohopdong'] . '"');
    $listphieuthu = select_list($conn, 'select * from tjhnl6i where Tjhnl6i_SqTeIn = "' . $_GET['sohopdong'] . '"');
    $songuoithamgia = select_info($conn, 'select COUNT(*) as tong from tufwt62 where Tufwt62_2gXBvH = "' . $_GET['sohopdong'] . '" GROUP BY Tufwt62_i5WkMU')['tong'];
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=data.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    ?>
    <table id="bang111" class="table table-bordered table-striped table-hover text-center" border="1" cellpadding="0"
           cellspacing="0">

        <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Ngày kí hợp đồng</th>
            <th>Phí dịch vụ</th>
            <th>Phiếu thu</th>
            <th>Ngày thu</th>
            <th>Số tiền</th>
            <th>Số người tham gia</th>
            <th>Thuế TNDN</th>
            <th>Thuế VAT</th>
            <th>Công ty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tong = 0;
        $tong1 = 0;
        if (count($listphieuthu) > 0) {
            $i = 0;
            $tong += $info['Ty4dj1n_HOugcn'];
            foreach ($listphieuthu as $val) {
                $i++;
                $tong1 += $val['Tjhnl6i_JI5xcy'];
                ?>
                <tr>
                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $info['Tlikahb_8aropb'] ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
                        <?php
                    }
                    ?>
                    <td>
                    <td class="btn btn-danger" onclick="getinfo(<?= $val['Tjhnl6i_id'] ?>)"
                        style="
                        padding: 2px 4px;"><?= $val['Tjhnl6i_n4Ah3f'] ?></td>
                    </td>
                    <td><?= DATE('d-m-Y', strtotime($val['Tjhnl6i_DIsTNw'])) ?></td>
                    <td><?= number_format($val['Tjhnl6i_JI5xcy']) ?></td>

                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $songuoithamgia ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td><?= $info['Tlikahb_8aropb'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>

                <td colspan="3">Chưa có phiếu thu nào của hợp đồng này</td>


                <td><?= $songuoithamgia ?></td>
                <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

            </tr>


            <?php
        }
        ?>
        <tr>
            <td colspan="2">Tổng</td>
            <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong1) ?></td>
            <td><?= $songuoithamgia ?></td>
            <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
            <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
            <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

        </tr>

        </tbody>

    </table>
    <?php
    exit;
}
// hết phần in và xuất excel
if (isset($_GET['idhd'])) {
    $this->layout('Student/layout2');
    $info = select_info($conn, 'select * from ty4dj1n LEFT JOIN tlikahb ON tlikahb_id = Ty4dj1n_iXsEwW where Ty4dj1n_id = "' . $_GET['idhd'] . '"');
    $listphieuthu = select_list($conn, 'select * from tjhnl6i where Tjhnl6i_SqTeIn = "' . $_GET['idhd'] . '"');
    $songuoithamgia = select_info($conn, 'select COUNT(*) as tong from tufwt62 where Tufwt62_2gXBvH = "' . $_GET['idhd'] . '" GROUP BY Tufwt62_i5WkMU')['tong'];
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=data.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
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


    <table id="bang111" class="table table-bordered table-striped table-hover text-center">

        <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Ngày kí hợp đồng</th>
            <th>Phí dịch vụ</th>
            <th>Phiếu thu</th>
            <th>Ngày thu</th>
            <th>Số tiền</th>
            <th>Số người tham gia</th>
            <th>Thuế TNDN</th>
            <th>Thuế VAT</th>
            <th>Công ty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tong = 0;
        $tong1 = 0;
        if (count($listphieuthu) > 0) {
            $i = 0;
            $tong += $info['Ty4dj1n_HOugcn'];
            foreach ($listphieuthu as $val) {
                $i++;
                $tong1 += $val['Tjhnl6i_JI5xcy'];
                ?>
                <tr>
                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $info['Tlikahb_8aropb'] ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
                        <?php
                    }
                    ?>
                    <td>
                        <button class="btn btn-danger" onclick="getinfo(<?= $val['Tjhnl6i_id'] ?>)"
                                style="padding: 2px 4px;"><?= $val['Tjhnl6i_n4Ah3f'] ?></button>
                    </td>
                    <td><?= DATE('d-m-Y', strtotime($val['Tjhnl6i_DIsTNw'])) ?></td>
                    <td><?= number_format($val['Tjhnl6i_JI5xcy']) ?></td>

                    <?php
                    if ($i == 1) {
                        ?>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= $songuoithamgia ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                        <td rowspan="<?= count($listphieuthu) ?>"><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td><?= $info['Tlikahb_8aropb'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($info['Ty4dj1n_VzX7Iw'])) ?></td>
                <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>

                <td colspan="3">Chưa có phiếu thu nào của hợp đồng này</td>


                <td><?= $songuoithamgia ?></td>
                <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
                <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
                <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

            </tr>


            <?php
        }
        ?>
        <tr>
            <td colspan="2">Tổng</td>
            <td><?= number_format($info['Ty4dj1n_HOugcn']) ?></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong1) ?></td>
            <td><?= $songuoithamgia ?></td>
            <td><?= number_format($info['Ty4dj1n_gRPmzu']) ?></td>
            <td><?= number_format($info['Ty4dj1n_a86ZFO']) ?></td>
            <td><?= number_format($info['Ty4dj1n_oubC7t']) ?></td>

        </tr>

        </tbody>

    </table>
    <div>
        <a class="btn btn-success" href="?xuat1bang&sohopdong=<?= $_GET['idhd'] ?>" id="xuat1">Xuất Excel</a>
        <a class="btn btn-danger" href="?inbaocao1&sohopdong=<?= $_GET['idhd'] ?>" id="in1">In báo cáo</a>
    </div>
    <script>

    </script>
    <?php
    exit;
} elseif (isset($_GET['idphieuthu'])) {
    $this->layout('Student/layout2');
    $info = select_info($conn, 'select * from tjhnl6i where Tjhnl6i_id = "' . $_GET['idphieuthu'] . '"');
    $listpbthuly = select_list($conn, 'select * from tq1xg7e 
		left join tnidq12 on tnidq12_id = Tq1xg7e_UIyERA 
		left join thfabcn on thfabcn_id = Tnidq12_AUTEaY 
		where Tq1xg7e_xQjeJm = "' . $_GET['idphieuthu'] . '"');
    $listpbmkt = select_list($conn, 'select * from t9zo7qd 
		left join tnidq12 on tnidq12_id = T9zo7qd_ko1yvh 
		left join thfabcn on thfabcn_id = Tnidq12_AUTEaY 
		where T9zo7qd_A8ruQ7 = "' . $_GET['idphieuthu'] . '"');
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=data.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    ?>
    <style>
        #xuat1 {
            display: none;
        }

        #in1{
            display: none;
        }
    </style>
    <h4><i class="fa fa-info"> Chi tiết phiếu thu: </i> <span class="bs-label label-danger"
                                                              style="padding: 5px;border-radius: 5px;"><?= $info['Tjhnl6i_n4Ah3f'] ?></span>
    </h4>
    <table class="table table-striped table-hover text-center">
        <thead>
        <tr>
            <th>Phiếu thu</th>
            <th>Ngày chi thù lao</th>
            <th>Nhân viên</th>
            <th>Vị trí</th>
            <th>Số tiền</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        $tong = 0;
        foreach ($listpbthuly as $val) {
            $i++;
            $tong += $val['Tq1xg7e_QPJHMb'];
            ?>


            <tr>
                <td><?= $info['Tjhnl6i_n4Ah3f'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($val['Tq1xg7e_xmFMde'])) ?></td>
                <td><?= $val['Tnidq12_lWKHkQ'] ?></td>
                <td>Thụ lý</td>
                <td><?= number_format($val['Tq1xg7e_QPJHMb']) ?></td>
            </tr>


            <?php
        }
        ?>
        <?php

        foreach ($listpbmkt as $val) {
            $i++;
            $tong += $val['T9zo7qd_CPEJrW'];
            ?>


            <tr>
                <td><?= $info['Tjhnl6i_n4Ah3f'] ?></td>
                <td><?= DATE('d-m-Y', strtotime($val['T9zo7qd_hP1lZA'])) ?></td>
                <td><?= $val['Tnidq12_lWKHkQ'] ?></td>
                <td>Marketing</td>
                <td><?= number_format($val['T9zo7qd_CPEJrW']) ?></td>
            </tr>


            <?php
        }
        ?>


        <tr>
            <td>Tổng</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= number_format($tong) ?></td>
        </tr>

        </tbody>

    </table>
    <div>
        <a href="?xuatexcel&sohopdong2=<?= $_GET['idhd1'] ?>&sophiethu=<?= $_GET['idphieuthu'] ?>"
           class="btn btn-success" id="xuat2">Xuất excel</a>
          <a class="btn btn-danger" href="?inbaocao2&sohopdong2=<?= $_GET['idhd1'] ?>&sophiethu=<?= $_GET['idphieuthu']?>" onclick="inbaocao()">In báo cáo</a>
    </div>

    <?php
} else {
    ?>
    <script src="/js/makealert.js" type="text/javascript"></script>
    <style>
        table {
            border-spacing: 3px 2px;
            border-collapse: separate;
        }
    </style>
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-9">
                    <h3><i class="fa fa-calendar"> Chi tiết hợp đồng</i></h3>
                </div>

                <?php
                selectbox5($conn, 'Tjhnl6i_SqTeIn', 'onchange="getlist()"', 3);
                ?>


            </div>
            <div class="row">
                <div class="col-md-12" id="noidung">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12" id="chitiet">
                </div>
            </div>

        </div>
    </div>
    <script>
        function getlist() {
            $.ajax({
                url: "/tb5m2at",
                dataType: "text",
                data: {idhd: $('#Tjhnl6i_SqTeIn').val()},
                type: "GET",
                success: function (data) {
                    $('#noidung').html(data);
                },
                error: function () {
                }
            });
        }

        function getinfo(value) {
            var idhd1 = $('#Tjhnl6i_SqTeIn').val();
            $.ajax({
                url: "/tb5m2at",
                dataType: "text",
                data: {idphieuthu: value, idhd1: idhd1},
                type: "GET",
                success: function (data) {
                    $('#chitiet').html(data);
                },
                error: function () {
                }
            });
        }

        function xuatexcel1() {
            $.ajax({
                url: "/tb5m2at",
                dataType: "text",
                data: {idhd: $('#Tjhnl6i_SqTeIn').val()},
                type: "POST",
                success: function (data) {

                },
                error: function () {
                }
            });

        }




    </script>

    <?php

}
?>				