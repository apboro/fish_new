(function($){
    $(document).ready(function(){
        $('.select2-menu').select2({
            ajax: {
                type: 'GET',
                url: '/admin/ajax.php',
                dataType: 'json',
                minimumInputLength: 2,
                delay: 250,
                placeholder: 'Искать по категории',
                data: function (params) {
                    var query = {
                        search: params.term,
                        action: 'list_categories',
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('.select2-products').select2({
            ajax: {
                type: 'GET',
                url: '/admin/ajax.php',
                dataType: 'json',
                minimumInputLength: 2,
                delay: 250,
                placeholder: 'Искать по товарам',
                data: function (params) {
                    var query = {
                        search: params.term,
                        action: 'list_products',
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    })
})(jQuery);