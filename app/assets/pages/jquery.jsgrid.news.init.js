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
            url: "../api/letters/"+parishId,
            headers: {"authorization":"Bearer "+token},
            data: filter,
            success: function(response) {
                //static filter on frontend side, you should actually filter data on backend side
                var filtered_data = $.grep(response, function (client) {
                    return (!filter.Name || client.Topic.indexOf(filter.Name) > -1)
                        && (!filter.SenderName || client.Verse.indexOf(filter.SenderName) > -1)
                        && (!filter.SenderEmail || client.SenderEmail.indexOf(filter.SenderEmail) > -1)
                });
                d.resolve(filtered_data);
            }
        });
        return d.promise();
    },

    insertItem: function (item) {
        item.ParishId = parishId;
        return $.ajax({
            type: "POST",
            url: "../api/letter/new",
            headers: {"authorization":"Bearer "+token},
            data: item
        }).done(function(res) {
            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
            !res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");
        });
    },

    updateItem: function (item) {
        //console.log(item);
        return $.ajax({
            type: "PUT",
            url: "../api/letter/"+item.Value,
            headers: {"authorization":"Bearer "+token},
            data: item
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
            data: {"Object":"letters"}
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
            editButton: false,
            filtering: true,
            editing: false,
            inserting: false,
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
            var editingClient;
            $("#cancel").click(function(){
                $("#dataForm").hide();
                $("#dataGrid").show();
                editingClient = null;
            });
            $("#addToTable").click(function(){
                $("#dataGrid").hide();
                $("#dataForm").show();

            });
            // $("#save").on("click", function() {
            //     //console.log(editingClient);
            //     if(editingClient){
            //         $.extend(editingClient, {
            //             ParishId : parishId,
            //             TypeId: $("#TypeId").val(),
            //             Name: $("#Name").val(),
            //             SenderName: $("#SenderName").val(),
            //             SenderEmail: $("#SenderEmail").val(),
            //             Subject: $("#Subject").val(),
            //             Letter: $(".summernote").summernote('code'),
            //             Published: $("#Published").is(':checked')
            //         });
            //         $("#jsGrid").jsGrid("updateItem", editingClient);
            //     }else{
            //         var saveClient ={
            //             ParishId : parishId,
            //             TypeId: $("#TypeId").val(),
            //             Name: $("#Name").val(),
            //             SenderName: $("#SenderName").val(),
            //             SenderEmail: $("#SenderEmail").val(),
            //             Subject: $("#Subject").val(),
            //             Letter: $(".summernote").summernote('code'),
            //             Published: $("#Published").is(':checked')
            //         };
            //         console.log(saveClient);
            //         $("#jsGrid").jsGrid("insertItem", saveClient);
            //     }
            //     editingClient = null;
            //         $("#Name").val("");
            //         $("#TypeId").val("");
            //         $("#SenderName").val("");
            //         $("#SenderEmail").val("");
            //         $("#Subject").val("");
            //         $(".summernote").summernote('code',"");
            //         $("#Published").val("");
            //     $("#dataGrid").show();
            //     $("#dataForm").hide();
            // });

            var options = {
                rowClick: function(e) {
                    editingClient = e.item;
                    return $.ajax({
                        type: "GET",
                        url: "../api/letter/"+editingClient.Value,
                        headers: {"authorization":"Bearer "+token},
                    }).done(function(res) {
                    console.log(res);
                        $("#Name").val(res.Name);
                        $("#LetterId").val(res.Value);
                        $("#TypeId").val(res.TypeId);
                        $("#SenderName").val(res.SenderName);
                        $("#SenderEmail").val(res.SenderEmail);
                        $("#Subject").val(res.Subject);
                        $("#Published").prop("checked", res.Published);
                        $(".summernote").summernote('code',res.Letter);
                        $("#dataGrid").hide();
                        $("#dataForm").show();
                    });
                    //console.log(e.item);

                },
                fields: [
                    {name: "Name", type: "text", width: 100, title:"Name"},
                    {name: "SenderName", type: "text", width: 100, title:"Sender's Name"},
                    {name: "SenderEmail", type: "text", width: 100, title:"Sender's Email"},
                    {name: "Subject", type: "textarea", width: 100, title:"Subject"},
                    {name: "Published", type: "text", width: 50, title:"Published"},
                    {type: "control", editButton: false}
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