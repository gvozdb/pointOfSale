pointsOfSale.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'pointsofsale-panel-home',
            renderTo: 'pointsofsale-panel-home-div'
        }]
    });
    pointsOfSale.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.page.Home, MODx.Component);
Ext.reg('pointsofsale-page-home', pointsOfSale.page.Home);