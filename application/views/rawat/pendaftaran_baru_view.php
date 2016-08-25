<script type="text/javascript">
    $(document).ready(function () {
        $("#lstJK").select2({
        });
        $("#lstWarga").select2({
        });
        $("#lstPoliklinik").select2({
        });
        $("#lstPelanggan").select2({
        });
        $("#lstDokter").select2({
        });        
        $("#lstAsuransi").select2({
        });
        $("#lstIdentitas").select2({
        });
    });
</script>

<script language="JavaScript" type="text/JavaScript">
function myPelanggan() { 
    var x               = document.getElementById("lstPelanggan"); 
    var Kelompok_id     = x.options[(x.selectedIndex)].getAttribute('data-kelompok_id');
    var Kelompok_name   = x.options[(x.selectedIndex)].getAttribute('data-kelompok_name');
    var Jenis_id        = x.options[(x.selectedIndex)].getAttribute('data-jenis_id');
    var Jenis_name      = x.options[(x.selectedIndex)].getAttribute('data-jenis_name');    
    document.getElementById("kelompok_id").value = Kelompok_id;
    document.getElementById("kelompok_name").value = Kelompok_name;
    document.getElementById("jenis_id").value = Jenis_id;
    document.getElementById("jenis_name").value = Jenis_name;    
}
</script>

<script type="text/javascript">
$(function() {
    $(document).on("click",'.pilih_item', function(e) {        
        var provinsi_id     = $(this).data('pid');
        var provinsi_name   = $(this).data('pname');
        var kab_id          = $(this).data('kid');
        var kab_name        = $(this).data('kname');
        var kec_id          = $(this).data('cid');
        var kec_name        = $(this).data('cname');
        var desa_id         = $(this).data('did');
        var desa_name       = $(this).data('dname');
        $(".provinsi_id").val(provinsi_id);
        $(".provinsi_name").val(provinsi_name);
        $(".kab_id").val(kab_id);
        $(".kab_name").val(kab_name);
        $(".kec_id").val(kec_id);
        $(".kec_name").val(kec_name);
        $(".desa_id").val(desa_id);
        $(".desa_name").val(desa_name);
    })
});
</script>

<!-- List Provinsi, Kab, Kec, Desa -->
<div class="modal bs-modal-lg" id="carialamat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                <div class="modal-header">                      
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-search"></i> Cari Data Alamat</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th width="8%">Pilih</th>
                                <th>Desa</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                        <?php 
                            $no = 1;
                            foreach($listAlamat as $a) {                            
                            ?>
                            <tr>
                                <td align="center">
                                    <button type="button" class="btn btn-success btn-xs pilih_item" data-toggle="modal" data-pid="<?php echo $a->provinsi_id; ?>" data-pname="<?php echo $a->provinsi_name; ?>" data-kid="<?php echo $a->kab_id; ?>" data-kname="<?php echo $a->kab_name; ?>" data-cid="<?php echo $a->kec_id; ?>" data-cname="<?php echo $a->kec_name; ?>" data-did="<?php echo $a->desa_id; ?>" data-dname="<?php echo $a->desa_name; ?>" title="Pilih Produk" data-dismiss="modal"><i class="icon-check"></i> Pilih
                                    </button>
                                </td>
                                <td><?php echo $a->desa_name; ?></td>
                                <td><?php echo $a->kec_name; ?></td>
                                <td><?php echo $a->kab_name; ?></td>
                                <td><?php echo $a->provinsi_name; ?></td>
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

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Pendaftaran <small>Pendaftaran Pasien</small>
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
                    <a href="#">Pendaftaran Pasien</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Pasien Baru</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="portlet box red-intense">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus-square"></i> Form Data Pasien Baru
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" action="<?php echo site_url('rawat/pendaftaran/savedatabaru'); ?>" method="post" enctype="multipart/form-data" name="form1">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="provinsi_id" name="provinsi_id">
                        <input type="hidden" class="kab_id" name="kab_id">
                        <input type="hidden" class="kec_id" name="kec_id">
                        <input type="hidden" class="desa_id" name="desa_id">
                        <input type="hidden" name="kelompok_id" id="kelompok_id">
                        <input type="hidden" name="jenis_id" id="jenis_id">

                            <div class="form-body">
                                <?php if ($error == 'true') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <b>ERROR !!</b> <br>
                                    <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                                <h3 class="form-section">Data Personal Pasien</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">No. RM</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Enter No. Rekam Medis" name="no_rm" value="<?php echo $No_RM; ?>" autocomplete="off" required readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Nama Pasien</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter Nama Pasien" name="nama" value="<?php echo set_value('nama'); ?>" autocomplete="off" required autofocus>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Nama Keluarga</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter Nama Keluarga" name="nama_keluarga" value="<?php echo set_value('nama_keluarga'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Jenis Kelamin</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Jenis Kelamin -" name="lstJK" id="lstJK" required>
                                                    <option value="">- Pilih Jenis Kelamin -</option>
                                                    <option value="Laki-Laki" <?php echo set_select('lstJK', 'Laki-Laki'); ?>>Laki-Laki</option>
                                                    <option value="Perempuan" <?php echo set_select('lstJK', 'Perempuan'); ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Tempat Lahir</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter Tempat Lahir" name="tmpt_lahir" value="<?php echo set_value('tmpt_lahir'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Tgl. Lahir</label>
                                            <div class="col-md-6">
                                                <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tgl_lahir" value="<?php echo set_value('tgl_lahir'); ?>" placeholder="DD-MM-YYYY" autocomplete="off" required />
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Alamat</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="3" placeholder="Enter Alamat" name="alamat" value="<?php echo set_value('alamat'); ?>" autocomplete="off" required></textarea>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Status Warga</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Status Warga -" name="lstWarga" id="lstWarga" required>
                                                    <option value="">- Pilih Status Warga -</option>
                                                    <option value="WNI" <?php echo set_select('lstWarga', 'WNI'); ?>>WNI</option>
                                                    <option value="WNA" <?php echo set_select('lstWarga', 'WNA'); ?>>WNA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Kode Pos</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" placeholder="Enter Kode Pos" name="kodepos" value="<?php echo set_value('kodepos'); ?>" pattern='^[0-9]*' maxlength="5" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">No. Telp</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter No. Telp" name="telp" value="<?php echo set_value('telp'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Provinsi</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control provinsi_name" placeholder="Enter Provinsi" name="provinsi" value="<?php echo set_value('provinsi'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="input-group-btn btn-right">
                                                    <a data-toggle="modal" href="#carialamat" title="Klik untuk Cari Data">
                                                        <button class="btn blue-madison" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Kabupaten</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control kab_name" placeholder="Enter Kabupaten" name="kabupaten" value="<?php echo set_value('kabupaten'); ?>" autocomplete="off" required readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Kecamatan</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control kec_name" placeholder="Enter Kecamatan" name="kecamatan" value="<?php echo set_value('kecamatan'); ?>" autocomplete="off" required readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Desa</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control desa_name" placeholder="Enter Desa" name="desa" value="<?php echo set_value('desa'); ?>" autocomplete="off" required readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="form-section">Data Pendaftaran Rawat Jalan</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Tanggal</label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tgl_lahir" value="<?php echo date('d-m-Y'); ?>" placeholder="DD-MM-YYYY" autocomplete="off" required readonly />
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Pelanggan</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Pelanggan -" name="lstPelanggan" id="lstPelanggan" onchange="myPelanggan()" required>
                                                    <option value="">- Pilih Pelanggan -</option>
                                                    <?php
                                                    foreach($listPelanggan as $l) {
                                                    ?>php
                                                    <option value="<?php echo $l->pelanggan_id; ?>" <?php echo set_select('lstPelanggan', $l->pelanggan_id); ?> data-kelompok_id="<?php echo $l->kelompok_id; ?>" data-kelompok_name="<?php echo $l->kelompok_name; ?>" data-jenis_id="<?php echo $l->jenis_id; ?>" data-jenis_name="<?php echo $l->jenis_name; ?>"><?php echo $l->pelanggan_name; ?></option>
                                                    <?php
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
                                            <label class="col-md-3 control-label" for="form_control_1">Kelompok</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="kelompok_name" id="kelompok_name" value="<?php echo set_value('kelompok_name'); ?>" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Jenis Tarif</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="jenis_name" id="jenis_name" value="<?php echo set_value('jenis_name'); ?>" autocomplete="off" readonly>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="form-section">Data Poliklinik & Dokter</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Poliklinik</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Poliklinik -" name="lstPoliklinik" id="lstPoliklinik" required>
                                                    <option value="">- Pilih Poliklinik -</option>
                                                    <?php
                                                    foreach($listPoliklinik as $p) {
                                                    ?>
                                                    <option value="<?php echo $p->poliklinik_id; ?>" <?php echo set_select('lstPoliklinik', $p->poliklinik_id); ?>><?php echo $p->poliklinik_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Nama Dokter</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Nama Dokter -" name="lstDokter" id="lstDokter" required>
                                                    <option value="">- Pilih Nama Dokter -</option>
                                                    <?php
                                                    foreach($listDokter as $d) {
                                                    ?>
                                                    <option value="<?php echo $d->dokter_id; ?>" <?php echo set_select('lstDokter', $d->dokter_id); ?>><?php echo $d->dokter_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="form-section">Data Asuransi dan Identitas</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Nama Asuransi</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Nama Asuransi -" name="lstAsuransi" id="lstAsuransi">
                                                    <option value="">- Pilih Nama Asuransi -</option>
                                                    <?php
                                                    foreach($listAsuransi as $a) {
                                                    ?>
                                                    <option value="<?php echo $a->asuransi_id; ?>" <?php echo set_select('lstAsuransi', $a->asuransi_id); ?>><?php echo $a->asuransi_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">No. Asuransi</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter No. Asuransi" name="no_asuransi" value="<?php echo set_value('no_asuransi'); ?>" autocomplete="off">
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Identitas</label>
                                            <div class="col-md-9">
                                                <select class="select2_category form-control" data-placeholder="- Pilih Identitas -" name="lstIdentitas" id="lstIdentitas" requried>
                                                    <option value="">- Pilih Identitas -</option>
                                                    <?php
                                                    foreach($listIdentitas as $i) {
                                                    ?>
                                                    <option value="<?php echo $i->identitas_id; ?>" <?php echo set_select('lstIdentitas', $i->identitas_id); ?>><?php echo $i->identitas_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">No. Identitas</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Enter No. Identitas" name="no_identitas" value="<?php echo set_value('no_identitas'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="form-section">Data Pendukung</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Agama</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="lstAgama" required>
                                                    <option value="">- Pilih Agama -</option>
                                                    <?php
                                                    foreach($listAgama as $a) {
                                                    ?>
                                                    <option value="<?php echo $a->agama_id; ?>" <?php echo set_select('lstAgama', $a->agama_id); ?>><?php echo $a->agama_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Status</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="lstStatus" required>
                                                    <option value="">- Pilih Status -</option>
                                                    <?php
                                                    foreach($listStatus as $s) {
                                                    ?>
                                                    <option value="<?php echo $s->status_id; ?>" <?php echo set_select('lstStatus', $s->status_id); ?>><?php echo $s->status_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Pendidikan</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="lstDidik" required>
                                                    <option value="">- Pilih Pendidikan -</option>
                                                    <?php
                                                    foreach($listDidik as $d) {
                                                    ?>
                                                    <option value="<?php echo $d->pendidikan_id; ?>" <?php echo set_select('lstDidik', $d->pendidikan_id); ?>><?php echo $d->pendidikan_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Pekerjaan</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="lstKerja" required>
                                                    <option value="">- Pilih Pekerjaan -</option>
                                                    <?php
                                                    foreach($listKerja as $k) {
                                                    ?>
                                                    <option value="<?php echo $k->pekerjaan_id; ?>" <?php echo set_select('lstKerja', $k->pekerjaan_id); ?>><?php echo $k->pekerjaan_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-4 control-label" for="form_control_1">Gol. Darah</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="lstDarah" required>
                                                    <option value="">- Pilih Gol. Darah -</option>
                                                    <?php
                                                    foreach($listDarah as $d) {
                                                    ?>
                                                    <option value="<?php echo $d->darah_id; ?>" <?php echo set_select('lstDarah', $d->darah_id); ?>><?php echo $d->darah_name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="form-section">Data Keluarga</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Ayah</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Nama Ayah" name="nm_ayah" value="<?php echo set_value('nm_ayah'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">Ibu</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Nama Ibu" name="nm_ibu" value="<?php echo set_value('nm_ibu'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-3 control-label" for="form_control_1">No. Telp</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Telp yg di Hubungi" name="telp_hub" value="<?php echo set_value('telp_hub'); ?>" autocomplete="off" required>
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green"><i class="fa fa-floppy-o"></i> Simpan</button>
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
