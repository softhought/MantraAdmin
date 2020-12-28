$(document).ready(function() {

    var basepath = $("#basepath").val();
    var startDate = new Date($("#acstartDate").val());
    var endDate = new Date($("#acendDate").val());
    
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      startDate: startDate,
      endDate: endDate      
   });



   
});// end of document ready