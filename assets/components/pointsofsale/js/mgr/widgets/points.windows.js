pointsOfSale.window.CreatePoint = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-point-window-create';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_point_create'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/point/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.CreatePoint.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.CreatePoint, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_retailer'),
            name: 'retailer',
            id: config.id + '-retailer',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_city'),
            name: 'city',
            id: config.id + '-city',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_post_code'),
            name: 'post_code',
            id: config.id + '-post_code',
            anchor: '99%'
        },{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_address_line_1'),
            name: 'address_line_1',
            id: config.id + '-address_line_1',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_address_line_2'),
            name: 'address_line_2',
            id: config.id + '-address_line_2',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_telephone'),
            name: 'telephone',
            id: config.id + '-telephone',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_website'),
            name: 'website',
            id: config.id + '-website',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_website_2'),
            name: 'website_2',
            id: config.id + '-website_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_contact_hours_1'),
            name: 'contact_hours_1',
            id: config.id + '-contact_hours_1',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_contact_hours_2'),
            name: 'contact_hours_2',
            id: config.id + '-contact_hours_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_lat'),
            name: 'lat',
            id: config.id + '-lat',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_lon'),
            name: 'lon',
            id: config.id + '-lon',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_point_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-point-window-create', pointsOfSale.window.CreatePoint);


pointsOfSale.window.UpdatePoint = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-point-window-update';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_point_update'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/point/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.UpdatePoint.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.UpdatePoint, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_retailer'),
            name: 'retailer',
            id: config.id + '-retailer',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_city'),
            name: 'city',
            id: config.id + '-city',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_post_code'),
            name: 'post_code',
            id: config.id + '-post_code',
            anchor: '99%'
        },{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_address_line_1'),
            name: 'address_line_1',
            id: config.id + '-address_line_1',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_address_line_2'),
            name: 'address_line_2',
            id: config.id + '-address_line_2',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_telephone'),
            name: 'telephone',
            id: config.id + '-telephone',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_website'),
            name: 'website',
            id: config.id + '-website',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_website_2'),
            name: 'website_2',
            id: config.id + '-website_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_contact_hours_1'),
            name: 'contact_hours_1',
            id: config.id + '-contact_hours_1',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_contact_hours_2'),
            name: 'contact_hours_2',
            id: config.id + '-contact_hours_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_lat'),
            name: 'lat',
            id: config.id + '-lat',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_point_lon'),
            name: 'lon',
            id: config.id + '-lon',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_point_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-point-window-update', pointsOfSale.window.UpdatePoint);