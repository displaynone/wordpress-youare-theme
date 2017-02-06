
(function() {
    var DOM = tinymce.DOM;
    
    var toggleButtons = function() {jQuery.each(['table', 'delete_table', 'delete_col', 'delete_row', 'col_after', 'col_before', 'row_after', 'row_before', 'row_props', 'cell_props', 'split_cells', 'merge_cells'], function(i, v) {
      jQuery('#content_'+v).toggle();
    });};

    tinymce.create('tinymce.plugins.YouTableToggle', {
        init : function(ed, url) {
            ed.addButton('youtabletoggle', {
                title : 'Table Buttons (Show/Hide)',
                image : url+'/../images/icons/toggle-table.png',
                onclick : function() {
                    toggleButtons();
                }
            });
            ed.onPostRender.add(function(){toggleButtons();});
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Table Show/Hide",
                author : 'CSS Mania',
                authorurl : 'http://www.cssmania.com/',
                infourl : 'http://www.cssmania.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youtabletoggle', tinymce.plugins.YouTableToggle);
    
})();
