<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Users
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('admin/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>                
                <li>
                    <a href="<?php echo site_url('admin/users'); ?>">Users</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tambah Users</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus-square"></i> Form Tambah Users
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('admin/users/savedata'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-body">
                                <?php if ($error == 'true') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <b>ERROR !!</b> <br>
                                    <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Username</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Username" name="username" value="<?php echo set_value('username'); ?>" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" title="Don't Use SPACE" autocomplete="off" required autofocus>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control" id="form_control_1" placeholder="Enter Password" name="password" autocomplete="off" required>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Nama Lengkap</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Nama Lengkap" name="name" value="<?php echo set_value('name'); ?>" autocomplete="off" required>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Avatar</label>
                                    <div class="col-md-10 has-success">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="<?php echo base_url(); ?>img/no_image.gif" alt="" />
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                                            </div>
                                            <div>
                                                <span class="btn btn-blue btn-file">
                                                <span class="fileupload-new"><i class="icon-paper-clip"></i> Browse</span>
                                                <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                    <input type="file" class="default" name="userfile" />
                                                </span>                                             
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10">
                                            <span class="label label-danger">NOTE !</span>
                                            <span>Resolution : 200 x 200 pixel</span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Simpan</button>
                                        <a href="<?php echo site_url('admin/users'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>            
</div>  