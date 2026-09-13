<link rel="stylesheet" href="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<script src="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
$(function () {
    'use strict';

    if (!$.datepicker) {
        return;
    }

    $.datepicker.setDefaults({
        dateFormat: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        yearRange: 'c-100:c+10',
        showOtherMonths: true,
        selectOtherMonths: true
    });

    $('.js-datepicker').each(function () {
        var $input = $(this);
        var altField = $input.data('alt-field');
        var options = {};

        if (altField) {
            options.altField = altField;
            options.altFormat = 'yy-mm-dd';
        }

        if ($input.data('max-today')) {
            options.maxDate = 0;
        }

        $input.datepicker(options);

        if (altField) {
            $input.on('change keyup', function () {
                var val = $input.val();
                if (!val) {
                    $(altField).val('');
                    return;
                }
                try {
                    var parsed = $.datepicker.parseDate('dd-mm-yyyy', val);
                    $(altField).val(parsed ? $.datepicker.formatDate('yy-mm-dd', parsed) : '');
                } catch (e) {
                    /* incomplete manual typing */
                }
            });
        }
    });
});
</script>
