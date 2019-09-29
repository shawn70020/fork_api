$(document).ready(function () {
    $(".member").click(function (e) {
        e.preventDefault();
        var id = e.target.dataset.id;
        var status = $("#member-" + id).val();
        var action = 'update_member';
        $.ajax({
            url: "update_member.php",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                status: status,
                action: action
            },
            success: function (data) {
                if (data.success) {
                    alert(data.success);
                } else if (data.fail) {
                    alert(data.fail);
                }
            }
        });
    });
    $(".order_status").click(function (e) {
        e.preventDefault();
        var oid = e.target.dataset.id;
        var status = $("#order-" + oid).val();
        var action = 'update_order';
        $.ajax({
            url: "update_order.php",
            method: "POST",
            dataType: "json",
            data: {
                oid: oid,
                status: status,
                action: action
            },
            success: function (data) {
                if (data.success) {
                    alert(data.success);
                } else if (data.fail) {
                    alert(data.fail);
                }
            }
        });
    });
    $(".add_cash").click(function (e) {
        e.preventDefault();
        var now_cash = $("#now_cash").val();
        var cash = $("#cash").val();
        var passwd = $("#password").val();
        var action = 'update_cash';
        $.ajax({
            url: "update_cash.php",
            method: "POST",
            dataType: "json",
            data: {
                now_cash: now_cash,
                cash: cash,
                passwd: passwd,
                action: action
            },
            success: function (data) {
                if (data.success) {
                    var str = '';
                    alert(data.success);
                    str = `<form class="form-horizontal">
                    <fieldset>
                        <legend>目前儲值金:${data.now}</legend>
                        <input type="hidden" class="number" name="hidden_cash" id="now_cash" value="{{$now_cash}}" />
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">儲值金額</label>
                            <div class="col-md-4">
                                <input id="cash" name="cash" type="text" placeholder="請輸入金額" class="form-control input-md"
                                    maxlength="4" required="">
                            </div> <span id="num_result">
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="passwordinput">密碼</label>
                            <div class="col-md-4">
                                <input id="password" name="passwd" type="password" placeholder="請輸入密碼"
                                    class="form-control input-md" required="">
                            </div>
                            <span id="passwd_result">
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton"></label>
                            <div class="col-md-4">
                                <button id="update" name="singlebutton" class="btn btn-primary add_cash">送出</button>
                                <a href="member.php" class="btn btn-primary btn-default">返回</a>
                            </div>
                        </div>
                    </fieldset>
                </form>`
                    $(".container").html(str);
                } else if (data.fail) {
                    alert(data.fail);
                }
            }
        });
    });
});