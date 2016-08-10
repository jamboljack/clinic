<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script>
    function hapusData(pelanggan_id) {
        var id = pelanggan_id;
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
            window.location.href="<?php echo site_url('admin/pelanggan/deletedata'); ?>"+"/"+id
        });
    }
</script>

<script type="text/javascript">
    $(function() {
        $(document).on("click",'.edit_button', function(e) {
            var id          = $(this).data('id');            
            var name        = $(this).data('name');
            var kelompok    = $(this).data('kelompok');
            var address     = $(this).data('address');
            var city        = $(this).data('city');
            var zipcode     = $(this).data('zipcode');
            var phone       = $(this).data('phone');
            var fax         = $(this).data('fax');
            var limit       = $(this).data('limit');
            $(".pelanggan_id").val(id);
            $(".pelanggan_name").val(name);
            $(".kelompok_id").val(kelompok);
            $(".pelanggan_address").val(address);
            $(".pelanggan_city").val(city);
            $(".pelanggan_zipcode").val(zipcode);
            $(".pelanggan_phone").val(phone);
            $(".pelanggan_fax").val(fax);
            $(".pelanggan_limit").val(limit);
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
            <form action="<?php echo site_url('admin/pelanggan/savedata'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Form Tambah Pelanggan</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Nama Pelanggan</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter Nama Pelanggan" name="name" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Kelompok</label>
                    <div class="col-md-9 has-error">
                        <select class="form-control" name="lstKelompok" required >
                            <option value="">- Pilih Kelompok -</option>
                            <?php foreach($listKelompok as $r) { ?>
                            <option value="<?php echo $r->kelompok_id; ?>"><?php echo $r->kelompok_name; ?></option>
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
                    <div class="col-md-5 has-error">
                        <input type="text" class="form-control" placeholder="Enter Kota" name="city" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kode Pos</label>
                    <div class="col-md-2 has-error">
                        <input type="text" class="form-control" placeholder="Enter Kode Pos" name="zipcode" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">No. Telpon</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter No. Telpon" name="phone" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Fax</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control" placeholder="Enter Fax" name="fax" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Limit (Rp)</label>
                    <div class="col-md-3 has-error">
                        <input type="text" class="form-control" placeholder="Enter Limit" pattern="^[0-9]*" title="Harus ANGKA" name="limit" autocomplete="off" value="<?php echo set_value('limit', 0); ?>">
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
            <form action="<?php echo site_url('admin/pelanggan/updatedata'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" class="form-control pelanggan_id" name="id">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Form Edit Pelanggan</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Nama Pelanggan</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control pelanggan_name" placeholder="Enter Nama Pelanggan" name="name" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Kelompok</label>
                    <div class="col-md-9 has-error">
                        <select class="form-control kelompok_id" name="lstKelompok" required >
                            <option value="">- Pilih Kelompok -</option>
                            <?php foreach($listKelompok as $r) { ?>
                            <option value="<?php echo $r->kelompok_id; ?>"><?php echo $r->kelompok_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-9 has-error">                                            
                        <textarea class="form-control pelanggan_address" name="address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kota</label>
                    <div class="col-md-5 has-error">
                        <input type="text" class="form-control pelanggan_city" placeholder="Enter Kota" name="city" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kode Pos</label>
                    <div class="col-md-2 has-error">
                        <input type="text" class="form-control pelanggan_zipcode" placeholder="Enter Kode Pos" name="zipcode" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">No. Telpon</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control pelanggan_phone" placeholder="Enter No. Telpon" name="phone" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Fax</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control pelanggan_fax" placeholder="Enter Fax" name="fax" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Limit (Rp)</label>
                    <div class="col-md-3 has-error">
                        <input type="text" class="form-control pelanggan_limit" placeholder="Enter Limit" pattern="^[0-9]*" title="Harus ANGKA" name="limit" autocomplete="off">
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
            Master Tarif <small>Pelanggan</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('admin/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Master Tarif</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pelanggan</a>
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
                            <i class="fa fa-list"></i> Daftar Pelanggan
                        </div>
                        <div class="tools"></div>
                    </div>

                    <div class="portlet-body">                        
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th>Nama Pelanggan</th>
                                <th width="10%">Kelompok</th>
                                <th width="10%">Tgl. Reg</th>
                                <th width="30%">Alamat</th>
                                <th width="10%">Telp</th>
                                <th width="16%">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($daftarlist as $r) {
                                $pelanggan_id   = $r->pelanggan_id;
                                $tanggal        = $r->pelanggan_date_reg;                                          
                                if (!empty($tanggal)) {
                                    $xtanggal   = explode("-",$tanggal);
                                    $thn1       = $xtanggal[0];
                                    $bln1       = $xtanggal[1];
                                    $tgl1       = $xtanggal[2];

                                    $date       = $tgl1.'-'.$bln1.'-'.$thn1;
                                } else { 
                                    $date       = '';
                                }
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>                                
                                <td><?php echo $r->pelanggan_name; ?></td>
                                <td><?php echo $r->kelompok_name; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $r->pelanggan_address; ?></td>
                                <td><?php echo $r->pelanggan_phone; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs edit_button" data-toggle="modal" data-target="#edit" data-id="<?php echo $r->pelanggan_id; ?>" data-name="<?php echo $r->pelanggan_name; ?>" data-kelompok="<?php echo $r->kelompok_id; ?>" data-address="<?php echo $r->pelanggan_address; ?>" data-city="<?php echo $r->pelanggan_city; ?>" data-zipcode="<?php echo $r->pelanggan_zipcode; ?>" data-phone="<?php echo $r->pelanggan_phone; ?>" data-fax="<?php echo $r->pelanggan_fax; ?>" data-limit="<?php echo $r->pelanggan_limit; ?>" title="Edit Data"><i class="icon-pencil"></i> Edit
                                    </button>
                                    <a onclick="hapusData(<?php echo $pelanggan_id; ?>)"><button class="btn btn-danger btn-xs" title="Hapus Data"><i class="icon-trash"></i> Hapus</button>
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