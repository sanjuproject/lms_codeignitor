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
                                    <h4 class="page-title">Track Readalong Selection</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form">
                                            
                                        </form>
                                                
                                        <div class="table-responsive gridview-wrapper">
                                            
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th colspan="4">Lesson 4</th>
                                                            <th colspan="4">Lesson 5</th>
                                                            <th colspan="4">Lesson 6</th>
                                                            <th colspan="2">Total</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Next Level Ability</th>
                                                            <th>PTD</th>
                                                            <th>YTD</th>
                                                            <th>Last Month</th>
                                                            <th>Current Month</th>

                                                        
                                                            <th>PTD</th>
                                                            <th>YTD</th>
                                                            <th>Last Month</th>
                                                            <th>Current Month</th>

                                                            
                                                            <th>PTD</th>
                                                            <th>YTD</th>
                                                            <th>Last Month</th>
                                                            <th>Current Month</th>
                                                            
                                                            <th>Last Month</th>
                                                            <th>Current Month</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td># students</td>
                                                            <?php
                                                            foreach ($lesson4_promtional as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson5_promtional as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson6_promtional as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= $lesson4_promtional[2] + $lesson5_promtional[2] + $lesson6_promtional[2] ?></td>
                                                            <td><?= $lesson4_promtional[3] + $lesson5_promtional[3] + $lesson6_promtional[3] ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td># parent consent</td>
                                                            <?php
                                                            foreach ($lesson4_parent_consent as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson5_parent_consent as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson6_parent_consent as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= $lesson4_parent_consent[2] + $lesson5_parent_consent[2] + $lesson6_parent_consent[2] ?></td>
                                                            <td><?= $lesson4_parent_consent[3] + $lesson5_parent_consent[3] + $lesson6_parent_consent[3] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>% parent consent</td>
                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson4_promtional[$i], $lesson4_parent_consent[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson5_promtional[$i], $lesson5_parent_consent[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson6_promtional[$i], $lesson6_parent_consent[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= get_percentage($lesson4_promtional[2]+$lesson5_promtional[2]+$lesson6_promtional[2], $lesson4_parent_consent[2]+$lesson5_parent_consent[2]+$lesson6_parent_consent[2]); ?></td>
                                                            <td><?= get_percentage($lesson4_promtional[3]+$lesson5_promtional[3]+$lesson6_promtional[3], $lesson4_parent_consent[3]+$lesson5_parent_consent[3]+$lesson6_parent_consent[3]); ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td># parent declined</td>
                                                            <?php
                                                            foreach ($lesson4_parent_declined as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson5_parent_declined as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson6_parent_declined as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= $lesson4_parent_declined[2] + $lesson5_parent_declined[2] + $lesson6_parent_declined[2] ?></td>
                                                            <td><?= $lesson4_parent_declined[3] + $lesson5_parent_declined[3] + $lesson6_parent_declined[3] ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>% parent declined</td>
                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson4_promtional[$i], $lesson4_parent_declined[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson5_promtional[$i], $lesson5_parent_declined[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson6_promtional[$i], $lesson6_parent_declined[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= get_percentage($lesson4_promtional[2]+$lesson5_promtional[2]+$lesson6_promtional[2], $lesson4_parent_declined[2]+$lesson5_parent_declined[2]+$lesson6_parent_declined[2]); ?></td>
                                                            <td><?= get_percentage($lesson4_promtional[3]+$lesson5_promtional[3]+$lesson6_promtional[3], $lesson4_parent_declined[3]+$lesson5_parent_declined[3]+$lesson6_parent_declined[3]); ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td># offer expired</td>
                                                            <?php
                                                            foreach ($lesson4_parent_expired as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson5_parent_expired as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            foreach ($lesson6_parent_expired as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= $lesson4_parent_expired[2] + $lesson5_parent_expired[2] + $lesson6_parent_expired[2] ?></td>
                                                            <td><?= $lesson4_parent_expired[3] + $lesson5_parent_expired[3] + $lesson6_parent_expired[3] ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>% offer declined</td>
                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson4_promtional[$i], $lesson4_parent_expired[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson5_promtional[$i], $lesson5_parent_expired[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            for ($i=0; $i < 4; $i++) { 
                                                                ?>
                                                                <td><?= get_percentage($lesson6_promtional[$i], $lesson6_parent_expired[$i]); ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?= get_percentage($lesson4_promtional[2]+$lesson5_promtional[2]+$lesson6_promtional[2], $lesson4_parent_expired[2]+$lesson5_parent_expired[2]+$lesson6_parent_expired[2]); ?></td>
                                                            <td><?= get_percentage($lesson4_promtional[3]+$lesson5_promtional[3]+$lesson6_promtional[3], $lesson4_parent_expired[3]+$lesson5_parent_expired[3]+$lesson6_parent_expired[3]); ?></td>
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