<script language="JavaScript" type="text/JavaScript">
function HitungHargaKecil() {
    var myForm        = document.form1;
    var Kemasan       = myForm.sat_kemasan.value;
    var Kms           = Kemasan.toUpperCase();    
    var Kecil         = myForm.sat_kecil.value;
    var Kcl           = Kecil.toUpperCase();
    var Hrg_Kemasan   = parseInt(myForm.hrg_kemasan.value);
    var Isi           = parseInt(myForm.isi_sat_kecil.value);
    
    if (Kms == Kcl) {
        myForm.isi_sat_kecil.value = 1;
        myForm.hrg_kecil.value     = Hrg_Kemasan;        
    } else if (Kms != Kcl) {        
        myForm.hrg_kecil.value     = Hrg_Kemasan/Isi;
    }

    Hrg_Kecil         = parseInt(myForm.hrg_kecil.value);

    if (Kms === '' && Kcl === '' && Hrg_Kemasan === 0) {
        myForm.hrg_pokok.value     = 0;
    } else if (Kms != '' && Kcl === '' && Hrg_Kemasan === 0) {
        myForm.hrg_pokok.value     = 0;
    } else if (Kms != '' && Kcl === '' && Hrg_Kemasan != 0) {
        myForm.hrg_pokok.value     = Hrg_Kemasan;
    } else if (Kms != '' && Kcl != '') {
        myForm.hrg_pokok.value     = Hrg_Kecil;
    }
}
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#lstJenis").select2({
        });

        $("#lstGolongan").select2({
        });

        $("#lstPabrikan").select2({
        });

        $("#lstSuplier").select2({
        });
    });
</script>

<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Master Data <small>Obat</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-bar-chart"></i>
                    <a href="<?php echo site_url('apotek/home'); ?>">Statistik</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Master Data</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?php echo site_url('apotek/obat'); ?>">Obat</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Edit Obat</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Kode : <b><?php echo $detail->obat_code; ?></b></a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i> Form Edit Obat
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('apotek/obat/updatedata'); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id" value="<?php echo $detail->obat_code; ?>" />

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Nama Obat</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter Nama Obat" name="name" value="<?php echo $detail->obat_name; ?>" autocomplete="off" required autofocus>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Merk</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter Merk" name="merk" value="<?php echo $detail->obat_merk; ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Jenis Obat</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Jenis Obat -" name="lstJenis" id="lstJenis" required>
                                                    <option value="">- Pilih Jenis Obat -</option>
                                                    <?php 
                                                    foreach($listJenis as $j) {
                                                        if ($detail->jenis_id==$j->jenis_id) {  
                                                    ?>
                                                    <option value="<?php echo $j->jenis_id; ?>" selected><?php echo $j->jenis_name; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $j->jenis_id; ?>"><?php echo $j->jenis_name; ?></option>
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
                                            <label class="col-md-3 control-label" for="form_control_1">Golongan</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Golongan -" name="lstGolongan" id="lstGolongan" required>
                                                    <option value="">- Pilih Golongan -</option>
                                                    <?php 
                                                    foreach($listGolongan as $g) {
                                                       if ($detail->gol_id==$g->gol_id) {  
                                                    ?>
                                                    <option value="<?php echo $g->gol_id; ?>" selected><?php echo $g->gol_name; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $g->gol_id; ?>"><?php echo $g->gol_name; ?></option>
                                                    <?php 
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>                      
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Pabrikan</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Pabrikan -" name="lstPabrikan" id="lstPabrikan" required>
                                                    <option value="">- Pilih Pabrikan -</option>
                                                    <?php 
                                                    foreach($listPabrikan as $p) {
                                                        if ($detail->pabrikan_id==$p->pabrikan_id) { 
                                                    ?>
                                                    <option value="<?php echo $p->pabrikan_id; ?>" selected><?php echo $p->pabrikan_name; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $p->pabrikan_id; ?>"><?php echo $p->pabrikan_name; ?></option>
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
                                            <label class="col-md-3 control-label" for="form_control_1">Suplier</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Suplier -" name="lstSuplier" id="lstSuplier" required>
                                                    <option value="">- Pilih Suplier -</option>
                                                    <?php 
                                                    foreach($listSuplier as $s) {
                                                        if ($detail->suplier_id==$s->suplier_id) { 
                                                    ?>
                                                    <option value="<?php echo $s->suplier_id; ?>" selected><?php echo $s->suplier_name; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $s->suplier_id; ?>"><?php echo $s->suplier_name; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>                      
                                        </div>
                                    </div>
                                </div>                                
                                <h4 class="form-section">Harga Beli</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Satuan Kemasan</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Satuan Kemasan" name="sat_kemasan" id="sat_kemasan" onkeyup="HitungHargaKecil()" value="<?php echo $detail->obat_sat_kms; ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                                <span class="help-block">Harus DIISI.</span>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Satuan Kecil</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Satuan Kecil" name="sat_kecil" id="sat_kecil" onkeyup="HitungHargaKecil()" value="<?php echo $detail->obat_sat_kcl; ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                                <span class="help-block">Harus DIISI.</span>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Harga Kemasan (Rp)</label>
                                            <div class="col-md-5">
                                                <input type="number" class="form-control" name="hrg_kemasan" id="hrg_kemasan" value="<?php echo $detail->obat_hrg_kms; ?>" onkeyup="HitungHargaKecil()" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                     
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Isi Satuan Kecil</label>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="isi_sat_kecil" id="isi_sat_kecil" value="<?php echo $detail->obat_isi_kcl; ?>" onkeyup="HitungHargaKecil()" autocomplete="off" required>
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
                                            <label class="col-md-4 control-label" for="form_control_1">Harga Kecil (Rp)</label>
                                            <div class="col-md-5">
                                                <input type="number" class="form-control" name="hrg_kecil" id="hrg_kecil" value="<?php echo $detail->obat_hrg_kcl; ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <h4 class="form-section">Stok dan Harga Pokok</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Stok Obat</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="stok" id="stok" value="<?php echo $detail->obat_stok; ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Harga Pokok</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="hrg_pokok" id="hrg_pokok" value="<?php echo $detail->obat_hpp; ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <h4 class="form-section">Batasan Stok</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Qty Minimal</label>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="minimal" value="<?php echo $detail->obat_min_qty; ?>" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Qty Maksimal</label>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="maximal" value="<?php echo $detail->obat_max_qty; ?>" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-checkboxes">
                                            <label class="col-md-2 control-label" for="form_control_1">Karakter Obat</label>
                                            <div class="md-checkbox-inline col-md-10">
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="chkGenerik" class="md-check" name="chkGenerik" value="1" <?php if ($detail->obat_st_generik == 1) { echo 'checked'; } ?>>
                                                    <label for="chkGenerik">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Generik
                                                    </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="chkBPJS" class="md-check" name="chkBPJS" value="1" <?php if ($detail->obat_st_bpjs == 1) { echo 'checked'; } ?>>
                                                    <label for="chkBPJS">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> BPJS
                                                    </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="chkAditif" class="md-check" name="chkAditif" value="1" <?php if ($detail->obat_st_adiktif == 1) { echo 'checked'; } ?>>
                                                    <label for="chkAditif">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Zat Adiktif
                                                    </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="chkDrop" class="md-check" name="chkDrop" value="1" <?php if ($detail->obat_st_drop == 1) { echo 'checked'; } ?>>
                                                    <label for="chkDrop">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Dropping
                                                    </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="chkStatus" class="md-check" name="chkStatus" value="1" <?php if ($detail->obat_st_aktif == 1) { echo 'checked'; } ?>>
                                                    <label for="chkStatus">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Aktif / Masih di Pakai
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-2 control-label" for="form_control_1">Zat Aktif</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="zat_aktif" value="<?php echo $detail->obat_zat_aktif; ?>" placeholder="Enter Zat Aktif" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="form-section">Harga Jual</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Kemasan Grosir</label>
                                            <div class="col-md-5">
                                                <input type="number" class="form-control" name="kms_grosir" value="<?php echo $detail->obat_hrg_kms_g; ?>" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Kecil Grosir</label>
                                            <div class="col-md-5">
                                                <input type="number" class="form-control" name="kcl_grosir" value="<?php echo $detail->obat_hrg_kcl_g; ?>" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Kemasan Eceran</label>
                                            <div class="col-md-5">
                                                <input type="number" class="form-control" name="kms_eceran" value="<?php echo $detail->obat_hrg_kms_e; ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>                                    
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Kecil Eceran</label>
                                            <div class="col-md-5">
                                                <input type="number" class="form-control" name="kcl_eceran" value="<?php echo $detail->obat_hrg_kcl_e; ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Update</button>
                                        <a href="<?php echo site_url('apotek/obat'); ?>" class="btn yellow"><i class="fa fa-times"></i> Batal</a>
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