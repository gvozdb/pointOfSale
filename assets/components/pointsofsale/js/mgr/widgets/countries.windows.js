pointsOfSale.window.CreateCountry = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-country-window-create';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_country_create'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/country/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.CreateCountry.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.CreateCountry, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_country_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_country_currency'),
            name: 'currency',
            id: config.id + '-currency',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'pointsofsale-combo-position',
            fieldLabel: _('pointsofsale_country_position'),
            name: 'position',
            id: config.id + '-position',
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_country_default'),
            name: 'default',
            id: config.id + '-default',
            checked: true,
        },{
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_country_show_in_switcher'),
            name: 'show_in_switcher',
            id: config.id + '-show_in_switcher',
            checked: true,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_country_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-country-window-create', pointsOfSale.window.CreateCountry);


pointsOfSale.window.UpdateCountry = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-country-window-update';
    }
    Ext.applyIf(config, {
        title: _('pointsofsale_country_update'),
        width: 550,
        autoHeight: true,
        url: pointsOfSale.config.connector_url,
        action: 'mgr/country/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    pointsOfSale.window.UpdateCountry.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.window.UpdateCountry, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_country_country'),
            name: 'country',
            id: config.id + '-country',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_country_currency'),
            name: 'currency',
            id: config.id + '-currency',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'pointsofsale-combo-position',
            fieldLabel: _('pointsofsale_country_position'),
            name: 'position',
            id: config.id + '-position',
            anchor: '99%'
        },  {
            xtype: 'textfield',
            fieldLabel: _('pointsofsale_country_code'),
            name: 'code',
            id: config.id + '-code',
            anchor: '99%',
            allowBlank: false,
        },  {
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_country_default'),
            name: 'default',
            id: config.id + '-default',
            checked: true,
        },{
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_country_show_in_switcher'),
            name: 'show_in_switcher',
            id: config.id + '-show_in_switcher',
            checked: true,
        },{
            xtype: 'xcheckbox',
            boxLabel: _('pointsofsale_country_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('pointsofsale-country-window-update', pointsOfSale.window.UpdateCountry);


MODx.combo.position = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        store: new Ext.data.ArrayStore({
            fields: ['position'],
            data: [
                ['before'],
                ['after'],
            ]
        }),
        emptyText: _('pointsofsale_country_choose_position'),
        displayField: 'position',
        valueField: 'position',
        hiddenName: 'position',
        mode: 'local',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true,
        allowBlank: false,
        anchor: '99%'
    });
    MODx.combo.position.superclass.constructor.call(this, config);
};
Ext.extend(MODx.combo.position, MODx.combo.ComboBox, {});

Ext.reg('pointsofsale-combo-position', MODx.combo.position);