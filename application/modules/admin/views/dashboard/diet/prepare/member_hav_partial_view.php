  <div class="row">
 <div class="col-md-2">
 	&nbsp;&nbsp;<button class="btn btn-block btn-outline-info btn-sm" style="width:180px;">HAV Information</button></div>
 <div class="col-md-7"></div>
 <div class="col-md-3">	&nbsp;&nbsp;<button class="btn btn-block btn-outline-secondary btn-sm" style="">
 Entry Date: <?php echo $hav->entry_date;?></button></div></div>
</div>


  <br>
  <div id="test_list_div">
  <table class="table table-bordered table-condensed dataTable" style="font-size: 11px;color:#cc6b58;margin-top: 10px;">

    <tbody>
    <tr><td>Body fat(%)</td><td><?php echo $hav->bodyfat."(".$hav->bodyfat_remarks.")";?></td> </tr>
    <tr><td>Visceral Fat(%)</td><td><?php echo $hav->visceral_fat."(".$hav->visceral_fat_remarks.")";?></td> </tr>
    <tr><td>Muscle(%)</td><td><?php echo $hav->full_body_muscle."(".$hav->musclemass_remarks.")";?></td> </tr>
    <tr><td>Metabolic</td><td><?php echo $hav->body_age."(".$hav->metabolic_remarks.")";?></td> </tr>
    <tr><td>Chronological Age </td><td><?php echo $hav->age;?></td> </tr>
    <tr><td>BMR </td><td style="font-wight:bold;"><?php echo $hav->rm;?></td> </tr>
 
    </tbody>
  </table>
  </div>

	<input type="hidden" name="havbmrValue" id="havbmrValue" value="<?php  echo $hav->rm; ?>">
