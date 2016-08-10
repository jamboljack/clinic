<script src="<?php echo base_url(); ?>js/jquery.maskMoney.min.js"></script>
<script language="JavaScript" type="text/JavaScript">
$(document).ready(function() {    
    $('#js_tempat').maskMoney({thousands:',', precision:0});
    $('#js_dokter').maskMoney({thousands:',', precision:0});
    $('#js_perawat').maskMoney({thousands:',', precision:0});
    $('#js_lain').maskMoney({thousands:',', precision:0});
    $('#harga').maskMoney({thousands:',', precision:0});
});
</script>

<script language="JavaScript" type="text/JavaScript">
function hitung() {
    var myForm  = document.form1;
    var Tempat  = myForm.js_tempat.value;
    Tempat      = Tempat.replace(/[,]/g, ''); // Ini String
    Tempat      = parseInt(Tempat); // Ini Integer
    var Dokter  = myForm.js_dokter.value;
    Dokter      = Dokter.replace(/[,]/g, ''); // Ini String
    Dokter      = parseInt(Dokter); // Ini Integer
    var Perawat = myForm.js_perawat.value;
    Perawat     = Perawat.replace(/[,]/g, ''); // Ini String
    Perawat     = parseInt(Perawat); // Ini Integer
    var Lain    = myForm.js_lain.value;
    Lain        = Lain.replace(/[,]/g, ''); // Ini String
    Lain        = parseInt(Lain); // Ini Integer

    var Total  = (Tempat+Dokter+Perawat+Lain);
    if (Total > 0) {
        myForm.harga.value = Total; 
    } else {
        myForm.harga.value = 0;
    }    
}
</script>

<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Master Tarif <small>Produk</small>
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
                    <a href="<?php echo site_url('admin/produk'); ?>">Produk</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Edit Produk</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i> Form Edit Produk
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('admin/produk/updatedata'); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id" value="<?php echo $detail->produk_id; ?>" />

                            <div class="form-body">                                
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Nama Produk</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="form_control_1" placeholder="Enter Nama Produk" name="name" value="<?php echo $detail->produk_name; ?>" autocomplete="off" required autofocus>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Jenis Tarif</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name='lstJenis' required>
                                            <option value="">- Pilih Jenis Tarif -</option>
                                            <?php 
                                                foreach($listJenis as $r) { 
                                                    if ($detail->jenis_id==$r->jenis_id) {
                                            ?>
                                            <option value="<?php echo $r->jenis_id; ?>" selected><?php echo $r->jenis_name; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $r->jenis_id; ?>"><?php echo $r->jenis_name; ?></option>
                                            <?php }
                                            } 
                                            ?>
                                        </select>
                                    </div>                      
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Unit</label>
                                    <div class="col-md-10">
                                        <select class="select2_category form-control" name='lstUnit' required>
                                            <option value="">- Pilih Unit -</option>
                                            <?php 
                                                foreach($listUnit as $r) {
                                                    if ($detail->unit_id==$r->unit_id) {
                                            ?>
                                            <option value="<?php echo $r->unit_id; ?>" selected><?php echo $r->unit_name; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $r->unit_id; ?>"><?php echo $r->unit_name; ?></option>
                                            <?php } 
                                            } 
                                            ?>
                                        </select>
                                    </div>                      
                                </div>
                                <h4 class="form-section">Komponen Harga</h4>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Jasa Tempat</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="js_tempat" id="js_tempat" value="<?php echo number_format($detail->produk_js_tempat, 0, '.', ','); ?>" onkeyup="hitung()" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Jasa Dokter</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="js_dokter" id="js_dokter" value="<?php echo number_format($detail->produk_js_dokter, 0, '.', ','); ?>" onkeyup="hitung()" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Jasa Perawat</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="js_perawat" id="js_perawat" value="<?php echo number_format($detail->produk_js_perawat, 0, '.', ','); ?>" onkeyup="hitung()" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Jasa Lain-Lain</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="js_lain" id="js_lain" value="<?php echo number_format($detail->produk_js_lain, 0, '.', ','); ?>" onkeyup="hitung()" autocomplete="off">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="form_control_1">Total Harga</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="harga" id="harga" value="<?php echo number_format($detail->produk_total, 0, '.', ','); ?>" onkeyup="hitung()" autocomplete="off" readonly>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Update</button>
                                        <a href="<?php echo site_url('admin/produk'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>            
</div>  