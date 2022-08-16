<script type="text/javascript" src="/jscript/jquery/jquery.js"></script>
<script type="text/javascript" src="/jscript/jquery/jquery.inputmask.bundle.min.js?v=3"> </script>
<script type="text/javascript">
jQuery(function($) {
        $("input[name='telephone']").mask("+r (000) 000-00-00", {
            translation: {
                'r': {
                    pattern: /[78]/,
                    optional: true
                }
            },
            onKeyPress: function (cep, e, field, options) {
                var length = cep.length;
                var masks = ['+7 (000) 000-00-00', '0 (000) 000-00-00', "+r (000) 000-00-00"];
                if (length > 1) {
                    if (cep[0] == '+' && cep[1] == '8') {
                        $("input[name='telephone']").mask(masks[1], options);
                    } else if (cep[0] == '+' && cep[1] == ' ') {
                        $("input[name='telephone']").mask(masks[0], options);
                    }
                } else {
                    $("input[name='telephone']").mask(masks[2], options);
                }
            }
            ,
            placeholder: "+7 (___) ___-__-__"
        });
        $("input[name='fax']").mask("+r (000) 000-00-00", {
            translation: {
                'r': {
                    pattern: /[78]/,
                    optional: true
                }
            },
            onKeyPress: function (cep, e, field, options) {
                var length = cep.length;
                var masks = ['+7 (000) 000-00-00', '0 (000) 000-00-00', "+r (000) 000-00-00"];
                if (length > 1) {
                    if (cep[0] == '+' && cep[1] == '8') {
                        $("input[name='fax']").mask(masks[1], options);
                    } else if (cep[0] == '+' && cep[1] == ' ') {
                        $("input[name='fax']").mask(masks[0], options);
                    }
                } else {
                    $("input[name='fax']").mask(masks[2], options);
                }
            }
            ,
            placeholder: "+7 (___) ___-__-__"
        });
    });
</script>
