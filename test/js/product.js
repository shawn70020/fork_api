$(document).ready(function () {

    $(function () {
        $("#pname").focusout(function () {
            check_pname();
        });
        $("#num").focusout(function () {
            check_num();
        });
        $("#price").focusout(function () {
            check_price();
        });

        function check_pname() {
            var pname = $("#pname").val().length;
            if (pname == '') {
                $("#pname_result").html("請填寫商品名稱!");
                $("#pname_result").show();
                $("#update").attr('disabled', true);
            } else {
                $("#pname_result").hide();
                $("#update").attr('disabled', false);
            }
        }

        function check_num() {
            var pattern = /^[0-9]+$/;
            var num = $("#num").val()
            if (!pattern.test(num)) {
                $("#num_result").html("請填入數字");
                $("#num_result").show();
                $("#update").attr('disabled', true);
            } else {
                $("#num_result").hide();
                $("#update").attr('disabled', false);
            }
        }

        function check_price() {
            var pattern = /^[0-9]+$/;
            var price = $("#price").val()
            if (!pattern.test(price)) {
                $("#price_result").html("請填入數字");
                $("#price_result").show();
                $("#update").attr('disabled', true);
            } else {
                $("#price_result").hide();
                $("#update").attr('disabled', false);
            }
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });

        $(".delete").click(function () {
            var msg = "確定要刪除商品?\n此操作不可恢復!";
            if (confirm(msg) == true) {
                var pid = $(this).attr("id");
                var action = 'delete';
                $.ajax({
                    type: "POST", //傳送方式
                    url: "../controllers/product_delete.php", //傳送目的地
                    dataType: "json", //資料格式
                    data: {
                        pid: pid,
                        action: action
                    },
                    success: function (data) {
                        if (data.success) {
                            alert(data.success);
                            location.reload();
                        } else if (data.fail) {
                            alert(data.fail);
                            location.reload();
                        }
                    }
                })
            } else {
                return false;
            }
        });
    });
});