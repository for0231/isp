!function(t){"function"==typeof define&&define.amd?define(["jquery","datatables.net-zf","datatables.net-autofill"],function($){return t($,window,document)}):"object"==typeof exports?module.exports=function(e,$){return e||(e=window),$&&$.fn.dataTable||($=require("datatables.net-zf")(e,$).$),$.fn.dataTable.AutoFill||require("datatables.net-autofill")(e,$),t($,e,e.document)}:t(jQuery,window,document)}(function($,t,e,n){"use strict";var a=$.fn.dataTable;return a.AutoFill.classes.btn="button tiny",a});