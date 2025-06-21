<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="<?= base_url(); ?>assets/combined_performance_files/css2" rel="stylesheet">

<style>
    .chart-wrapper {}

    .legend {
        position: absolute;
        top: 160px;
        margin: 0;
        padding: 0;
        list-style-type: none;
        right: 0;
        left: 0;
        width: 100%;
        display: flex;
        font-size: 12px;
        align-items: center;
        justify-content: center;
    }

    .legend li {
        margin: 0 10px;
    }

    .legend li::before {
        display: inline-block;
        width: 30px;
        height: 10px;
        content: "";
        margin-right: 6px;
    }

    .legend li:nth-child(1):before {
        background-color: #cc0000;
    }

    .legend li:nth-child(2):before {
        background-color: #000033;
    }

    .legend li:nth-child(3):before {
        background-color: #f8981f;
    }

    .legend li:nth-child(4):before {
        background-color: #00b300;
    }
</style>

<script src="<?= base_url(); ?>assets/combined_performance_files/chart.js.download"></script>
<script src="<?= base_url(); ?>assets/combined_performance_files/chartjs-plugin-datalabels@2"></script>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Combined Performance</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="demo-form" action="<?= base_url('institution/combined_performance'); ?>">
                                <div class="difficulty_report_form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Programme Type</label>

                                                <select name="programme_type" id="programme_type" class="form-control">
                                                    <?php
                                                    if (!empty($courses_drop)) {
                                                        foreach ($courses_drop as $cour) {
                                                    ?>
                                                            <option value="<?= $cour->ss_aw_course_id ?>" <?php if (!empty($searchdata['combined_programme_type'])) {
                                                                                                                if ($searchdata['combined_programme_type'] == $cour->ss_aw_course_id) { ?> selected <?php }
                                                                                                                                                                                            } ?>><?= $cour->ss_aw_course_nickname ?></option>

                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>

                                        </div>


                                        <div class="form-group report-goBtn" style="margin-top: 25px;">
                                            <input type="submit" name="submit" value="Go" class="btn btn-primary form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <h3>Score distribution for Lessons and Assessment Quizzes</h3>
                            <div class="chart-wrapper">
                                <ul class="legend">
                                    <li>25% or less</li>
                                    <li>&gt;25% - 50%</li>
                                    <li>&gt;50% - 75%</li>
                                    <li>&gt;75% - 100%</li>
                                </ul>
                                <canvas id="myChart2" width="1877" height="938" style="display: block; box-sizing: border-box; height: 751px; width: 1502px;"></canvas>
                            </div>

                            <hr>
                            <h3>Average Scores for Lessons and Assessment Quizzes</h3>
                            <div class="chart-wrapper">
                                <canvas id="myChart3" width="1877" height="938" style="display: block; box-sizing: border-box; height: 751px; width: 1502px;"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('bottombar.php');
    ?>
</div>
<?php
include('footer.php')
?>

<script>
    Chart.register(ChartDataLabels);
    const ctx2 = document.getElementById('myChart2');
    const chartData2 = {
        //labels: ['Nouns', 'Adjectives', 'Articles'],
        labels: <?= $topics; ?>,
        datasets: [{
                label: "25% or less",
                type: "bar",
                stack: "Lesson",
                backgroundColor: "#cc0000",
                data: <?= $lesson0to25; ?>,
            }, {
                label: ">25% - 50%",
                type: "bar",
                stack: "Lesson",
                backgroundColor: "#000033",
                data: <?= $lesson25to50; ?>,
            }, {
                label: ">50% - 75%",
                type: "bar",
                stack: "Lesson",
                backgroundColor: "#f8981f",
                data: <?= $lesson50to75; ?>,
            }, {
                label: ">75% - 100%",
                type: "bar",
                stack: "Lesson",
                backgroundColor: "#00b300",
                backgroundColorHover: "#3e95cd",
                data: <?= $lesson75to100 ?>
            },
            {
                label: "25% or less",
                type: "bar",
                stack: "Assessment",
                backgroundColor: "#cc0000",
                data: <?= $assessment0to25; ?>,
            }, {
                label: ">25% - 50%",
                type: "bar",
                stack: "Assessment",
                backgroundColor: "#000033",
                data: <?= $assessment25to50; ?>,
            }, {
                label: ">50% - 75%",
                type: "bar",
                stack: "Assessment",
                backgroundColor: "#f8981f",
                data: <?= $assessment50to75; ?>,
            }, {
                label: ">75% - 100%",
                type: "bar",
                stack: "Assessment",
                backgroundColor: "#00b300",
                backgroundColorHover: "#3e95cd",
                data: <?= $assessment75to100; ?>
            }
        ]
    };
    new Chart(ctx2, {
        type: 'bar',
        data: chartData2,
        options: {
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    //color: '#000000',
                    //anchor: 'end',

                    font: {
                        size: 0,
                        //weight: 'bold'
                    }
                }
            },
            responsive: true,
            interaction: {
                intersect: false,
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        },

    });
</script>
<script>
    let customData = <?= $total_lesson_assessment_user_num; ?>; //total number of students
    const ctx3 = document.getElementById('myChart3').getContext("2d");
    const chartData3 = {
        labels: <?= $topics; ?>,
        datasets: [{
                label: 'Lesson',
                data: <?= $lesson_avg_score; ?>,
                borderColor: 'red',
                backgroundColor: 'red',
            },
            {
                label: 'Assessment',
                data: <?= $assessment_avg_score; ?>,
                borderColor: 'blue',
                backgroundColor: 'blue',
            }
        ]
    };
    new Chart(ctx3, {
        type: 'bar',
        data: chartData3,
        options: {
            responsive: true,
            plugins: {
                tooltip: {

                    callbacks: {

                        label: function(tooltipItem, data) {
                            // console.log(tooltipItem);
                            // console.log(tooltipItem.dataIndex, + ' '+tooltipItem.datasetIndex);
                            // var currentIndex = tooltipItem.index;
                            return 'Total User  ' + customData[tooltipItem.dataIndex][tooltipItem.datasetIndex];
                        }
                    }
                },
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    offset: -20,
                    color: '#000000',
                    align: 'start',
                    anchor: 'end',

                    font: {
                        size: 12,
                        weight: 'bold'
                    },
                    formatter: function(value, context) {
                        if (value != 0) {
                            return Math.round(value) + '%';
                        } else {
                            return '';
                        }
                    },
                }
            },

        }
    });
</script>


</body>

</html>