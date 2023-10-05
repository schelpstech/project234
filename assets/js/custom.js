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
  var dataTable = $('#datatable-search').DataTable({
    dom: 'Bfrtip',
    buttons: [
      '','copy', 'csv', 'excel', 'pdf' ,'print'// You can include other export options as needed
    ]
  });

  // Create a separate print button
  $('#print-button').on('click', function() {
    dataTable.button('4').trigger(); // '0' corresponds to the 'copy' button; adjust the index based on your needs
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





