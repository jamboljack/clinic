<!DOCTYPE html>
<html>
<head>
<meta name="keyword" content="">
<link rel="shortcut icon" href="<?php echo base_url(); ?>img/logo-icon.png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Q-Clinic</title>

<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />    
</head>

<body class="login-body">
	<div class="container">
		<br><br><br>	
        <div align="center">
            <img src="<?php echo base_url(); ?>img/logo.png">            
        </div>
        
        <form class="form-signin" action="<?php echo site_url('login/validasi'); ?>" name="login" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <h2 class="form-signin-heading">Masukkan User & Password :</h2>
                <div class="login-wrap">            
                    <input id="username" type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" title="Don't Use SPACE" placeholder="Username Anda" autofocus required>
                    <?php echo form_error('username', '<div class="form-group has-error"><p class="help-block">','</p></div>'); ?>
                    <input type="password" class="form-control" placeholder="Password Anda" name="password" autocomplete="off" required>
                    <?php echo form_error('password', '<div class="form-group has-error"><p class="help-block">','</p></div>'); ?>
                    <button class="btn btn-lg btn-login btn-block" type="submit">Login</button>
        	   </div>            
        </form>
            
        <?php 
        if ($this->session->flashdata('notification')) { 
        ?>
            <div class="form-body">
                <div class="alert alert-block alert-success fade in" align="center">
                    <?php echo $this->session->flashdata('notification'); ?>
	           </div>	            
            </div>
        <? 
        } 
        ?>       
    </div>

    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
</body>
</html>