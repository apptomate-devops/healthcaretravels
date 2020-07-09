$('#button').click(function (e) {
            var isvalid = true;
            var checki=true;
            $(".validate").each(function () {
                if ($.trim($(this).val()) == '') {
                    isValid = false;
                    $(this).css({
                        "border": "1px solid red",
                        "background": ""
                    });
                    
                    if (isValid == false)
                        e.preventDefault();
                }
                else {
                    $(this).css({
                        "border": "2px solid green",
                        "background": ""
                    });
                    
                }
            });

        });

$('#button1').click(function (e) {
    var isvalid = true;
    var checki=true;
    $(".validate1").each(function () {
        if ($.trim($(this).val()) == '') {
            isValid = false;
            $(this).css({
                "border": "1px solid red",
                "background": ""
            });

            if (isValid == false)
                e.preventDefault();
        }
        else {
            $(this).css({
                "border": "2px solid green",
                "background": ""
            });

        }
    });

});