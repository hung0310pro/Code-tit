<?php // ban sai
require_once "tit.php";
$conn = new titAuth($servername, $username, $password, $dbname);
?>
<link href='/plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet'/>
<link href='/plugins/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print'/>
<script src='/plugins/fullcalendar/fullcalendar.min.js'></script>
<?php
$w = null;
$wl = null;
if ($_GET['Tyzh5in_CBpWtZ'] != null) {
    $w = ' AND Tea4boi_6Zfvbk = ' . $_GET['Tyzh5in_CBpWtZ'];
    $w1 = ' AND Tcy5d8t_Egj0mP = ' . $_GET['Tyzh5in_CBpWtZ'];
}
if ($_GET['Tea4boi_uRPbil'] != null) {
    $w = $w . ' AND Tea4boi_uRPbil = ' . $_GET['Tea4boi_uRPbil'];
    $w1 = $w1 . ' AND Tcy5d8t_4te6nb = ' . $_GET['Tea4boi_uRPbil'];
}
$tkb = select_list($conn, 'SELECT * FROM tea4boi LEFT JOIN (tw8mqr7,tjxzrka) ON (tjxzrka.Tjxzrka_id = tea4boi.Tea4boi_6Zfvbk AND
tw8mqr7.Tw8mqr7_id = tea4boi.Tea4boi_uRPbil)
WHERE Tjxzrka_BKZ24z = 51 AND Tjxzrka_liMTtb >  CURDATE() 
' . $w);
// Tjxzrka_BKZ24z = 51 AND Tjxzrka_liMTtb >  CURDATE() (lớp đang thực hiện-và ngày kết thúc học lớn hơn ngày hôm nay)
$tkbtn = select_list($conn, 'SELECT * FROM tcy5d8t LEFT JOIN (tw8mqr7,tjxzrka) ON (tjxzrka.Tjxzrka_id = tcy5d8t.Tcy5d8t_Egj0mP AND
tw8mqr7.Tw8mqr7_id = tcy5d8t.Tcy5d8t_4te6nb)
WHERE Tjxzrka_BKZ24z = 51 AND Tcy5d8t_uW3tRj >  CURDATE()
' . $w1);
$count = 0;
$data = array();

foreach ($tkbtn as $value) {
    $data[$count]['title'] = 'Lớp : ' . $value['Tjxzrka_siRo6k'] . ' Phòng : ' . $value['Tw8mqr7_o89VN6'];
    $data[$count]['start'] = $value['Tcy5d8t_uW3tRj'] . 'T' . $value['Tcy5d8t_aIwtvx'];
    $data[$count]['end'] = $value['Tcy5d8t_uW3tRj'] . 'T' . $value['Tcy5d8t_537fqX'];
    $data[$count]['url'] = '/tcy5d8t/edit/' . $value['Tcy5d8t_id'];
    $count++;
}

$count = 0;
$wc = array(53 => 1, 54 => 2, 55 => 3, 56 => 4, 57 => 5, 58 => 6, 59 => 0);
While ($count < 365) {
    $dc = date('Y-m-d', strtotime("+" . $count . " days")); // tính từ ngày hôm nay(30/8/2018) cộng //lên 365 ngày (30/8/2019)
    // w	Biểu diễn bằng số của ngày trong tuần	0 (cho Chủ Nhật) đến 6 (Thứ Bảy)
    $dw = date('w', strtotime($dc));
    foreach ($tkb as $value) {
        if ($dc <= $value['Tjxzrka_liMTtb']
            and $dc >= $value['Tjxzrka_RGElDT']
            and $dw == $wc[$value['Tea4boi_BFMxnI']]
        ) // nếu thời gian ngày của $dc mà nó < ngày học bắt đầu($value['Tjxzrka_RGElDT']) và nhỏ hơn ngày bắt đầu học thì in ra
        	
        {
            $a = $count . $value['Tea4boi_id'];// làm cái này để tránh bị trùng vs cái ở trên(cái $tkbtn)
            // cứ pre cái $data thì hiểu
            $data[$a]['title'] = 'Lớp : ' . $value['Tjxzrka_siRo6k'] . ' Phòng : ' . $value['Tw8mqr7_o89VN6'];
            $data[$a]['start'] = $dc . 'T' . $value['Tea4boi_AhIUyQ'];
            $data[$a]['end'] = $dc . 'T' . $value['Tea4boi_uCwsIM'];
            $data[$a]['url'] = '/tjxzrka/edit/' . $value['Tjxzrka_id'];
        }
    }
    $count++;
}


?>
<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'month,agendaWeek'
            },
            //defaultView: 'agendaWeek',
            defaultDate: '<?php echo $datetoday; ?>',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            events: [
                <?php foreach ($data as $value ) { ?>
                {
                    title: '<?php echo $value['title'];  ?>',
                    start: '<?php echo $value['start'];  ?>',
                    end: '<?php echo $value['end'];  ?>',
                    url: '<?php echo $value['url'];  ?>'
                },
                <?php } ?>
            ]
        });
    });
</script>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Thời khóa biểu giáo viên</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>  <!-- /.box-tools -->
    </div>
    <div class="box-body">
        <form action="#" method="get">
            <div class="row">


                <?php selectbox5($conn, 'Tyzh5in_CBpWtZ', null, 3); ?>
                <?php selectbox5($conn, 'Tea4boi_uRPbil', null, 3); ?>
                <?php if (!empty($_GET['Tyzh5in_CBpWtZ'])) {
                    ?>
                    <script>
                        $('#Tyzh5in_CBpWtZ').val("<?php echo $_GET['Tyzh5in_CBpWtZ']; ?>").trigger('chosen:updated');
                    </script>
                    <?php
                } ?>
                <?php if (!empty($_GET['Tea4boi_uRPbil'])) {
                    ?>
                    <script>
                        $('#Tea4boi_uRPbil').val("<?php echo $_GET['Tea4boi_uRPbil']; ?>").trigger('chosen:updated');
                    </script>
                    <?php
                } ?>
                <div class="col-lg-3">
                    <br>
                    <div class="form-group"><input type="submit" name="submit" id="submitbutton"
                                                   class="btn btn-primary btn-sm" value="Tìm kiếm"></div>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div id='calendar'>
        </div>
    </div>
</div>
</div>
</div>