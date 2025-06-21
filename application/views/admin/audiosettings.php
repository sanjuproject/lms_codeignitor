 <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

       
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-left">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">Settings</li>
                                    <li class="breadcrumb-item active">Audio Settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>
		<?php include("error_message.php");?>
                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Audio Settings</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <!-- end page title -->


                    <form action="<?php echo base_url()  ?>admin/audiosettings" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="newtopic">Correct Answer Audio Sound</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3" id="btnAudio1"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_correct_audio; ?>" id="audCorrectSound"></audio>
                                                    <br>
                                                    <button type="button"
                                                        class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                        Upload Audio
                                                        <input type="file" id="fileCorrectAnswerAudio" name="fileCorrectAnswerAudio">
                                                    </button><span id="lblFileName" class="lblFileName">No file
                                                        selected</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="newtopic">Incorrect Answer Audio Sound</label> 
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3" id="btnAudio2"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_incorrect_audio; ?>" id="audIncorrectSound"></audio>
                                                    <br>
                                                    <button type="button"
                                                        class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                        Upload Audio
                                                        <input type="file" id="fileIncorrectAnswerAudio" name="fileIncorrectAnswerAudio">
                                                    </button><span id="lblFileName2" class="lblFileName">No file
                                                        selected</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="newtopic">Complete assessment Audio Sound</label> 
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3" id="btnAudio10"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_complete_assessment_audio; ?>" id="audCompleteAssesmentSound"></audio>
                                                    <br>
                                                    <button type="button"
                                                        class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                        Upload Audio
                                                        <input type="file" id="fileCompleteAnswerAudio" name="fileCompleteAnswerAudio">
                                                    </button><span id="lblFileName3" class="lblFileName">No file
                                                        selected</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                 <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Demo Voice</label>                                                   
                                                    <select id="demo_audio_voice" class="form-control">
                                                        <option>Select One</option>
                                                        <?php
                                                         foreach ($audio_voice_type as $value) {
                                                              ?>
                                                                <option value="<?php echo  $value['ss_aw_id']; ?>">
																<?php echo  $value['ss_aw_voice_type']."(Pitch : ".$value['ss_aw_pitch']." Speed : ".$value['ss_aw_speed'].")"; ?></option>
                                                              <?php 
                                                          } 
                                                        ?>
                                                    </select>

                                                </div>

                                               

                                            </div>
                                             <div class="col-sm-6">
                                                 <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Demo Text</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio8"><i class="mdi mdi-play"></i></button>
                                                    <audio src="" id="demo_example_audio"></audio>
                                                   
                                                    <input class="form-control padding-45" type="text" id="demoAudioText"
                                                        placeholder="Enter sample audio text">

                                                </div>
                                             </div>

                                            <div class="col-sm-6">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Global Audio Voice</label>                                                   
                                                    <select id="global_audio_voice" class="form-control" name="global_audio_voice">
                                                        <option>Select One</option>
                                                        <?php
                                                         foreach ($audio_voice_type as $value) {
                                                              ?>
                                                                <option value="<?php echo  $value['ss_aw_id']; ?>"
                                                                    <?php
                                                                    if(!empty($result[0]->ss_aw_golabal_voice))
                                                                    {
                                                                        if($value['ss_aw_id']==$result[0]->ss_aw_golabal_voice)
                                                                        {
                                                                            echo 'selected';
                                                                        } 
                                                                    }
                                                                    ?>

                                                                    ><?php echo  $value['ss_aw_voice_type']."(Pitch : ".$value['ss_aw_pitch']." Speed : ".$value['ss_aw_speed'].")"; ?></option>
                                                              <?php 
                                                          } 
                                                        ?>
                                                    </select>

                                                </div>


                                            </div>
                                            <div class="col-sm-6"></div>
                                            <div class="col-sm-12">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Choose Audio Voice</label>                                                   
                                                    <select id="text_generate_audio_voice" class="form-control" name="text_generate_audio_voice" onchange="getaudiopitchspeed(this.value)">
                                                        <option>Select One</option>
                                                        <?php
                                                         foreach ($audio_voices as $value) {
                                                              ?>
                                                                <option value="<?php echo  $value['ss_aw_id']; ?>"
                                                                    

                                                                    ><?php echo  $value['ss_aw_voice_type']; ?></option>
                                                              <?php 
                                                          } 
                                                        ?>
                                                    </select>

                                                </div>


                                            </div>
                                            <div class="col-sm-1" style="margin-top: 35px;"><span style="font-weight: bold;">Slow</span></div>
                                            <div class="col-sm-5">
                                                <label>Pitch</label>
                                                <input type="text" name="e_pitch" id="e_pitch" class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label>Speed</label>
                                                <input type="text" name="e_speed" id="e_speed" class="form-control">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="slow_audio" onclick="listenaudio(this.id)"><i class="mdi mdi-play"></i></button>
                                                <audio src="" id="slow_audio_src"></audio>
                                            </div>

                                            <div class="col-sm-1" style="margin-top: 35px;"><span style="font-weight: bold;">Medium</span></div>
                                            <div class="col-sm-5">
                                                <label>Pitch</label>
                                                <input type="text" name="c_pitch" id="c_pitch" class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label>Speed</label>
                                                <input type="text" name="c_speed" id="c_speed" class="form-control">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="medium_audio" onclick="listenaudio(this.id)"><i class="mdi mdi-play"></i></button>
                                                <audio src="" id="medium_audio_src"></audio>
                                            </div>

                                            <div class="col-sm-1" style="margin-top: 35px;"><span style="font-weight: bold;">Fast</span></div>
                                            <div class="col-sm-5">
                                                <label>Pitch</label>
                                                <input type="text" name="a_pitch" id="a_pitch" class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label>Speed</label>
                                                <input type="text" name="a_speed" id="a_speed" class="form-control">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="fast_audio" onclick="listenaudio(this.id)"><i class="mdi mdi-play"></i></button>
                                                <audio src="" id="fast_audio_src"></audio>
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="newtopic">Bad Audio Text</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio7"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_bad_audio; ?>" id="audBadSound"></audio>
                                                    <br>
                                                    <input type="hidden" name="bad_audio" value="<?php echo $result[0]->ss_aw_bad_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtBadAudioText"
                                                        placeholder="Bad audio text" name="txtBadAudioText" value="<?php echo $result[0]->ss_aw_bad_audio_text; ?>" />
                                                </div>

                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Skip Audio Text</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio3"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_skip_audio; ?>" id="audSkipSound"></audio>
                                                    <input type="hidden" name="skip_audio" value="<?php echo $result[0]->ss_aw_skip_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtSkipAudioText"
                                                        placeholder="Skip audio text" name="txtSkipAudioText" value="<?php echo $result[0]->ss_aw_audio_text; ?>">


                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                    <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Start Lesson After Quiz Message</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio5"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_lesson_quiz_audio; ?>" id="audLessonquizSound"></audio>
                                                    <input type="hidden" name="lessonquiz_audio" value="<?php echo $result[0]->ss_aw_lesson_quiz_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtLessonquizAudioText"
                                                        placeholder="Start Lesson After Quiz Message" name="txtLessonquizAudioText" value="<?php echo $result[0]->ss_aw_lesson_quiz_text; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Correct answer audio Message</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio6"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_correct_answer_audio; ?>" id="audCorrectanswerSound"></audio>
                                                    <input type="hidden" name="correct_answer_audio" value="<?php echo $result[0]->ss_aw_correct_answer_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="correctanswerAudioText"
                                                        placeholder="Correct answer audio Message" name="correctanswerAudioText" value="<?php echo $result[0]->ss_aw_correct_answer_text; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Warning Audio Text</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio4"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_warning_audio; ?>" id="audWarningSound"></audio>
                                                    <input type="hidden" name="warning_audio" value="<?php echo $result[0]->ss_aw_warning_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtWarningAudioText"
                                                        placeholder="Warning audio text" name="txtWarningAudioText" value="<?php echo $result[0]->ss_aw_warning_text; ?>">


                                                </div>
                                                

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Welcome message for Assessment</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio9"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_welcome_assesment_audio; ?>" id="audWelcomeAssesmentSound"></audio>
                                                    <input type="hidden" name="welcome_assesment" value="<?php echo $result[0]->ss_aw_welcome_assesment_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtWarningAudioText"
                                                        placeholder="Warning audio text" name="txtWelcomeAssesmentAudioText" value="<?php echo $result[0]->ss_aw_welcome_assesment_text; ?>">


                                                </div>
                                                

                                            </div>


                                            
											
											
                                        </div>
										 
                                         <div class="row mb-2">
                                            <div class="col-sm-12 text-center">
                                                <h5>TOPICAL LESSON QUIZ</h5>    
                                            </div>
                                            
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Good (> 70%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio11"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_topical_lesson_correct; ?>" id="audCorrectTopicalLessonSound"></audio>
                                                    <input type="hidden" name="welcome_topical_lesson" value="<?php echo $result[0]->ss_aw_topical_lesson_correct_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtCorrectTopicalLessonAudioTxt"
                                                        placeholder="Warning audio text" name="txtCorrectTopicalLessonAudioTxt" value="<?php echo $result[0]->ss_aw_topical_lesson_correct_txt; ?>">


                                                </div>
                                                
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Medium (> 70%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio12"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_topical_lesson_incorrect; ?>" id="audIncorrectTopicalLessonSound"></audio>
                                                    <input type="hidden" name="welcome_topical_lesson" value="<?php echo $result[0]->ss_aw_topical_lesson_incorrect_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtIncorrectTopicalLessonAudioTxt"
                                                        placeholder="Warning audio text" name="txtIncorrectTopicalLessonAudioTxt" value="<?php echo $result[0]->ss_aw_topical_lesson_incorrect_txt; ?>">


                                                </div>
                                                
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Bad (< 50%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio13"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_topical_lesson_incorrect2; ?>" id="audIncorrect2TopicalLessonSound"></audio>
                                                    <input type="hidden" name="incorrect2_topical_lesson" value="<?php echo $result[0]->ss_aw_topical_lesson_incorrect2_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtIncorrect2TopicalLessonAudioTxt"
                                                        placeholder="Warning audio text" name="txtIncorrect2TopicalLessonAudioTxt" value="<?php echo $result[0]->ss_aw_topical_lesson_incorrect2_txt; ?>">


                                                </div>
                                                
                                            </div>

                                         </div>

                                         <div class="row mb-2">
                                            <div class="col-sm-12 text-center">
                                                <h5>TOPICAL ASSESSMENT QUIZ</h5>    
                                            </div>
                                            
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Good (> 70%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio14"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_topical_assessment_correct; ?>" id="audCorrectTopicalAssessmentSound"></audio>
                                                    <input type="hidden" name="correct_assessment_lesson" value="<?php echo $result[0]->ss_aw_topical_assessment_correct_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtCorrectTopicalAssessmentAudioTxt"
                                                        placeholder="Warning audio text" name="txtCorrectTopicalAssessmentAudioTxt" value="<?php echo $result[0]->ss_aw_topical_assessment_correct_txt; ?>">


                                                </div>
                                                
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Medium (> 70%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio15"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_topical_assessment_incorrect; ?>" id="audIncorrectTopicalAssessmentSound"></audio>
                                                    <input type="hidden" name="incorrect_topical_assessment" value="<?php echo $result[0]->ss_aw_topical_assessment_incorrect_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtIncorrectTopicalAssessmentAudioTxt"
                                                        placeholder="Warning audio text" name="txtIncorrectTopicalAssessmentAudioTxt" value="<?php echo $result[0]->ss_aw_topical_assessment_incorrect_txt; ?>">


                                                </div>
                                                
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Bad (< 50%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio16"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_topical_assessment_incorrect2; ?>" id="audIncorrect2TopicalAssessmentSound"></audio>
                                                    <input type="hidden" name="incorrect2_topical_assessment" value="<?php echo $result[0]->ss_aw_topical_assessment_incorrect2_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtIncorrect2TopicalAssessmentAudioTxt"
                                                        placeholder="Warning audio text" name="txtIncorrect2TopicalAssessmentAudioTxt" value="<?php echo $result[0]->ss_aw_topical_assessment_incorrect2_txt; ?>">


                                                </div>
                                                
                                            </div>

                                         </div>

                                         <div class="row mb-2">
                                            <div class="col-sm-12 text-center">
                                                <h5>GENERAL LANGUAGE LESSON / ASSESSMENT</h5>    
                                            </div>
                                            
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Good (> 70%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio17"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_general_language_correct; ?>" id="audCorrectGeneralLanguageSound"></audio>
                                                    <input type="hidden" name="correct_general_language" value="<?php echo $result[0]->ss_aw_general_language_correct_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtCorrectGeneralLanguageAudioTxt"
                                                        placeholder="Warning audio text" name="txtCorrectGeneralLanguageAudioTxt" value="<?php echo $result[0]->ss_aw_general_language_correct_txt; ?>">


                                                </div>
                                                
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Medium (> 70%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio18"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_general_language_incorrect; ?>" id="audIncorrectGeneralLanguageSound"></audio>
                                                    <input type="hidden" name="incorrect_general_language" value="<?php echo $result[0]->ss_aw_general_language_incorrect_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtIncorrectGeneralLanguageAudioTxt"
                                                        placeholder="Warning audio text" name="txtIncorrectGeneralLanguageAudioTxt" value="<?php echo $result[0]->ss_aw_general_language_incorrect_txt; ?>">


                                                </div>
                                                
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Bad (< 50%)</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio19"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'assets/audio/'.$result[0]->ss_aw_general_language_incorrect2; ?>" id="audIncorrect2GeneralLanguageSound"></audio>
                                                    <input type="hidden" name="incorrect2_general_language" value="<?php echo $result[0]->ss_aw_general_language_incorrect2_txt; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtIncorrect2GeneralLanguageAudioTxt"
                                                        placeholder="Warning audio text" name="txtIncorrect2GeneralLanguageAudioTxt" value="<?php echo $result[0]->ss_aw_general_language_incorrect2_txt; ?>">


                                                </div>
                                                
                                            </div>

                                         </div>


                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">

                                <div class="text-left">
                                    <button type="submit"
                                        class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Update</button>
                                    <button type="button"
                                        class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
                                </div>
                            </div>


                        </div>
                        <input type="hidden" name="update_general_settings" value="update_general_settings">
                        <input type="hidden" name="record_id" value="<?php echo $result[0]->ss_aw_general_settings_id; ?>">
                    </form>

               


                </div> <!-- container -->

            </div> <!-- content -->

            <?php
                include('includes/bottombar.php');
            ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <style type="text/css">
    .custom-form-control {

        width: 50px;

    }

    .selectize-dropdown {
        z-index: 99999;
    }

    .selectize-dropdown-header {
        display: none;
    }

    .dropify-wrapper .dropify-message p {
        line-height: 50px;
    }

    .custom-color {
        background-color: #3283f6;
        margin-right: 10px;
    }

    .templete {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-box {
        border: 1px solid #ced4da;
    }
.frm-audio-settings {
    position:relative;
}
.btn-play-audio{
    position: absolute;
    top: 34px;
    right: 5px;
}
.padding-45 {
    padding-right:45px;
}
    </style>

    <?php
            include('footer.php')
        ?>
    <!-- Table Editable plugin-->
    <script src="<?php echo base_url();?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
    

    <!-- <script src="./assets/libs/select2/js/select2.min.js"></script> -->
    <!-- <script src="./assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script> -->
    <!-- <script src="./assets/js/pages/form-validation.init.js"></script> -->
    <!-- <script src="./assets/js/pages/form-advanced.init.js"></script> -->



    <script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Validation init js-->

    <script>
    jQuery(function() {
        jQuery('#fileCorrectAnswerAudio').change(function() {
            jQuery('#lblFileName').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });
        jQuery('#fileIncorrectAnswerAudio').change(function() {
            jQuery('#lblFileName2').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });
        jQuery('#fileCompleteAnswerAudio').change(function() {
            jQuery('#lblFileName3').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });
        jQuery('#btnAudio1').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audCorrectSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audCorrectSound')[0].pause();
            }

        })
        jQuery('#audCorrectSound').on('ended', function() {
            jQuery('#btnAudio1 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio2').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrectSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrectSound')[0].pause();
            }

        })
         jQuery('#audIncorrectSound').on('ended', function() {
            jQuery('#btnAudio2 i').removeClass('mdi-pause').addClass('mdi-play');
        });
		
		jQuery('#btnAudio3').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audSkipSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audSkipSound')[0].pause();
            }

        })
         jQuery('#audSkipSound').on('ended', function() {
            jQuery('#btnAudio3 i').removeClass('mdi-pause').addClass('mdi-play');
        });
		
		jQuery('#btnAudio4').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audWarningSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audWarningSound')[0].pause();
            }

        })
         jQuery('#audWarningSound').on('ended', function() {
            jQuery('#btnAudio4 i').removeClass('mdi-pause').addClass('mdi-play');
        });
		
		jQuery('#btnAudio5').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audLessonquizSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audLessonquizSound')[0].pause();
            }

        })
         jQuery('#audLessonquizSound').on('ended', function() {
            jQuery('#btnAudio5 i').removeClass('mdi-pause').addClass('mdi-play');
        });
		jQuery('#btnAudio6').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audCorrectanswerSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audCorrectanswerSound')[0].pause();
            }

        })
         jQuery('#audCorrectanswerSound').on('ended', function() {
            jQuery('#btnAudio6 i').removeClass('mdi-pause').addClass('mdi-play');
        });
		jQuery('#btnAudio7').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audBadSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audBadSound')[0].pause();
            }

        })
         jQuery('#audBadSound').on('ended', function() {
            jQuery('#btnAudio7 i').removeClass('mdi-pause').addClass('mdi-play');
        });


         jQuery('#btnAudio9').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audWelcomeAssesmentSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audWelcomeAssesmentSound')[0].pause();
            }

        })
         jQuery('#audWelcomeAssesmentSound').on('ended', function() {
            jQuery('#btnAudio9 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio10').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audCompleteAssesmentSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audCompleteAssesmentSound')[0].pause();
            }

        })
        jQuery('#audCompleteAssesmentSound').on('ended', function() {
            jQuery('#btnAudio10 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio11').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audCorrectTopicalLessonSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audCorrectTopicalLessonSound')[0].pause();
            }

        });
        jQuery('#audCorrectTopicalLessonSound').on('ended', function() {
            jQuery('#btnAudio11 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio12').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrectTopicalLessonSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrectTopicalLessonSound')[0].pause();
            }

        });
        jQuery('#audIncorrectTopicalLessonSound').on('ended', function() {
            jQuery('#btnAudio12 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio13').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrect2TopicalLessonSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrect2TopicalLessonSound')[0].pause();
            }

        });
        jQuery('#audIncorrect2TopicalLessonSound').on('ended', function() {
            jQuery('#btnAudio13 i').removeClass('mdi-pause').addClass('mdi-play');
        });


        jQuery('#btnAudio14').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audCorrectTopicalAssessmentSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audCorrectTopicalAssessmentSound')[0].pause();
            }

        });
        jQuery('#audCorrectTopicalAssessmentSound').on('ended', function() {
            jQuery('#btnAudio14 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio15').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrectTopicalAssessmentSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrectTopicalAssessmentSound')[0].pause();
            }

        });
        jQuery('#audIncorrectTopicalAssessmentSound').on('ended', function() {
            jQuery('#btnAudio15 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio16').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrect2TopicalAssessmentSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrect2TopicalAssessmentSound')[0].pause();
            }

        });
        jQuery('#audIncorrect2TopicalAssessmentSound').on('ended', function() {
            jQuery('#btnAudio16 i').removeClass('mdi-pause').addClass('mdi-play');
        });


        jQuery('#btnAudio17').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audCorrectGeneralLanguageSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audCorrectGeneralLanguageSound')[0].pause();
            }

        });
        jQuery('#audCorrectGeneralLanguageSound').on('ended', function() {
            jQuery('#btnAudio17 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio18').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrectGeneralLanguageSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrectGeneralLanguageSound')[0].pause();
            }

        });
        jQuery('#audIncorrectGeneralLanguageSound').on('ended', function() {
            jQuery('#btnAudio18 i').removeClass('mdi-pause').addClass('mdi-play');
        });

        jQuery('#btnAudio19').click(function() {
            let targetObj = jQuery(this).find('i');
            if (targetObj.hasClass('mdi-play')) {
                targetObj.removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#audIncorrect2GeneralLanguageSound')[0].play();
            } else {
                targetObj.removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#audIncorrect2GeneralLanguageSound')[0].pause();
            }

        });
        jQuery('#audIncorrect2GeneralLanguageSound').on('ended', function() {
            jQuery('#btnAudio19 i').removeClass('mdi-pause').addClass('mdi-play');
        });

    });
	
    </script>
    <script type="text/javascript">
       $(document).ready(function() { 
          $("#btnAudio8").click(function(){
           
            var demoAudioText = $("#demoAudioText").val();
            var demo_audio_voice = $("#demo_audio_voice").val();            
            var url= '<?php echo base_url(); ?>'+'admin/demo_audio_play';

            $.ajax({
              type: 'POST',
              url: url,
              data: {'demoAudioText':demoAudioText,'demo_audio_voice':demo_audio_voice},
              dataType: "text",
              beforeSend: function() {
                    $("#demo_example_audio").removeAttr("src");
                },
              success: function(resultData) {
                $('#demo_example_audio').attr('src', resultData);  
                $('#demo_example_audio').get(0).load();
              
                $('#demo_example_audio').get(0).play();                   
                                                                        
              }
            });
           
            
          });
       });

        function getaudiopitchspeed(audio_id){
            $.ajax({
              type: 'POST',
              url: '<?= base_url(); ?>admin/getaudiopitchspeed',
              data: {'audio_id':audio_id},
              dataType: "json",
              success: function(resultData) {
                console.log(resultData);
                if (resultData != "") {
                    $("#e_pitch").val(resultData.ss_aw_e_pitch);
                    $("#e_speed").val(resultData.ss_aw_e_speed);

                    $("#c_pitch").val(resultData.ss_aw_c_pitch);
                    $("#c_speed").val(resultData.ss_aw_c_speed);

                    $("#a_pitch").val(resultData.ss_aw_a_pitch);
                    $("#a_speed").val(resultData.ss_aw_a_speed);
                }     
              }
            });
        }

        function listenaudio(id){
            console.log("click button >>>", id);
            let pitch = "";
            let speed = "";
            let global_sudio = $("#text_generate_audio_voice").val();
            if (id == 'slow_audio') {
                pitch = $("#e_pitch").val();
                speed = $("#e_speed").val();
            }
            else if(id == 'medium_audio'){
                pitch = $("#c_pitch").val();
                speed = $("#c_speed").val();
            }
            else{
                pitch = $("#a_pitch").val();
                speed = $("#a_speed").val();
            }

            $.ajax({
              type: 'POST',
              url: '<?= base_url(); ?>admin/listenaudio',
              data: {'pitch':pitch,'speed':speed,'global_sudio':global_sudio},
              dataType: "text",
              beforeSend: function() {
                $("#"+id+"_src").removeAttr("src");
              },
              success: function(resultData) {
                $("#"+id+"_src").attr('src', resultData);  
                $("#"+id+"_src").get(0).load();
              
                $("#"+id+"_src").get(0).play();                   
                                                                        
              }
            });
        }
     </script>
</body>

</html>