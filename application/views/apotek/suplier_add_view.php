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
            Master Data <small>Suplier</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('apotek/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Master Data</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?php echo site_url('apotek/suplier'); ?>">Suplier</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tambah Suplier</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus-square"></i> Form Tambah Suplier
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('apotek/suplier/savedata'); ?>" method="post" enctype="multipart/form-data" name="form1">
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
                                    <label class="col-md-2 control-label" for="form_control_1">Nama Suplier</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Nama Suplier" name="name" value="<?php echo set_value('name'); ?>" autocomplete="off" required autofocus>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label">Alamat</label>
                                    <div class="col-md-10 has-success">
                                        <textarea class="form-control" name="address" rows="3" placeholder="Enter Alamat" required><?php echo set_value('address'); ?></textarea>
                                    </div>                                    
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Provinsi</label>
                                    <div class="col-md-10">
                                        <select class="select2_category form-control" data-placeholder="- Pilih Provinsi -" name="lstProvinsi" id="lstProvinsi" required>
                                            <option value="">- Pilih Provinsi -</option>
                                            <?php 
                                            foreach($listProvinsi as $p) { 
                                            ?>
                                            <option value="<?php echo $p->provinsi_id; ?>" <?php echo set_select('lstProvinsi', $p->provinsi_id); ?>><?php echo $p->provinsi_name; ?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>                      
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Kabupaten</label>
                                    <div class="col-md-10">
                                        <select class="select2_category form-control" data-placeholder="- Pilih Kabupaten -" name="lstKabupaten" id="lstKabupaten" required>
                                            <option value="">- Pilih Kabupaten -</option>
                                            <?php 
                                            foreach($listKabupaten as $k) { 
                                            ?>
                                            <option value="<?php echo $k->kab_id; ?>" <?php echo set_select('lstKabupaten', $k->kab_id); ?>><?php echo $k->kab_name; ?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>                      
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Kota</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Kota" name="city" value="<?php echo set_value('city'); ?>" autocomplete="off" required>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Kode Pos</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" maxlength="5" id="form_control_1" placeholder="Enter Kode Pos" name="zipcode" value="<?php echo set_value('zipcode'); ?>" pattern="^[0-9]*" title="Harus ANGKA" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">No. Telp</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter No. Telp" name="phone" value="<?php echo set_value('phone'); ?>" autocomplete="off" required>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">No. Fax</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter No. Fax" name="fax" value="<?php echo set_value('fax'); ?>" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Email</label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" id="form_control_1" placeholder="Enter Email" name="email" value="<?php echo set_value('email'); ?>" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Kontak</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Kontak" name="contact" value="<?php echo set_value('contact'); ?>" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">No. NPWP</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter No. NPWP" name="npwp" value="<?php echo set_value('npwp'); ?>" autocomplete="off" required>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Termin Hutang (Hari)</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" maxlength="2" id="form_control_1" placeholder="Enter Termin" name="termin" value="<?php echo set_value('termin', 0); ?>" pattern="^[0-9]*" title="Harus ANGKA" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Limit Hutang (Rp)</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" id="form_control_1" placeholder="Enter Limit Hutang" name="limit" value="<?php echo set_value('limit', 0); ?>" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Saldo Awal (Rp)</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" id="form_control_1" placeholder="Enter Saldo Awal" name="saldo" value="<?php echo set_value('saldo', 0); ?>" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Simpan</button>
                                        <a href="<?php echo site_url('apotek/suplier'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>
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