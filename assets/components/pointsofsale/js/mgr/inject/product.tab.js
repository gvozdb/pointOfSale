Ext.override(MODx.panel.Resource, {
    posOriginals: {
        getFields: MODx.panel.Resource.prototype.getFields,
    },

    getFields: function (config) {
        var fields = this.posOriginals.getFields.call(this, config);
        fields.filter(function (row) {
            if (row['id'] === 'modx-resource-tabs') {
                row.items.push({
                    id: 'pos-tab-product-prices',
                    title: _('pos_tab_product_prices'),
                    layout: 'anchor',
                    items: [{
                        xtype: 'pos-grid-product-prices',
                        cls: 'main-wrapper',
                        product_id: pointsOfSale.config['product_id'],
                    }],
                    listeners: {
                        show: function () {
                            var grid = Ext.getCmp('pos-grid-product-prices');
                            !!grid && grid.refresh();
                        },
                    },
                });
            }
        });

        return fields;
    },
});

Ext.ComponentMgr.onAvailable('modx-resource-tabs', function () {
    var tabs = this;
    tabs.on('beforerender', function () {
        var is = tabs.items.items.filter(function (row) {
            return (row['id'] === 'pos-tab-product-prices' || row['id'] === 'pos-grid-product-prices');
        });

        if (is['length'] === 0) {
            tabs.add({
                id: 'pos-tab-product-prices',
                title: _('pos_tab_product_prices'),
                layout: 'anchor',
                items: [{
                    xtype: 'pos-grid-product-prices',
                    cls: 'main-wrapper',
                    product_id: pointsOfSale.config['product_id'],
                }],
                listeners: {
                    show: function () {
                        var grid = Ext.getCmp('pos-grid-product-prices');
                        !!grid && grid.refresh();
                    },
                },
            });
        }
    });
});