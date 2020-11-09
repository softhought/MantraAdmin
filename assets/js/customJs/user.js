$(document).ready(function(){
   var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
   

}); // end of document ready

function CreateUserFrmValidate() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('.err-border').removeClass('err-border');

    if ($('#name').val()=="") {
        $('#name').focus().addClass("err-border");
        Toast.fire({
            type: 'error',
            title: 'Enter name'
        })
        return false;
    }

    if ($('#user_name').val()=="") {
        $('#user_name').focus().addClass("err-border");
        Toast.fire({
            type: 'error',
            title: 'Enter username'
        })
        return false;
    }    
   
    if ($('#user_role_id option:selected').val()==0) {
        Toast.fire({
            type: 'error',
            title: 'Select a role'
        })
        return false;
    }
    var password=$('#password').val();
    var cpassword=$('#cpassword').val();
    if (password=="") {
        $('#password').focus().addClass("err-border");
        Toast.fire({
            type: 'error',
            title: 'Enter password'
        })
        return false;
    }
    if (cpassword=="") {
        $('#cpassword').focus().addClass("err-border");
        Toast.fire({
            type: 'error',
            title: 'Confirm password'
        })
        return false;
    }
    if(password!=cpassword)
    {
        Toast.fire({
            type: 'error',
            title: 'Password is not matching'
        })
        $('#cpassword').focus().addClass("err-border");
        return false;
    }
    

    return true;
    
}


function openUserloginLogoutDetailModal(userid) {
    // alert(userid);
    $('#ModalBody').html('');   


    $.ajax({
        type: "POST",
        url:'user/getloginLogoutDetailByUserId',
        data:{
            userid:userid
        },
        success: function(result) {
            $('#ModalBody').html(result);  
            $('#loginLogoutTable').DataTable({
                "order": [[ 0, "desc" ]]
            } );
            $('#myModal').modal('show');      
        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            // alert(msg);  
        }
    }); /*end ajax call*/

}
