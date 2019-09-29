$(document).ready(function () {

    let page = 1; //預設開始頁數1
    let page_limit = 8; //每頁顯示比數
    let total_record = 0; //總筆數
    let total_page = 0; //總頁數
    fetchData();
    // handling the prev-btn
    $(".prev-btn").on("click", function () {
        fetchData();
        if (page > 1) {
            page--;
            fetchData();
        }
        console.log("Prev Page: " + page);
    });

    // handling the next-btn
    $(".next-btn").on("click", function () {
        fetchData();
        if (page < total_page) {
            page++;
            fetchData();
        } else if (page == total_page) {
            console.log("最後一頁");
        }
        console.log("Next Page: " + page);
    });

    function fetchData() {
        $.ajax({
            url: "../controllers/page_handle.php",
            type: "GET",
            data: {
                page: page,
                page_limit: page_limit
            },
            success: function (data) {
                total_record = data.totals;
                console.log(total_record);
                total_page = data.total_page;
                console.log(total_page);
                let str = '';
                for (i = 0; i < page_limit; i++) {
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
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
});