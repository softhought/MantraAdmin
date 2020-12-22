$(document).ready(function(){
    basepath = $("#basepath").val();

    
    $("#specialenquiryshowbtn").click(function(){
        var from_dt = $("#from_dt").val();
        var to_date = $("#to_date").val();
        var branch = $("#branch").val();  
        var wing = $("#wing").val();  
   
        if(Validitywithform()){
   
    $("#specialenquiry_list").html('');
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,wing:wing};
    var method = 'enquiry/getspecialenquiry';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#specialenquiry_list").html(data);
    $('.dataTable2').DataTable({
        "scrollX": true
     })
    }
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


});

function Validitywithform(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var wing = $("#wing").val();
    
    $("#errormsg").text('');
    if(from_dt == ""){
        $("#errormsg").text('Error : Select from date');
        return false;
    }else if(to_date == ""){
        $("#errormsg").text('Error : Select to date');
        return false;
    }
    else if(wing == ""){
        $("#errormsg").text('Error : Select Wing');
        return false;
    }
    return true;
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
