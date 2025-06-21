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
                             <li class="breadcrumb-item active">General Settings</li>
                         </ol>
                     </div>
                 </div>
             </div>
             <?php include("error_message.php"); ?>
             <div class="row">

                 <div class="col-md-6">
                     <h4 class="page-title">General Settings</h4>
                 </div>

                 <div class="col-md-6">


                 </div>



             </div>
             <!-- end page title -->


             <form action="<?php echo base_url()  ?>admin/generalsettings" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                 <div class="row">
                     <div class="col-12">
                         <div class="card">
                             <div class="card-body">
                                 <div class="row mb-2">
                                     <div class="col-sm-4">
                                         <div class="form-group">
                                             <label for="ss_aw_lesson_assessment_time_difference">Lesson Assessment Time Difference (hours)</label>
                                             <input class="form-control" type="text" id="ss_aw_lesson_assessment_time_difference" name="ss_aw_lesson_assessment_time_difference" value="<?php echo $result[0]->ss_aw_lesson_assessment_time_difference; ?>">
                                         </div>
                                         <div class="form-group">
                                             <label for="ss_aw_lesson_time_gap">Time Gap between Lessons
                                                 (hours)</label>
                                             <input class="form-control" type="text" id="ss_aw_lesson_time_gap" placeholder="Time interval for recap screens in sec" name="ss_aw_lesson_time_gap" value="<?php echo $result[0]->ss_aw_lesson_time_gap; ?>">
                                

                                         </div>
                                         <div class="form-group">
                                             <label for="ss_aw_lesson_time_gap">Time Gap between Diagnostic Course
                                                 (Days)</label>
                                             <input class="form-control" type="text" id="ss_aw_diagnostic_purchase_restriction" placeholder="Time interval for re-assign course for singale user" name="ss_aw_diagnostic_purchase_restriction" value="<?php echo $result[0]->ss_aw_diagnostic_purchase_restriction; ?>">


                                         </div>




                                     </div>
                                     <div class="col-sm-4">
                                         <div class="form-group">
                                             <label for="ss_aw_next_course_start_time">Next Course Start time gap
                                                 (hours)</label>
                                             <input class="form-control" type="text" id="ss_aw_next_course_start_time" placeholder="Pause wrong answer time in sec" name="ss_aw_next_course_start_time" value="<?php echo $result[0]->ss_aw_next_course_start_time; ?>">
                                         </div>
                                         <div class="form-group">
                                             <label for="ss_aw_supplementary_content_access_duration">Supplementary content access duration (hours) </label>
                                             <input class="form-control" type="text" id="ss_aw_supplementary_content_access_duration" placeholder="Quiz idle time to exit in sec" name="ss_aw_supplementary_content_access_duration" value="<?php echo $result[0]->ss_aw_supplementary_content_access_duration; ?>">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">

                         <div class="text-left">
                             <button type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Update</button>
                             <button type="button" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
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
 </style>

 <?php
    include('footer.php')
    ?>
 <!-- Table Editable plugin-->
 <script src="<?php echo base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

 <!-- Table editable init-->
 <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->


 <!-- <script src="./assets/libs/select2/js/select2.min.js"></script> -->
 <!-- <script src="./assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script> -->
 <!-- <script src="./assets/js/pages/form-validation.init.js"></script> -->
 <!-- <script src="./assets/js/pages/form-advanced.init.js"></script> -->



 <script src="<?php echo base_url(); ?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
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

     });
 </script>
 <script type="text/javascript">
     $(document).ready(function() {
         $("#btnAudio8").click(function() {

             var demoAudioText = $("#demoAudioText").val();
             var demo_audio_voice = $("#demo_audio_voice").val();
             var url = '<?php echo base_url(); ?>' + 'admin/demo_audio_play';
             var language_code = 'en';
             if (demo_audio_voice == 'En-GBR-Wavelength - F- Smartphone') {
                 language_code = 'en-gb';
             } else if (demo_audio_voice == 'En-US-Wavelength - D - Smartphone') {
                 language_code = 'en-us';
             } else if (demo_audio_voice == 'En-US-Wavelength - C - Smartphone') {
                 language_code = 'en-us';
             } else if (demo_audio_voice == 'En-US-Wavelength - C - Smartphone') {
                 language_code = 'en-us';
             }
             $.ajax({
                 type: 'POST',
                 url: url,
                 data: {
                     'demoAudioText': demoAudioText,
                     'demo_audio_voice': demo_audio_voice,
                     'language_code': language_code
                 },
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