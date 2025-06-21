

<!-- jQuery js -->
<script src="<?php echo base_url();?>assets/libs/jquery/jquery.min.js"></script>


<!-- Vendor js -->
<script src="<?php echo base_url();?>assets/js/vendor.min.js"></script>

<!-- Plugins js-->
<script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/selectize/js/standalone/selectize.min.js"></script>

<!-- Dashboar 1 init js-->
<!-- <script src="./assets/js/pages/dashboard-1.init.js"></script> -->


 <!-- third party js -->
 <script src="<?php echo base_url();?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
 <script src="<?php echo base_url();?>assets/libs/pdfmake/build/vfs_fonts.js"></script>

 
<!-- Plugin js-->
<script src="<?php echo base_url();?>assets/libs/parsleyjs/parsley.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/autonumeric/autoNumeric-min.js"></script>
<!-- Tippy js-->
<script src="<?php echo base_url();?>assets/libs/tippy.js/tippy.all.min.js"></script>
<!-- Validation init js-->
<!-- <script src="./assets/js/pages/form-validation.init.js"></script> -->

<!-- Datatables init -->
<script src="<?php echo base_url();?>assets/js/pages/datatables.init.js"></script>
<script src="<?php echo base_url();?>assets/js/pages/form-masks.init.js"></script>

<!-- Plugins js -->
<script src="<?php echo base_url();?>assets/libs/dropzone/min/dropzone.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/dropify/js/dropify.min.js"></script>

    <!-- Init js-->
    <script src="<?php echo base_url();?>assets/js/pages/form-fileuploads.init.js"></script>
    <!-- App js-->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>



<script src="<?php echo base_url();?>scripts/common.js"></script>


<!-- crop js-->
<script src="<?php echo base_url();?>scripts/croppie.js"></script>

<!-- Validation init js-->
 <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>


<!-- Tost-->
<script src="<?php echo base_url();?>assets/libs/jquery-toast-plugin/jquery.toast.min.js"></script>
<!-- toastr init js-->
<!-- <script src="./assets/js/pages/toastr.init.js"></script> -->

<!-- Init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-fileuploads.init.js"></script>
<!-- App js-->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>



<!--<script src="<?php echo base_url();?>scripts/common.js"></script>-->

 <script>
     var container = document.getElementsByClassName("container")[0];
container.onkeyup = function(e) {
    var target = e.srcElement || e.target;
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;
    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null)
                break;
            if (next.tagName.toLowerCase() === "input") {
                next.focus();
                break;
            }
        }
    }
    // Move to previous field if empty (user pressed backspace)
    else if (myLength === 0) {
        var previous = target;
        while (previous = previous.previousElementSibling) {
            if (previous == null)
                break;
            if (previous.tagName.toLowerCase() === "input") {
                previous.focus();
                break;
            }
        }
    }
}

var containersecond = document.getElementsByClassName("container-modal-second")[0];
containersecond.onkeyup = function(e) {
    var target = e.srcElement || e.target;
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;
    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null)
                break;
            if (next.tagName.toLowerCase() === "input") {
                next.focus();
                break;
            }
        }
    }
    // Move to previous field if empty (user pressed backspace)
    else if (myLength === 0) {
        var previous = target;
        while (previous = previous.previousElementSibling) {
            if (previous == null)
                break;
            if (previous.tagName.toLowerCase() === "input") {
                previous.focus();
                break;
            }
        }
    }
}
     </script>


<!-- Validation init js-->
 <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>
 
 
         <script src="<?php echo base_url();?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
        <script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
        <!--<script src="<?php echo base_url();?>assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>-->
        <script src="<?php echo base_url();?>assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>

        <script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

        <!-- Init js-->
        <script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>

        <!-- Validation init js-->
        <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>
<script>
$(".button-menu-mobile").click(function(){
	
	var curtype = $('body').attr('data-sidebar-size');
	if(curtype == 'default')
	{
		$('body').attr('data-sidebar-size',"condensed");
	}
	else if(curtype == "condensed")
	{
		$('body').attr('data-sidebar-size',"default");
	}
});
</script>