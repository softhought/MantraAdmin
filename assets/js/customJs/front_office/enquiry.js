$(document).ready(function(){
   var basepath = $("#basepath").val();
    $(document).on('submit', '#EnquiryForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        //console.log(formData);
    
        if (validateform()) {
           var formData = new FormData($(this)[0]);
            $("#enquirysavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'enquiry/addedit_action';
           var data =  ajaxcallcontroller(method,formData);         
           if(data.msg_status == 1 && data.mode == 'ADD' && mayhelp_id == 0){
              
            $("#loaderbtn").css('display', 'none');
            $("#enquirysavebtn").css('display', 'inline-block');
            $("#errormsg").text(data.msg_data).css('color','#775dbf');
            $("#enquiry_dt").val('');
            $("#first_name").val('');
            $("#wings").val('').change();
            $("#last_name").val('');
            $("#branch_id").val('').change();
            $("#pin").val('').change();
            $("#location").val('').change();
            $("#email").val('');
            $("#mobile_no").val('');
            $("#whatsapp_no").val('');
            $("#address").val('');
            $("#remarks").val('');
            $("#followup_date").val('');
            $("#done_by").val('').change();
              //$("#EnquiryForm").reset();           
            
           }else if(data.msg_status == 1 && data.mode == 'ADD' && (mayhelp_id != 0 || frguestpId != 0)){
            window.location.href = basepath + 'enquiry/addeditenquiry';
        }
           else if(data.msg_status == 1 && data.mode == 'EDIT'){
               window.location.href = basepath + 'enquiry';
           }          
           
        }
    });

    $("#pin").change(function(){
        var pin = $("#pin option:selected").text();
        var formData = {pin:pin};
        var method = 'enquiry/getlocation';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#location").html(data.locationlist);
    })
    getallenquery();
    $("#viewbtn").click(function(){
        getallenquery();
    });

    $(document).on("click", ".addFeedback", function () {
        var startDate = new Date($("#acstartDate").val());
        var endDate = new Date($("#acendDate").val()); 
        var enq_id = $(this).attr('data-id');
        var formData = {enq_id:enq_id};
        var method = 'enquiry/getenqmasterforfeedback';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#enquiry_id").val( enq_id );
        $("#fname").val(data.enquirymstdata['FIRST_NAME'])
        $("#lname").val(data.enquirymstdata['LAST_NAME'])
        $("#pincode").val(data.enquirymstdata['PIN'])
        $("#location").val(data.enquirymstdata['LOCATION'])
        $("#address").val(data.enquirymstdata['ADDRESS'])
        $("#email").val(data.enquirymstdata['EMAIL'])
        $("#mobile1").val(data.enquirymstdata['MOBILE1'])
        $("#mobile2").val(data.enquirymstdata['MOBILE2'])        
        $("#txtwing").val(data.enquirymstdata['for_the_wing'])
        $("#feedbck_branch").val(data.enquirymstdata['BRANCH_CODE'])
        $("#sel_remarks").html(data.remarkslist);
        $("#done_by").html(data.userlistview);      
        $('#feedbackmodel').modal('show');
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            startDate: startDate,
            endDate: endDate,
            autoclose:true,
            todayHighlight:true  
        
         });
         $('.select2').select2();
    });

    $(document).on("click", ".feedbackList", function () {
        var enq_id = $(this).attr('data-id');
        var formData = {enq_id:enq_id};
        var method = 'enquiry/getfeedbacklist';
        var data =  htmlshowajaxcomtroller(method,formData);
        $("#feedbackModalBody").html(data);
        $('#feedbacklistmodel').modal('show');
        
    });

    // close enquiry
    $(document).on("click", "#closeenquiry", function () {   
        Swal.fire({    
            title: 'Are you sure you wish to close this enquiry ?',
            icon: 'info',    
            width: 350,    
            padding: '1em',    
            showCancelButton: true,    
            confirmButtonColor: '#3085d6',    
            cancelButtonColor: 'btn btn-danger',    
            confirmButtonText: 'Yes',    
            cancelButtonText: 'No',    
            customClass: {    
                title: 'alerttitale2',    
                content: 'alerttext',    
                confirmButton: 'btn tbl-action-btn padbtn',    
                cancelButton: 'btn tbl-action-btn padbtn',    
            },    
        }).then((result) => {    
            if (result.value) {                          
                var enq_id = $(this).attr('data-id');
                var formData = {enq_id:enq_id};
                var method = 'enquiry/enquiryclose';
                var data =  ajaxcallcontrollerforcutom(method,formData);
                if(data.msg_status == 1){
                    $(".hidebtn_"+enq_id).css('display','none');
                }
            }   
        });
    })

    //wings list
    $("#wing_category").change(function(){
        var cat_id = $(this).val();
        var formData = {cat_id:cat_id};
        var method = 'enquiry/getallwings';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#wings").html(data.wingsview);
    })

    //calling wing category list
    $("#category").change(function(){
        var cat_id = $(this).val();
        var formData = {cat_id:cat_id};
        var method = 'enquiry/getallwings';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#wing").html(data.wingsview);
    })
})

function validateform(){
    var enquiry_dt = $("#enquiry_dt").val();
    var first_name = $("#first_name").val();
    var wings = $("#wings").val();
    var last_name = $("#last_name").val();
    var branch_id = $("#branch_id").val();
    var pin = $("#pin").val();
    var location = $("#location").val();   
    var mobile_no = $("#mobile_no").val();   
    var address = $("#address").val();   
    var followup_date  = $("#followup_date").val();
    var done_by = $("#done_by").val();
    $("#errormsg").text("").css('color','red');
    if(enquiry_dt == ""){
        $("#errormsg").text("Error : Select Enquiry Date");
        $("#enquiry_dt").focus();
        return false;
    }else if(first_name == ""){
        $("#errormsg").text("Error : Enter First Name");
        $("#first_name").focus();
        return false;
    }else if(wings == ""){
        $("#errormsg").text("Error : Select Wing");
        $("#wings").focus();
        return false;
    }
    else if(last_name == ""){
        $("#errormsg").text("Error : Enter Last Name");
        $("#last_name").focus();
        return false;
    }else if(branch_id == ""){
        $("#errormsg").text("Error : Select Branch");
        $("#branch_id").focus();
        return false;
    }else if(pin == ""){
        $("#errormsg").text("Error : Select Pin");
        $("#pin").focus();
        return false;
    }else if(location == ""){
        $("#errormsg").text("Error : Select Location");
        $("#location").focus();
        return false;
    }else if(mobile_no == ""){
        $("#errormsg").text("Error : Enter Mobile No.");
        $("#mobile_no").focus();
        return false;
    }else if(mobile_no.length < 10){
        $("#errormsg").text("Error : Enter 10 Digit Mobile No.");
        $("#mobile_no").focus();
        return false;
    }else if(address == ""){
        $("#errormsg").text("Error : Enter Address");
        $("#address").focus();
        return false;
    }else if(followup_date == ""){
        $("#errormsg").text("Error : Select Follow-Up Date");
        $("#followup_date").focus();
        return false;
    }else if(done_by == ""){
        $("#errormsg").text("Error : Select Done By");
        $("#done_by").focus();
        return false;
    }
return true;

}

function getallenquery(){
  var search_by = $("#search_by").val(); 
  var from_dt = $("#from_dt").val();
  var to_date = $("#to_date").val();
  var branch = $("#branch").val();
  var wing = $("#wing").val();
  var caller = $("#caller").val();
  var mobile_no = $("#mobile_no").val(); 
  $("#calling_list").html(''); 
  $("#loader").css('display','block');
  var formData = {search_by:search_by,from_dt:from_dt,to_date:to_date,branch:branch,wing:wing,caller:caller,mobile_no:mobile_no};
  var method = 'enquiry/getenquirylist';
  var data =  htmlshowajaxcomtroller(method,formData);
   $("#loader").css('display','none');
   $("#calling_list").html(data);
   $('.dataTable2').DataTable({
    "scrollX": true
 })
}

function addFeedBack(){
	var enq_id = $("#enquiry_id").val();
	var sel_remarks = $("#sel_remarks").val();
	var remarks = $("#txtremark").val();
	var followup_date = $("#followup_date").val();
	var done_by = $("#done_by").val();
	var m_branch_feed_code = $("#feedbck_branch").val();	
   
    if(validatefeedback()){
        formData =  {enq_id:enq_id,sel_remarks:sel_remarks,remarks:remarks,followup_date:followup_date,done_by:done_by,m_branch_feed_code:m_branch_feed_code};
        var method = 'enquiry/feedback_action';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        if(data.msg_status == 1){
            $("#sel_remarks").val('').change();
            $("#txtremark").val('');
            $("#followup_date").val('');
            $("#done_by").val('').change();
             $("#errormodal").css('display','inline-block');
             
        }
    }
	
		
	
}

function validatefeedback(){
    var enq_id = $("#enquiry_id").val();
	var remarks = $("#txtremark").val();
	var followup_date = $("#followup_date").val();
    var done_by = $("#done_by").val();
    $("#enquiry_id,#txtremark,#followup_date,#donebyerr").removeClass('modalerror');
    
    if(enq_id == ""){
        // $("#errormodal").text('Error : Enter enquiry id')
        $("#enquiry_id").addClass('modalerror');
        return false;
     }else if(remarks == ""){
        // $("#errormodal").text('Error : Enter addtional remarks') 
        $("#txtremark").addClass('modalerror');
        $("#txtremark").focus();
        return false;
     }else if(followup_date == ""){
        // $("#errormodal").text('Error : Select follow up date')
        $("#followup_date").addClass('modalerror');
        $("#followup_date").focus();
        return false;
     }else if(done_by == ""){
        // $("#errormodal").text('Error : Select done by')
        $("#donebyerr").addClass('modalerror');
        $("#done_by").focus();
        return false;
     }
     return true;
}
