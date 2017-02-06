
(function() {
    var DOM = tinymce.DOM;
    function you_mce_success(sel) { return '<p class="success">'+sel+'</p>'; }
    tinymce.create('tinymce.plugins.YouSuccessMessage', {
        init : function(ed, url) {
 
            ed.addButton('yousuccessmessage', {
                title : 'Success message',
                image : url+'/../images/icons/check.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_success(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Success Message",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('yousuccessmessage', tinymce.plugins.YouSuccessMessage);
    
})();
