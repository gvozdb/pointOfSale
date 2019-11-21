pointsOfSale.panel.Default = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        // id: Ext.id(),
        items: this.getItems(config),
        listeners: this.getListeners(config),

        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        autoHeight: true,
    });
    pointsOfSale.panel.Default.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.panel.Default, MODx.Panel, {
    getItems: function (config) {
        return [];
    },

    getListeners: function (config) {
        return {};
    },
});
Ext.reg('pos-panel-default', pointsOfSale.panel.Default);
