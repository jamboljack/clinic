<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.min.js"></script>

<script language="JavaScript" type="text/JavaScript">
$(document).ready(function(){
    $('#kembalian').maskMoney({thousands:',', precision:0});    
});
</script>

<script type="text/javascript">
function HitungKembalian(){
    var myForm      = document.form1;
    var Sisa        = parseInt(myForm.sisa.value);
    var Bayar       = parseInt(myForm.jml_bayar.value);
    var Kembalian   = (Bayar - Sisa);

    if (Kembalian > 0) {
        myForm.kembalian.value = Kembalian; 
    } else {
        myForm.kembalian.value = 0;
    }       
}
</script>

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
                    <a href="<?php echo site_url('rawat/kasir'); ?>">Kasir/Pembayaran</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Daftar Transaksi Pasien</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i> Data Pasien
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form">
                            <div class="form-body">                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail->pasien_nama.' - '.$detail->pasien_no_rm; ?>" readonly>
                                                <label for="form_control_1">Nama Pasien</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail->pasien_alamat; ?>" readonly>
                                                <label for="form_control_1">Alamat</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail->pelanggan_name.' - '.$detail->kelompok_name; ?>" readonly>
                                                <label for="form_control_1">Pelanggan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="portlet light bordered">
                        <div class="invoice">
                            <div class="row invoice-logo">
                                <div class="col-xs-6">
                                    <p>
                                    <b>SISA</b>
                                    </p>
                                </div>  
                                <div class="col-xs-6">
                                <p>                                
                                <b><?php echo number_format($Sisa, 0, '.', ','); ?></b>
                                <span class="muted">No. Kwitansi : <b><?php echo $Kwitansi; ?></b></span>
                                </p>
                                </div>
                            </div>
                            <hr/>
                        </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('rawat/kasir/pembayaran/'.$this->uri->segment(4)); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" id="sisa" value="<?php echo $Sisa; ?>">
                        
                            <div class="form-body">                                
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" id="grandtotal" name="grandtotal" value="<?php echo number_format($GrandTotal, 0, '.', ','); ?>" readonly>
                                                <label for="form_control_1">Grand Total</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" id="dibayar" name="dibayar" value="<?php echo number_format($DiBayar, 0, '.', ','); ?>" readonly>
                                                <label for="form_control_1">Di Bayar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" id="dibayar" name="dibayar" value="<?php echo number_format($Sisa, 0, '.', ','); ?>" readonly>
                                                <label for="form_control_1">Sisa</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group">
                                                <div class="input-group-control">
                                                    <select class="form-control" name="lstJenisBayar" required>
                                                        <option value="">- Pilih Jenis Bayar -</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Credit">Credit</option>
                                                    </select>
                                                    <label for="form_control_1">Jenis Bayar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group">
                                                <div class="input-group-control">
                                                    <input type="number" class="form-control" name="jml_bayar" id="jml_bayar" value="<?php echo set_value('jml_bayar', 0); ?>" onkeydown="HitungKembalian()" autocomplete="off" required>
                                                    <label for="form_control_1">Jumlah Bayar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" id="kembalian" name="kembalian" value="<?php echo set_value('kembalian', 0); ?>" onkeydown="HitungKembalian()" readonly>
                                                <label for="form_control_1">Kembalian</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green submit"><i class="fa fa-floppy-o"></i> Bayar Kwitansi</button>
                                        <a href="<?php echo site_url('rawat/tindakan/bhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" class="btn red"><i class="fa fa-print"></i> Print Kwitansi</a>
                                        <a href="<?php echo site_url('rawat/kasir'); ?>" class="btn yellow"><i class="fa fa-times"></i> Kembali</a>                                        
                                    </div>
                                </div>                            
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Item Barang-->                
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-list"></i>Daftar Tindakan
                                </div>                                                        
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="13%">No. Transaksi</th>
                                                <th width="10%">Tanggal</th>
                                                <th>Nama Dokter</th>
                                                <th width="15%">Nama Poliklinik</th>
                                                <th width="15%">Total</th>
                                                <th width="15%">Jenis Bayar</th>
                                                <th width="5%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;                                            
                                            foreach($listTindakan as $i) {                                                
                                                $tanggal        = $i->rawat_date;
                                                if (!empty($tanggal)) {
                                                    $xtanggal   = explode("-",$tanggal);
                                                    $thn        = $xtanggal[0];
                                                    $bln        = $xtanggal[1];
                                                    $tgl        = $xtanggal[2];

                                                    $date       = $tgl.'-'.$bln.'-'.$thn;
                                                } else { 
                                                    $date       = '';
                                                }
                                                
                                                if ($i->rawat_jns_bayar == '-') {
                                                    $status = 'BELUM BAYAR';
                                                } else {
                                                    $status = $i->rawat_jns_bayar;
                                                }
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $no; ?></td>
                                                <td><?php echo $i->rawat_no_trans; ?></td>
                                                <td align="center"><?php echo $date; ?></td>
                                                <td><?php echo $i->dokter_name; ?></td>
                                                <td><?php echo $i->poliklinik_name; ?></td>
                                                <td align="right"><b><?php echo number_format($i->rawat_total, 0, '.', ','); ?></b></td>
                                                <td align="center"><b><?php echo $status; ?></b></td>
                                                <td align="center">                                                    
                                                    <a href="<?php echo site_url('kasir/tindakan/detail/'.$i->pasien_id.'/'.$i->rawat_id); ?>"><button class="btn btn-primary btn-xs" title="Detail Data"><i class="icon-pencil"></i></button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $no++;
                                            } 
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" align="center"><b>SUB TOTAL</b></td>
                                                <td align="right"><b><?php echo number_format($TotalA, 0, '.', ','); ?></b></td>
                                                <td align="right"><b><?php echo number_format($TotalAC, 0, '.', ','); ?></b></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- List Resep Pasien -->
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-list"></i>Daftar Resep
                                </div>                                                        
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="13%">No. Faktur</th>
                                                <th width="10%">Tanggal</th>
                                                <th>Nama Dokter</th>                                                
                                                <th width="15%">Total</th>
                                                <th width="15%">Jenis Bayar</th>
                                                <th width="5%">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach($listResep as $r) {                                                
                                                $tanggal        = $r->jual_date;
                                                if (!empty($tanggal)) {
                                                    $xtanggal   = explode("-",$tanggal);
                                                    $thn        = $xtanggal[0];
                                                    $bln        = $xtanggal[1];
                                                    $tgl        = $xtanggal[2];

                                                    $date       = $tgl.'-'.$bln.'-'.$thn;
                                                } else { 
                                                    $date       = '';
                                                }
                                                
                                                if ($r->jual_pay_type == '-') {
                                                    $status = 'BELUM BAYAR';
                                                } else {
                                                    $status = $r->jual_pay_type;
                                                }
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $no; ?></td>
                                                <td><?php echo $r->jual_no_faktur; ?></td>
                                                <td align="center"><?php echo $date; ?></td>
                                                <td><?php echo $r->dokter_name; ?></td>
                                                <td align="right"><b><?php echo number_format($r->jual_total, 0, '.', ','); ?></b></td>
                                                <td align="center"><b><?php echo $status; ?></b></td>
                                                <td align="center">                                                    
                                                    <a href="<?php echo site_url('kasir/tindakan/detail/'.$r->pasien_id.'/'.$r->jual_id); ?>"><button class="btn btn-primary btn-xs" title="Detail Data"><i class="icon-pencil"></i></button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $no++;
                                            } 
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" align="center"><b>SUB TOTAL</b></td>
                                                <td align="right"><b><?php echo number_format($TotalB, 0, '.', ','); ?></b></td>
                                                <td align="right"><b><?php echo number_format($TotalBC, 0, '.', ','); ?></b></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>            
</div>