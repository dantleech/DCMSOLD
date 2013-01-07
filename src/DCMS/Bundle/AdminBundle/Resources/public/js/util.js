(function($) {
    $.confirm = function(message) {
        return confirm(message);
    }

    $.fn.dcmsFancyForm = function (options) {
        $this = this;
        var element = $(this);
        var options = $.extend({
            'get_url': null,
            'post_url': null,
            'submit_button_id': null,
            'updating_message': 'Updating',
            'wrapper_id': null,
            'activate_anchor': null
        }, options);

        var wrapperEl = $('#' + options.wrapper_id);
        var anchorEl = $('#' + options.activate_anchor);

        function _create() {
            $(anchorEl).bind('click', function() {
                $.ajax({
                    type: 'get',
                    url: options.get_url,
                    success: function (resp, status, xhr) {
                        wrapperEl.html(resp);
                        init_create_template_form();
                    }
                });
                // init_create_template_form();
                $(wrapperEl).reveal();
            });
        }

        function init_create_template_form() {
            $('#' + options.submit_button_id).bind('click', function () {
                $(wrapperEl).mask('{% trans %}Updating{% endtrans %}');
                var data = $(wrapperEl.find('form')).serialize();

                $.ajax({
                    type: 'post',
                    url: options.post_url,
                    data: data,
                    success: function (resp, status, xhr) {
                        $(wrapperEl).html(resp);
                        init_create_template_form();
                        $(wrapperEl).unmask();
                    },
                    error: function (resp, message, xhr) {
                        $(wrapperEl).html(resp.responseText);
                        $(wrapperEl).unmask();
                    },
                });

                return false;
            });

            $('#' + options.cancel_button_id).bind('click', function () {
                $(wrapperEl).trigger('reveal:close');
                wrapperEl.html('');
            });
        }

        _create();
    }
}) (jQuery)
