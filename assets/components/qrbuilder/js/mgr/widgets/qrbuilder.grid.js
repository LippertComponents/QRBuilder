Qrbuilder.combo.RedirectType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
       //displayField: 'name'
        //,valueField: 'id'
        //,fields: ['id', 'name']
        store: ['301', '302']
        //,url: Testapp.config.connectorUrl
        ,baseParams: { action: '' ,combo: true }
        //,mode: 'local'
        ,editable: false
    });
    Qrbuilder.combo.RedirectType.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder.combo.RedirectType,MODx.combo.ComboBox);
Ext.reg('qrbuilder-combo-redirect-type', Qrbuilder.combo.RedirectType);

var activeContextKey = 'web';

Qrbuilder.combo.ContextKey = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'name'
        ,hiddenName: 'context_key'
        ,valueField: 'key'
        ,value: 'web'
        ,fields: ['key', 'name']
        ,url: Qrbuilder.config.connectorUrl
        ,baseParams: { action: 'mgr/contextkey/getList',combo: true }
        //,mode: 'local'
        ,editable: false
        ,cls: 'x-window-with-tabs'
    });
    Qrbuilder.combo.ContextKey.superclass.constructor.call(this,config);
};
//Ext.extend(MODx.combo.SlideStatus, MODx.combo.ComboBox);
Ext.extend(Qrbuilder.combo.ContextKey,MODx.combo.ComboBox);
Ext.reg('qrbuilder-combo-context-key', Qrbuilder.combo.ContextKey);

Qrbuilder.grid.Qrbuilder = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'qrbuilder-grid-qrbuilder'
        ,url: Qrbuilder.config.connectorUrl
        ,baseParams: { action: 'mgr/qrcode/getList', 'context_key': activeContextKey }
        ,save_action: 'mgr/qrcode/updateFromGrid'
        ,fields: [
            'id',
            'type',
            'name',
            'context_key',
            'description', 
            'destination_url',
            'hits',
            'override_url_input',
            'build_url_params', 
            'qr_link',
            'short_link',
            'use_ad_link', 
            'redirect_type', 
            'qr_png_path',
            'qr_svg_path',
            'active',
            'start_date',
            'use_end_date',
            'end_date',
            'create_date',
            'edit_date',
            'campaign_source',
            'campaign_medium',
            'campaign_term',
            'campaign_content',
            'campaign_name'
        ]
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 50
        },{
            header: _('qrbuilder.grid.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('qrbuilder.grid.qr_link')
            ,dataIndex: 'qr_link'
            ,sortable: true
            ,width: 200
            ,editor: { xtype: 'displayfield' }
        },{
            header: _('qrbuilder.grid.qr_png_path')
            //,tpl: this.templates.thumb
            ,renderer: function(value, cell) {
                return '<a href="'+Qrbuilder.config.assetsUrl+value+'" download="'+Qrbuilder.config.assetsUrl+value+'" >'+_('qrbuilder.grid.download_png')+'</a>';
            }
            ,dataIndex: 'qr_png_path'
            ,sortable: false
            ,width: 85 
            //,editor: { xtype: 'displayfield' }
        },{
            header: _('qrbuilder.grid.qr_svg_path')
            //,tpl: this.templates.thumb
            ,renderer: function(value, cell) {
                return '<a href="'+Qrbuilder.config.assetsUrl+value+'" download="'+Qrbuilder.config.assetsUrl+value+'" >'+_('qrbuilder.grid.download_svg')+'</a>';
            }
            ,dataIndex: 'qr_svg_path'
            ,sortable: false
            ,width: 85 
            //,editor: { xtype: 'displayfield' }
        },{
            header: _('qrbuilder.grid.description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 150
            ,editor: { xtype: 'textarea' }
        },{
            header: _('qrbuilder.grid.hits')
            ,dataIndex: 'hits'
            ,sortable: true
            ,width: 80
            ,editor: { xtype: 'textfield' }
        },{
            header: _('qrbuilder.grid.start_date')
            ,dataIndex: 'start_date'
            ,sortable: true
            ,width: 120
            ,format: MODx.config.manager_date_format
            ,dateFormat: MODx.config.manager_date_format
            ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
            ,editor: { 
                xtype: 'datefield'
                ,format: MODx.config.manager_date_format
            } // datefield
            ,xtype: 'datecolumn'
        },{
            header: _('qrbuilder.grid.end_date')
            ,dataIndex: 'end_date'
            ,sortable: true
            ,width: 120
            ,format: MODx.config.manager_date_format
            ,dateFormat: MODx.config.manager_date_format
            ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
            ,editor: { 
                xtype: 'datefield'
                ,format: MODx.config.manager_date_format
            } // datefield
            ,xtype: 'datecolumn'
        }]
        ,tbar: [{
            text: _('qrbuilder.qrcode_create')
            ,handler: this.createQrcode
        },'->'
        ,{
            xtype: 'qrbuilder-combo-context-key'
            ,name: 'qrbuilder_context_key'
            ,id: 'qrbuilder-context-filter'
            ,width: 200
            ,allowBlank: false
            ,listeners: {
                'select': { fn:this.filterQRCodes, scope:this }
                ,'change': { fn: this.filterQRCodes, scope: this }
            }
        },{
            xtype: 'textfield'
            ,id: 'qrbuilder-search-filter'
            ,emptyText: _('qrbuilder.search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }]
    });
    Qrbuilder.grid.Qrbuilder.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder.grid.Qrbuilder,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        this.getStore().setBaseParam('context_key', activeContextKey);
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterQRCodes: function(cb,nv,ov) {
        activeContextKey = cb.getValue();
        this.getStore().setBaseParam('context_key', activeContextKey);
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
            text: _('qrbuilder.qrcode_update')
            ,handler: this.updateQrcode
        },'-',{
            text: _('qrbuilder.qrcode_remove')
            ,handler: this.removeQrcode
        }];
    }
    ,createQrcode: function(btn,e) {
        if (!this.CreateQrcodeWindow) {
            this.CreateQrcodeWindow = MODx.load({
                xtype: 'qrbuilder-window-qrcode-create'
                //,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        var defaultData = {
            start_date: Qrbuilder.Util.Today 
            ,end_date: Qrbuilder.Util.Enddate
            ,redirect_type: '301'
            ,override_url_input: '0'
            ,use_end_date: '0'
            ,use_ad_link: '0'
        };
        
        this.CreateQrcodeWindow.setValues(defaultData);
        
        this.CreateQrcodeWindow.show(e.target);
        
    }
    ,updateQrcode: function(btn,e) {
        
        myQRCodePNGImageUrl = Qrbuilder.config.assetsUrl+this.menu.record.qr_png_path;
        myQRCodeSVGImageUrl = Qrbuilder.config.assetsUrl+this.menu.record.qr_svg_path;
        
        if (!this.updateQrcodeWindow) {
            this.updateQrcodeWindow = MODx.load({
                xtype: 'qrbuilder-window-qrcode-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateQrcodeWindow.setValues(this.menu.record);
        this.updateQrcodeWindow.show(e.target);
        
        var PNGImagePath = Ext.select('#pngQRImagePath');
        PNGImagePath.set({
            src: myQRCodePNGImageUrl
        });
        
        var SVGImagePath = Ext.select('#svgQRImagePath');
        SVGImagePath.set({
            src: myQRCodeSVGImageUrl
        });
        
        var PNGLink = Ext.select('#pngQRImageA');
        PNGLink.set({
            href: myQRCodePNGImageUrl,
            download: myQRCodePNGImageUrl
        });
        
        var SVGLink = Ext.select('#svgQRImageA');
        SVGLink.set({
            href: myQRCodeSVGImageUrl,
            download: myQRCodeSVGImageUrl
        });
    }

    ,removeQrcode: function() {
        MODx.msg.confirm({
            title: _('qrbuilder.qrcode_remove')
            ,text: _('qrbuilder.qrcode_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/qrcode/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('qrbuilder-grid-qrbuilder',Qrbuilder.grid.Qrbuilder);

/**
 * Form Tab Objects 
 */

var QrbuilderBasicTab = {
        title: _('qrbuilder.qrcode.tab_basic')
        ,cls: 'modx-panel'
        ,border: false
        ,defaults: { autoHeight: true }
        ,items:[{
                xtype: 'hidden'
                ,name: 'id'
            },
            {
                html: '<p id="qrcodeCreateDescription">'+_('qrbuilder.qrcode.tab_basic_desc')+'</p>'
                ,border: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('qrbuilder.qrcode.name')
                ,name: 'name'
                ,anchor: '100%'
            },{ // # 3
                xtype: 'qrbuilder-combo-context-key'
                ,fieldLabel: _('qrbuilder.qrcode.context_key')
                //,boxLabel: _('qrbuilder.qrcode.?')
                ,inputValue: activeContextKey
                ,renderer: 'name'
                ,name: 'context_key'
                ,width: 300
            },{
                xtype: 'textarea'
                ,fieldLabel: _('qrbuilder.qrcode.description')
                ,name: 'description'
                ,anchor: '100%'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('qrbuilder.qrcode.destination_url')
                ,name: 'destination_url'
                ,anchor: '100%'
            },{
                xtype: 'datefield'
                ,fieldLabel: _('qrbuilder.qrcode.start_date')
                ,name: 'start_date'
                //,inputValue: Qrbuilder.Util.Today
                ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
                ,format: MODx.config.manager_date_format
                //,altFormats: MODx.config.manager_date_format
                ,editor: { xtype: 'datefield' } // datefield
                //,xtype: 'datecolumn'
                ,width: 150
            },{
                xtype: 'xcheckbox'
                ,fieldLabel: _('qrbuilder.qrcode.use_end_date')
                ,boxLabel: _('qrbuilder.qrcode.use_end_date_check')
                ,name: 'use_end_date'
                ,inputValue: '0'
            },{
                xtype: 'datefield'
                ,fieldLabel: _('qrbuilder.qrcode.end_date')
                ,name: 'end_date'
                //,inputValue: Qrbuilder.Util.Enddate
                ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
                ,format: MODx.config.manager_date_format
                //,altFormats: MODx.config.manager_date_format
                ,width: 150
            },{
                xtype: 'qrbuilder-combo-redirect-type'
                ,fieldLabel: _('qrbuilder.qrcode.redirect_type')
                //,boxLabel: _('qrbuilder.qrcode.?')
                ,inputValue: '301'
                ,renderer: 'value'
                ,name: 'redirect_type'
                ,width: 300
            }
        ]
    };

var QrbuilderParamsTab = {
    title: _('qrbuilder.qrcode.tab_params')
    ,border: false
    ,defaults: { autoHeight: true } 
    ,items: [{
            //id: 'album_description'
            html: '<p id="qrcodeParamsInstructions">'+_('qrbuilder.qrcode.tab_params_desc')+'</p>'
            ,border: false
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.campaign_source')
            ,name: 'campaign_source'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.campaign_medium')
            ,name: 'campaign_medium'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.campaign_term')
            ,name: 'campaign_term'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.campaign_content')
            ,name: 'campaign_content'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.campaign_name')
            ,name: 'campaign_name'
            ,anchor: '100%'
        }
    ]
};
var QrbuilderImageTab = {
    title: _('qrbuilder.qrcode.tab_image')
    ,border: false
    ,defaults: { autoHeight: true } 
    ,items: [{
            //id: 'album_description'
            html: '<p id="albumCreateImageInstructions">'+_('qrbuilder.qrcode.tab_image_desc')+'</p>'
            ,border: false
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.qr_link')
            ,name: 'qr_link'
            ,anchor: '100%'
            ,readOnly: true
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('qrbuilder.qrcode.use_ad_link')
            ,boxLabel: _('qrbuilder.qrcode.use_ad_link_check')
            ,name: 'use_ad_link'
            ,inputValue: '0'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('qrbuilder.qrcode.short_link')
            ,name: 'short_link'
            ,anchor: '100%'
        }, {
            html: '<p>'+_('qrbuilder.qrcode.qr_png_path')+'<a id="pngQRImageA" href="" target="_blank" download=""><img id="pngQRImagePath" src="'+ this.value +'" style="max-width: 300px; max-height: 300px;" /></a></p>' +
                  '<p>'+_('qrbuilder.qrcode.qr_svg_path')+'<a id="svgQRImageA" href="" target="_blank" download=""><img id="svgQRImagePath" src="'+ this.value +'" style="max-width: 300px; max-height: 300px;" /></a></p>'
            //,fieldLabel: _('qrbuilder.qrcode.qr_code_path')
            ,name: 'qr_png_path'
        },
    ]
};

var QrbuilderAdvancedTab = {
    title: _('qrbuilder.qrcode.tab_advanced')
    ,border: false
    ,autoHeight: true
    ,items:[{
            html: '<p id="qrcodeAdvancedInstructions">'+_('qrbuilder.qrcode.tab_advanced_desc')+'</p><br />'
            ,border: false
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('qrbuilder.qrcode.override_url_input')
            ,boxLabel: _('qrbuilder.qrcode.override_url_input_check')
            ,name: 'override_url_input'
            ,inputValue: '0'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('qrbuilder.qrcode.build_url_params')
            ,name: 'build_url_params'
            //,width: 400
            ,anchor: '100%'
        }]
    };

Qrbuilder.window.CreateQrcode = function(config) {
    config = config || {};
    QrbuilderBasicTab.items[3].inputValue = activeContextKey;
    QrbuilderBasicTab.items[3].value = activeContextKey;
    
    Ext.applyIf(config,{
        title: _('qrbuilder.qrcode_create')
        ,url: Qrbuilder.config.connectorUrl
        ,baseParams: {
            action: 'mgr/qrcode/create'
        }
        ,cls: 'x-window-with-tabs'
        ,width: 600
        //,fileUpload:true
        ,fields: [{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,border: true
            ,deferredRender: false
            ,forceLayout: true
            ,defaults: {
                border: false
                ,autoHeight: true
                ,layout: 'form'
                ,deferredRender: false
                ,forceLayout: true
            }
            ,items: [
                QrbuilderBasicTab
                ,QrbuilderParamsTab
                //,QrbuilderImageTab // only for update
                ,QrbuilderAdvancedTab
                ]
            }]
    });
    Qrbuilder.window.CreateQrcode.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder.window.CreateQrcode,MODx.Window);
Ext.reg('qrbuilder-window-qrcode-create',Qrbuilder.window.CreateQrcode);



Qrbuilder.window.UpdateQrcode = function(config) {
    config = config || {};
    // QrbuilderBasicTab.items[3].inputValue = activeContextKey;
    Ext.applyIf(config,{
        title: _('qrbuilder.qrcode_update')
        ,url: Qrbuilder.config.connectorUrl
        ,baseParams: {
            action: 'mgr/qrcode/update'
        }
        ,cls: 'x-window-with-tabs'
        ,width: 600
        //,fileUpload:true
        ,fields: [{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,border: true
            ,deferredRender: false
            ,forceLayout: true
            ,defaults: {
                border: false
                ,autoHeight: true
                ,layout: 'form'
                ,deferredRender: false
                ,forceLayout: true
            }
            ,items: [
                QrbuilderBasicTab
                ,QrbuilderParamsTab
                ,QrbuilderImageTab 
                ,QrbuilderAdvancedTab
                ]
            }]
    });
    Qrbuilder.window.UpdateQrcode.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder.window.UpdateQrcode,MODx.Window);
Ext.reg('qrbuilder-window-qrcode-update',Qrbuilder.window.UpdateQrcode);
