NiceSelect.bind(document.getElementById("a-select"), { placeholder: "Sort by" });
$(document).ready(function () {
    $("#a-select").change(function () {
        const sortCriterion = $(this).val();
        if (sortCriterion) {
            $.ajax({
                url: "order.php",
                data: { sort: sortCriterion },
                type: "POST",
                success: function (data) {
                    $(".mySwiper .swiper-wrapper").html(data);
                    swiper.update();
                },
            });
        } else {
            $(".mySwiper .swiper-wrapper").html("<p>Select a sorting criterion to see movies.</p>");
        }
    });
});