pointsOfSale.grid.Dealers = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pointsofsale-grid-dealers';
    }
    Ext.applyIf(config, {
        url: pointsOfSale.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/dealer/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateDealer(grid, e, row);
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
    pointsOfSale.grid.Dealers.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(pointsOfSale.grid.Dealers, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = pointsOfSale.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createDealer: function (btn, e) {
        var w = MODx.load({
            xtype: 'pointsofsale-dealer-window-create',
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

    updateDealer: function (btn, e, row) {
        if (typeof (row) != 'undefined') {
            this.menu.record = row.data;
        } else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/dealer/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pointsofsale-dealer-window-update',
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

    removeDealer: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('pointsofsale_dealers_remove')
                : _('pointsofsale_dealer_remove'),
            text: ids.length > 1
                ? _('pointsofsale_dealers_remove_confirm')
                : _('pointsofsale_dealer_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/dealer/remove',
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

    disableDealer: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/dealer/disable',
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

    enableDealer: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/dealer/enable',
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
        return ['id', 'country', 'city', 'distributor', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('pointsofsale_dealer_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('pointsofsale_dealer_country'),
            dataIndex: 'country',
            sortable: true,
            width: 200,
        }, {
            header: _('pointsofsale_dealer_city'),
            dataIndex: 'city',
            sortable: false,
            width: 250,
        }, {
            header: _('pointsofsale_dealer_distributor'),
            dataIndex: 'distributor',
            sortable: false,
            width: 250,
        }, {
            header: _('pointsofsale_dealer_active'),
            dataIndex: 'active',
            renderer: pointsOfSale.utils.renderBoolean,
            sortable: true,
            width: 100,
        }, {
            header: _('pointsofsale_grid_actions'),
            dataIndex: 'actions',
            renderer: pointsOfSale.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('pointsofsale_dealer_create'),
            handler: this.createDealer,
            scope: this
        },{
            xtype: 'pointsofsale-dealers-excel-upload-form'
            , id: 'pointsofsale-dealers-excel-upload-form'
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
Ext.reg('pointsofsale-grid-dealers', pointsOfSale.grid.Dealers);


pointsOfSale.ExcelUploadForm = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        layout: 'form'
        , url: pointsOfSale.config.connector_url
        , baseParams: {
            action: 'mgr/dealer/upload'
        }
        , id: 'pointsofsale-dealer-upload-form'
        , keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
        , items: this.getFields(config)
        , listeners: {
            success: {
                fn: function () {
                    location.reload();
                }, scope: this
            }
        }
    });
    pointsOfSale.ExcelUploadForm.superclass.constructor.call(this, config);
};
Ext.extend(pointsOfSale.ExcelUploadForm, MODx.FormPanel, {
    getFields: function (config) {
        return [{
            layout: 'column'
            ,items: [
                {
                    name: 'file'
                    , xtype: 'modx-combo-browser'
                    , hideFiles: true
                    , source: MODx.config['pointsofsale_source'] || MODx.config.default_media_source
                    , id: 'pointsofsale-dealers-upload-input'
                    , emptyText: _('pointsofsale_upload_dealer')

                }, {
                    xtype: 'button'
                    , cls: 'primary-button'
                    , text: _('pointsofsale_dealers_upload_btn')
                    , id: 'pointsofsale-dealers-upload'
                    , listeners: {
                        click: {
                            fn: function () {
                                this.submit();
                            }, scope: this
                        },
                    }
                }
            ],
        }];
    },
});
Ext.reg('pointsofsale-dealers-excel-upload-form', pointsOfSale.ExcelUploadForm);
