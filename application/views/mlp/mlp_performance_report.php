 <!-- ============================================================== -->
 <!-- Start Page Content here -->
 <!-- ============================================================== -->

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

   .selectpicker {
     border: 1px solid #000;
     height: 50px;
     overflow-y: auto;
   }

   .card-body {
     min-height: 200px;
   }

   .adminusersbottomgapbetweenbtn {
     margin-top: 30px;
   }

   #generate_modal {
     margin-top: 124px;
   }

   .modal-body {
     text-align: center;
   }

   #report_link_button {
     border: 1px solid #000;
     border-radius: 5%;
     padding: 5px;
     background: #5256eb;
     color: #fff;
   }

   #loader {
     padding: 20px;
   }

   .report_link {
     padding: 10px;
     word-wrap: break-word;
   }

   #bs-select-1 {
     overflow-y: auto !important;
   }

   #error_message {
     background-color: #f1c4098f;
   }

   #error_message p {
     padding: 22px;
     color: #000;
   }

   .link_text {
     border: 1px solid #000;
     background: #ddd;
     padding: 10px;
   }
 </style>
 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <!-- Latest compiled and minified JavaScript -->


 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

 <div class="content-page">
   <div class="content">

     <!-- Start Content-->
     <div class="container-fluid">

       <!-- start page title -->
       <div class="row">
         <div class="col-md-12">
           <div class="page-title-left">
             <ol class="breadcrumb m-0">
               <!-- <li class="breadcrumb-item">Settings</li> -->
               <!-- <li class="breadcrumb-item active">General Settings</li> -->
             </ol>
           </div>
         </div>
       </div>
       <?php include(APPPATH . "views/admin/error_message.php"); ?>
       <div class="row">

         <div class="col-md-6">
           <h4 class="page-title">Masters Lite Perfomence</h4>
         </div>

         <div class="col-md-6">


         </div>



       </div>
       <!-- end page title -->


       <form class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
         <div class="row">
           <div class="col-12">
             <div class="card">
               <div class="card-body">
                 <div class="row mb-2">
                   <div class="col-sm-4">
                     <div class="form-group">
                       <label for="">Masters Lite Users</label>
                       <select class="form-control selectpicker border rounded" data-live-search="true" id="mlp_user" name="mlp_user">
                         <option value="">Select</option>
                         <?php
                          if (!empty($mlp_user)) {
                            foreach ($mlp_user as $mlpUser) { ?>
                             <option value="<?= $mlpUser->ss_aw_child_id ?>"><?= $mlpUser->name ?></option>
                         <?php  }
                          } ?>

                       </select>
                     </div>
                   </div>
                   <div class="col-sm-4">
                     <button type="button" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn" id="adminusersbottomgapbetweenbtn">Generate Download Link</button>
                   </div>
                 </div>

               </div>
             </div>
           </div>
         </div>
         <div class="row">
           <div class="col-md-6">

             <div class="text-left">

               <!-- <button type="button" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button> -->
             </div>
           </div>


         </div>

       </form>
     </div> <!-- container -->

   </div> <!-- content -->

   <?php
    include(APPPATH . 'views/admin/includes/bottombar.php');
    ?>

 </div>

 <!-- ============================================================== -->
 <!-- End Page content -->
 <!-- ============================================================== -->

 </div>
 <!-- END wrapper -->



 <?php
  include(APPPATH . 'views/admin/footer.php')
  ?>
 <!-- The Modal -->
 <div class="modal" id="generate_modal">
   <div class="modal-dialog">
     <div class="modal-content">

       <!-- Modal Header -->
       <div class="modal-header">
         <h4 class="modal-title">Genrate Download Link</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>

       <!-- Modal body -->
       <div class="modal-body">
         <div id="loader">
           <div class="text-center">
             <div class="spinner-border" role="status">
               <span class="sr-only">Loading...</span>
             </div>
           </div>
           <span>Generating Link Please Wait...</span>
         </div>
         <div id="report_generated">
           <div class="my-2 link_text">
             <a class="report_link" href="" download></a>
           </div>
           <div class="my-2">
             <a class="success" id="report_link_button" href="" download>Download Report</a>
           </div>
         </div>

         <div id="error_message">

           <p>
             <span><i class="fa fa-warning" style="font-size:38px;color:red"></i></span><br /><span style="font-size:18px;"> select an user first.</span>
           </p>
         </div>
       </div>

       <!-- Modal footer -->
       <div class="modal-footer">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
       </div>

     </div>
   </div>
 </div>
 </body>

 </html>

 <script>
   $(function() {
     $('.selectpicker').selectpicker();
     $("#report_generated").css("display", "none");
   });
 </script>
 <script>
   $("#adminusersbottomgapbetweenbtn").click(function() { 
     $("#generate_modal").modal("show");
     let mlp_user = $("#mlp_user").val();
     if (mlp_user != "") {
       $("#error_message").css("display", "none");
       if ($("#loader").css("display") == "none") {
         $(".modal-title").html("Generate Download Link");
         $("#loader").css("display", "block");
         $("#report_generated").css("display", "none");
       }
       $.ajax({
         url: "<?php echo base_url()  ?>testingapi/get_mlp_pdf_report",
         type: "post",
         data: $("#modal-demo-form").serialize(),
         success: function(response) {
           $("#loader").css("display", "none");
           $("#report_generated").css("display", "block");
           let url = JSON.parse(response);
           let downloadLink = "<?= base_url() ?>" + url;
           $(".report_link").prop("href", downloadLink);
           $("#report_link_button").prop("href", downloadLink);
           $(".report_link").html(downloadLink);
           $(".modal-title").html("Download Link Generated");
         },
         error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
         }
       });
     } else {

       $(".modal-title").html("Generate Download Link");
       $("#loader").css("display", "none");
       $("#report_generated").css("display", "none");
       $("#error_message").css("display", "block");
     }

   });
 </script>