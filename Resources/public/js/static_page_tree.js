"use strict";

var grossumStaticPageAdmin = grossumStaticPageAdmin || {};

grossumStaticPageAdmin.tree = function(context)
{
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
            maxLevels: context.tree_depth,
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false,
            rootID: context.root_id
        })
        .on('sortupdate', function()
        {
            $.ajax({
                url: context.save_tree_url,
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
                        alert('Error');
                    }
                }
            });
        });
};