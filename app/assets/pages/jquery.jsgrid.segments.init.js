/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * JsGrid page
 */


/**
 * JsGrid Controller
 */
var parishId = $('#parishId').val();
var token = $('#token').val();
var JsDBSource = {
    loadData: function (filter) {
        //console.log(filter);
        var d = $.Deferred();
        $.ajax({
            type: "GET",
            url: "../api/segments",
            headers: {"authorization":"Bearer "+token},
            data: filter,
            success: function(response) {
                //static filter on frontend side, you should actually filter data on backend side
                var filtered_data = $.grep(response, function (client) {
                    return (!filter.Code || client.Code.indexOf(filter.Code) > -1)
                        && (!filter.Description || client.Description.indexOf(filter.Description) > -1)
                        && (!filter.ProjectID || client.ProjectID.indexOf(filter.ProjectID) > -1)
                        && (!filter.ProjectNumber || client.ProjectNumber.indexOf(filter.ProjectNumber) > -1)
                        && (!filter.ApiKey || client.ApiKey.indexOf(filter.ApiKey) > -1)
                        && (!filter.SslCert || client.SslCert.indexOf(filter.SslCert) > -1)
                        && (!filter.PwdCert || client.PwdCert.indexOf(filter.PwdCert) > -1)
                });
                d.resolve(filtered_data);
            }
        });
        return d.promise();
    },

    insertItem: function (item) {
        return $.ajax({
            type: "POST",
            url: "../api/segment/new",
            headers: {"authorization":"Bearer "+token},
            data: item
        }).done(function(res) {
            console.log(res);
            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
            !res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");

        });
    },

    updateItem: function (item) {
        console.log(item);
        return $.ajax({
            type: "PUT",
            url: "../api/segment/"+item.Value,
            headers: {"authorization":"Bearer "+token},
            data: item,
            error: function(e)
            {
                console.log(e);
                swal("Update Item!", e.responseText, "error");
            }
        }).done(function(res) {
            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
            !res.value ?  swal("Update Item!", "Nothing was updated", "warning"): swal("Update Item!", "Item successfully updated", "success");

        });
    },

    deleteItem: function (item) {
        return $.ajax({
            type: "DELETE",
            url: "../api/destroy/"+item.Value,
            headers: {"authorization":"Bearer "+token},
            data: {"Object":"segment"}
        }).done(function(res) {
            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
            swal("Delete Item!", "Item successfully deleted", "success");
        });
    },

    parishes: function () {
        return $.ajax({
            type: "GET",
            url: "../api/parishes",
            headers: {"authorization":"Bearer "+token},
            async: false
        }).responseJSON
    }
};



!function($) {
    "use strict";

    var chDate = function(config) {
        jsGrid.Field.call(this, config);
    };

    chDate.prototype = new jsGrid.Field({

        css: "date-field",            // redefine general property 'css'
        align: "center",              // redefine general property 'align'

        myCustomProperty: "foo",      // custom property

        sorter: function(date1, date2) {
            return new Date(date1) - new Date(date2);
        },

        itemTemplate: function(value) {
            return !value ? new Date().toDateString() : new Date(value).toDateString();
        },

        insertTemplate: function(value) {
            return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() });
        },

        editTemplate: function(value) {
            return this._editPicker = $("<input>").datepicker().datepicker("setDate", new Date(value));
        },

        insertValue: function() {
            return this._insertPicker.datepicker("getDate").toISOString();
        },

        editValue: function() {
            return this._editPicker.datepicker("getDate").toISOString();
        }
    });

    var chTime = function(config) {
        jsGrid.Field.call(this, config);
    };

    chTime.prototype = new jsGrid.Field({

        css: "time-field",            // redefine general property 'css'
        align: "center",              // redefine general property 'align'

        myCustomProperty: "foo",      // custom property

        sorter: function(date1, date2) {
            return new Date(date1) - new Date(date2);
        },

        itemTemplate: function(value) {
            return !value ? moment().format('hh:mm A') : moment(new Date(value)).format('hh:mm A');
        },

        insertTemplate: function(value) {
            return this._insertPicker = $("<input>").timepicker({ defaultTime: moment().format('hh:mm A') });
        },

        editTemplate: function(value) {
            return this._editPicker = $("<input>").timepicker().timepicker("setTime",  moment(new Date(value)).format('hh:mm A'));
        },

        insertValue: function() {
            return this._insertPicker.timepicker("getTime").val();
        },

        editValue: function() {
            return this._editPicker.timepicker("getTime").val();
        }
    });

    jsGrid.fields.time = chTime;
    jsGrid.fields.date = chDate;

    var GridApp = function() {
        this.$body = $("body")
    };
    GridApp.prototype.createGrid = function ($element, options) {
        //default options
        var defaults = {
            width: "100%",
            filtering: true,
            editing: true,
            inserting: true,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            deleteConfirm: "Do you really want to delete the entry?"
        };

        $element.jsGrid($.extend(defaults, options));
    },
        GridApp.prototype.init = function () {
            var $this = this;

            var options = {
                fields: [
                    {name: "Code", type: "text", width: 25, validate: "required"},
                    {name: "Description", type: "text", width: 50, validate: "required"},
                    {name: "ProjectId", type: "text", width: 50, title: "Project ID"},
                    {name: "ProjectNumber", type: "text", width: 25, title: "Project Number"},
                    {name: "ApiKey", type: "text", width: 25, title: "Api Key"},
                    {name: "SslCert", type: "text", width: 40, title: "SSL Certificate"},
                    {name: "PwdCert", type: "text", width: 40, title: "Password Certificate"},
                    {name: "SendLimit", type: "number", width: 25},
                    // {name: "Logo", type: "file", width: 30, align: "center"},
                    {type: "control", width: 30}
                ],
                controller: JsDBSource,
            };
            $this.createGrid($("#jsGrid"), options);

        },
        //init ChatApp
        $.GridApp = new GridApp, $.GridApp.Constructor = GridApp

}(window.jQuery),

//initializing main application module
    function($) {
        "use strict";
        $.GridApp.init();
    }(window.jQuery);