
// iosSwitcher / ativo
$('.ativo').click(function() {
    var route =  $(this).find('input').attr("data-route");

    $.ajax({
        type: "GET",
        url: route,
    });
    return false;
});

// iosSwitcher / ativo
$('.destaque').click(function() {
    var tabela =  $(this).find('input').attr("data-tabela");
    var id = $(this).find('input').attr("data-id");
    $.ajax({
        type: "POST",
        data: {tabela: tabela, id:id},
        url: "../public/ajax-destaque.php",
        dataType: "html"
    });
    return false;
});

(function(theme, $) {
    theme = theme || {};
    var instanceName = '__IOS7Switch';
    var PluginIOS7Switch = function($el) {
        return this.initialize($el);
    };

    PluginIOS7Switch.prototype = {
        initialize: function($el) {
            if ( $el.data( instanceName ) ) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .build();

            return this;
        },
        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },
        build: function() {
            var switcher = new Switch( this.$el.get(0) );

            $( switcher.el ).on( 'click', function( e ) {
                e.preventDefault();
                switcher.toggle();
            });

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginIOS7Switch: PluginIOS7Switch
    });

    // jquery plugin
    $.fn.themePluginIOS7Switch = function(opts) {
        return this.each(function() {
            var $this = $(this);
            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginIOS7Switch($this);
            }
        });
    }

}).apply(this, [ window.theme, jQuery ]);

(function( $ ) {
    'use strict';
    if ( typeof Switch !== 'undefined' && $.isFunction( Switch ) ) {
        $(function() {
            $('[data-plugin-ios-switch]').each(function() {
                var $this = $( this );
                $this.themePluginIOS7Switch();
            });
        });

    }
}).apply(this, [ jQuery ]);