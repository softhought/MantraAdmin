

<tr id="rowItemdetails_<?php echo $rowno; ?>" class="itemDtlCls" >

    <td style="text-align: left;" > 
        
      <span id="serial_<?php echo $rowno; ?>" class="slCls"><?php echo $rowno;?></span>                  
    </td>
    <td> <?php echo $development_dt;?></td>
    <td> <?php echo $development_type;?></td>
    <td> <?php echo $developer_name;?></td>
    <td> <?php echo $developer_note;?></td>


    <td  align="center">
    <a href="javascript:;" class="delDetails" id="delDocRow_<?php echo $rowno; ?>" title="Delete">
     
      <i class="far fa-trash-alt" style="color: #d04949; font-weight:700;"></i>
          

        </a>
     </td>


<input type="hidden" name="rowdevelopment_dt[]"  value="<?php echo date("Y-m-d",strtotime($development_dt));?>">
<input type="hidden" name="rowdevelopment_type[]"  value="<?php echo $development_type;?>">
<input type="hidden" name="rowdeveloper_name[]"  value="<?php echo $developer_name;?>">
<input type="hidden" name="rowdeveloper_note[]"  value="<?php echo $developer_note;?>">

</tr>
