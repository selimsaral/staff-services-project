$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var Counties = {
    getCounties: function (city_id) {
        $.ajax({
            url: '/admin/job/get-counties',
            type: 'POST',
            data: {city_id: city_id},
            success: function (response) {
                var county = $('select[name = "county_id"]');
                county.html(response);

                if (county.data('id') !== "") {
                    county.val(county.data('id'));
                }
            },
            error: function () {
                alert("İlçeler Yüklenirken Sorun Oluştu");
            }
        });
    }
}

$(document).ready(function () {

    var city = $('.city').val();
    if (typeof city !== "undefined" && city !== "") {
        Counties.getCounties(city);
    }

    $('.city').change(function () {
        Counties.getCounties($(this).val());
    });
});
