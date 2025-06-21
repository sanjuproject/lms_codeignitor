<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    
</style>
<div class="content-page">
    <div class="content">
                        <?php
                            $page_title = "";
                            if ($type == 1) {
                                $page_title = "PTD readalong completed users of ".$readalong_title;
                            }
                            elseif ($type == 2) {
                                $page_title = "YTD readalong completed users of ".$readalong_title;
                            }
                            else{
                                $page_title = "MTD readalong completed users of ".$readalong_title;
                            }
                        ?>
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title"><?= $page_title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url() ?>report/track_readalong_completed_users/<?= $this->uri->segment(3); ?>" method="post" id="filter-form">
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="text" name="search_data" class="form-control" placeholder="Search..." aria-label="Recipient's username" 
                                                    <?php  
                                                    if (isset($search_data)) {    echo 'value="' . $search_data . '"';
                                                    } 
                                                    ?>>
                                                    
                                                    <div class="input-group-append" style="position:relative;">
                                                        <?php
                                                        if (!empty($search_data)) {
                                                        ?>
                                                            <div style="position: absolute; right: 20; left: -25px; padding: 8px; cursor: pointer;">
                                                                <i class="fas fa-times" style="cursor: pointer;" onclick="resetsearch();"></i>
                                                            </div>

                                                        <?php
                                                        }
                                                        ?>
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (!empty($result)) {
                                ?>
                                <div class="table-responsive gridview-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>SL No.</th>
                                                <th>Username</th>
                                                <th>Institution name / Parent name</th>
                                                <th>Selected to Start Date</th>
                                                <th>Complete Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($result as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $key + 1; ?></td>
                                                    <td><?= $value->ss_aw_child_nick_name; ?></td>
                                                    <td><?= !empty($value->institution_name) ? $value->institution_name : $value->parent_name; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($value->ss_aw_start_date)); ?></td>
                                                    <td><?= date('d/m/Y', strtotime($value->complete_date)); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>    
                                <?php
                            }
                            else{
                                ?>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h4 class="text-danger">Sorry! no data found</h4>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>


        </div> <!-- container -->

    </div> <!-- content -->
    <?php
    include('bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->
<?php
include('footer.php')
?>
<script type="text/javascript">
    function resetsearch() {
        $("input[name='search_data']").val('');
        $("#filter-form").submit();
    }
</script>
</body>
</html>