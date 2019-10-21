pointsOfSale.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_item_create'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/options/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('pointsofsale_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-item-window-create', pointsOfSale.window.CreateItem);


pointsOfSale.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_item_update'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/options/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('pointsofsale_item_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-item-window-update', pointsOfSale.window.UpdateItem);