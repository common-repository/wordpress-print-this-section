(function() {
    tinymce.create('tinymce.plugins.printthis', {

        init : function(ed, url){
            ed.addButton('printthis', {
                title : 'Insert Print This',
                image : url + "/images/print.png",
                onclick : function() {
                    ed.selection.setContent('[print_this]' + ed.selection.getContent() + '[/print_this]');
                }
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Print This Section Shortcode",
                author : "Scott Hair",
                authorurl : 'http://twodeuces.com',
                infourl : 'http://twodeuces.com',
                version : "2.0.1"
            };
        }
    });

    tinymce.PluginManager.add('printthis', tinymce.plugins.printthis);
})();
