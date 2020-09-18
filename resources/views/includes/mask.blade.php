<script>
    $.prototype.textMask = function(formatValue) {
        this.each(function(key,ele){
            var unformattedText = ele.originalText || ele.innerText;
            if(!ele.originalText) {
                ele.originalText = unformattedText;
            }
            var formattedText = '';
            var i = 0;
            var j = 0;
            while(i < formatValue.length) {
                var currentText = formatValue[i];
                var isNumber = !isNaN(parseFloat(currentText));

                if(isNumber) {
                    if(unformattedText[j]) {
                        formattedText += unformattedText[j];
                    }
                    j++
                }
                else {
                    formattedText += currentText;
                }
                i++;
            }
            ele.innerText = formattedText;
        })
    }
    if($('.masked_phone_us').inputmask) {
        $('.masked_phone_us').inputmask('(999) 999-9999', {
            removeMaskOnSubmit: true
        });
    }
    $('.masked_phone_us_text').textMask('(999) 999-9999');
</script>