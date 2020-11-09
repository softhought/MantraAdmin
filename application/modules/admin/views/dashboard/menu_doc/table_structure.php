   <section class="layout-box-content-format1">  
       <table  id="app_dtl" class="table customTbl table-bordered table-striped dataTable" style="width: 100%">
                <thead>
                    <tr>
                    <th>Sl</th>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Null</th>
                    <th>Key</th>
                    <th>Default</th>
                    <th>Extra</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $sl=1;
                  foreach ($tableStructure as $key => $value) {
                  ?>
                   <tr>
                    <td><?php echo $sl++; ?></td> 
                    <td><?php echo $value->Field; ?></td> 
                    <td><?php echo $value->Type; ?></td> 
                    <td><?php echo $value->Null; ?></td> 
                    <td><?php echo $value->Key; ?></td> 
                    <td><?php echo $value->Default; ?></td> 
                    <td><?php echo $value->Extra; ?></td> 
                   </tr>
                  <?php } ?>
                </tbody>
              </table> 
     </div>   




                <section>