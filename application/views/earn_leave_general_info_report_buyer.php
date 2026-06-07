<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Earn Leave Payment Sheet of <?php echo date('Y',strtotime($year)) ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/table.css" />

</head>
	<style>
		.bordered {
			border: 2px solid black;
			border-collapse: collapse;
			font-size:12px;
			border-radius:3px;
		}
		.bordered td, .bordered th {
			border: 1px solid #ffff;
		}
		.bordered th {
			background: #C9C9C9;
		}
		.bordered tr:nth-of-type(odd) {
			background-color: #F7F7F7;
		}
		.bordered tr:hover {
			background: #C9C9C9;
			-o-transition: all 0.1s ease-in-out;
			-webkit-transition: all 0.1s ease-in-out;
			-moz-transition: all 0.1s ease-in-out;
			-ms-transition: all 0.1s ease-in-out;
			transition: all 0.1s ease-in-out;     
		}
		.bottom_txt_design{
			border-top:1px solid;
			width:150px;
			font-weight:bold;
			font-size:12px;
		}
		.bottom_txt_manager_design{
			border-top:1px solid;
			width:170px;
			font-size:12px;
		}
		td { padding:3px; height:30px;}
	</style>
<body>
	<?php 
		// dd($values);
		if(empty($values)){
			echo "No data found"; exit;
		}

		// If controller passed an array of stdClass objects (rows), normalize
		// into the associative array-of-columns format this view expects.
		if (is_array($values) && isset($values[0]) && is_object($values[0])) {
			$raw = $values;
			$values = [];
			foreach ($raw as $r) {
				$values['emp_id'][] = isset($r->emp_id) ? $r->emp_id : (isset($r->id) ? $r->id : '');
				$values['emp_name'][] = isset($r->name_en) ? $r->name_en : (isset($r->name) ? $r->name : '');
				$values['desig_name'][] = isset($r->desig_name) ? $r->desig_name : '';
				$values['line_name'][] = isset($r->line_name_en) ? $r->line_name_en : (isset($r->line_name) ? $r->line_name : '');
				$values['emp_join_date'][] = isset($r->emp_join_date) ? $r->emp_join_date : (isset($r->jod) ? $r->jod : '');
				$values['gross_sal'][] = isset($r->gross_sal) ? $r->gross_sal : (isset($r->com_gross_sal) ? $r->com_gross_sal : 0);
				$values['basic_sal'][] = isset($r->basic_sal) ? $r->basic_sal : 0;
				$values['ttl_wk_days'][] = isset($r->t_days) ? $r->t_days : (isset($r->ttl_wk_days) ? $r->ttl_wk_days : 0);
				$values['P'][] = isset($r->P) ? $r->P : 0;
				$values['A'][] = isset($r->A) ? $r->A : 0;
				$values['el'][] = isset($r->el) ? $r->el : 0;
				$values['net_pay'][] = isset($r->net_pay) ? $r->net_pay : 0;
				$values['sec_name'][] = isset($r->sec_name_en) ? $r->sec_name_en : (isset($r->sec_name) ? $r->sec_name : '');
			}
		}

		$row_count = isset($values["emp_id"]) ? count($values["emp_id"]) : 0;
		if($row_count >13){
			$page=ceil($row_count/13);
		}
		else{
		$page=1;
		}

		$k = 0;

		// track seen emp IDs across pages to avoid duplicate rows
		$seen_emp_ids = array();

		$grand_total_gross    		=0;
		$grand_total_basic    		=0;
		$grand_total_working_day  	=0;
		$grand_total_payable_day	=0;
		$grand_total_el_days  		=0;
		$grand_total_absent_day   	=0;
		$grand_total_net_el  		=0;
		$grand_total_net_amount  	=0;
		$grand_total_net_amount_b_d	=0;
		$grand_total_stamp			=0;
		$grand_total_payable_amount  		=0;
		
	for ( $counter = 1; $counter <= $page; $counter ++){
		// calculate this page range before rendering header
		$per_page_row = ($counter == $page) ? (($row_count - 1) % 13) : 13;
		$start = $k;
		$end = $start + $per_page_row;
		if ($end >= $row_count) {
			$end = $row_count - 1;
		}
		$indices = range($start, $end);

		// decide if this page will render any rows (not empty and not duplicate)
		$will_render = false;
		foreach ($indices as $idx_check) {
			$empIdCheck = isset($values['emp_id'][$idx_check]) ? trim((string) $values['emp_id'][$idx_check]) : '';
			if ($empIdCheck === '') continue;
			if (!in_array($empIdCheck, $seen_emp_ids, true)) { $will_render = true; break; }
		}

		if (!$will_render) {
			$k = $end + 1; // advance index past this page
			continue; // skip rendering empty page
		}

	?>
	<div style=" margin:0 auto;">
		<?php $this->load->view("head_english"); ?>
		<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:1000px; margin-bottom:80px;">
			<span style="font-size:13px; font-weight:bold;">Earn Leave Payment Sheet of <?php echo date('Y',strtotime($year));?></span>
			<br />
			<div style="width:950px;">
				<div style="text-align:right; right:120px; position:relative;">Disbursement Date:</div>
			</div>
			<table class="bordered" border="1"  style="font-size:12px; text-align:center;">
				<tr style="height:30px;padding:3px;">
					<th width="30">SL</th>
					<th width="80">Emp ID</th>
					<th width="150">Name and Designation</th>
					<th width="150">Line</th>
					<th width="80">DOJ</th>
					<th width="50">Gross</th>
					<th width="50">Basic</th>
					<th width="70">Total Days</th>
					<th width="80">Working Days</th>
					<th width="30">EL</th>
					<th width="30">Absent</th>
					<th width="50">Net EL</th>
					<th width="80">Net Amount</th>
					<th width="50">Stamp</th>
					<th width="80">Payable Amount</th>
					<th width="120">Signature</th>
				</tr>
				<?php
					$total_gross    	=0;
					$total_basic    	=0;
					$total_working_day  =0;
					$total_payable_day	=0;
					$total_el_days  	=0;
					$total_absent_day   =0;
					$total_net_el  		=0;
					$total_net_amount  	=0;
					$total_net_amount_b_d=0;
					$total_stamp 		=0;
					$total_payable_amount  	=0;

					$section=array();
					if($counter == $page)
					{
						$modulus = ($row_count-1) % 13;
						$per_page_row=$modulus;
					}
					else{
						$per_page_row=13;
					}

					$start = $k;
					$end = $start + $per_page_row;
					if ($end >= $row_count) {
						$end = $row_count - 1;
					}
					$indices = range($start, $end);

					foreach ($indices as $idx) {
						// skip rows where emp_id is empty/null
						$empId = isset($values['emp_id'][$idx]) ? trim((string) $values['emp_id'][$idx]) : '';
						if ($empId === '') {
							continue;
						}

						// skip duplicate emp_id (already rendered)
						if (in_array($empId, $seen_emp_ids, true)) {
							continue;
						}
						$seen_emp_ids[] = $empId;
						echo "<tr>";

						echo "<td>";
						echo $s = $idx + 1;
						echo "</td>";

						echo "<td style='font-weight:bold;'>";
						echo $values["emp_id"][$idx];
						echo "</td>";

						echo "<td align='left'>";
						echo "<span style='font-family:Arial, Helvetica, sans-serif;font-weight:bold;'>";
						print_r($values["emp_name"][$idx]);
						echo "</span>";
						echo "<br>";
						echo "<span style='font-family:Arial, Helvetica, sans-serif;'>";
						print_r($values["desig_name"][$idx]);
						echo "</span>";
						echo "</td>";

						echo "<td style='font-weight:bold;'>";
						echo $values["line_name"][$idx];
						echo "</td>";

						$doj = date("d-M-Y", strtotime($values["emp_join_date"][$idx]));
						echo "<td >";
						echo $doj;
						echo "</td>";

						echo "<td >";
						echo $values["gross_sal"][$idx];
						echo "</td>";
						$total_gross = $total_gross + $values["gross_sal"][$idx];
						$grand_total_gross = $grand_total_gross + $values["gross_sal"][$idx];

						echo "<td >";
						echo $values["basic_sal"][$idx];
						echo "</td>";
						$total_basic = $total_basic + $values["basic_sal"][$idx];
						$grand_total_basic = $grand_total_basic + $values["basic_sal"][$idx];

						$tot_wor_day = $values["ttl_wk_days"][$idx];
						$el = $values["el"][$idx];
						$cl = $values["cl"][$idx];
						$ml = $values["ml"][$idx];
						$sl = $values["sl"][$idx];
						$ads_day = $values["A"][$idx];
						$h = $values["H"][$idx];
						$w = $values["W"][$idx];

						echo "<td align='right' style='padding-right:5px;'>";
						echo $values["ttl_wk_days"][$idx];
						echo "</td>";
						$total_working_day = $total_working_day + $values["ttl_wk_days"][$idx];
						$grand_total_working_day = $grand_total_working_day + $values["ttl_wk_days"][$idx];

						echo "<td align='right' style='padding-right:5px;'>";
						echo $values["P"][$idx];
						echo "</td>";
						$total_payable_day = $total_payable_day + $values["P"][$idx];
						$grand_total_payable_day = $grand_total_payable_day + $values["P"][$idx];

						echo "<td align='right' style='padding-right:5px;'>";
						echo $values["el"][$idx];
						echo "</td>";
						$total_el_days = $total_el_days + $values["el"][$idx];
						$grand_total_el_days = $grand_total_el_days + $values["el"][$idx];

						echo "<td align='right' style='padding-right:5px;'>";
						echo $values["A"][$idx];
						echo "</td>";
						$total_absent_day = $total_absent_day + $values["A"][$idx];
						$grand_total_absent_day = $grand_total_absent_day + $values["A"][$idx];

						$net_el = ($values["P"][$idx] / 18) - $el;

						echo "<td align='right' style='padding-right:5px;'>";
						echo number_format($net_el, 2);
						echo "</td>";
						$total_net_el = $total_net_el + number_format($net_el, 2);
						$grand_total_net_el = $grand_total_net_el + number_format($net_el, 2);

						$net_amount = ($values["net_pay"][$idx]);

						echo "<td align='right' style='padding-right:5px; font-weight:bold;'>";
						echo number_format($net_amount, 0);
						echo "</td>";
						$total_net_amount_b_d = $total_net_amount_b_d + $net_amount;
						$grand_total_net_amount_b_d = $grand_total_net_amount_b_d + $net_amount;

						echo "<td align='right' style='padding-right:5px;'>";
						if ($net_amount >= 510) {
							echo $stamp = 10;
						} else {
							echo $stamp = 0;
						}
						$total_stamp = $total_stamp + $stamp;
						$grand_total_stamp = $grand_total_stamp + $stamp;

						echo "<td align='right' style='padding-right:5px; font-weight:bold;'>";
						$net_amount = $net_amount - $stamp;
						echo number_format($net_amount, 0);
						echo "</td>";
						$total_payable_amount = $total_payable_amount + $net_amount;
						$grand_total_payable_amount = $grand_total_payable_amount + $net_amount;

						echo "<td style='height:77px'>";
						echo "";
						echo "</td>";

						echo "</tr>";
						$section = $values["sec_name"][$idx];
					}
					$k = $end + 1;
					echo "<tr style='font-weight:bold; background-color:#CCC;'>";
					echo "<td colspan='5' align='center'>";
					echo "Page Total";
					echo "</td>";
					
					echo "<td align='center'>";
					echo number_format($total_gross);
					echo "</td>";
					
					echo "<td align='right'>";
					echo number_format($total_basic);
					echo "</td>";
					
					echo "<td align='right'>";
					echo $total_working_day;
					echo "</td>";
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo $total_payable_day;
					echo "</td>";
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo $total_el_days;
					echo "</td>";
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo $total_absent_day;
					echo "</td>";		
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo $total_net_el;
					echo "</td>";		
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo round($total_net_amount_b_d);
					echo "</td>";
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo $total_stamp;
					echo "</td>";	
					
					echo "<td align='right' style='padding-right:5px;'>";
					echo round($grand_total_payable_amount);
					echo "</td>";		
				
					echo "</tr>";
				?>
					<?php
						if($counter == $page){?>
							<tr height="10">
								<td align="center" colspan="5"><strong style="font-size:13px;">Grand Total</strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_gross);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_basic);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_working_day);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_payable_day);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_el_days);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_absent_day);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_el);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_amount_b_d);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_stamp);?></strong></td>
								<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_payable_amount);?></strong></td>
							</tr>
					<?php } ?>
					<br>
					<table width="100%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
						<tr height="80%" ><td colspan="29"></td></tr>
						<tr height="20%">
							<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Prepared By</dt></td>
							<td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Accounts Exe.</dt></td>
							<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR/Sr Manager</dt></td>
							<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM(HR,Admin&Compl.)</dt></td>
							<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM</dt></td>
							<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
						</tr>
					</table>
			</table>
		</div>
	</div>
<?php  } exit; ?>
</body>
</html>