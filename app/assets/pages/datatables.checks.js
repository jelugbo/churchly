/**
 * Created by jelugb1 on 11/2/2016.
 */

//
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table){
    var $table             = table.table().node();
    var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
    var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
    var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

    // If none of the checkboxes are checked
    if($chkbox_checked.length === 0){
        chkbox_select_all.checked = false;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
        }

        // If all of the checkboxes are checked
    } else if ($chkbox_checked.length === $chkbox_all.length){
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
        }

        // If some of the checkboxes are checked
    } else {
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = true;
        }
    }
}

$(document).ready(function (){
    // Array holding selected row IDs
    var rows_selected = [];
    var table = $('#dtdevices').DataTable({
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "btn-sm"
        }, {
            extend: "csv",
            className: "btn-sm"
        }, {
            extend: "excel",
            className: "btn-sm"
        }, {
            extend: "pdf",
            className: "btn-sm"
        }, {
            extend: "print",
            className: "btn-sm"
        }],
        /*'ajax': window.location.origin+'/church/api/registers',*/
        'columnDefs': [{
            'targets': 0,
            'searchable':false,
            'orderable':false,
            'width':'1%',
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox">';
            }
        }],
        'order': [1, 'asc'],
        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data[1];

            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }
        }
    });

    // Handle click on checkbox
    $('#dtdevices tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');

        // Get row data
        var data = table.row($row).data();
        console.log($row);
        console.log(data);
        // Get row ID
        var rowId = data[1];

        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray($row, rows_selected);

        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
            rows_selected.push($row);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
            rows_selected.splice(index, 1);
        }

        if(this.checked){
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }

        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    // Handle click on table cells with checkboxes
    $('#dtdevices').on('click', 'tbody td, thead th:first-child', function(e){
        $(this).parent().find('input[type="checkbox"]').trigger('click');
    });

    // Handle click on "Select all" control
    $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
        if(this.checked){
            $('#dtdevices tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('#dtdevices tbody input[type="checkbox"]:checked').trigger('click');
        }

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    // Handle table draw event
    table.on('draw', function(){
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);
    });

    // Handle form submission event
    $('#frm-dtdevices').on('submit', function(e){
        var form = this;
        // Iterate over all selected checkboxes
        $.each(rows_selected, function(index, rowId){
            var data = table.row(rowId).data();
            console.log(data);
           item = JSON.parse('{"Enabled":false,"Value":'+data[1]+',"UserId":'+data[2]+',"GroupId":'+data[3]+'}');
           console.log(item);
            //send Ajax to enable and count
            $.ajax({
                type: "PUT",
                url: "../api/register/"+item.Value,
                data: item,
                error: function(e)
                {
                    console.log(e);
                    swal("Update Item!", e.responseText, "error");
                }
            }).done(function(res) {
               // $("#jsGrid").jsGrid("loadData"); // here we resolve promise with actual item
                !res.value ?  swal("Update Item!", "Nothing was updated", "warning"): swal("Update Item!", "Item successfully updated", "success");
            });
            // Create a hidden element
            $(form).append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'id[]')
                    .val(rowId)
            );
        });

        // FOR DEMONSTRATION ONLY
        console.log(form);

        // Remove added elements
        $('input[name="id\[\]"]', form).remove();

        // Prevent actual form submission
        e.preventDefault();
    });
});
