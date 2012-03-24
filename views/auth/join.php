<script>
$(function() {

	$('#from_join').on('submit', function(e) {
		
		$.ajax({
			url: '/v1' + $(this).attr('action'),
			dataType: 'json',
			type: 'POST',
			data: $(this).serialize(),
			success: function (x) {
				$('.help-inline').empty();
				if (!!x.error) {
					$.each(x.errors, function(i, msg) {
						$('#' + i + '_msg').text(msg);
					});
				} else {
					$.ajax({
						url: '/cookie/set?apirn_1=' + JSON.stringify(x.auth),
						dataType: 'json',
						success: function (y) {
							if (y.apirn_1) {
								window.location = '/';
							}
						}
					});
				}
			}
		});

		e.preventDefault();
	});

});
</script>

<div class="row-fluid show-grid">
	<div class="span12"></div>
</div>

<div class="row-fluid show-grid">

	<div class="span12">
		<?php echo form::open($action, array('id' => 'from_join')) ?>

		<div>
			<?php echo form::input('email', '', array('placeholder' => 'email')) ?>
			<span class="help-inline" id="email_msg"></span>
		</div>

		<div>
			<?php echo form::password('password', '', array('placeholder' => 'password')) ?>
			<span class="help-inline" id="password_msg"></span>
		</div>

		<?php echo form::submit(null , $submit, array('class' => 'btn')) ?>

		<?php echo form::close() ?>
	</div>

</div>

