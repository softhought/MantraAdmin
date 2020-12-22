$(document).ready(function(){

  basepath = $("#basepath").val();
    updateClock();
    setInterval('updateClock()', 1000 );

    $(document).on('keyup change', '#mobile_no', function(event) {
         var mobile_no = $(this).val();
         $("#package").html('<option value="">Select</option>');
         if(mobile_no.length == 10){
        var formData = {mobile_no:mobile_no};
        var method = 'memberattendance/getmembershipdtl';
        var data =  ajaxcallcontrollerforcutom(method,formData);
          if(data.msg_status == 1){
           $("#package").html(data.listview);
          }else{
            $("#errormsg").text('Error : Member has no active package')
          }
         }
  })

  $(document).on('change', '#package', function(event) {
    var cus_id = $('#package').val();  
   
   var formData = {cus_id:cus_id};
   var method = 'memberattendance/getmemberdtl';
   var data =  ajaxcallcontrollerforcutom(method,formData);     
      $("#mem_name").val(data.memdtl['CUS_NAME']);
      $("#membership_no").val(data.memdtl['MEMBERSHIP_NO']);
      $("#mem_name").val(data.memdtl['CUS_NAME']);
    
   
})

})

function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}
