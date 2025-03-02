$('#zila').change(function(){
$.get($(this).data('url'), {
        option: $(this).val()
    },
    function(data) {
        var subcat = $('#upazila');
        subcat.empty();
        subcat.append("<option value=''>-----</option>")
        $.each(data, function(index, element) {
            subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
        });
    });
});