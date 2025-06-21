

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
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="couponmanagement.php"> Coupon Management </a></li>
                                    <li class="breadcrumb-item"><a href="targetaudiencegroups.php">LIst of Audience Groups</a></li>
                                    <li class="breadcrumb-item active">Create Audience Group</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="page-title">Create Audience Group</h4>
                        </div>



                    </div>
                    <!-- end page title -->

                    <div class="row mt-2">

                        <div class="col-lg-3"></div>

                        <div class="col-lg-6">

                            <div class="card-box">


                                <form action="#" id="demo-form" class="parsley-examples">

                                    <div class="form-group">
                                        <label for="title">Audience Group Title<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="title" placeholder="Group Title" required>

                                        <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <div class="radio radio-primary mb-1">
                                                <input type="radio" name="member" id="Existing" value="1" required="" checked="checked">
                                                <label for="Existing">
                                                    Existing Members
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">

                                            <div class="radio radio-primary">
                                                <input type="radio" name="member" id="Potential" value="2">
                                                <label for="Potential">
                                                    Potential Customers
                                                </label>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="existingmembers" id="member1">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Age<span class="text-danger">*</span></label>
                                                <select id="" class="form-control" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">8 - 10 Yrs</option>
                                                    <option value="2">10 - 12 Yrs</option>
                                                    <option value="2">12 - 14 Yrs</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>School<span class="text-danger">*</span></label>
                                                <select id="" class="form-control" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">Delhi Public</option>
                                                    <option value="2">Kolkata Public</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                         

                                        </div>

                                        <!-- <div class="form-row">
                                            

                                           <div class="form-group col-md-6">
                                                <label>School Type<span class="text-danger">*</span></label>
                                                <select id="" class="form-control" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">Public</option>
                                                    <option value="2">Private</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Price Point<span class="text-danger">*</span></label>
                                                <select id="" class="form-control" required="">
                                                    <option value="">Select</option>
                                                    <option value="1">500 - 1000</option>
                                                    <option value="2">1000 - 2000</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                        </div> -->

                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>Programme Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" data-toggle="flatpicker" placeholder="Start Date">
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Programme End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" data-toggle="flatpicker" placeholder="End Date">
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                            <label for="city1">City<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control select2-multiple" id="city1" data-toggle="select2" multiple="multiple" data-placeholder="City">
                                                    <option value="HI">Kolkata</option>
                                                        <option value="HI">Chennai</option>

                                                    </select>
                                                </div>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                            <div class="form-group col-md-6">
                                            <label for="state1">State<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control select2-multiple" id="state1" data-toggle="select2" multiple="multiple" data-placeholder="State">
                                                        <option value="HI">West Bengal</option>
                                                        <option value="HI">Tamilnadu</option>

                                                    </select>
                                                </div>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                            </div>

                                    </div>


                                    <div class="existingmembers" id="member2" style="display: none;">

                                    <div class="form-group">
                                            <label>Member List<span class="text-danger">*</span></label>

                                            <div class="row member-checkbox-section">
                                                <div class="col-md-6 pl-0">
                                                <div class="checkbox checkbox-pink mb-1 ml-3 mr-4">
                                                <input type="checkbox" name="Member[]" id="hobby1"
                                                                value="ski" data-parsley-mincheck="2">
                                                <label for="hobby1"> Contacts Title 1 (12) </label>
                                            </div>
                                                </div>
                                          
                                                        <div class="col-md-6 pl-0">
                                                           <div class="checkbox checkbox-pink mb-1 ml-3 mr-4">
                                                                                                        <input type="checkbox" name="Member[]" id="hobby2"
                                                                                                                        value="run">
                                                                                                        <label for="hobby2"> Contacts Title 2 (22) </label>
                                                                                                    </div>
                                                        </div>
                                         

                                           
                                            

                                            </div>

                                           
                                        </div>

                                    <div class="form-row">

                                            <div class="form-group col-md-6">
                                            <label for="city">City<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control select2-multiple" id="city" data-toggle="select2" multiple="multiple" data-placeholder="City">
                                                        <option value="HI">Kolkata</option>
                                                        <option value="HI">Chennai</option>

                                                    </select>
                                                </div>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                            <div class="form-group col-md-6">
                                            <label for="state">State<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control select2-multiple" id="state" data-toggle="select2" multiple="multiple" data-placeholder="State">
                                                        <option value="HI">West Bengal</option>
                                                        <option value="HI">Tamilnadu</option>

                                                    </select>
                                                </div>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>

                                            </div>





                             
                            
                            
                           </div>


                           <div class="form-row">

<div class="form-group col-md-6 mb-0">

    <label for="level">Level<span class="text-danger">*</span></label>
    <select id="" class="form-control" required="">
        <option value="">Select</option>
        <option value="HI">E Level</option>
            <option value="HI">C Level</option>
            <option value="HI">A Level</option>

    </select>
    <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
</div>

<div class="form-group col-md-6 mb-0">
    <label>Limit First<span class="text-danger">*</span></label>
    <select id="" class="form-control" required="">
        <option value="">Select</option>
        <option value="1">100 Members</option>
        <option value="2">200 Members</option>

    </select>
    <p class="cmr-0">( Info : Select 0 for all members )</p>
    <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
</div>

</div>

<div class="form-row">

<div class="form-group col-md-12">
    <label for="title">Note<span class="text-danger">*</span></label>
    <input class="form-control" type="text" id="title" placeholder="Note Option" required>

    <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
</div>

</div>

<div class="form-row">

<div class="mb-3">
<div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                            id="customSwitch2">
                        <label class="custom-control-label" for="customSwitch2">Inactive</label>
                        
                    </div>
</div>
</div>

<div class="form-row">

<div class="col-sm-4">
    <button class="btn btn-success btn-block waves-effect waves-light" data-toggle="modal" data-target="#modal-preview" type="submit">Preview </button>
</div>
<div class="col-sm-4">
    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Create</button>
</div>
<div class="col-sm-4">
    <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Remove</button>
</div>
</div>

    
                            </from>




                        </div>
                    </div> <!-- end col -->

                    <div class="col-lg-3"></div>

                </div>



                   <!-- Modal -->
                   <div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title">Preview - Audience Group Audience</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>Members information from selected lists</p>
                                  
                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                            data-show-columns="true">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th># SL No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Dolor 1</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Dolor 2</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Dolor 3</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Dolor 4</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Dolor 5</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Dolor 6</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Dolor 7</td>
                                                    <td>dol@gmail.com</td>
                                                    <td>9831098310</td>
                                                    <td>Kolkata</td>
                                                    <td>West Bengal</td>

                                                </tr>


                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

            </div> <!-- container -->

        </div> <!-- content -->

        <?php
include 'includes/bottombar.php';
?>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <style type="text/css">
        .card-box {
            box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
        }

    </style>

    <?php
include 'footer.php'
?>
    <script src="./assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="./assets/libs/select2/js/select2.min.js"></script>
    <script src="./assets/libs/flatpickr/flatpickr.min.js"></script>



    <!-- Validation init js-->
    <script src="./assets/js/pages/form-validation.init.js"></script>
    <script src="./assets/js/pages/form-advanced.init.js"></script>
    <!-- Init js-->
    <script src="./assets/js/pages/create-project.init.js"></script>


    <script>

$(document).ready(function() {
    $("#Existing").click(function() {
        var test = $(this).val();

        $("#member2").hide();
        $("#member1").show();
    });
    $("#Potential").click(function() {
        var test = $(this).val();

        $("#member1").hide();
        $("#member2").show();
    });

    $("#customSwitch2").click(function(){
    $(".custom-switch label").text(($(".custom-switch label").text() == 'Inactive') ? 'Active' : 'Inactive').fadeIn();
  });
});
    </script>

</body>

</html>
