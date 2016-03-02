$(function(){
    "use strict";

    var $tree = $('.dd.box-content').nestable(
            {
                maxDepth: $('meta[name="grossum_static_page_tree_depth"]').attr('content')
            }
        );

    $tree
        .on('change', function(e) {
            $.ajax({
                url: Routing.generate('admin_grossum_staticpage_staticpage_save-tree'),
                type: 'POST',
                data: {
                    tree: $tree.nestable('serialize')
                },
                dataType: 'json',
                cache: false,
                success: function(response)
                {
                    console.log('[Grossum.StaticPage]', 'node position changed');
                }
            });
        });
});