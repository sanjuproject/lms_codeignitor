<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_cron extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		
		$this->load->model('ss_aw_error_code_model');
		$this->load->model('ss_aw_childs_model');
		$this->load->helper('custom_helper');
		$this->load->model('ss_aw_sections_topics_model');
		$this->load->model('ss_aw_assisment_diagnostic_model');
		$this->load->model('ss_aw_diagnonstic_questions_asked_model');
		$this->load->model('ss_aw_diagonastic_exam_log_model');
		$this->load->model('ss_aw_diagonastic_exam_model');
		$this->load->model('ss_aw_diagonastic_exam_model');
		$this->load->model('ss_aw_parents_model');
		$this->load->model('ss_aw_admin_users_model');
		$this->load->model('ss_aw_adminmenus_model');
		$this->load->model('ss_aw_roles_category_model');
		$this->load->model('ss_aw_page_content_model');
		$this->load->model('ss_aw_faq_model');
		$this->load->model('ss_aw_courses_model');
		$this->load->model('ss_aw_currencies_model');
		$this->load->model('ss_aw_lessons_model');
		$this->load->model('ss_aw_email_valification_model');
		$this->load->model('ss_aw_phone_valification_model');
		$this->load->model('ss_aw_sections_subtopics_model');
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_readalongs_upload_model');
		$this->load->model('ss_aw_readalongs_topics_model');
		$this->load->model('ss_aw_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_model');
		$this->load->helper('directory');
		$this->load->model('ss_aw_supplymentary_uploaded_model');
		$this->load->model('ss_aw_course_count_model');
		$this->load->model('ss_aw_voice_type_matrix_model');
		$this->load->model('ss_aw_supplymentary_model');
		$this->load->model('ss_aw_external_contact_model');
		$this->load->model('ss_aw_coupons_model');
		$this->load->model('ss_aw_manage_coupon_send_model');
		$this->load->model('ss_aw_child_course_model');
		$this->load->model('ss_aw_purchase_courses_model');
		$this->load->model('ss_aw_email_que_model');
		$this->load->model('ss_aw_update_profile_log_model');
	}
	

	public function cron_lesson_audio()
	{
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records($limit_no);
		$final_output = "";
		$title_str = '';
		$count = 0;
		if (!empty($getlessons_listary)) {
			foreach($getlessons_listary as $value)
			{
				$title_str = trim($value['ss_aw_lesson_title']);
				$lesson_topic = trim($value['ss_aw_lesson_topic']);
				$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
				//create directory
				$upload_path = "assets/audio/lessons/".$lesson_topic;
				if (!file_exists($upload_path)) {
				    mkdir($upload_path, 0777, true);
				}
				//end
				$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
				$title_str = str_ireplace($remove_ary,"",trim($title_str));
				$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
				$title_str = str_ireplace("i.e.", "that is", $title_str);
				$pattern = '/\[s\].*?\[\/s\]/';
				$title_str = preg_replace($pattern, '', $title_str);
				if(!empty($title_str) && $title_str != 'NA')
				{
					$audio_file = $upload_path."/".time()."_".rand().".mp3";
					
					$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;
					$textary = array();
					$textary['input']['text'] = $title_str;
					$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
					$textary['voice']['name'] = $value['ss_aw_voice_type'];
					//$textary['voice']['ssmlGender'] = 'FEMALE';
					$textary['audioConfig']['audioEncoding'] = 'MP3';
					$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
					$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
					
					
					$audio_data = json_encode($textary);
					$ch = curl_init($url);

					$header[] = "Content-type: application/json";
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					$output = curl_exec($ch);
					$info = curl_getinfo($ch);
														
					$final_output = json_decode($output,true);
					$final_output = base64_decode($final_output['audioContent']);	
					
					file_put_contents($audio_file, $final_output);

					$filesize = filesize($audio_file);
					if ($filesize > 0) {
						$updateary = array();					
						$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
						$updateary['ss_aw_lesson_audio'] = $audio_file;
						$updateary['ss_aw_lesson_audio_exist'] = 1;
						$this->ss_aw_lessons_model->update_record($updateary);	
					}
					else
					{
						$count++;
						if (file_exists($audio_file)) {
							unlink($audio_file);
						}
					}					
				}
				else
				{
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_audio'] = "";
					$updateary['ss_aw_lesson_audio_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);
				}
			}	
		}

		echo $count;
		die();
	}

	public function cron_lesson_audio_slow()
	{
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_for_slow($limit_no);
		$final_output = "";
		$title_str = '';
		$count = 0;
		if (!empty($getlessons_listary)) {
			// code...
		}
		foreach($getlessons_listary as $value)
		{
			$title_str = trim($value['ss_aw_lesson_title']);
			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($title_str));
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);
			
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_e_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_e_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);	
				
				file_put_contents($audio_file, $final_output);

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_audio_slow'] = $audio_file;
					$updateary['ss_aw_lesson_audio_slow_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);	
				}
				else
				{
					$count++;
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_audio_slow'] = "";
				$updateary['ss_aw_lesson_audio_slow_exist'] = 1;
				$this->ss_aw_lessons_model->update_record($updateary);
			}
		}

		echo $count;
		die();
	}

	public function cron_lesson_audio_fast()
	{
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_for_fast($limit_no);
		$final_output = "";
		$title_str = '';
		$count = 0;
		
		foreach($getlessons_listary as $value)
		{
			
			$title_str = trim($value['ss_aw_lesson_title']);
			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($title_str));
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_a_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_a_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);	
				
				file_put_contents($audio_file, $final_output);

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_audio_fast'] = $audio_file;
					$updateary['ss_aw_lesson_audio_fast_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);	
				}
				else
				{
					$count++;
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_audio_fast'] = "";
				$updateary['ss_aw_lesson_audio_fast_exist'] = 1;
				$this->ss_aw_lessons_model->update_record($updateary);
			}
		}

		echo $count;
		die();
	}
	
	public function cron_lesson_details_audio()
	{
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_details($limit_no);
		$final_output = "";
		$title_str = '';
		foreach($getlessons_listary as $value)
		{
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($value['ss_aw_lesson_details']));
			
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);

			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				
				file_put_contents($audio_file, $final_output);

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_details_audio'] = $audio_file;
					$updateary['ss_aw_details_audio_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_details_audio'] = "";
				$updateary['ss_aw_details_audio_exist'] = 1;
				$this->ss_aw_lessons_model->update_record($updateary);
			}
		}
		die();
	}

	public function cron_lesson_details_audio_slow()
	{
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_details_slow($limit_no);
		$final_output = "";
		$title_str = '';
		foreach($getlessons_listary as $value)
		{
			
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($value['ss_aw_lesson_details']));
			
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_e_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_e_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				
				file_put_contents($audio_file, $final_output);

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_details_audio_slow'] = $audio_file;
					$updateary['ss_aw_details_audio_slow_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_details_audio_slow'] = "";
				$updateary['ss_aw_details_audio_slow_exist'] = 1;
				$this->ss_aw_lessons_model->update_record($updateary);
			}
			
		}
		die();
	}

	public function cron_lesson_details_audio_fast()
	{
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_details_fast($limit_no);
		$final_output = "";
		$title_str = '';
		foreach($getlessons_listary as $value)
		{
			
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($value['ss_aw_lesson_details']));
			
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_a_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_a_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				
				file_put_contents($audio_file, $final_output);

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_details_audio_fast'] = $audio_file;
					$updateary['ss_aw_details_audio_fast_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_details_audio_fast'] = "";
				$updateary['ss_aw_details_audio_fast_exist'] = 1;
				$this->ss_aw_lessons_model->update_record($updateary);
			}
			
		}
		die();
	}
	
	public function cron_lesson_asnwers_audio()
	{
		$getlessons_listary = array();
		$limit_no = 20;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_answers($limit_no);
		
		$final_output = "";
		$title_str = '';
		foreach($getlessons_listary as $value)
		{
			$title_str = trim($value['ss_aw_lesson_answers']);
			

			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($title_str));
			
			$title_str = str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$title_str = str_ireplace("/", ".", $title_str);

			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if($value['ss_aw_lesson_quiz_type_id'] == 3)
			{
				//$replaceary = array("/",",");
				//$title_str = str_replace($replaceary," or ",$title_str); 
				$title_str = str_replace("/"," or ",$title_str);
			}

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
				
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);		
				file_put_contents($audio_file, $final_output);				
				
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_answers_audio'] = $audio_file;
					$updateary['ss_aw_lesson_answers_audio_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}	
									
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_answers_audio_exist'] = 3;
				$this->ss_aw_lessons_model->update_record($updateary);	
			}
		}
		die();
	}

	public function cron_lesson_asnwers_audio_slow()
	{
		$getlessons_listary = array();
		$limit_no = 20;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_answers_slow($limit_no);
		
		$final_output = "";
		$title_str = '';
		foreach($getlessons_listary as $value)
		{
			
			$title_str = trim($value['ss_aw_lesson_answers']);
			

			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($title_str));
			
			$title_str = str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$title_str = str_ireplace("/", ".", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if($value['ss_aw_lesson_quiz_type_id'] == 3)
			{
				//$replaceary = array("/",",");
				//$title_str = str_replace($replaceary," or ",$title_str); 
				$title_str = str_replace("/"," or ",$title_str);
			}

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_e_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_e_speed']);
				
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);		
				file_put_contents($audio_file, $final_output);				
				
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_answers_audio_slow'] = $audio_file;
					$updateary['ss_aw_lesson_answers_audio_slow_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}	
									
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_answers_audio_slow_exist'] = 3;
				$this->ss_aw_lessons_model->update_record($updateary);	
			}
			
		}
		die();
	}

	public function cron_lesson_asnwers_audio_fast()
	{
		$getlessons_listary = array();
		$limit_no = 20;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_records_answers_fast($limit_no);
		
		$final_output = "";
		$title_str = '';
		foreach($getlessons_listary as $value)
		{
			
			$title_str = trim($value['ss_aw_lesson_answers']);
			

			$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",trim($title_str));
			
			$title_str = str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str))));
			$title_str = str_ireplace("i.e.", "that is", $title_str);
			$title_str = str_ireplace("/", ".", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$lesson_topic = trim($value['ss_aw_lesson_topic']);
			$lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
			//create directory
			$upload_path = "assets/audio/lessons/".$lesson_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if($value['ss_aw_lesson_quiz_type_id'] == 3)
			{
				//$replaceary = array("/",",");
				//$title_str = str_replace($replaceary," or ",$title_str); 
				$title_str = str_replace("/"," or ",$title_str);
			}

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_a_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_a_speed']);
				
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);		
				file_put_contents($audio_file, $final_output);				
				
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
					$updateary['ss_aw_lesson_answers_audio_fast'] = $audio_file;
					$updateary['ss_aw_lesson_answers_audio_fast_exist'] = 1;
					$this->ss_aw_lessons_model->update_record($updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}	
									
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_lession_id'] = $value['ss_aw_lession_id'];
				$updateary['ss_aw_lesson_answers_audio_fast_exist'] = 3;
				$this->ss_aw_lessons_model->update_record($updateary);	
			}
			
		}
		die();
	}
	
	public function cron_assessment_answers_audio()
	{
		$getans_listary = array();
		$limit_no = 15;
		$getans_listary = $this->ss_aw_assisment_diagnostic_model->get_limited_answers_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($getans_listary as $value)
		{
			$title_str = trim($value['ss_aw_answers']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]","_");
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$title_str = str_ireplace("/", ".", $title_str);
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/assessment/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if(!empty($title_str) && $title_str != 'NA')
			{
				if ($value['ss_aw_question_format'] == 'Rewrite the sentence') {
					$title_str = str_replace("/"," or ",$title_str);
				}
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				file_put_contents($audio_file, $final_output);	

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_answers_audio'] = $audio_file;
					$updateary['ss_aw_answers_audio_exist'] = 1;
					$this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_answers_audio_exist'] = 1;
				$this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
			}
		}
		die();
	}
	

	public function cron_assessment_audio()
	{
		$listary = array();
		$limit_no = 20;
		$listary = $this->ss_aw_assisment_diagnostic_model->get_limited_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			
			$title_str = trim($value['ss_aw_rules']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]","_");
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/assessment/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = $value['ss_aw_c_pitch'];
				$textary['audioConfig']['speakingRate'] = $value['ss_aw_c_speed'];
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				
				file_put_contents($audio_file, $final_output);	
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_rules_audio'] = $audio_file;
					$updateary['ss_aw_audio_exist'] = 1;
					$this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_audio_exist'] = 1;
				$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
			}
		}
		die();
	}
	
	public function cron_assessment_question_preface_audio()
	{
		$listary = array();
		$limit_no = 20;
		$listary = $this->ss_aw_assisment_diagnostic_model->get_limited_preface_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			$title_str = trim($value['ss_aw_question_preface']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]","_");
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);

			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/assessment/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = $value['ss_aw_c_pitch'];
				$textary['audioConfig']['speakingRate'] = $value['ss_aw_c_speed'];
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				file_put_contents($audio_file, $final_output);	
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_question_preface_audio'] = $audio_file;
					$updateary['ss_aw_preface_audio_exist'] = 1;
					$this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_preface_audio_exist'] = 1;
				$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
			}
		}
		die();
	}

	public function cron_assessment_sub_question_audio()
	{
		$listary = array();
		$limit_no = 20;
		$listary = $this->ss_aw_assisment_diagnostic_model->get_limited_question_records($limit_no);
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			$title_str = trim($value['ss_aw_question']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]","_");
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$pattern = '/\[s\].*?\[\/s\]/';
			$title_str = preg_replace($pattern, '', $title_str);
			
			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/assessment/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = $value['ss_aw_c_pitch'];
				$textary['audioConfig']['speakingRate'] = $value['ss_aw_c_speed'];
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				file_put_contents($audio_file, $final_output);		
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_question_audio'] = $audio_file;
					$updateary['ss_aw_question_audio_exist'] = 1;
					$this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_question_audio_exist'] = 1;
				$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
			}
		}
		die();
	}
	
	
	
	/****************************************** READALONGS SECTION *************************************************/
	
	
	public function cron_readalong_audio()
	{

		$listary = array();
		$limit_no = 10;
		$listary = $this->ss_aw_readalong_model->get_limited_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			$title_str = trim($value['ss_aw_content']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]");
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$readalong_title = trim($value['readalong_name']);
            $readalong_title = str_replace(" ", "_", strtolower($readalong_title));
            //create directory
            $upload_path = "assets/audio/readalong/".$readalong_title;

            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            //end

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				
					if($value['ss_aw_level'] == 'E')
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_e_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_e_speed']);
					}
					else if($value['ss_aw_level'] == 'C')
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
					}
					else
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_a_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_a_speed']);
					}	
	

				$audio_data = json_encode($textary);
				$ch = curl_init($url);
				
				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);			
				file_put_contents($audio_file, $final_output);	
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();
					$updateary['ss_aw_readalong_audio'] = $audio_file;
					$updateary['ss_aw_audio_exist'] = 1;
					$this->ss_aw_readalong_model->update_record($value['ss_aw_readalong_id'],$updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else
			{
				$updateary['ss_aw_readalong_audio'] = "";
				$updateary['ss_aw_audio_exist'] = 1;
				$this->ss_aw_readalong_model->update_record($value['ss_aw_readalong_id'],$updateary);	
			}
		}
		die();
	}
	
	public function cron_readalong_quiz_audio()
	{
		$listary = array();
		$limit_no = 15;
		$listary = $this->ss_aw_readalong_quiz_model->get_limited_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			$title_str = trim($value['ss_aw_answers']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]");
			
			$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
			$readalong_title = trim($value['readalong_name']);
            $readalong_title = str_replace(" ", "_", strtolower($readalong_title));
            //create directory
            $upload_path = "assets/audio/readalong/".$readalong_title;

            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            //end

			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				
					if($value['ss_aw_level'] == 'E')
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_e_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_e_speed']);
					}
					else if($value['ss_aw_level'] == 'C')
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
					}
					else
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_a_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_a_speed']);
					}	
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);
				
				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
			
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);			
				file_put_contents($audio_file, $final_output);	

				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();
					$updateary['ss_aw_answers_audio'] = $audio_file;
					$updateary['ss_aw_answers_audio_exist'] = 1;
					$this->ss_aw_readalong_quiz_model->update_record_byid($value['ss_aw_readalong_id'],$updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
				
			}
			else
			{
				$updateary['ss_aw_answers_audio'] = "";
				$updateary['ss_aw_answers_audio_exist'] = 1;
				$this->ss_aw_readalong_quiz_model->update_record_byid($value['ss_aw_readalong_id'],$updateary);	
			}
		}
		die();
	}
	
	public function cron_readalong_details_quiz_audio()
	{
		$listary = array();
		$limit_no = 15;
		$listary = $this->ss_aw_readalong_quiz_model->get_limited_records_details($limit_no);
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			$title_str = trim($value['ss_aw_details']);
			$remove_ary = array("[u]","[/u]","[b]","[/b]","[link]","[/link]","[c]","[/c]","[h]","[/h]");
			$title_str = str_ireplace($remove_ary,"",$title_str);
			$readalong_title = trim($value['readalong_name']);
            $readalong_title = str_replace(" ", "_", strtolower($readalong_title));
            //create directory
            $upload_path = "assets/audio/readalong/".$readalong_title;

            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            //end
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				
					if($value['ss_aw_level'] == 'E')
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_e_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_e_speed']);
					}
					else if($value['ss_aw_level'] == 'C')
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
					}
					else
					{
						$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_a_pitch']);
						$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_a_speed']);
					}	
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);
				
				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
			
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);			
				file_put_contents($audio_file, $final_output);	
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_quiz_type_audio'] = $audio_file;
					$updateary['ss_aw_details_audio_exist'] = 1;
					$this->ss_aw_readalong_quiz_model->update_record_byid($value['ss_aw_readalong_id'],$updateary);	
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
				
			}
			else
			{
				$updateary['ss_aw_quiz_type_audio'] = "";
				$updateary['ss_aw_details_audio_exist'] = 1;
				$this->ss_aw_readalong_quiz_model->update_record_byid($value['ss_aw_readalong_id'],$updateary);	
			}
		}
		die();
	}
	/***************************************************  SUPPLYMENTARY ***************************************************************/
	
	public function cron_supplymentary_answers_audio()
	{
		$getans_listary = array();
		$limit_no = 15;
		$getans_listary = $this->ss_aw_supplymentary_model->get_limited_answers_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($getans_listary as $value)
		{
			$title_str = trim($value['ss_aw_answers']);
			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/supplementary/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = doubleval($value['ss_aw_c_pitch']);
				$textary['audioConfig']['speakingRate'] = doubleval($value['ss_aw_c_speed']);
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				file_put_contents($audio_file, $final_output);
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_answers_audio'] = $audio_file;
					$updateary['ss_aw_answers_audio_exist'] = 1;
					$this->ss_aw_supplymentary_model->update_records($updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}	
				
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_answers_audio_exist'] = 1;
				$this->ss_aw_supplymentary_model->update_records($updateary);	
			}
		}
		die();
	}
	
	public function cron_supplymentary_audio()
	{
		$listary = array();
		$limit_no = 20;
		$listary = $this->ss_aw_supplymentary_model->get_limited_records($limit_no);
		
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			
			$title_str = trim($value['ss_aw_rules']);
			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/supplementary/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = $value['ss_aw_c_pitch'];
				$textary['audioConfig']['speakingRate'] = $value['ss_aw_c_speed'];
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				
				file_put_contents($audio_file, $final_output);	
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_rules_audio'] = $audio_file;
					$updateary['ss_aw_audio_exist'] = 1;
					$this->ss_aw_supplymentary_model->update_records($updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}								
			}
			else
			{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_audio_exist'] = 1;
				$this->ss_aw_supplymentary_model->update_records($updateary);
			}
		}
		die();
	}
	
	public function cron_supplymentary_question_preface_audio()
	{
		$listary = array();
		$limit_no = 20;
		$listary = $this->ss_aw_supplymentary_model->get_limited_preface_records($limit_no);
		$final_output = "";
		$title_str = "";
		foreach($listary as $value)
		{
			$title_str = trim($value['ss_aw_question_preface']);
			$assessment_topic = trim($value['ss_aw_category']);
			$assessment_topic = str_replace(" ", "_", strtolower($assessment_topic));
			//create directory
			$upload_path = "assets/audio/supplementary/".$assessment_topic;
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0777, true);
			}
			//end
			if(!empty($title_str) && $title_str != 'NA')
			{
				$audio_file = $upload_path."/".time()."_".rand().".mp3";
				$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=".GOOGLE_KEY;	
				$textary = array();
				$textary['input']['text'] = $title_str;
				$textary['voice']['languageCode'] = $value['ss_aw_language_code'];
				$textary['voice']['name'] = $value['ss_aw_voice_type'];
				//$textary['voice']['ssmlGender'] = 'FEMALE';
				$textary['audioConfig']['audioEncoding'] = 'MP3';
				$textary['audioConfig']['pitch'] = $value['ss_aw_c_pitch'];
				$textary['audioConfig']['speakingRate'] = $value['ss_aw_c_speed'];
				
				$audio_data = json_encode($textary);
				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
													
				$final_output = json_decode($output,true);
				$final_output = base64_decode($final_output['audioContent']);
				file_put_contents($audio_file, $final_output);
				$filesize = filesize($audio_file);
				if ($filesize > 0) {
					$updateary = array();					
					$updateary['ss_aw_id'] = $value['ss_aw_id'];
					$updateary['ss_aw_question_preface_audio'] = $audio_file;
					$updateary['ss_aw_preface_audio_exist'] = 1;
					$this->ss_aw_supplymentary_model->update_records($updateary);
				}
				else
				{
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}					
			}
			else{
				$updateary = array();					
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_preface_audio_exist'] = 1;
				$this->ss_aw_supplymentary_model->update_records($updateary);
			}
		}
		die();
	}

	public function remove_lesson_audio_cron(){
		$getlessons_listary = array();
		$limit_no = 15;
		$getlessons_listary = $this->ss_aw_lessons_model->get_limited_deleted_records($limit_no);
		if (!empty($getlessons_listary)) {
			foreach($getlessons_listary as $value){

				if (!empty($value->ss_aw_lesson_audio)) {
					if (file_exists($value->ss_aw_lesson_audio)) {
						unlink($value->ss_aw_lesson_audio);
						$updateary = array();
						$updateary['ss_aw_lession_id'] = $value->ss_aw_lession_id;
						$updateary['ss_aw_lesson_audio'] = "";
						$updateary['ss_aw_lesson_audio_exist'] = 2;
						$this->ss_aw_lessons_model->update_record($updateary);
					}
				}

				if (!empty($value->ss_aw_lesson_details_audio)) {
					if (file_exists($value->ss_aw_lesson_details_audio)) {
						unlink($value->ss_aw_lesson_details_audio);
						$updateary = array();
						$updateary['ss_aw_lession_id'] = $value->ss_aw_lession_id;
						$updateary['ss_aw_lesson_details_audio'] = "";
						$updateary['ss_aw_details_audio_exist'] = 2;
						$this->ss_aw_lessons_model->update_record($updateary);
					}
				}

				if (!empty($value->ss_aw_lesson_answers_audio)) {
					if (file_exists($value->ss_aw_lesson_answers_audio)) {
						unlink($value->ss_aw_lesson_answers_audio);
						$updateary = array();
						$updateary['ss_aw_lession_id'] = $value->ss_aw_lession_id;
						$updateary['ss_aw_lesson_answers_audio'] = "";
						$updateary['ss_aw_lesson_answers_audio_exist'] = 2;
						$this->ss_aw_lessons_model->update_record($updateary);
					}
				}
			}	
		}
		die();
	}

	public function remove_assessment_audio_cron(){
		$assessment_listary = array();
		$limit_no = 15;
		$assessment_listary = $this->ss_aw_assesment_uploaded_model->get_deleted_limited_records($limit_no);

		if (!empty($assessment_listary)) {
			foreach ($assessment_listary as $key => $value) {
				$updateary = array();					
				$updateary['ss_aw_id'] = $value->ss_aw_id;
				$updateary['ss_aw_deleted'] = 0;
				$this->ss_aw_assisment_diagnostic_model->update_records($updateary);

				if (!empty($value->ss_aw_question_preface_audio)) {
					if (file_exists($value->ss_aw_question_preface_audio)) {
						unlink($value->ss_aw_question_preface_audio);
						$updateary = array();					
						$updateary['ss_aw_id'] = $value->ss_aw_id;
						$updateary['ss_aw_question_preface_audio'] = "";
						$updateary['ss_aw_preface_audio_exist'] = 2;
						$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
					}
				}

				if (!empty($value->ss_aw_question_audio)) {
					if (file_exists($value->ss_aw_question_audio)) {
						unlink($value->ss_aw_question_audio);
						$updateary = array();					
						$updateary['ss_aw_id'] = $value->ss_aw_id;
						$updateary['ss_aw_question_audio'] = "";
						$updateary['ss_aw_question_audio_exist'] = 2;
						$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
					}
				}

				if (!empty($value->ss_aw_answers_audio)) {
					if (file_exists($value->ss_aw_answers_audio)) {
						unlink($value->ss_aw_answers_audio);
						$updateary = array();					
						$updateary['ss_aw_id'] = $value->ss_aw_id;
						$updateary['ss_aw_answers_audio'] = "";
						$updateary['ss_aw_answers_audio_exist'] = 2;
						$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
					}
				}

				if (!empty($value->ss_aw_rules_audio)) {
					if (file_exists($value->ss_aw_rules_audio)) {
						unlink($value->ss_aw_rules_audio);
						$updateary = array();					
						$updateary['ss_aw_id'] = $value->ss_aw_id;
						$updateary['ss_aw_rules_audio'] = "";
						$updateary['ss_aw_audio_exist'] = 2;
						$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
					}
				}
			}
		}

		die();
	}

	public function change_deleted_assessment_status(){
		$result = $this->ss_aw_assesment_uploaded_model->get_all_deleted_record();
		$deleted_question_id = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$deleted_question_id[] = $value->ss_aw_id;
			}
		}

		if (!empty($deleted_question_id)) {
			$update_ary = array(
				'ss_aw_deleted' => 1
			);
			$response = $this->ss_aw_assisment_diagnostic_model->update_multi_record($deleted_question_id, $update_ary);
			echo $response;
		}
	}

	//call function to remove collateral.
	public function removeUnwantedCollateralImages() {
		$dir = './assets/audio/sub_question_audio';
		deleteAll($dir);
	}

	public function send_default_coupon_to_new_users(){
		$new_users = $this->ss_aw_external_contact_model->get_all_user();
		$default_coupon_detail = $this->ss_aw_coupons_model->get_default_coupon_by_target_audience(2);
		if (!empty($default_coupon_detail) && !empty($new_users)) {
			$coupon_code = $default_coupon_detail[0]->ss_coupon_code;
			$start_date = $default_coupon_detail[0]->ss_aw_start_date;
			$end_date = $default_coupon_detail[0]->ss_aw_end_date;
			$discount = $default_coupon_detail[0]->ss_aw_discount;
			$template = $default_coupon_detail[0]->ss_aw_template;
			$executing_day = $default_coupon_detail[0]->ss_aw_executing_date_in_month;

			$template = str_ireplace("[@@coupon_code@@]", $coupon_code, $template);
			$template = str_ireplace("[@@coupon_start_date@@]", $start_date, $template);
			$template = str_ireplace("[@@coupon_end_date@@]", $end_date, $template);
			$template = str_ireplace("[@@coupon_discount@@]", $discount, $template);
			if (date('d') == $executing_day) {
				foreach ($new_users as $key => $value) {
					$username = $value->ss_aw_name;
					$email = $value->ss_aw_email;
					$template = str_ireplace("[@@username@@]", $username, $template);
					$send_details = $this->ss_aw_manage_coupon_send_model->get_send_detailsofuser($value->ss_aw_id, 2);
					if (!empty($send_details)) {
						$total_send_num = count($send_details);
						if ($total_send_num % 3 == 0) {
							$last_send_date = strtotime($send_details[$total_send_num - 1]->ss_aw_send_date);
							$current_date = time();
							$datediff = $current_date - $last_send_date;
							$days = round($datediff / (60 * 60 * 24));

							if ($days >= 90) {
								$data = array(
									'ss_aw_coupon_id' => $default_coupon_detail[0]->ss_aw_id,
									'ss_aw_user_id' => $value->ss_aw_id,
									'ss_aw_target_audience' => 2,
									'ss_aw_send_date' => date('Y-m-d')
								);

								$response = $this->ss_aw_manage_coupon_send_model->add_record($data);
								if ($response) {
									emailnotification($email, 'Exiting Offer', $template);
								}
							}
						}
						else
						{
							$data = array(
								'ss_aw_coupon_id' => $default_coupon_detail[0]->ss_aw_id,
								'ss_aw_user_id' => $value->ss_aw_id,
								'ss_aw_target_audience' => 2,
								'ss_aw_send_date' => date('Y-m-d')
							);

							$response = $this->ss_aw_manage_coupon_send_model->add_record($data);
							if ($response) {
								emailnotification($email, 'Exiting Offer', $template);
							}
						}
					}
					else{
						$data = array(
							'ss_aw_coupon_id' => $default_coupon_detail[0]->ss_aw_id,
							'ss_aw_user_id' => $value->ss_aw_id,
							'ss_aw_target_audience' => 2,
							'ss_aw_send_date' => date('Y-m-d')
						);

						$this->ss_aw_manage_coupon_send_model->add_record($data);
					}	
				}	
			}
		}
	}

	public function send_default_coupon_to_existing_users(){
		$default_coupon_detail = $this->ss_aw_coupons_model->get_default_coupon_by_target_audience(1);
		$current_date = date('Y-m-d');
		$one_week_ago_date = date('Y-m-d', strtotime($current_date." -7 days"));
		$existing_users = $this->ss_aw_child_course_model->getcompletechildparentdetail($one_week_ago_date);
		if (!empty($default_coupon_detail) && !empty($existing_users)) {
			$coupon_code = $default_coupon_detail[0]->ss_coupon_code;
			$start_date = $default_coupon_detail[0]->ss_aw_start_date;
			$end_date = $default_coupon_detail[0]->ss_aw_end_date;
			$discount = $default_coupon_detail[0]->ss_aw_discount;
			$template = $default_coupon_detail[0]->ss_aw_template;
			$executing_day = $default_coupon_detail[0]->ss_aw_executing_date_in_month;

			$template = str_ireplace("[@@coupon_code@@]", $coupon_code, $template);
			$template = str_ireplace("[@@coupon_start_date@@]", $start_date, $template);
			$template = str_ireplace("[@@coupon_end_date@@]", $end_date, $template);
			$template = str_ireplace("[@@coupon_discount@@]", $discount, $template);

			if ($executing_day == date('d')) {
				foreach ($existing_users as $key => $value) {
					$username = $value->ss_aw_parent_full_name;
					$email = $value->ss_aw_parent_email;
					$template = str_ireplace('[@@username@@]', $username, $template);
					$send_details = $this->ss_aw_manage_coupon_send_model->get_send_detailsofuser($value->ss_aw_id, 1);
					if (!empty($send_details)) {
						$last_send_date = strtotime($send_details[count($send_details) - 1]->ss_aw_send_date);
						$current_date = time();
						$datediff = $current_date - $last_send_date;
						$days = round($datediff / (60 * 60 * 24));
						if ($days >= 30) {
							$data = array(
								'ss_aw_coupon_id' => $default_coupon_detail[0]->ss_aw_id,
								'ss_aw_user_id' => $value->ss_aw_parent_id,
								'ss_aw_target_audience' => 1,
								'ss_aw_send_date' => date('Y-m-d')
							);

							$response = $this->ss_aw_manage_coupon_send_model->add_record($data);
							if ($response) {
								emailnotification($email, 'Exiting Offer', $template);
							}
						}
					}
					else
					{
						$data = array(
							'ss_aw_coupon_id' => $default_coupon_detail[0]->ss_aw_id,
							'ss_aw_user_id' => $value->ss_aw_parent_id,
							'ss_aw_target_audience' => 1,
							'ss_aw_send_date' => date('Y-m-d')
						);

						$response = $this->ss_aw_manage_coupon_send_model->add_record($data);
						if ($response) {
							emailnotification($email, 'Exiting Offer', $template);
						}
					}
				}
			}
		}
	}

	// child block function due to emi not clear and inactivity
	public function block_child(){
		$all_childs = $this->ss_aw_childs_model->get_all_child();
		if (!empty($all_childs)) {
			foreach ($all_childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = "";
				$accessable = 1;
				$child_accessable = 1;
				if (!empty($childary)) {
					$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];
					if ($course_id == 1) {
						$level = "E";
					}
					elseif ($course_id == 2) {
						$level = "C";
					}
					elseif ($course_id == 3){
						$level = "A";
					}

					//get accessibility of course
					if ($childary[count($childary) - 1]['ss_aw_course_payemnt_type'] == 1) {
						//get first emi payment date
						$first_emi_date = date('Y-m-d', strtotime($childary[count($childary) - 1]['ss_aw_child_course_create_date']));
								
						//get present emi day num after first payment date
						$searchary = array(
							'ss_aw_child_id' => $child_id,
							'ss_aw_selected_course_id' => $course_id
						);

						$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary); 
						$present_emi_day_num = count($count_previous_emi) * 31; //31 is the day interval between two emis

						//calculate next emi date
						$next_emi_date = date('Y-m-d', strtotime($first_emi_date." +".$present_emi_day_num." days"));
						$next_emi_date_time = strtotime($next_emi_date);
						$current_date = date('Y-m-d');
						$current_date_time = strtotime($current_date);
						$datediff = $next_emi_date_time - $current_date_time;
						$mid_days = round($datediff / (60 * 60 * 24));	
						if ($mid_days >= -1) {
							$accessable = 1;
						}
						else{
							$accessable = 0;
						}
					}
					else{
						$accessable = 1;
					}

					//check inactivity
					// $get_result = get_active_inactive_delinquent_students();
					// if (!empty($get_result)) {
					// 	$childs = $get_result['inactive_student_ary'];
					// 	if (in_array($child_id, $childs)) {
					// 		$child_accessable = 0;
					// 	}
					// 	else{
					// 		$child_accessable = 1;
					// 	}
					// }

				}

				if ($accessable == 0) {
					$block = 1;
					$update_data = array(
						'ss_aw_blocked' => 1
					);
					$this->ss_aw_childs_model->update_child_details($update_data, $child_id);
				}		
			}
		}
	}

	//block parent if all their child did't pay emi with in 30 days
	public function block_parent_with_child(){
		$parents = $this->ss_aw_parents_model->getallcoursepurchasedparents();
		if (!empty($parents)) {
			foreach ($parents as $key => $value) {
				$parent_id = $value->ss_aw_parent_id;
				$childs = $this->ss_aw_childs_model->get_all_active_childs_by_parent($parent_id);
				if (!empty($childs)) {
					$total_child = count($childs);
					$count_blockage = 0;
					foreach ($childs as $key => $value) {
						$child_id = $value->ss_aw_child_id;
						$childary = $this->ss_aw_child_course_model->get_details($child_id);
						$level = "";
						if (!empty($childary)) {
							$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];
							if ($course_id == 1) {
								$level = "E";
							}
							elseif ($course_id == 2) {
								$level = "C";
							}
							elseif ($course_id == 3){
								$level = "A";
							}

							//get accessibility of course
							if ($childary[count($childary) - 1]['ss_aw_course_payemnt_type'] == 1) {
								//get first emi payment date
								$first_emi_date = date('Y-m-d', strtotime($childary[0]['ss_aw_child_course_create_date']));
										
								//get present emi day num after first payment date
								$searchary = array(
									'ss_aw_child_id' => $child_id,
									'ss_aw_selected_course_id' => $course_id
								);

								$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary); 
								$present_emi_day_num = count($count_previous_emi) * 31; //31 is the day interval between two emis

								//calculate next emi date
								$next_emi_date = date('Y-m-d', strtotime($first_emi_date." +".$present_emi_day_num." days"));
								$next_emi_date_time = strtotime($next_emi_date);
								$current_date = date('Y-m-d');
								$current_date_time = strtotime($current_date);
								$datediff = $current_date_time - $next_emi_date_time;
								$mid_days = round($datediff / (60 * 60 * 24));
									
								if ($mid_days > 30) {
									$count_blockage = $count_blockage + 1;
								}

							}
						}
					}

					if ($count_blockage == $total_child) {
						$this->ss_aw_parents_model->update_active_status($parent_id, 0);
						$this->ss_aw_childs_model->change_all_child_status_by_parent($parent_id);
					}
				}
			}
		}
	}

	public function send_email_ques(){
		$result = $this->ss_aw_email_que_model->get_limited_records(5);
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$record_id = $value->ss_aw_id;
				$subject = $value->ss_aw_subject;
				$template = $value->ss_aw_template;
				$email = $value->ss_aw_email;
				$type = $value->ss_aw_type;
				if ($type == 1) {
					$response = emailnotification($email, $subject, $template);
					if ($response) {
						$this->ss_aw_email_que_model->remove_record($record_id);
					}
				}
			}
		}
	}

	public function send_profile_update_email(){
		$result = $this->ss_aw_update_profile_log_model->get_data(5);
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$record_id = $value->ss_aw_id;
				$subject = $value->ss_aw_subject;
				$template = $value->ss_aw_content;
				$email = $value->ss_aw_email;
				{
					$response = emailnotification($email, $subject, $template);
					if ($response) {
						$this->ss_aw_update_profile_log_model->remove_record($record_id);
					}
				}
			}
		}
	}
}

//function to remove all unlinked files in collateral folder.
function deleteAll($dir, $remove = false) {
 	$structure = glob(rtrim($dir, "/").'/*');
 	if (is_array($structure)) {
		foreach($structure as $file) {
			if (is_dir($file))
			deleteAll($file,true);
			else if(is_file($file))
			unlink($file);
		}
 	}
}