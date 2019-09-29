$(document).ready(function () {
	$(".add_search").click(function (e) {
		e.preventDefault();
		var search = $('#search').val();
		var action = "product";
		$.ajax({
			type: "post",
			url: "search.php",
			data: {
				search: search,
				action: action
			},
			dataType: "json",
			success: function (data) {
				var s = data.length;
				var str = '';
				for (i = 0; i < s; i++) {
					str += `<div class="main">
        <div>
          <a href="product.php?id=${data[i].id}">
            <img src="../images/${data[i].image}" width="240px" height="320px" />
          </a>
        </div>
        <div class="down">
          <div class="price">${data[i].price}/ <small>卷</small></div>
          <h1>${data[i].name}</h1>
          <ul class="details">
            <li>${data[i].content}</li>
          </ul>
          <a href="product.php?id=${data[i].id}" class="btn btn-primary btn-lg btn-block buy-now">
            購買 <span class="glyphicon glyphicon-triangle-right"></span>
          </a>
        </div>
	  </div>`
				}
				$(".content").html(str);
			}
		});
	});
	$(".order_search").click(function (e) {
		e.preventDefault();
		var search = $('#search').val();
		var action = "order";
		$.ajax({
			type: "post",
			url: "search_order.php",
			data: {
				search: search,
				action: action
			},
			dataType: "json",
			success: function (data) {
				var s = data.length;
				var str = '';
				var status = '';
				for (i = 0; i < s; i++) {
					if (data[i].status == 0) {
						status = `<select name="order" class="update_order" id="order-${data[i].orderid}">
						<option value="0">處理中</option>
						<option value="1">已出貨</option>
					  </select>
					  <button data-id="${data[i].orderid}" class="order_status">送出</button>`
					} else if (data[i].status == 1) {
						status = `<select name="order" class="update_order" id="order-${data[i].orderid}">
                    <option value="0">處理中</option>
                    <option selected="selected" value="1">已出貨</option>
                  </select>
                  <button data-id="${data[i].orderid}"" class="order_status">送出</button>`
					}
					st = `<table id="tablePreview" class="table">
				   <thead>
					   <tr>
						   <th>#訂單編號</th>
						   <th>顧客編號</th>
						   <th>成立時間</th>
						   <th>操作</th>
					   </tr>
				   </thead>
				   <tbody> `
					str +=
						`<tr>
                    <th scope="row">${data[i].orderid}</th>
					<td>${data[i].uid}</td>
					<td>${data[i].join_time}</td>
					<td>${status}</td>
					</div>`
				}
				$(".container").html(st + str);
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
			}
		});
	});
});