<?php echo form::open('auth/login') ?>

<?php echo form::input('email') ?>
<?php echo form::input('password') ?>
<?php echo form::submit(null ,'login') ?>

<?php echo form::close() ?>
