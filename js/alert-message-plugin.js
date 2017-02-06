
(function() {
    var DOM = tinymce.DOM;
    function you_mce_alert(sel) { return '<p class="alert">'+sel+'</p>'; }
    tinymce.create('tinymce.plugins.YouAlertMessage', {
        init : function(ed, url) {
 
            ed.addButton('youalertmessage', {
                title : 'Alert message',
                image : url+'/../images/icons/alert.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_alert(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Alert Message",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youalertmessage', tinymce.plugins.YouAlertMessage);
    
})();
