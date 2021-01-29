<!-- Default panel contents -->
<h3 style="text-align:center;"> <span class="label label-danger">Member Detail</span></h3>

<table class="table" border="0" cellspacing="0" cellpadding="0" style="border: 2px solid #F66F5F;border-radius: 3px;">
<tr class="active" >
    <td class="form_text2">Membership No : </td>
    <td align="left" style="padding-right: 7px;border-top:none;" class="form_text2"><?php echo $customermstdata->MEMBERSHIP_NO; ?>&nbsp;</td>
</tr>

<tr class="warning">
    <td class="form_text2">Name : </td>
    <td align="left" style="padding-right: 7px;" class="form_text2"><?php echo $customermstdata->CUS_NAME; ?></td>
</tr>
<tr class="danger">
    <td class="form_text2">Card : </td>
    <td align="left" style="padding-right: 7px;" class="form_text2"><?php echo $customermstdata->CUS_CARD; ?>&nbsp;</td>
</tr>

</table>
<table align="center" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-hover" style="width:99%;margin:0 auto;font-size:15px;border: 2px solid #DDD;margin-bottom:20px;">
     <tr class="heading">
        <th style="border-top:none;">#</td>
        <th style="border-top:none;">Date</th>
        <th style="border-top:none;">Email Title</th>
        <th style="border-top:none;">Email Matter</th>
       
    </tr>
    <?php 
    $k=1;
    foreach($oldmememaildel as $oldmememaildel){?>
    <tr class="content">
        <td class="content_txt" align="right" width="2%"><?php echo $k++;?></td>
        <td class="content_txt" align="left"><?php echo date('d-m-Y h:i A',strtotime($oldmememaildel->date_of_sending)); ?></td>
        <td class="content_txt" align="left"><?php echo $oldmememaildel->email_title; ?></td>
        <td class="content_txt" align="left"><?php echo $oldmememaildel->email_matter; ?></td>
        
    </tr>
    <?php }?>
    
    </table>

<!-- Table -->