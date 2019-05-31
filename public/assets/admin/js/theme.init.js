window.theme = {};

/*MENU*/
(function( $ ) {
    'use strict';
    var $items = $( '.nav-main > li.nav-parent' );
    function expand( li ) {
        li.children( 'ul.nav-children' ).slideDown( 'fast', function() {
            li.addClass( 'nav-expanded' );
            $(this).css( 'display', '' );
            ensureVisible( li );
        });
    }

    function collapse( li ) {
        li.children('ul.nav-children' ).slideUp( 'fast', function() {
            $(this).css( 'display', '' );
            li.removeClass( 'nav-expanded' );
        });
    }

    function ensureVisible( li ) {
        var scroller = li.offsetParent();
        if ( !scroller.get(0) ) {
            return false;
        }

        var top = li.position().top;
        if ( top < 0 ) {
            scroller.animate({
                scrollTop: scroller.scrollTop() + top
            }, 'fast');
        }
    }

    $items.on('click', function() {
        var prev = $( '.nav-main > li.nav-expanded' ),
            next = $( this );

        if ( prev.get( 0 ) !== next.get( 0 ) ) {
            collapse( prev );
            expand( next );
        } else {
            collapse( prev );
        }
    });

    $items.find('.nav-children a').on( 'click', function( ev ) {
        ev.stopPropagation();
    });

}).apply( this, [ jQuery ]);

// Skeleton
(function(theme, $) {

    'use strict';

    theme = theme || {};

    var $body		= $( 'body' ),
        $html		= $( 'html' ),
        $window		= $( window ),
        isAndroid	= navigator.userAgent.toLowerCase().indexOf('android') > -1;

    // mobile devices with fixed has a lot of issues when focus inputs and others...
    if ( typeof $.browser !== 'undefined' && $.browser.mobile && $html.hasClass('fixed') ) {
        $html.removeClass( 'fixed' ).addClass( 'scroll' );
    }

    var Skeleton = {

        options: {
            sidebars: {
                menu: '#content-menu',
                left: '#sidebar-left',
                right: '#sidebar-right'
            }
        },

        customScroll: ( !Modernizr.overflowscrolling && !isAndroid && $.fn.nanoScroller !== 'undefined'),

        initialize: function() {
            this
                .setVars()
                .build()
                .events();
        },

        setVars: function() {
            this.sidebars = {};

            this.sidebars.left = {
                $el: $( this.options.sidebars.left )
            };

            this.sidebars.right = {
                $el: $( this.options.sidebars.right ),
                isOpened: $html.hasClass( 'sidebar-right-opened' )
            };

            this.sidebars.menu = {
                $el: $( this.options.sidebars.menu ),
                isOpened: $html.hasClass( 'inner-menu-opened' )
            };

            return this;
        },

        build: function() {

            if ( typeof $.browser !== 'undefined' && $.browser.mobile ) {
                $html.addClass( 'mobile-device' );
            } else {
                $html.addClass( 'no-mobile-device' );
            }

            $html.addClass( 'custom-scroll' );
            if ( this.customScroll ) {
                this.buildSidebarLeft();
                this.buildContentMenu();
            }

            this.buildSidebarRight();

            return this;
        },

        events: function() {
            if ( this.customScroll ) {
                this.eventsSidebarLeft();
            }

            this.eventsSidebarRight();
            this.eventsContentMenu();

            if ( typeof $.browser !== 'undefined' && !this.customScroll && isAndroid ) {
                this.fixScroll();
            }

            return this;
        },

        fixScroll: function() {
            var _self = this;

            $window
                .on( 'sidebar-left-opened sidebar-right-toggle', function( e, data ) {
                    _self.preventBodyScrollToggle( data.added );
                });
        },

        buildSidebarLeft: function() {
            this.sidebars.left.$nano = this.sidebars.left.$el.find( '.nano' );

            this.sidebars.left.$nano.nanoScroller({
                alwaysVisible: true,
                preventPageScrolling: true
            });

            return this;
        },

        eventsSidebarLeft: function() {

            var $nano = this.sidebars.left.$nano;

            var updateNanoScroll = function() {
                if ( $.support.transition ) {
                    $nano.nanoScroller();
                    $nano
                        .one('bsTransitionEnd', updateNanoScroll)
                        .emulateTransitionEnd(150)
                } else {
                    updateNanoScroll();
                }
            };

            this.sidebars.left.$el
                .on( 'click', function() {
                    updateNanoScroll();
                });

            $nano
                .on( 'mouseenter', function() {
                    if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
                        $nano.nanoScroller();
                    }
                })
                .on( 'mouseleave', function() {
                    if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
                        $nano.nanoScroller();
                    }
                });

            return this;
        },

        buildSidebarRight: function() {
            this.sidebars.right.isOpened = $html.hasClass( 'sidebar-right-opened' );

            if ( this.customScroll ) {
                this.sidebars.right.$nano = this.sidebars.right.$el.find( '.nano' );

                this.sidebars.right.$nano.nanoScroller({
                    alwaysVisible: true,
                    preventPageScrolling: true
                });
            }

            return this;
        },

        eventsSidebarRight: function() {
            var _self = this;

            var open = function() {
                if ( _self.sidebars.right.isOpened ) {
                    return close();
                }

                _self.sidebars.right.isOpened = true;

                $html.addClass( 'sidebar-right-opened' );

                $window.trigger( 'sidebar-right-toggle', {
                    added: true,
                    removed: false
                });

                $html.on( 'click.close-right-sidebar', function(e) {
                    e.stopPropagation();
                    close(e);
                });
            };

            var close = function(e) {
                if ( !!e && !!e.target && ($(e.target).closest( '.sidebar-right' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
                    e.preventDefault();
                    return false;
                }

                $html.removeClass( 'sidebar-right-opened' );
                $html.off( 'click.close-right-sidebar' );

                $window.trigger( 'sidebar-right-toggle', {
                    added: false,
                    removed: true
                });

                _self.sidebars.right.isOpened = false;
            };

            var bind = function() {
                $('[data-open="sidebar-right"]').on('click', function(e) {
                    var $el = $(this);
                    e.stopPropagation();

                    if ( $el.is('a') )
                        e.preventDefault();

                    open();
                });
            };

            this.sidebars.right.$el.find( '.mobile-close' )
                .on( 'click', function( e ) {
                    e.preventDefault();
                    $html.trigger( 'click.close-right-sidebar' );
                });

            bind();

            return this;
        },

        buildContentMenu: function() {
            if ( !$html.hasClass( 'fixed' ) ) {
                return false;
            }

            this.sidebars.menu.$nano = this.sidebars.menu.$el.find( '.nano' );

            this.sidebars.menu.$nano.nanoScroller({
                alwaysVisible: true,
                preventPageScrolling: true
            });

            return this;
        },

        eventsContentMenu: function() {
            var _self = this;

            var open = function() {
                if ( _self.sidebars.menu.isOpened ) {
                    return close();
                }

                _self.sidebars.menu.isOpened = true;

                $html.addClass( 'inner-menu-opened' );

                $window.trigger( 'inner-menu-toggle', {
                    added: true,
                    removed: false
                });

                $html.on( 'click.close-inner-menu', function(e) {

                    close(e);
                });

            };

            var close = function(e) {
                if ( !!e && !!e.target && !$(e.target).closest( '.inner-menu-collapse' ).get(0) && ($(e.target).closest( '.inner-menu' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
                    return false;
                }

                e.stopPropagation();

                $html.removeClass( 'inner-menu-opened' );
                $html.off( 'click.close-inner-menu' );

                $window.trigger( 'inner-menu-toggle', {
                    added: false,
                    removed: true
                });

                _self.sidebars.menu.isOpened = false;
            };

            var bind = function() {
                $('[data-open="inner-menu"]').on('click', function(e) {
                    var $el = $(this);
                    e.stopPropagation();

                    if ( $el.is('a') )
                        e.preventDefault();

                    open();
                });
            };

            bind();

			/* Nano Scroll */
            if ( $html.hasClass( 'fixed' ) ) {
                var $nano = this.sidebars.menu.$nano;

                var updateNanoScroll = function() {
                    if ( $.support.transition ) {
                        $nano.nanoScroller();
                        $nano
                            .one('bsTransitionEnd', updateNanoScroll)
                            .emulateTransitionEnd(150)
                    } else {
                        updateNanoScroll();
                    }
                };

                this.sidebars.menu.$el
                    .on( 'click', function() {
                        updateNanoScroll();
                    });
            }

            return this;
        },

        preventBodyScrollToggle: function( shouldPrevent, $el ) {
            setTimeout(function() {
                if ( shouldPrevent ) {
                    $body
                        .data( 'scrollTop', $body.get(0).scrollTop )
                        .css({
                            position: 'fixed',
                            top: $body.get(0).scrollTop * -1
                        })
                } else {
                    $body
                        .css({
                            position: '',
                            top: ''
                        })
                        .scrollTop( $body.data( 'scrollTop' ) );
                }
            }, 150);
        }

    };

    // expose to scope
    $.extend(theme, {
        Skeleton: Skeleton
    });

}).apply(this, [ window.theme, jQuery ]);


// Base
(function(theme, $) {

    'use strict';

    theme = theme || {};

    theme.Skeleton.initialize();

}).apply(this, [ window.theme, jQuery ]);


// Masked Input
(function( $ ) {

    'use strict';

    if ( $.isFunction($.fn[ 'mask' ]) ) {

        $(function() {
            $('[data-plugin-masked-input]').each(function() {
                var $this = $( this ),
                    opts = {};

                var pluginOptions = $this.data('plugin-options');
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginMaskedInput(opts);
            });
        });

    }

}).apply(this, [ jQuery ]);


// Masked Input
(function(theme, $) {

    theme = theme || {};

    var instanceName = '__maskedInput';

    var PluginMaskedInput = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginMaskedInput.defaults = {
    };

    PluginMaskedInput.prototype = {
        initialize: function($el, opts) {
            if ( $el.data( instanceName ) ) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend( true, {}, PluginMaskedInput.defaults, opts );

            return this;
        },

        build: function() {
            this.$el.mask( this.$el.data('input-mask'), this.options );

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginMaskedInput: PluginMaskedInput
    });

    // jquery plugin
    $.fn.themePluginMaskedInput = function(opts) {
        return this.each(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginMaskedInput($this, opts);
            }

        });
    }

}).apply(this, [ window.theme, jQuery ]);

// Bootstrap Toggle
(function( $ ) {

    'use strict';

    var $window = $( window );

    var toggleClass = function( $el ) {
        if ( !!$el.data('toggleClassBinded') ) {
            return false;
        }

        var $target,
            className,
            eventName;

        $target = $( $el.attr('data-target') );
        className = $el.attr('data-toggle-class');
        eventName = $el.attr('data-fire-event');


        $el.on('click.toggleClass', function(e) {
            e.preventDefault();
            $target.toggleClass( className );

            var hasClass = $target.hasClass( className );

            if ( !!eventName ) {
                $window.trigger( eventName, {
                    added: hasClass,
                    removed: !hasClass
                });
            }
        });

        $el.data('toggleClassBinded', true);

        return true;
    };

    $(function() {
        $('[data-toggle-class][data-target]').each(function() {
            toggleClass( $(this) );
        });
    });

}).apply( this, [ jQuery ]);


$('.select-option-type').change(function(){
    var $this = $(this);
    $('.option-type').hide();
    $('.tipo-'+$this.val()).show();
});

$('.bannerTipoSelect').change(function(){
    var tipo = $(this).val();
    if(tipo == 'v'){
        $('.bannerVideo').fadeIn();
        $('.bannerImagem').hide();
    }else{
        $('.bannerImagem').fadeIn();
        $('.bannerVideo').hide();
    }
});
// iosSwitcher / ativo
$('#select-quadra').change(function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: "../../public/ajax-carrega-torre.php",
        data: {id: id},
        beforeSend: function () {
            $('#select-torre').html('<option value="">Carregando...</option>');
        },
        success: function (html) {
            $('#select-torre').html(html);
        }
    });
    return false;
});

$('.opcaoUnidade').change(function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: "../../public/ajax-carrega-tipo.php",
        data: {id: id},
        beforeSend: function () {
            $('.tipoUnidade').html('<option value="">Carregando...</option>');
        },
        success: function (html) {
            $('.tipoUnidade').html(html);
        }
    });
    return false;
});

$('.btnGalery').bind('click', function(){
   var type = $(this).attr('data-type');
   if(type == 'video'){
        $('.cadImage').hide();
       $('.btnVideo').hide();
        $('.cadVideo').fadeIn();
        $('.btnImage').fadeIn();
   }else{
       $('.cadVideo').hide();
       $('.btnImage').hide();
       $('.cadImage').fadeIn();
       $('.btnVideo').fadeIn();
   }

});

// Colorpicker
(function( $ ) {

    'use strict';

    if ( $.isFunction($.fn[ 'colorpicker' ]) ) {

        $(function() {
            $('[data-plugin-colorpicker]').each(function() {
                var $this = $( this ),
                    opts = {};

                var pluginOptions = $this.data('plugin-options');
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginColorPicker(opts);
            });
        });

    }

}).apply(this, [ jQuery ]);