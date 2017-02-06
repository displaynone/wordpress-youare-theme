
(function() {
    var DOM = tinymce.DOM;
    function you_mce_2cols(sel) { return '<div class="sixcol block_bottom">'+sel+'</div><div class="sixcol block_bottom last">'+sel+'</div>'; }
    tinymce.create('tinymce.plugins.You2Cols', {
        init : function(ed, url) {
 
            ed.addButton('you2cols', {
                title : '2 columns',
                image : url+'/../images/icons/2cols.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_2cols(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre 2 Columns",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('you2cols', tinymce.plugins.You2Cols);
    
})();
