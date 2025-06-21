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
                                    <li class="breadcrumb-item">Notification Templates CMS</li>
                                    <li class="breadcrumb-item active">Image Gallery</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Image Gallery</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="header-title">Dropzone File Upload</h4> -->
                                    <!-- <p class="sub-header">
                                        DropzoneJS is an open source library that provides drag’n’drop file uploads with
                                        image previews.
                                    </p> -->
                                    <div class="row">
                                        <div class="col-4">

                                                    <button type="button" id="refresh"
                                                        class="btn btn-danger waves-effect waves-light">Refresh</button>
                                                       
                                                
                                            
                                           <!--  <form action="<?php echo base_url(); ?>admin/imagegallery" method="post" enctype="multipart/form-data"> -->
                                            <form action="<?php echo base_url(); ?>admin/imagegallery_upload" class="dropzone" id="imageDropzone"data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate" method="post" enctype="multipart/form-data">
                                                
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple />
                                                </div>                                

                                                <div class="dz-message needsclick">
                                                    <i class="h1 text-muted dripicons-cloud-upload"></i>
                                                    <h3>Drop files here or click to upload.</h3>

                                                </div>
                                                <input type="hidden" name="upload_images" value="upload_images">
                                                
                                            
                                            <div class="col-md-1 pl-0 mt-3">
                                                   <!--  <button type="button" id="btnUpload"
                                                        class="btn btn-danger waves-effect waves-light">Upload</button> -->
                                                       
                                                </div>
                                                </form>
                                        </div>
                                        <div class="col-8">
                                            <!-- Preview -->
                                            <div class="dropzone-previews" id="file-previews"></div>
                                        </div>
                                    </div>




                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div><!-- end col -->
                    </div>
                    <!-- file preview template -->
                    <div class="d-none" id="uploadPreviewTemplate">
                        <div class="card mt-1 mb-0 shadow-none border">
                            <div class="p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                    </div>
                                    <div class="col pl-0">
                                        <a href="javascript:void(0);" class="text-muted font-weight-bold"
                                            data-dz-name></a>
                                        <p class="mb-0" data-dz-size></p>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Button -->
                                        <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                            <i class="dripicons-cross"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row gallery-previews">

                                       <?php
                                        foreach ($result as $value) {
                                             
                                        ?>

                                        <div class="card ">
                                            <img class="card-img-top img-fluid" src="<?php echo base_url() ?>uploads/image_galary/<?php echo $value->ss_aw_image; ?>"
                                                alt="" />

                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $value->ss_aw_image_name; ?></h5>

                                                <p>posted on: <?php echo date("d M, Y", strtotime($value->ss_aw_create_date)); ?> @ <?php echo date("h:ia", strtotime($value->ss_aw_create_date)); ?></p>
                                                <span class="badge badge-soft float-left mr-2"><?php echo $value->ss_aw_image_resolution; ?></span>
                                                
                                                <a href="#" onclick="return copy_url('<?php echo $value->ss_aw_image; ?>')" class="badge badge-soft-success float-left">Copy
                                                    URL</a>
                                                <a href="#" class="badge badge-soft-danger float-right"
                                                    data-toggle="modal" data-target="#warning-delete-modal" onclick="return delete_pic('<?php echo $value->ss_aw_image_id; ?>','<?php echo $value->ss_aw_image; ?>')">Remove</a>
                                            </div>
                                        </div>
                                        <?php
                                           } 
                                        ?>

                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div><!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="text-right">
                                <ul class="pagination pagination-rounded justify-content-end">
                                     <!-- Show pagination links -->
                                    <?php foreach ($links as $link) {
                                    echo "<li>". $link."</li>";
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Delete confirmation dialog -->
            <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">Deleting will remove this image permanently from the system. Are you
                                    sure ?</p>
                                <div class="button-list">
									<?php 
									if($this->uri->segment(3))
									{
										$pageno = $this->uri->segment(3);
									}
									else
									{
										$pageno = 0;
									}
									?>
                                    <form action="<?php echo base_url() ?>admin/imagegallery/<?php echo $pageno;?>" method="post" id="formsubmit">
                                    <input type="hidden" name="delete_pic_id" id="delete_pic_id">
									<input type="hidden" name="delete_image" id="delete_image">
                                    <input type="hidden" name="delete_pic_process" value="delete_pic_process">
                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
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
    .text-muted {
        
        display: none;
    }
    </style>

    <?php
            include('footer.php')
        ?>
    <!-- Table Editable plugin-->
    <script src="<?php echo base_url();?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
   
    <script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
   
    <!-- Validation init js-->
    
    

   


    
    <script type="text/javascript">
        function delete_pic(pic_id,picture)
    {   
        $("#delete_pic_id").val(pic_id);
		$("#delete_image").val(picture);
       
    }
    function copy_url(image)
    {
        
        var url = "<?php echo base_url().'uploads/image_galary/' ?>"+image;
        var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value = url;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);

            }
    </script>
    <script type="text/javascript">
        $("#refresh").click(function(){
			$("#delete_pic_id").val("");
			$("#delete_image").val("");
            $("#formsubmit").submit();
        });
    </script>
      
  

</body>

</html>