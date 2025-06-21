<!DOCTYPE html>
<html lang="en">

<head>

    <?php
$title = "Assessments";
include('includes/header.php')
?>
    <!-- <link href="./assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="./assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" /> -->


    <link href="./assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="./assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" /> -->

</head>

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        <?php
include('includes/topbar.php')
?>

        <?php
include('includes/leftsidebar.php')
?>

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
                                    <li class="breadcrumb-item">Assessments</li>
                                    <li class="breadcrumb-item active">List of Assessment</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Assessments</h4>
                        </div>

                        <div class="col-md-6">



                            <div class="footerformView float-right mb-2">
                                <form>
                                    <select class="form-control adminusersbottomdropdown" id="drpMultipleCta">
                                        <option value="0" select>Please Select</option>
                                        <option value="1">Import New Assessment/Diagnostic Quiz</option>
                                        <option value="2">Delete all</option>
                                    </select>

                                </form>
                            </div>


                        </div>



                    </div>
                    <!-- end page title -->



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row mb-2">
                                        <div class="col-sm-4">

                                            <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#modal1-add-assessment"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Import New Assessment</a>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="#" id="demo-form">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Topic / Section name">
                                                                    <div class="input-group-append">
                                                                        <button
                                                                            class="btn btn-primary waves-effect waves-light"
                                                                            type="button">Go</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                                    <select
                                                                        class="form-control adminusersbottomdropdown"
                                                                        id="drpStatus">
                                                                        <option value="0" select>Status</option>
                                                                        <option value="1">Active</option>
                                                                        <option value="2">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Clear</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                            data-show-columns="true">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck1">
                                                            <label class="custom-control-label"
                                                                for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th># SL No.</th>
                                                    <th>Topic / Section Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck2">
                                                            <label class="custom-control-label"
                                                                for="customCheck2"></label>
                                                        </div>
                                                    </td>
                                                    <td>1</td>

                                                    <td><a class="link" href="assessmentsparticulartopic.php" >Topic Name 1</a></td>


                                                    <td>
                                                        <a href="#" class="badge badge-soft-success"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal">Active</a>
                                                    </td>
                                                    <td>

                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete"> <i class="mdi mdi-delete"></i></a>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck3">
                                                            <label class="custom-control-label"
                                                                for="customCheck3">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>2</td>

                                                    <td><a class="link" href="assessmentsparticulartopic.php">Topic Name 2</a></td>


                                                    <td>
                                                        <a href="#" class="badge badge-soft-danger"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal">In
                                                            Active</a>
                                                    </td>
                                                    <td>

                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete"> <i class="mdi mdi-delete"></i></a>
                                                    </td>

                                                </tr>


                                            </tbody>
                                        </table>

                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">


                        </div>

                        <div class="col-md-6">
                            <div class="text-right">
                                <ul class="pagination pagination-rounded justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                    <!--Status update confirmation dialog -->
                    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Are you sure you want to update the status?</p>
                                        <div class="button-list">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Yes</button>
                                            <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                    <!-- Delete confirmation dialog -->
                    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Deleting will remove this topic from the system. Are you
                                            sure ?
                                        </p>
                                        <div class="button-list">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Yes</button>
                                            <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="modal1-add-assessment" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">New Assessment/Diagnostic Quiz Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="#" id="demo-form" class="parsley-examples" id="modal-demo-form">
                                        <div class="form-row">
                                            <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Subject<span class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">English</option>
                                                    <option value="2">Option 2</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Topic<span
                                                        class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">Nouns</option>
                                                    <option value="2">Adverbs</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Format<span class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">Single</option>
                                                    <option value="2">Option 2</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">Level E</option>
                                                    <option value="2">Level C</option>
                                                    <option value="3">Level A</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Template<span
                                                        class="text-danger">*</span></label><br/>
                                                <button type="button"
                                                    class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload Again 
                                                    <input type="file">
                                                </button><span id="" class="lblFileName">MyTemplate.xlsx</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"><li>This error would appear on validation error of template upload</li></ul>
                                                <h6>Note : Only Excel file format allowed. <a href="#">Sample Template</a> file found here.</h6>
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Add Lesson
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


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
            include('includes/footer.php')
        ?>
    <!-- Table Editable plugin-->
    <script src="./assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
    <script src="./assets/libs/select2/js/select2.min.js"></script>
    <script src="./assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="./assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <!-- Validation init js-->
    <script src="./assets/js/pages/form-validation.init.js"></script>
    <script src="./assets/js/pages/form-advanced.init.js"></script>

    <script>
    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus').prop('selectedIndex', 0);
        });

        jQuery('#customCheck1').click(function() {
            let $this = jQuery(this);
            let thisCheckedState = jQuery(this).is(':checked');
            let listOfCheckboxes = $this.closest('table').find('tbody tr td:first-child :checkbox');

            if (thisCheckedState) {
                listOfCheckboxes.each(function() {
                    jQuery(this).prop('checked', true);
                });
            } else {
                listOfCheckboxes.each(function() {
                    jQuery(this).prop('checked', false);
                });
            }

        });
        jQuery('tbody tr td:first-child :checkbox').click(function() {
            let $this = jQuery(this);
            let thisCheckedState = $this.is(':checked');
            let targetCheckbox = $this.closest('table').find('tr th:first-child :checked');
            if (!thisCheckedState) {
                targetCheckbox.prop('checked', false);
            }
        });

    });
    </script>

</body>

</html>