pointsOfSale.window.CreateDistributor = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-distributor-window-create';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_distributor_create'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/distributor/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.CreateDistributor.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.CreateDistributor, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_distributor'),
            name: 'distributor',
            id: config.id + '-distributor',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_city'),
            name: 'city',
            id: config.id + '-city',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_post_code'),
            name: 'post_code',
            id: config.id + '-post_code',
            anchor: '99%'
        },{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_address_line_1'),
            name: 'address_line_1',
            id: config.id + '-address_line_1',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_address_line_2'),
            name: 'address_line_2',
            id: config.id + '-address_line_2',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_telephone'),
            name: 'telephone',
            id: config.id + '-telephone',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_website'),
            name: 'website',
            id: config.id + '-website',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_website_2'),
            name: 'website_2',
            id: config.id + '-website_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_contact_hours_1'),
            name: 'contact_hours_1',
            id: config.id + '-contact_hours_1',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_lat'),
            name: 'lat',
            id: config.id + '-lat',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_lon'),
            name: 'lon',
            id: config.id + '-lon',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_distributor_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-distributor-window-create', pointsOfSale.window.CreateDistributor);


pointsOfSale.window.UpdateDistributor = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-distributor-window-update';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_distributor_update'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/distributor/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.UpdateDistributor.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.UpdateDistributor, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_distributor'),
            name: 'distributor',
            id: config.id + '-distributor',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_city'),
            name: 'city',
            id: config.id + '-city',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_post_code'),
            name: 'post_code',
            id: config.id + '-post_code',
            anchor: '99%'
        },{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_address_line_1'),
            name: 'address_line_1',
            id: config.id + '-address_line_1',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_address_line_2'),
            name: 'address_line_2',
            id: config.id + '-address_line_2',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_telephone'),
            name: 'telephone',
            id: config.id + '-telephone',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_website'),
            name: 'website',
            id: config.id + '-website',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_website_2'),
            name: 'website_2',
            id: config.id + '-website_2',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_contact_hours_1'),
            name: 'contact_hours_1',
            id: config.id + '-contact_hours_1',
            anchor: '99%'
        },   {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_lat'),
            name: 'lat',
            id: config.id + '-lat',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_distributor_lon'),
            name: 'lon',
            id: config.id + '-lon',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_distributor_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-distributor-window-update', pointsOfSale.window.UpdateDistributor);