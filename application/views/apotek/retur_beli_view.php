<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script>
    function hapusData(pembelian_id) {
        var id = pembelian_id;
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
            window.location.href="<?php echo site_url('apotek/pembelian/deletedata'); ?>"+"/"+id
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
            Transaksi <small>Pembelian</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('apotek/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Transaksi</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pembelian</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo site_url('apotek/pembelian/adddata'); ?>">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah</button>
                </a>
                <br><br>
                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Daftar Pembelian
                        </div>
                        <div class="tools"></div>
                    </div>

                    <div class="portlet-body">                        
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th width="15%">No. Faktur</th>
                                <th width="10%">Tanggal</th>
                                <th>Suplier</th>
                                <th width="5%">PPN %</th>
                                <th width="10%">Total</th>
                                <th width="5%">Bayar</th>
                                <th width="10%">Status</th>
                                <th width="10%">Username</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($daftarlist as $r) {
                                $pembelian_id   = $r->pembelian_id;
                                
                                $tanggal        = $r->pembelian_date_in;
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
                                <td><?php echo $r->pembelian_no_invoice; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $r->suplier_name; ?></td>
                                <td><?php echo number_format($r->pembelian_ppn, 2, '.', ','); ?></td>
                                <td><?php echo number_format($r->pembelian_netto, 0, '.', ','); ?></td>
                                <td><?php echo $r->pembelian_pay_type; ?></td>
                                <td>
                                    <?php 
                                    if($r->pembelian_status == 0) { 
                                        echo '<span class="label label-sm label-danger">Belum Final</span>'; 
                                    } else { 
                                        echo '<span class="label label-sm label-success">Final</span>'; 
                                    } 
                                    ?>
                                </td>
                                <td><?php echo $r->user_username; ?></td>
                                <td>
                                    <a href="<?php echo site_url('apotek/pembelian/editdata/'.$r->pembelian_id); ?>"><button class="btn btn-primary btn-xs" title="Edit Data"><i class="icon-pencil"></i> Edit</button></a>                                    
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