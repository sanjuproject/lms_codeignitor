 <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Inactive Stage</h4>
                                </div>
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
                                                            <th>For inactives</th>
                                                            <th colspan="<?= count($lesson_list); ?>">Last lesson completed</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Level</th>
                                                            <?php
                                                            if (!empty($lesson_list)) {
                                                                foreach ($lesson_list as $key => $value) {
                                                                    ?>
                                                                    <th><?= $value['ss_aw_lesson_topic']; ?></th>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td><?=Winners?></td>
                                                            <?php
                                                            if (!empty($lesson_list)) {
                                                                foreach ($lesson_list as $key => $value) {
                                                                    ?>
                                                                    <td><?= $winners_complete_count[$value['ss_aw_lession_id']] ?></td>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <td><?= array_sum($winners_complete_count) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Champions</td>
                                                            <?php
                                                            if (!empty($lesson_list)) {
                                                                foreach ($lesson_list as $key => $value) {
                                                                    ?>
                                                                    <td><?= $champions_complete_count[$value['ss_aw_lession_id']] ?></td>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <td><?= array_sum($champions_complete_count); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?=Master?>s</td>
                                                            <?php
                                                            if (!empty($lesson_list)) {
                                                                foreach ($lesson_list as $key => $value) {
                                                                    ?>
                                                                    <td><?= $masters_complete_count[$value['ss_aw_lession_id']] ?></td>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <td><?= array_sum($masters_complete_count); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

</body>
</html>