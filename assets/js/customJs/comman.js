$(document).ready(function(){

    var startDate = new Date($("#acstartDate").val());
    var endDate = new Date($("#acendDate").val()); 

  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    startDate: startDate,
    endDate: endDate,
    autoclose:true,
    todayHighlight:true  

 });
 $('.datepicker2').datepicker({
    format: 'dd-mm-yyyy',
    autoclose:true,
    todayHighlight:true  

 });

 $('.dobdatepicker').datepicker({
    format: 'dd-mm-yyyy',   
    startDate: new Date('1990-01-01'),
    autoclose:true,
    todayHighlight:true  

 });
 $('.dataTable2').DataTable({
    "scrollX": true
 })

    $('.numberwithdecimal').bind('keyup paste', function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });

    $('.onlynumber').bind('keyup paste', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('.inputupper').bind('keyup paste', function() {
       $(this).css('text-transform','uppercase');
    });
})
function readCommanURL(input) {
   
    var id = $(input).attr('data-showId');
    var isimage = $(input).attr('data-isimage');
  
    $("#"+isimage).val('Y');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#'+id)
                .attr('src', e.target.result)
                .width(120)
                .height(125);
        };

        reader.readAsDataURL(input.files[0]);

    }

}

function ajaxcallcontroller(method,formData){
   var data = "";
   var basepath = $("#basepath").val();
            $.ajax({
                type: "POST",
                url: basepath + method,
                dataType: "json",
                processData: false,
                contentType: false,
                data: formData,
                async:false,
                success: function(result) {
                    data = result;
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
   return data;
       
}

function ajaxcallcontrollerforcutom(method,formData){
    var data = "";
    var basepath = $("#basepath").val();
             $.ajax({
                 type: "POST",
                 url: basepath + method,
                 dataType: "json",                
                 data: formData,
                 async:false,
                 success: function(result) {
                     data = result;
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
    return data;
        
 }

 function htmlshowajaxcomtroller(method,formData){
    var data = "";
    var basepath = $("#basepath").val();          
            $.ajax({
                type: "POST",
                url: basepath + method,
                dataType: "html",
                data: formData,
                async:false,
                success: function(result) {
                    data  = result;
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

return data;
      
 }