<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <div class="page-header-inner">        
        <div class="page-logo">
            <a href="<?php echo site_url('admin/home'); ?>">
                <img src="<?php echo base_url(); ?>img/logo-admin.png" alt="logo" class="logo-default"/>
            </a>
            <div class="menu-toggler sidebar-toggler hide"></div>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <?php
                        if ($this->session->userdata('avatar') <> '') {
                            $image = "icon/".$this->session->userdata('avatar');
                        } else {
                            $image = "img/avatar.png";
                        }                        
                        ?>
                        <img alt="" class="img-circle" src="<?php echo base_url().$image; ?>"/>
                        <span class="username username-hide-on-mobile"><?php echo $this->session->userdata('nama'); ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">                       
                        <li>
                            <a href="<?php echo site_url('login/logout'); ?>">
                                <i class="icon-key"></i> Log Out 
                            </a>
                        </li>
                    </ul>
                </li>                
            </ul>
        </div>      
    </div>   
</div>