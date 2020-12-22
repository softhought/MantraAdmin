<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th>              
              <th width="9%">Date</th>
              <th  width="10%">06am-08am</th>
              <th width="10%">09am-11am </th>             
              <th  width="10%">12pm-02pm</th>  
              <th  width="10%">03pm-05pm</th>  
              <th  width="10%">06pm-08pm</th>  
              <th  width="10%">09pm-11pm</th>  
              <th width="10%">Total</th>  
           
                                  
              </tr>
          </thead>
          <tbody>
          <?PHP
					 $i=0;
					 $m=1;
                    
                     for ($r=0;$r<sizeof($aryRange);$r++)
                     {
						 $total=$ary0608[$r]+$ary0911[$r]+$ary1202[$r]+$ary0305[$r]+$ary1820[$r]+$ary2123[$r];
						

					?>
					<tr>
						<td><?PHP echo($m);?></td>
						<td><?PHP echo(date("d-m-Y",strtotime($aryRange[$r])));?></td>
						<td><?PHP echo($ary0608[$r]);?></td>
						<td><?PHP echo($ary0911[$r]);?></td>
						<td><?PHP echo($ary1202[$r]);?></td>
						<td><?PHP echo($ary0305[$r]);?></td>
						<td><?PHP echo($ary1820[$r]);?></td>
						<td><?PHP echo($ary2123[$r]);?></td>
						<td><?PHP echo($total);?></td>
					</tr>
                         <?PHP } ?>
          
          </tbody>
        </table>