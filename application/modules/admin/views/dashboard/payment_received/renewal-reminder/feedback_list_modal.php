<!-- Default panel contents -->
<h3 style="text-align:center;"> <span class="label label-danger">Enquiry Detail</span></h3>

<table class="table" border="0" cellspacing="0" cellpadding="0" style="border: 2px solid #F66F5F;border-radius: 3px;">

<tr class="warning">
    <td class="form_text2">Name : </td>
    <td align="left" style="padding-right: 7px;" class="form_text2"><?php echo $name;  ?></td>
</tr>
<tr class="warning">
    <td class="form_text2">Membership No : </td>
    <td align="left" style="padding-right: 7px;" class="form_text2"><?php echo $mno;  ?></td>
</tr>

</table>
<table align="center" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-hover" style="width:99%;margin:0 auto;font-size:15px;border: 2px solid #DDD;margin-bottom:20px;">
    <tr class="heading">
        <th style="border-top:none;">#</td>
        <th style="border-top:none;">Enquiry Date</th>
        <th style="border-top:none;">Remarks</th>
        <th style="border-top:none;">Remarks Additional</th>
        <th style="border-top:none;">Follow-Up Date</th>
        <th style="border-top:none;">By</th>
    </tr>
    <?php 
    $k=1;
    if(!empty($enquirydata)){
    foreach($enquirydata as $enquirydata){?>
    <tr class="content">
        <td class="content_txt" align="right" width="2%"><?php echo $k++;?></td>
        <td class="content_txt" align="left"><?php echo date('d-m-Y',strtotime($enquirydata->enq_date)); ?></td>
        <td class="content_txt" align="left"><?php echo $enquirydata->reason_title; ?></td>
        <td class="content_txt" align="left"><?php echo $enquirydata->enq_remarks; ?></td>
        <td class="content_txt" align="left"><?php echo date('d-m-Y',strtotime($enquirydata->followup_date)); ?></td>
        <td class="content_txt" align="left"><?php echo $enquirydata->name; ?></td>
    </tr>
    <?php } }?>
    
    </table>

<!-- Table -->