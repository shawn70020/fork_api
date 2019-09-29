$(document).ready(function () {

	load_cart_data();

	function load_cart_data() {
		$.ajax({
			url: "car_show.php",
			method: "POST",
			dataType: "json",
			success: function (data) {
				$('#cart_details').html(data.cart_details);
				$('.badge').text(data.total_item);
			}
		});
	}

	$('#cart-popover').popover({
		html: true,
		container: 'body',
		content: function () {
			return $('#popover_content_wrapper').html();
		}
	});

	$(document).on('click', '.add_cart', function () {
		var product_id = $(this).attr("id");
		var product_name = $('#name').val();
		var product_price = $('#price').val();
		var product_quantity = $('#quantity').val();
		var product_num = $('#num').val();
		var product_image = $('#image').val();
		var action = "add";
		if (product_quantity > 0) {
			$.ajax({
				url: "add.php",
				method: "POST",
				data: {
					product_id: product_id,
					product_name: product_name,
					product_price: product_price,
					product_quantity: product_quantity,
					product_num: product_num,
					product_image: product_image,
					action: action
				},
				success: function (data) {
					load_cart_data();
					alert("商品已加入購物車");
				}
			});
		} else {
			alert("請輸入有效數字");
		}
	});
	/**
	 刪除單一購物車商品
	 */
	$(document).on('click', '.delete', function () {
		var pid = $(this).attr("id");
		var action = 'remove';
		if (confirm("您確定刪除此項商品嗎")) {
			$.ajax({
				url: "add.php",
				method: "POST",
				data: {
					pid: pid,
					action: action
				},
				success: function () {
					load_cart_data();
					$('#cart-popover').popover('hide');
					alert("商品已被移出購物車！");
					location.reload();
				}
			})
		} else {
			return false;
		}
	});
	/**
	 刪除全部購物車商品 
	 */
	$(document).on('click', '#clear_cart', function () {
		var action = 'empty';
		$.ajax({
			url: "add.php",
			method: "POST",
			data: {
				action: action
			},
			success: function () {
				load_cart_data();
				$('#cart-popover').popover('hide');
				alert("購物車已被清空");
			}
		});
	});
	/** 
	 結帳
	*/
	$(document).on('click', '#add_order', function () {
		var action = 'order';
		var i;
		var pid = [];
		var quantity = [];
		var s = $(".number").length;
		for (i = 1; i <= s; i++) {
			quantity.push($("#quantity-" + i).val());
		}
		for (i = 1; i <= s; i++) {
			pid.push($("#pid-" + i).val());
		}
		$.ajax({
			url: "add_order.php",
			method: "POST",
			dataType: "json",
			data: {
				quantity: quantity,
				pid: pid,
				action: action
			},
			success: function (data) {
				if (data.success) {
					load_cart_data();
					$('#cart-popover').popover('hide');
					alert("訂單交易成功!");
					location.href = '../controllers/member.php';
				} else if (data.fail) {
					alert(data.fail);
				}
			}
		});
	});
	$(document).on('click', '#update_order', function () {
		var action = 'update_order';
		var i;
		var oid = [];
		var status = [];
		var s = $(".update_order").length;
		for (i = 1; i <= s; i++) {
			status.push($("#order-" + i).val());
		}
		for (i = 1; i <= s; i++) {
			oid.push($("#oid-" + i).val());
		}
		$.ajax({
			url: "update_order.php",
			method: "POST",
			dataType: "json",
			data: {
				status: status,
				oid: oid,
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
});