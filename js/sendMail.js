$('form').submit(function (e) {
    e.preventDefault();
    var data = $('form').serializeArray();
    $.ajax({
        type: "POST",
        url: 'mail',
        data: data,
        success: function(data, textStatus, jqXHR) {
            alert(data);
        },
        dataType: "json"});}); 