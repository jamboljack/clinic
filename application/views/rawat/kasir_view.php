<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
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
            Transaksi Rawat Jalan <small>Kasir/Pembayaran</small>
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
                    <a href="#">Kasir/Pembayaran</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Daftar Transaksi Pasien
                        </div>
                        <div class="tools"></div>
                    </div>                    
                    <div class="portlet-body">                        
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th width="10%">No. Transaksi</th>
                                <th width="14%">Tanggal</th>
                                <th>Nama Pasien</th>
                                <th width="15%">Poliklinik</th>
                                <th width="20%">Dokter</th>
                                <th width="5%">Status</th>
                                <th width="5%">Bayar</th>
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
                                    <a href="<?php echo site_url('rawat/kasir/id/'.$r->pasien_id); ?>"><button class="btn btn-warning btn-xs" title="Edit Data"><i class="icon-check"></i></button>
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