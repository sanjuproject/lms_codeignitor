<?php if($this->session->flashdata('error')){?>	
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>  
	<?php }else if($this->session->flashdata('success')){ ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div> 
	<?php }

if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}	
	?>