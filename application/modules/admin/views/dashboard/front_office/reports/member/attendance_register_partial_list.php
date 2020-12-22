<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th width="6%">Sl.No</th>              
              <th width="9%">Date</th>
              <th  width="10%">Membership No</th>
              <th width="15%">Name </th>             
              <th  width="10%">Mobile No.</th>  
              <th  width="12%">IN Time</th>  
              <th  width="12%">OUT Time</th>  
              <th  width="10%" style="text-align:center">Workout Time <br>(in min.)</th>  
              <th width="10%">Branch</th>  
              <th width="7%">Card</th>                         
              <!-- <th width="10%">Action</th> -->
                                  
              </tr>
          </thead>
          <tbody>

          <?php  $i=1;
          foreach($attendancelist as $attendancelist){ ?>

             <tr>
             <td> <?php echo $i++; ?>  </td>
             <td> <?php if($attendancelist->att_date != ""){ echo date('d-m-Y',strtotime($attendancelist->att_date)); } ?>  </td>
             <td> <?php echo $attendancelist->membershipno; ?>  </td>
             <td> <?php echo $attendancelist->CUS_NAME; ?>  </td>
             <td> <?php echo $attendancelist->mobile_no; ?>  </td>
             <td> <?php echo $attendancelist->in_time; ?>  </td>
             <td> <?php echo $attendancelist->out_time; ?>  </td>
             <td> <?php echo $attendancelist->workout_time; ?>  </td>
             <td> <?php echo $attendancelist->BRANCH_NAME; ?>  </td>
             <td> <?php echo $attendancelist->CUS_CARD; ?>  </td>
             </tr>

          <?php } ?>
          
          </tbody>
        </table>