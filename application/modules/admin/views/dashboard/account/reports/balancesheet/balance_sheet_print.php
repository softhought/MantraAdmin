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
                   <td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:bold;">Balance Sheet</span></td>
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
				<th colspan="10" align="left" style="font-size: 16px;color: #000;background:#e3e3e3;font-weight: bold;">Liability</th>
			</tr>
			<?php 
				
				$ln_count = 0;
				
				$liablity_grp_desc = "";
				$liablity_group = "";
				$liablity_group_sum = 0;
				$total_liablity = 0;
				
				foreach($LiablitiesData as $liablity_data)
				{
				
				$total_liablity+= $liablity_data['Liabilities'];	
				$liablity_group_sum = 0;
				if($liablity_grp_desc!=$liablity_data['GroupDescription'])
				{
					$liablity_group_sum = $LiablitiesSum[$liablity_data['GroupDescription']];
					$liablity_group = $liablity_data['GroupDescription'];
					$ln_count = $ln_count+1;
					
					// Line count check
				if($ln_count>100)
				{ ?>
				<!-- </table> -->
			
                <?php $ln_count = 1; 
					
					
				?>
				 
			<?php
				} // end of line count check
				
			?>
					<tr style="background:#e3e3e3;font-weight: bold;">
						<td colspan="2" align="left" style="width: 70%;"><b><?php echo $liablity_group; ?></b></td>
						<td colspan="1" align="right"><b><?php echo number_format($liablity_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$liablity_group = "";
				}
				$ln_count = $ln_count+1;
				
				// Line count check
				if($ln_count>100)
				{ ?>
				<!-- </table> -->
			
			
                <?php $ln_count = 1; 
			
				?>
				
			<?php
				} // end of line count check
				
			?>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $liablity_data['AccountName']; ?></td>
				<td align="right"><?php echo number_format($liablity_data['Liabilities'],2); ?></td>
			</tr>
			
			<?php
		
			$liablity_grp_desc = $liablity_data['GroupDescription'];
			}
			$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Liablity</b></td>
				<td colspan="1" align="right"><b><?php echo number_format($total_liablity,2); ?></b></td>
			</tr>
                
        </table>
        <div style="padding:4px"></div> 
		
		<table width="100%" class="demo">
			<tr class="table_head">
				<th colspan="10" align="left" style="font-size: 16px;color: #000;background:#e3e3e3;font-weight: bold;">Asset</th>
			</tr>
			<?php 
				$ln_count = $ln_count+1;
				
				$asset_grp_desc = "";
				$asset_group = "";
				$asset_group_sum = 0;
				$total_asset = 0;
				
				foreach($AssetData as $asset_data)
				{
				$total_asset+= $asset_data['Asset'];
				$asset_group_sum = 0;
				if($asset_grp_desc!=$asset_data['GroupDescription'])
				{
					$asset_group_sum = $AssetSum[$asset_data['GroupDescription']];
					$asset_group = $asset_data['GroupDescription'];
					$ln_count = $ln_count+1;
					// Line count check
			?>
					
					<tr style="background:#e3e3e3;font-weight: bold;">
						<td colspan="2" align="left"><b><?php echo $asset_group; ?></b></td>
						<td colspan="1" align="right"><b><?php echo number_format($asset_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$asset_group = "";
				}
				$ln_count = $ln_count+1;
				
				 ?>
			
			
            
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $asset_data['AccountName']; ?></td>
				<td align="right"><?php echo number_format($asset_data['Asset'],2); ?></td>
			</tr>
			
			<?php
			//$total_income = $asset_data['Income'];
			$asset_grp_desc = $asset_data['GroupDescription'];
			}
			//$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Asset</b></td>
				<td colspan="1" align="right"><b><?php echo number_format($total_asset,2); ?></b></td>
			</tr>
                
        </table>
		
		<div style="padding:4px"></div> 
		<?php
		
			$total_liablty = abs($total_liablity);
			$total_ast = abs($total_asset);
			
			$tag = "";
			$diff_amount = 0;
			
		
			if($total_ast>$total_liablty)
			{
				$tag = "Profit";
				$diff_amount = $total_ast -$total_liablty;
			}
			elseif($total_ast<$total_liablty)
			{
				$tag = "Loss";
				$diff_amount = $total_liablty-$total_ast;
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
				<td align="left" style="width: 70%;"><?php echo $tag ;?></td>
				<td align="right"><?php echo number_format($diff_amount,2); ?> </td>
			
				
			</tr>
		</table>





</body>
</html>