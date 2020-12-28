<html>
    <head>
        <title>General Ledger Report</title>
        <style>
          .demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
	.demo th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:5px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:11px;		
		
	}
    .small_demo {
		border:1px solid;
		padding:2px;
	}
	.small_demo td {
		//border:1px solid;
		padding:2px;
                width: auto;
                font-family:Verdana, Geneva, sans-serif; 
                font-size:11px; font-weight:bold;
	}
    .headerdemo {
		border:1px solid #C0C0C0;
		padding:2px;
	}
	
	.headerdemo td {
		//border:1px solid #C0C0C0;
		padding:2px;
	}
    .demo_font{
            font-family:Verdana, Geneva, sans-serif;
		font-size:11px;	
        }
        .table_head{
            height:45px;
            border:none;
        }
        .break{
            page-break-after: always;
        }

          html,body{
        max-width: 29.7cm;
        max-height: 21cm;
        padding: 5px;


       
        /* change the margins as you want them to be. */
   } 

            @page { margin: 1;}

  .demo table, .demo th, .demo td {
  
   page-break-inside: avoid;
  }

  tr
  {
   
      page-break-inside: avoid;
   
  }

     @media print {
        thead {display: table-header-group;margin-top: 50px;border-top: 0px;}

    }
        </style>
    </head>
    <body onload="window.print()">
       
        <table width="100%" class="">
               <tr>
                   <td align="center">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companyaddress) ?>
                        </span>
                    </td>
                </tr>
        </table>
        <table width="100%" class="">
               <tr>
                   <td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:bold;"><?php echo $accountname;?></span></td>
               </tr>
        </table>
        
        
       <table width="100%">
            <tr><td align="center"><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
        
       <table width="100%">
           <tr>
               <td width="50%" align="left">
                   <table >
                        <tr>
                            <td align="left"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Print Date : <?php echo date('d-m-Y');?></span></td>
                        </tr>
                    </table>
               </td>
               <td width="35%" align="right">
                   <table>
                        <tr>
                            <td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>
                        </tr>
                        <tr>
                            <td align="center"><span style="font-size:12px;">(<?php echo date("d-m-Y",strtotime($accounting_period['start_date'])). " To ".date("d-m-Y",strtotime($accounting_period['end_date']));?>)</span></td>
                        </tr>
                   </table>
               </td>
           </tr>
        </table>
        <div style="padding:4px"></div>
        <div style="padding:4px"></div>
       
		<table width="100%" class="demo">
		<tr>
               <th align="left">Date</th>
               <th>&nbsp;</th>
               <th align="left" width='20%'>Particulars</th>
               <th align="left">Voucher Type</th>
               <th align="left">Voucher No.</th>
               <th align="right">Debit</th>
               <th align="right">Credit</th>
           </tr>
		  
            <?php 
		$totalDebit = 0;
        $totalCredit =0;
		
		
		
		foreach($generalledger as $res){ ?>
		<tr>
		    <td>
                <?php if($res['vchNumber']=="Opening")
                {echo " ";}
                else{
                    echo date('d-m-Y',strtotime($res['VchDate']));
                    
                }?>
            </td>
			<td><?php echo $res['isdebit'];?></td>
			<td >
			
			<strong><?php //echo $res['VchAccountDetailscrdrtag'];?></strong><br><?php //echo $res['_narration'];?>
				<?php 
					$group_array=explode("~",$res['VchAccountDetailscrdrtag']);
					
					$acctg1 = explode(",",$group_array[0]);
					$acctg2 = explode(",",$group_array[1]);
					$acctg3 = explode(",",$group_array[2]);
					if($res['VchAccountDetailscrdrtag']!=""){
					echo("<table width='100%' border='0'>  ");
					for($i=0;$i<count($acctg1);$i++){
						echo("<tr>");
						echo("<td style='border:0'>".$acctg2[$i]."</td><td align='right' style='border:0'>".$acctg3[$i]." (<strong>".$acctg1[$i]."</strong>)</td>");
						echo("</tr>");
						
					}
					echo("</table>");
					}
					
					
				
				?>
			</td>
			<td><?php echo $res['VchType'];?></td>
			<td><?php echo $res['vchNumber'];?></td>
			<td align="right"><?php if($res['debitamount']==0){echo "";}else{echo number_format($res['debitamount'],2);}?></td>
            <td align="right"><?php if($res['creditamount']==0){echo "";}else{echo number_format($res['creditamount'],2);}?></td>
		</tr>
		<?php 
		
		
			$totalDebit = $totalDebit+$res['debitamount'];
            $totalCredit = $totalCredit+$res['creditamount'];
            $differenceAmt = $totalDebit-$totalCredit;
            $absdifferenceAmt=abs($differenceAmt);
            if($differenceAmt>0){
                $lastbalance = $totalDebit;
                
            }else{
                $lastbalance = $totalCredit;
            }
            
            
            if($differenceAmt>0){
                $tag = "Dr";
            }
            elseif ($differenceAmt==0) {
            $tag="";
             }
            else{
                $tag="Cr";
            }
		
		
		
		
		} /*---End Of Foreach----*/ 
		?>
		
		<tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="right" style="border-bottom:1px solid #CCC;border-top:1px solid #CCC;"> <?php if($totalDebit==0){echo "";}else{echo number_format($totalDebit,2);}?></td>
               <td align="right" style="border-bottom:1px solid #CCC;border-top:1px solid #CCC;"> <?php if($totalCredit==0){echo "";}else{echo number_format($totalCredit,2);}?></td>
           </tr>
           
           <tr>
               <td>&nbsp;</td>
               <td><?php echo $tag;?></td>
               <td>Closing Balance</td>
               
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <?php 
                        if($tag=="Dr"){ 
                           
               ?>
               <td align="right" style="border-bottom:1px solid #CCC;"><?php echo "";?></td>
                       
               <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($absdifferenceAmt,2);?></td>
                        <?php } else{
                            
                            ?>
                <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($absdifferenceAmt,2);?></td>
                <td align="right" style="border-bottom:1px solid #CCC;"><?php echo "";?></td>
                        <?php } ?>
           
               
           </tr>
<?php 
        
      
?>
           <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               
               <td>&nbsp;</td>
               <td>&nbsp;</td>

               <td align="right" style="border-bottom:1px solid #CCC;font-weight:700;"><?php echo number_format($lastbalance,2);?></td>
                       
               <td align="right" style="border-bottom:1px solid #CCC;font-weight:700;"> <?php echo number_format($lastbalance,2);?></td>
                        
           
               
           </tr>
		
		</table>
                
    </body>
</html>