<input type="hidden" name="search_column" id="search_column" value="<?php echo $searchColumn;?>" >
   <section class="layout-box-content-format1">  
       <table  id="app_dtl2" class="table customTbl table-bordered table-striped dataTable" style="width: 100%">
                <thead>
                  <tr>
                   <?php
                  foreach ($tableStructure as $key => $value) {
                  ?>
                    <th><?php echo $value->Field; ?></th> 
                  <?php } ?>
                   </tr>
                </thead>
                <tbody>
                  <?php
                    $sl=1;
                  foreach ($tableData as $tabledata) {
                  ?>
                   <tr>
                     <?php

                     $tableArray = (array)$tabledata;
                     
                  foreach ($tableStructure as $key => $value) {
                  ?>
                    <td><?php echo $tableArray[$value->Field]; ?></td> 
                    <?php } ?>
                   </tr>
                  <?php } ?>
                </tbody>
               <tfoot>
                    <tr>
                   <?php
                  foreach ($tableStructure as $key => $value) {
                  ?>
                    <th><?php echo $value->Field; ?></th> 
                  <?php } ?>
                   </tr>
                </tfoot> 
              </table> 
     </div>   




                <section>