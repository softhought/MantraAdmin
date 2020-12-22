$(document).ready(function(){

    basepath = $("#basepath").val();

    $(document).on("click","#smslistviewbtn",function(){
       
        getAllRenewalreminder();
    });

    $("#mobile_no").keyup(function(){
        var mobile_no = $(this).val();
       
        if(mobile_no.length == 10){
           
        var formData = {mobile_no:mobile_no};
        var method = 'renewalremindersms/getMobileDetail';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#mem_no").val(data.mem_no);
        }
    })


    $("#category").change(function(){
        var category = $(this).val();  
           
        var formData = {category:category};
        var method = 'renewalremindersms/getPackageList';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#card").html(data.cardlistview);
      
    });

    // $('#checkAll').on('click', function(){
    //       // Check/uncheck all checkboxes in the table
    //       // var rows = table.rows({ 'search': 'applied' }).nodes();
    //      // alert();
    //      $('.rowCheckAll').not(this).prop('checked', this.checked);
    //  });

    

     $(document).on('click', '#sendsms', function(event) {
        event.preventDefault();
            
        var formData = new FormData($("#SmsForm")[0]);     
      
        var method = 'renewalremindersms/sendingSMS';
        var data =  ajaxcallcontroller(method,formData);
        if(data.msg_status == 1){
            Swal.fire({ 
                title: 'Send SMS Successfully',    
                text: "",    
                icon: 'info',    
                width: 350,    
                padding: '1em', 
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok', 
                customClass: {    
                    title: 'alerttitale',    
                    content: 'alerttext',    
                    confirmButton: 'btn tbl-action-btn padbtn',  
                },    
            })  
        }
      
   });

   $(document).on('click', '#viewpayment', function(event) {
    event.preventDefault();
        
    var formData = new FormData($("#SmsForm")[0]);     
  
    var method = 'renewalremindersms/sendingSMS';
    var data =  ajaxcallcontroller(method,formData);
    if(data.msg_status == 1){
        Swal.fire({ 
            title: 'Send SMS Successfully',    
            text: "",    
            icon: 'info',    
            width: 350,    
            padding: '1em', 
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok', 
            customClass: {    
                title: 'alerttitale',    
                content: 'alerttext',    
                confirmButton: 'btn tbl-action-btn padbtn',  
            },    
        })  
    }
  
});


$(document).on("click", ".viewpayment", function () {
    var member_id = $(this).attr('data-id');
    var formData = {member_id:member_id};
    var method = 'renewalremindersms/getpaymenthistory';
    var data =  htmlshowajaxcomtroller(method,formData);
    $("#paymentlistModalBody").html(data);
    $('#paymenthistorylistmodel').modal('show');
    
});


    // $(document).on("click","#smslistviewbtn",function(){


    // var table = $('#example').DataTable({
      
    //     'ajax': basepath+'renewalremindersms/getAllRenewalreminder',
    //     'columnDefs': [{
    //        'targets': 0,
    //        'searchable':false,
           
    //        'orderable':false,
    //        'className': 'dt-body-center',
    //        'render': function (data, type, full, meta){
    //            return  $('<div/>').text(data).html() + '<input type="checkbox" class="call-checkbox rowCheckAll" name="id[]" value="' + '">';
    //        }
    //     }],
    //     'order': [1, 'asc']
    //  });
    // });
  
    //  // Handle click on "Select all" control
    //  $('#example-select-all').on('click', function(){
    //     // Check/uncheck all checkboxes in the table
        
    //     var rows = $('#renewal_remindersms').rows({ 'search': 'applied' }).nodes();
    //     $('input[type="checkbox"]', rows).prop('checked', this.checked);
    //  });
  
    // //  // Handle click on checkbox to set state of "Select all" control
    //  $('#renewal_remindersms tbody').on('change', 'input[type="checkbox"]', function(){
    //     // If checkbox is not checked
    //     if(!this.checked){
    //        var el = $('#example-select-all').get(0);
    //        // If "Select all" control is checked and has 'indeterminate' property
    //        if(el && el.checked && ('indeterminate' in el)){
    //           // Set visual state of "Select all" control 
    //           // as 'indeterminate'
    //           el.indeterminate = true;
    //        }
    //     }
    //  });






});

function getAllRenewalreminder(){
  
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var category = $("#category").val();
    var card = $("#card").val();
    var trainer = $("#trainer").val();
    var mobile_no = $("#mobile_no").val();
    var mem_no = $("#mem_no").val();
  
   
    $("#sms_list").html(''); 
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,category:category,card:card,trainer:trainer,mobile_no:mobile_no,mem_no:mem_no};
    var method = 'renewalremindersms/getAllRenewalreminder';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#loader").css('display','none');
     $("#sms_list").html(data);
     $('.dataTable2').DataTable({
      "scrollX": true,
      
   })



  }