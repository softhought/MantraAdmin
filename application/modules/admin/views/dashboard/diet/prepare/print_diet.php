<!-- <link rel="stylesheet" href="https://mantrahealthclub.com/admin/css/diet_meal_print.css" /> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<style type="text/css">

.text_s{ font-weight: bold; color: #7b1884; }
.mantralogo{ display: block; margin-left: auto; margin-right: auto; width: 25%;}
.your{ position: ABSOLUTE; bottom: -20px; right: 445px; style:;}
.hello{ font-size: 20; text-align: center; }
.havM{ position: relative; margin-bottom: 20;}
.havlogo{ display: block; margin-left: auto; margin-right: auto; width: 50%;}
.havach{ background-color: #FF5E00; width: 30%; height: 25%; position: absolute; bottom: -1px; right: 255px; display: block; border: 0; }
.havachP{ margin-top:-3; color: white;  padding: 10px 0;}
.t1{ font-size: 14; text-align: center; }
.center{ float: center }
.left{ float: left }
.right{ float: right }
.but_size{ height: 45px; border-radius: 2px; margin-bottom: 0px; }
.thead1 { background-color: dodgerblue; color: white; font-size: 12px; letter-spacing: 1px }
.thead2 { background-color: orangered; color: white; font-size: 12px; letter-spacing: 1px }
.tbody1 { border: 1px solid dodgerblue; background-color: lightgray; color: black;}
.tbody2 { border: 1px solid orangered; background-color: lightgray; color: black;}
td{ border: 1px solid white; }
.h1, .h2, .h3, h1, h2, h3 { margin-top: 0; margin-bottom: 0; }
.acor{ background-color: ;}
.margin{ margin-bottom: 5px;}
.Q{font-family: "Times New Roman";}
#myModal{ height: 600px; width: 1550px; }
#modal-body{ max-height: 400px; overflow-y: scroll; }
#panel{ margin-bottom: 0px}
p{color: black; margin: 2;}
li{margin-bottom: 25px;}
.panel-heading{margin: -10px }
th{ text-align: center; }
.thead13 {
    background-color: #a8c760;
    color: white;
    font-size: 12px;
    letter-spacing: 1px;
}
/* COLUMN VISUAL EFFECTS */
	.TFtableCol{
		width:100%; 
		border-collapse:collapse; 
	}
	.TFtableCol td{ 
		padding:7px; border:white 1px solid; width: 25%;
	}
	/* improve visual readability for IE8 and below */
	.TFtableCol tr{
		background: silver;  float: center;
	}
	/*  Define the background color for all the ODD table columns  */
	.TFtableCol tr td:nth-child(odd){ 
		/* background: silver; */
		background: #d6d6d6;
	}
	/*  Define the background color for all the EVEN table columns  */
	.TFtableCol tr td:nth-child(even){
		/* background: lightgray; */
		background: #dedede;
	}
    .memberInfo {
    #background: #f7e6b3;
    background: #c1db85;
    border-radius: 10px;
    color: #313131;
    padding: 10px;
}

@page {
	size: 8.27in 11.69in;
	margin: 5%;
}

body {
	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	font-size: 15px;
	text-align: left;
	padding: 0px;
	margin: 0px;
}
.name {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 30px;
	font-weight: bold;
	text-align: center;
	line-height: 34px;
	letter-spacing: 3px;
	text-transform: capitalize;
}
.name_tag {
	font-size: 9px;
	font-weight: normal;
	text-align: center;
	letter-spacing: 2px;
	text-decoration: underline;
	line-height: 10px;
	text-transform: capitalize;
}

#container
{
	width:960px;
	margin:0 auto;
	border:0px solid #CCC;
}
#innerDiv
{
	width:940px;
	margin:10px auto;
}
.logo img
{
	margin-left:auto;
	margin-right:auto;
	display:block;
	border-radius:2px;
}
</style>
<?php
$this->load->model('dietmodel','_dietmodel',TRUE);
$CI=&get_instance();
$rowMemberMealMaster =  $this->_dietmodel->GetMembersDietByMealID($mealID);
foreach($rowMemberMealMaster as $row_meal_master)
{
	$member_name = $row_meal_master->CUS_NAME;
	$gender = $row_meal_master->CUS_SEX;
	$marital_status = $row_meal_master->CUS_MS;
	$bmr_rate = $row_meal_master->bmr_rate;

	$calorie_requierd = $row_meal_master->calorie_required;
	
	$total_cal_expnditure = $row_meal_master->final_calorie_req;
	
	$total_cal_given = $row_meal_master->total_calorie_given;
	
	$body_fat_percentg = $row_meal_master->bodyfatpercent;
	$body_fat_remarks = $row_meal_master->bodyfatremarks;
	//$visceral_fat = $row_meal_master->visceral_fat;
	//$visceral_fat_remarks = $row_meal_master->visceral_fat_remarks;
    
	$meal_approach = $row_meal_master->meal_approach;
	$specialnote = $row_meal_master->member_remarks;
	$dietitian = $row_meal_master->dietitian;
	
	if($row_meal_master->meal_approach_code=="ZZA")
	{
		$cal_expenditure = $row_meal_master->total_cal_with_zig_zag;
	}
	else
	{
		$cal_expenditure = $row_meal_master->final_calorie_req;
	}
	
}

$title_tag = "";
if($gender=="M")
{
	$title_tag = "Mr.";
}
if($gender=="F")
{
	if($marital_status=="M")
	{
		$title_tag = "Mrs.";
	}
	if($marital_status=="S")
	{
		$title_tag = "Ms.";
	}
}


// Total Natural Energy
$rowNaturalFoodSource = $this->_dietmodel->GetFoodSourceGiven($mealID,'Natural'); 

$totalCarbsNatural = 0;
$totalProteinNatural = 0;
$totalFatNatural = 0;
foreach($rowNaturalFoodSource as $natural_food)
{
	$totalCarbsNatural+= $natural_food->carbs_grams;
	$totalProteinNatural+= $natural_food->protein_grams;
	$totalFatNatural+= $natural_food->fat_grams;
}
$tCarbsNaturalCalorie = $this->_dietmodel->converGramToCalorie($totalCarbsNatural,'Carbohydrate');
$tProteinNaturalCalorie = $this->_dietmodel->converGramToCalorie($totalProteinNatural,'Protein');
$tFatNaturalCalorie = $this->_dietmodel->converGramToCalorie($totalFatNatural,'Fat');



// Supplement Energy in gm
$rowSupplementFoodSource = $this->_dietmodel->GetFoodSourceGiven($mealID,'Supplement'); 

$totalCarbsSupllmnt = 0;
$totalProteinSupllmnt = 0;
$totalFatSupllmnt = 0;
foreach($rowSupplementFoodSource as $suplymnt_food)
{
	$totalCarbsSupllmnt+= $suplymnt_food->carbs_grams;
	$totalProteinSupllmnt+= $suplymnt_food->protein_grams;
	$totalFatSupllmnt+= $suplymnt_food->fat_grams;
}
$tCarbsSupllmntCalorie = $this->_dietmodel->converGramToCalorie($totalCarbsSupllmnt,'Carbohydrate');
$tProteinSupllmntCalorie = $this->_dietmodel->converGramToCalorie($totalProteinSupllmnt,'Protein');
$tFatSupllmntCalorie = $this->_dietmodel->converGramToCalorie($totalFatSupllmnt,'Fat');




?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Mantra The Life Style Health Club Pvt. Ltd.</title>
<link rel="stylesheet" href="css/diet_meal_print.css" />

<script type="text/javascript">
    function printpage() {
        
        var printButton = document.getElementById("printpagebutton");
        printButton.style.visibility = 'hidden';
        window.print()
		printButton.style.visibility = 'visible';
    }
</script>

</head>
<body>
<p><img src="<?php echo base_url(); ?>assets/img/print.png" id="printpagebutton" title="Print" onclick="printpage()" /></p>
	<div id="container">
		<div id="innerDiv">
			<div id="headView">
				<div class="logo">
					  <img src="<?php echo base_url(); ?>assets/img/mantralogo.png" class="mantralogo" >
                                    <div>
                                        <p style="color: #00adff; font-size: 25px; text-align: center;"><b>Greetings from Mantra Life Style Health Club!</b></p>
                                        <p class="hello"><strong>Hello, <?php echo $member_name ; ?></strong></p>
                                        <!-- <p class="your"><strong>YOUR</strong></p> -->
                                    </div>
					<h2 style="text-align:center;color: #2e3593;">Diet Mantra</h2>
					<p style="text-align:right;"><strong>Date : <?php echo date('d-m-Y');?></strong></p>
				</div>
			</div>
			<div id="bodyView">
				<!-- <section id="memberInfo" class="memberInfo">
				
					<p>
						<b><?php echo $title_tag." ".$member_name ; ?>,</b> The scientific <?php echo $meal_approach; ?> for your healthy life style ...<br>
						Your total calorie expenditure in a day is <b><?php echo number_format($calorie_requierd); ?> kcal</b>, your recommended calorie requirement in a day is <b><?php echo number_format($cal_expenditure); ?> kcal</b> and calorie given to you is <b><?php echo number_format($total_cal_given); ?> kcal</b> to achieve your fitness goal.<br>
						Your BMR(Resting Calorie Burn) is <b><?php echo number_format($bmr_rate); ?> kcal.</b> Your Body Fat % is <b><?php echo $body_fat_percentg; ?></b> which indicates that you are in <b><?php echo $body_fat_remarks; ?></b> State.
					
					</p>
					
					<p><b>According to Anthropometric Assessment your ideal diet meal is given below : </b> </p>
					
				</section>
    <br> -->
                	<section id="memberInfo" class="memberInfo">
				
					<p>
						<b><?php echo $title_tag." ".$member_name ; ?>,</b><br> 
                        Your Calorie requirement is <b><?php echo number_format($calorie_requierd); ?> kcal ,</b>
					   Your Body fa% is <b><?php echo $body_fat_percentg; ?></b> which is <b><?php echo $body_fat_remarks; ?></b> State.
                       Your visceral fat % is <b><?php //echo $body_fat_percentg; ?></b> which is <b><?php //echo $visceral_fat_remarks; ?></b> State.
				       Your metabolic age is  which is 
                    </p>
					
					<p><b>According to the above body composition assessment Your ideal meal plan  is given bellow. </b> </p>
					
				</section><!-- END MEMBER INFO-->
                <!-- END MEMBER INFO-->
				
				
				<section id="dietComponentSum" style="">
					
				
					
                    <h4 class="text_s">Energy from Food Supplement Source  -------</h4>
					<table cellspacing="0" cellpadding="0" border="0" class="table" style="width:100%;" >
					  <thead class="thead1">
                    <tr>
                    
						<th>Food Category</th>
						<th>Quantity</th>
						<th>Energy(kcal)</th>
					</tr>
					</thead>
                  <tbody class="tbody1 TFtableCol">   
					<tr>
						<td class="text-left  td2">Carbohydrate</td>
						<td><?php echo $totalCarbsNatural; ?> gm</td>
						<td><?php echo $tCarbsNaturalCalorie; ?></td>
					</tr>
					<tr>
						<td class="text-left  td2">Protein</td>
						<td><?php echo $totalProteinNatural; ?> gm</td>
						<td><?php echo $tProteinNaturalCalorie; ?></td>
					</tr>
					<tr>
						<td class="text-left  td2">Fat</td>
						<td><?php echo $totalFatNatural; ?> gm</td>
						<td><?php echo $tFatNaturalCalorie; ?></td>
					</tr>
                     </tbody>
				</table>
				</section>
				
				<section id="dietComponentSum" style="margin-bottom:20px;">
					<h4 class="text_s">Energy from Food Supplement Source  -------</h4>
					<table cellspacing="0" cellpadding="0" border="0" class="table" style="width:100%;" >
                     <thead class="thead2">
					<tr>
						<th>Food Category</th>
						<th>Quantity</th>
						<th>Energy(kcal)</th>
					</tr>
					 </thead>
                <tbody class="tbody2 TFtableCol">
					
					<tr>
						<td>Carbohydrate</td>
						<td><?php echo $totalCarbsSupllmnt; ?> gm</td>
						<td><?php echo $tCarbsSupllmntCalorie; ?></td>
					</tr>
					<tr>
						<td>Protein</td>
						<td><?php echo $totalProteinSupllmnt; ?> gm</td>
						<td><?php echo $tProteinSupllmntCalorie; ?></td>
					</tr>
					<tr>
						<td>Fat</td>
						<td><?php echo $totalFatSupllmnt; ?> gm</td>
						<td><?php echo $tFatSupllmntCalorie; ?></td>
					</tr>
				 </tbody>	
				</table>
				</section>
			
				
				<?php 
				$rowSupplymentCategory = $this->_dietmodel->getOtherAssistanceCateg($mealID);
                $Issuppliment='N';
				foreach($rowSupplymentCategory as $other_assistnce_catg){ 
                    $Issuppliment='Y';
			?>
				
				<section id="" style="clear:both;">
				<h4  class="text_s"> Support From : <?php echo $other_assistnce_catg->otherAssistanceCategory; ?>  ------- </h4>
				<table cellspacing="0" cellpadding="0" border="0"  class="table" style="width:100%;"  >
				<thead class="thead1">
                	<tr>
						<th>Supplement</th>
						<th>Quantity</th>
						
					</tr>
                    </thead>
					<?php 
						$rowSupplymentCategory = $this->_dietmodel->getSupplementBycategory($mealID,$other_assistnce_catg->otherAssistanceCategory);
						foreach($rowSupplymentCategory as $suplmntCatg){
							
					?>
                      <tbody class="tbody1 TFtableCol">
						<tr>
							<td style="vertical-align:top;">
							<?php echo $suplmntCatg->supplement_name." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - ". $suplmntCatg->advice;
								$rowSupplementDetail = $this->_dietmodel->GetOtherAssistanceDetailData($suplmntCatg->otherAssistncSuplmntID);
								
							?>
							
								
							</td>
							<td style="vertical-align:top;"><?php echo $suplmntCatg->serving_size." ".$suplmntCatg->unit_name; ?></td>
						</tr>
                         </tbody>
					<?php } ?>
					
				</table>
				</section>	
				
				
			<?php 		
				}
			?>
				
				
			<section id="dietmealList" style="margin-top:25px;margin-bottom:30px;">
				<h4 class="text_s">List of Meals</h4>
					<?php 
					$rowMemberMealDtl = $this->_dietmodel->GetMemberMealDetail($mealID);
					foreach($rowMemberMealDtl as $memmealDtl){
					$rowMemFoodDtl = $this->_dietmodel->GetMemberFoodDtl($memmealDtl->id);	
					?>
					<table id="memberFoodDtl" class="table" border="0" cellspacing="0" cellpadding="0" style="width:100%;"  >
						<?php 
                        if( $Issuppliment=='Y'){$theadClass='thead2';}else{$theadClass='thead1';}
							if($memmealDtl->meal_no==11){
						?>
                         <thead class="<?php echo $theadClass;?>">
						<tr>
							<td><b><?php echo "Daily Recommendation"; ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
                            </thead>
						</tr>
						<?php }else{?>
                         <thead class="<?php echo $theadClass;?>">
						<tr>
							<td><b><?php echo "Meal ".$memmealDtl->meal_no ; ?></b> &nbsp;&nbsp;&nbsp;Time : <?php echo date("h:i A",strtotime($memmealDtl->meal_time)); ?></td>
							<td>&nbsp;</td>
						</tr>
                        </thead>
						<?php } ?>
                         <tbody class="tbody1 TFtableCol">
						<tr>
							
							
							<?php if($memmealDtl->meal_no==11){ ?>
							<td width="40%"><b><i>Food</i></b></td>
							<td width="20%"><b><i>Qty</i></b></td>
							<td width="40%"><b><i>Instruction</i></b></td>
							<?php }else{?>
							<td width="50%"><b><i>Food</i></b></td>
							<td width="50%"><b><i>Qty</i></b></td>
							<?php }?>
						</tr>
						<?php foreach($rowMemFoodDtl as $foodDtl){?>
							<tr>
								<td><?php echo $foodDtl->food_name; ?></td>
								<td><?php echo $foodDtl->food_qty." ".$foodDtl->unit_name; ?></td>

								<?php if($memmealDtl->meal_no==11){ ?>
							
							<td><?php echo $foodDtl->instruction; ?></td>
							<?php }?>
								
							</tr>
						<?php } ?>
                         </tbody>
					</table>
					<?php } ?>
			</section>	
			
			
				<?php if($specialnote){
					$array_note = explode(PHP_EOL, $specialnote);
					?>
				<section>
					<strong>Special Note**</strong><br>
					<?php 
						foreach($array_note as $key=>$val){
							echo "&nbsp;&nbsp;&nbsp;".$array_note[$key]."<br>";
						}
					?>
					
					
					
				</section>
				<?php }else{echo "";} ?>
				
				<section>
					<p><strong>Dietitian : </strong><?php echo $dietitian; ?></p>
				<section>
				
			</div>
			<div class="memberInfo">
				<p><strong>Disclaimer:</strong></p>

				<p>The information given on this page through various calculations are designed to help you make informed about your health. It is not intended as a substitute for the advice or treatment that may have been prescribed by your physician. These calculations are not accurate for pregnant or nursing women or children. Before adhering to any recommendations, you should consult with your physician.</p>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
	
?>