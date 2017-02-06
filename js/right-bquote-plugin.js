
(function() {
    var DOM = tinymce.DOM;
    function you_mce_right_bquote(sel) { return '<blockquote class="right">'+sel+'</blockquote>'; }
    tinymce.create('tinymce.plugins.YouRightBlockquote', {
        init : function(ed, url) {
 
            ed.addButton('yourightbquote', {
                title : 'Right Blockquote',
                image : url+'/../images/icons/rblock.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_right_bquote(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Right Blockqoute",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('yourightbquote', tinymce.plugins.YouRightBlockquote);
    
})();
