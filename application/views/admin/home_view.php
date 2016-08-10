<div class="page-content-wrapper">
    <div class="page-content">            
        <h3 class="page-title">
            Dashboard <small>Statistics</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">                    
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url('dashboard/home'); ?>">Dashboard</a>
                </li>
            </ul>                
        </div>            
                        
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        <?php 
                            $Jml_Pelanggan = count($TotalPelanggan);
                            echo number_format($Jml_Pelanggan);
                        ?>
                        </div>
                        <div class="desc">
                        Pelanggan
                        </div>
                    </div>
                    <a class="more" href="<?php echo site_url('admin/service'); ?>">
                        View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-medkit"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        <?php 
                            $Jml_Produk = count($TotalProduk);
                            echo number_format($Jml_Produk);
                        ?>
                        </div>
                        <div class="desc">
                        Produk Tarif
                        </div>
                    </div>
                    <a class="more" href="<?php echo site_url('admin/project'); ?>">
                        View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-user-md"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        <?php 
                            $Jml_Dokter = count($TotalDokter);
                            echo number_format($Jml_Dokter);
                        ?>
                        </div>
                        <div class="desc">
                        Dokter
                        </div>
                    </div>
                    <a class="more" href="<?php echo site_url('admin/news'); ?>">
                        View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-stethoscope"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        <?php 
                            $Jml_Perawat = count($TotalPerawat);
                            echo number_format($Jml_Perawat);
                        ?>
                        </div>
                        <div class="desc">
                        Perawat
                        </div>
                    </div>
                    <a class="more" href="<?php echo site_url('admin/testimoni'); ?>">
                        View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>         
            
        <div class="clearfix"></div>
    </div>
</div>