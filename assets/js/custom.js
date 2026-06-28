function formatInput() {
  var input = document.getElementById("school_code").value;
  input = input.replace(/[^a-zA-Z0-9]/g, "").toUpperCase();
  var formatted = input.replace(/(.{2})/g, "$1-");
  formatted = formatted.slice(0, -1);
  document.getElementById("school_code").value = formatted;
}

function switch_contact_type() {
  var note_type = document.getElementById("contact_type");
  var selectedValue = note_type.options[note_type.selectedIndex].value;
  if (selectedValue == "phone") {
    $('#show_phone').show();
    $('#show_email').hide();
    $('#show_address').hide();
    $('#show_address1').hide();
    $('#show_addres2').hide();
    $('#phone').attr('required', '');
    $('#phone').attr('data-error', 'Phone number field is required.');
  }
  else if (selectedValue == "email") {
    $('#show_email').show();
    $('#show_phone').hide();
    $('#show_address').hide();
    $('#show_address1').hide();
    $('#show_address2').hide();
    $('#email').attr('required', '');
    $('#email').attr('data-error', 'Email Address field is required.');
  }
  else if (selectedValue == "address") {
    $('#show_email').hide();
    $('#show_phone').hide();
    $('#show_address').show();
    $('#show_address1').show();
    $('#show_address2').show();
    $('#address').attr('required', '');
    $('#address').attr('data-error', 'Address field is required.');
    $('#lga_type').attr('required', '');
    $('#lga_type').attr('data-error', 'Select LGA field is required.');
  }
  else {
    alert("Select a contact data type to add");
    $('#show_email').hide();
    $('#show_phone').hide();
    $('#show_address').hide();
    $('#show_address1').hide();
    $('#show_address2').hide();
  }
}

function previewImage(input) {
  var preview = document.getElementById('preview');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function preview2ndImage(input) {
  var preview = document.getElementById('preview_2nd');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    }
    reader.readAsDataURL(input.files[0]);
  }
}
function preview3rdImage(input) {
  var preview = document.getElementById('preview_3rd');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    }
    reader.readAsDataURL(input.files[0]);
  }
}



$(document).ready(function() {
  var initializedTables = [];

  function isPortalDataTable(table) {
    var $table = $(table);

    if ($table.data('datatable') === false || $table.hasClass('no-datatable')) {
      return false;
    }

    if ($table.find('thead th').length === 0 || $table.find('tbody').length === 0) {
      return false;
    }

    return table.id === 'datatable-search'
      || $table.hasClass('js-datatable')
      || $table.hasClass('table-flush')
      || $table.closest('.table-responsive').length > 0;
  }

  function tableLabels($table) {
    var labels = [];
    $table.find('thead th').each(function() {
      labels.push($(this).text().replace(/\s+/g, ' ').trim());
    });
    return labels;
  }

  function applyMobileLabels($table) {
    var labels = tableLabels($table);
    $table.find('tbody tr').each(function() {
      $(this).children('td').each(function(index) {
        if (!$(this).attr('data-label') && labels[index]) {
          $(this).attr('data-label', labels[index]);
        }
      });
    });
  }

  function availableButtons() {
    var buttonExtensions = [];
    var buttons = ($.fn.dataTable && $.fn.dataTable.ext && $.fn.dataTable.ext.buttons) || {};
    var buttonClass = 'btn btn-sm btn-outline-dark';

    if (buttons.copyHtml5) {
      buttonExtensions.push({ extend: 'copyHtml5', text: 'Copy', className: buttonClass });
    }
    if (buttons.csvHtml5) {
      buttonExtensions.push({ extend: 'csvHtml5', text: 'CSV', className: buttonClass });
    }
    if (buttons.excelHtml5) {
      buttonExtensions.push({ extend: 'excelHtml5', text: 'Excel', className: buttonClass });
    }
    if (buttons.print) {
      buttonExtensions.push({ extend: 'print', text: 'Print', className: buttonClass });
    }

    return buttonExtensions;
  }

  if (!$.fn.DataTable) {
    return;
  }

  $.fn.dataTable.ext.errMode = 'none';

  $('table').filter(function() {
    return isPortalDataTable(this);
  }).each(function(index) {
    var table = this;
    var $table = $(table);
    var exportButtons = availableButtons();

    if ($.fn.DataTable.isDataTable(table)) {
      return;
    }

    if (!table.id || $('[id="' + table.id + '"]').length > 1) {
      table.id = 'portal-datatable-' + (index + 1);
    }

    $table.addClass('portal-data-table');
    $table.closest('.table-responsive').addClass('portal-table-responsive');
    applyMobileLabels($table);

    try {
      var dataTable = $table.DataTable({
        dom: '<"portal-table-top"<"portal-table-length"l><"portal-table-buttons"B><"portal-table-filter"f>>rt<"portal-table-bottom"<"portal-table-info"i><"portal-table-pagination"p>>',
        pageLength: parseInt($table.data('page-length'), 10) || 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        autoWidth: false,
        deferRender: true,
        order: [],
        buttons: exportButtons,
        language: {
          search: '',
          searchPlaceholder: 'Search table',
          lengthMenu: 'Show _MENU_',
          paginate: {
            previous: 'Prev',
            next: 'Next'
          }
        },
        drawCallback: function() {
          applyMobileLabels($table);
        }
      });

      initializedTables.push(dataTable);
    } catch (error) {
      console.error('DataTable initialization failed for #' + table.id, error);
      $table.addClass('datatable-init-failed');
    }
  });

  $('#print-button').on('click', function() {
    if (initializedTables[0]) {
      initializedTables[0].button('.buttons-print').trigger();
    }
  });
});


function toggleButton() {
  var checkbox = document.getElementById("confirmInvoice");
  var button = document.getElementById("submitInvoice");
  if (checkbox.checked) {
    button.disabled = false; // Enable the button
  } else {
    button.disabled = true; // Disable the button
  }
}


function switch_check_rebate() {
  var selectedValue = $('#rebate').val()
  if (selectedValue == "Yes") {
    $('#showRebateAmount').show();
    $('#showRebateFile').show();
    $('#rebateAmount').attr('required', '');
    $('#rebateAmount').attr('data-error', 'Rebate Amount field is required.');
    $('#rebateFile').attr('required', '');
    $('#rebateFile').attr('data-error', 'Rebate File field is required.');
  } else if (selectedValue != "Yes") {
    $('#showRebateAmount').hide();
    $('#showRebateFile').hide();
  }
}





