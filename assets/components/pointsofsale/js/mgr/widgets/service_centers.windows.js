pointsOfSale.window.CreateServiceCenter = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-service_center-window-create';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_service_center_create'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/service_center/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.CreateServiceCenter.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.CreateServiceCenter, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_distributor'),
            name: 'distributor',
            id: config.id + '-distributor',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_city'),
            name: 'city',
            id: config.id + '-city',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_post_code'),
            name: 'post_code',
            id: config.id + '-post_code',
            anchor: '99%'
        },{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_address_line_1'),
            name: 'address_line_1',
            id: config.id + '-address_line_1',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_address_line_2'),
            name: 'address_line_2',
            id: config.id + '-address_line_2',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_telephone'),
            name: 'telephone',
            id: config.id + '-telephone',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_website'),
            name: 'website',
            id: config.id + '-website',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_website_2'),
            name: 'website_2',
            id: config.id + '-website_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_contact_hours_1'),
            name: 'contact_hours_1',
            id: config.id + '-contact_hours_1',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_lat'),
            name: 'lat',
            id: config.id + '-lat',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_lon'),
            name: 'lon',
            id: config.id + '-lon',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_service_center_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-service_center-window-create', pointsOfSale.window.CreateServiceCenter);


pointsOfSale.window.UpdateServiceCenter = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-service_center-window-update';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_service_center_update'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/service_center/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.UpdateServiceCenter.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.UpdateServiceCenter, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_distributor'),
            name: 'distributor',
            id: config.id + '-distributor',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_city'),
            name: 'city',
            id: config.id + '-city',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_post_code'),
            name: 'post_code',
            id: config.id + '-post_code',
            anchor: '99%'
        },{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_address_line_1'),
            name: 'address_line_1',
            id: config.id + '-address_line_1',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_address_line_2'),
            name: 'address_line_2',
            id: config.id + '-address_line_2',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_telephone'),
            name: 'telephone',
            id: config.id + '-telephone',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_website'),
            name: 'website',
            id: config.id + '-website',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_website_2'),
            name: 'website_2',
            id: config.id + '-website_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_contact_hours_1'),
            name: 'contact_hours_1',
            id: config.id + '-contact_hours_1',
            anchor: '99%'
        },   {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_lat'),
            name: 'lat',
            id: config.id + '-lat',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_service_center_lon'),
            name: 'lon',
            id: config.id + '-lon',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_service_center_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-service_center-window-update', pointsOfSale.window.UpdateServiceCenter);