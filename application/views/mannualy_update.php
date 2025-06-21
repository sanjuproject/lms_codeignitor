
<style>
    .btn-submit{
        margin-top: 35px;
    }
    option:disabled {
        background-color: #fbf1f1;
    }
    .lesson_topics ul{

        columns: 4;
        -webkit-columns: 4;
        -moz-columns: 4;
        list-style-type: none;
    }
    .checked_red{
        color: #ff0000;
    }
</style>  

<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item active"><h3>Manage Lesson Assessment Data</h3></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="row parent-details-body">
                            <div class="col-6">
                                <h4 class="details-title">User Name: <span><?= $child_details[0]->ss_aw_child_first_name . " " . $child_details[0]->ss_aw_child_last_name; ?></span></h4>
                                <h4 class="details-title">E-mail: <span><?= $child_details[0]->ss_aw_child_email; ?></span></h4>
                            </div>
                            <div class="col-6">
                                <h4 class="details-title"><?= $child_details[0]->ss_aw_is_institute == '1' ? 'Institution Name:' : '' ?> <span><?= $child_details[0]->ss_aw_is_institute == '1' ? $institution->ss_aw_name : ''; ?></span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">    
                        <?php
                        if ($this->session->flashdata('success')) {
                            ?>
                            <div class="row alert-msg" style="text-align: center;background-color: #11ca176b;margin: -23px -25px 0px -25px;color: #fff;">
                                <div class="col-md-12">
                                    <div class="page-title-left">
                                        <h5><?php echo $this->session->flashdata('success'); ?></h5>                                   
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        if ($this->session->flashdata('error')) {
                            ?>
                            <!--                            <div class="row" style="text-align: center;background: rgb(255,198,188);
                            background: linear-gradient(180deg, rgba(255,198,188,1) 0%, rgba(255,255,255,1) 50%, rgba(255,198,188,1) 100%);margin: -23px -25px 0px -25px;color: #fff;">-->
                            <div class="row" style="text-align: center;background-color: #ff917e6b;margin: -23px -25px 0px -25px;color: #fff;">
                                <div class="col-md-12">
                                    <div class="page-title-left">
                                        <h5><?php echo $this->session->flashdata('error'); ?></h5>                                   
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row" id="msg_lesson" style="text-align: center;background-color: #ff917e6b;margin: -23px -25px 0px -25px;color: #fff; display: none;">
                            <div class="col-md-12">
                                <div class="page-title-left page_title_left_lesson">

                                </div>
                            </div>
                        </div>

                        <form class="no-load" name="frm_master_lite" action="<?=base_url('master_lite/lesson_completion')?>" id="frm_master_lite" method="post" onsubmit="return getConfirmation(this);" enctype="multipart/form-data">
                        <input type="hidden" name="child_id" id="lesson_child_id" required value="<?= $child_details[0]->ss_aw_child_id ?>">
                        <input type="hidden" name="child_level" id="lesson_child_level" value="<?= $course_details->ss_aw_course_id ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Module Topic:</b></label>
                                   
                                    <div class="col-12 lesson_topics">
                                        <ul>
                                            <?php
//                                             echo "<pre>";
//                                                print_r($lesson_list);
//                                                exit;
                                            if (!empty($lesson_list)) {
                                                
                                                foreach ($lesson_list as $key => $value) {
                                                                                                     
                                                    $in_progress = false;
                                                    $checked='checked';
                                                    if ($value['ss_aw_las_lesson_id'] != '' && ($value['ss_aw_last_lesson_modified_date'] != '' || $value['ss_aw_last_lesson_modified_date'] == '0000-00-00 00:00:00') && $value['lesson_end_date'] == '') {
                                                       
                                                        $in_progress = true;
                                                        $checked='';
                                                    } elseif ($value['ss_aw_las_lesson_id'] != '' && ($value['ss_aw_last_lesson_modified_date'] != '' || $value['ss_aw_last_lesson_modified_date'] == '0000-00-00 00:00:00') && $value['lesson_end_date'] != '' && $value['assement_complete'] == '') {
                                                       
                                                        $in_progress = true;
                                                         $checked='';
                                                    }
                                                    
                                                    ?>
                                                    <li class=""><input type="checkbox" data-for="<?= $value['ss_aw_section_reference_no'] ?>" 
                                                        id="lesson_check_<?= $value['ss_aw_section_reference_no'] ?>" class="lesson_container" 
                                                        name="lesson_value[]" value="<?= $value['ss_aw_lession_id']; ?>" 
                                                    <?= $value['ss_aw_last_lesson_modified_date'] != '' ? $checked.' disabled' : '' ?> 
                                                        <label for="lesson_check_<?= $value['ss_aw_section_reference_no'] ?>">  
                                                                <?= $value['ss_aw_lesson_topic']; ?> <?=$in_progress==true?'<span style="background-color: #0421f17d;color: #fff;">(In-Progress)</span>':''?></label></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Action</label>
                                    <select class="form-control" name="action" id="action" required>
                                        <option value="">Choose Action</option>
                                        <option value="1">Mark as Complete</option>                                        
                                        <option value="3">Mark as accessible</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" class="btn-submit" name="lesson_submit" value="Submit">
                                </div>
                            </div>                            
                        </div>                        
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->

    </div> <!-- container -->

</div> <!-- content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>
<script>
    $(document).ready(function () {
        $(".lesson_container").prop("required", true);
        $(".lesson_container").on("click", function () {
            $(".alert-msg").css("display", "none");
            $(".lesson_container").prop("required", false);
            //Get All Checkbox count//
            let checkedVals = $('.lesson_container:checkbox:checked').map(function () {
                return $(this).data("for");
            }).get();
            //GET all Dissabled Count//
            let chkDisabled = $('.lesson_container:checkbox:checked:disabled').map(function () {
                return $(this).data("for");
            }).get();

            let error = false;
            let chkTotalCount = checkedVals.length;
            let chkDisaCount = chkDisabled.length;
            //Check if Mark as Accessable is possible//
            if ((chkTotalCount - chkDisaCount) > 1) {
                $("#action option[value=3]").prop('disabled', true);
            } else if ((chkTotalCount - chkDisaCount) == "1") {
                $("#action option[value=3]").prop('disabled', false);
            } else {
                $(".lesson_container").prop("required", true);
            }
            let seq_id = Math.max(...checkedVals);
            for (seq_id; seq_id > 0; seq_id--) {
                if (!$(`#lesson_check_${seq_id}`).is(":checked")) {
                    if ($(`#lesson_check_${seq_id}`).length > 0) {
                        $(`#lesson_check_${seq_id}`).parent("li").removeClass().addClass("checked_red");
                        $(`#lesson_check_${seq_id}`).prop("required", true);
                        error = true;
                    }
                } else {
                    $(`#lesson_check_${seq_id}`).parent("li").removeClass();
                }
            }
            if (error == true) {
                $(".page_title_left_lesson").html("<h5>Please Select Topics In Sequence</h5>");
                $("#msg_lesson").css("display", "block");
            } else {
                $("#msg_lesson").css("display", "none");
                $(".page_title_left_lesson").html("");
                $("li").removeClass("checked_red");

            }
        });

//        $('#lesson_container').children('option:not(:disabled):not(:eq(1))').prop('disabled', true);
//        $('#assessment_container').children('option:not(:disabled):not(:eq(1))').prop('disabled', true);
    });
    function getConfirmation(e) {                            
                               
                                let conf = confirm("Do you really want to submit the form");
                                if (conf) {
                                    return true;
                                } else {                                  
                                    return false;
                                }
                            }
</script>    