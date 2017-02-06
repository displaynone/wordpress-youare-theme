
(function() {
    var DOM = tinymce.DOM;
    function you_mce_3cols(sel) { return '<div class="fourcol block_bottom">'+sel+'</div><div class="fourcol block_bottom">'+sel+'</div><div class="fourcol block_bottom last">'+sel+'</div>'; }
    tinymce.create('tinymce.plugins.You3Cols', {
        init : function(ed, url) {
 
            ed.addButton('you3cols', {
                title : '3 columns',
                image : url+'/../images/icons/3cols.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_3cols(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre 3 Columns",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('you3cols', tinymce.plugins.You3Cols);
    
})();
