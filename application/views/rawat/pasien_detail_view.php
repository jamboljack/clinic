<script type="text/javascript">
    $(document).ready(function () {
        $("#lstProvinsi").select2({
        });

        $("#lstKabupaten").select2({
        });        
    });
</script>

<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Pendaftaran <small>Pendaftaran Pasien</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('rawat/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pendaftaran</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pendaftaran Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pasien Baru</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row margin-top-20">
            <div class="col-md-12">            
            
                <div class="profile-sidebar">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <img src="<?php echo base_url('img/no-image-pasien.png'); ?>" class="img-responsive" alt="">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                Photo
                            </div>
                        </div>
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">                                
                                <li class="active">
                                    <a href="#">
                                    <i class="fa fa-user-plus"></i>
                                    Data Pasien Baru </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('rawat/pendaftaran/pasienlama'); ?>">
                                    <i class="fa fa-user"></i>
                                    Data Pasien Lama </a>
                                </li>                                
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->                    
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->

                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Data Pasien Baru</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">Data Personal</a>
                                        </li>                                    
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <form role="form" action="#">
                                                <div class="form-group">
                                                    <label class="control-label">No. Rekam Medis</label>
                                                    <input type="text" placeholder="Enter No. Rekam Medis" class="form-control" name="no_rm" value="<?php echo set_value('no_rm'); ?>" autocomplete="off" required readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" placeholder="Doe" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control"/>
                                                </div>                                               
                                                <div class="margiv-top-10">
                                                    <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Simpan</button>      
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->

            </div>
        </div>

    </div>            
</div>  