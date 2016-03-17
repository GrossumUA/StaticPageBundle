$(function()
{
    "use strict";

    var $head = $(document.head);

    $('ol.sortable')
        .nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: $head.find('meta[name="grossum_static_page.static_page.tree_depth"]').attr('content'),
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false,
            rootID: $head.find('meta[name="grossum_static_page.entity.static_page.constant.root_id"]').attr('content')
        })
        .on('sortupdate', function()
        {
            $.ajax({
                url: $head.find('meta[name="grossum_static_page.route.save_tree"]').attr('content'),
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