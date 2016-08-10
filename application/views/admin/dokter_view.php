<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script>
    function hapusData(dokter_id) {
        var id = dokter_id;
        swal({
            title: 'Anda Yakin ?',
            text: 'Data ini Akan di Hapus !',type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: true
        }, function() {
            window.location.href="<?php echo site_url('admin/dokter/deletedata'); ?>"+"/"+id
        });
    }
</script>

<script type="text/javascript">
    $(function() {
        $(document).on("click",'.edit_button', function(e) {
            var id          = $(this).data('id');            
            var name        = $(this).data('name');
            var tipe        = $(this).data('tipe');
            var address     = $(this).data('address');
            var city        = $(this).data('city');            
            var phone       = $(this).data('phone');
            $(".dokter_id").val(id);
            $(".dokter_name").val(name);
            $(".tipe_id").val(tipe);
            $(".dokter_address").val(address);
            $(".dokter_city").val(city);
            $(".dokter_phone").val(phone);
        })
    });
</script>

<?php 
if ($this->session->flashdata('notification')) { ?>
<script>
    swal({
        title: "Done",
        text: "<?php echo $this->session->flashdata('notification'); ?>",
        timer: 2000,
        showConfirmButton: false,
        type: 'success'
    });
</script>
<? } ?>

<!-- Add Modal Form -->
<div class="modal bs-modal-lg" id="add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('admin/dokter/savedata'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Form Tambah Dokter</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Nama Dokter</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter Nama Dokter" name="name" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tipe Dokter</label>
                    <div class="col-md-9 has-error">
                        <select class="form-control" name="lstTipe" required >
                            <option value="">- Pilih Tipe Dokter -</option>
                            <?php foreach($listTipe as $r) { ?>
                            <option value="<?php echo $r->tipe_id; ?>"><?php echo $r->tipe_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-9 has-error">                                            
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kota</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter Kota" name="city" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">No. Telpon</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter No. Telpon" name="phone" autocomplete="off" required>
                    </div>
                </div>                
            </div>
                        
            <div class="modal-footer">
                <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Simpan</button>
                <button type="button" class="btn yellow" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            </div>
            </form>
        </div>        
    </div>    
</div>

<!-- Edit Modal Form -->
<div class="modal bs-modal-lg" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('admin/dokter/updatedata'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" class="form-control dokter_id" name="id">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Form Edit Dokter</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Nama Dokter</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control dokter_name" placeholder="Enter Nama Dokter" name="name" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tipe Dokter</label>
                    <div class="col-md-9 has-error">
                        <select class="form-control tipe_id" name="lstTipe" required >
                            <option value="">- Pilih Tipe Dokter -</option>
                            <?php foreach($listTipe as $r) { ?>
                            <option value="<?php echo $r->tipe_id; ?>"><?php echo $r->tipe_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-9 has-error">                                            
                        <textarea class="form-control dokter_address" name="address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kota</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control dokter_city" placeholder="Enter Kota" name="city" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">No. Telpon</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control dokter_phone" placeholder="Enter No. Telpon" name="phone" autocomplete="off" required>
                    </div>
                </div>
            </div>
                        
            <div class="modal-footer">
                <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Update</button>
                <button type="button" class="btn yellow" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            </div>
            </form>
        </div>        
    </div>    
</div>

<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Master Klinik <small>Dokter</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('admin/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Master Klinik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Dokter</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="modal" href="#add">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</button>
                </a>
                <br><br>
                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Daftar Dokter
                        </div>
                        <div class="tools"></div>
                    </div>

                    <div class="portlet-body">                        
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th>Nama Dokter</th>
                                <th width="20%">Tipe</th>                                
                                <th width="25%">Alamat</th>
                                <th width="10%">Telp</th>
                                <th width="16%">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($daftarlist as $r) {
                                $dokter_id   = $r->dokter_id;
                            ?>                                
                            <tr>
                                <td><?php echo $no; ?></td>                                
                                <td><?php echo $r->dokter_name; ?></td>
                                <td><?php echo $r->tipe_name; ?></td>
                                <td><?php echo $r->dokter_address; ?></td>
                                <td><?php echo $r->dokter_phone; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs edit_button" data-toggle="modal" data-target="#edit" data-id="<?php echo $r->dokter_id; ?>" data-name="<?php echo $r->dokter_name; ?>" data-tipe="<?php echo $r->tipe_id; ?>" data-address="<?php echo $r->dokter_address; ?>" data-city="<?php echo $r->dokter_city; ?>" data-phone="<?php echo $r->dokter_phone; ?>" title="Edit Data"><i class="icon-pencil"></i> Edit
                                    </button>
                                    <a onclick="hapusData(<?php echo $dokter_id; ?>)"><button class="btn btn-danger btn-xs" title="Hapus Data"><i class="icon-trash"></i> Hapus</button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>

                        </table>
                    </div>
                </div>            
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>