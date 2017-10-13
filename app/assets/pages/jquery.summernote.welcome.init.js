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
function loadLetter(){

}

function saveLetter(){
    var item ={
        ParishId : parishId,
        TypeId: 1,
        Name: $("#Name").val(),
        SenderName: $("#SenderName").val(),
        SenderEmail: $("#SenderEmail").is(':checked'),
        Subject: $("#Subject").val(),
        Letter: $(".summernote").summernote('code'),
        Published: 1
    };

    return $.ajax({
        type: "POST",
        url: "../api/letter/new",
        headers: {"authorization":"Bearer "+token},
        data: item
    }).done(function(res) {
        $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
        !res.value ?  swal("Insert Item!", "Nothing was saved", "warning"): swal("Insert Item!", "Item successfully saved", "success");
    });
}

function updateLetter(){

}

function deleteLetter(){

}
var JsDBSource = {
    loadData: function (filter) {
        //console.log(filter);
        var d = $.Deferred();
        $.ajax({
            type: "GET",
            url: "../api/devotions/"+parishId,
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
            url: "../api/devotion/new",
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
            url: "../api/devotion/"+item.Value,
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
            data: {"Object":"devotions"}
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
                        DevotionDate: $("#datepicker-autoclose").val(),
                        Topic: $("#Topic").val(),
                        Verse: $("#Verse").val(),
                        Content: $("#Content").val(),
                        HasMedia: $("#HasMedia").is(':checked'),
                        Type: $("#Type").val(),
                        Url: $("#Url").val(),
                        Value: $("#devotionID").val()
                    });
                    $("#jsGrid").jsGrid("updateItem", editingClient);
                }else{
                    var saveClient ={
                        DevotionDate: $("#datepicker-autoclose").val(),
                        Topic: $("#Topic").val(),
                        Verse: $("#Verse").val(),
                        Content: $("#Content").val(),
                        HasMedia: $("#HasMedia").is(':checked'),
                        Type: $("#Type").val(),
                        Url: $("#Url").val()
                    };
                    console.log(saveClient);
                    $("#jsGrid").jsGrid("insertItem", saveClient);
                }
                editingClient = null;
                $("#datepicker-autoclose").val("");
                $("#Topic").val("");
                $("#Verse").val("");
                $("#Content").val("");
                $("#HasMedia").val("");
                $("#Type").val("");
                $("#Url").val("");
                $("#devotionID").val("");
                $("#dataGrid").show();
                $("#dataForm").hide();
            });

            var options = {
                rowClick: function(e) {
                    editingClient = e.item;
                    //console.log(e.item);
                    $("#datepicker-autoclose").val(e.item.DevotionDate);
                    $("#Topic").val(e.item.Topic);
                    $("#Verse").val(e.item.Verse);
                    $("#Content").val(e.item.Content);
                    $("#HasMedia").prop("checked", e.item.HasMedia);
                    $("#Type").val(e.item.Type);
                    $("#Url").val(e.item.Url);
                    $("#devotionID").val(e.item.Value);
                    $("#dataGrid").hide();
                    $("#dataForm").show();
                    (e.item.HasMedia)?$("#Media").show():$("#Media").hide();
                },
                fields: [
                    {name: "DevotionDate", type: "text", width: 100, title:"Devotion Date"},
                    {name: "Topic", type: "text", width: 100},
                    {name: "Verse", type: "text", width: 50, title:"Bible Verse"},
                    {name: "Content", type: "textarea", width: 100, title:"Message"},
                    {name: "Url", type: "text", width: 100, title:"Media URL"},
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