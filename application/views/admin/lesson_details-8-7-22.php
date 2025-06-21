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
                                    <li class="breadcrumb-item">Lessons</li>
                                    <li class="breadcrumb-item active">Lesson Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
				<?php include("error_message.php");?>
                    <div class="row">

                        <div class="col-md-4">
                            <h4 class="page-title">Level: <?php 
                            $course_level_ary = explode(",", $upload_lesson_details[0]->ss_aw_course_id);
                            $course_level = "";

                            foreach ($course_level_ary as $key => $value) {
                                if (!empty($value)) {
                                    if ($key != 0) {
                                        $course_level .= ",";
                                    }
                                    if ($value == 1) {
                                        $course_level .= "E";
                                    }
                                    elseif ($value == 2) {
                                        $course_level .= "C";
                                    }
                                    else{
                                        $course_level .= "A";
                                    }
                                }
                            }
                            echo $course_level;   
                            ?>    
                            </h4>
                        </div>

                        <div class="col-md-4">
                            <h4 class="page-title">Topic: <?= $upload_lesson_details[0]->ss_aw_lesson_topic; ?></h3>
                        </div>

                    </div>
                    <!-- end page title -->



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    

                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                            data-show-columns="true">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th># SL No.</th>
                                                    <th>Title</th>
                                                    <th>Details</th>
                                                    <!-- <th>Audio</th>
                                                    <th>Action</th> -->
                                                </tr>
                                            </thead>

                                            <tbody>
        										
                                                       <?php
                                                       if (!empty($lesson_details)) {
                                                           foreach ($lesson_details as $key => $value) {
                                                            if ($value['ss_aw_lesson_format_type'] != 2) {
                                                                ?>
                                                               <tr>
                                                                   <td><?= $key + 1; ?></td>
                                                                   <td><?= $value['ss_aw_lesson_title']; ?>
                                                                       <?php
                                                                       if (!empty($value['ss_aw_lesson_title'])) {
                                                                           ?>
                                                                           <button class="btn btn-warning waves-effect btn-xs waves-light" type="button" data-toggle="modal" data-target="#text-upload-<?= $value['ss_aw_lession_id']; ?>">Edit Text</button>
                                                                        <?php
                                                                        if (!empty($value['ss_aw_lesson_audio'])) {
                                                                            ?>
                                                                            <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 audioBtn" data-id="<?= $value['ss_aw_lession_id']; ?>" id="btnAudio_<?= $value['ss_aw_lession_id']; ?>" onclick="playAudio(<?= $value['ss_aw_lession_id']; ?>);"><i class="mdi mdi-play" id="playPauseBtn_<?= $value['ss_aw_lession_id']; ?>"></i></button>
                                                    <audio src="<?php echo base_url().$value['ss_aw_lesson_audio']; ?>" id="sound_<?= $value['ss_aw_lession_id']; ?>"></audio>
                                                                            <?php
                                                                        }
                                                                       }
                                                                       ?>

                                                                   </td>
                                                                   <td><?= $value['ss_aw_lesson_details']; ?>
                                                                       <?php
                                                                       if (!empty($value['ss_aw_lesson_details'])) {
                                                                           ?>
                                                                           <button class="btn btn-warning waves-effect btn-xs waves-light" type="button" data-toggle="modal" data-target="#details-upload-<?= $value['ss_aw_lession_id']; ?>">Edit Text</button>
                                                                           <?php
                                                                        if (!empty($value['ss_aw_lesson_details_audio'])) {
                                                                            ?>
                                                                            <button type="button" class="btn btn-success waves-effect waves-light btn-xs ml-3 audioDetailsBtn" data-id="<?= $value['ss_aw_lession_id']; ?>" id="btnDetailsAudio_<?= $value['ss_aw_lession_id']; ?>" onclick="playDetailsAudio(<?= $value['ss_aw_lession_id']; ?>);"><i class="mdi mdi-play" id="playDetailsPauseBtn_<?= $value['ss_aw_lession_id']; ?>"></i></button>
                                                    <audio src="<?php echo base_url().$value['ss_aw_lesson_details_audio']; ?>" id="details_sound_<?= $value['ss_aw_lession_id']; ?>"></audio>
                                                                            <?php
                                                                        }
                                                                       }
                                                                       ?>
                                                                           
                                                                   </td>
                                                               </tr>
                    <div class="modal fade" id="text-upload-<?= $value['ss_aw_lession_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel-<?= $value['ss_aw_lession_id']; ?>">Edit Title</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="post" action="<?php echo base_url(); ?>admin_course_content/upload_lesson_title" id="demo-form" class="parsley-examples" id="modal-demo-form-<?= $value['ss_aw_lession_id']; ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="title_id" value="<?= $value['ss_aw_lession_id']; ?>">
                                        <input type="hidden" name="lesson_upload_id" value="<?= $upload_lesson_details[0]->ss_aw_lession_id; ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Title<span
                            class="text-danger">*</span></label><br />
                                            <textarea name="lesson_title" id="lesson_title" class="form-control" required><?= $value['ss_aw_lesson_title']; ?></textarea>
                                                        
                                            </div>
                                            
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Update
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <div class="modal fade" id="details-upload-<?= $value['ss_aw_lession_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterDetailsModalLabel-<?= $value['ss_aw_lession_id']; ?>">Edit Details</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="post" action="<?php echo base_url(); ?>admin_course_content/upload_lesson_details" id="demo-form" class="parsley-examples" id="modal-details-form-<?= $value['ss_aw_lession_id']; ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="details_id" value="<?= $value['ss_aw_lession_id']; ?>">
                                        <input type="hidden" name="lesson_upload_id" value="<?= $upload_lesson_details[0]->ss_aw_lession_id; ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Details<span
                            class="text-danger">*</span></label><br />
                                            <textarea name="lesson_details" id="lesson_details" class="form-control" required><?= $value['ss_aw_lesson_details']; ?></textarea>
                                                        
                                            </div>
                                            
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Update
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                               <?php   
                                                            }
                                                           }
                                                       }
                                                       ?> 
                                            </tbody>
                                        </table>
                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">


                        </div>

                        <div class="col-md-6">
                            <div class="text-right">
                                <ul class="pagination pagination-rounded justify-content-end">
                                     <?php foreach ($links as $link) {
                                    echo "<li>". $link."</li>";
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="audio-upload" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Upload Audio</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="post" action="<?php echo base_url(); ?>admin_course_content/upload_readalong_audio" id="demo-form" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data">
                                        <input type="hidden" name="readalong_id" id="readalong_id">
                                        <input type="hidden" name="readalong_upload_id" id="readalong_upload_id" value="<?= $upload_details[0]->ss_aw_id; ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Audio<span
                                                        class="text-danger">*</span></label><br />
                                                        <input name="file" type="file" data-plugins="dropify" data-height="100" required/>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <!-- <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                        
                                            </div>
                                            
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Upload
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>
        
            
                                      

                                    
 
                                        

                                    </div> <!-- end card-body-->

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->


                        <!-- Modal -->
                    <div class="modal fade" id="image-upload" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Upload Image</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="post" action="<?php echo base_url(); ?>admin_course_content/upload_readalong_image" id="demo-form" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data">
                                        <input type="hidden" name="upload_image_id" id="upload_image_id">
                                        <input type="hidden" name="readalong_upload_id" value="<?= $upload_details[0]->ss_aw_id; ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Image<span
                                                        class="text-danger">*</span></label><br />
                                                        <input name="content_image" type="file" data-plugins="dropify" data-height="100" required/>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <!-- <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                        
                                            </div>
                                            
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Upload
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>

                                    </div> <!-- end card-body-->

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->


                    </div><!-- /.modal -->

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
       /*******Start-debasis******/
       .content-right{
        justify-content: flex-end;
    }
    .topselectdropdown{
        width: 200px;
    }
    /*******End-debasis******/
    </style>	

    <?php
            include('footer.php')
        ?>
    <!-- Table Editable plugin-->
    <script src="<?php echo base_url();?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
    <script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <!-- Validation init js-->
    <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>

    <script type="text/javascript">
        function uploadAudio(readalongId) {
            jQuery("#readalong_id").val(readalongId);
        }

        function uploadImage(readalongId){
            jQuery("#upload_image_id").val(readalongId);
        }

        function playAudio(readalongId) {
            if (jQuery("#playPauseBtn_"+readalongId).hasClass('mdi-play')) {
                jQuery("#playPauseBtn_"+readalongId).removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#sound_'+readalongId)[0].play();
            } else {
                jQuery("#playPauseBtn_"+readalongId).removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#sound_'+readalongId)[0].pause();
            }
        }
        
        jQuery(".audioBtn").each(function(){
            var readalongId = jQuery(this).attr('data-id');
            jQuery('#sound_'+readalongId).on('ended', function() {
                jQuery('#playPauseBtn_'+readalongId).removeClass('mdi-pause').addClass('mdi-play');
            });
        });

        function playDetailsAudio(readalongId) {
            if (jQuery("#playDetailsPauseBtn_"+readalongId).hasClass('mdi-play')) {
                jQuery("#playDetailsPauseBtn_"+readalongId).removeClass('mdi-play').addClass('mdi-pause');
                jQuery('#details_sound_'+readalongId)[0].play();
            } else {
                jQuery("#playDetailsPauseBtn_"+readalongId).removeClass('mdi-pause').addClass('mdi-play');
                jQuery('#details_sound_'+readalongId)[0].pause();
            }
        }
        
        jQuery(".audioDetailsBtn").each(function(){
            var readalongId = jQuery(this).attr('data-id');
            jQuery('#details_sound_'+readalongId).on('ended', function() {
                jQuery('#playDetailsPauseBtn_'+readalongId).removeClass('mdi-pause').addClass('mdi-play');
            });
        });
    </script>
</body>

</html>	