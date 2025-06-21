<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8" />
    <!-- <title>Dashboard | team</title> -->
    <title>Audio Generation | team</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->


 

</head>

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">





        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page m-0">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->


                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Audio Generation</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <!-- end page title -->


                    <form action="" class="parsley-examples" method="post" id="modal-demo-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row mb-2">
                                            <div class="col-sm-4">





                                                <div class="form-group">
                                                    <label for="txtQuizIdleTime">Text</label>
                                                    <input class="form-control" name="audiotext" type="text" id="" placeholder="Text"
                                                        required>


                                                </div>
                                                <div class="form-group">
                                                    <label for="txtQuizIdleTime">Voice</label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="voice" required>
                                                            <option value="0" select>Please select</option>
                                                            <option value="Mark">Mark</option>
                                                            <option value="Alice">Alice</option>
                                                            <option value="Sophie">Sophie</option>
                                                        </select>
                                                    </div>


                                                </div>
                                                <div class="form-group">
                                                    <label for="txtQuizIdleTime">Speed</label>
                                                    <input class="form-control" type="text" name="speed" id="" placeholder="Speed"
                                                        required>


                                                </div>
                                                <div class="form-group">
                                                    <label for="txtQuizIdleTime">Pitch</label>
                                                    <input class="form-control" type="text" name="pitch" id="" placeholder="Pitch"
                                                        required>


                                                </div>



                                            </div>
                                            <div class="col-sm-4" style="padding-top:32px;">
                                            

                                            </div>
                                            
                                        </div>


                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="text-left">
                                    <button type="submit"
                                        class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Generate
                                        Audio</button>
                                    <button type="reset"
                                        class="btn btn-danger waves-effect waves-light m-l-10">Reset</button>
                                </div>
                            </div>


                        </div>
                    </form>



                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                © <?php echo date("Y") ?> team. All rights reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

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
</body>
</html>

<?php

	
if($_POST)
{

	$title_str = $_POST['audiotext'];
	$voice = $_POST['voice'];
	$speed = $_POST['speed'];
	$pitch = $_POST['pitch'];
$text_to_read = urlencode($title_str);

							// Your API Key here
							$apikey = 'b9c0587eb1a3fddfc2eedb63be5c3919';
						
						if($voice == 'Alice')
						{
							// The language to use
							$language = 'en_uk';
						}else
						{
							$language = 'en_us';
						}
						
							// API URL of text-to-speech enabler
							$api_url = 'https://tts.readspeaker.com/a/speak';

							// Compose API call url
							$url = $api_url . '?key='.$apikey.'&lang='.$language.'&voice='.$voice.'&speed='.$speed.'&pitch='.$pitch.'&text='.$text_to_read;
							
							$audio_file = "voice_".$voice."_speed_".$speed."_pitch_".$pitch."_".time().".mp3";
							$ch = curl_init($url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_HEADER, true);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
							$audio_data = curl_exec($ch);	
									$final_output = $audio_data;
									file_put_contents($audio_file, $final_output);
								echo "<a href=$audio_file download>$audio_file</a>";			
}
?>									