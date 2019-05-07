$(document).ready(function () {

    $(document).on('click', '#show-rates', function (e) {
        e.preventDefault();
        $('#convert-data').html('');
        var form = $('#exchange-form');
        var url = $(this).data('url');

        if (form.find('.has-error').length > 0){
            return
        };
        $.ajax(
            {
                url: url,
                type: "POST",
                data: form.serialize(),
                success: function(data) {
                    $('#convert-data').html(data);
                }
            }
        );
    })
});