<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.min.js"></script>
<script>
    function hapusDataItem(detail_id) {
        var id = detail_id;
        swal({
            title: 'Hapus Tindakan ?',
            text: 'Data ini Akan di Hapus !',type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: true
        }, function() {
            window.location.href="<?php echo site_url('rawat/pendaftaran/deletedataitem/'.$this->uri->segment(4)); ?>"+"/"+id
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

<script language="JavaScript" type="text/JavaScript">
$(document).ready(function(){
    $('#produk_harga').maskMoney({thousands:',', precision:0});    
    $('#produk_subtotal').maskMoney({thousands:',', precision:0});
    $('#item_harga').maskMoney({thousands:',', precision:0});
    $('#item_subtotal').maskMoney({thousands:',', precision:0});
});
</script>

<script type="text/javascript">
function HitungSubTotal(){    
    var myForm      = document.form1;
    var Qty         = parseFloat(myForm.produk_qty.value);
    var Harga       = myForm.produk_harga.value;
    Harga           = Harga.replace(/[,]/g, ''); // Ini String
    Harga           = parseInt(Harga); // Ini Integer    

    var SubTotal    = (Qty*Harga);
    if (SubTotal > 0) {
        myForm.produk_subtotal.value = SubTotal; 
    } else {
        myForm.produk_subtotal.value = 0;
    }

    var Tempat      = (Qty*parseInt(myForm.jasa_tempat.value));
    myForm.total_jasa_tempat.value  = Tempat;
    var Dokter      = Qty*parseInt(myForm.jasa_dokter.value);
    myForm.total_jasa_dokter.value  = Dokter;
    var Perawat     = Qty*parseInt(myForm.jasa_perawat.value);
    myForm.total_jasa_perawat.value = Perawat;
    var Lain        = Qty*parseInt(myForm.jasa_lain.value);
    myForm.total_jasa_lain.value    = Lain;
}
</script>

<script type="text/javascript">
$(function() {
    $(document).on("click",'.pilih_item', function(e) {        
        var code        = $(this).data('code');
        var name        = $(this).data('name');
        var harga       = $(this).data('harga');
        var tempat      = $(this).data('jstempat');
        var dokter      = $(this).data('jsdokter');
        var perawat     = $(this).data('jsperawat');
        var lain        = $(this).data('jslain');
        $(".produk_id").val(code);
        $(".produk_name").val(name);
        $(".produk_qty").val(1);
        $(".produk_harga").val(harga);    
        $(".produk_subtotal").val(harga);
        $(".jasa_tempat").val(tempat);
        $(".jasa_dokter").val(dokter);
        $(".jasa_perawat").val(perawat);
        $(".jasa_lain").val(lain);
    })
});
</script>

<script type="text/javascript">
    $(function() {
        $(document).on("click",'.edit_item', function(e) {
            var id          = $(this).data('id');
            var code        = $(this).data('code');          
            var name        = $(this).data('name');
            var qty         = $(this).data('qty');            
            var harga       = $(this).data('harga');
            var subtotal    = $(this).data('subtotal');
            var tgl         = $(this).data('tgl');
            var tgl_trans   = tgl.split("-").reverse().join("-");
            var dokter      = $(this).data('dokter');
            var jstempat    = $(this).data('jstempat');
            var jsdokter    = $(this).data('jsdokter');
            var jsperawat   = $(this).data('jsperawat');
            var jslain      = $(this).data('jslain');            
            $(".detail_id").val(id);
            $(".item_code").val(code);
            $(".item_name").val(name);
            $(".item_qty").val(qty);
            $(".item_harga").val(harga);            
            $(".item_subtotal").val(subtotal);
            $(".item_tanggal").val(tgl_trans);
            $(".item_dokter").val(dokter);
            $(".item_jasa_tempat").val(jstempat);
            $(".item_jasa_dokter").val(jsdokter);
            $(".item_jasa_perawat").val(jsperawat);
            $(".item_jasa_lain").val(jslain);
        })
    });
</script>

<script type="text/javascript">
function HitungSubTotalItem(){
    var myForm2     = document.form2;
    var Qty         = parseFloat(myForm2.item_qty.value);
    var Harga       = myForm2.item_harga.value;
    Harga           = Harga.replace(/[,]/g, ''); // Ini String
    Harga           = parseInt(Harga); // Ini Integer    

    var SubTotal    = (Qty*Harga);
    if (SubTotal > 0) {
        myForm2.item_subtotal.value = SubTotal; 
    } else {
        myForm2.item_subtotal.value = 0;
    }    
    var Tempat      = (Qty*parseInt(myForm2.item_jasa_tempat.value));    
    myForm2.item_total_jasa_tempat.value  = Tempat;
    var Dokter      = Qty*parseInt(myForm2.item_jasa_dokter.value);
    myForm2.item_total_jasa_dokter.value  = Dokter;
    var Perawat     = Qty*parseInt(myForm2.item_jasa_perawat.value);
    myForm2.item_total_jasa_perawat.value = Perawat;
    var Lain        = Qty*parseInt(myForm2.item_jasa_lain.value);
    myForm2.item_total_jasa_lain.value    = Lain;    
}
</script>

<!-- List Daftar Tindakan -->
<div class="modal bs-modal-lg" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                <div class="modal-header">                      
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-search"></i> Cari Data Tindakan</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1" width="100%">
                        <thead>
                            <tr>
                                <th width="8%">Pilih</th>
                                <th>Nama Tindakan</th>
                                <th width="30%">Unit</th>
                                <th width="20%">Tarif</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                        <?php 
                            $no = 1;
                            foreach($listProduk as $p) {                            
                            ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs pilih_item" data-toggle="modal" data-code="<?php echo $p->produk_id; ?>" data-name="<?php echo $p->produk_name; ?>" data-harga="<?php echo $p->produk_total; ?>" data-jstempat="<?php echo $p->produk_js_tempat; ?>" data-jsdokter="<?php echo $p->produk_js_dokter; ?>" data-jsperawat="<?php echo $p->produk_js_perawat; ?>" data-jslain="<?php echo $p->produk_js_lain; ?>" title="Pilih Data" data-dismiss="modal"><i class="icon-check"></i> Pilih
                                    </button>
                                </td>
                                <td><?php echo $p->produk_name; ?></td>
                                <td><?php echo $p->unit_name; ?></td>
                                <td align="right"><?php echo number_format($p->produk_total, 0, '.', ','); ?></td>
                            </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn yellow" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                </div>
            </form>
        </div>        
    </div>    
</div>

<!-- Edit Item Form -->
<div class="modal bs-modal-lg" id="edititem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('rawat/tindakan/updatedataitem/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" name="form2">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" class="form-control detail_id" name="id">
            <input type="hidden" class="item_jasa_tempat" name="jasa_tempat" id="item_jasa_tempat">
            <input type="hidden" class="item_jasa_dokter" name="jasa_dokter" id="item_jasa_dokter">
            <input type="hidden" class="item_jasa_perawat" name="jasa_perawat" id="item_jasa_perawat">
            <input type="hidden" class="item_jasa_lain" name="jasa_lain" id="item_jasa_lain">

            <input type="hidden" name="total_jasa_tempat" id="item_total_jasa_tempat">
            <input type="hidden" name="total_jasa_dokter" id="item_total_jasa_dokter">
            <input type="hidden" name="total_jasa_perawat" id="item_total_jasa_perawat">
            <input type="hidden" name="total_jasa_lain" id="item_total_jasa_lain">
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Form Edit Tindakan</h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">ID Produk</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control item_code" name="code" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Nama Tindakan</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control item_name" name="name" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Nama Dokter</label>                    
                    <div class="col-md-9">
                        <select class="form-control item_dokter" name="dokter_id" id="dokter_id" required>
                            <option value="">- Pilih Dokter -</option>
                            <?php 
                            foreach($listDokter as $d) {                                
                            ?>
                            <option value="<?php echo $d->dokter_id; ?>"><?php echo $d->dokter_name; ?></option>
                            <?php                                
                            } 
                            ?>
                        </select>  
                    </div>                            
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Tgl. Input</label>
                    <div class="col-md-4">
                        <input class="form-control form-control-inline input-medium date-picker item_tanggal" size="16" type="text" name="tgl_trans" placeholder="DD-MM-YYYY" autocomplete="off" required />
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Qty</label>
                    <div class="col-md-2">
                        <input type="number" class="form-control item_qty" name="qty" id="item_qty" onkeydown="HitungSubTotalItem()" autocomplete="off" required>
                        <div class="form-control-focus"></div>
                    </div>
                </div>                
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Harga</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control item_harga" name="harga" id="item_harga" onkeydown="HitungSubTotalItem()" autocomplete="off" required>
                        <div class="form-control-focus"></div>
                    </div>
                </div>                
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Sub Total</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control item_subtotal" name="subtotal" id="item_subtotal" autocomplete="off" readonly>
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

<!-- Pembayaran -->
<div class="modal fade" id="bayar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form action="<?php echo site_url('rawat/tindakan/updatedata/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" name="form3">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-check-circle"></i> Pembayaran Kwitansi Pasien</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">No. Kwitansi</label>
                                <div class="col-md-8">                                                
                                    <input type="text" class="form-control" name="no_lpb" value="<?php echo $KodePB; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Tanggal Faktur</label>
                                <div class="col-md-5">                                                
                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tgl_faktur" value="<?php echo date('d-m-Y'); ?>" placeholder="DD-MM-YYYY" autocomplete="off" required />
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
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


<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Pendaftaran <small>Tindakan Pasien</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('rawat/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pendaftaran</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?php echo site_url('rawat/tindakan'); ?>">Tindakan Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tambah Tindakan Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">No. Transaksi : <?php echo $this->uri->segment(6); ?></a>                    
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus-square"></i> Form Tambah Tindakan Pasien
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php 
                        $tgl_trans  = $detail_pasien->rawat_date;

                        if (!empty($tgl_trans)) {
                            $mtgl       = explode("-",$tgl_trans);
                            $thn        = $mtgl[0];
                            $bln        = $mtgl[1];
                            $tgl        = $mtgl[2];
                            $tanggal_tr = $tgl.'-'.$bln.'-'.$thn;
                        } else { 
                            $tanggal_tr       = '';
                        }
                        ?>
                        <div class="invoice">
                            <div class="row invoice-logo">
                                <div class="col-xs-6">
                                    <p><b>TOTAL</b></p>
                                </div>  
                                <div class="col-xs-6">
                                <p>                                
                                <b><?php echo number_format($Total, 0, '.', ','); ?></b>
                                <span class="muted">No. Transaksi : <b><?php echo $this->uri->segment(6); ?> / <?php echo $tanggal_tr; ?></b></span>
                                </p>
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
                
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form role="form">
                            <div class="form-body">                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail_pasien->pasien_nama.' - '.$detail_pasien->pasien_no_rm; ?>" readonly>
                                                <label for="form_control_1">Nama Pasien</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail_pasien->pasien_alamat; ?>" readonly>
                                                <label for="form_control_1">Alamat</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail_pasien->dokter_name; ?>" readonly>
                                                <label for="form_control_1">Dokter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail_pasien->pelanggan_name.' - '.$detail_pasien->kelompok_name; ?>" readonly>
                                                <label for="form_control_1">Pelanggan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail_pasien->jenis_name; ?>" readonly>
                                                <label for="form_control_1">Jenis Tarif</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $detail_pasien->poliklinik_name; ?>" readonly>
                                                <label for="form_control_1">Polklinik</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('rawat/tindakan/savedataitem/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="dokter_id" value="<?php echo $detail_pasien->dokter_id; ?>">
                        <input type="hidden" class="jasa_tempat" name="jasa_tempat" id="jasa_tempat">
                        <input type="hidden" class="jasa_dokter" name="jasa_dokter" id="jasa_dokter">
                        <input type="hidden" class="jasa_perawat" name="jasa_perawat" id="jasa_perawat">
                        <input type="hidden" class="jasa_lain" name="jasa_lain" id="jasa_lain">
                        <input type="hidden" name="total_jasa_tempat" id="total_jasa_tempat">
                        <input type="hidden" name="total_jasa_dokter" id="total_jasa_dokter">
                        <input type="hidden" name="total_jasa_perawat" id="total_jasa_perawat">
                        <input type="hidden" name="total_jasa_lain" id="total_jasa_lain">
                        
                            <div class="form-body">                                
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input">
                                            <div class="input-group">
                                                <div class="input-group-control">                   
                                                    <input type="text" class="form-control produk_id" id="produk_id" name="produk_id" placeholder="Kode Produk" onkeydown="HitungSubTotal()" required>
                                                    <label for="form_control_1">Cari Kode</label>
                                                </div>
                                                <span class="input-group-btn btn-right">
                                                    <a data-toggle="modal" href="#additem" title="Klik untuk Cari Data">
                                                        <button class="btn blue-madison" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>                                  
                                    </div>                                    
                                    <div class="col-md-5">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control produk_name" placeholder="Uraian" name="produk_name" id="produk_name" readonly>
                                                <label for="form_control_1">Uraian</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group">
                                                <div class="input-group-control">
                                                    <input type="number" class="form-control produk_qty" name="produk_qty" id="produk_qty" value="<?php echo set_value('produk_qty', 0); ?>" onkeydown="HitungSubTotal()" autocomplete="off" required>
                                                    <label for="form_control_1">Qty</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control produk_harga" id="produk_harga" name="produk_harga" value="<?php echo set_value('produk_harga', 0); ?>" onkeydown="HitungSubTotal()" readonly>
                                                <label for="form_control_1">Harga</label>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control produk_subtotal" id="produk_subtotal" name="produk_subtotal" value="<?php echo set_value('produk_subtotal', 0); ?>" readonly>
                                                <label for="form_control_1">Sub Total</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green submit" id="SaveItem"><i class="fa fa-plus-circle"></i> Tambah Tindakan</button>
                                        <button type="button" class="btn blue simpan" data-toggle="modal" data-target="#bayar" title="Pembayaran"><i class="fa fa-floppy-o"></i> Bayar
                                        </button>
                                        <a href="<?php echo site_url('rawat/tindakan/bhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" class="btn purple"><i class="fa fa-medkit"></i> BHP</a>
                                        <a href="<?php echo site_url('rawat/tindakan/bhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" class="btn red"><i class="fa fa-print"></i> Print Billing</a>
                                        <a href="<?php echo site_url('rawat/tindakan'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>                                        
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
                                                <th width="5%">Kode</th>
                                                <th>Uraian</th>
                                                <th width="10%">Tanggal</th>
                                                <th width="10%">Harga</th>
                                                <th width="5%">Qty</th>
                                                <th width="10%">Sub Total</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach($listTindakan as $i) {
                                                $detail_id = $i->detail_id;

                                                $tanggal        = $i->detail_date;
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
                                                <td><?php echo $i->produk_id; ?></td>               
                                                <td><?php echo $i->detail_name; ?></td>
                                                <td align="center"><?php echo $date; ?></td>
                                                <td align="right"><?php echo number_format($i->detail_harga, 0, '.', ','); ?></td>
                                                <td align="right"><?php echo $i->detail_qty; ?></td>
                                                <td align="right"><?php echo number_format($i->detail_total, 0, '.', ','); ?></td>
                                                <td align="center">
                                                    <button type="button" class="btn btn-primary btn-xs edit_item" data-toggle="modal" data-target="#edititem" data-id="<?php echo $i->detail_id; ?>" data-code="<?php echo $i->produk_id; ?>" data-name="<?php echo $i->detail_name; ?>" data-qty="<?php echo $i->detail_qty; ?>" data-harga="<?php echo number_format($i->detail_harga, 0, '.', ','); ?>" data-subtotal="<?php echo number_format($i->detail_total, 0, '.', ','); ?>" data-tgl="<?php echo $i->detail_date; ?>" data-dokter="<?php echo $i->dokter_id; ?>" data-jstempat="<?php echo $i->produk_js_tempat; ?>" data-jsdokter="<?php echo $i->produk_js_dokter; ?>" data-jsperawat="<?php echo $i->produk_js_perawat; ?>" data-jslain="<?php echo $i->produk_js_lain; ?>" title="Edit Data"><i class="icon-pencil"></i>
                                                    </button>
                                                    <a onclick="hapusDataItem(<?php echo $detail_id; ?>)"><button class="btn btn-danger btn-xs" title="Hapus Data"><i class="icon-trash"></i></button>
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
                </div>
                <!--
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="well">                                
                            <div class="row static-info align-reverse">
                                <div class="col-md-8 name">Grand Total :</div>
                                <div class="col-md-3 value"></div>
                            </div>
                        </div>
                    </div>
                </div>                
                -->
            </div>
        </div>

    </div>            
</div>