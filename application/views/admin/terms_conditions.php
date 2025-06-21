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
                                    <h4 class="page-title">Terms & Conditions</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <form action="<?php echo base_url(); ?>admin/terms_conditions" method="post" id="terms_conditions_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div id="snow-editor" style="height: 300px;">
                                            <?php echo $page_data_content[0]['page_data']; ?>
                                           

                                        </div> <!-- end Snow-editor-->
                                        <div class="text-right mt-2">
                                
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Update</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" >Cancel</button>
                            </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div><!-- end col -->
                        </div>
                        <textarea name="page_data" style="display:none" id="hiddenArea"></textarea>
                        
                        </form>                      
                      
                      
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
                include('footer.php');
                include('editor.php');
            ?>
    <script type="text/javascript">
  $( document ).ready(function() {
   $("#terms_conditions_form").on("submit",function(){
$("#hiddenArea").val($("#snow-editor").html());
})
});
    </script>        
      

        

       