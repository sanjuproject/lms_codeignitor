<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
        table {
            font-size: 1rem;
            white-space: nowrap;
            margin: 0;
            border: none;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            border: 1px solid #555;
        }

        table td,
        table th {
            border: 1px solid #555;

        }

        table thead th {

            position: sticky;
            top: 0;
            z-index: 1;
            width: 25vw;
            background: white;
            font-size: 14px;
            padding: 0 5px;
        }

        table td {
            background: #fff;
            font-size: 14px;
            text-align: center;
        }

        table tbody th {
            font-weight: 100;
            text-align: left;
            position: relative;
        }

        table thead th:first-child {
            position: sticky;
            left: 0px;
            z-index: 2;
        }


        table tbody th {
            position: sticky;
            left: 0;
            background: white;
            z-index: 1;
        }

        caption {
            text-align: left;
            padding: 0.25rem;
            position: sticky;
            left: 0;
        }

        [role="region"][aria-labelledby][tabindex] {
            width: 100%;
            max-height: 300px;
            overflow: auto;
        }

        [role="region"][aria-labelledby][tabindex]:focus {
            box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
            outline: 0;
        }

        table.no-border,
        table.no-border td,
        table.no-border th {
            border-width: 0;
            padding: 0;
        }

        .no-left-margin {
            margin-left: 0 !important;
        }

        .row-metrics {
            padding: 0;
            margin: 0;
            list-style-type: none;
            font-size: 12px;
            text-align: left;
            margin-left: 10px;

        }

        .row-metrics li {
            padding: 3px;
            text-align: center;
        }

        .left-border {
            border-left: 1px solid #555;
        }

        .row-metrics li:nth-child(2n) {
            background-color: #fdfad3;
        }
        .row-metrics li:nth-child(2n + 1) {
            background-color: #fff;
        }

        .row-metrics li:not(:last-child) {
            border-bottom: 1px solid #555;
        }

        .slno {
            width: 30px;
           
        }
        div.student-name-wrapper {display: flex;align-items: center;}
        div.student-name-wrapper .slno {display: block;padding:0 5px; }
        .student-name {display: block;width: 150px;word-wrap: break-word;white-space: break-spaces;}
        .freeze-col-name-wrapper {
            display: flex;
            align-items: center;
            justify-content: stretch;
        }
        tr:nth-child(2n) .freeze-col-name-wrapper {
            background-color: #fdfad3;
        }
       .gridview-wrapper{
        overflow-y: auto;
        height: calc(100vh - 360px);
       }
       .no-data{
        background-color: #ccc !important;
       }
    </style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">Report Dashboard</li>
                            <li class="breadcrumb-item">Individual Performance</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Individual Performance</h4>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-end">
                                <form method="post" id="demo-form" action="<?= base_url('institution/individual_performance'); ?>">
                                    <div class="difficulty_report_form">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group d-flex justify-content-end align-items-center pt-3">
                                                    <label class="m-0 mr-2">Programme&nbsp;Type</label>
                                                    <select name="programme_type" id="programme_type" class="form-control mt-0">
                                                        <option value="1" <?php if(!empty($searchdata['programme_type'])){ if($searchdata['programme_type'] == 1){ ?> selected <?php } } ?>>Winners</option>
                                                        <!-- <option value="3" <?php if(!empty($searchdata['programme_type'])){ if($searchdata['programme_type'] == 3){ ?> selected <?php } } ?>>Champions</option> -->
                                                        <option value="5" <?php if(!empty($searchdata['programme_type'])){ if($searchdata['programme_type'] == 5){ ?> selected <?php } } ?>>Masters</option>
                                                    </select>
                                                    <div class="form-group report-goBtn ml-2 m-0" style="margin-top: 25px;">
                                                <input type="submit" name="submit" value="Go" class="btn btn-primary form-control">
                                            </div>
                                                </div>  
                                                                       
                                            </div>


                                            
                                        </div> 
                                    </div>
                                </form>
                                <?php
                                if (!empty($childs)) {
                                ?>
                                    <div class="btn-container pt-3 pl-2">
                                        <a href="<?= base_url(); ?>export/generateXls_institutionreportdashboard/<?= $institution_id; ?>/<?= @$searchdata['programme_type'] ?>" class="btn btn-success align-middle"><i class="mdi mdi-file-excel"></i>Export</a>
                                    </div>
                                <?php } ?>
                            </div>
                            
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (!empty($childs)) {
                                ?>
                                <div class="table-responsive gridview-wrapper">
                                    <table style="border-bottom:none">
                                        <thead>
                                            <tr>

                                                <th>
                                                    <table class="no-border">
                                                        <tr>
                                                            <td class="slno">#</td>
                                                            <td>User Name</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th>Diagnostic Quiz</th>
                                                <?php
                                                $topic_count = 1;
                                                if (!empty($topics)) {
                                                    foreach ($topics as $key => $value) {
                                                        $topic_count++;
                                                        ?>
                                                        <th><?= $value['ss_aw_lesson_topic']; ?></th>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $child_no = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
                                                foreach ($childs as $key => $value) {
                                                    $child_no++;
                                                    $child_id = $value->ss_aw_child_id;
                                                    ?>
                                                    <tr>
                                                        <th>
                                                            <div class="freeze-col-name-wrapper">
                                                                <div class="student-name-wrapper">
                                                                    <span class="slno"><?= $child_no; ?></span>
                                                                    <span class="student-name"><?= $value->ss_aw_child_first_name." ".$value->ss_aw_child_last_name; ?></span>
                                                                </div>
                                                                <ul class="row-metrics left-border">
                                                                    <li>Diagnostic Quiz</li>
                                                                    <li>Lesson</li>
                                                                    <li>Assessment</li>
                                                                    <li>ReadAlong</li>
                                                                </ul>
                                                            </div>
                                                        </th>
                                                        <td>
                                                            <ul class="row-metrics no-left-margin">
                                                                <li>
                                                                    <?php
                                                                    if ($diagnosticcorrectnum[$value->ss_aw_child_id] != 'NA') {
                                                                        ?>
                                                                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?= $diagnosticcompletedate[$child_id]; ?>"><?= $diagnosticcorrectnum[$value->ss_aw_child_id]; ?></a>
                                                                        <?php
                                                                    }
                                                                    else{
                                                                        echo "&nbsp;";
                                                                    }
                                                                    ?>
                                                                    </li>
                                                                <li class="no-data">&nbsp;</li>
                                                                <li class="no-data">&nbsp;</li>
                                                                <li class="no-data">&nbsp;</li>
                                                            </ul>
                                                        </td>
                                                        <?php
                                                        if (!empty($topics)) {
                                                            foreach ($topics as $key => $topic) {
                                                                ?>
                                                                <td>
                                                                    <ul class="row-metrics no-left-margin">
                                                                        <li>&nbsp;</li>
                                                                        <li>
                                                                            <?php
                                                                            if ($lessonscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA') {
                                                                                ?>
                                                                                <a href="javascript:void(0)" data-toggle="tooltip" title="<?= $lessoncompletedate[$child_id][$topic['ss_aw_lession_id']]; ?>"><?= $lessonscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']]; ?></a>
                                                                                <?php
                                                                            }
                                                                            else{
                                                                                echo "&nbsp;";
                                                                            }
                                                                            ?>
                                                                            
                                                                        </li>
                                                                        <li>
                                                                            <?php
                                                                            if ($assessmentscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA') {
                                                                                ?>
                                                                                <a href="javascript:void(0)" data-toggle="tooltip" title="<?= $assessmentcompletedate[$child_id][$topic['ss_aw_lession_id']]; ?>"><?= $assessmentscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']]; ?></a>
                                                                                <?php
                                                                            }
                                                                            else{
                                                                                echo "&nbsp;";
                                                                            }
                                                                            ?>
                                                                        </li>
                                                                        <li>
                                                                            <?php
                                                                            if ($readalongscore[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA') {
                                                                                ?>
                                                                                <a href="javascript:void(0)" data-toggle="tooltip" title="<?= $readalongcompletedate[$child_id][$topic['ss_aw_lession_id']]; ?>"><?= $readalongscore[$value->ss_aw_child_id][$topic['ss_aw_lession_id']]; ?></a>
                                                                                <?php
                                                                            }
                                                                            else{
                                                                              echo "&nbsp;";  
                                                                            }
                                                                            ?>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
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
                            
                            <div class="text-right mt-3">
                                <ul class="pagination pagination-rounded justify-content-end">
                                    <?php foreach ($links as $link) {
                                        echo "<li>". $link."</li>";
                                    } ?>
                                </ul>
                            </div>
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
</body>
</html>