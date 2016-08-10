<div class="page-header">
    <div class="page-header-top">
        <div class="container">            
            <div class="page-logo">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>img/logo-dashboard.png" alt="logo" class="logo-default"></a>
            </div>
            <a href="#" class="menu-toggler"></a>            
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">                                       
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">                     
                        <?php if (!empty($this->session->userdata('avatar'))) { ?>
                            <img src="<?php echo base_url(); ?>icon/<?php echo $this->session->userdata('avatar'); ?>" class="img-responsive" alt="">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>img/avatar.png" class="img-responsive" alt="">
                        <?php } ?>
                        <span class="username username-hide-mobile"><?php echo $this->session->userdata('nama'); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?php echo site_url('dashboard/profil'); ?>">
                                <i class="icon-user"></i> Profil </a>
                            </li>                           
                            <li class="divider">
                            </li>
                            <li>
                                <a href="<?php echo site_url('login/logout'); ?>">
                                <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>            
        </div>
    </div>
    
    <div class="page-header-menu">
        <div class="container">
            <div class="hor-menu ">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="<?php echo site_url('dashboard/home'); ?>">Dashboard</a>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
    
</div>