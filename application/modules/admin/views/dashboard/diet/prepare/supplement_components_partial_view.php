<style type="text/css">
	.table td, .table th {
    padding: .1rem;
    
}
</style>
 <div class="row">
 <div class="col-md-4">
<div class="callout callout-info">
	&nbsp;&nbsp;<span class="badge badge-danger"><?php echo $splmntName;?></span><br>
	

	<div class="container">         
  <table class="table table-bordered table-condensed" style="font-size: 11px;color:#cc6b58;">
    <thead>
      <tr>
        <th>Sl</th>
        <th>Component</th>
        <!-- <th>Qty</th>
        <th>Unit</th> -->
      </tr>
    </thead>
    <tbody>
    	<?php
    		$sl=1;
       
    		foreach ($componentList as $componentlist) {
    
    	?>
      <tr>
        <td><?php echo $sl++;?></td>
        <td><?php echo $componentlist->component;?></td>
       <!--  <td><?php echo $componentlist->qty;?></td>
        <td><?php echo $componentlist->unit_name;?></td> -->
        
      </tr>
  <?php } ?>
    
    </tbody>
  </table>
</div>
                  </div>


  
  </div>  
 <div class="col-md-6">


  <div class="callout callout-info">       
<span class="badge badge-danger">Note:</span><br>
          <?php
           echo $supplement_remarks;
          

?>
  </div>                 
  </div>                 
  </div>                 