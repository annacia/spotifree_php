/*
    Generic Modal
    -------------
    Originalmente por: Diego Marques

    Exemplo de utilização:

    var modal = new modal({
        title: 'Nome do Produto',
        body: '<p>Produto</p>',
        buttons: [
            {
                '<button class="modal-button">OK 1</button>': {
                    'click': function() { alert('Teste 1'); }
                },
                '<button class="modal-button">OK 2</button>': {
                    'click': function() { alert('Teste 2'); }
                }
            },
            '<a href="javascript:void(0);" class="modal-button modal-button-clean modal-close"><i class="fa fa-times"></i> Fechar</a>'
        ]
    });
    modal.open();

    modal.close();
    */

    function Modal(options) {
        var self = this;

        options = $.extend({
            id: null, // <string>
            class: null, // <string>
            title: null, // <string> | <dom object>
            body: null, // <string> | <dom object>
            size: null, // <string 'small' | 'big'>
            style: null, // <string (css)>
            buttons: null, // <string> | [ { <string>: { <event>: <function> } } | <string> ]
            closeButton: true, // <bool>
            closeOnOuterClick: true, // <bool>
            afterOpen: null, // <function>
            afterClose: null, // <function>
            closeAfter: null // <int>
        }, options);

        // Create the default html
        this.$ = $(
            '<div' + (options.id ? ' id="' + options.id + '"' : '') + ' class="modal modal-generic' + (options.size ? ' modal-' + options.size : '') + (options.class ? ' ' + options.class : '') + '">' +
                '<div class="modal-main container" ' + (options.style ? ' style="' + options.style + '"' : '') + '>' +
                    (options.closeButton ? '<a class="modal-close" href="javascript:void(0);" title="Fechar"><i class="fas fa-times"></i></a>' : '') +
                    (options.title ? '<div class="modal-head"><h2 class="title-modal"></h2></div>' : '') +
                    (options.body ? '<div class="modal-body"></div>' : '') +
                    (options.buttons !== null && ((options.buttons.constructor === Array && options.buttons.length > 0) || typeof options.buttons == 'string') ? '<div class="modal-foot"></div>' : '') +
                '</div>' +
                '<div class="modal-overlay' + (options.closeOnOuterClick ? ' modal-close' : '') + '"></div>' +
            '</div>'
        );

        // Append the title
        if(options.title)
            this.$.find('.modal-head h2').append(options.title);

        // Append the body
        if(options.body)
            this.$.find('.modal-body').append(options.body);

        // Close after time
        if(options.closeAfter){
            setTimeout(function(){
                self.close();
            }, options.closeAfter);
        }

        // Append the buttons
        if(options.buttons !== null) {
            if(options.buttons.constructor === Array && options.buttons.length > 0) {
                $.each(options.buttons, function(key, value) {
                    if(typeof value == 'object') {
                        $.each(value, function(key, value) {
                            var $button = $(key);
                            $.each(value, function(key, value) {
                                $button.on(key, value);
                            });
                            self.$.find('.modal-foot').append($button);
                        });
                    } else {
                        self.$.find('.modal-foot').append(value);
                    }
                });
            } else {
                self.$.find('.modal-foot').append(options.buttons);
            }
        }

        // Open the modal
        this.open = function() {
            var windowWidth = $(window).outerWidth();
            $('body').addClass('modal-open');
            $('body').css('margin-right', ($(window).outerWidth() - windowWidth) + 'px');

            if(typeof options.afterOpen == 'function')
                options.afterOpen();
            
            return self;
        }
        
        // Close the modal
        this.close = function() {
            self.$.addClass('modal-closing');
            setTimeout(function() {
                $('body').removeClass('modal-open');
                $('body').css('margin-right', 0);
                self.$.remove();

                if(typeof options.afterClose == 'function')
                    options.afterClose();
            }, 350);
        }

        // Append modal to body
        this.$.appendTo('body');

        // Events
        this.$.find('.modal-close').on('click', self.close);
    }
