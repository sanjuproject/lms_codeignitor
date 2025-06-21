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
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="newtopic">Correct Answer Audio Sound</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3" id="btnAudio1"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_correct_audio; ?>" id="audCorrectSound"></audio>
                                                    <br>
                                                    <button type="button"
                                                        class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                        Upload Audio
                                                        <input type="file" id="fileCorrectAnswerAudio" name="fileCorrectAnswerAudio">
                                                    </button><span id="lblFileName" class="lblFileName">No file
                                                        selected</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="newtopic">Incorrect Answer Audio Sound</label> 
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3" id="btnAudio2"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_incorrect_audio; ?>" id="audIncorrectSound"></audio>
                                                    <br>
                                                    <button type="button"
                                                        class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                        Upload Audio
                                                        <input type="file" id="fileIncorrectAnswerAudio" name="fileIncorrectAnswerAudio">
                                                    </button><span id="lblFileName2" class="lblFileName">No file
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

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="newtopic">Bad Audio Text</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio7"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_bad_audio; ?>" id="audBadSound"></audio>
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
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_skip_audio; ?>" id="audSkipSound"></audio>
                                                    <input type="hidden" name="skip_audio" value="<?php echo $result[0]->ss_aw_skip_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtSkipAudioText"
                                                        placeholder="Skip audio text" name="txtSkipAudioText" value="<?php echo $result[0]->ss_aw_audio_text; ?>">


                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                    <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Start Lesson After Quiz Message</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio5"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_lesson_quiz_audio; ?>" id="audLessonquizSound"></audio>
                                                    <input type="hidden" name="lessonquiz_audio" value="<?php echo $result[0]->ss_aw_lesson_quiz_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtLessonquizAudioText"
                                                        placeholder="Start Lesson After Quiz Message" name="txtLessonquizAudioText" value="<?php echo $result[0]->ss_aw_lesson_quiz_text; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Correct answer audio Message</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio6"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_correct_answer_audio; ?>" id="audCorrectanswerSound"></audio>
                                                    <input type="hidden" name="correct_answer_audio" value="<?php echo $result[0]->ss_aw_correct_answer_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="correctanswerAudioText"
                                                        placeholder="Correct answer audio Message" name="correctanswerAudioText" value="<?php echo $result[0]->ss_aw_correct_answer_text; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Warning Audio Text</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio4"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_warning_audio; ?>" id="audWarningSound"></audio>
                                                    <input type="hidden" name="warning_audio" value="<?php echo $result[0]->ss_aw_warning_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtWarningAudioText"
                                                        placeholder="Warning audio text" name="txtWarningAudioText" value="<?php echo $result[0]->ss_aw_warning_text; ?>">


                                                </div>
                                                

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group frm-audio-settings">
                                                    <label for="txtQuizIdleTime">Welcome message for Assessment</label>
                                                    <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 btn-play-audio" id="btnAudio9"><i class="mdi mdi-play"></i></button>
                                                    <audio src="<?php echo base_url().'uploads/'.$result[0]->ss_aw_welcome_assesment_audio; ?>" id="audWelcomeAssesmentSound"></audio>
                                                    <input type="hidden" name="welcome_assesment" value="<?php echo $result[0]->ss_aw_welcome_assesment_audio; ?>" />
                                                    <input class="form-control padding-45" type="text" id="txtWarningAudioText"
                                                        placeholder="Warning audio text" name="txtWelcomeAssesmentAudioText" value="<?php echo $result[0]->ss_aw_welcome_assesment_text; ?>">


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

    });
	
    </script>
    <script type="text/javascript">
       $(document).ready(function() { 
          $("#btnAudio8").click(function(){
           
            var demoAudioText = $("#demoAudioText").val();
            var demo_audio_voice = $("#demo_audio_voice").val();            
            var url= '<?php echo base_url(); ?>'+'admin/demo_audio_play';

			
			// if(demo_audio_voice == 'En-GBR-Wavelength - F- Smartphone')
			// {
			// 	language_code ='en-gb';
			// }
			// else if(demo_audio_voice == 'En-US-Wavelength - D - Smartphone')
			// {
			// 	language_code ='en-us';
			// }
			// else if(demo_audio_voice == 'En-US-Wavelength - C - Smartphone')
			// {
			// 	language_code ='en-us';
			// }
			// else if(demo_audio_voice == 'En-US-Wavelength - C - Smartphone')
			// {
			// 	language_code ='en-us';
			// }

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
     </script>
</body>

</html>