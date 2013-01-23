(function($) {
    $.fn.phpcrBrowser = function( method ) {
        var options = {
            path_get_children: null,
            path_update_node: null,
            class: {
                expand_icon: 'icon-plus',
                collapse_icon: 'icon-minus',
                folder_closed_icon: 'icon-folder-close',
                folder_open_icon: 'icon-folder-open',
                property_icon: 'icon-flag',
            },
        }

        var methods = {
            'init': function (givenOptions) {
                var rootAr = {
                    id: '/',
                    name: 'root',
                    properties: [],
                    children: []
                }
                rootEl = methods.renderNode(rootAr);
                this.append(rootEl);
                options = $.extend(options, givenOptions)
                methods.refresh();
            },

            'getChildren': function (id) {
                var children = $.ajax({
                    type: 'get',
                    data: {
                        path: id
                    },
                    url: options.path_get_children,
                    dataType: 'json',
                    success: function (data) {
                        methods.appendChildrenToNode(id, data)
                        methods.refresh();
                    }
                })
            },

            'appendChildrenToNode': function (nodeId, children) {
                var nodeEl = $('.phpcrNode[phpcrId="' + nodeId + '"]');
                ulEl = nodeEl.find('ul');
                ulEl.addClass(options.class.ul)
                $.each(children, function (name, child) {
                    var liEl = methods.renderNode(child);
                    ulEl.append(liEl);
                });
                nodeEl.append(ulEl);
            },

            'refresh': function () {

                // toggle expansion
                $('.toggleexpand').unbind('click').bind('click', function () {
                    var nodeEl = $(this).closest('.phpcrNode');

                    if (nodeEl.attr('_state') == 'expanded') {
                        $('.phpcrNode[phpcrId="' + nodeEl.attr('phpcrId') + '"]').find('.phpcrNode').remove();
                        nodeEl.attr('_state', 'collapsed');
                        nodeEl.find('ul').first().hide();
                        methods.refresh();
                    } else {
                        methods.getChildren(nodeEl.attr('phpcrId'));
                        nodeEl.attr('_state', 'expanded');
                        nodeEl.find('ul').first().show();
                        methods.refresh();
                    }

                    return false;
                });

                // update the icons
                $('.phpcrNode[_state="expanded"]').each(function () {
                    $(this).find('i').first()
                        .removeClass(options.class.expand_icon)
                        .addClass(options.class.collapse_icon);
                });
                $('.phpcrNode[_state="collapsed"]').each(function () {
                    $(this).find('i').first()
                        .removeClass(options.class.collapse_icon)
                        .addClass(options.class.expand_icon);
                });
            },

            'renderNode': function (nodeAr) {
                var nodeEl = $('<li class="phpcrNode" _state="collapsed"/>');
                nodeEl.attr('phpcrName', nodeAr.name);
                nodeEl.attr('phpcrId', nodeAr.id);
                methods.renderRow(nodeEl, options.class.folder_closed_icon, nodeAr.name, '', '', true);

                var childrenEl = $('<ul class="children"/>');
                childrenEl.addClass(options.class.ul)
                $.each(nodeAr.properties, function (propName, prop) {
                    var propEl = $('<li class="property"/>');
                    propEl.attr('phpcrName', propName);
                    propEl.attr('phpcrValue', prop.value);
                    propEl.attr('phpcrType', prop.type);

                    methods.renderRow(propEl, options.class.property_icon, propName, prop.value, prop.type, false);
                    childrenEl.append(propEl);
                });
                nodeEl.append(childrenEl);

                return nodeEl;
            },

            'renderRow': function (rowEl, icon, name, value, type, hasChildren) {
                var expandEl = $('<a class="toggleexpand" href="#"><i></i></a>');
                var iconEl = $('<i/>');
                var nameEl = $('<div class="phpcrName"/>')
                var valueEl = $('<div class="phpcrValue"/>')
                var typeEl = $('<div class="phpcrType"/>')

                iconEl.addClass(icon);
                nameEl.html('&nbsp;' + name);
                valueEl.html(value);
                typeEl.html(type);
                nameEl.prepend(iconEl);
                nameEl.prepend(expandEl);

                rowEl
                    .append(nameEl)
                    .append(valueEl)
                    .append(typeEl);
            }
        }

        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
        }

    };

}) (jQuery)
