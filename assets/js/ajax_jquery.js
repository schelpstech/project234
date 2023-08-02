function select_region_type() {
    var variable = $("#country_type").val();
    if (variable != "") {
        $.ajax({
            url: "../../app/ajax_query.php",
            method: "POST",
            data: {
                variable: variable,
                requested: 'fetch_region_data',
            },
            success: function (data) {
                $("#region_type").html(data);
            },
            cache: false,
        });
    } else {
        alert("Select Country");
    }
}

function select_state_type() {
    var variable = $("#region_type").val();
    if (variable != "") {
        $.ajax({
            url: "../../app/ajax_query.php",
            method: "POST",
            data: {
                variable: variable,
                requested: 'fetch_state_data',
            },
            success: function (data) {
                $("#state_type").html(data);
            },
            cache: false,
        });
    } else {
        alert("Select Region");
    }
}

function select_lga_type() {
    var variable = $("#state_type").val();
    if (variable != "") {
        $.ajax({
            url: "../../app/ajax_query.php",
            method: "POST",
            data: {
                variable: variable,
                requested: 'fetch_lga_data',
            },
            success: function (data) {
                $("#lga_type").html(data);
            },
            cache: false,
        });
    } else {
        alert("Select State");
    }
}



function validateEmail(){
    var emailAddress = $("#emailAddress").val();
    emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const min = 100000; // Minimum 6-digit number (inclusive)
    const max = 999999; // Maximum 6-digit number (inclusive)

  // Generate a random number between min and max
  const token = Math.floor(Math.random() * (max - min + 1)) + min;
    if (emailAddress != "" && emailRegex.test(emailAddress)) {
        
        $.ajax({
            url: "../../mailer/contact.php",
            method: "POST",
            data: {
                emailAddress: emailAddress,
                token: token,
            },
            success: function (data) {
                alert(data);
                $("#token").attr("disabled", false); 
            },
            cache: false,
            
        });
    } else {
        alert("Invalid Email Address. Enter a valid email address");
        $("#emailAddress").val() = "";
    }
}


function termlyInvoice() {
    var variable = $("#termID").val();
    if (variable != "") {
        $.ajax({
            url: "../../pages/school/report/termlyInvoice.php",
            method: "POST",
            data: {
                variable: variable,
            },
            success: function (data) {
                $("#invoiceTable").html(data);
            },
            cache: false,
        });
    } else {
        alert("Select Term");
    }
}


//Fetch School Details

function fetchSchDetails() {
    var variable = $("#schCode").val();
    if (variable != "") {
        $.ajax({
            url: "../../app/ajax_query.php",
            method: "POST",
            data: {
                variable: variable,
                requested: 'fetchSchDetails',
            },
            success: function (data) {
                $("#schname").html(data);
            },
            cache: false,
        });
    } else {
        alert("Enter School Code ");
    }
}