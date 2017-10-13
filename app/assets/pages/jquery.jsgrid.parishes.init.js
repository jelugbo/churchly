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
            url: "../api/parishes",
            headers: {"authorization":"Bearer "+token},
            data: filter,
            success: function(response) {
                //static filter on frontend side, you should actually filter data on backend side
                var filtered_data = $.grep(response, function (client) {
                    return (!filter.Name || client.Name.indexOf(filter.Name) > -1)
                        && (!filter.ChurchId || client.ChurchId === filter.ChurchId)
                        && (!filter.Overseer || client.Overseer.indexOf(filter.Overseer) > -1)
                        && (!filter.State || client.State.indexOf(filter.State) > -1)
                        && (!filter.Zip || client.Zip.indexOf(filter.Zip) > -1)
                        && (!filter.Logo || client.Logo.indexOf(filter.Logo) > -1)
                });
                d.resolve(filtered_data);
            }
        });
        return d.promise();
    },

    insertItem: function (item) {
        console.log(item);
        if(item.Logo instanceof Object){
            var form_data = new FormData();
            form_data.append('file', item.Logo);
            file_size = item.Logo.size / 1024;
            $.ajax({
                url: "upload.php",
                type: "POST",
                data:  form_data,
                headers: {"authorization":"Bearer "+token},
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    if(data=='invalid file')
                    {
                        // invalid file format.
                        swal("Insert Item!", "Could not upload attached file, Invalid File", "error");
                        return false;
                    }
                    else
                    {
                        // Update Db and view uploaded file.
                        item.Logo = ($(data).attr("src"));
                        return $.ajax({
                            type: "POST",
                            url: "../api/parish/new",
                            data: item
                        }).done(function(res) {
                            console.log(res.value);
                            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
                            !res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");
                        });
                    }
                },
                error: function(e)
                {
                    swal("Insert Item!", e, "error");
                }
            });
        }else{
            return $.ajax({
                type: "POST",
                url: "../api/parish/new",
                data: item
            }).done(function(res) {
                console.log(res.value);
                $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
                !res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");
            });
        }
    },

    updateItem: function (item) {
        if(item.Logo instanceof Object){
            var form_data = new FormData();
            form_data.append('file', item.Logo);
            file_size = item.Logo.size / 1024;
            $.ajax({
                url: "upload.php",
                type: "POST",
                data:  form_data,
                headers: {"authorization":"Bearer "+token},
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    if(data=='invalid file')
                    {
                        // invalid file format.
                        swal("Update Item!", "Could not upload attached file, Invalid File", "error");
                        return false;
                    }
                    else
                    {
                        // Update Db and view uploaded file.
                        item.Logo = ($(data).attr("src"));
                        return $.ajax({
                            type: "PUT",
                            url: "../api/parish/"+item.Value,
                            data: item
                        }).done(function(res) {
                            console.log(res.value);
                            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
                            !res.value ?  swal("Update Item!", "Nothing was updated", "warning"): swal("Update Item!", "Item successfully updated", "success");
                        });
                    }
                },
                error: function(e)
                {
                    swal("Update Item!", e, "error");
                }
            });
        }else{
            return $.ajax({
                type: "PUT",
                url: "../api/parish/"+item.Value,
                headers: {"authorization":"Bearer "+token},
                data: item
            }).done(function(res) {
                console.log(res.value);
                $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
                !res.value ?  swal("Update Item!", "Nothing was updated", "warning"): swal("Update Item!", "Item successfully updated", "success");
            });
        }

    },

    deleteItem: function (item) {
        return $.ajax({
            type: "DELETE",
            url: "../api/destroy/"+item.Value,
            headers: {"authorization":"Bearer "+token},
            data: {"Object":"parish"}
        }).done(function(res) {
            $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
            swal("Delete Item!", "Item successfully deleted", "success");
        });
    },

    churches: function () {
        return $.ajax({
            type: "GET",
            url: "../api/churches",
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

    var chImg = function(config) {
        jsGrid.Field.call(this, config);
    };

    chImg.prototype = new jsGrid.Field({

        itemTemplate: function(value, item) {
            // console.log(item);
            return $("<img>").attr("src", value).css({ height: 50, width: 50 });
        },
        insertTemplate: function() {
            return this._insertPicker =  $("<input>").prop("type", "file");
        },
        editTemplate: function() {
            return this._insertPicker =  $("<input>").prop("type", "file");
        },
        insertValue: function() {
            return this._insertPicker[0].files[0];
        },
        editValue: function() {
            return this._insertPicker[0].files[0];
        }
    });

    $("#dialog").dialog({
        modal: true,
        autoOpen: false,
        position: {
            my: "center",
            at: "center",
            of: $("#jsgrid")
        }
    });


    jsGrid.fields.time = chTime;
    jsGrid.fields.date = chDate;
    jsGrid.fields.file = chImg;

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
                    {name: "Name", type: "text", width: 40},
                    {name: "ChurchId", type: "select", items: JsDBSource.churches(), valueField: "Value", textField: "ShortName", title: "Church", width: 25},
                    {name: "Overseer", type: "text", width: 50, title: "Pastor"},
                    {name: "Address", type: "text", width: 40},
                    {name: "City", type: "text", width: 25},
                    {name: "State", type: "text", width: 25},
                    {name: "Zip", type: "text", width: 25},
                    {name: "Country", type: "text", width: 25},
                    {name: "Email", type: "text", width: 65},
                    {name: "Phone", type: "text", width: 25},
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