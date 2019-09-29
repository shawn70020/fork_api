$(document).ready(function () {

    $(function () {
        $("#cash").focusout(function () {
            check_num();
        });
        $("#password").focusout(function () {
            check_password();
        });

        function check_num() {
            var pattern = /^[0-9]+$/;
            var num = $("#cash").val()
            if (!pattern.test(num)) {
                $("#num_result").html("請填入數字");
                $("#num_result").show();
                $("#update").attr('disabled', true);
            } else {
                $("#num_result").hide();
                $("#update").attr('disabled', false);
            }
        }

        function check_password() {
            var passwd = $("#password").val().length;
            if (passwd == '') {
                $("#passwd_result").html("請填寫密碼!");
                $("#passwd_result").show();
                $("#update").attr('disabled', true);
            } else {
                $("#passwd_result").hide();
                $("#update").attr('disabled', false);
            }
        }
    });
});