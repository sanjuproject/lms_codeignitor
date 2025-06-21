<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/html2canvas.min.js"></script>
<style>
    /* #photo { */
    /* padding: 4px; */
    /* height: 312px; */
    /* border:1px solid red; */
    /* } */

    #cross {
        text-align: center;
        width: 30px;
        height: 30px;
        margin: 0;
        padding: 0;
        border-collapse: collapse;
    }

    #buttons {
        width: 30%;
        float: right;
    }

    tr {
        margin: 0;
        padding: 0;
        border-collapse: collapse;
    }

    td {
        height: 50px;
        width: 50px;
        border: 1px solid black;
    }

    .topbox {
        display: flex;
        /* flex: 1; */
        flex-direction: row;
        /* border:1px solid red; */
    }

    #creat_puzzelParent,
    #puzzelParent {
        display: flex;
        flex: 1;
        justify-content: top;
        align-items: center;
        flex-direction: column;
        padding-bottom: 20px;
        /* border:1px solid red; */
    }

    #rightBox {
        float: left;
        clear: left;
    }

    .butt {
        height: 50px;
        width: 107px;
    }

    #puzzel {
        text-align: center;
        margin: 0;
        padding: 0;
        border-collapse: collapse;
        border: 1px solid black;
    }

    .inputBox {
        width: 50px;
        height: 50px;
        text-align: center;
    }

    input {
        border: none;
    }

    #hintsTable {
        width: 480px;
        float: left;
        clear: left;
    }

    .cell {
        position: relative;
    }

    .info_number {
        position: absolute;
        top: 0;
        left: 0;
        padding: 5px;
        color: red;
        font-weight: bold;
    }

    button {
        margin-top: 20px
    }

    .hints_form_container {
        margin-top: 30px;
    }

    .hints_indidual_container {
        display: flex;
        flex-direction: row;
    }

    .label-input {
        flex: 9;
    }

    .direction-input {
        flex: 1;
    }

    .save_container {
        display: flex;
        flex: 1;
        justify-content: center;
    }
    .button_container{
        display: flex;
        flex-direction: row;
    }

    #name_error, #quiz_error {
        color: red;
        margin-top: 3px;
    }
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/quiz_list">Quiz List</a></li>

                            <li class="breadcrumb-item active"><?= $quiz_details->challange_name; ?></li>
                        </ol>

                    </div>
                </div>

                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Crosswise Update</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <!-------------------------  -->

            <div id="success_container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Quiz Update Successfully
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div id="error_container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <!--  

             -->

            <!-- ------------------ -->

            <input type="hidden" name="challange_id" id="challange_id" value="<?= $quiz_details->ss_aw_challange_id; ?>">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="quiz_name_container">
                                <div class="direction-input mb-3 quiz_type_container">
                                    <label for="example-select">Quiz Type</label>
                                    <select class="form-control" name="quiz_type" id="quiz_type">
                                        <option value="">Select</option>
                                        <option value="crossword" <?= $quiz_details->challange_type == 'crossword' ? 'selected' : ''; ?>>Crossword</option>
                                    </select>
                                    <div id="quiz_error"></div>
                                </div>

                                <div class="label-input mb-3">
                                    <label for="emailaddress">Quiz Name</label>
                                    <input class="form-control" type="text" name="quiz_name" id="quiz_name" placeholder="Quiz Name" value="<?= $quiz_details->challange_name; ?>">
                                    <div id="name_error"></div>
                                </div>
                            </div>
                            <div id="quiz">
                                <div id="photo">

                                    <div class="topbox">


                                        <div id="creat_puzzelParent">
                                            <table id="creat_puzzel">

                                            </table>

                                            <button onClick="doAction()" class="btn btn-danger waves-effect waves-light mr-1">
                                                Create Puzzle
                                            </button>
                                        </div>
                                        <div id="puzzelParent">
                                            <table id="puzzel">

                                            </table>
                                            <!-- <div>
                                                <button onclick="takeshot()" class="btn btn-danger waves-effect waves-light mr-1">
                                                    Save Snapshot
                                                </button>
                                            </div> -->
                                        </div>
                                    </div>


                                </div>

                                <!-- <h1>Screenshot:</h1> -->
                                <div id="output"></div>

                            </div> <!-- end card body-->
                            <div class="hints_form_container" id="hints_form_container">
                                <?php
                                $item_details_json = $quiz_details->challange_answer;
                                $item_details = json_decode($item_details_json);

                                $hints_details_json = $quiz_details->challange_hints;
                                $hints_details = json_decode($hints_details_json);

                                $word_ary = array('1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'fifth', '6' => 'sixth');
                                $order_ary = array('1' => '1st', '2' => '2nd', '3' => '3rd', '4' => '4th', '5' => '5th', '6' => '6th');
                                $start = 1;
                                foreach ($hints_details as $key => $value) {
                                ?>
                                    <div class="hints_indidual_container">
                                        <div class="label-input mb-3">
                                            <label for="emailaddress"><?= $order_ary[$start] ?> Hints</label>
                                            <input class="form-control" type="text" name="<?= $word_ary[$start] ?>_hints" id="<?= $word_ary[$start] ?>_hints" placeholder="<?= $order_ary[$start] ?> Hints" value="<?= $value[0]; ?>">
                                        </div>
                                        <div class="direction-input mb-3">
                                            <label for="example-select">H/V</label>
                                            <select class="form-control" name="<?= $word_ary[$start] ?>_hints_direction" id="<?= $word_ary[$start] ?>_hints_direction">
                                                <option <?= $value[1] == 'H' ? 'selected' : ''; ?>>H</option>
                                                <option <?= $value[1] == 'V' ? 'selected' : ''; ?>>V</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php
                                    $start++;
                                }
                                ?>




                            </div>
                            <div class="save_container">
                                <div class="col-lg-3 button_container">
                                    <div class="text-lg-center">
                                        <button disabled type="button" id="add_button" onclick="add_quiz()" class="btn btn-danger waves-effect waves-light mr-1"><i class="mdi mdi-plus-circle mr-1"></i>Update Quiz</button>
                                    </div>
                                    <div class="text-lg-center">
                                        <button type="button" id="add_button" onclick="closeEdit()" class="btn btn-primary waves-effect waves-light mr-1"><i class="mdi mdi-close-box mr-1"></i>Close</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card disabled -->
                    </div><!-- end col-->
                    <div>

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
<?php
include('footer.php')
?>
<script type="text/javascript">
    $(document).ready(function() {
        document.getElementById("success_container").style.display = "none";
        document.getElementById("error_container").style.display = "none";
        initializeScreen();

    });
    // Define the function
    // to screenshot the div
    var img_base64 = '';

    function takeshot() {
        let div =
            document.getElementById('puzzel');
        html2canvas(div).then(
            function(canvas) {
                img_base64 = canvas.toDataURL('image/png');
            }
        )
    }
</script>
<script>
    //Globals
    var currentTextInput;
    var puzzelArrayData;
    //Loads the Crossword
    function initializeScreen() {
        //document.getElementById("puzzelParent").style.display = "block";
        var puzzelTable = document.getElementById("puzzel");
        puzzelArrayData = preparePuzzelArray();
        for (var i = 0; i < puzzelArrayData.length; i++) {
            var row = puzzelTable.insertRow(-1);
            var rowData = puzzelArrayData[i];
            for (var j = 0; j < rowData.length; j++) {
                var cell = row.insertCell(-1);
                cell.setAttribute("class", "cell");
                if (rowData[j] != 0) {
                    var txtID = String('txt' + '_' + i + '_' + j);
                    var spanID = String('span' + '_' + i + '_' + j);
                    cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" onfocus="textInputFocus(' + "'" + txtID + "'" + ')">';
                } else {
                    cell.style.backgroundColor = "black";
                }
            }
        }

        var createPuzzelTable = document.getElementById("creat_puzzel");
        createPuzzelArrayData = creatPuzzelArray();
        for (var i = 0; i < createPuzzelArrayData.length; i++) {
            var row = createPuzzelTable.insertRow(-1);
            var createRowData = createPuzzelArrayData[i];
            for (var j = 0; j < createRowData.length; j++) {
                var cell = row.insertCell(-1);
                cell.setAttribute("class", "cell");
                var txtID = String('c_txt' + '_' + i + '_' + j);
                var spanID = String('c_span' + '_' + i + '_' + j);
                if (createRowData[j] != 0) {
                    cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input type="text" class="inputBox" maxlength="3" style="text-transform: uppercase; font-weight:bold; font-size:16px" id="' + txtID + '" value="' + createRowData[j] + '" autocomplete="off">'
                } else {
                    cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input type="text" class="inputBox" maxlength="3" style="text-transform: uppercase; font-weight:bold; font-size:16px" id="' + txtID + '"  value="' + createRowData[j] + '" autocomplete="off">'
                }
            }
        }
        // addHint();
        doAction();
    }
    //Adds the hint numbers
    function addHint() {
        // document.getElementById("txt_1_0").placeholder = "1";
        document.getElementById("span_1_0").innerHTML = "1";
        document.getElementById("span_0_1").innerHTML = "2";
        document.getElementById("span_0_4").innerHTML = "3";
        document.getElementById("span_3_1").innerHTML = "4";
    }
    //Stores ID of the selected cell into currentTextInput
    function textInputFocus(txtID123) {
        currentTextInput = txtID123;
    }
    //Returns Array
    function preparePuzzelArray() {
        //console.log("@@",<?= $quiz_details->challange_answer ?>);
        var items = <?= $quiz_details->challange_answer ?>;
        //var items = "<?= json_encode($item_details[0]) ?>";
        return items;
    }

    function creatPuzzelArray() {
        var create_items = <?= $quiz_details->challange_answer ?>;
        return create_items;
    }

    //Clear All Button
    function clearAllClicked() {
        currentTextInput = '';
        var puzzelTable = document.getElementById("puzzel");
        puzzelTable.innerHTML = '';
        initializeScreen();
    }
    //Check button
    function checkClicked() {
        for (var i = 0; i < puzzelArrayData.length; i++) {
            var rowData = puzzelArrayData[i];
            for (var j = 0; j < rowData.length; j++) {
                if (rowData[j] != 0) {
                    var selectedInputTextElement = document.getElementById('txt' + '_' + i + '_' + j);
                    if (selectedInputTextElement.value != puzzelArrayData[i][j]) {
                        selectedInputTextElement.style.backgroundColor = 'red';

                    } else {
                        selectedInputTextElement.style.backgroundColor = 'white';
                    }
                }
            }
        }
    }
    //Clue Button
    function clueClicked() {
        if (currentTextInput != null) {
            var temp1 = currentTextInput;
            var token = temp1.split("_");
            var row = token[1];
            var column = token[2];
            document.getElementById(temp1).value = puzzelArrayData[row][column];
            //checkClicked();
        }
    }
    //Solve Button
    function solveClicked() {
        if (currentTextInput != null) {
            var temp1 = currentTextInput;
            var token = temp1.split("_");
            var row = token[1];
            var column = token[2];

            // Print elements on top
            for (j = row; j >= 0; j--) {
                if (puzzelArrayData[j][column] != 0) {
                    document.getElementById('txt' + '_' + j + '_' + column).value = puzzelArrayData[j][column];
                } else break;
            }
            // Print elements on right
            for (i = column; i < puzzelArrayData[row].length; i++) {
                if (puzzelArrayData[row][i] != 0) {
                    document.getElementById('txt' + '_' + row + '_' + i).value = puzzelArrayData[row][i];
                } else break;
            }

            // Print elements below
            for (m = row; m < puzzelArrayData.length; m++) {
                if (puzzelArrayData[m][column] != 0) {
                    document.getElementById('txt' + '_' + m + '_' + column).value = puzzelArrayData[m][column];
                } else break;
            }
            // Print elements on left
            for (k = column; k >= 0; k--) {
                if (puzzelArrayData[row][k] != 0) {
                    document.getElementById('txt' + '_' + row + '_' + k).value = puzzelArrayData[row][k];
                } else break;
            }
            // Done!

        }
    }
</script>

<script>
    var upload_quiz_name = '';
    var create_quiz = new Array();
    var hints_seperate_value = new Array();
    var answer_json_data = '';
    var answer_hints_json_data = '';


    function doAction() {
        const button_disable = document.getElementById("add_button");
        var elm = {};
        var elms = document.getElementById("creat_puzzel").getElementsByTagName("input");
        const createArray = [];

        //------------------- */
        for (var i = 0; i < elms.length; i++) {
            const vv = document.getElementById(elms[i].id);
            createArray.push(vv.value.toLowerCase())
        }

        // var create_quiz = new Array();
        for (var i = 0; i < 6; i++) {
            create_quiz[i] = new Array();
            for (var j = (i * 6); j < 6 * i + 6; j++)
                if (create_quiz[i] == null)
                    create_quiz[i] = createArray[j];
                else
                    create_quiz[i].push(createArray[j]);
        }
        // console.log("======create_quiz===", create_quiz)
        document.getElementById("puzzelParent").style.display = "flex";
        button_disable.disabled = false;
        updatePuzzelArray();
        updateInitializeScreen();

    }

    function updatePuzzelArray() {
        var items = create_quiz;
        answer_json_data = JSON.stringify(items);
        return items;
    }

    function updateInitializeScreen() {
        document.getElementById("puzzel").innerHTML = '';
        var puzzelTable = document.getElementById("puzzel");
        puzzelArrayData = updatePuzzelArray();

        for (var i = 0; i < puzzelArrayData.length; i++) {
            var row = puzzelTable.insertRow(-1);
            var rowData = puzzelArrayData[i];
            for (var j = 0; j < rowData.length; j++) {
                var cell = row.insertCell(-1);
                cell.setAttribute("class", "cell");
                if (rowData[j] != 0) {
                    var txtID = String('txt' + '_' + i + '_' + j);
                    var spanID = String('span' + '_' + i + '_' + j);
                    if (puzzelArrayData[i][j] != '' && puzzelArrayData[i][j].length == 3) {
                        // console.log("====",  span_value[m].split(",")[0])
                        const hint_number = puzzelArrayData[i][j].split(",")[0].trim();
                        // document.getElementById(span_elms[m].id).innerHTML = hint_number;
                        console.log(puzzelArrayData[i][j].length, hint_number)
                        cell.innerHTML = '<span class=info_number id="' + spanID + '">' + hint_number + '</span><input type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" onfocus="textInputFocus(' + "'" + txtID + "'" + ')">';
                    } else {
                        cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" onfocus="textInputFocus(' + "'" + txtID + "'" + ')">';
                    }
                } else {
                    cell.style.backgroundColor = "black";
                }
            }
        }
    }

    function add_quiz_backup() {
        // takeshot();
        const challange_id = document.getElementById("challange_id").value;
        const upload_quiz_name_id = document.getElementById("quiz_name");
        upload_quiz_name = upload_quiz_name_id.value;
        if (upload_quiz_name == '') {
            document.getElementById("quiz_name").focus();
            document.getElementById("name_error").innerHTML = "Quiz Name is require";
            return;
        } else {
            document.getElementById("name_error").innerHTML = "";
        }

        // get  hints value
        var elms_hints = document.getElementById("hints_form_container").getElementsByTagName("input");
        var elms_hints_select = document.getElementById("hints_form_container").getElementsByTagName("select");
        var hints_value = [];
        console.log(elms_hints);
        for (var h = 0; h < 6; h++) {
            const h_value = document.getElementById(elms_hints[h].id);
            const h_select_value = document.getElementById(elms_hints_select[h].id);
            hints_value.push(h_value.value);
            hints_value.push(h_select_value.value);
        }
        // console.log("____________", hints_value);

        for (var x = 0; x < 6; x++) {
            hints_seperate_value[x] = new Array();
            for (var y = (x * 2); y < 2 * x + 2; y++)
                if (hints_seperate_value[x] == null)
                    hints_seperate_value[x] = hints_value[y];
                else
                    hints_seperate_value[x].push(hints_value[y]);
        }
        answer_hints_json_data = JSON.stringify(hints_seperate_value);
        // console.log("_____1111_______", hints_seperate_value);
        //-------------------

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/update_quiz_answer",
            data: {
                upload_quiz_name: upload_quiz_name,
                challange_answer: answer_json_data,
                challange_answer_hints: answer_hints_json_data,
                image: img_base64,
                challange_id: challange_id
            },

            // dataType: "json",
            success: function(result) {
                console.log("@1", result);
                if (result != '') {
                    // window.location.reload()
                    document.getElementById("success_container").style.display = "block";
                    $('html, body').animate({
                        scrollTop: 0
                    }, 'slow');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                } else {
                    document.getElementById("error_container").style.display = "block";
                }
                // swal("Record updated successful");
                /*  $("#success_msg").show();
                 $('html, body').animate({
                     scrollTop: $(".page-title-left").offset().top
                 }, 500);
                 setTimeout(function () {
                     $('#success_msg').fadeOut('fast');
                 }, 5000); */
            }
        });
    }

    function add_quiz() {
        const challange_id = document.getElementById("challange_id").value;

        let img_base64 = '';

        const upload_quiz_type = document.getElementById("quiz_type");
        const quiz_type_detail = upload_quiz_type.value;

        if (quiz_type_detail == '') {
            document.getElementById("quiz_type").focus();
            document.getElementById("quiz_error").innerHTML = "Please Select Quiz Type";
            return;
        } else {
            document.getElementById("quiz_error").innerHTML = "";
        }

        const upload_quiz_name_id = document.getElementById("quiz_name");
        upload_quiz_name = upload_quiz_name_id.value;
        if (upload_quiz_name == '') {
            document.getElementById("quiz_name").focus();
            document.getElementById("name_error").innerHTML = "Quiz Name is require";
            return;
        } else {
            document.getElementById("name_error").innerHTML = "";
        }

        // get  hints value
        var elms_hints = document.getElementById("hints_form_container").getElementsByTagName("input");
        var elms_hints_select = document.getElementById("hints_form_container").getElementsByTagName("select");
        var hints_value = [];

        for (var h = 0; h < 6; h++) {
            const h_value = document.getElementById(elms_hints[h].id);
            const h_select_value = document.getElementById(elms_hints_select[h].id);
            hints_value.push(h_value.value);
            hints_value.push(h_select_value.value);
        }
        // console.log("____________", hints_value);

        for (var x = 0; x < 6; x++) {
            hints_seperate_value[x] = new Array();
            for (var y = (x * 2); y < 2 * x + 2; y++)
                if (hints_seperate_value[x] == null)
                    hints_seperate_value[x] = hints_value[y];
                else
                    hints_seperate_value[x].push(hints_value[y]);
        }
        answer_hints_json_data = JSON.stringify(hints_seperate_value);

        //-------------------
        let div = document.getElementById('puzzel');
        html2canvas(div).then(
            function(canvas) {
                img_base64 = canvas.toDataURL('image/png');

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>admin/update_quiz_answer",
                    data: {
                        quiz_type_detail: quiz_type_detail,
                        upload_quiz_name: upload_quiz_name,
                        challange_answer: answer_json_data,
                        challange_answer_hints: answer_hints_json_data,
                        image: img_base64,
                        challange_id: challange_id
                    },

                    // dataType: "json",
                    success: function(result) {
                        console.log("@1", result);
                        if (result != '') {
                            // window.location.reload()
                            document.getElementById("success_container").style.display = "block";
                            $('html, body').animate({
                                scrollTop: 0
                            }, 'slow');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        } else {
                            document.getElementById("error_container").style.display = "block";
                        }
                    }
                });
            }
        )
    }

    function closeEdit() {
            location.href = "<?= base_url(); ?>admin/quiz_list";
    }

</script>

</body>

</html>