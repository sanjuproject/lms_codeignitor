<?php if(!empty($ss_aw_admin_user_crop_pic)){
		$profile_pic = base_url()."assets/images/users/".$ss_aw_admin_user_crop_pic;
}else{
       $profile_pic = base_url()."assets/images/users/profile.jpg";
}

?>
<input type="hidden" class="upload imgInp" id="upload_img" name="old_cropped_image" />
<div class="edit-photo text-center">
 <div class="croppedImageContainer">
  <img src="<?php echo $profile_pic;?>" alt="" id="drag-image1"/>
</div>

<div id="cropped_preview" class="rounded-circle img-thumbnail"></div>

<p id="myBtn">Upload Image
  <button id="btn_upload_image" type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus"></i></button>
</p>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="image-container">
	
      <img class='blah' src="<?php echo $profile_pic;?>" alt='Profile Image' width='100%' height='auto' id="drag-image" />
    </div>
    Slide To Zoom
    <div class="form-inline text-center pro-file-padding">
      <div class="fileUpload">
        <input type="file" class="upload imgInp" id="upload_img" name="profile_pic" />
        <span class="btn btn-primar text-color upload_photo">Upload Photo</span>
      </div>
      <span class="btn btn-success text-color" id="get_url_btn">Save</span><span class="btn btn-danger close_btn text-color cancel_button">Cancel</span>
    </div>
  </div>
</div>
<input type="hidden" name="croppedimagesrc" id="croppedimagesrc" class="form-control">
</div>