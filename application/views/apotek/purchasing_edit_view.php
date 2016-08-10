<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/sweetalert2.css">
<script src="<?php echo base_url(); ?>js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.min.js"></script>
<script>
    function hapusDataItem(purc_detail_id) {
        var id = purc_detail_id;
        swal({
            title: 'Hapus Item ?',
            text: 'Data ini Akan di Hapus !',type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: true
        }, function() {
            window.location.href="<?php echo site_url('apotek/purchasing/deletedataitemedit/'.$this->uri->segment(4)); ?>"+"/"+id
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
    $('#harga').maskMoney({thousands:',', decimal:'.', precision:0});
    $('#subtotal').maskMoney({thousands:',', decimal:'.', precision:0});
    $('#item_harga').maskMoney({thousands:',', decimal:'.', precision:0});
    $('#item_subtotal').maskMoney({thousands:',', decimal:'.', precision:0});
});
</script>

<script language="JavaScript" type="text/JavaScript">
function mySupplier() { 
    var x           = document.getElementById("lstSuplier"); 
    var Address     = x.options[(x.selectedIndex)].getAttribute('data-address');
    var Phone       = x.options[(x.selectedIndex)].getAttribute('data-phone');
    var City        = x.options[(x.selectedIndex)].getAttribute('data-city');
    var Termin      = x.options[(x.selectedIndex)].getAttribute('data-termin');
    document.getElementById("address").value = Address;
    document.getElementById("phone").value   = Phone;
    document.getElementById("city").value   = City;
    document.getElementById("termin").value  = Termin;    
}
</script>

<script type="text/javascript">
$(function() {
    $(document).on("click",'.pilih_item', function(e) {        
        var code    = $(this).data('code');
        var name    = $(this).data('name');
        var harga   = $(this).data('harga');
        var satuan   = $(this).data('satuan');        
        $(".obat_code").val(code);
        $(".obat_name").val(name);
        $(".obat_qty").val(1);
        $(".obat_harga").val(harga);
        $(".obat_satuan").val(satuan);
        $(".obat_subtotal").val(harga);
    })
});
</script>

<script type="text/javascript">
$(function() {
    $(document).on("click",'.pilih_satuan', function(e) {        
        var code    = $(this).data('code');        
        $(".satuan_code").val(code);        
    })
});
</script>

<script type="text/javascript">
function checktxtbox(){
    if(document.form1.code.value != '' && document.form1.qty.value != 0){
        document.form1.butn.disabled=false;
    }
    else{
        document.form1.butn.disabled=true;
    }

    var myForm      = document.form1;
    var Qty         = myForm.qty.value;
    Qty             = Qty.replace(/[,]/g, ''); // Ini String
    Qty             = parseInt(Qty); // Ini Integer
    var Harga       = myForm.harga.value;
    Harga           = Harga.replace(/[,]/g, ''); // Ini String
    Harga           = parseInt(Harga); // Ini Integer    

    var SubTotal    = (Qty*Harga);    
    if (SubTotal > 0) {
        myForm.subtotal.value = SubTotal; 
    } else {
        myForm.subtotal.value = 0;
    }       
}
</script>

<script type="text/javascript">
function HitungSubTotalItem(){
    var myForm2     = document.form2;
    var Qty         = myForm2.item_qty.value;
    Qty             = Qty.replace(/[,]/g, ''); // Ini String
    Qty             = parseInt(Qty); // Ini Integer
    var Harga       = myForm2.item_harga.value;
    Harga           = Harga.replace(/[,]/g, ''); // Ini String
    Harga           = parseInt(Harga); // Ini Integer    

    var SubTotal    = (Qty*Harga);    
    if (SubTotal > 0) {
        myForm2.item_subtotal.value = SubTotal; 
    } else {
        myForm2.item_subtotal.value = 0;
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
            var subtotal    = $(this).data('subtotal');
            $(".purc_detail_id").val(id);
            $(".item_code").val(code);
            $(".item_name").val(name);
            $(".item_qty").val(qty);
            $(".item_satuan").val(satuan);
            $(".item_harga").val(harga);
            $(".item_subtotal").val(subtotal);
        })
    });
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
                                <th width="12%">Kode</th>                                
                                <th>Nama Obat</th>
                                <th width="10%">Hrg Kemasan</th>
                                <th width="10%">Sat Kemasan</th>
                                <th width="10%">Hrg Kecil</th>
                                <th width="5%">Isi</th>
                                <th width="10%">Sat Kecil</th>
                                <th width="5%">Stok</th>                                
                            </tr>
                        </thead>
                            
                        <tbody>
                        <?php 
                            $no = 1;
                            foreach($listObat as $r) {                            
                            ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs pilih_item" data-toggle="modal" data-code="<?php echo $r->obat_code; ?>" data-name="<?php echo $r->obat_name; ?>" data-harga="<?php echo $r->obat_hrg_kms; ?>" data-satuan="<?php echo $r->obat_sat_kms; ?>" title="Pilih Data" data-dismiss="modal"><i class="icon-check"></i> Pilih
                                    </button>
                                </td>
                                <td><?php echo $r->obat_code; ?></td>
                                <td><?php echo $r->obat_name; ?></td>
                                <td align="right"><?php echo number_format($r->obat_hrg_kms, 0, '.', ','); ?></td>
                                <td><?php echo $r->obat_sat_kms; ?></td>
                                <td align="right"><?php echo number_format($r->obat_hrg_kcl, 0, '.', ','); ?></td>
                                <td align="right"><?php echo number_format($r->obat_isi_kcl, 0, '.', ','); ?></td>
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

<!-- List Satuan -->
<div class="modal fade" id="pilihsatuan" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-search"></i> Pilih Satuan</h4>
            </div>
            
            <div class="modal-body">
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Kode Obat</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control satuan_code" placeholder="Enter Kode Obat" name="code" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Nama Obat</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control satuan_name" placeholder="Enter Nama Obat" name="name" autocomplete="off" readonly>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="15%">Pilih</th>
                                <th>Satuan</th>
                                <th width="15%">Isi Satuan</th>
                                <th width="20%">Harga Satuan</th>    
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center"></td>
                                <td></td>
                                <td align="right"></td>
                                <td align="right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>                
            </div>

            <div class="modal-footer">
            </div>            
        </div>
    </div>
</div>

<!-- Edit Item Form -->
<div class="modal bs-modal-lg" id="edititem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('apotek/purchasing/updatedataitemedit/'.$this->uri->segment(4)); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" name="form2">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" class="form-control purc_detail_id" name="id">
                        
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
                    <div class="col-md-4">
                        <input type="text" class="form-control item_satuan" name="satuan" onkeydown="HitungSubTotalItem()" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Harga</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control item_harga" name="harga" id="item_harga" onkeydown="HitungSubTotalItem()" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label">Sub Total</label>
                    <div class="col-md-4">
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
            <form action="<?php echo site_url('apotek/purchasing/updatedata/'.$this->uri->segment(4)); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-check-circle"></i> Simpan Data Purchase</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">No. Purchase</label>
                                <div class="col-md-8">                                                
                                    <input type="text" class="form-control" name="no_purchase" value="<?php echo $detail->purchase_no; ?>" autocomplete="off" required readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $tanggal        = $detail->purchase_date;
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
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Tgl. Purchase</label>
                                <div class="col-md-5">                                                
                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="date" value="<?php echo $date; ?>" placeholder="DD-MM-YYYY" autocomplete="off" readonly />
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Suplier</label>
                                <div class="col-md-8">
                                    <select class="form-control" data-placeholder="Pilih Suplier" name="lstSuplier" id="lstSuplier" onchange="mySupplier()" required autofocus>
                                        <option value="">- Pilih Suplier -</option>
                                        <?php 
                                        foreach($listSuplier as $s) {
                                            if ($detail->suplier_id == $s->suplier_id) {
                                        ?>
                                        <option value="<?php echo $s->suplier_id; ?>" <?php echo set_select('lstSuplier', $s->suplier_id); ?> data-address="<? echo $s->suplier_address; ?>" data-phone="<? echo $s->suplier_phone; ?>" data-city="<? echo $s->suplier_city; ?>" data-termin="<? echo $s->suplier_termin; ?>" selected><?php echo $s->suplier_name; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $s->suplier_id; ?>" <?php echo set_select('lstSuplier', $s->suplier_id); ?> data-address="<? echo $s->suplier_address; ?>" data-phone="<? echo $s->suplier_phone; ?>" data-city="<? echo $s->suplier_city; ?>" data-termin="<? echo $s->suplier_termin; ?>"><?php echo $s->suplier_name; ?></option>
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
                                <label class="col-md-4 control-label" for="form_control_1">Alamat</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $detail->suplier_address; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">No. Telp</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $detail->suplier_phone; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Kota</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $detail->suplier_city; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Termin (Hari)</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="termin" id="termin" value="<?php echo $detail->purchase_termin; ?>" autocomplete="off" readonly>
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">Keterangan</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo $detail->purchase_ket; ?>" placeholder="Enter Keterangan" autocomplete="off">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label" for="form_control_1">TOTAL</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="total" id="total" value="<?php echo number_format($Total, 0, '.', ','); ?>" autocomplete="off" readonly>
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
            Transaksi <small>Purchasing</small>
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
                    <a href="<?php echo site_url('apotek/purchasing'); ?>">Purchasing</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Edit Purchasing</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i> Form Edit Purchasing
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
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
                                    <span class="muted">No. Purchase : <b><?php echo $detail->purchase_no; ?> / <?php echo $date; ?></b></span>
                                </p>
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('apotek/purchasing/savedataitemedit/'.$this->uri->segment(4)); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id" value="<?php echo $detail->purchase_id; ?>">                        

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
                                    <div class="col-md-3">
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
                                                <span class="input-group-btn btn-right">
                                                    <button class="btn blue-madison pilih_satuan" type="button" data-toggle="modal" data-target="#pilihsatuan" title="Pilih Satuan" id="butn" name="butn" disabled>
                                                        <i class="fa fa-search"></i>
                                                    </button>                                                    
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control obat_harga" id="harga" name="harga" value="<?php echo set_value('harga', 0); ?>" onkeydown="checktxtbox()" readonly>
                                                <label for="form_control_1">Harga</label>
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
                                        <a href="<?php echo site_url('apotek/purchasing'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>                                        
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
                                    <i class="fa fa-list"></i>Daftar Obat
                                </div>                                                        
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">Kode</th>
                                                <th>Nama Obat</th>
                                                <th width="5%">Qty</th>
                                                <th width="10%">Satuan</th>
                                                <th width="15%">Harga</th>
                                                <th width="15%">Sub Total</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach($listItem as $i) {
                                                $purc_detail_id = $i->purc_detail_id;
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $i->obat_code; ?></td>
                                                <td><?php echo $i->purc_detail_name; ?></td>
                                                <td><?php echo $i->purc_detail_qty; ?></td>
                                                <td><?php echo $i->purc_detail_satuan; ?></td>      
                                                <td align="right"><?php echo number_format($i->purc_detail_harga, 0, '.', ','); ?></td>                                                
                                                <td align="right"><?php echo number_format($i->purc_detail_subtotal, 0, '.', ','); ?></td>
                                                <td align="center">
                                                    <button type="button" class="btn btn-primary btn-xs edit_item" data-toggle="modal" data-target="#edititem" data-id="<?php echo $i->purc_detail_id; ?>" data-code="<?php echo $i->obat_code; ?>" data-name="<?php echo $i->purc_detail_name; ?>" data-qty="<?php echo $i->purc_detail_qty; ?>" data-satuan="<?php echo $i->purc_detail_satuan; ?>" data-harga="<?php echo $i->purc_detail_harga; ?>" data-subtotal="<?php echo $i->purc_detail_subtotal; ?>" title="Edit Data"><i class="icon-pencil"></i>
                                                    </button>
                                                    <a onclick="hapusDataItem(<?php echo $purc_detail_id; ?>)"><button class="btn btn-danger btn-xs" title="Hapus Data"><i class="icon-trash"></i></button>
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