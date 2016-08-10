<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script>
    function hapusData(perawat_id) {
        var id = perawat_id;
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
            window.location.href="<?php echo site_url('admin/perawat/deletedata'); ?>"+"/"+id
        });
    }
</script>

<script type="text/javascript">
    $(function() {
        $(document).on("click",'.edit_button', function(e) {
            var id          = $(this).data('id');            
            var name        = $(this).data('name');            
            var address     = $(this).data('address');
            var city        = $(this).data('city');
            var phone       = $(this).data('phone');
            $(".perawat_id").val(id);
            $(".perawat_name").val(name);          
            $(".perawat_address").val(address);
            $(".perawat_city").val(city);
            $(".perawat_phone").val(phone);        
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
            <form action="<?php echo site_url('admin/perawat/savedata'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Form Tambah Perawat</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Nama Perawat</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter Nama Perawat" name="name" autocomplete="off" required>
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
            <form action="<?php echo site_url('admin/perawat/updatedata'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" class="form-control perawat_id" name="id">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Form Edit Perawat</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Nama Perawat</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control perawat_name" placeholder="Enter Nama Perawat" name="name" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-9 has-error">                                            
                        <textarea class="form-control perawat_address" name="address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kota</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control perawat_city" placeholder="Enter Kota" name="city" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">No. Telpon</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control perawat_phone" placeholder="Enter No. Telpon" name="phone" autocomplete="off" required>
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
            Master Klinik <small>Perawat</small>
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
                    <a href="#">Perawat</a>
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
                            <i class="fa fa-list"></i> Daftar Perawat
                        </div>
                        <div class="tools"></div>
                    </div>

                    <div class="portlet-body">                        
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th>Nama Perawat</th>                                
                                <th width="25%">Alamat</th>
                                <th width="15%">Kota</th>
                                <th width="10%">Telp</th>
                                <th width="16%">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($daftarlist as $r) {
                                $perawat_id   = $r->perawat_id;
                            ?>                                
                            <tr>
                                <td><?php echo $no; ?></td>                                
                                <td><?php echo $r->perawat_name; ?></td>                                
                                <td><?php echo $r->perawat_address; ?></td>
                                <td><?php echo $r->perawat_city; ?></td>
                                <td><?php echo $r->perawat_phone; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs edit_button" data-toggle="modal" data-target="#edit" data-id="<?php echo $r->perawat_id; ?>" data-name="<?php echo $r->perawat_name; ?>" data-address="<?php echo $r->perawat_address; ?>" data-city="<?php echo $r->perawat_city; ?>"  data-phone="<?php echo $r->perawat_phone; ?>" title="Edit Data"><i class="icon-pencil"></i> Edit
                                    </button>
                                    <a onclick="hapusData(<?php echo $perawat_id; ?>)"><button class="btn btn-danger btn-xs" title="Hapus Data"><i class="icon-trash"></i> Hapus</button>
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