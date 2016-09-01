<script type="text/javascript">
    $(document).ready(function () {
        $("#lstDokter").select2({
        });
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.min.js"></script>
<script>
    function hapusDataItemBhp(detail_id) {
        var id = detail_id;
        swal({
            title: 'Hapus Item ?',
            text: 'Data BHP ini Akan di Hapus !',type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: true
        }, function() {
            window.location.href="<?php echo site_url('rawat/tindakan/deletedataitembhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>"+"/"+id
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
    $('#harga').maskMoney({thousands:',', precision:0});
    $('#disc').maskMoney({decimal:'.', precision:2});
    $('#subtotal').maskMoney({thousands:',', precision:0});
    $('#item_harga').maskMoney({thousands:',', precision:0});
    $('#item_disc').maskMoney({decimal:'.', precision:2});
    $('#item_subtotal').maskMoney({thousands:',', precision:0});
    $('#ppn').maskMoney({decimal:'.', precision:2});    
    $('#total_netto').maskMoney({thousands:',', precision:0});
});
</script>

<script language="JavaScript" type="text/JavaScript">
function mySupplier() { 
    var x           = document.getElementById("lstSuplier"); 
    var Address     = x.options[(x.selectedIndex)].getAttribute('data-address');    
    document.getElementById("address").value = Address;    
}
</script>

<script type="text/javascript">
$(function() {
    $(document).on("click",'.pilih_item', function(e) {        
        var code        = $(this).data('code');
        var name        = $(this).data('name');
        var harga_grosir= $(this).data('harga_grosir'); // Satuan Grosir
        var harga_eceran= $(this).data('harga_eceran'); // Satuan Eceran
        var satuan      = $(this).data('satuan');
        var stok        = $(this).data('stok'); // Stok Terakhir
        var hpp         = $(this).data('hpp'); // Harga Pokok Obat
        var kelompok    = $(this).data('kelompok'); // Status Kelompok Harga        
        $(".obat_code").val(code);
        $(".obat_name").val(name);
        $(".obat_qty").val(1);        
        if (kelompok === 'E') { // Jika Eceran, Harga Eceran
            $(".obat_harga").val(harga_eceran);
            $(".obat_subtotal").val(harga_eceran);
        } else { // Jika Grosir, Harga Grosir
            $(".obat_harga").val(harga_grosir);
            $(".obat_subtotal").val(harga_grosir);
        }
        $(".obat_satuan").val(satuan);
        $(".obat_disc").val(0.00);
        $(".obat_stok").val(stok);
        $(".obat_hpp").val(hpp);
    })
});
</script>

<script type="text/javascript">
function checktxtbox(){
    var myForm      = document.form1;
    var Qty         = parseFloat(myForm.qty.value);
    var Harga       = myForm.harga.value;
    Harga           = Harga.replace(/[,]/g, ''); // Ini String
    Harga           = parseInt(Harga); // Ini Integer
    var Disc        = parseFloat(myForm.disc.value); // Float Desimal    
    var TotalnoDisc = (Qty * Harga);

    if (Disc != 0) {        
        var DiscRp  = (Disc*TotalnoDisc/100);
    } else {        
        myForm.disc.value = 0.00;
        var DiscRp  = 0;
    }

    var SubTotal    = ((Qty*Harga)-DiscRp);    
    if (SubTotal > 0) {
        myForm.subtotal.value = SubTotal; 
    } else {
        myForm.subtotal.value = 0;
    }
}
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#lstSuplier").select2({
        });        
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on("click",'.edit_item', function(e) {
            var id          = $(this).data('id');
            var code        = $(this).data('code');          
            var name        = $(this).data('name');
            var qty         = $(this).data('qty');
            var satuan      = $(this).data('satuan');
            var harga       = $(this).data('harga');
            var disc        = $(this).data('disc');
            var subtotal    = $(this).data('subtotal');            
            var stok        = $(this).data('stok');
            $(".detail_id").val(id);
            $(".item_code").val(code);
            $(".item_name").val(name);
            $(".item_qty").val(qty);
            $(".item_satuan").val(satuan);
            $(".item_harga").val(harga);
            $(".item_disc").val(disc);
            $(".item_subtotal").val(subtotal);            
            $(".item_stok").val(stok);
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
    var Disc        = parseFloat(myForm2.item_disc.value); // Float Desimal
    var TotalnoDisc = (Qty * Harga);

    if (Disc != 0) {        
        var DiscRp  = (Disc*TotalnoDisc/100);
    } else {        
        myForm2.disc.value = 0.00;
        var DiscRp  = 0;
    }

    var SubTotal    = ((Qty*Harga)-DiscRp);
    if (SubTotal > 0) {
        myForm2.item_subtotal.value = SubTotal; 
    } else {
        myForm2.item_subtotal.value = 0;
    }       
}
</script>

<script type="text/javascript">
function HitungTotalNetto() {
    var myForm3     = document.form3;
    var TotalBruto  = myForm3.total_bruto.value;
    TotalBruto      = TotalBruto.replace(/[,]/g, ''); // Ini String
    TotalBruto      = parseInt(TotalBruto); // Ini Integer    
    var PPN         = parseFloat(myForm3.ppn.value);
    
    if (PPN === 0.00) {
        myForm3.ppn.value   = 0;
        var TotalPPN        = 0; // Jika PPN = 0.00
    } else {
        var TotalPPN        = ((PPN*TotalBruto)/100); // PPN dari Total Bruto    
    }
    
    if (PPN === 0) {        
        myForm3.total_netto.value = TotalBruto;    
    } else {        
        var TotalNetto = (TotalBruto+TotalPPN); // Bruto + PPN + Materai
        myForm3.total_netto.value = TotalNetto;        
    }
}
</script>

<!-- List Daftar Obat -->
<div class="modal bs-modal-lg" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                <div class="modal-header">                      
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-search"></i> Cari Data Obat</h4>
                </div>                                
                
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="8%">Pilih</th>
                                <th width="15%">Kode</th>                                
                                <th>Nama Obat</th>                                
                                <th width="15%">Hrg. Grosir</th>                                
                                <th width="15%">Hrg. Eceran</th>
                                <th width="15%">Satuan</th>
                                <th width="10%">Stok</th>                                
                            </tr>
                        </thead>
                            
                        <tbody>
                        <?php 
                            $no = 1;
                            foreach($listObat as $r) {                            
                            ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs pilih_item" data-toggle="modal" data-code="<?php echo $r->obat_code; ?>" data-name="<?php echo $r->obat_name; ?>" data-satuan="<?php echo $r->obat_sat_kcl; ?>" data-harga_grosir="<?php echo $r->obat_hrg_kcl_g; ?>" data-harga_eceran="<?php echo $r->obat_hrg_kcl_e; ?>" data-stok="<?php echo $r->obat_stok; ?>" data-hpp="<?php echo $r->obat_hpp; ?>" data-kelompok="<?php echo $detail_pasien->kelompok_hrg_obat; ?>" title="Pilih Data" data-dismiss="modal"><i class="icon-check"></i> Pilih
                                    </button>
                                </td>
                                <td><?php echo $r->obat_code; ?></td>
                                <td><?php echo $r->obat_name; ?></td>                                
                                <td align="right"><?php echo number_format($r->obat_hrg_kcl_g, 0, '.', ','); ?></td>
                                <td align="right"><?php echo number_format($r->obat_hrg_kcl_e, 0, '.', ','); ?></td>
                                <td><?php echo $r->obat_sat_kcl; ?></td>
                                <td align="right"><?php echo number_format($r->obat_stok, 0, '.', ','); ?></td>
                            </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
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
            <form action="<?php echo site_url('rawat/tindakan/updatedataitembhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" name="form2">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" class="form-control detail_id" name="id">
            <input type="hidden" class="form-control item_code" name="code">
            <input type="hidden" class="form-control item_qty" name="qtylama">
            <input type="hidden" class="form-control item_stok" name="stokakhir">            
                        
            <div class="modal-header">                      
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Form Edit Item Obat</h4>
            </div>
            <div class="modal-body">              
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Kode</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control item_code" name="code" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Nama Obat</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control item_name" name="name" autocomplete="off" readonly>
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
                    <label class="col-md-3 control-label">Satuan</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control item_satuan" name="satuan" onkeydown="HitungSubTotalItem()" autocomplete="off" readonly>
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
                    <label class="col-md-3 control-label">Disc (%)</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control item_disc" name="disc" id="item_disc" onkeydown="HitungSubTotalItem()" autocomplete="off" required>
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
            <form action="<?php echo site_url('rawat/tindakan/updatedatabhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" name="form3">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-check-circle"></i> Simpan Biaya Obat & Alkes</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">No. Faktur</label>
                                <div class="col-md-8">                                                
                                    <input type="text" class="form-control" name="no_faktur" value="<?php echo $KodePJ.' - '.$this->uri->segment(6); ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Tanggal Faktur</label>
                                <div class="col-md-5">                                                
                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tgl_faktur" value="<?php echo date('d-m-Y'); ?>" autocomplete="off" required />
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Nama Pasien</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama" value="<?php echo $detail_pasien->pasien_nama.' - '.$detail_pasien->pasien_no_rm; ?>" autocomplete="off">
                                    <div class="form-control-focus"></div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Alamat</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama" value="<?php echo $detail_pasien->pasien_alamat; ?>" autocomplete="off">
                                    <div class="form-control-focus"></div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Nama Dokter</label>
                                <div class="col-md-8">
                                    <select class="select2_category form-control" name="lstDokter" id="lstDokter" required>
                                        <option value="">- Pilih Dokter -</option>
                                        <?php 
                                        foreach($listDokter as $d) {
                                            if ($detail_pasien->dokter_id == $d->dokter_id) {
                                        ?>
                                            <option value="<?php echo $d->dokter_id; ?>" selected><?php echo $d->dokter_name; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $d->dokter_id; ?>"><?php echo $d->dokter_name; ?></option>
                                        <?php
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Poliklinik</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="poliklinik" value="<?php echo $detail_pasien->poliklinik_name; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Pelanggan / Kelompok</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="pelanggan" value="<?php echo $detail_pasien->pelanggan_name.' - '.$detail_pasien->kelompok_name; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Tarif</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="ppn" id="ppn" value="<?php echo $detail_pasien->jenis_name; ?>" autocomplete="off">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1"><b>Status Obat</b></label>
                                <div class="col-md-8">
                                    <select class="form-control" name="lstStatusObat" required>
                                        <option value="">- Pilih Status Obat -</option>
                                        <option value="Resep">Resep</option>
                                        <option value="Non Resep">Non Resep</option>
                                    </select>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1"><b>TOTAL OBAT & ALKES</b></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="total_netto" id="total_netto" value="<?php echo number_format($Total, 0, '.', ','); ?>" autocomplete="off" readonly>
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
            Transaksi Rawat Jalan <small>Tindakan Pasien</small>
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
                    <a href="<?php echo site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>">Tindakan Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tambah BHP Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">No. Transaksi : <b><?php echo $this->uri->segment(6); ?></b></a>                    
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

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-medkit"></i> Tambah BHP Pasien
                        </div>
                    </div>
                    
                    <div class="portlet-body form">                        
                        <div class="invoice">
                            <div class="row invoice-logo">
                                <div class="col-xs-6">
                                    <p><b>TOTAL</b></p>
                                </div>  
                                <div class="col-xs-6">
                                <p>                                
                                <b><?php echo number_format($Total, 0, '.', ','); ?></b>
                                <span class="muted">No. Faktur : <b><?php echo $KodePJ; ?> / <?php echo date('d-m-Y'); ?></b></span>
                                </p>
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>                

                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('rawat/tindakan/savedatabhp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">         
                        <input type="hidden" name="pasien_id" value="<?php echo $detail_pasien->pasien_id; ?>">
                        <input type="hidden" name="dokter_id" value="<?php echo $detail_pasien->dokter_id; ?>">                        
                        <input type="hidden" class="obat_stok" name="stokakhir">
                        <input type="hidden" class="obat_hpp" name="hrg_pokok">                        

                            <div class="form-body">                                
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input">
                                            <div class="input-group">
                                                <div class="input-group-control">                   
                                                    <input type="text" class="form-control obat_code" id="code" name="code" placeholder="Kode Obat" onkeydown="checktxtbox()" required>
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
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control obat_name" name="name" id="name" readonly>
                                                <label for="form_control_1">Nama Obat</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group">
                                                <div class="input-group-control">
                                                    <input type="number" class="form-control obat_qty" name="qty" id="qty" value="<?php echo set_value('qty', 0); ?>" onkeydown="checktxtbox()" autocomplete="off" required>
                                                    <label for="form_control_1">Qty</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group">
                                                <div class="input-group-control">
                                                    <input type="text" class="form-control obat_satuan" id="satuan" name="satuan" placeholder="Satuan" onkeydown="checktxtbox()" readonly>
                                                    <label for="form_control_1">Satuan</label>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control obat_harga" id="harga" name="harga" value="<?php echo set_value('harga', 0); ?>" onkeydown="checktxtbox()" required>
                                                <label for="form_control_1">Harga</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control obat_disc" id="disc" name="disc" value="<?php echo set_value('disc', 0.00); ?>" onkeydown="checktxtbox()">
                                                <label for="form_control_1">Disc(%)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control obat_subtotal" id="subtotal" name="subtotal" value="<?php echo set_value('subtotal', 0); ?>" readonly>
                                                <label for="form_control_1">Sub Total</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green submit" id="SaveItem"><i class="fa fa-plus-circle"></i> Tambah Item</button>
                                        <button type="button" class="btn blue simpan" data-toggle="modal" data-target="#bayar" title="Simpan Data"><i class="fa fa-floppy-o"></i> Simpan
                                        </button>                                        
                                        <a href="<?php echo site_url('rawat/tindakan/id/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>
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
                                    <i class="fa fa-list"></i>Daftar BHP
                                </div>                                                        
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">Kode</th>
                                                <th>Nama BHP</th>                                                
                                                <th width="8%">Qty</th>
                                                <th width="10%">Satuan</th>
                                                <th width="10%">Harga</th>
                                                <th width="5%">Disc(%)</th>
                                                <th width="10%">Sub Total</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach($listItem as $i) {
                                                $detail_id = $i->detail_id;
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $i->obat_code; ?></td>               
                                                <td><?php echo $i->detail_name; ?></td>             
                                                <td><?php echo $i->detail_qty; ?></td>
                                                <td><?php echo $i->detail_satuan; ?></td>      
                                                <td align="right"><?php echo number_format($i->detail_harga, 0, '.', ','); ?></td>
                                                <td align="right"><?php echo number_format($i->detail_disc, 2, '.', ','); ?></td>
                                                <td align="right"><?php echo number_format($i->detail_total, 0, '.', ','); ?></td>
                                                <td align="center">
                                                    <button type="button" class="btn btn-primary btn-xs edit_item" data-toggle="modal" data-target="#edititem" data-id="<?php echo $i->detail_id; ?>" data-code="<?php echo $i->obat_code; ?>" data-name="<?php echo $i->detail_name; ?>" data-qty="<?php echo $i->detail_qty; ?>" data-satuan="<?php echo $i->detail_satuan; ?>" data-harga="<?php echo number_format($i->detail_harga, 0, '.', ','); ?>" data-disc="<?php echo $i->detail_disc; ?>" data-subtotal="<?php echo number_format($i->detail_total, 0, '.', ','); ?>" data-stok="<?php echo $i->obat_stok; ?>" title="Edit Data"><i class="icon-pencil"></i>
                                                    </button>
                                                    <a onclick="hapusDataItemBhp(<?php echo $detail_id; ?>)"><button class="btn btn-danger btn-xs" title="Hapus Data"><i class="icon-trash"></i></button>
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