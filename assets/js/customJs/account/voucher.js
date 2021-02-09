$(document).ready(function(){
    var basepath = $("#basepath").val();

    $("#tranction_type").change(function(){
        var tranction_type = $("#tranction_type").val();
        var formData = {tranction_type:tranction_type};
        var method = 'voucher/getsubtransactiontype';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#sub_tranction_type").html(data.subtranctionview);

        if(tranction_type == "CASH" || tranction_type == "BANK"){
           
            $("#sub_tranction_type").removeAttr('disabled',false);
        }else{
            $("#sub_tranction_type").attr('disabled',true);
            frameAccounts();
        }
       
    })

    $("#category").change(function(){
        var category = $(this).val();             
        var formData = {category:category};
        var method = 'voucher/getPackageList';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#card").html(data.cardlistview);
      
    });
    
    $("#sub_tranction_type").change(function(){

        frameAccounts();
      
    });
    $("#sub_tranction_type").trigger('change'); 
    $("#addentrybtn").click(function(){

        
        var dr_cr_tag = $("#account_tag").val();
        var account_id = $("#account_id").val();
         var account_name = $("#account_id option:selected").text();
        var pay_to_id = $("#pay_to").val();
        var pay_to_name = $("#pay_to option:selected").text();
        var pay_month = $("#pay_month").val();
        var amount = $("#amount").val();
        var rowno = parseInt($("#rowno").val())+parseInt(1);

        if(validatedata()){
            var formData = {rowno:rowno,dr_cr_tag:dr_cr_tag,account_id:account_id,account_name:account_name,pay_to_id:pay_to_id,pay_to_name:pay_to_name,pay_month:pay_month,amount:amount};
            var method = 'voucher/getvoucherdetails';
            var data =  htmlshowajaxcomtroller(method,formData); 
            $("#rowno").val(rowno);
            $("#detail_voucher table").show();
            $("#detail_voucher table tbody").append(data);
            resetDrCrAmount();
            if($("#account_tag").val() == 'Dr'){
                $("#account_tag").val('Cr').change();
            }else{
                $("#account_tag").val('Dr').change();
            }
            
            $("#account_id").val('').change();
            $("#pay_to").val('').change();
            $("#pay_month").val('').change();
            $("#amount").val('');
            $("#is_voucher_dtl").val('Y');
            $('#account_tag').attr('disabled', false);
            populateAccounts("OTH", "list", "");
           
        }
       
      
    });

   
    $(document).on('click', '.delvoucherDetails', function() {
        var currRowID = $(this).attr('id');
        var rowDtlNo = currRowID.split('_');
       
        $("tr#rowcarddetails_" + rowDtlNo[1]).remove();
        $("#is_voucher_dtl").val('Y');
        $("#rowno").val(parseFloat($("#rowno").val()) - 1);
        resetDrCrAmount();
    });

    $(document).on('click', '.editvoucherDetails', function() {
        var currRowID = $(this).attr('id');
        var rowDtlNo = currRowID.split('_');

        $("#account_tag").val($("#dr_cr_tag_dtl_"+rowDtlNo[1]).val()).change();
        var trn_type = $("#tranction_type").val();
        var sub_trn_type = $("#sub_tranction_type").val();

        
        if (trn_type == "CASH") {
            if (sub_trn_type == "RECEIPT") {
                if ($('#account_tag').val() == "Dr") {
                   
                    populateAccounts("CSH", "type", "");
                }
                else {
                    populateAccounts("OTH", "list", "");
    
                }
            }
            else {
                if ($('#account_tag').val() == "Cr") {
                    populateAccounts("CSH", "type", "");
                }
                else {
                    populateAccounts("OTH", "list", "");
                }
            }
    
        }
        else if (trn_type == "BANK") {
            if (sub_trn_type == "RECEIPT") {
                if ($('#account_tag').val() == "Dr") {
                    populateAccounts("BNK", "list", "");
                }
                else {
                    populateAccounts("OTH", "list", "");
                }
            }
            if (sub_trn_type == "PAYMENT") {
                if ($('#account_tag').val() == "Cr") {
                    populateAccounts("BNK", "list", "");
                }
                else {
                    populateAccounts("OTH", "list", "");
                }
            }
        }
        else  // CONTRA or JOURNAL
        {
            populateAccounts("OTH", "list", "");
    
        }
        
        $("#account_id").val($("#account_id_dtl_"+rowDtlNo[1]).val()).change();
        $("#pay_to").val($("#pay_to_id_dtl_"+rowDtlNo[1]).val()).change();
        $("#pay_month").val($("#pay_month_dtl_"+rowDtlNo[1]).val()).change();
        $("#amount").val($("#amountdtl_"+rowDtlNo[1]).val()).change();
        $("tr#rowcarddetails_" + rowDtlNo[1]).remove();
        $("#is_voucher_dtl").val('Y');
        resetDrCrAmount();
        $("#rowno").val(parseFloat($("#rowno").val()) + 1);
    });

// form submit

$(document).on('submit', '#VoucherForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    //console.log(formData);

    if (validateform()) {
       var formData = new FormData($(this)[0]);
        $("#vouchersavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'voucher/addedit_action';
       var data =  ajaxcallcontroller(method,formData);         
       if(data.msg_status == 1 && data.mode == 'ADD'){
            $("#loaderbtn").css('display', 'none');
            $("#vouchersavebtn").css('display', 'inline-block');
            Swal.fire({
            title: "Voucher No : " + data.voucherno,
            text: "",
            icon: "info",
            width: 350,
            padding: "1em",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Ok",
            customClass: {
              title: "alerttitale",
              content: "alerttext",
              confirmButton: "btn tbl-action-btn padbtn",
            },
          }).then((result) => {
            if (result.value) {
              window.location.href = basepath + "voucher/addeditvoucher";
            }
          });

       
    }
       else if(data.msg_status == 1 && data.mode == 'EDIT'){
        window.location.href = basepath + "voucher";
       }          
       
    }
});


// voucher list

$("#vouchershowbtn").click(function(){
    getvoucherdata();
})

// delete voucher
$(".voucherdelete").click(function(){
    var voucher_id = $(this).attr('data-voucherid');
   
    Swal.fire({    
        // title: 'Receipt No : ' + data.receipt_no,    
        text: "Are you sure you wish to delete this entry?",    
        icon: 'info',    
        width: 350,    
        padding: '1em',    
        showCancelButton: true,    
        confirmButtonColor: '#3085d6',    
        cancelButtonColor: 'btn btn-danger',    
        confirmButtonText: 'Yes',    
        cancelButtonText: 'No',    
        customClass: {    
            title: 'alerttitale',    
            content: 'alerttext',    
            confirmButton: 'btn tbl-action-btn padbtn',    
            cancelButton: 'btn tbl-action-btn padbtn',    
        },    
    }).then((result) => {    
        if (result.value) {    
            window.location.href = basepath + 'voucher/voucherdelete/' + voucher_id;    
                

        }   
    });

})

});

function getvoucherdata(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();  
    var tranction_type = $("#tranction_type").val();  
    var collection_type = $("#collection_type").val();  
   
    // if(Validitywithform()){
    $("#voucher_list").html('');
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,tranction_type:tranction_type,collection_type:collection_type};
    var method = 'voucher/getvoucherdata';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#voucher_list").html(data);
    $('.dataTable').DataTable()
    // }
}


function resetDrCrAmount(){
	var total_dr_amt=0;
	var total_cr_amt=0;
	$(".listamounted").each(function(){
	  var currRowID = $(this).attr('id');
      var rowDtlNo = currRowID.split('_');
      
      var tran_type=$("#dr_cr_tag_dtl_"+rowDtlNo[1]).val();    

	      if (tran_type=='Dr') {
	      		total_dr_amt+=parseFloat($(this).val());
	      }else{
	      	    total_cr_amt+=parseFloat($(this).val());
	      }
    });
//   console.log("test---");
	$("#total_dr").val(total_dr_amt);
	$("#total_cr").val(total_cr_amt);
  if (total_dr_amt!=total_cr_amt) {
          if (total_dr_amt>total_cr_amt) {
            // $("#tran_type").val("Cr").change();
            var remaining=(total_dr_amt-total_cr_amt);
            // $("#amount").val(remaining);
          }else{
            // $("#tran_type").val("Dr").change();
            var remaining=(total_cr_amt-total_dr_amt);
            // $("#amount").val(remaining);
          }

  }

}



function validateform(){


    var branch = $("#branch").val();
    var voucher_dt = $("#voucher_dt").val();
    var tranction_type = $("#tranction_type").val();
    var sub_tranction_type = $("#sub_tranction_type").val();
    
    var total_dr = $("#total_dr").val();
    var total_cr = $("#total_cr").val();
    $("#errormsg").text('');
    if(voucher_dt == ""){
        $("#errormsg").text('Error : Select voucher date');		
		$('#voucher_dt').focus();
		return false;
    }
    else if(branch == ""){
        $("#errormsg").text('Error : Select branch');		
		$('#branch').focus();
		return false;
    } else if(tranction_type == ""){
        $("#errormsg").text('Error : Select transaction type');		
		$('#tranction_type').focus();
		return false;
    }else if((tranction_type == "CASH" || tranction_type == "BANK") && sub_tranction_type == ""){
        $("#errormsg").text('Error : Select sub transaction type');		
		$('#sub_tranction_type').focus();
		return false;
    }else if (total_dr <= 0 || total_cr <= 0) {
        $("#errormsg").text('Error : Empty detail section');	
		return false;
	}
	if (total_dr != total_cr) {
        $("#errormsg").text('Error : Total debit must be equal to Total Credit');		
		return false;
	}
    
return true;

}




function frameAccounts(){

	var trn_type = $("#tranction_type").val();
        var sub_trn_type = $("#sub_tranction_type").val();

      if (trn_type == "CASH") {
		if (sub_trn_type == "RECEIPT") {
			// $('#account_tag option[value="Dr"]').attr("selected", "selected");
			$('#account_tag').val("Dr").change();
			$('#account_tag').attr('disabled', true);
			populateAccounts("CSH", "type", "");
		}
		else {
			// $('#account_tag option[value="Cr"]').attr("selected", "selected");
            $('#account_tag').val("Cr").change();
			$('#account_tag').attr('disabled', true);
			populateAccounts("CSH", "type", "");
		}

	}
	else if (trn_type == "BANK") {
		if (sub_trn_type == "RECEIPT") {
			// $('#account_tag option[value="Dr"]').attr("selected", "selected");
			$('#account_tag').val("Dr").change();
			$('#account_tag').attr('disabled', true);
			populateAccounts("BNK", "list", "");
		}
		if (sub_trn_type == "PAYMENT") {
            // $('#account_tag option[value="Cr"]').attr("selected", "selected");
            $('#account_tag').val("Cr").change();
			$('#account_tag').attr('disabled', true);
			populateAccounts("BNK", "list", "");
		}
	}
	else if (trn_type == "CONTRA") {
		$('#account_tag').attr('disabled', false);
		populateAccounts("CN", "list", "");
	}

	else  // CONTRA or JOURNAL
	{
		if (trn_type == "JOURNAL") {
			$('#account_tag').attr('disabled', false);
			populateAccounts("JRN", "list", "");
		}

	}

}

function populateAccounts(trn, tag, pkg) {
              
    var formData = {trn:trn,tag:tag,pkg:pkg};
    var method = 'voucher/getAccountList';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    $("#account_id").html(data.accountlistview);
}

function validatedata(){

   
    var dr_cr_tag = $("#account_tag").val();
    var account_id = $("#account_id").val();
     var account_name = $("#account_id option:selected").text();
    var pay_to_id = $("#pay_to").val();
    var pay_to_name = $("#pay_to option:selected").text();
    var pay_month = $("#pay_month").val();
    var amount = $("#amount").val();
    
    $("#adderrormsg").text('');	
    if (dr_cr_tag == "") {
        $("#adderrormsg").text('Error : Select Debit / Credit Tag');		
		$('#account_tag').focus();
		return false;
	}else  if (account_id == "") {
        $("#adderrormsg").text('Error : Select Account');		
		$('#account_id').focus();
		return false;
	}else  if (amount <= 0) {
        $("#adderrormsg").text('Error : Invalid Amount');		
		$('#account_id').focus();
		return false;
	}

   return true;

}