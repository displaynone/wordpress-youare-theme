
(function() {
    var DOM = tinymce.DOM;
    function you_mce_info(sel) { return '<p class="info">'+sel+'</p>'; }
    tinymce.create('tinymce.plugins.YouInfoMessage', {
        init : function(ed, url) {
 
            ed.addButton('youinfomessage', {
                title : 'Info message',
                image : url+'/../images/icons/info.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_info(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Info Message",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youinfomessage', tinymce.plugins.YouInfoMessage);
    
})();
