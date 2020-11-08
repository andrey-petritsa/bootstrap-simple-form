$('form').submit(function (e) {
    $('.alert').addClass('d-none');
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: "POST",
        url: 'mail/index.php',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data, textStatus, jqXHR) {
            try {
                data = $.parseJSON(data);
            }
            catch(e) {
                $('.error').removeClass('d-none');
                $('.error-message').html(data);
                return 0;
            }
            
            if('success' in data ) {
                $('.success').removeClass('d-none');
            }
            if('error' in data ) {
                $('.error').removeClass('d-none');
                $('.error-message').html(data['error']);
            }       
        },
        });}); 