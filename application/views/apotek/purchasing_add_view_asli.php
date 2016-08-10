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
    $(document).on("click",'.edit_button', function(e) {        
        var code    = $(this).data('code');
        var name    = $(this).data('name');
        var harga   = $(this).data('harga');
        var satuan   = $(this).data('satuan');        
        $(".obat_code").val(code);
        $(".obat_name").val(name);
        $(".obat_qty").val(1);
        $(".obat_harga").val(harga);
        $(".obat_satuan").val(satuan);
    })
});
</script>

<script type="text/javascript">
function checktxtbox(){
    if(document.fItem.code.value != '' && document.fItem.qty.value != 0){
        document.fItem.butn.disabled=false;
    }
    else{
        document.fItem.butn.disabled=true;
    }
}
</script>

<!-- CSRF Token -->
<script type="text/javascript">
    var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#lstSuplier").select2({
        });        
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
                                <th width="12%">Kode</th>                                
                                <th>Nama Obat</th>
                                <th width="10%">Hrg Kemasan</th>
                                <th width="10%">Sat Kemasan</th>
                                <th width="10%">Hrg Kecil</th>
                                <th width="5%">Isi</th>
                                <th width="10%">Sat Kecil</th>
                                <th width="5%">Stok</th>
                                <th width="8%">Aksi</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                        <?php 
                            $no = 1;
                            foreach($listObat as $r) {                            
                            ?>
                            <tr>
                                <td><?php echo $r->obat_code; ?></td>
                                <td><?php echo $r->obat_name; ?></td>
                                <td align="right"><?php echo number_format($r->obat_hrg_kms); ?></td>
                                <td><?php echo $r->obat_sat_kms; ?></td>
                                <td align="right"><?php echo number_format($r->obat_hrg_kcl); ?></td>
                                <td align="right"><?php echo number_format($r->obat_isi_kcl); ?></td>
                                <td><?php echo $r->obat_sat_kcl; ?></td>
                                <td align="right"><?php echo number_format($r->obat_stok); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs edit_button" data-toggle="modal" data-code="<?php echo $r->obat_code; ?>" data-name="<?php echo $r->obat_name; ?>" data-harga="<?php echo $r->obat_hrg_kms; ?>" data-satuan="<?php echo $r->obat_sat_kms; ?>" title="Pilih Data" data-dismiss="modal"><i class="icon-check"></i> Pilih
                                    </button>
                                </td>
                            </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
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
                <div class="form-group">                    
                    <label class="col-md-3 control-label">Kode Obat</label>
                    <div class="col-md-9 has-error">
                        <input type="text" class="form-control satuan_code" placeholder="Enter Kode Obat" name="code" autocomplete="off" readonly>
                    </div>
                </div> 
            </div>

            <div class="modal-footer">
            </div>            
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
                    <a href="#">Tambah Purchasing</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus-square"></i> Form Tambah Purchasing
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('apotek/purchasing/savedata'); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Simpan</button>
                                        <a href="<?php echo site_url('apotek/purchasing'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="invoice">
                                <div class="row invoice-logo">
                                    <div class="col-xs-6 invoice-logo-space">                                    
                                    </div>  
                                    <div class="col-xs-6">
                                    <p>
                                    0
                                    </p>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                            -->
                            <div class="form-body">
                                
                                <?php if ($error == 'true') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <b>ERROR !!</b> <br>
                                    <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">No. Purchase</label>
                                            <div class="col-md-9">                                                
                                                <input type="text" class="form-control" name="no_purchase" value="<?php echo $KodePO; ?>" autocomplete="off" required readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-3" for="form_control_1">Date</label>
                                            <div class="col-md-6">
                                                <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="date" value="<?php echo date('d-m-Y'); ?>" placeholder="DD-MM-YYYY" autocomplete="off" required />
                                                <div class="form-control-focus"></div>
                                            </div>                                            
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Suplier</label>
                                            <div class="col-md-9">
                                                <select class="form-control" data-placeholder="Pilih Suplier" name="lstSuplier" id="lstSuplier" onchange="mySupplier()" required autofocus>
                                                    <option value="">- Pilih Suplier -</option>
                                                    <?php 
                                                    foreach($listSuplier as $s) {
                                                    ?>
                                                    <option value="<?php echo $s->suplier_id; ?>" <?php echo set_select('lstSuplier', $s->suplier_id); ?> data-address="<? echo $s->suplier_address; ?>" data-phone="<? echo $s->suplier_phone; ?>" data-city="<? echo $s->suplier_city; ?>" data-termin="<? echo $s->suplier_termin; ?>"><?php echo $s->suplier_name; ?></option>
                                                    <?php
                                                    } 
                                                    ?>
                                                </select>                                        
                                            </div>
                                            <div class="form-control-focus"></div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-3" for="form_control_1">Alamat</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address'); ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-3" for="form_control_1">No. Telp</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-3" for="form_control_1">Kota</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city'); ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-3" for="form_control_1">Termin (Hari)</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="termin" id="termin" value="<?php echo set_value('termin'); ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-3" for="form_control_1">Keterangan</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo set_value('keterangan'); ?>" placeholder="Enter Keterangan" autocomplete="off">
                                                <div class="form-control-focus"></div>
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
                        <form role="form" name="fItem" id="fItem" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="form-body">                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-md-line-input">
                                            <div class="input-group">
                                                <div class="input-group-control">
                                                    <input type="hidden" class="obat_code" id="id">
                                                    <input type="text" class="form-control obat_code" id="code" name="code" placeholder="Kode Obat" onkeydown="checktxtbox()" required>
                                                    <label for="form_control_1">Cari Kode Obat</label>
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
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input"> 
                                            <div class="input-group-control">
                                                <input type="text" class="form-control obat_name" id="name" readonly>
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
                                                    <input type="text" class="form-control obat_satuan" id="satuan" name="satuan" placeholder="Satuan" readonly>
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
                                                <input type="number" class="form-control obat_harga" id="harga" nama="harga" value="<?php echo set_value('harga', 0); ?>" readonly>
                                                <label for="form_control_1">Harga</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green submit" id="SaveItem"><i class="fa fa-plus-circle"></i> Tambah Item</button>                                        
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
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $no; ?></td>
                                                <td>345.50$</td>
                                                <td>345.50$</td>
                                                <td>345.50$</td>
                                                <td>345.50$</td>
                                                <td>345.50$</td>
                                                <td>345.50$</td>                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                </div>

            </div>
        </div>

    </div>            
</div>

<!-- Simpan Item Obat -->
<script>
$(function() {
    $("#fItem").submit(function(e) {
        //dataString      = $("#fItem").serialize();        
        //var obat_code   = $("input#code").val();
        //var obat_name   = $("input#name").val();
        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>" + "apotek/purchasing/savedataitem",
            dataType: 'json',
            data: {
                $("#fItem").serialize(),              
            },

            success: function(data) {
                alert('Successful!');
            }          
        });
        
        e.preventDefault();
        //return false;
        console.log( $(this).serialize() );
    });
});
</script>