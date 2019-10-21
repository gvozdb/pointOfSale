pointsOfSale.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'pointsofsale-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('pointsofsale') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('pointsofsale_points'),
                layout: 'anchor',
                items: [{
                    html: _('pointsofsale_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pointsofsale-grid-points',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('pointsofsale_distributors'),
                layout: 'anchor',
                items: [{
                    html: _('pointsofsale_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pointsofsale-grid-distributors',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('pointsofsale_service_centers'),
                layout: 'anchor',
                items: [{
                    html: _('pointsofsale_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pointsofsale-grid-service_centers',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('pointsofsale_dealers'),
                layout: 'anchor',
                items: [{
                    html: _('pointsofsale_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pointsofsale-grid-dealers',
                    cls: 'main-wrapper',
                }]
            },
                {
                    title: _('pointsofsale_countries'),
                    layout: 'anchor',
                    items: [{
                        html: _('pointsofsale_intro_msg'),
                        cls: 'panel-desc',
                    }, {
                        xtype: 'pointsofsale-grid-countries',
                        cls: 'main-wrapper',
                    }]
                },]
        }]
    });
    pointsOfSale.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.panel.Home, MODx.Panel);
Ext.reg('pointsofsale-panel-home', pointsOfSale.panel.Home);
