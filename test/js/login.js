$(document).ready(function () {

    $(function () {
        $("#username_result").hide();
        $("#password_result").hide();
        $("#code_result").hide();

        var error_username;
        var error_passwd;
        var error_code;

        $("#username").focusout(function () {
            check_username();
        });
        $("#password").focusout(function () {
            check_passwd();
        });
        $("#code").focusout(function () {
            check_code();
        });

        function check_username() {
            var pattern = /^[a-zA-Z]*$/;
            var username = $("#username").val();
            if (pattern.test(username) && username !== '') {
                $("#username_result").hide();
                $(".usr").css("background-color", "#dff0d8");
                error_username = false;
            } else {
                $("#username_result").html("請記得填寫帳號");
                $("#username_result").show();
                $(".usr").css("background-color", "#f2dede");
                error_username = true;
            }
        }

        function check_passwd() {
            var pattern = /^[a-zA-Z]*$/;
            var passwd = $("#password").val();
            if (pattern.test(passwd) && passwd !== '') {
                $("#password_result").hide();
                $(".pass").css("background-color", "#dff0d8");
                error_passwd = false;
            } else {
                $("#password_result").html("請記得填寫密碼");
                $("#password_result").show();
                $(".pass").css("background-color", "#f2dede");
                error_passwd = true;
            }
        }

        function check_code() {
            var pattern = /^[a-zA-Z]*$/;
            var code = $("#code").val();
            if (pattern.test(code) && code !== '') {
                $("#code_result").hide();
                $("#code").css("border", "1px solid #3c763d");
                error_code = false;
            } else {
                $("#code_result").html("請填寫驗證碼");
                $("#code_result").show();
                $(".input-group-addon").css("background-color", "#f2dede");
                error_code = true;
            }
        }



        $("#getcode_num").click(function () {
            $(this).attr("src", '../controllers/checkCode.php?', Math.random());
        });

        // $("#submitExample").click(function () {
        //     if (error_username === false && error_passwd === false && error_code === false) {
        //         $.ajax({
        //             type: "POST", //傳送方式
        //             url: "../controllers/login.php", //傳送目的地
        //             dataType: "json", //資料格式
        //             data: $('#formlogin').serialize(),
        //             success: function (data) {
        //                 if (data.join) {
        //                     $("#join_result").html(data.join);
        //                 } else {
        //                     $.each(data, function (key, item) {
        //                         if (item) {
        //                             $("#" + key + "_result").html(item);
        //                         } else {
        //                             $("#" + key + "_result").empty();
        //                         }
        //                     });
        //                 }
        //             },
        //             error: function (jqXHR) {
        //                 $("#username_result").html('<font color="#ff0000">發生錯誤：' + jqXHR.status + '</font>');
        //             }
        //         })
        //     }
        // })
    });
});