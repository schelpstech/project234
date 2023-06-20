//show password
function showPassword() {
  const a = document.getElementById('oldPassword');
  const b = document.getElementById('newPassword');
  const c = document.getElementById('confirmPassword');

  if (a.type === 'password' && b.type === 'password' && c.type === 'password') {
    a.type = 'text';
    b.type = 'text';
    c.type = 'text';
  } else if (a.type === 'text' && b.type === 'text' && c.type === 'text') {
    a.type = 'password';
    b.type = 'password';
    c.type = 'password';
  }
}

function checkpassword() {
  var a = document.getElementById('newPassword').value;
  var b = document.getElementById('confirmPassword').value;

  if (a != "" && a.length < 8 && a.length > 16) {
    alert('Password is not in acceptable format');
  }
  if (a != "" && b.length < 8 && b.length > 16) {
    alert('Password is not in acceptable format');
  }
 

  if (a !== b && b !== "") {
    alert('Password and Confirm Password does not match');
    b = "";
  }

}

function watchToken() {
  var field = document.getElementById('newPassword');
  if($("#token").attr("disable",false) == true){
    $("#token").attr("disable",true);
  }

}



