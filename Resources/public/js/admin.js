$(function(){
    $('ol.sortable').on('sortupdate', function() {
        $.ajax({
            url: Routing.generate('admin_grossum_staticpage_staticpage_save-tree'),
            type: 'POST',
            async:false,
            data: {
                tree: $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0})
            },
            dataType: 'json',
            cache: false,
            success: function(response)
            {
                if (response.result == false) {
                    alert('Error')
                }
            }
        });
    });
});