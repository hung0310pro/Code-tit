<?php
$this->layout('Student/layout2');
require_once "tit.php";

$conn = new titAuth($servername, $username, $password, $dbname);
if (isset($_GET['thaydoi'])) {
    $this->layout('Student/layout2');

    $insertdata = array(
        "Tyzh5in_7gue9c" => 93
    );
    $wheredata = array(
        "Tyzh5in_id" => $_POST['id'] //???
    );
    updatedb($conn, "tyzh5in", array("where" => $wheredata, "data" => $insertdata));

    exit; // update lại thông tin đã đóng sau khi mình chỉnh sửa
}
$loptrehan = select_list($conn, 'select * from tyzh5in WHERE Tyzh5in_UBtu3G <= DATE_ADD("' . $datetoday . '", INTERVAL -14 DAY) AND Tyzh5in_UBtu3G != "0000-00-00" AND Tyzh5in_7gue9c = 94  GROUP BY Tyzh5in_O6aeIR'); // lấy ra những thằng hết hạn và chưa đóng
?>
<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.js"></script>

<table id="bangnn" class="table table-bordered table-striped table-hover text-center">
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên học sinh</th>
        <th>Số điện thoại</th>
        <th>Ngày bắt đầu</th>
        <th>Ngày kết thúc</th>
        <th>Trạng thái</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0;
    foreach ($loptrehan as $val): $i++ ?>
        <tr>
            <td><?= $i ?></td>
            <td>
                <a href="http://dev.faceworks.vn:8833/tyzh5in/?search=<?= $val['Tyzh5in_O6aeIR'] ?>&Crdfrom=&Crdto=&Tyzh5in_Lerjhk=null&Tyzh5in_yBpzNV=&Tyj7o9kCrdto=&Tyj7o9kCrdfrom=&Tyj7o9k_CIxaNf=&Tyj7o9k_vZojKh=&Tyj7o9k_gi1ZFy=&Tyj7o9k_lLUB7cto=&Tyj7o9k_lLUB7cfrom=&Tyj7o9k_cYZf5uto=&Tyj7o9k_cYZf5ufrom=&Tyj7o9k_6nhA4wto=&Tyj7o9k_6nhA4wfrom=&Tyj7o9k_tX5ORo=null&Tyj7o9k_owner=null&Tyzh5in_CBpWtZ=&TjxzrkaCrdto=&TjxzrkaCrdfrom=&Tjxzrka_HFkZI3=&Tjxzrka_RGElDTto=&Tjxzrka_RGElDTfrom=&Tjxzrka_liMTtbto=&Tjxzrka_liMTtbfrom=&Tjxzrka_X05PfAto=&Tjxzrka_X05PfAfrom=&Tjxzrka_ayPXq4to=&Tjxzrka_ayPXq4from=&Tjxzrka_3TeKExto=&Tjxzrka_3TeKExfrom=&Tjxzrka_nKldo4to=&Tjxzrka_nKldo4from=&Tjxzrka_pduk2ato=&Tjxzrka_pduk2afrom=&Tjxzrka_UAu36Pto=&Tjxzrka_UAu36Pfrom=&Tjxzrka_lyEj7Zto=&Tjxzrka_lyEj7Zfrom=&Tjxzrka_BKZ24z=null&Tjxzrka_owner=null&Tyzh5in_7QrYAo=&TargyesCrdto=&TargyesCrdfrom=&Targyes_dbMgY8=&Targyes_SjvFZ0=&Targyes_QAUgRD=&Targyes_QFctEuto=&Targyes_QFctEufrom=&Targyes_owner=null&Tyzh5in_nDJKWyto=&Tyzh5in_nDJKWyfrom=&Tyzh5in_UBtu3Gto=<?= $val['Tyzh5in_UBtu3G'] ?>&Tyzh5in_UBtu3Gfrom=<?= $val['Tyzh5in_UBtu3G'] ?>&Tyzh5in_zoaDbKto=&Tyzh5in_zoaDbKfrom=&Tyzh5in_QcsETJto=&Tyzh5in_QcsETJfrom=&Tyzh5in_4EsZXfto=&Tyzh5in_4EsZXffrom=&Tyzh5in_bjuEV8to=&Tyzh5in_bjuEV8from=&Tyzh5in_kh7xNPto=&Tyzh5in_kh7xNPfrom=&Tyzh5in_owner=null"
                   target="_blank" title="Học sinh sắp hết hạn"><?= $val['Tyzh5in_O6aeIR'] ?></a></td>
            <td><?= get_info($conn, 'tyj7o9k', ['tyj7o9k_id' => $val['Tyzh5in_yBpzNV']])['Tyj7o9k_u2O5HC'] ?></td>
            <td><?= $val['Tyzh5in_nDJKWy'] ?></td>
            <td><?= $val['Tyzh5in_UBtu3G'] ?></td>
            <td>
                <select name="trangthai<?= $val["Tyzh5in_id"] ?>" id="trangthai<?= $val["Tyzh5in_id"] ?>"
                        onchange="thaydoi(<?= $val["Tyzh5in_id"] ?>)" class="form-control chosen-select">
                    <?php
                    $ok = select_list($conn, "select * from dataman where Data_field = 'Tyzh5in_7gue9c' and (Id = 93 or Id = 94) ");
                    // lấy cái trạng thái đươc lưu trong bảng dataman navicat
                    // Value là cột tên trạng thái trong dataman
                    // Id là key của trạng thái đó
                    // Đề là lấy học sinh quá hạn, và trạng thái của nó là chưa đóng tiền, và khi nó đóng rồi mình sửa trạng thái của nó đã đóng thì nó sẽ tự mất học sinh ấy trong danh sách quá hạn
                    // trangthai<?= $val["Tyzh5in_id"] là kiểu lấy đúng cái số id của thằng học sinh mình chọn, mỗi học sinh sẽ có 1 id riêng, nên phải truyền đúng id nó vào, viết thế để biết thôi nhưng thực chất là phải truyền đúng cái id vào onechage
                    foreach ($ok as $value1) {
                        ?>
                        <option value="<?= $value1["Id"] ?>" selected="94"><?= $value1["Value"] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>
<script src="/js/makealert.js" type="text/javascript"></script>
<script>

    function thaydoi(id) {
        var id = id;
        $.ajax({
            url: "/tr2pc8h?thaydoi", // GET ở trên phải trùng với cái sau dấu ? này
            dataType: "html",
            data: {
                id: id
            },
            type: "POST",
            success: function (data) {
                makeSAlertright('Thành công', 3000);
                window.setTimeout(function () {
                    location.reload()
                }, 1000);
            },
            error: function () {
            }
        });

    }

    $(function () {
        $('#bangnn').DataTable();
    });
</script>


