<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th>  
              <th width="15%">Name </th>             
              <th  width="10%">Mobile No.</th>  
              <th  width="10%">Branch</th>  
              <th  width="10%">Designation</th>  
              <th  width="10%">Present Days</th>  
                                     
             
                                  
              </tr>
          </thead>
          <tbody>

          <?php  $i=1;
          foreach($attendancelist as $attendancelist){ ?>

             <tr>
             <td> <?php echo $i++; ?>  </td>            
             <td> <?php echo $attendancelist->empl_name; ?>  </td>
             <td> <?php echo $attendancelist->empl_mobile; ?>  </td>
             <td> <?php echo $attendancelist->BRANCH_NAME; ?>  </td>
             <td> <?php echo $attendancelist->desig_desc; ?>  </td>
             <td> <span class="circledrw"><?php echo $attendancelist->presentDys; ?></span>  </td>
            
             </tr>

          <?php } ?>
          
          </tbody>
        </table>