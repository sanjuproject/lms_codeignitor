<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<script src="<?= base_url(); ?>/assets/js/fabric.min.js">
</script>

<style>
    .button_contaner,
    .canvas-container {
        display: flex;
        justify-content: center;
    }

    .hints_indidual_container {
        display: flex;
        flex-direction: row;
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
            <?php include "error_message.php"; ?>

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


                            <div class="button_contaner">
                                <?php
                                $text_character_length = strlen($quiz_list_data->challange_answer);
                                ?>
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
include 'footer.php'
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
        // fabric.Image.fromURL('<?= base_url(); ?>/<?= $quiz_list_data->challange_image; ?>', function(oImg) {
        fabric.Image.fromURL('<?php echo base_url(); ?>assets/quiz_challange_templete/img_6.jpg', function(oImg) {
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

        var Hints = new fabric.Textbox("Hints", {
            left: 410,
            top: 170,
            width: 300,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 22,
            fontWeight: 900,
            selectable: false,
        })

        var InputBox = new fabric.Textbox("<?php $str = ""; for ($x = 1; $x <= $text_character_length; $x++) { $str .= "___  "; } echo $str;  ?>", {
            left: 410,
            top: 415,
            width: 400,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 17,
            width: 310,
            fontWeight: 900,
            selectable: false,
            textAlign: 'center',
            lineHeight: 2
        })
        var question = new fabric.Textbox("<?= $quiz_list_data->challange_image; ?>", {
            left: 410,
            top: 250,
            width: 300,
            fontFamily: 'arial',
            fill: '#333',
            fontSize: 20,
            fontWeight: 900,
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
        canvas.add(Hints, InputBox, question, text_quiz_name, quiz_heading, quiz_footer);
    });

    function first_templete_name() {
        templete_name = document.getElementById("templete_name").value;
        return templete_name;
    }

    function changeTemplete() {
        // console.log(document.getElementById("templete_name").value)
        templete_name = document.getElementById("templete_name").value;
        // console.log("templete_name------", templete_name)
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
                document.getElementById("success_container").style.display = "block";
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');

            }
        });
    }

    function closeButton() {
        window.location.replace("<?= base_url(); ?>admin/quiz_list");
    }
</script>

</body>

</html>