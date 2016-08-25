<?php
$uri = $this->uri->segment(2);

if ($uri == 'home') {
    $dashboard      = 'active';
    $daftar         = '';
    $span_daftar_1  = '';
    $span_daftar_2  = '';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = '';
    $kasir          = '';
    $pasien         = '';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';    
} elseif ($uri == 'pendaftaran') {
    $dashboard      = '';
    $daftar         = 'active open';
    $span_daftar_1  = '<span class="selected"></span>';
    $span_daftar_2  = 'open';
    $pendaftaran    = 'active';
    $tindakan       = '';
    $resep          = '';
    $kasir          = '';
    $pasien         = '';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';    
} elseif ($uri == 'tindakan') {
    $dashboard      = '';
    $daftar         = 'active open';
    $span_daftar_1  = '<span class="selected"></span>';
    $span_daftar_2  = 'open';
    $pendaftaran    = '';
    $tindakan       = 'active';
    $resep          = '';
    $kasir          = '';
    $pasien         = '';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';    
} elseif ($uri == 'resep') {
    $dashboard      = '';
    $daftar         = 'active open';
    $span_daftar_1  = '<span class="selected"></span>';
    $span_daftar_2  = 'open';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = 'active';
    $kasir          = '';
    $pasien         = '';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';    
} elseif ($uri == 'kasir') {
    $dashboard      = '';
    $daftar         = 'active open';
    $span_daftar_1  = '<span class="selected"></span>';
    $span_daftar_2  = 'open';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = '';
    $kasir          = 'active';
    $pasien         = '';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';
} elseif ($uri == 'pasien') {
    $dashboard      = '';
    $daftar         = 'active open';
    $span_daftar_1  = '<span class="selected"></span>';
    $span_daftar_2  = 'open';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = '';
    $kasir          = '';
    $pasien         = 'active';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';
} elseif ($uri == 'appointment') {
    $dashboard      = '';
    $daftar         = '';
    $span_daftar_1  = '';
    $span_daftar_2  = '';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = '';
    $kasir          = '';
    $pasien         = '';
    $informasi      = 'active open';
    $span_info_1    = '<span class="selected"></span>';
    $span_info_2    = 'open';
    $appointment    = 'active';
    $antrian        = '';    
} elseif ($uri == 'antrian') {
    $dashboard      = '';
    $daftar         = '';
    $span_daftar_1  = '';
    $span_daftar_2  = '';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = '';
    $kasir          = '';
    $pasien         = '';
    $informasi      = 'active open';
    $span_info_1    = '<span class="selected"></span>';
    $span_info_2    = 'open';
    $appointment    = '';
    $antrian        = 'active';
} else {
    $dashboard      = 'active';
    $daftar         = '';
    $span_daftar_1  = '';
    $span_daftar_2  = '';
    $pendaftaran    = '';
    $tindakan       = '';
    $resep          = '';
    $kasir          = '';
    $pasien         = '';
    $informasi      = '';
    $span_info_1    = '';
    $span_info_2    = '';
    $appointment    = '';
    $antrian        = '';    
}

?>
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">         
        <ul class="page-sidebar-menu page-sidebar-menu-light" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">            
            <li class="sidebar-toggler-wrapper">            
               <div class="sidebar-toggler">
               </div>               
            </li>
            <li class="sidebar-search-wrapper">                    
                <form class="sidebar-search">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form>                
            </li>
            <li class="tooltips" data-container="body" data-placement="right" data-html="true" data-original-title="Dashboard">
                <a href="<?php echo site_url('dashboard/home'); ?>">
                    <i class="fa fa-home"></i>
                    <span class="title">
                    Dashboard
                    </span>
                </a>
            </li>
            <li class="tooltips <?php echo $dashboard; ?>" data-container="body" data-placement="right" data-html="true" data-original-title="Statistik">
                <a href="<?php echo site_url('rawat/home'); ?>">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">
                    Statistik
                    </span>
                </a>
            </li>
            <li class="<?php echo $daftar; ?>">
                <a href="javascript:;">
                    <i class="fa fa-folder"></i>
                    <span class="title">Pendaftaran</span>
                    <?php echo $span_daftar_1; ; ?>
                    <span class="arrow <?php echo $span_daftar_2; ?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php echo $pendaftaran; ?>">
                        <a href="<?php echo site_url('rawat/pendaftaran'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Pendaftaran Pasien
                        </a>
                    </li>
                    <li class="<?php echo $tindakan; ?>">
                        <a href="<?php echo site_url('rawat/tindakan'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Tindakan Pasien
                        </a>
                    </li>
                    <li class="<?php echo $resep; ?>">
                        <a href="<?php echo site_url('rawat/resep'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Resep Pasien
                        </a>
                    </li>
                    <li class="<?php echo $kasir; ?>">
                        <a href="<?php echo site_url('rawat/kasir'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Kasir/Pembayaran
                        </a>
                    </li>
                    <li class="<?php echo $pasien; ?>">
                        <a href="<?php echo site_url('rawat/pasien'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Daftar Pasien
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $informasi; ?>">
                <a href="javascript:;">
                    <i class="fa fa-th-list"></i>
                    <span class="title">Informasi</span>
                    <?php echo $span_info_1; ; ?>
                    <span class="arrow <?php echo $span_info_2; ?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php echo $appointment; ?>">
                        <a href="<?php echo site_url('rawat/appointment'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Daftar Appointment
                        </a>
                    </li>
                    <li class="<?php echo $antrian; ?>">
                        <a href="<?php echo site_url('rawat/antrian'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Daftar Antrian
                        </a>
                    </li>                    
                </ul>
            </li>
            
        </ul>        
    </div>
</div>