'use strict';

window.$ = window.jQuery =  require('jquery');
window.inputmask =          require('jquery.inputmask');
window.validate =           require('jquery-validation');
window.gmaps =              require('gmaps');


$(document).ready(function () {

    // Input masking
    $('input[type="tel"]').inputmask({"mask": "+7(999)999-99-99", greedy: false});


    // Map
    var map = new gmaps({
        el: '#map',
        lat: 55.782198,
        lng: 37.588593,
        scrollwheel: false
    });
    map.addMarker({
        lat: 55.782198,
        lng: 37.588593,
        title: 'ООО "Администратор ОССП"',
        infoWindow: {
            content: '<p>"Администратор ОССП"</p> <p>Москва <br> метро Белорусская (кольцевая), Новолесной переулок, дом 5<p>'
        }
    });


    // Form validation
    var form = $("form");
    // $.validator.messages.required = '';
    form.each( function() {
        // _this = $(this);
        $(this).validate({
            errorClass: "-error",
            validClass: "-valid"
        });
    });

    // Form Ajax sending
    form.submit (function(event) {
        var _this = $(this);
        if (_this.valid())
        {
            $.ajax({
                type: _this.attr("method"),
                url: _this.attr("action"),
                data: _this.serialize(),
                success: function(data) {
                    console.log(data);
                    _this.find("button").text("Успешно");
                    _this
                        .find("button")
                        .prop('disabled', true);
                    _this[0].reset();
                    _this.find("div.form").css({'display': 'none'});
                    _this.find("p.success").css({'display': 'block'});
                }
            });
        }
        event.preventDefault();
    });

});