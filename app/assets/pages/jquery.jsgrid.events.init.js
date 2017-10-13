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
        console.log(filter);
        var d = $.Deferred();
        $.ajax({
            type: "GET",
            url: "../api/events/"+parishId,
            headers: {"authorization":"Bearer "+token},
            data: filter,
            success: function(response) {
                //static filter on frontend side, you should actually filter data on backend side
                var filtered_data = $.grep(response, function (client) {
                    return (!filter.Name || client.Name.indexOf(filter.Name) > -1)
                        && (!filter.Venue || client.Venue.indexOf(filter.Venue) > -1)
                });
                d.resolve(filtered_data);
            }
        });
        return d.promise();
    },

    insertItem: function (item) {
        item.ParishId = parishId;
        if($("#plan").val() =='Free' ){
            swal("Insert Item!", "You do not have access to complete this action, please upgrade your subscription plan", "warning");
        }else if(parseFloat($("#balance").val()) < 1){
            swal("Insert Item!", "You do not have credit to complete this action, please upgrade your subscription plan", "warning");
        }else{
            return $.ajax({
                type: "POST",
                url: "../api/event/new",
                headers: {"authorization":"Bearer "+token},
                data: item
            }).done(function(res) {
                $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
                //update mileage now
                if(!res.value){
                    swal("Insert Item!", "Nothing was saved", "warning")
                }else{
                    swal("Insert Item!", "Item successfully saved", "success");
                    $.ajax({
                        type: "POST",
                        url: "assets/ajax_interface.php",
                        headers: {"authorization":"Bearer "+token},
                        data: {function: 'update_mileage', arguments: [parseInt($("#user").val()),'events']}
                    }).done(function(res) {
                        var bal = parseFloat($("#balance").val()) - 1;
                        $("#balance").val(bal);
                        console.log(res);
                    })
                }



                // !res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");
            });
        }
    },

    updateItem: function (item) {
        console.log(item);
        return $.ajax({
            type: "PUT",
            url: "../api/event/"+item.Value,
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
            data: {"Object":"events"}
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
            return this._insertPicker.datepicker("getDate").toUTCString();
        },

        editValue: function() {
            return this._editPicker.datepicker("getDate").toUTCString();
        }
    });

    var chTime = function(config) {
        jsGrid.Field.call(this, config);
    };

    chTime.prototype = new jsGrid.Field({
        itemTemplate: function(value) {
            return !value ? moment.utc().format('HH:mm A') : value;
        },

        insertTemplate: function(value) {
            return this._insertPicker = $("<input>").timepicker({ defaultTime: moment().format('HH:mm A') });
        },

        editTemplate: function(value) {
            return this._editPicker = $("<input>").timepicker().timepicker("setTime",  value);
        },

        insertValue: function() {
            return this._insertPicker.timepicker("getTime").val();
        },

        editValue: function() {
            console.log(this._editPicker.timepicker("getTime").data('timepicker').hour);
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
                    {name: "Name", type: "text", width: 100, title: "Event Name", validate: "required"},
                    {name: "Venue", type: "text", width: 100, validate: "required"},
                    {name: "StartDate", type: "date", width: 50, title: "Start Date", validate: "required"},
                    {name: "StartTime", type: "time", width: 40, title: "Start Time", validate: "required"},
                    {name: "EndDate", type: "date", width: 50, title: "End Date", validate: "required"},
                    {name: "EndTime", type: "time", width: 40, title: "End Time", validate: "required"},
                    {type: "control"}
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