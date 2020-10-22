$('#button, #button1').click(function (e) {
    $(".validate, .validate1").each(function () {
        var value = $(this).val();
        var fieldId = $(this).attr('id');
        var allowedZero = ['cleaning_fee', 'security_deposit'];
        var isAllowedZero = allowedZero.indexOf(fieldId) !== -1;
        var isValid = value && value.trim() && value != 0;
        if (isAllowedZero && value.trim() == 0) {
            isValid = true;
        }
        if (isValid) {
            $(this).css({
                "border": "2px solid green",
                "background": ""
            });
            if ($(this).is('select')) {
                $(this).next('.chosen-container').css({
                    "border": "2px solid green",
                    "background": ""
                })
            }
        } else {
            e.preventDefault();
            console.log('Error vallidating filed', this.name);
            $(this).css({
                "border": "1px solid red",
                "background": ""
            });
            if ($(this).is('select')) {
                $(this).next('.chosen-container').css({
                    "border": "1px solid red",
                    "background": ""
                })
            }
            try {
                $(window).scrollTop($(this).offset().top - 100);
            } catch (e) {
                console.log('Error while validate:', e);
            }
        }
    });
});
