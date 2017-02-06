
(function() {
    var DOM = tinymce.DOM;
    tinymce.create('tinymce.plugins.YouExtraShortCodes', {
        init : function(ed, url) {
          
            ed.addButton('youextrashortcodes', {
                title : 'Extra Short Codes',
                image : url+'/../images/icons/extra-buttons.png',
                onclick : function() {
                  var t3 = ed.getParam('', 'toolbar3');
                  var id = ed.controlManager.get(t3).id;
                  if (DOM.isHidden(id)) {
                    Toggle_PDW = 0;
                    DOM.show(id);
                    jQuery.each(['table', 'delete_table', 'delete_col', 'delete_row', 'col_after', 'col_before', 'row_after', 'row_before', 'row_props', 'cell_props', 'split_cells', 'merge_cells'], function(i, v) {
                      jQuery('#content_'+v).hide();
                    });
                  } else {
                    Toggle_PDW = 1;
                    DOM.hide(id);
                  }
/*                  ed.windowManager.open({
                    file : url + '/extra-shortcodes-plugin.php',
                    width : 500,
                    height : 200,
                    inline : 1
                  }, {
                    plugin_url : url // Plugin absolute URL
                  });                
                  */
                }
            });
            ed.onPostRender.add(function(){
              var t3 = ed.getParam('', 'toolbar3');
              var id = ed.controlManager.get(t3).id;
              DOM.hide(id);
            });

        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Extra Short Codes",
                author : 'CSS Mania',
                authorurl : 'http://www.cssmania.com/',
                infourl : 'http://www.cssmania.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youextrashortcodes', tinymce.plugins.YouExtraShortCodes);
    
    
})();
