<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>

	<style type="text/css">

	body {
		background-color: #fff;	
		font-family:  Verdana Helvetica, Arial, sans-serif;
		color: #4F5155;
    }
    .print_logo{
        width:5%;
    }
    .logo{
          width:16%;
    }
   .borderleft{
	border-right: 1px solid black;
   }
   .paddingleft{
	   padding-left:10px;
   }

   .heading{
		text-align: center;
    font-size: 22px;
    border-bottom: 1px solid black;
    padding-bottom: 6px;
    text-transform: uppercase;
	margin-bottom: 0;
	}
	.textstyle{
		padding:5px 0px 5px 5px;
		width:50%;
	}
	
	.borderbottom{
		border-bottom:1px solid black;
	}
	.payment-details{
		border-collapse: collapse;
		
	}
	.padding10 td{
		padding: 10px;
	}
	.padding15 td{
		padding: 15px;
		text
	}
	.payment-details td{
      border:1px solid black;
	
	}
	.info-1{
		margin-bottom: 0px;
       font-size: 10px;
	}
		
	</style>
</head>
<body>
<?php 
//  echo "<pre>";
//  print_r($paymentdtl);
//  echo "</pre>";exit;


?>
 <table width="100%" class="">
               <tr>
                   <td align="center">
                        <u><span style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                           
                        </span></u>
                    </td>
                </tr>
        </table>
        <table width="100%" class="">
               <tr>
                   <td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:bold;">Profit & Loss</span></td>
               </tr>
        </table>
        
        
       <table width="100%">
            <tr><td align="center"><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
       
        <!-- <div style="padding:2px 0 5px 0;"></div> -->
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
    
    <table width="100%" class="demo" style="margin-top: 10px;!important">
			<tr class="table_head">
				<th colspan="10" align="left" style="font-size: 16px;color: #000;background:#e3e3e3;font-weight: bold;">Expenditure</th>
			</tr>
			<?php 
			
				$ln_count = 0;
				
				$expenditure_grp_desc = "";
				$expenditure_group = "";
				$expenditure_group_sum = 0;
				$total_expenditure = 0;
				//pre($expenditureData);exit;
				foreach($expenditureData as $expediture_data)
				{
				
				$total_expenditure+= $expediture_data['Expenditure'];	
				$expenditure_group_sum = 0;
				if($expenditure_grp_desc!=$expediture_data['GroupDescription'])
				{
					$expenditure_group_sum = $expenditureSum[$expediture_data['GroupDescription']];
					$expenditure_group = $expediture_data['GroupDescription'];
					$ln_count = $ln_count+1;
					
					// Line count check
				if($ln_count>30)
				{ ?>
			
				
                <?php $ln_count = 1; 
					
				?>
				 
			<?php
				} // end of line count check
				
			?>
					<tr style="background:#e3e3e3;font-weight: bold;">
						<td colspan="2" align="left" style="width: 72%;"><b><?php echo $expenditure_group; ?></b></td>
						<td colspan="8" align="right"><b><?php echo number_format($expenditure_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$expenditure_group = "";
				}
				$ln_count = $ln_count+1;
				
				// Line count check
				if($ln_count>30)
				{ ?>
				
			
                <?php $ln_count = 1; 
				
				?>
				
			<?php
				} // end of line count check
				
			?>
			<tr>
				<!-- <td>&nbsp;</td> -->
				<td colspan="2" align="left"><?php echo $expediture_data['AccountName']; ?></td>
				<td colspan="8" align="right"><?php echo number_format($expediture_data['Expenditure'],2); ?></td>
			</tr>
			
			<?php
		
			$expenditure_grp_desc = $expediture_data['GroupDescription'];
			}
			$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Expenditure</b></td>
				<td colspan="8" align="right"><b><?php echo number_format($total_expenditure,2); ?></b></td>
			</tr>
                
        </table>


		<div style="padding:4px"></div> 
	
		
		<table width="100%" class="demo" style="margin-top: 10px;!important">
			<tr class="table_head">
				<th colspan="10" align="left"  style="font-size: 16px;color: #000;background:#e3e3e3;font-weight: bold;s">Income</th>
			</tr>
			<?php 
				$ln_count = $ln_count+1;
				
				$income_grp_desc = "";
				$income_group = "";
				$income_group_sum = 0;
				$total_income = 0;
				
				foreach($incomeData as $income_data)
				{
				$total_income+= $income_data['Income'];
				$income_group_sum = 0;
				if($income_grp_desc!=$income_data['GroupDescription'])
				{
					$income_group_sum = $incomeSum[$income_data['GroupDescription']];
					$income_group = $income_data['GroupDescription'];
					$ln_count = $ln_count+1;
					// Line count check
		
					?>	
					
					<tr style="background:#e3e3e3;font-weight: bold;">
						<td colspan="2" align="left" style="width: 72%;"><b><?php echo $income_group; ?></b></td>
						<td colspan="8" align="right"><b><?php echo number_format($income_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$income_group = "";
				}
				$ln_count = $ln_count+1;
				
		
				?>
			<tr>
				
				<td colspan="2"><?php echo $income_data['AccountName']; ?></td>
				<td colspan="8" align="right"><?php echo number_format($income_data['Income'],2); ?></td>
			</tr>
			
			<?php
			
			$income_grp_desc = $income_data['GroupDescription'];
			}
		
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Income</b></td>
				<td colspan="8" align="right"><b><?php echo number_format($total_income,2); ?></b></td>
			</tr>
                
        </table>
		
		<div style="padding:4px"></div> 
		<?php
			$tag = "";
			$diff_amount = 0;
			
		
			if($total_income>$total_expenditure)
			{
				$tag = "Profit";
				$diff_amount = $total_income -$total_expenditure;
			}
			elseif($total_income<$total_expenditure)
			{
				$tag = "Loss";
				$diff_amount = $total_expenditure-$total_income;
			}
			else
			{
				$tag = "";
				$diff_amount = "";
			}
			
			$ln_count = $ln_count+1;
		?>
		
		
		<table width="100%" class="demo" style="font-weight:bold;">
			<tr>
				<td colspan="2"  align="left" style="width: 72%;"><?php echo $tag ;?></td>
				<td colspan="1"  align="right"><?php echo number_format($diff_amount,2); ?> </td>
			
				
			</tr>
		</table>





</body>
</html>