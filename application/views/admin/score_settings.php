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
                                    <li class="breadcrumb-item active">Score Settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>
		<?php include("error_message.php");?>
                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Score Settings</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <!-- end page title -->


                    <form action="<?php echo base_url()  ?>admin/add_scoring_values" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label><p style="font-weight: bold; font-size: 20px;">Part 1</p></label>
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part1_1">Level 1</label>
                                                    <input class="form-control" type="text" id="part1_1" name="part1_1" value="<?= $score_value[0]->part1_1; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_2">Level 2</label>
                                                    <input class="form-control" type="text" id="part1_2" name="part1_2" value="<?= $score_value[0]->part1_2; ?>">
                                                </div>
												<div class="form-group">
                                                    <label for="part1_3">Level 3</label>
                                                    <input class="form-control" type="text" id="part1_3" name="part1_3" value="<?= $score_value[0]->part1_3; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_4">Level 4</label>
                                                    <input class="form-control" type="text" id="part1_4" name="part1_4" value="<?= $score_value[0]->part1_4; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_5">Level 5</label>
                                                    <input class="form-control" type="text" id="part1_5" name="part1_5" value="<?= $score_value[0]->part1_5; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_6">Level 6</label>
                                                    <input class="form-control" type="text" id="part1_6" name="part1_6" value="<?= $score_value[0]->part1_6; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_7">Level 7</label>
                                                    <input class="form-control" type="text" id="part1_7" name="part1_7" value="<?= $score_value[0]->part1_7; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part1_8">Level 8(%)</label>
                                                    <input class="form-control" type="text" id="part1_8" name="part1_8" value="<?= $score_value[0]->part1_8; ?>">
                                                </div>
												<div class="form-group">
                                                    <label for="part1_9">Level 9</label>
                                                    <input class="form-control" type="text" id="part1_9" name="part1_9" value="<?= $score_value[0]->part1_9; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_10">Level 10</label>
                                                    <input class="form-control" type="text" id="part1_10" name="part1_10" value="<?= $score_value[0]->part1_10; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_11">Level 11</label>
                                                    <input class="form-control" type="text" id="part1_11" name="part1_11" value="<?= $score_value[0]->part1_11; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_12">Level 12</label>
                                                    <input class="form-control" type="text" id="part1_12" name="part1_12" value="<?= $score_value[0]->part1_12; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_13">Level 13</label>
                                                    <input class="form-control" type="text" id="part1_13" name="part1_13" value="<?= $score_value[0]->part1_13; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_14">Level 14</label>
                                                    <input class="form-control" type="text" id="part1_14" name="part1_14" value="<?= $score_value[0]->part1_14; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part1_15">Level 15</label>
                                                    <input class="form-control" type="text" id="part1_15" name="part1_15" value="<?= $score_value[0]->part1_15; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_16">Level 16</label>
                                                    <input class="form-control" type="text" id="part1_16" name="part1_16" value="<?= $score_value[0]->part1_16; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_17">Level 17</label>
                                                    <input class="form-control" type="text" id="part1_17" name="part1_17" value="<?= $score_value[0]->part1_17; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_18">Level 18</label>
                                                    <input class="form-control" type="text" id="part1_18" name="part1_18" value="<?= $score_value[0]->part1_18; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_19">Level 19</label>
                                                    <input class="form-control" type="text" id="part1_19" name="part1_19" value="<?= $score_value[0]->part1_19; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_20">Level 20</label>
                                                    <input class="form-control" type="text" id="part1_20" name="part1_20" value="<?= $score_value[0]->part1_20; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <label><p style="font-weight: bold; font-size: 20px;">Part 2</p></label>
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part2_1">Level 1</label>
                                                    <input class="form-control" type="text" id="part2_1" name="part2_1" value="<?= $score_value[0]->part2_1; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_2">Level 2</label>
                                                    <input class="form-control" type="text" id="part2_2" name="part2_2" value="<?= $score_value[0]->part2_2; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_3">Level 3</label>
                                                    <input class="form-control" type="text" id="part2_3" name="part2_3" value="<?= $score_value[0]->part2_3; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_4">Level 4</label>
                                                    <input class="form-control" type="text" id="part2_4" name="part2_4" value="<?= $score_value[0]->part2_4; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_5">Level 5</label>
                                                    <input class="form-control" type="text" id="part2_5" name="part2_5" value="<?= $score_value[0]->part2_5; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_6">Level 6</label>
                                                    <input class="form-control" type="text" id="part2_6" name="part2_6" value="<?= $score_value[0]->part2_6; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_7">Level 7</label>
                                                    <input class="form-control" type="text" id="part2_7" name="part2_7" value="<?= $score_value[0]->part2_7; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part2_8">Level 8</label>
                                                    <input class="form-control" type="text" id="part2_8" name="part2_8" value="<?= $score_value[0]->part2_8; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_9">Level 9</label>
                                                    <input class="form-control" type="text" id="part2_9" name="part2_9" value="<?= $score_value[0]->part2_9; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_10">Level 10</label>
                                                    <input class="form-control" type="text" id="part2_10" name="part2_10" value="<?= $score_value[0]->part2_10; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_11">Level 11</label>
                                                    <input class="form-control" type="text" id="part2_11" name="part2_11" value="<?= $score_value[0]->part2_11; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_12">Level 12</label>
                                                    <input class="form-control" type="text" id="part2_12" name="part2_12" value="<?= $score_value[0]->part2_12; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_13">Level 13</label>
                                                    <input class="form-control" type="text" id="part2_13" name="part2_13" value="<?= $score_value[0]->part2_13; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_14">Level 14</label>
                                                    <input class="form-control" type="text" id="part2_14" name="part2_14" value="<?= $score_value[0]->part2_14; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part2_15">Level 15</label>
                                                    <input class="form-control" type="text" id="part2_15" name="part2_15" value="<?= $score_value[0]->part2_15; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_16">Level 16</label>
                                                    <input class="form-control" type="text" id="part2_16" name="part2_16" value="<?= $score_value[0]->part2_16; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part2_17">Level 17</label>
                                                    <input class="form-control" type="text" id="part2_17" name="part2_17" value="<?= $score_value[0]->part2_17; ?>">
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
                                    <button type="submit"
                                        class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Update</button>
                                    <button type="button"
                                        class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
                                </div>
                            </div>


                        </div>
                        <input type="hidden" name="update_score_settings" value="update_score_settings">
                        <input type="hidden" name="record_id" value="<?= $score_value[0]->id; ?>">
                    </form>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Confidence Settings</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <form action="<?php echo base_url()  ?>admin/add_scoring_values" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label><p style="font-weight: bold; font-size: 20px;">Part 1</p></label>
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part1_1">Level 1</label>
                                                    <input class="form-control" type="text" id="part1_1" name="part1_1" value="<?= $confidence_value[0]->part1_1; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_2">Level 2</label>
                                                    <input class="form-control" type="text" id="part1_2" name="part1_2" value="<?= $confidence_value[0]->part1_2; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_3">Level 3</label>
                                                    <input class="form-control" type="text" id="part1_3" name="part1_3" value="<?= $confidence_value[0]->part1_3; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_4">Level 4</label>
                                                    <input class="form-control" type="text" id="part1_4" name="part1_4" value="<?= $confidence_value[0]->part1_4; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_5">Level 5</label>
                                                    <input class="form-control" type="text" id="part1_5" name="part1_5" value="<?= $confidence_value[0]->part1_5; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_6">Level 6</label>
                                                    <input class="form-control" type="text" id="part1_6" name="part1_6" value="<?= $confidence_value[0]->part1_6; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_7">Level 7</label>
                                                    <input class="form-control" type="text" id="part1_7" name="part1_7" value="<?= $confidence_value[0]->part1_7; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_8">Level 8</label>
                                                    <input class="form-control" type="text" id="part1_8" name="part1_8" value="<?= $confidence_value[0]->part1_8; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_9">Level 9</label>
                                                    <input class="form-control" type="text" id="part1_9" name="part1_9" value="<?= $confidence_value[0]->part1_9; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_10">Level 10</label>
                                                    <input class="form-control" type="text" id="part1_10" name="part1_10" value="<?= $confidence_value[0]->part1_10; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part1_11">Level 11</label>
                                                    <input class="form-control" type="text" id="part1_11" name="part1_11" value="<?= $confidence_value[0]->part1_11; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_12">Level 12</label>
                                                    <input class="form-control" type="text" id="part1_12" name="part1_12" value="<?= $confidence_value[0]->part1_12; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_13">Level 13</label>
                                                    <input class="form-control" type="text" id="part1_13" name="part1_13" value="<?= $confidence_value[0]->part1_13; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_14">Level 14</label>
                                                    <input class="form-control" type="text" id="part1_14" name="part1_14" value="<?= $confidence_value[0]->part1_14; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_15">Level 15</label>
                                                    <input class="form-control" type="text" id="part1_15" name="part1_15" value="<?= $confidence_value[0]->part1_15; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_16">Level 16</label>
                                                    <input class="form-control" type="text" id="part1_16" name="part1_16" value="<?= $confidence_value[0]->part1_16; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_17">Level 17</label>
                                                    <input class="form-control" type="text" id="part1_17" name="part1_17" value="<?= $confidence_value[0]->part1_17; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_18">Level 18</label>
                                                    <input class="form-control" type="text" id="part1_18" name="part1_18" value="<?= $confidence_value[0]->part1_18; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_19">Level 19</label>
                                                    <input class="form-control" type="text" id="part1_19" name="part1_19" value="<?= $confidence_value[0]->part1_19; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_20">Level 20</label>
                                                    <input class="form-control" type="text" id="part1_20" name="part1_20" value="<?= $confidence_value[0]->part1_20; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="part1_21">Level 21</label>
                                                    <input class="form-control" type="text" id="part1_21" name="part1_21" value="<?= $confidence_value[0]->part1_21; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_22">Level 22</label>
                                                    <input class="form-control" type="text" id="part1_22" name="part1_22" value="<?= $confidence_value[0]->part1_22; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_23">Level 23</label>
                                                    <input class="form-control" type="text" id="part1_23" name="part1_23" value="<?= $confidence_value[0]->part1_23; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_24">Level 24</label>
                                                    <input class="form-control" type="text" id="part1_24" name="part1_24" value="<?= $confidence_value[0]->part1_24; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_25">Level 25</label>
                                                    <input class="form-control" type="text" id="part1_25" name="part1_25" value="<?= $confidence_value[0]->part1_25; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_26">Level 26</label>
                                                    <input class="form-control" type="text" id="part1_26" name="part1_26" value="<?= $confidence_value[0]->part1_26; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_27">Level 27</label>
                                                    <input class="form-control" type="text" id="part1_27" name="part1_27" value="<?= $confidence_value[0]->part1_27; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_28">Level 28</label>
                                                    <input class="form-control" type="text" id="part1_28" name="part1_28" value="<?= $confidence_value[0]->part1_28; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_29">Level 29</label>
                                                    <input class="form-control" type="text" id="part1_29" name="part1_29" value="<?= $confidence_value[0]->part1_29; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="part1_30">Level 30</label>
                                                    <input class="form-control" type="text" id="part1_30" name="part1_30" value="<?= $confidence_value[0]->part1_30; ?>">
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
                                    <button type="submit"
                                        class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Update</button>
                                    <button type="button"
                                        class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
                                </div>
                            </div>


                        </div>
                        <input type="hidden" name="update_confidence_settings" value="update_confidence_settings">
                        <input type="hidden" name="record_id" value="<?= $confidence_value[0]->id; ?>">
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
</body>

</html>