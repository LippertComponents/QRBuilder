var Qrbuilder = function(config) {
    config = config || {};
    Qrbuilder.superclass.constructor.call(this,config);
};
Ext.extend(Qrbuilder,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('qrbuilder',Qrbuilder);

Qrbuilder = new Qrbuilder();