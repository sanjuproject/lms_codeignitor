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
                                    <h4 class="page-title">Days Deliquent</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    
                                                    <div class="col-md-3">
                                                        <label>Assign Level</label>
                                                        <select name="level" id="level" class="form-control">                                                           
                                                            <option value="1" <?php if(!empty($days_deliquent_data['level'])){ if($days_deliquent_data['level'] == '1'){ ?> selected <?php } } ?>>Winners</option>
                                                            <option value="3" <?php if(!empty($days_deliquent_data['level'])){ if($days_deliquent_data['level'] == '3'){ ?> selected <?php } } ?>>Champions</option>
                                                            <option value="5" <?php if(!empty($days_deliquent_data['level'])){ if($days_deliquent_data['level'] == '5'){ ?> selected <?php } } ?>>Masters</option>
                                                        </select>    
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group report-goBtn" style="text-align: left; margin-top: 28px;">
                                                            <input type="submit" name="submit" value="Go" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                               
                                        <div class="table-responsive gridview-wrapper">
                                            
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>For delinquent students</th>
                                                            <th style="text-align: center;" colspan="3">Days Delinquent</th>                                                           
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Lesson / Assessment</th>
                                                            <th>1-7</th>
                                                            <th>8-14</th>
                                                            <th>15+</th>                                                            
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        if (!empty($lesson_list)) {
                                                            $count = 0;
                                                            $grand_total = 0;
                                                            for ($i=0; $i < count($lesson_list); $i++) { 
                                                                $count++;
                                                                ?>
                                                                <tr>
                                                                    <td><?= $count; ?></td>
                                                                    <td><?= $complete_data['first'][$lesson_list[$i]['lesson_id']]; ?></td>
                                                                    <td><?= $complete_data['second'][$lesson_list[$i]['lesson_id']]; ?></td>
                                                                    <td><?= $complete_data['third'][$lesson_list[$i]['lesson_id']]; ?></td>
                                                                    <!--<td><?= $complete_data['last'][$lesson_list[$i]['lesson_id']]; ?></td>-->
                                                                    <?php
                                                                    $total = $complete_data['first'][$lesson_list[$i]['lesson_id']] + $complete_data['second'][$lesson_list[$i]['lesson_id']] + $complete_data['third'][$lesson_list[$i]['lesson_id']] + $complete_data['last'][$lesson_list[$i]['lesson_id']];
                                                                    $grand_total = $grand_total + $total;
                                                                    ?>
                                                                    <td><?= $total; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>Total</td>
                                                                <td><?= array_sum($complete_data['first']); ?></td>
                                                                <td><?= array_sum($complete_data['second']); ?></td>
                                                                <td><?= array_sum($complete_data['third']); ?></td>
                                                                <!--<td><?= array_sum($complete_data['last']); ?></td>-->
                                                                <td><?= $grand_total; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
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