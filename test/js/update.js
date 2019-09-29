$(document).ready(function() {

    $(function() {
        $("#username").focusout(function() {
            check_username();
        });
        $("#cpassword").focusout(function() {
            check_cpasswd();
        });
        $("#realname").focusout(function() {
            check_realname();
        });
        $("#email").focusout(function() {
            check_email();
        });

        function check_username() {
            var pattern = /^[a-zA-Z]*$/;
            var fname = $("#username").val();
            if (pattern.test(fname) && fname !== '') {
                $("#username_result").hide();
                $("#member_update").attr('disabled', false);
            } else {
                $("#username_result").html("請記得填寫帳號"); 
                $("#member_update").attr('disabled', true); 
            }
        }

        function check_realname() {
            var realname_length = $("#realname").val().length;
            if (realname_length < 2) {
                $("#realname_result").html("名字至少兩個字!");
                $("#member_update").attr('disabled', true);
            } else {
                $("#realname_result").hide();
                $("#member_update").attr('disabled', false);
            }
        }

        function check_cpasswd() {
            var password = $("#password").val();
            var retype_password = $("#cpassword").val();
            if (password !== retype_password) {
                $("#cpassword_result").html("兩者密碼不同!");
                $("#member_update").attr('disabled', true);
            } else {
                $("#cpassword_result").hide();
                $("#member_update").attr('disabled', false);
            }
        }

        function check_email() {
            var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var email = $("#email").val();
            if (pattern.test(email) && email !== '') {
                $("#email_result").hide();
                $("#member_update").attr('disabled', false);
            } else {
                $("#email_result").html("信箱格式不符!");
                $("#member_update").attr('disabled', true);
            }
        }
        $("#member_update").click(function (e) { 
            e.preventDefault();
            var username = $("#username").val();
            var passwd = $("#password").val();
            var passwdo = $("#passwdo").val();
            var cpasswd = $("#cpassword").val();
            var realname = $("#realname").val();
            var email = $("#email").val();
            $.ajax({
                url: "modify_detail.php",
                method: "POST",
                dataType: "json",
                data: {
                    username: username,
                    passwd: passwd,
                    passwdo: passwdo,
                    cpasswd: cpasswd,
                    realname: realname,
                    email: email
                },
                success: function (data) {
                    if (data.pass_change) {
                        alert(data.pass_change);
                        location.href = "logout.php";
                    } else if (data.success) {
                        alert(data.success);
                        location.reload(); 
                    }
                }
            });
        });
    });

});