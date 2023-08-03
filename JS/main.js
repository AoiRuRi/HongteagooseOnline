    //會員登入彈窗關閉按鈕
    $(document).ready(function() {

        $(".btn-close").click(function() {
            $("#login-modal").modal("hide");
        });
    });
    //回到最頂按鈕
    $(document).ready(function() {

    $(".back-to-top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "500");
    });
});