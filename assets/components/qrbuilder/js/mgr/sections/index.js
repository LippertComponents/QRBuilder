Ext.onReady(function() {
    MODx.load({ xtype: 'qrbuilder-page-home'});
});

Qrbuilder.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'qrbuilder-panel-home'
            ,renderTo: 'qrbuilder-panel-home-div'
        }]
    });
    Qrbuilder.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder.page.Home,MODx.Component);
Ext.reg('qrbuilder-page-home',Qrbuilder.page.Home);


// Utility:
Qrbuilder.Util = {};

Ext.onReady(function(){
    console.log('OnReady QR-bulder sections/index.js');
    // set the default date values for the create calendar
    var tmpToday = new Date();
    var tmpTime = Date.parse(tmpToday.toString());
    
    Qrbuilder.Util.Today = tmpToday.format(MODx.config.manager_date_format);
    
    // 90 days out:
    tmpTime = tmpTime*1 + 90*3600*24*1000;
    
    var tmpEnd = new Date(tmpTime);
    Qrbuilder.Util.Enddate = tmpEnd.format(MODx.config.manager_date_format);;// tmpEnd.getFullYear() + '-' + tmpEnd.getMonth() + '-' + tmpEnd.getDate();
    
    console.log('OnReady QR-bulder complete sections/index.js');
});