<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script>
    function hapusData(obat_code) {
        var id = obat_code;
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
            window.location.href="<?php echo site_url('apotek/obat/deletedata'); ?>"+"/"+id
        });
    }
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

<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Transaksi Rawat Jalan <small>Resep Pasien</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('rawat/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Transaksi Rawat Jalan</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Resep Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pilih Data Pasien</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo site_url('rawat/resep'); ?>">
                    <button type="submit" class="btn yellow"><i class="fa fa-times"></i> Kembali</button>
                </a>
                <br><br>
                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Pilih Data Pasien
                        </div>
                        <div class="tools"></div>
                    </div>                    
                    <div class="portlet-body">                        
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th width="10%">No. Transaksi</th>
                                <th width="15%">Tanggal</th>
                                <th>Nama Pasien</th>
                                <th width="15%">Poliklinik</th>
                                <th width="20%">Dokter</th>
                                <th width="5%">Status</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($listPasien as $r) {
                                $tanggal        = $r->rawat_date;
                                if (!empty($tanggal)) {
                                    $xtanggal   = explode("-",$tanggal);
                                    $thn        = $xtanggal[0];
                                    $bln        = $xtanggal[1];
                                    $tgl        = $xtanggal[2];

                                    $date       = $tgl.'-'.$bln.'-'.$thn;
                                } else { 
                                    $date       = '';
                                }
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>                                
                                <td><?php echo $r->rawat_no_trans; ?></td>
                                <td><?php echo $date.' '.$r->rawat_time_update; ?></td>
                                <td><?php echo $r->pasien_nama; ?></td>
                                <td><?php echo $r->poliklinik_name; ?></td>
                                <td><?php echo $r->dokter_name; ?></td>
                                <td>
                                    <?php if ($r->rawat_st_bayar == 'Open') { ?>
                                    <span class="label label-primary"><?php echo $r->rawat_st_bayar; ?></span>
                                    <?php } else { ?>
                                    <span class="label label-danger"><?php echo $r->rawat_st_bayar; ?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('rawat/resep/addresep/'.$r->rawat_id.'/'.$r->jenis_id); ?>"><button class="btn btn-primary btn-xs" title="Tambah Data"><i class="fa fa-plus-square"></i></button></a>
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