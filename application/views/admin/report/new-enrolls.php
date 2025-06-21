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
                                    <h4 class="page-title">New Enrollee Tracking</h4>
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
                                                        <th>#Enrolls</th>
                                                        <th>PTD</th>
                                                        <th>YTD</th>
                                                        <?php
                                                        if (!empty($monthly_data)) {
                                                            foreach ($monthly_data as $key => $value) {
                                                                ?>
                                                                <th><?= $key; ?></th>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <tr>
                                                        <td>Online</td>
                                                        <td>
                                                            <?php
                                                            if (count($ptd_num_details) > 0) {
                                                                if (!empty($ptd_num_details[0]->online)) {
                                                                    echo $ptd_num_details[0]->online;
                                                                }
                                                                else
                                                                {
                                                                    echo "0";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (count($ytd_num_details) > 0) {
                                                                if (!empty($ytd_num_details[0]->online)) {
                                                                    echo $ytd_num_details[0]->online;
                                                                }
                                                                else
                                                                {
                                                                    echo "0";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php
                                                            if (!empty($monthly_data)) {
                                                                foreach ($monthly_data as $key => $value) {
                                                                    if (!empty($value[0]->online)) {
                                                                        ?>
                                                                        <td><?= $value[0]->online; ?></td>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <td>0</td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td>Email Solitation</td>
                                                        <td>
                                                            <?php
                                                            if (count($ptd_num_details) > 0) {
                                                                if (!empty($ptd_num_details[0]->email_solitation)) {
                                                                    echo $ptd_num_details[0]->email_solitation;
                                                                }
                                                                else
                                                                {
                                                                    echo "0";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (count($ytd_num_details) > 0) {
                                                                if (!empty($ytd_num_details[0]->email_solitation)) {
                                                                    echo $ytd_num_details[0]->email_solitation;
                                                                }
                                                                else
                                                                {
                                                                    echo "0";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php
                                                            if (!empty($monthly_data)) {
                                                                foreach ($monthly_data as $key => $value) {
                                                                    if (!empty($value[0]->email_solitation)) {
                                                                        ?>
                                                                        <td><?= $value[0]->email_solitation; ?></td>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <td>0</td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>In person offer</td>
                                                        <td>
                                                            <?php
                                                            if (count($ptd_num_details) > 0) {
                                                                if (!empty($ptd_num_details[0]->offer)) {
                                                                    echo $ptd_num_details[0]->offer;
                                                                }
                                                                else
                                                                {
                                                                    echo "0";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (count($ytd_num_details) > 0) {
                                                                if (!empty($ytd_num_details[0]->offer)) {
                                                                    echo $ytd_num_details[0]->offer;
                                                                }
                                                                else
                                                                {
                                                                    echo "0";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php
                                                            if (!empty($monthly_data)) {
                                                                foreach ($monthly_data as $key => $value) {
                                                                    if (!empty($value[0]->offer)) {
                                                                        ?>
                                                                        <td><?= $value[0]->offer; ?></td>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <td>0</td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </tr> -->
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