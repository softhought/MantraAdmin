<!-- <span class="badge badge-badge badge-light">Medical Information(s)</span> -->
  <button class="btn btn-block btn-outline-secondary btn-sm" style="width:180px;">Medical Information(s)</button></div>
  
  <table class="table table-bordered table-condensed" style="font-size: 11px;color:#cc6b58;margin-top: 10px;">
    <thead>
      <tr style="background: #f3f3f3;color: #742796;">
        
        <th style="width: 25%">Disease </th>
        <th>Medicine</th>
        
      </tr>
    </thead>
    <tbody>
      <?php if($medicalData->is_high_bp=='Yes'){?>
      <tr><td>Hign BP</td><td><?php echo $medicalData->high_bp_medicines;?></td></tr>
    <?php } ?>

     <?php if($medicalData->diabetes_type!=''){?>
      <tr><td>Diabetes <?php echo $medicalData->diabetes_type; ?></td><td><?php echo $medicalData->diabetics_medicines;?></td></tr>
    <?php } ?>

     <?php if($medicalData->is_heart_disease=='Yes'){?>
      <tr><td>Heart disease  </td><td><?php echo $medicalData->heart_disease_medicines;?></td></tr>
    <?php } ?>
    <?php if($medicalData->is_pcod=='Yes'){?>
      <tr><td>PCOD </td><td><?php echo $medicalData->pcod_medicines;?></td></tr>
    <?php } ?>
    <?php if($medicalData->is_chronic_kidney_disease =='Yes'){?>
      <tr><td>Chronic Kidney Disease  </td><td><?php echo $medicalData->chronic_kidney_disease_medicines;?></td></tr>
    <?php } ?>
     <?php if($medicalData->regular_med_history !=''){?>
      <tr><td>History of Regular Medication:   </td><td><?php echo $medicalData->regular_med_history;?></td></tr>
    <?php } ?>

    <?php 
    /* need to check file location */
/*
    if($medicalData->doctor_prescription !=''){?>
      <tr><td>
      Recent Doctor Prescription   </td><td>
        <a href="<?php echo base_url().$medicalData->regular_med_history;?>" download>
        <span class="badge badge-badge badge-info">Download</span>
       </a>
        </td></tr>
    <?php } 
  */
    ?>
    
    
    </tbody>
  </table>