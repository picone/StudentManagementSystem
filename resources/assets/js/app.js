
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

/*Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});*/

$(function(){
    $('.selectAll').click(function(){
        $(this).parents('table').find('tbody').find(':checkbox').prop('checked',$(this).prop('checked'))
    });
    let _token=$('body').data('_token');
    if(_token){
        $.ajaxSetup({
            headers:{'X-CSRF-TOKEN':_token}
        });
    }
});
window.alertDialog=function(msg,type,callback){
    BootstrapDialog.show({
        title:'提醒',
        message:msg,
        type:type|BootstrapDialog.TYPE_PRIMARY,
        callback:callback
    });
};

window.confirmDialog=function(msg,callback){
    BootstrapDialog.confirm({
        title:'警告',
        message:msg,
        type:BootstrapDialog.TYPE_DANGER,
        btnCancelLabel:'取消',
        btnOKLabel:'确定',
        callback:callback
    });
};
