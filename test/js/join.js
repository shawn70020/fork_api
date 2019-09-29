$(document).ready(function () {

    $(function () {
        $("#username").focusout(function () {
            check_username();
        });
        $("#password").focusout(function () {
            check_passwd();
        });
        $("#cpassword").focusout(function () {
            check_cpasswd();
        });
        $("#realname").focusout(function () {
            check_realname();
        });
        $("#email").focusout(function () {
            check_email();
        });

        function check_username() {
            var pattern = /^[a-zA-Z]*$/;
            var fname = $("#username").val();
            if (pattern.test(fname) && fname !== '') {
                $("#username_result").hide();
                $("#username").css("border", "1px solid #3c763d");
                $("#join_member").attr('disabled', false);
            } else {
                $("#username_result").html("請記得填寫帳號");
                $("#username_result").show();
                $("#username").css("border", "1px solid #a94442");
                $("#join_member").attr('disabled', true);
            }
        }

        function check_passwd() {
            var pattern = /^[a-zA-Z]*$/;
            var sname = $("#password").val()
            if (pattern.test(sname) && sname !== '') {
                $("#password_result").hide();
                $("#password").css("border", "1px solid #3c763d");
                $("#join_member").attr('disabled', false);
            } else {
                $("#password_result").html("請記得填寫密碼");
                $("#password_result").show();
                $("#password").css("border", "1px solid #a94442");
                $("#join_member").attr('disabled', true);
            }
        }

        function check_realname() {
            var realname_length = $("#realname").val().length;
            if (realname_length < 2) {
                $("#realname_result").html("名字至少兩個字!");
                $("#realname_result").show();
                $("#realname").css("border", "1px solid #a94442");
                $("#join_member").attr('disabled', true);
            } else {
                $("#realname_result").hide();
                $("#realname").css("border", "1px solid #3c763d");
                $("#join_member").attr('disabled', false);
            }
        }

        function check_cpasswd() {
            var password = $("#password").val();
            var retype_password = $("#cpassword").val();
            if (password !== retype_password) {
                $("#cpassword_result").html("兩者密碼不同!");
                $("#cpassword_result").show();
                $("#cpassword").css("border", "1px solid #a94442");
                $("#join_member").attr('disabled', true);
            } else {
                $("#cpassword_result").hide();
                $("#cpassword").css("border", "1px solid #3c763d");
                $("#join_member").attr('disabled', false);
            }
        }

        function check_email() {
            var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var email = $("#email").val();
            if (pattern.test(email) && email !== '') {
                $("#email_result").hide();
                $("#email").css("border", "1px solid #3c763d");
                $("#join_member").attr('disabled', false);
            } else {
                $("#email_result").html("信箱格式不符!");
                $("#email_result").show();
                $("#email").css("border", "1px solid #a94442");
                $("#join_member").attr('disabled', true);
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

        $("#join_member").click(function () {
            var username = $('#username').val();
            var password = $('#password').val();
            var cpassword = $('#cpassword').val();
            var realname = $('#realname').val();
            var email = $('#email').val();
            var action = "join";
            $.ajax({
                url: "../controllers/join_check.php",
                method: "POST",
                data: {
                    username: username,
                    password: password,
                    cpassword: cpassword,
                    realname: realname,
                    email: email,
                    action: action
                },
                success: function (data) {
                    if(data.used){
                        alert(data.used);
                    }else if(data.fail){
                        alert(data.fail);
                    }else{
                        alert(data.join);
                        location.href = "../controllers/login.php";
                    }
                }
            });
        });
        // $(".member").click(function (e) {
        //     //e.preventDefault();
        //     var id = e.target.dataset.id;
        //     var status = $("#member-" + id).val();
        //     var action = 'update_member';
        //     $.ajax({
        //         url: "update_member.php",
        //         method: "POST",
        //         dataType: "json",
        //         data: {
        //             id: id,
        //             status: status,
        //             action: action
        //         },
        //         success: function (data) {
        //             if (data.success) {
        //                 alert("jijoij");
        //             } else if (data.fail) {
        //                 alert(data.fail);
        //             }
        //         }
        //     });
        // });
    });

});