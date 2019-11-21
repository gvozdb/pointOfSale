var pointsOfSale = function (config) {
    config = config || {};
    pointsOfSale.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale, Ext.Component, {
    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    formpanel: {},
    combo: {},
    config: {},
    view: {},
    utils: {},
});
Ext.reg('pointsofsale', pointsOfSale);

pointsOfSale = new pointsOfSale();