
(function() {
    var DOM = tinymce.DOM;
    function you_mce_intro(sel) { return '<p class="intro">'+sel+'</p>'; }
    tinymce.create('tinymce.plugins.YouIntro', {
        init : function(ed, url) {
 
            ed.addButton('youintro', {
                title : 'Intro text',
                image : url+'/../images/icons/intro.png',
                onclick : function() {
                  var sel = ed.selection.getContent();
                  if (!sel) sel = 'Insert your text here';
                  ed.execCommand(
                    'mceInsertContent',
                    false,
                    you_mce_intro(sel)
                  );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Intro Text",
                author : 'Design is Pure',
                authorurl : 'http://www.designispure.com/',
                infourl : 'http://www.designispure.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youintro', tinymce.plugins.YouIntro);
    
})();
