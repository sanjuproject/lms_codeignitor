<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<script src="<?= base_url(); ?>/assets/js/fabric.min.js">
</script>

<style>
    #photo {
        padding: 4px;
        /* height: 285px; */
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
        flex: 1;
        flex-direction: row;
    }

    #puzzelParent {
        display: flex;
        flex: 1;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding-bottom: 20px;
    }

    #hintsParent {
        display: flex;
        flex: 1;
        justify-content: left;
        padding-bottom: 20px;
        flex-direction: column;
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

    .label-input {
        flex: 9;
    }

    .button_contaner,
    .canvas-container {
        display: flex;
        justify-content: center;
    }

    .hints_indidual_container {
        display: flex;
        flex-direction: row;
    }

    /* .hints_form_container {
        margin-top: 30px;
    } */

    .copy_link {
        width: '100%';
        text-align: center;
        margin: 20px 0 0 0;
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
                        <h4 class="page-title parsley-examples">Quiz View : <?= $quiz_list_data->challange_name; ?></h4>
                    </div>
                </div>
            </div>

            <!-- end page title -->
            <?php include("error_message.php"); ?>

            <!-------------------------  -->

            <div id="success_container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Facebook Image Upload Successfully
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

            <div style="display: none" id="success_msg" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Copied to clipboard successfully. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- ------------------ -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <?php
                                    print_r($quiz_templete_data);
                                    ?> -->
                            <div class="hints_indidual_container">
                                <div class="direction-input mb-3">
                                    <label for="example-select">Templete</label>
                                    <select class="form-control" name="templete_name" id="templete_name" onchange="changeTemplete(this.value)">
                                        <!-- <option>Select Templete</option> -->
                                        <?php
                                        foreach ($quiz_templete_data as $row_details) {
                                            echo '<option value="' . $row_details->challange_template_name . '">' . $row_details->challange_template_name . '</option>';
                                        }
                                        ?>


                                    </select>
                                </div>
                            </div>

                            <div class="canvas-container">
                                <canvas id="quiz_canvas"></canvas>
                            </div>

                            <!-- <div class="copy_link">
                                <p>To view the answer visit the following link</p>
                            </div> -->

                            <!-- <div class="hints_form_container">
                                <div class="hints_indidual_container">
                                    <div class="label-input mb-4">
                                        <p></p>
                                    </div>
                                    <div class="label-input mb-3">
                                        <input class="form-control" id="answer_link" readonly type="text" name="answer_link" value="www.alsowise.com/puzzles/crosswords/<?= $quiz_list_data->ss_aw_challange_id; ?>">
                                    </div>
                                    <div class="direction-input mb-3">
                                        <a onclick="answerLink()" href="javascript:void(0);" class="form-control">
                                            <i class="mdi mdi-arrange-send-backward" title="Copy Code"></i>
                                        </a>
                                    </div>
                                    <div class="label-input mb-4">
                                    </div>
                                </div>
                            </div> -->

                            <div class="button_contaner">
                                <button onClick="publishToFacebook()" class="btn btn-danger waves-effect waves-light mr-1">
                                    Publish to Facebook
                                </button>
                                <button onClick="downloadImage()" class="btn btn-danger waves-effect waves-light mr-1">
                                    Download Puzzle Image
                                </button>
                                <button onClick="closeButton()" class="btn btn-danger waves-effect waves-light mr-1">
                                    Close
                                </button>
                                <!-- <button onClick="answerButton()" class="btn btn-danger waves-effect waves-light mr-1">
                                    View Answer
                                </button> -->
                            </div>
                            <?php

                            $answer_details = $quiz_list_data->challange_answer;
                            $item_details = json_decode($answer_details);

                            $hints_details_json = $quiz_list_data->challange_hints;
                            $hints_details = json_decode($hints_details_json);
                            /* echo "<pre>";
                            print_r($hints_details);
                            die(); */
                            $vertical_options = array();
                            $horizontal_options = array();
                            if (!empty($hints_details)) {
                                foreach ($hints_details as $key => $value) {
                                    if ($value[1] == 'V') {
                                        $vertical_options[] = $value[0];
                                    } elseif ($value[1] == 'H') {
                                        $horizontal_options[] = $value[0];
                                    }
                                }
                            }
                            ?>
                            <div id="quiz">
                                <!-- <div id="photo">
                                    <table id="creat_puzzel">

                                    </table>
                                    <div class="topbox">
                                        <div id="puzzelParent">
                                            <table id="puzzel">
                                            </table>
                                        </div>
                                        <div id="hintsParent">
                                            <div id="hints">
                                                Hints
                                            </div>
                                            <div id="hints_down">
                                                Down <br />
                                                <?php
                                                if (!empty($vertical_options)) {
                                                    foreach ($vertical_options as $value) {
                                                ?>
                                                        <li><?= $value; ?></li>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div id="hints_accross">
                                                Accross <br />
                                                <?php
                                                if (!empty($horizontal_options)) {
                                                    foreach ($horizontal_options as $value) {
                                                ?>
                                                        <li><?= $value; ?></li>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>


                                </div> -->
                                <!-- <h1>Screenshot:</h1> -->
                                <div id="output"></div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->

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
    var canvas;
    $(document).ready(function() {
        // updateInitializeScreen();
        document.getElementById("success_container").style.display = "none";
        document.getElementById("error_container").style.display = "none";
        canvas = new fabric.Canvas('quiz_canvas');
        canvas.setHeight(750);
        canvas.setWidth(750);
        first_templete_name();
        canvas.setBackgroundImage('<?= base_url(); ?>assets/quiz_challange_templete/' + templete_name + '.jpeg', canvas.renderAll.bind(canvas), {
            // Needed to position backgroundImage at 0/0
            originX: 'left',
            originY: 'top',
            scaleX: .7,
            scaleY: .7
        });

        // fabric.Image.fromURL('<?= base_url(); ?>/assets/quiz_challange/633563fb614b41664443387.jpeg', function(oImg) {
        fabric.Image.fromURL('<?= base_url(); ?>/<?= $quiz_list_data->challange_image; ?>', function(oImg) {
            oImg.set({
                left: 25,
                top: 170,
                // width: 400,
                // height:400,
                // scaleX: 1.15,
                // scaleY: 1.15,
                selectable: false,
            });
            oImg.scaleToHeight(370);
            oImg.scaleToWidth(370);
            canvas.add(oImg);
            // console.log(JSON.stringify(canvas))
        });

        var quiz_heading = new fabric.Textbox("Can you solve this puzzle?", {
            left: 25,
            top: 40,
            width: 600,
            fontFamily: 'Pacifico',
            fill: '#333',
            fontSize: 35,
            fill: '#023047',
            // fontWeight: 900,
            selectable: false,
        })

        var text_quiz_name = new fabric.Textbox("<?= $quiz_list_data->challange_name; ?>", {
            left: 25,
            top: 110,
            width: 600,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 22,
            fontWeight: 900,
            selectable: false,
        })

        var text1 = new fabric.Textbox("Hints", {
            left: 410,
            top: 170,
            width: 300,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 22,
            fontWeight: 900,
            selectable: false,
        })
        var text2 = new fabric.Textbox("Down", {
            left: 410,
            top: 390,
            width: 300,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 20,
            fontWeight: 900,
            selectable: false,
        })

        var text3 = new fabric.Textbox("<?= $vertical_options[0]; ?>\n<?= $vertical_options[1]; ?>\n<?= $vertical_options[2]; ?>\n<?= $vertical_options[3]; ?>", {
            left: 410,
            top: 415,
            width: 400,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 17,
            width: 310,
            // fontWeight: 900,
            selectable: false,
        })
        var text4 = new fabric.Textbox("Across", {
            left: 410,
            top: 200,
            width: 300,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 20,
            fontWeight: 900,
            selectable: false,
        })
        var text5 = new fabric.Textbox("<?= $horizontal_options[0]; ?>\n<?= $horizontal_options[1]; ?>\n<?= $horizontal_options[2]; ?>\n<?= $horizontal_options[3]; ?>", {
            left: 410,
            top: 225,
            width: 400,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 17,
            width: 340,
            // fontWeight: 900,
            selectable: false,
        })
        var quiz_footer = new fabric.Textbox("Visit www.alsowise.com/fun to test your skill.", {
            left: 25,
            top: 640,
            width: 600,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 22,
            fontWeight: 600,
            selectable: false,

        })
        canvas.add(text1, text2, text3, text4, text5, text_quiz_name, quiz_heading, quiz_footer);
    });

    function first_templete_name() {
        templete_name = document.getElementById("templete_name").value;
        return templete_name;
    }

    function changeTemplete() {
        // console.log(document.getElementById("templete_name").value)
        templete_name = document.getElementById("templete_name").value;
        console.log("templete_name------", templete_name)
        canvas.setBackgroundImage('<?= base_url(); ?>assets/quiz_challange_templete/' + templete_name + '.jpeg', canvas.renderAll.bind(canvas), {
            // Needed to position backgroundImage at 0/0
            originX: 'left',
            originY: 'top',
            scaleX: .7,
            scaleY: .7
        });
        // return templete_name;
    }

    function base_sixtyfour_image() {
        if (canvas) {
            this.href = canvas.toDataURL({
                format: 'jpeg',
                quality: 1,
            });
            return this.href;
        }
    }


    function downloadImage(e) {
        const linkSource = base_sixtyfour_image();
        // console.log(linkSource)
        const downloadLink = document.createElement("a");
        downloadLink.href = linkSource;
        downloadLink.download = '<?= $quiz_list_data->challange_name; ?>' + '.png';
        downloadLink.click();
    }


    function publishToFacebook() {
        console.log("Publish to Facebook")
        const image_source = base_sixtyfour_image();
        console.log("================", image_source)
        const quiz_challange_id = '<?= $quiz_list_data->ss_aw_challange_id; ?>'
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/quiz_facebook_image_Upload",
            data: {
                quiz_challange_id: quiz_challange_id,
                image: image_source,
            },

            // dataType: "json",
            success: function(result) {
                console.log("@1", result);
                /*if (result != '') {

                    document.getElementById("success_container").style.display = "block";
                    $('html, body').animate({
                        scrollTop: 0
                    }, 'slow');

                } else {
                    document.getElementById("error_container").style.display = "block";
                }*/
                document.getElementById("success_container").style.display = "block";
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');

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

    function closeButton() {
        window.location.replace("<?= base_url(); ?>admin/quiz_list");
    }

    function answerButton() {
        window.location.replace("<?= base_url(); ?>admin/quiz_answer_id_wise/<?= $quiz_list_data->ss_aw_challange_id; ?>");
    }

    function answerLink() {
        /* Get the text field */
        var copyText = document.getElementById("answer_link");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');

        $("#success_msg").show();
        setTimeout(function() {
            $('#success_msg').fadeOut('fast');
        }, 5000);
    }

    function updatePuzzelArray() {
        var items = <?= json_encode([$item_details][0]); ?>;
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
                        cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input disabled type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" onfocus="textInputFocus(' + "'" + txtID + "'" + ')">';
                    }
                } else {
                    cell.style.backgroundColor = "black";
                }
            }
        }
    }
</script>

</body>

</html>