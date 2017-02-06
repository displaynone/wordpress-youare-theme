
(function() {
    var DOM = tinymce.DOM;
    function you_mce_error(sel) { return '<p class="error">'+sel+'</p>'; }
    tinymce.create('tinymce.plugins.YouErrorMessage', {
        init : function(ed, url) {
 
            ed.addButton('youerrormessage', {
                title : 'Error message',
                image : url+'/../images/icons/error.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_error(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Error Message",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youerrormessage', tinymce.plugins.YouErrorMessage);
    
})();
