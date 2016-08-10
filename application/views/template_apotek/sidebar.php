<?php
$uri = $this->uri->segment(2);

if ($uri == 'home') {
    $dashboard      = 'active';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = '';
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'jenis_obat') {
    $dashboard      = '';
    $data           = 'active open';
    $span_data_1    = '<span class="selected"></span>';
    $span_data_2    = 'open';
    $jenis_obat     = 'active';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = '';
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = ''; 
} elseif ($uri == 'gol_obat') {
    $dashboard      = '';
    $data           = 'active open';
    $span_data_1    = '<span class="selected"></span>';
    $span_data_2    = 'open';
    $jenis_obat     = '';
    $gol_obat       = 'active';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = '';
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = ''; 
} elseif ($uri == 'pabrikan') {
    $dashboard      = '';
    $data           = 'active open';
    $span_data_1    = '<span class="selected"></span>';
    $span_data_2    = 'open';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = 'active';
    $suplier        = '';
    $obat           = '';
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'suplier') {
    $dashboard      = '';
    $data           = 'active open';
    $span_data_1    = '<span class="selected"></span>';
    $span_data_2    = 'open';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = 'active';
    $obat           = '';
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'obat') {
    $dashboard      = '';
    $data           = 'active open';
    $span_data_1    = '<span class="selected"></span>';
    $span_data_2    = 'open';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = 'active'; 
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'purchasing') {
    $dashboard      = '';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = ''; 
    $transaksi      = 'active open';
    $span_trans_1   = '<span class="selected"></span>';
    $span_trans_2   = 'open';
    $purchasing     = 'active';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'pembelian') {
    $dashboard      = '';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = ''; 
    $transaksi      = 'active open';
    $span_trans_1   = '<span class="selected"></span>';
    $span_trans_2   = 'open';
    $purchasing     = '';
    $pembelian      = 'active';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'retur_beli') {
    $dashboard      = '';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = ''; 
    $transaksi      = 'active open';
    $span_trans_1   = '<span class="selected"></span>';
    $span_trans_2   = 'open';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = 'active';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'penjualan') {
    $dashboard      = '';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = ''; 
    $transaksi      = 'active open';
    $span_trans_1   = '<span class="selected"></span>';
    $span_trans_2   = 'open';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = 'active';
    $retur_jual     = '';
    $expired        = '';
} elseif ($uri == 'retur_jual') {
    $dashboard      = '';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = ''; 
    $transaksi      = 'active open';
    $span_trans_1   = '<span class="selected"></span>';
    $span_trans_2   = 'open';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = 'active';
    $expired        = '';
} elseif ($uri == 'expired') {
    $dashboard      = '';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = ''; 
    $transaksi      = 'active open';
    $span_trans_1   = '<span class="selected"></span>';
    $span_trans_2   = 'open';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = 'active';
} else {
    $dashboard      = 'active';
    $data           = '';
    $span_data_1    = '';
    $span_data_2    = '';
    $jenis_obat     = '';
    $gol_obat       = '';
    $pabrikan       = '';
    $suplier        = '';
    $obat           = '';
    $transaksi      = '';
    $span_trans_1   = '';
    $span_trans_2   = '';
    $purchasing     = '';
    $pembelian      = '';
    $retur_beli     = '';
    $penjualan      = '';
    $retur_jual     = '';
    $expired        = ''; 
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
                <a href="<?php echo site_url('apotek/home'); ?>">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">
                    Statistik
                    </span>
                </a>
            </li>
            <li class="<?php echo $data; ?>">
                <a href="javascript:;">
                    <i class="fa fa-folder"></i>
                    <span class="title">Master Data</span>
                    <?php echo $span_data_1; ; ?>
                    <span class="arrow <?php echo $span_data_2; ?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php echo $jenis_obat; ?>">
                        <a href="<?php echo site_url('apotek/jenis_obat'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Jenis Obat
                        </a>
                    </li>
                    <li class="<?php echo $gol_obat; ?>">
                        <a href="<?php echo site_url('apotek/gol_obat'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Golongan Obat
                        </a>
                    </li>
                    <li class="<?php echo $pabrikan; ?>">
                        <a href="<?php echo site_url('apotek/pabrikan'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Pabrikan
                        </a>
                    </li>
                    <li class="<?php echo $suplier; ?>">
                        <a href="<?php echo site_url('apotek/suplier'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Suplier
                        </a>
                    </li>
                    <li class="<?php echo $obat; ?>">
                        <a href="<?php echo site_url('apotek/obat'); ?>">
                            <i class="fa fa-check-square-o"></i>
                            Obat
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $transaksi; ?>">
                <a href="javascript:;">
                    <i class="fa fa-th-list"></i>
                    <span class="title">Transaksi</span>
                    <?php echo $span_trans_1; ; ?>
                    <span class="arrow <?php echo $span_trans_2; ?>"></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php echo $purchasing; ?>">
                        <a href="<?php echo site_url('apotek/purchasing'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Purchasing
                        </a>
                    </li>
                    <li class="<?php echo $pembelian; ?>">
                        <a href="<?php echo site_url('apotek/pembelian'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Pembelian
                        </a>
                    </li>
                    <li class="<?php echo $retur_beli; ?>">
                        <a href="<?php echo site_url('apotek/retur_beli'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Retur Pembelian
                        </a>
                    </li>
                    <li class="<?php echo $penjualan; ?>">
                        <a href="<?php echo site_url('apotek/penjualan'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Penjualan
                        </a>
                    </li>
                    <li class="<?php echo $retur_jual; ?>">
                        <a href="<?php echo site_url('apotek/retur_jual'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Retur Penjualan
                        </a>
                    </li>
                    <li class="<?php echo $expired; ?>">
                        <a href="<?php echo site_url('apotek/expired'); ?>">
                            <i class="fa fa-hand-o-right"></i>
                            Info Barang Expired
                        </a>
                    </li>
                </ul>
            </li>
            
        </ul>        
    </div>
</div>