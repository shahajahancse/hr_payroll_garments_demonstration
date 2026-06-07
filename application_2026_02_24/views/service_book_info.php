<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Information</title>

<style>
.bordered { border: 2px solid black; border-collapse: collapse; font-size:12px;}
.bordered td, .bordered th { border: 1px solid #ffff; }
.bordered th { background: #C9C9C9; }
.bordered tr:nth-of-type(odd) { background-color: #F7F7F7; }

.emp_info{ background:#DFDFFF; }
.service tr:nth-child(even){background:#BFBF7F}
.service tr:nth-child(odd){background:#BFDF7F}
</style>
</head>

<body style="width:750px;">

<?php $row_count = count($values["emp_id"]); ?>

<?php for($i=0;$i < $row_count;$i++){ ?>

<div style="height:980px;margin-bottom:50px;">

<!-- ================= HEADER ================= -->

<table style="width:100%;">
<tr style="font-size:22px;font-weight:bold;">
<td>
<?php echo $this->db->where("unit_id",$unit_id)
->get('pr_units')->row()->unit_name;?>
</td>

<td rowspan="4" width="80">
<img border="1"
src="<?php echo base_url();?>uploads/photo/<?=
$values['img_source'][$i] ?? '';?>"
height="120" />
</td>
</tr>

<tr>
<td style="font-size:18px;text-decoration:underline;
font-style:italic;font-weight:bold;">
Service Book Information
</td>
</tr>
</table>

<!-- ================= BASIC INFO ================= -->

<table style="width:100%;border:1px solid;margin-top:10px;" cellpadding="6">

<tr><td width="170" style="background:#BFBFFF">ID NO</td>
<td style="background:#DFDFFF"><?=$values["emp_id"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Employee Name</td>
<td style="background:#DFDFFF"><?=$values["emp_name"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Father Name</td>
<td style="background:#DFDFFF"><?=$values["emp_fname"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Mother Name</td>
<td style="background:#DFDFFF"><?=$values["emp_mname"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Designation</td>
<td style="background:#DFDFFF"><?=$values["desig_name"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Section</td>
<td style="background:#DFDFFF"><?=$values["sec_name"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Line</td>
<td style="background:#DFDFFF"><?=$values["line_name"][$i]?></td></tr>

<?php
$dob = date("Y-m-d",strtotime($values["emp_dob"][$i]));
$doj = date("Y-m-d",strtotime($values["doj"][$i]));
$today = date("Y-m-d");
?>

<tr><td style="background:#BFBFFF">Date of Birth</td>
<td style="background:#DFDFFF"><?=$dob?></td></tr>

<tr><td style="background:#BFBFFF">Date of Join</td>
<td style="background:#DFDFFF"><?=$doj?></td></tr>

<?php
$age = date_diff(date_create($dob),date_create($today));
?>

<tr><td style="background:#BFBFFF">Age</td>
<td style="background:#DFDFFF">
<?=$age->y?> Years <?=$age->m?> Months <?=$age->d?> Days
</td></tr>

<tr><td style="background:#BFBFFF">Religion</td>
<td style="background:#DFDFFF"><?=$values["religion_name"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Sex</td>
<td style="background:#DFDFFF">
<?=$values["emp_sex"][$i]==1?'Male':'Female'?>
</td></tr>

<tr><td style="background:#BFBFFF">Marital Status</td>
<td style="background:#DFDFFF">
<?=$values["marital_status"][$i] ?? ''?>
</td></tr>

<tr><td style="background:#BFBFFF">Blood Group</td>
<td style="background:#DFDFFF"><?=$values["blood_name"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Permanent Address</td>
<td style="background:#DFDFFF"><?=$values["emp_par_add"][$i]?></td></tr>

<tr><td style="background:#BFBFFF">Present Address</td>
<td style="background:#DFDFFF"><?=$values["emp_pre_add"][$i]?></td></tr>

</table>

<!-- ================= SERVICE BOOK ================= -->

<?php
$emp_id = $values["emp_id"][$i];

$query = $this->db->where('ref_id',$emp_id)
->order_by('effective_month','asc')
->get('pr_incre_prom_pun');
?>

<table class="service" style="width:100%;margin-top:20px;" cellpadding="5">

<tr style="font-weight:bold;background:#FF7F7F">
<td colspan="9" align="center">Service Book</td>
</tr>

<tr style="font-weight:bold;background:#BFBFFF">
<th>SI</th>
<th>Status</th>
<th>Date</th>
<th>Dept</th>
<th>Section</th>
<th>Line</th>
<th>Designation</th>
<th>Inc Amt</th>
<th>Salary</th>
</tr>

<?php
$k = 1;
foreach($query->result() as $rows):

$inc_amt = $rows->new_salary - $rows->prev_salary;

/* ===== SKIP ZERO INCREMENT ===== */
if($inc_amt == 0) continue;
?>

<tr>
<td><?=$k++?></td>
<td><?=$rows->status==1?'Increment':'Promotion'?></td>
<td><?=date("d-M-Y",strtotime($rows->effective_month))?></td>
<td><?=$this->common_model->get_dept_name($rows->new_dept)?></td>
<td><?=$this->common_model->get_section_name($rows->new_section)?></td>
<td><?=$this->common_model->get_line_name($rows->new_line)?></td>
<td><?=$this->common_model->get_desig_name($rows->new_desig)?></td>
<td><?=$inc_amt?></td>
<td><?=$rows->new_salary?></td>
</tr>

<?php endforeach; ?>

</table>

</div>

<?php } exit; ?>

</body>
</html>
