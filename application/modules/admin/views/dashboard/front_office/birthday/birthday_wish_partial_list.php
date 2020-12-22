<table id="calling_list" class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th>Sl.No</th> 
              <th>Membership No.</th> 
              <th>Name </th> 
              <th>Branch</th> 
              <th>DOB</th> 
              <!-- <th style="width:150px;">Action</th> -->
                                  
              </tr>
          </thead>
          <tbody>

          <?php $i=1; 
         
                         foreach ($todaybirthdaylist as $todaybirthdaylist){
                           
                       
                         
                         ?>
                    <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $todaybirthdaylist->MEMBERSHIP_NO; ?></td>
                            <td><?php echo $todaybirthdaylist->CUS_NAME; ?></td>
                            <td><?php echo $todaybirthdaylist->CUS_PHONE; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($todaybirthdaylist->CUS_DOB)); ?></td>
                            
                           
                      </tr>
     <?php  }  ?>
          
          </tbody>
        </table>


