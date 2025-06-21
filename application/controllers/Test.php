<?php
	class Test extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			
		}
public function test()
	{
		
			$this->load->view('test');
		
	}
	
	public function test2()
	{
		
			/*$postdata = $this->input->post();
			$pdf_file = $_FILES["upload_pdf"]["name"];
			define('UPLOAD_PDF_DIR', 'assets/collateral/'); 
			$imageFileType = strtolower(pathinfo($pdf_file,PATHINFO_EXTENSION));
			
			$allowed =  array('pdf');
			$ext = pathinfo($pdf_file, PATHINFO_EXTENSION);
		if(!empty($_FILES["upload_pdf"]["name"]))	
		{	
			$target_file_pdf = UPLOAD_PDF_DIR . uniqid().'.pdf';
			
			if(in_array($ext,$allowed)) 
			{
				move_uploaded_file($_FILES["upload_pdf"]["tmp_name"], $target_file_pdf);	
				echo base_url().$target_file_pdf;
			}
			
		}*/
		
		$config['upload_path'] = './assets/test/';
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        $config['max_size'] = 20000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('upload_pdf')) {
            $error = array('error' => $this->upload->display_errors());
			echo "error";
            //$this->load->view('files/upload_form', $error);
        } else {
            $data = array('image_metadata' => $this->upload->data());

            echo "Success";
        }
		
		if (!$this->upload->do_upload('upload_img')) {
            $error = array('error' => $this->upload->display_errors());
			echo "error";
            //$this->load->view('files/upload_form', $error);
        } else {
            $data = array('image_metadata' => $this->upload->data());

            echo "Success";
        }
	}
	
	public function lesson_read_excel()
		{
			$file = './uploads/lesson_format_one_module_template_v2_FINAL_2021.05.20.xlsx';
 
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
			 
		
			
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				
				$column = @$objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = @$objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
				{
					
					if($cell[0] == 'A')
					{
						$data_value = $avalue;
					}
					if($cell[0] == 'B')
					{
						$data_value = $bvalue;
					}
					if($cell[0] == 'C')
					{
						//$data_value = $cvalue;
					}
					if($cell[0] == 'D')
					{
						//$data_value = $dvalue;
					}
					if($cell[0] == 'E')
					{
						//$data_value = $evalue;
					}
				}
				else
				{
					if($cell[0] == 'A')
					{
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'B')
					{
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'C')
					{
						//$cvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					
					else if($cell[0] == 'D')
					{
						//$dvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'E')
					{
						//$evalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
				
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			echo "<pre>";
			$finalary = array();
			$i = 0;
			foreach($data['values'] as $key=>$value)
			{
				if($key > 2)
				{
					if(strlen($value['D']) > 1)
					{
						$course_ary = array();
						$course_ary = explode(",",$value['D']);
						
						foreach($course_ary as $val2)
						{
							//if($course_ary[0])
							{
								$finalary[$i] = $value;
								$finalary[$i]['D'] = $val2;
							}
							$i++;
						}
					}
					else
					{
						$finalary[$i] = $value;
						$i++;
					}
				
				}
				
			}
		
			foreach($finalary as $key=>$val)
			{
				//if($key > 2)
				{
						// The text to be read, url-encoded
				/*$text_to_read = urlencode("Hello World");

				// Your API Key here
				$apikey = '498aab8be0e9100f6ce04efc06bb1a45';

				// The language to use
				$language = 'en_us';

				// The voice to use
				$voice= 'Sophie';

				// API URL of text-to-speech enabler
				$api_url = 'https://tts.readspeaker.com/a/speak';

				// Compose API call url
				$url = $api_url . '?key='.$apikey.'&lang='.$language.'&voice='.$voice.'&text='.$text_to_read;

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$audio_data = curl_exec($ch);

				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

					if ($status == 200 && ! curl_errno($ch)) 
					{
						curl_close($ch);
				
				$file = rand().time().".mp3";
				file_put_contents($file, $audio_data);
				*/
				$topic = "Noun";
				$language = "English";
				$format = "Single";
				if($format == "Single")
					$topic_format_id = $topic."_". 1 ."_".($key+1);
				else
					$topic_format_id = $topic."_". 2 ."_". ($key + 1);
				
					$sql = "INSERT INTO `ss_aw_lessons`(`ss_aw_language`,`ss_aw_topic_format_id`,`ss_aw_lesson_topic`,`ss_aw_lesson_format`,`ss_aw_course_id`,
					`ss_aw_lesson_format_type`,`ss_aw_lesson_title`, `ss_aw_lesson_details`,`ss_aw_lesson_quiz_type_id`, `ss_aw_lesson_question_options`,
					`ss_aw_lesson_answers`, `ss_aw_lessons_recap`) 
					VALUES ('".$language."','".$topic_format_id."','".$topic."','".$format."','".$val['D']."','".$val['A']."',
					'".$val['B']."','".$val['C']."','".$val['E']."','".$val['F']."','".$val['G']."','".$val['H']."')";
					$this->db->query($sql);
					
					
					//}
				/*else {
					// Cannot translate text to speech because of text-to-speech API error
					error_log(__FILE__ . ': API error while text-to-speech. error code=' . $status);
					curl_close($ch);
					}
				*/
				}
			}
			
		}
		
		public function lesson_read_excel_2()
		{
			$file = './uploads/lesson_format_two_module_template_v1_FINAL_2021.05.20.xlsx';
 
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
			 
		
			
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				
				$column = @$objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = @$objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
				{
					
					if($cell[0] == 'A')
					{
						$data_value = $avalue;
					}
					if($cell[0] == 'B')
					{
						$data_value = $bvalue;
					}
					if($cell[0] == 'C')
					{
						//$data_value = $cvalue;
					}
					if($cell[0] == 'D')
					{
						//$data_value = $dvalue;
					}
					if($cell[0] == 'E')
					{
						//$data_value = $evalue;
					}
				}
				else
				{
					if($cell[0] == 'A')
					{
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'B')
					{
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'C')
					{
						//$cvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					
					else if($cell[0] == 'D')
					{
						//$dvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'E')
					{
						//$evalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
				
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			$finalary = array();
			
			$finalary = $data['values'];
			$i = 1;
			foreach($finalary as $key=>$val)
			{
				//if($key > 2)
				{
						// The text to be read, url-encoded
				/*$text_to_read = urlencode("Hello World");

				// Your API Key here
				$apikey = '498aab8be0e9100f6ce04efc06bb1a45';

				// The language to use
				$language = 'en_us';

				// The voice to use
				$voice= 'Sophie';

				// API URL of text-to-speech enabler
				$api_url = 'https://tts.readspeaker.com/a/speak';

				// Compose API call url
				$url = $api_url . '?key='.$apikey.'&lang='.$language.'&voice='.$voice.'&text='.$text_to_read;

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$audio_data = curl_exec($ch);

				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

					if ($status == 200 && ! curl_errno($ch)) 
					{
						curl_close($ch);
				
				$file = rand().time().".mp3";
				file_put_contents($file, $audio_data);
				*/
				$topic = "Noun";
				$language = "English";
				$format = "Multiple";
				$level = 1;
				if($format == "Single")
					$topic_format_id = $topic."_". 1 ."_". $i;
				else
					$topic_format_id = $topic."_". 2 ."_". $i;
				$lesson_format_type = 6;
					$sql = "INSERT INTO `ss_aw_lessons`(`ss_aw_language`,`ss_aw_topic_format_id`,`ss_aw_lesson_topic`,`ss_aw_lesson_format`,`ss_aw_course_id`,
					`ss_aw_lesson_format_type`,`ss_aw_lesson_title`, `ss_aw_lesson_details`,`ss_aw_lesson_quiz_type_id`, `ss_aw_lesson_question_options`,
					`ss_aw_lesson_answers`, `ss_aw_lessons_recap`) 
					VALUES ('".$language."','".$topic_format_id."','".$topic."','".$format."','".$level."','".$lesson_format_type."',
					'".addslashes($val['A'])."','".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($val['D'])."','".addslashes($val['E'])."','')";
					$this->db->query($sql);
					$i++;
					
					
					//}
				/*else {
					// Cannot translate text to speech because of text-to-speech API error
					error_log(__FILE__ . ': API error while text-to-speech. error code=' . $status);
					curl_close($ch);
					}
				*/
				}
			}
			
		}
		
		public function assessment_read_excel()
		{
			
			// The text to be read, url-encoded
		/*$text_to_read = urlencode("Change the sentence");

		// Your API Key here
		$apikey = '498aab8be0e9100f6ce04efc06bb1a45';

		// The language to use
		$language = 'en_us';

		// The voice to use
		$voice= 'Sophie';

		// API URL of text-to-speech enabler
		$api_url = 'https://tts.readspeaker.com/a/speak';

		// Compose API call url
		$url = $api_url . '?key='.$apikey.'&lang='.$language.'&voice='.$voice.'&text='.$text_to_read;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$audio_data = curl_exec($ch);

		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		/*if ($status == 200 && ! curl_errno($ch)) {
			// Everything is fine and data is returned
			curl_close($ch);
			header('HTTP/1.1 200 OK');
			header('Content-Type: audio/mp3');
			print ($audio_data);
		} else {
			// Cannot translate text to speech because of text-to-speech API error
			error_log(__FILE__ . ': API error while text-to-speech. error code=' . $status);
			curl_close($ch);
		}*/
		//curl_close($ch);
		
		//$file = "change_sentence.mp3";
		
		//file_put_contents($file, $audio_data);

			$file = './uploads/excel_14.xlsx';
 
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
			 
			
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			
			$data['values'] = $arr_data;
			//echo "<pre>";
			//print_r($data);
			//die();
			/************* Count E Courses *********************/
			$e_count = 0;
			$c_count = 0;
			$a_count = 0;
			$topic = "";
			$format = "";
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);
				if($key > 2)
				{
					if($level == 'E')
					{
						$e_count++;
					}
					if($level == 'C')
					{
						$c_count++;
					}
					if($level == 'A')
					{
						$a_count++;
					}
				}
				else
				{
					$topic = $val['B'];
					$format = $val['C'];
				}
			}
			
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);
				$data['values'][$key]['B'] = $topic;
				$data['values'][$key]['C'] = $format;
					if($val['A'] == 'E' && $e_count > 25)
					{
						$weight = floor($val['D'] * 0.01) + 1;
						$data['values'][$key]['E'] = $weight;
					}else if($level == 'E' && $e_count > 17 && $e_count < 25)
					{
						$weight = floor($val['D'] * 0.02) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'E' && $e_count > 10 && $e_count < 17)
					{
						$weight = floor($val['D'] * 0.03) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'E' && $e_count <= 10)
					{
						$weight = floor($val['D'] * 0.04) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'E' && $e_count == 1)
					{
						$weight = 1;
						$data['values'][$key]['E'] = $weight;
					}
					
					if($level == 'C' && $c_count > 25)
					{
						$weight = floor(1+($val['D'] * (0.01)));
						$data['values'][$key]['E'] = $weight;
					}else if($level == 'C' && $c_count > 17 && $c_count < 25)
					{
						$weight = floor($val['D'] * 0.02) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'C' && $c_count > 10 && $c_count < 17)
					{
						$weight = floor($val['D'] * 0.03) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'C' && $c_count <= 10)
					{
						$weight = floor($val['D'] * 0.04) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'C' && $c_count == 1)
					{
						$weight = 1;
						$data['values'][$key]['E'] = $weight;
					}
					
					if($level == 'A' && $a_count > 25)
					{
						$weight = floor(1+($val['D'] * (0.01)));
						$data['values'][$key]['E'] = $weight;
					}else if($level == 'A' && $a_count > 17 && $a_count < 25)
					{
						$weight = floor($val['D'] * 0.02) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'A' && $a_count > 10 && $a_count < 17)
					{
						$weight = floor($val['D'] * 0.03) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'A' && $a_count <= 10)
					{
						$weight = floor($val['D'] * 0.04) + 1;
						$data['values'][$key]['E'] = $weight;
					}
					else if($level == 'A' && $a_count == 1)
					{
						$weight = 1;
						$data['values'][$key]['E'] = $weight;
					}
					
					/* Set Assessment or Diagonistic */
					if($val['N'] == 'Assessment (A)')
					{
						$data['values'][$key]['N'] = 2;
					}
					else
					{
						$data['values'][$key]['N'] = 1;
					}						
			}
			$final_output = "";
			$rule_file = "";
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);
				if($key > 2)
				{
					$format = trim(str_replace("/ ","",$val['G']));
					if($format === 'Choose the right answers')
					{
						$audio_file = "choose_right_answers.mp3";
					}
					else if($format === 'Fill in the blanks')
					{
						$audio_file = "fill_the_blanks.mp3";
					}
					else if($format === 'Change the sentence')
					{
						$audio_file = "change_sentence.mp3";
					}
					else if($format === 'Change the word to its comparative degree')
					{
						$audio_file = "change_the_word_to_its_comparative_degree.mp3";
					}
					else if($format === 'Choose the right option')
					{
						$audio_file = "choose_the_right_option.mp3";
					}
					else if($format === 'Convert to the comparative degree')
					{
						$audio_file = "convert_to_the_comparative_degree.mp3";
					}
					else if($format === 'Insert the adverb')
					{
						$audio_file = "insert_the_adverb.mp3";
					}
					else if($format === 'Join the sentences')
					{
						$audio_file = "join_the_sentences.mp3";
					}
					else if($format === 'Place the article in the aprropraite place')
					{
						$audio_file = "place_the_article_in_the_aprropraite_place.mp3";
					}
					else if($format === 'Rewrite the sentence')
					{
						$audio_file = "rewrite_the_sentence.mp3";
					}
					
					
					$rule_str = trim($val['M']);
					$rule_file = "";
					if(!empty($rule_str) && $rule_str != 'NA')
					{
						
						$rule_file = "assets/audio/rules/".time()."_".rand().".mp3";
						$url = "https://translate.google.com.vn/translate_tts?ie=UTF-8&q=".urlencode($rule_str)."&tl=en&client=tw-ob";	

							if (!function_exists('curl_init')) { // use file get contents 
									$output = file_get_contents($url); 
								} else { // use curl 
									$ch = curl_init(); 
									curl_setopt($ch, CURLOPT_URL, $url); 
									curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); 
									curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1"); 
									curl_setopt($ch, CURLOPT_HEADER, 0); 
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
									curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
									$output = curl_exec($ch); 
									curl_close($ch); 
								}
								$final_output .= $output;
								file_put_contents($rule_file, $final_output);
								
					}
					
					$sql = "INSERT INTO `ss_aw_assisment_diagnostic`(`ss_aw_added_by`, `ss_aw_level`,`ss_aw_format`,`ss_aw_seq_no`,`ss_aw_weight`, `ss_aw_category`,
					`ss_aw_sub_category`, `ss_aw_question_format`,`ss_aw_question_format_audio`,`ss_aw_question_preface`, `ss_aw_question`, `ss_aw_multiple_choice`, `ss_aw_verb_form`,
					`ss_aw_answers`, `ss_aw_rules`, `ss_aw_rules_audio`, `ss_aw_quiz_type`) VALUES ('1','".addslashes($level)."','".addslashes($val['C'])."',
					'".addslashes($val['D'])."','".addslashes($val['E'])."','".addslashes($val['B'])."','".addslashes($val['F'])."','".addslashes($format)."',
					'".$audio_file."','".addslashes($val['H'])."','".addslashes($val['I'])."','".addslashes($val['J'])."','".addslashes($val['K'])."',
					'".addslashes($val['L'])."','".addslashes($rule_str)."','".$rule_file."','".addslashes($val['N'])."')";
					$this->db->query($sql);
					echo "<br/><br/>";
				}
			}
			//echo "<pre>";
			//print_r($data['values']);
		}
		
		public function readalong_read_excel()
		{
			$file = './uploads/readalong_module_template.xlsx';
 
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			 
			
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			
			$data['values'] = $arr_data;
			
			foreach($data['values'] as $key=>$val)
			{
					echo $sql = "INSERT INTO `ss_aw_readalong`(`ss_aw_level`, `ss_aw_topic`, `ss_aw_content`, `ss_aw_image`, `ss_aw_voiceover`, `ss_aw_text_visible`
					) VALUES ('".addslashes($val['A'])."','".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($val['D'])."','".addslashes($val['E'])."',
					'".addslashes($val['F'])."')";
					$this->db->query($sql);
				
			}
		}
}