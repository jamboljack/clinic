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
                    <a href="#">Edit Users</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i> Form Edit Users
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('admin/users/updatedata'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id" value="<?php echo $detail->user_username; ?>" />

                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Username</label>
                                    <div class="col-md-10">
                                        <input class="form-control" value="<?php echo $detail->user_username; ?>" id="form_control_1" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control" id="form_control_1" placeholder="Change Password" name="password" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                        <span class="help-block">Isi Password Jika Ingin di RUBAH.</span>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Nama Lengkap</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Name" name="name" value="<?php echo $detail->user_name; ?>" autocomplete="off" required>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name='lstStatus' required>
                                            <option value="">- Select Status -</option>
                                            <option value="Active" <?php if ($detail->user_status == 'Active') { echo 'selected'; } ?>>Active</option>
                                            <option value="Non Active" <?php if ($detail->user_status == 'Non Active') { echo 'selected'; } ?>>Non Active</option>
                                        </select>
                                    </div>                      
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Avatar Lama</label>
                                    <div class="col-md-10 has-error">
                                        <?php if (!empty($detail->user_image)) { ?>
                                        <img src="<?php echo base_url(); ?>icon/<?php echo $detail->user_image; ?>" width="20%">
                                        <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>img/avatar.png">
                                        <?php } ?>
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
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Update</button>
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