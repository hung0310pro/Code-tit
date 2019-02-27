  function themsp1() {
            var sanpham = JSON.parse($("#sanpham1").val());
            var soluong = $("#slxuat").val();
            var masp = $("#masp").val();
            var tensp = $("#tenspid").val();
            var somodel = $("#somodel").val();
            var khoxuat = $("#T8qwcbe_PX9QG7").val();
            var data = {soluong, masp, tensp, somodel, khoxuat}
            for (i = 1; i <= soluong; i++) {
                sanpham.push(data);
            }
            $("#sanpham1").val(JSON.stringify(sanpham));
            themsp();
        }

        function themsp() {
            var sanpham1 = $("#sanpham1").val();
            console.log(JSON.parse(sanpham1));
            $.ajax({
                url: "/t1hotys?themsp1",
                dataType: "text",
                data: {sanpham1: sanpham1},
                type: "POST",
                success: function (data) {
                    $("#show").html(data);
                },
                error: function () {
                }
            });
        }

        <script>
        function xoa(i) {
            console.log(i);
            var sanpham = $.parseJSON($('#sanpham1').val());
            sanpham.splice(i, 1);
            $('#sanpham1').val(JSON.stringify(sanpham));
            var sanpham1 = $("#sanpham1").val();
            themsp();
        }
    </script>