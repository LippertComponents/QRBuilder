Qrbuilder.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('qrbuilder.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('qrbuilder')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('qrbuilder.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'qrbuilder-grid-qrbuilder'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }/*,{
                title: _('qrbuilder.web_ads')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('qrbuilder.web_ads_desc')+'</p><br />'
                    ,border: false
                }/ *,{
                    xtype: 'qrbuilder-grid-web-ads'
                    ,cls: 'main-wrapper'
                    ,preventRender: false
                }* /]
            }*/]
        }]
    });
    Qrbuilder.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder.panel.Home,MODx.Panel);
Ext.reg('qrbuilder-panel-home',Qrbuilder.panel.Home);

