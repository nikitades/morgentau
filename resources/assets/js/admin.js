var ADMIN = function () {
    var sortable = {
        selector: '.entity-sortable',
        pageSelector: '.entity-sortable-page',
        defaultOptions: {},
        init: function () {
            $(sortable.selector).each($.proxy(function (i, el) {
                this.create(el);
            }, this));
        },
        gid: function () {
            return (Math.random() + 1).toString(36).substring(7);
        },
        get_id: function (item) {
            return $(item).data('entity-id') || $(item).attr('id') || false;
        },
        create: function (el) {
            $(el).parent().attr('id', $(el).parent().attr('id') ? $(el).parent().attr('id') : this.gid())
            $(el).nestedSortable(this.getOptions(el));
        },
        getOptions: function (el) {
            switch (true) {
                case $(el).is('.entity-sortable-page'):
                    return $.extend(this.defaultOptions, {
                        protectRoot: true,
                        isAllowed: this.isAllowed,
                        listType: 'ul',
                        handle: 'div',
                        items: 'li',
                        toleranceElement: '> div',
                        isTree: true,
                        disableParentChange: false,
                        listClasses: 'list-group secondary',
                        relocate: this.pagesRelocate
                    });
                default:
                    return $.extend(this.defaultOptions, {
                        disableNestingClass: 'list-group-item',
                        protectRoot: false,
                        isAllowed: this.isAllowed,
                        listType: 'ul',
                        handle: 'div',
                        items: 'li',
                        toleranceElement: '> div',
                        disableParentChange: true,
                        listClasses: 'list-group secondary col-xs-12',
                        relocate: this.relocate
                    });
            }
        },
        isAllowed: function (placeholder, placeholderParent, currentItem) {
            // console.info($(placeholderParent).is('.entity-sortable'));
            return true;
        },
        relocate: function (e) {
            var order = [];
            $(e.target).children().each(function (i, el) {
                order.push($(el).data('entityId'));
            });
            m.ajax({
                url: '/ajax/admin/reorder/',
                to: $(e.target).data('to'),
                data: {
                    entity: $(e.target).data('entity') || false,
                    order: order
                },
                user_success: function () {
                    sortable.create($(e.target).parent().find(sortable.selector));
                }
            });
        },
        pagesRelocate: function (e) {
            var order = [];
            order = sortable.findChildren(order, $(e.target));
            m.ajax({
                url: '/ajax/pages/dropSort/',
                to: $(e.target).parent(),
                data: {
                    order: order
                },
                user_success: function () {
                    sortable.create($(e.target).parent().find(sortable.selector));
                }
            });
            console.info('yippika-yay!');
        },
        findChildren: function (order, item) {
            $(item).find('.sortable-item').each($.proxy(function (i, el) {
                order[$(el).data('entityId')] = {
                    n: $(el).index(),
                    id: $(el).data('entityId'),
                    parent: $(el).parent().parent().data('entityId')
                };
            }, this));
            return order;
        }
    };

    var init = function () {
        sortable.init();
    };

    return {
        init: init
    }
};

$(ADMIN().init);