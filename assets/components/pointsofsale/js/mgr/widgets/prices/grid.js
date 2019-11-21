pointsOfSale.grid.ProductPrices = function (config) {
    config = config || {};
    if (!config['product_id']) {
        return;
    }
    if (!config['id']) {
        config['id'] = 'pos-grid-product-prices';
    }
    config['actionPrefix'] = 'mgr/prices/';
    Ext.applyIf(config, {
        baseParams: {
            action: config['actionPrefix'] + 'getlist',
            sort: 'id',
            dir: 'DESC',
            product_id: config['product_id'],
        },
        multi_select: false,
        // pageSize: Math.round(MODx.config['default_per_page'] / 2),

        save_action: config['actionPrefix'] + 'update',
        save_callback: this.updateRow,
        autosave: true,
    });
    pointsOfSale.grid.ProductPrices.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.grid.ProductPrices, pointsOfSale.grid.Default, {
    getFields: function (config) {
        return [
            'id',
            'product_id',
            'country',
            'price',
        ];
    },

    getColumns: function (config) {
        return [{
            header: _('mel_grid_id'),
            dataIndex: 'id',
            width: 50,
            sortable: true,
            fixed: true,
            resizable: false,
            hidden: true,
        }, {
            header: _('pos_grid_country'),
            dataIndex: 'country',
            width: 150,
            sortable: false,
        }, {
            header: _('pos_grid_price'),
            dataIndex: 'price',
            width: 150,
            sortable: false,
            editor: {xtype: 'numberfield'},
        }];
    },

    getTopBar: function (config) {
        return ['->', this.getSearchField(config)];
    },

    /**
     *
     * @param response
     */
    updateRow: function (response) {
        this.refresh();

        console.log('updateRow this', this);
        console.log('updateRow response', response);
    },
});
Ext.reg('pos-grid-product-prices', pointsOfSale.grid.ProductPrices);