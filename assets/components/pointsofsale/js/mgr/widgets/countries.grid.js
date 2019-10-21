pointsOfSale.grid.Countries = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-grid-countries';
    }
    Ext.applyIf(config, {
        url: pointsOfSale.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/country/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateCountry(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'pointsofsale-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    pointsOfSale.grid.Countries.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(pointsOfSale.grid.Countries, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = pointsOfSale.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createCountry: function (btn, e) {
        var w = MODx.load({
            xtype: 'pointsofsale-country-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
    },

    updateCountry: function (btn, e, row) {
        if (typeof (row) != 'undefined') {
            this.menu.record = row.data;
        } else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/country/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pointsofsale-country-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeCountry: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('pointsofsale_countries_remove')
                : _('pointsofsale_country_remove'),
            text: ids.length > 1
                ? _('pointsofsale_countries_remove_confirm')
                : _('pointsofsale_country_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/country/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    disableCountry: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/country/disable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    enableCountry: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/country/enable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    getFields: function () {
        return ['id', 'country', 'currency', 'position', 'code', 'active', 'default', 'show_in_switcher','actions'];
    },

    getColumns: function () {
        return [{
            header: _('pointsofsale_country_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('pointsofsale_country_country'),
            dataIndex: 'country',
            sortable: true,
            width: 230,
        }, {
            header: _('pointsofsale_country_currency'),
            dataIndex: 'currency',
            sortable: false,
            width: 100,
        }, {
            header: _('pointsofsale_country_position'),
            dataIndex: 'position',
            sortable: false,
            width:100,
        }, {
            header: _('pointsofsale_country_code'),
            dataIndex: 'code',
            sortable: false,
            width: 100,
        }, {
            header: _('pointsofsale_country_default'),
            dataIndex: 'default',
            renderer: pointsOfSale.utils.renderBoolean,
            sortable: true,
            width: 70,
        }, {
            header: _('pointsofsale_country_show_in_switcher'),
            dataIndex: 'show_in_switcher',
            renderer: pointsOfSale.utils.renderBoolean,
            sortable: true,
            width: 70,
        }, {
            header: _('pointsofsale_country_active'),
            dataIndex: 'active',
            renderer: pointsOfSale.utils.renderBoolean,
            sortable: true,
            width: 70,
        }, {
            header: _('pointsofsale_grid_actions'),
            dataIndex: 'actions',
            renderer: pointsOfSale.utils.renderActions,
            sortable: false,
            width: 190,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('pointsofsale_country_create'),
            handler: this.createCountry,
            scope: this
        }, '->', {
            xtype: 'pointsofsale-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof (row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                } else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('pointsofsale-grid-countries', pointsOfSale.grid.Countries);
