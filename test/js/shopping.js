$(document).ready(function () {

    $(function () {
        var s = $(".test").length;

        $(".test").focusout(function () {
            var pattern = /^[0-9]+$/;
            var value = $(this).val();
            var total = 0;
            if (value.length == '') {
                $(this).val(1);
            } else if (!pattern.test(value)) {
                $(this).val(1);
            } else if (value > 10) {
                $(this).val(10);
            } else if (value < 1) {
                $(this).val(1);
            }
            for (i = 1; i <= s; i++) {
                total = total + $("#price-" + i).val() * $("#quantity-" + i).val();
            }
            $(".total").html("總金額：" + total);
        });
    });
});