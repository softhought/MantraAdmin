$(document).ready(function(){

   

    basepath = $("#basepath").val();

    $(document).on('submit', '#AmcForm', function(event) {

        event.preventDefault();

        var formData = new FormData($(this)[0]);

        console.log(formData);

      // alert();

        if (validateform()) {

           var formData = new FormData($(this)[0]);

            $("#savebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'annualmaintanancechrg/addedit_action';

           var data =  ajaxcallcontroller(method,formData);

           window.location.href = basepath + 'annualmaintanancechrg';

        //    if(data.msg_status == 1 && data.mode == 'ADD'){
        //        $("#loaderbtn").css('display', 'none');
        //        $("#savebtn").css('display', 'inline-block'); 
        //        $("#statutory_name").val('');
             
        //        $("#errormsg").text(data.msg_data).css('color','#775dbf');

        //    }else if(data.msg_status == 1 && data.mode == 'EDIT'){

        //        window.location.href = basepath + 'statutorymaster';

        //    }          

           

        }

    });

// amc report in calender
fullcalender();
    $("#expirydate").click(function() {


        //$('#calender').fullCalendar({ events: {} });
        $('#calender').fullCalendar('destroy');
        fullcalender();
    })



})

function fullcalender() {

    var basepath = $("#basepath").val();
    var statutory_id = $("#statutory_name").val();
    $("#calender").html('');
    $("#loader").css("display", "block");
   //alert(statutory_id);
    $.ajax({
        type: "POST",
        url: basepath + 'annualmaintanancechrg/getAmcExpirydata',
        dataType: "json",
        //contentType: false,
        data: { statutory_id: statutory_id },
        success: function(result) {
           
            $("#loader").css("display", "none");
            $('#calender').fullCalendar({
                displayEventTime: false,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,listWeek'
                },
                defaultDate: new Date(),
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: 2, // allow "more" link when too many events        
                events: result,
                

            });



        }

    });
}

function validateform(){

    var item_name = $("#item_name").val();
    var expiry_date = $("#expiry_date").val();
    var renewal_amt = $("#renewal_amt").val();    
   

    $("#errormsg").text('').css('color','red');
    if(item_name == ""){
        $("#errormsg").text('Error : Select item name');
        $("#item_name").focus();
        return false;

    }
    else if(expiry_date == ""){
        $("#errormsg").text('Error : Select expiry date');
        $("#expiry_date").focus();
        return false;

    }else if(renewal_amt == ""){
        $("#errormsg").text('Error : Enter Renewal Amount');
        $("#renewal_amt").focus();
        return false;

    }

    return true;

}

