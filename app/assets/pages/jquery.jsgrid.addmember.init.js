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
            url: "../api/users/"+parishId,
            headers: {"authorization":"Bearer "+token},
            data: filter,
            success: function(response) {
                //static filter on frontend side, you should actually filter data on backend side
                var filtered_data = $.grep(response, function (client) {
                    return (!filter.Topic || client.Topic.indexOf(filter.Topic) > -1)
                        && (!filter.Verse || client.Verse.indexOf(filter.Verse) > -1)
                        && (!filter.Content || client.Content.indexOf(filter.Content) > -1)
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
            url: "../api/user/new",
            headers: {"authorization":"Bearer "+token},
            data: item
        }).done(function(res) {
            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
            if(!res.value){
                swal("Insert Item!", "Nothing was saved", "warning")
            }else{
                swal("Insert Item!", "Item successfully saved", "success");
                var send_letter = $("#welcome").is(':checked');
                if(send_letter){
                    $.ajax({
                        type: "POST",
                        url: "assets/ajax_interface.php",
                        headers: {"authorization":"Bearer "+token},
                        data: {function: 'welcome', arguments: [parishId,res.value,parseInt($("#uid").val())]}
                    }).done(function(resp) {
                        swal("Send Welcome Letter!", resp.result.msg, "warning");
                        !resp.result.value ? swal("Send Welcome Letter!", resp.result.msg, "warning"):swal("Send Welcome Letter!", resp.result.msg, "success");
                        console.log(resp);
                    })
                }
            }
            //!res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");
        });
    },

    updateItem: function (item) {
        //console.log(item);
        return $.ajax({
            type: "PUT",
            url: "../api/user/"+item.Value,
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
            data: {"Object":"user_profile"}
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
                $("#Media").hide();
                $("#dataForm").show();

            });
            $("#save").on("click", function() {
                //console.log(editingClient);
                if(editingClient){
                    $.extend(editingClient, {

                        Fname: $("#Fname").val(),
                        Lname: $("#Lname").val(),
                        Phone: $("#Phone").val(),
                        Email: $("#Email").val(),
                        Dob: $("#datepicker-autoclose").val(),
                        Married: $("#Married").is(':checked'),
                        Wedding: $("#datepicker").val(),
                        Address: $("#Address").val(),
                        City: $("#City").val(),
                        State: $("#State").val(),
                        Zip: $("#Zip").val(),
                        Value: $("#MemberId").val()
                    });
                    $("#jsGrid").jsGrid("updateItem", editingClient);
                }else{
                    var saveClient ={
                        Fname: $("#Fname").val(),
                        Lname: $("#Lname").val(),
                        Phone: $("#Phone").val(),
                        Email: $("#Email").val(),
                        Dob: $("#datepicker-autoclose").val(),
                        Married: $("#Married").is(':checked'),
                        Wedding: $("#datepicker").val(),
                        Address: $("#Address").val(),
                        City: $("#City").val(),
                        State: $("#State").val(),
                        Zip: $("#Zip").val()
                    };
                    console.log(saveClient);
                    $("#jsGrid").jsGrid("insertItem", saveClient);
                }
                editingClient = null;
                $("#Fname").val("");
                $("#Lname").val("");
                $("#Email").val("");
                $("#Phone").val("");
                $("#datepicker-autoclose").val("");
                $("#Married").prop("");
                $("#datepicker").val("");
                $("#Address").val("");
                $("#City").val("");
                $("#State").val("");
                $("#Zip").val("");
                $("#dataGrid").show();
                $("#dataForm").hide();
            });

            var options = {
                rowClick: function(e) {
                    editingClient = e.item;
                    //console.log(e.item);

                    $("#Fname").val(e.item.Fname);
                    $("#Lname").val(e.item.Lname);
                    $("#Email").val(e.item.Email);
                    $("#Phone").val(e.item.Phone);
                    $("#datepicker-autoclose").val(e.item.Dob);
                    $("#Married").prop("checked", e.item.Married);
                    $("#datepicker").val(e.item.Wedding);
                    $("#Address").val(e.item.Address);
                    $("#City").val(e.item.City);
                    $("#State").val(e.item.State);
                    $("#Zip").val(e.item.Zip);
                    $("#MemberId").val(e.item.Value);
                    $("#dataGrid").hide();
                    $("#dataForm").show();
                    (e.item.Married)?$("#married_div").show():$("#married_div").hide();
                },
                fields: [
                    {name: "Fname", type: "text", width: 100, title:"First Name"},
                    {name: "Lname", type: "text", width: 100, title:"Last Name"},
                    {name: "Email", type: "text", width: 150, title:"Email Address"},
                    {name: "Phone", type: "textarea", width: 100, title:"Phone"},
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