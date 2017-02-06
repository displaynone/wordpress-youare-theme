
(function() {
    tinymce.create('tinymce.plugins.YouContactForm', {
        init : function(ed, url) {
            ed.addButton('youcontactform', {
                title : 'Contact Form',
                image : url+'/../images/icons/contact-form.png',
                onclick : function() {
                    idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
                    var email = prompt("Contact Form", "Add a valid e-mail address");
                    ed.execCommand('mceInsertContent', false, '[youcontactform email="'+email+'"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "YouAre Contact Form",
                author : 'CSS Mania',
                authorurl : 'http://www.cssmania.com/',
                infourl : 'http://www.cssmania.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youcontactform', tinymce.plugins.YouContactForm);
})();
