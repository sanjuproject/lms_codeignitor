
<style>
    .btn-submit{
        margin-top: 35px;
    }
    .checkbox-inline{
        padding: 10px;
    }
    .checkbox-inline input{
        width: 20px;
    }
</style>  
//<?php
//echo "<pre>";
//print_r($child_details);
//exit;
//
?>
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item active"><h3>Manage Lesson Assessment Audio Data</h3></li>
                        </ol>
                    </div>
                </div>
            </div>
<!--            <div class="row">
                <div class="col-lg-10">
                    <div class="card-box">
                        <div class="row parent-details-body">
                            <div class="col-6">
                                <h4 class="details-title">User Name: <span><?= @$child_details[0]->ss_aw_child_first_name . " " . @$child_details[0]->ss_aw_child_last_name; ?></span></h4>
                                <h4 class="details-title">E-mail: <span><?= @$child_details[0]->ss_aw_child_email; ?></span></h4>
                            </div>
                            <div class="col-6">
                                <h4 class="details-title"><?= @$child_details[0]->ss_aw_is_institute == '1' ? 'Institution Name:' : '' ?> <span><?= @$child_details[0]->ss_aw_is_institute == '1' ? $institution->ss_aw_name : ''; ?></span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->


            <div class="row">
                <div class="col-lg-10">
                    <div class="card-box">    
                        <?php
                        if ($this->session->flashdata('success')) {
                            ?>
                            <div class="row" style="text-align: center;background-color: #11ca176b;margin: -23px -25px 0px -25px;color: #fff;">
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


                        <?= form_open(base_url('course_audio_update/create_audio_file')); ?>                      
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <select class="form-control" name="course_type" id="course_type" required>
                                        <option value="">Choose Course</option>
                                        <option value="1">Lesson</option>                                        
                                        <option value="2">Assessment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Lesson ID</label>
                                    <input type="number" class="form-control" name="lesson_id" id="lesson_id" value="" required="">
                                </div>
                            </div>                           
                            <div class="col-md-3">

                                <label>Select For Audio Conversion</label>
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="title" id="title" value="1">Title
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="details" id="details" value="1">Details
                                    </label>
                                </div>                           
                            </div>                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="submit" class="btn-submit" value="Submit">
                                </div>
                            </div>                            
                        </div>                        
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->

    </div> <!-- container -->

</div> <!-- content -->
  