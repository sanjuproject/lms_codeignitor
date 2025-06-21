<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

<div class="h-100" data-simplebar>


    <div id="sidebar-menu">

        <ul id="side-menu">
	
		<?php foreach($menuary as $key=>$val){
			
			?>
            <li>
			<?php if(count($val) == 1){?>
                <a href="<?php echo base_url().$val[0]['link'];?>">
                    <i class="mdi <?php echo $val[0]['menu_icon']?>"></i>
                    <span><?php echo $val[0]['page'];?></span>
                </a>
			<?php }else if(count($val) > 1){
				?>	
				<a href="#sidebarCrm_<?php echo $key;?>" data-toggle="collapse">
                    <i class="mdi <?php echo $val[0]['menu_icon']?>"></i>
                    <span><?php echo $val[0]['page'];?>&nbsp;</span>
                    <span class="menu-arrow"></span>
                </a>
				
				<div class="collapse" id="sidebarCrm_<?php echo $key;?>">
                    <ul class="nav-second-level">
                    <?php foreach($val as $key2=>$val2){ 
						if($key2 > 0){
					?>					
						<li>
                            <a href="<?php echo base_url().$val2['link'];?>"><?php echo $val2['page'];?></a>
                        </li>
                    <?php }} ?>    
                    </ul>
                </div>
			<?php } ?>	
            </li>
		<?php } ?>
       
      
        </ul>

    </div>

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->