<?php

class Import extends CI_Controller {
	function __construct(){
		parent::__construct();
	}

	function index(){
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
	        <meta http-equiv="Content-Type" content="text/csv; charset=utf-8"/>
	        <title>IMPORT</title>
        </head>
		<body>

		<?php
		/********************************/
		/* Code at http://legend.ws/blog/tips-tricks/csv-php-mysql-import/
		/* Edit the entries below to reflect the appropriate values
		/********************************/
		$databasetable = "pr_emp_per_info";
		$fieldseparator = "\t";
		$lineseparator = "\n";
		// $csvfile = "import/Staff_txt_UTF.txt";
		$csvfile = "import/Staff_txt_UTF.txt";

		/********************************/

		/* Would you like to add an ampty field at the beginning of these records?

		/* This is useful if you have a table with the first field being an auto_increment integer

		/* and the csv file does not have such as empty field before the records.

		/* Set 1 for yes and 0 for no. ATTENTION: don't set to 1 if you are not sure.

		/* This can dump data in the wrong fields if this extra field does not exist in the table

		/********************************/

		$addauto = 1;

		/********************************/

		/* Would you like to save the mysql queries in a file? If yes set $save to 1.

		/* Permission on the file should be set to 777. Either upload a sample file through ftp and

		/* change the permissions, or execute at the prompt: touch output.sql && chmod 777 output.sql

		/********************************/

		$save = 1;

		// $outputfile = "import/output_staff.txt";
		$outputfile = "import/output_worker.txt";

		/********************************/

		if(!file_exists($csvfile)) {
			echo "File not found. Make sure you specified the correct path.\n";
			exit;
		}
		$file = fopen($csvfile,"r");

		if(!$file) {
			echo "Error opening data file.\n";
			exit;
		}

		$size = filesize($csvfile);
		if(!$size) {
			echo "File is empty.\n";
			exit;
		}
		$csvcontent = fread($file,$size);
		fclose($file);

		//echo $check = file_put_contents($tmpfile, str_replace("\t", ";",  iconv('UTF-16', 'UTF-8', file_get_contents($csvfile))));

		$lines = 0;
		$queries = "";
		$linearray = array();
		$line_by_array = explode($lineseparator,$csvcontent);

		//foreach(explode($lineseparator,$csvcontent) as $line) {

		$count = count($line_by_array);
		// for($i = 0 ; $i < $count - 1; $i++) {
		for($i = 1 ; $i < $count; $i++) {
			$lines++;
			$line = trim($line_by_array[$i]);
			//echo $line.'<br>';

			//$line = trim($line," \t");

			//$line = str_replace("\r","\t",$line);

			/***********************************

			This line escapes the special character. remove it if entries are already escaped in the csv file

			***********************************/

			//$line = str_replace("'","\'",$line);

			/************************************/

			//echo $line.'<br>';

			$linearray = explode($fieldseparator,$line);

			//print_r($linearray);
			//echo '=========================';
			//$linemysql = implode("','",$linearray);

			$emp_name  	= trim($linearray[0]);
			$emp_b_name	= trim($linearray[1]);
			echo $emp_id 	= trim($linearray[2]).',';
			$dept_name	= trim($linearray[3]);
			$sec_name	= trim($linearray[4]);
			$line_name	= trim($linearray[5]);
			$desig_name	= trim($linearray[6]);
			
			$sal_grade	= trim($linearray[7]);
			$doj 		= trim($linearray[8]);
			$dob 		= trim($linearray[9]);
			$sal_gross	= trim($linearray[10]);
			$att_bonus	= trim($linearray[11]);
			$gender		= trim($linearray[12]);
			$marital	= trim($linearray[13]);

			$ot			= trim($linearray[14]);

			$fthr_name= trim($linearray[15]);
			$fthr_name_b= trim($linearray[16]);
			$mthr_name= trim($linearray[17]);
			$mthr_name_b= trim($linearray[18]);

			$pre_add= trim($linearray[19]);
			$par_add= trim($linearray[20]);
			$pre_add_b= trim($linearray[21]);
			$par_add_b= trim($linearray[22]);

			$district		= trim($linearray[23]);
			$pr_emp_edu		= trim($linearray[24]);
			$religion		= trim($linearray[25]);

			$nid			= trim($linearray[26]);
			$emp_blood		= trim($linearray[27]);
			$bank_ac		= trim($linearray[28]);

			$com_gross	= $sal_gross;

			//$unit_id = substr($emp_id, 0, 1);
			
			$unit_id = 1;
			$emp_position_id = 1;//Stuff =1 And Worker =2

			if($gender 	=='F'  ){ $gender 	= 2; }else{ $gender = 1; }
			if($marital =='Married'){ $marital 	= 2; }else{ $marital= 1; }
			if($ot 		=='Yes'){ $ot 		= 0; }else{ $ot 	= 1; }

			if($line_name ==''){ $line_id 	= 0; }else{$line_id=$line_name;}

			if($dept_name ==''){ $dept_name 	= 'None'; }
			if($sec_name ==''){ $sec_name 	= 'None'; }
			if($district ==''){ $district 	= 'None'; }
			if($desig_name ==''){ $desig_name 	= 'None'; }
			if($sal_grade ==''){ $sal_grade 	= 'None'; }
			if($religion ==''){ $religion 	= 'None'; }
			if($att_bonus =='Yes'){ $att_bonus 	= '1'; }else{ $att_bonus 	= '2'; }

			/*$this->check_dept($dept_name,$unit_id);
			$this->check_section($sec_name,$unit_id);
			$this->check_district($district);
			$this->check_designation($desig_name,$unit_id);
			$this->check_salgrade($sal_grade);
			$this->check_religion($religion);*/
			// $this->check_att_bonus($bonus_name);

			/*$dept_id = $this->get_department_id_by_name($dept_name,$unit_id);
			$sec_id  = $this->get_section_id_by_name($sec_name,$unit_id);
			$district_id = $this->get_district_id_by_name($district);
			$desig_id = $this->get_designation_id_by_name($desig_name,$unit_id);
			$sal_grade_id = $this->get_salary_grade_id_by_name($sal_grade);
			$religion_id = $this->get_religion_id_by_name($religion);*/
			// $bonus_id = $this->get_bonus_id_by_name($bonus_name);
			
			
			$dob1 = date('Y-m-d', strtotime($dob));
			$doj1 = date('Y-m-d', strtotime($doj));

			//echo "$emp_id====$emp_name===$dob-->$dob1<br>";

			/*if($addauto){
				echo $query =  "INSERT INTO $databasetable (`emp_id`, `emp_full_name`, `bangla_nam`, `national_brn_id`, `emp_fname`, `emp_fname_bn`, `emp_mname`, `emp_mname_bn`, `emp_dob`, `emp_religion`, `emp_sex`, `emp_marital_status`, `emp_blood`, `bank_ac_no` ) VALUES ('$emp_id', '$emp_name', '$emp_b_name', '$nid','$fthr_name','$fthr_name_b','$mthr_name','$mthr_name_b','$dob1','$religion_id', '$gender', '$marital', '$emp_blood', '$bank_ac');";
				echo "<br>";

				echo $query2 = "INSERT INTO pr_emp_com_info (`emp_id`,`unit_id`,`emp_dept_id`, `emp_sec_id`, `emp_line_id`, `emp_desi_id`,`emp_operation_id`,`emp_position_id`, `emp_sal_gra_id`, `emp_cat_id`, `emp_shift`, `gross_sal`,`com_gross_sal`, `ot_entitle`, `transport`, `lunch`, `att_bonus`, `salary_draw`,`salary_type`,`emp_join_date`) VALUES ('$emp_id',$unit_id,$dept_id,$sec_id,$line_id,$desig_id,0,$emp_position_id,'$sal_grade_id',1,1,'$sal_gross','$com_gross',$ot,1,1,'$att_bonus',1,1,'$doj1' );";
				echo "<br>";

				echo $query3 =  "INSERT INTO pr_emp_add (`emp_id`, `emp_pre_add`, `emp_par_add`, `emp_par_dis`, `emp_pre_add_ban`, `emp_par_add_ban`) VALUES ('$emp_id','$pre_add','$par_add','$district_id','$pre_add_b','$par_add_b');";
				echo "<br>";

				echo $query4 =  "INSERT INTO pr_emp_edu (`emp_id`,`emp_degree`) VALUES ('$emp_id','$pr_emp_edu');";
				echo "<br>";

				echo $query5 =  "INSERT INTO pr_emp_skill (`emp_id`) VALUES ('$emp_id');";
				echo "<br>";

				echo $query6 =  "INSERT INTO pr_id_proxi (`emp_id`,`proxi_id`) VALUES ('$emp_id','$emp_id');";
				echo "<br>";

				echo $query7 = "CREATE TABLE IF NOT EXISTS `temp_$emp_id` (`att_id` int(11) NOT NULL AUTO_INCREMENT, `device_id` int(11) DEFAULT NULL, `proxi_id` int(11) DEFAULT NULL, `date_time` datetime DEFAULT NULL, PRIMARY KEY (`att_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

				echo "<br>";

				echo $query8 ="-- ======================================================================";
				}

			else

				echo $query =  "INSERT INTO $databasetable (`emp_id`,`emp_full_name`,`emp_dob`,`emp_marital_status`,`emp_blood`) VALUES ('$emp_id', '$emp_name', '$dob1', 1, 0);";

			$queries .= $query . "\n";
			$queries .= $query2 . "\n";
			$queries .= $query3 . "\n";
			$queries .= $query4 . "\n";
			$queries .= $query5 . "\n";
			$queries .= $query6 . "\n";
			$queries .= $query7 . "\n";
			$queries .= $query8 . "\n";
			echo "<br>";*/
			//@mysql_query($query);
		}

		//@mysql_close($con);
		/*if($save) {
			if(!is_writable($outputfile)) {
				echo "File is not writable, check permissions.\n";
			}else {
				$file2 = fopen($outputfile,"w");
				if(!$file2) {
					echo "Error writing to the output file.\n";
				}else {
					fwrite($file2,$queries);
					fclose($file2);
				}
			}
		}*/
		echo "Found a total of $lines records in this csv file.\n";
	?>
</body>
</html>
<?php
	}

	//Zuel
	function zuel_import_xlsx(){
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
	        <meta http-equiv="Content-Type" content="text/csv; charset=utf-8"/>
	        <title>IMPORT</title>
        </head>
		<body>

		<?php
		$fieldseparator = "\t";
		$lineseparator = "\n";

		$csvfile = './uploads/files/Worker_List_Ucode.csv';
		if(!file_exists($csvfile)) {
			echo "File not found. Make sure you specified the correct path.\n";
			exit;
		}
		$file = fopen($csvfile,"r");

		if(!$file) {
			echo "Error opening data file.\n";
			exit;
		}

		$size = filesize($csvfile);
		if(!$size) {
			echo "File is empty.\n";
			exit;
		}
		$csvcontent = fread($file,$size);
		fclose($file);

		//echo $check = file_put_contents($tmpfile, str_replace("\t", ";",  iconv('UTF-16', 'UTF-8', file_get_contents($csvfile))));

		$lines = 0;
		$queries = "";
		$linearray = array();
		$line_by_array = explode($lineseparator,$csvcontent);

		//foreach(explode($lineseparator,$csvcontent) as $line) {

		$count = count($line_by_array);
		for($i = 0 ; $i < $count - 1; $i++) {
			$lines++;
			$line = trim($line_by_array[$i]);

			$linearray = explode($fieldseparator,$line);

			print_r($linearray);

			//echo '=========================';

			// $linemysql = implode("','",$linearray);
			// echo $linemysql = implode("','",$linearray);
			// print_r($linemysql);
			// echo $emp_name  	= $linearray[0];
			/*echo $emp_b_name	= $linearray[1];
			echo $emp_id 	= $linearray[2];
			echo $dept_name	= $linearray[3];
			echo $sec_name	= $linearray[4];*/
			echo "<br>";
		}
		echo "string";
	?>
</body>
</html>
<?php
	}

	function check_dept($dept_name,$unit_id){
		$num_row = $this->db->where('dept_name',trim($dept_name))->where('unit_id',$unit_id)->get('pr_dept')->num_rows();

		if($num_row < 1){
			$dept_name = trim($dept_name);
			$data = array(
				'unit_id' => $unit_id,
				'dept_name' => $dept_name
			);
			$this->db->insert('pr_dept', $data); 
		}
	}

	function check_section($sec_name,$unit_id){
		$num_row = $this->db->where('sec_name',trim($sec_name))->where('unit_id',$unit_id)->get('pr_section')->num_rows();
		if($num_row < 1){
			$sec_name = trim($sec_name);
			$data = array(
				'unit_id' => $unit_id,
				'sec_name' => $sec_name
			);
			$this->db->insert('pr_section', $data); 
		}
	}

	function check_district($district_name){
		$num_row = $this->db->where('name_en',trim($district_name))->get('district')->num_rows();
		if($num_row < 1){
			$district_name = trim($district_name);
			$data = array(
				'name_en' => $district_name
			);
			$this->db->insert('district', $data); 
		}
	}

	function check_designation($desig_name,$unit_id){
		$num_row = $this->db->where('desig_name',trim($desig_name))->where('unit_id',$unit_id)->get('pr_designation')->num_rows();
		if($num_row < 1){
			$desig_name = trim($desig_name);
			$data = array(
				'unit_id' => $unit_id,
				'desig_name' => $desig_name

			);
			$this->db->insert('pr_designation', $data);
		}
	}

	function check_salgrade($salgrade_name){
		$num_row = $this->db->where('gr_name',trim($salgrade_name))->get('pr_grade')->num_rows();
		if($num_row < 1){
			$salgrade_name = trim($salgrade_name);
			$data = array(
				'gr_name' => $salgrade_name
			);
			$this->db->insert('pr_grade', $data); 
		}
	}
	function check_religion($religion){
		$num_row = $this->db->where('religion_name',trim($religion))->get('pr_religions')->num_rows();
		if($num_row < 1){
			$religion_name = trim($religion);
			$data = array(
				'religion_name' => $religion_name
			);
			$this->db->insert('pr_religions', $data); 
		}
	}
	
	function check_att_bonus($bonus_name){
		$num_row = $this->db->where('ab_rule_name',trim($bonus_name))->get('pr_attn_bonus')->num_rows();
		if($num_row < 1){
			$bonus_name = trim($bonus_name);
			$data = array(
				'ab_rule_name' => $bonus_name
			);
			$this->db->insert('pr_attn_bonus', $data); 
		}
	}

	function get_unit_id_by_name($unit_name){
		$this->db->select('unit_id');
		$this->db->where('unit_name',trim($unit_name));
		$query = $this->db->get('pr_units');
		$row = $query->row();
		return $unit_id = $row->unit_id;
	}

	function get_department_id_by_name($dept_name,$unit_id){
		$this->db->select('dept_id');
		$this->db->where('dept_name',trim($dept_name));
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get('pr_dept');
		$row = $query->row();
		return $dept_id = $row->dept_id;
	}

	function get_section_id_by_name($sec_name,$unit_id){
		$this->db->select('sec_id');
		$this->db->where('sec_name',trim($sec_name));
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get('pr_section');
		$row = $query->row();
		return $sec_id = $row->sec_id;
	}

	function get_district_id_by_name($district_name){
		$this->db->select('id');
		$this->db->where('name_en',trim($district_name));
		// $this->db->where('unit_id',$unit_id);
		$query = $this->db->get('district');
		$row = $query->row();
		return $district_id = $row->id;
	}

	function get_designation_id_by_name($desig_name,$unit_id){
		$this->db->select('desig_id');
		$this->db->where('desig_name',trim($desig_name));
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get('pr_designation');
		$row = $query->row();
		return $desig_id = $row->desig_id;
	}

	function get_salary_grade_id_by_name($sal_grade){
		$this->db->select('gr_id');
		$this->db->where('gr_name',trim($sal_grade));
		$query = $this->db->get('pr_grade');
		$row = $query->row();
		return $gr_id = $row->gr_id;
	}
	function get_religion_id_by_name($religion_name){
		$this->db->select('religion_id');
		$this->db->where('religion_name',trim($religion_name));
		$query = $this->db->get('pr_religions');
		$row = $query->row();
		return $religion_id = $row->religion_id;
	}

	function get_bonus_id_by_name($bonus_name){
		$this->db->select('ab_id');
		$this->db->like('ab_rule_name', trim($bonus_name));
		$query = $this->db->get('pr_attn_bonus');
		$row = $query->row();
		//echo $this->db->last_query();
		return $ab_id = $row->ab_id;
	}

	function add_phone(){
		date_default_timezone_set('Asia/Dhaka');
		$file_name = "import/cn.txt";
		if (file_exists($file_name)){
			$lines = file($file_name);
			foreach(array_values($lines)  as $line) {
				list($id, $amt) = preg_split('/\s+/', trim($line));
				$data = array(
					'emp_id' 		=> $id,
					'emp_com_name'	=> $amt,
				);
				$this->db->where('emp_id', $id);
				$this->db->insert('pr_emp_skill', $data);
			}
			echo "Upload successfully done";
		}
	}

	function inc_pro(){
		date_default_timezone_set('Asia/Dhaka');
		$file_name = "import/increment.txt";
		if (file_exists($file_name)){
			$lines = file($file_name);
			// dd($lines);
			foreach(array_values($lines)  as $line) {

				list($id, $desig_id,$salary,$grade,$effect_date) = preg_split('/\s+/', trim($line));
				$emp_pre_info = $this->db->select('emp_id,emp_dept_id,emp_sec_id,emp_line_id,emp_desi_id,emp_sal_gra_id,gross_sal,com_gross_sal')->from('pr_emp_com_info')->where('emp_id',$id)->get()->row();
				if (empty($emp_pre_info)) {
					// echo $id."<br>";
					continue;
				}
				// echo "<pre>";print_r($emp_pre_info);				
				$data = array(
					'prev_emp_id'     => $emp_pre_info->emp_id,
					'prev_dept'       => $emp_pre_info->emp_dept_id,
					'prev_section'    => $emp_pre_info->emp_sec_id,
					'prev_line'       => $emp_pre_info->emp_line_id,
					'prev_desig'      => $emp_pre_info->emp_desi_id,
					'prev_grade'      => $emp_pre_info->emp_sal_gra_id,
					'prev_salary'     => $emp_pre_info->gross_sal,
					'prev_com_salary' => $emp_pre_info->com_gross_sal,
					'new_emp_id'      => $emp_pre_info->emp_id,
					'new_dept'        => $emp_pre_info->emp_dept_id,
					'new_section'     => $emp_pre_info->emp_sec_id,
					'new_line'        => $emp_pre_info->emp_line_id,
					'new_desig'       => $desig_id,
					'new_grade'       => $grade,
					'new_salary'      => $salary,
					'new_com_salary'  => $salary,
					'effective_month' => date('Y-m-d',strtotime($effect_date)),
					'ref_id' 		  =>  $emp_pre_info->emp_id,
					'status' 		  =>1
				);
				// echo "<pre>";print_r($data);
				// dd($data);
				$insert = $this->db->where('prev_emp_id', $id)->insert('pr_incre_prom_pun', $data);
				if($insert){
					$data = array(
							// 'emp_id'		 =>$id,
							// 'emp_desi_id'	 =>$desig_id,	
							// 'emp_sal_gra_id' =>$grade,		
							'gross_sal'		 =>$salary,
							'com_gross_sal'  =>$salary 		
					);
					// $this->db->where('prev_emp_id', $id);
					$this->db->where('emp_id', $id)->update('pr_emp_com_info', $data);
				}
			}
			echo "Upload successfully done";
		}
	}

	function inc(){
		// dd("lo");
		date_default_timezone_set('Asia/Dhaka');
		$file_name = "import/incre.txt";
		if (file_exists($file_name)){
			$lines = file($file_name);
			// dd($lines);
			foreach(array_values($lines)  as $line) {
				// dd($line);
				list($id,$salary,$effect_date) = preg_split('/\s+/', trim($line));
				// dd($id.'==='.$salary.'==='.$effect_date);
				$emp_pre_info = $this->db->select('emp_id,emp_dept_id,emp_sec_id,emp_line_id,emp_desi_id,emp_sal_gra_id,gross_sal,com_gross_sal')->from('pr_emp_com_info')->where('emp_id',$id)->get()->row();
				// dd($emp_pre_info);
				if (empty($emp_pre_info)) {
					echo @$i++;
					continue;
				}			
				$data = array(
					'prev_emp_id'     => $emp_pre_info->emp_id,
					'prev_dept'       => $emp_pre_info->emp_dept_id,
					'prev_section'    => $emp_pre_info->emp_sec_id,
					'prev_line'       => $emp_pre_info->emp_line_id,
					'prev_desig'      => $emp_pre_info->emp_desi_id,
					'prev_grade'      => $emp_pre_info->emp_sal_gra_id,
					'prev_salary'     => $emp_pre_info->gross_sal,
					'prev_com_salary' => $emp_pre_info->com_gross_sal,
					'new_emp_id'      => $emp_pre_info->emp_id,
					'new_dept'        => $emp_pre_info->emp_dept_id,
					'new_section'     => $emp_pre_info->emp_sec_id,
					'new_line'        => $emp_pre_info->emp_line_id,
					'new_desig'       => $emp_pre_info->emp_desi_id,
					'new_grade'       => $emp_pre_info->emp_sal_gra_id,
					'new_salary'      => $salary,
					'new_com_salary'  => $salary,
					'effective_month' => date('Y-m-d',strtotime($effect_date)),
					'ref_id' 		  => $emp_pre_info->emp_id,
					'status' 		  => 1
				);
				// echo "<pre>";print_r($data);
				// dd($data);
				$insert = $this->db->where('prev_emp_id', $id)->insert('pr_incre_prom_pun', $data);
				if($insert){
					// dd($emp_pre_info->id);
					$data = array(
							'emp_sal_gra_id' =>$grade,		
							'gross_sal'		 =>$salary,
							'com_gross_sal'  =>$salary 		
					);
					// $this->db->where('prev_emp_id', $id);
					$this->db->where('emp_id', $id)->update('pr_emp_com_info', $data);
				}
			}
			echo "Upload successfully done";
		}
	}

	function import_dep1_compleate(){
		dd("import_dep1_compleate");
		$ajdata=$this->db->get('ajfl_final')->result();
		foreach($ajdata as $aj){
			$emp_id=$aj->ID;
			$dept=$aj->Department;
			$sec=$aj->Section;
			$line=$aj->Line;
			$desi=$aj->Designation;

			$this->db->where('dept_name', $dept);
			$this->db->where('unit_id', 1);
			$emp_depertment = $this->db->get('emp_depertment')->row();

			if(!empty($emp_depertment)){
				$dept_id = $emp_depertment->dept_id;
			}else{
				$this->db->insert('emp_depertment', array('dept_name' => $dept,'dept_bangla' => $dept, 'unit_id' => 1));
				$dept_id = $this->db->insert_id();
			}

			$this->db->where('sec_name_en', $sec);
			$this->db->where('unit_id', 1);
			$emp_section = $this->db->get('emp_section')->row();
			if(!empty($emp_section)){
				$sec_id = $emp_section->id;
			}else{
				$this->db->insert('emp_section', array('depertment_id'=> $dept_id,'sec_name_en' => $sec, 'sec_name_bn' => $sec, 'unit_id' => 1));
				$sec_id = $this->db->insert_id();
			}

			$this->db->where('line_name_en', $line);
			$this->db->where('unit_id', 1);
			$emp_line = $this->db->get('emp_line_num')->row();
			if(!empty($emp_line)){
				$line_id = $emp_line->id;
			}else{
				$this->db->insert('emp_line_num', array('section_id'=> $sec_id,'dept_id'=> $dept_id,'line_name_en' => $line,'line_name_bn' => $line, 'unit_id' => 1));
				$line_id = $this->db->insert_id();
			}

			$this->db->where('desig_name', $desi);
			$this->db->where('unit_id', 1);
			$emp_designation = $this->db->get('emp_designation')->row();
			if(!empty($emp_designation)){
				$desig_id = $emp_designation->id;
			}else{
				$this->db->insert('emp_designation', array('desig_name' => $desi,'desig_bangla' => $desi,'unit_id' => 1 ,'attn_id' => 1,'holiday_weekend_id' => 1,'iftar_id' => 1,'night_al_id' => 1,'tiffin_id' => 1,'hide_status' => 1));
				$desig_id = $this->db->insert_id();
			}

			// emp_dasignation_line_acl
			// id	
			// dept_id	
			// section_id	
			// line_id	
			// designation_id
			// unit_id	

			$this->db->where('unit_id', 1);
			$this->db->where('dept_id', $dept_id);
			$this->db->where('section_id', $sec_id);
			$this->db->where('line_id', $line_id);
			$this->db->where('designation_id', $desig_id);
			$emp_dasignation_line_acl = $this->db->get('emp_dasignation_line_acl')->row();

			if(empty($emp_dasignation_line_acl)){
				$this->db->insert('emp_dasignation_line_acl', array('dept_id' => $dept_id,'section_id' => $sec_id,'line_id' => $line_id,'designation_id' => $desig_id, 'unit_id' => 1));
			}

			$this->db->where('emp_id', $emp_id);
			$this->db->update('pr_emp_com_info', array('emp_dept_id' => $dept_id,'emp_sec_id' => $sec_id,'emp_line_id' => $line_id,'emp_desi_id' => $desig_id));
		}
	}
	function import_dep2(){
		dd('import_dep2');
		$ajdata=$this->db->get('lkfl_final')->result();
		foreach($ajdata as $aj){
			$emp_id=$aj->ID;
			$dept=$aj->Department;
			$sec=$aj->Section;
			$line=$aj->Line;
			$desi=$aj->Designation;

			$this->db->where('dept_name', $dept);
			$this->db->where('unit_id', 2);
			$emp_depertment = $this->db->get('emp_depertment')->row();

			if(!empty($emp_depertment)){
				$dept_id = $emp_depertment->dept_id;
			}else{
				$this->db->insert('emp_depertment', array('dept_name' => $dept,'dept_bangla' => $dept, 'unit_id' => 2));
				$dept_id = $this->db->insert_id();
			}

			$this->db->where('sec_name_en', $sec);
			$this->db->where('unit_id', 2);
			$emp_section = $this->db->get('emp_section')->row();
			if(!empty($emp_section)){
				$sec_id = $emp_section->id;
			}else{
				$this->db->insert('emp_section', array('depertment_id'=> $dept_id,'sec_name_en' => $sec, 'sec_name_bn' => $sec, 'unit_id' => 2));
				$sec_id = $this->db->insert_id();
			}

			$this->db->where('line_name_en', $line);
			$this->db->where('unit_id', 2);
			$emp_line = $this->db->get('emp_line_num')->row();
			if(!empty($emp_line)){
				$line_id = $emp_line->id;
			}else{
				$this->db->insert('emp_line_num', array('section_id'=> $sec_id,'dept_id'=> $dept_id,'line_name_en' => $line,'line_name_bn' => $line, 'unit_id' => 2));
				$line_id = $this->db->insert_id();
			}

			$this->db->where('desig_name', $desi);
			$this->db->where('unit_id', 2);
			$emp_designation = $this->db->get('emp_designation')->row();
			if(!empty($emp_designation)){
				$desig_id = $emp_designation->id;
			}else{
				$this->db->insert('emp_designation', array('desig_name' => $desi,'desig_bangla' => $desi,'unit_id' => 2 ,'attn_id' => 1,'holiday_weekend_id' => 1,'iftar_id' => 1,'night_al_id' => 1,'tiffin_id' => 1,'hide_status' => 1));
				$desig_id = $this->db->insert_id();
			}

			// emp_dasignation_line_acl
			// id	
			// dept_id	
			// section_id	
			// line_id	
			// designation_id
			// unit_id	

			$this->db->where('unit_id', 2);
			$this->db->where('dept_id', $dept_id);
			$this->db->where('section_id', $sec_id);
			$this->db->where('line_id', $line_id);
			$this->db->where('designation_id', $desig_id);
			$emp_dasignation_line_acl = $this->db->get('emp_dasignation_line_acl')->row();

			if(empty($emp_dasignation_line_acl)){
				$this->db->insert('emp_dasignation_line_acl', array('dept_id' => $dept_id,'section_id' => $sec_id,'line_id' => $line_id,'designation_id' => $desig_id, 'unit_id' => 2));
			}

			$this->db->where('emp_id', $emp_id);
			$this->db->update('pr_emp_com_info', array('emp_dept_id' => $dept_id,'emp_sec_id' => $sec_id,'emp_line_id' => $line_id,'emp_desi_id' => $desig_id));
		}
	}
	function import_dep4(){
		dd('import_dep4');
		$ajdata=$this->db->get('hnfl')->result();
		foreach($ajdata as $aj){
			$emp_id=$aj->ID;
			$dept=$aj->Department;
			$sec=$aj->Section;
			$line=$aj->Line;
			$desi=$aj->Designation;

			$this->db->where('dept_name', $dept);
			$this->db->where('unit_id', 4);
			$emp_depertment = $this->db->get('emp_depertment')->row();

			if(!empty($emp_depertment)){
				$dept_id = $emp_depertment->dept_id;
			}else{
				$this->db->insert('emp_depertment', array('dept_name' => $dept,'dept_bangla' => $dept, 'unit_id' => 4));
				$dept_id = $this->db->insert_id();
			}

			$this->db->where('sec_name_en', $sec);
			$this->db->where('unit_id', 4);
			$emp_section = $this->db->get('emp_section')->row();
			if(!empty($emp_section)){
				$sec_id = $emp_section->id;
			}else{
				$this->db->insert('emp_section', array('depertment_id'=> $dept_id,'sec_name_en' => $sec, 'sec_name_bn' => $sec, 'unit_id' => 4));
				$sec_id = $this->db->insert_id();
			}

			$this->db->where('line_name_en', $line);
			$this->db->where('unit_id', 4);
			$emp_line = $this->db->get('emp_line_num')->row();
			if(!empty($emp_line)){
				$line_id = $emp_line->id;
			}else{
				$this->db->insert('emp_line_num', array('section_id'=> $sec_id,'dept_id'=> $dept_id,'line_name_en' => $line,'line_name_bn' => $line, 'unit_id' => 4));
				$line_id = $this->db->insert_id();
			}

			$this->db->where('desig_name', $desi);
			$this->db->where('unit_id', 4);
			$emp_designation = $this->db->get('emp_designation')->row();
			if(!empty($emp_designation)){
				$desig_id = $emp_designation->id;
			}else{
				$this->db->insert('emp_designation', array('desig_name' => $desi,'desig_bangla' => $desi,'unit_id' => 4 ,'attn_id' => 1,'holiday_weekend_id' => 1,'iftar_id' => 1,'night_al_id' => 1,'tiffin_id' => 1,'hide_status' => 1));
				$desig_id = $this->db->insert_id();
			}

			// emp_dasignation_line_acl
			// id	
			// dept_id	
			// section_id	
			// line_id	
			// designation_id
			// unit_id	

			$this->db->where('unit_id', 4);
			$this->db->where('dept_id', $dept_id);
			$this->db->where('section_id', $sec_id);
			$this->db->where('line_id', $line_id);
			$this->db->where('designation_id', $desig_id);
			$emp_dasignation_line_acl = $this->db->get('emp_dasignation_line_acl')->row();

			if(empty($emp_dasignation_line_acl)){
				$this->db->insert('emp_dasignation_line_acl', array('dept_id' => $dept_id,'section_id' => $sec_id,'line_id' => $line_id,'designation_id' => $desig_id, 'unit_id' => 4));
			}

			$this->db->where('emp_id', $emp_id);
			$this->db->update('pr_emp_com_info', array('emp_dept_id' => $dept_id,'emp_sec_id' => $sec_id,'emp_line_id' => $line_id,'emp_desi_id' => $desig_id));
		}
	}


	function update_per_infos(){
		$datas = $this->db->select('*')->get('new_pr_emp_per_info')->result();
		foreach($datas as $data){
			$per_info = [
				'name_en'		=> $data->name_en,
				'name_bn'		=> $data->name_bn, 
				'father_name'	=> $data->father_name,
				'mother_name'	=> $data->mother_name,
				'spouse_name'	=> $data->spouse_name,
				'emp_dob' 		=> $data->emp_dob,
				'gender'		=> $data->gender,
				'religion' 		=> $data->religion,
				'blood' 		=> $data->blood,
				'm_child' 		=> $data->m_child,
				'f_child' 		=> $data->f_child,
				'education' 	=> $data->education,
				'nid_dob_check' => $data->nid_dob_check,
				'nid_dob_id' 	=> $data->nid_dob_id,
				'personal_mobile' => $data->personal_mobile,
				'bank_bkash_no'   => $data->bank_bkash_no,
				'pre_home_owner' 	=> $data->pre_home_owner,
				'holding_num' 		=> $data->holding_num,
				'home_own_mobile' 	=> $data->home_own_mobile,
				'pre_village_bn' 	=> $data->pre_village_bn, 
				'per_village_bn' 	=> $data->per_village_bn, 
				'nominee_name' 		=> $data->nominee_name,  
				'nominee_vill' 		=> $data->nominee_vill, 
				'nomi_mobile' 		=> $data->nomi_mobiole, 
				'nomi_relation'		=> $data->nomi_relation, 
				'refer_name'		=> $data->refer_name,
				'refer_mobile' 		=> $data->refer_mobile,
				'refer_relation' 	=> $data->refer_relation, 
				'refer_village'		=> $data->refer_village, 
				'exp_factory_name' 	=> $data->exp_factory_name, 
				'exp_duration' 		=> $data->exp_duration,
				'exp_dasignation' 	=> $data->exp_dasignation,
			];

			$this->db->where('emp_id', $data->emp_id)->update('pr_emp_per_info', $per_info);
		}
		echo "Update successfully done!";
		// dd($datas);
	}

		function update_dis(){
		$datas = $this->db->select('per_nomi_post.emp_id,per_nomi_post.nomi_post,emp_post_offices.name_bn,emp_post_offices.id as post_id')
						  ->from('per_nomi_post')
						  ->join('emp_post_offices', 'emp_post_offices.name_bn = trim(per_nomi_post.nomi_post)')
						  ->group_by('per_nomi_post.emp_id')->get()->result();

		// echo "<pre>";print_r($datas);exit;

		// $dis_array = array();
		foreach($datas as $data){
			$this->db->where('emp_id', $data->emp_id)->update('pr_emp_per_info', 
						[
							// 'refer_post'     => $data->nomi_post,
							'ref_post' => $data->post_id,
							// 'refer_post'    => $data->upa_id,
						]);
		}
		// echo "<pre>";print_r($dis_array);exit;
		echo "Update successfully done!";
		// dd($datas);
	}

	function update_incre_prom(){
		$this->db->select('prev_emp_id');
		$this->db->from('pr_incre_prom_pun');
		$this->db->where('effective_month LIKE', '%2024%');
		$this->db->where('status', 1);
		$query = $this->db->get();
		$incre_proms = $query->result();
		$ids = array_column($incre_proms, 'prev_emp_id');
		// dd($ids);
		$res = array();
		foreach($ids as $id){
			$this->db->select('*');
			$this->db->where('emp_id', $id);
			$result = $this->db->get('pr_emp_com_info')->result();
			$res = array_merge($res, $result);
		}
		// dd($result);
		
		foreach($res as $row){

			$data = [
				'prev_dept'       => $row->emp_dept_id,
				'prev_section'    => $row->emp_sec_id,
				'prev_line'       => $row->emp_line_id,
				'prev_desig'      => $row->emp_desi_id,
				'new_dept'        => $row->emp_dept_id,
				'new_section'     => $row->emp_sec_id,
				'new_line'        => $row->emp_line_id,
				'new_desig'       => $row->emp_desi_id,
			];

			$this->db->where('prev_emp_id', $row->emp_id);
			$this->db->where('effective_month LIKE', '%2024%');
			$this->db->where('status', 1);
			$this->db->update('pr_incre_prom_pun', $data);
		}

		echo "Success";exit;
	}


	function incs(){
		$datas = $this->db
					->select('new_salary,new_com_salary,prev_emp_id,effective_month')
					->where('effective_month LIKE','%2024%')
					->where('prev_emp_id LIKE','50%')
					->order_by('effective_month','DESC')
					->group_by('prev_emp_id')
					->get('pr_incre_prom_pun')->result();
		// echo "<pre>";print_r($datas);exit;
	
		foreach($datas as $row){
			$this->db->where('emp_id', $row->prev_emp_id)->update('pr_emp_com_info', 
				[
					'gross_sal'     => $row->new_salary,
					'com_gross_sal' => $row->new_com_salary,
				]);
		}

		echo "Update successfully done!";
	}



	function ____bkash_no(){
		date_default_timezone_set('Asia/Dhaka');
		$file_name = "import/bkash.txt";
		if (file_exists($file_name)){
			$lines = file($file_name);
			foreach(array_values($lines)  as $line) {
				list($id, $amt) = preg_split('/\s+/',$line);
				$data = array(
					'emp_id' 	=> $id,
					'bank_bkash_no'	=> $amt,
				);
				// dd($data);
				$this->db->where('emp_id', $id);
				$this->db->update('pr_emp_per_info', $data);
			}
			echo "Upload successfully done";
		}
	}

	// function get_id(){
	// 	$lists = $this->db->select('emp_id')->where('unit_id',1)->where('eot_hour !=',0)->where('salary_month','2025-03-01')->get('pay_salary_sheet')->result();

	// 	foreach($lists as $list){
	// 		echo $list->emp_id."<br>";
	// 	}
	// }


	function sp_leavsssse(){
		$get_emps = $this->db->select('emp_id')->where('emp_cat_id',1)->where('unit_id',4)->get('pr_emp_com_info')->result_array();
		// dd($get_emps);
		foreach ($get_emps as $emp_id) {
			// dd($emp_id);
			// ---------- CHECK ALREADY EXISTS ----------
			$exists = $this->db
				->where('emp_id', $emp_id['emp_id'])
				->where('leave_start', '2025-12-01')
				->where('leave_end', '2025-12-01')
				->where('leave_type', 'sp')
				->get('pr_leave_trans')
				->row();

			if ($exists) {
				echo "Emp ID {$emp_id['emp_id']} : Already exists<br>";
				continue;
			}

			// ---------- INSERT DATA ----------
			$data = [
				'emp_id'       => $emp_id['emp_id'],
				'unit_id'      => 4,
				'start_date'   => '2025-12-01',
				'leave_type'   => 'sp',
				'leave_start'  => '2025-12-01',
				'leave_end'    => '2025-12-01',
				'total_leave'  => 1
			];
			// dd($data);

			$insert = $this->db->insert('pr_leave_trans', $data);

			if ($insert) {
				echo "Emp ID {$emp_id['emp_id']} : Inserted successfully<br>";
			} else {
				echo "Emp ID {$emp_id['emp_id']} : Insert failed<br>";
			}
		}

		echo 'Success';
	}

	// function grade(){
	// 	$get_grade = $this->db
	// 		->select('prev_emp_id, prev_grade')
	// 		->like('prev_emp_id', '200', 'after')
	// 		->where('effective_month', '2025-12-01')
	// 		->get('pr_incre_prom_pun')
	// 		->result();

	// 	// foreach ($get_grade as $grade) {
	// 	// 	$this->db
	// 	// 		->where('emp_id', $grade->prev_emp_id)
	// 	// 		->update('pr_emp_com_info', ['emp_sal_gra_id' => $grade->prev_grade]);
	// 	// 	echo "Emp ID {$grade->prev_emp_id} : Grade updated to {$grade->prev_grade}<br>";
	// 	// }
	// }

	function earn_leave(){
		$ids = [
2002463,2003442,2004201,2004767,2004831,2004843,2005351,2007337,2007496,2007653,2007841,2008079,2008510,2008809,2008827,2008918,2008919,2008947,2008983,2009309,2009651,2009689,2009786,2009969,2010074,2010186,2010472,2010478,2000169,2000213,2000324,2000328,2000916,2001056,2001810,2002246,2002278,2003173,2003193,2004557,2005404,2005706,2006084,2007123,2007126,2007288,2007341,2007409,2007428,2007961,2008043,2008271,2008537,2008549,2008904,2008906,2009008,2009051,2009152,2009274,2009325,2009369,2009480,2009539,2009541,2009544,2009670,2009715,2009733,2009757,2009827,2009838,2009862,2009898,2009928,2009936,2009949,2009977,2009991,2010013,2010017,2010050,2010059,2010083,2010146,2010162,2010199,2010202,2010222,2010311,2010355,2010406,2010432,2010433,2010445,2010447,2010450,2000326,2000761,2000870,2001147,2001333,2001740,2001806,2001966,2002124,2002218,2002541,2003366,2004071,2004323,2004407,2004792,2007113,2007747,2007793,2007879,2007977,2008035,2008150,2008315,2008394,2008460,2008495,2008577,2008578,2008580,2008661,2008726,2008830,2008914,2008916,2008955,2008963,2009044,2009076,2009219,2009339,2009483,2009485,2009488,2009509,2009580,2009602,2009688,2009693,2009751,2009785,2009805,2009846,2009861,2010000,2010023,2010047,2010092,2010095,2010136,2010230,2010248,2010251,2010253,2010260,2010293,2010331,2010375,2010412,2010456,2010457,2007611,2000958,2001726,2001819,2002269,2004563,2005568,2005605,2005900,2007012,2007019,2007874,2008498,2010105,2000567,2001848,2003887,2003908,2004232,2004319,2004739,2004790,2004852,2005597,2007029,2007861,2007913,2008408,2008433,2008721,2008779,2008991,2009000,2009090,2009236,2009343,2009415,2009470,2009475,2009497,2009581,2009714,2009744,2009884,2009963,2010031,2010088,2010211,2010228,2010429,2010437,2010443,2000261,2002539,2003293,2003550,2003863,2005085,2005660,2007472,2008036,2008062,2008312,2008343,2008356,2008376,2008594,2008606,2009270,2009278,2009392,2009401,2009454,2009484,2009831,2010012,2010014,2010057,2010242,2010364,2010392,2010420,2000907,2001567,2003348,2004162,2004320,2004513,2004828,2005453,2005831,2006031,2007145,2007201,2008029,2008073,2008109,2008284,2008513,2008616,2008702,2008729,2008781,2009106,2009154,2009206,2009279,2009424,2009534,2009649,2009720,2009753,2009820,2009923,2010227,2010259,2010306,2010309,2010330,2010346,2010350,2010381,2010410,2000538,2000791,2000962,2001358,2002578,2002959,2004422,2005564,2005585,2007060,2007125,2007888,2008413,2008664,2008692,2008715,2008860,2009021,2009098,2009189,2009262,2009416,2009542,2009576,2009610,2009729,2009738,2009747,2009768,2009893,2009902,2010038,2010085,2010086,2010153,2010297,2010322,2010326,2010404,2010415,2010418,2010460,2010464,2003001,2003508,2003635,2003982,2004142,2004358,2004375,2004517,2005186,2005352,2005535,2005696,2005847,2005851,2005967,2005994,2007523,2007625,2007783,2007815,2007997,2008026,2008149,2008561,2008621,2008842,2008970,2009241,2009301,2009317,2009318,2009374,2009570,2009662,2009695,2009709,2009825,2009854,2010064,2010097,2010127,2010137,2010281,2010308,2010315,2010468,2000856,2001536,2001642,2002586,2004575,2004648,2004649,2004893,2005214,2005456,2005527,2005619,2005992,2006002,2007164,2007389,2007441,2007500,2007501,2007502,2007649,2007767,2007798,2007919,2008294,2008629,2008679,2008902,2008989,2009022,2009025,2009060,2009118,2009136,2009237,2009501,2009666,2009819,2009830,2009837,2009849,2009909,2010041,2010114,2010148,2010255,2010276,2010327,2010347,2010403,2010409,2010427,2010471,2010479,2002683,2002853,2002911,2002955,2003074,2003895,2003924,2004048,2004137,2004432,2005237,2005396,2007030,2007138,2007152,2007344,2007530,2007636,2007643,2007839,2007892,2007911,2007995,2008414,2008455,2008504,2008674,2008911,2008930,2008936,2009104,2009261,2009341,2009543,2009594,2009759,2009803,2009915,2010025,2010257,2010271,2010312,2010325,2010372,2010386,2010387,2010396,2010467,2002038,2002738,2003270,2003877,2004271,2004328,2004618,2005038,2005391,2005402,2005824,2005858,2005884,2005957,2007415,2007449,2007640,2007644,2007654,2007804,2007939,2007967,2008120,2008188,2008278,2008304,2008330,2008623,2008920,2008964,2009020,2009273,2009299,2009307,2009400,2009462,2009507,2009681,2009711,2009723,2009801,2009857,2010062,2010103,2010135,2010262,2010265,2010279,2010291,2010461,2010466,2000025,2000064,2010284,2008151,2010206,2000171,2000280,2000292,2000449,2000581,2001933,2005098,2007003,2007592,2008468,2008619,2008699,2009108,2009826,2010539,2001655,2008052,2010028,2010354,2000011,2001565,2001591,2002936,2003305,2003945,2004237,2004894,2005661,2005920,2007081,2007637,2007833,2007957,2008101,2008226,2008465,2008998,2009749,2009783,2009897,2010045,2010079,2010155,2010182,2010184,2010188,2010193,2010229,2010250,2010301,2010317,2010332,2010374,2010391,2010395,2010436,2010458,2010463,2010477,2001294,2003162,2003679,2003851,2005173,2005427,2007278,2007401,2007614,2007686,2007895,2008406,2008419,2009033,2009144,2009185,2009269,2009272,2009579,2009659,2009678,2009809,2009848,2009875,2009990,2010003,2010069,2010117,2010244,2010245,2010277,2010339,2010343,2010351,2010378,2000056,2000118,2000704,2001335,2007600,2007604,2008746,2009784,2004919,2009870,2010043,2010077,2010209,2010376,2010167,2010172,2010168

		
		];

		$datas = $this->db->select('
			emp_id,
			gross_sal,
			CASE 
				WHEN gross_sal = 0 THEN 0
				ELSE ((gross_sal - 2450) * 1.5)
			END as basic_sal,
			com_gross_sal,
			emp_dept_id as dept_id,
			emp_sec_id as sec_id,
			emp_line_id as line_id,
			emp_desi_id as desig_id,
			unit_id,
			emp_join_date as jod
		')
		->where_in('emp_id', $ids)->get('pr_emp_com_info')->result();
		foreach($datas as $data){
			$dataa = [
				'emp_id'        => $data->emp_id,
				'gross_sal'     => $data->gross_sal,
				'basic_sal'     => $data->basic_sal,
				'com_gross_sal' => $data->com_gross_sal,
				'dept_id'   	=> $data->dept_id,
				'sec_id'    	=> $data->sec_id,
				'line_id'   	=> $data->line_id,
				'desig_id'  	=> $data->desig_id,
				// 'unit_id'   	=> $data->unit_id,
				'jod'       	=> $data->jod,
				// 'earn_month'	=> '2024-12-31',
				'created_at'    => date('Y-m-d H:i:s'),
			];
			$this->db->where('emp_id', $data->emp_id)->where('earn_month', '2024-12-31')->update('pr_earn_leave', $dataa);
			echo "Emp ID {$data->emp_id} : Earned leave updated<br>";
		}

		echo "Update successfully done!";
	}
}
?>