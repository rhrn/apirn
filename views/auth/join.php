<style>
#submit-join {
	width:110px;
}
.help-inline {
	position: absolute;
}
</style>
<script>
$(function() {

	$('#form-join').on('submit', function(e) {

		$('#submit-join').prop('disabled', true);
		
		$.ajax({
			url: '/v1' + $(this).attr('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json'
		}).done(function(x) {
			$('#submit-join').prop('disabled', false);
			$('.help-inline').empty();
			if (!!x.error) {
				$.each(x.errors, function(i, msg) {
					$('#' + i + '-msg').text(msg);
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
		});

		e.preventDefault();
	});

});
</script>

<?php echo form::open($action, array('id' => 'form-join')) ?>

<div>
	<?php echo form::input('email', '', array('placeholder' => 'email')) ?>

	<span class="help-inline" id="email-msg"></span>
</div>

<div>
	<?php echo form::password('password', '', array('placeholder' => 'password')) ?>

	<span class="help-inline" id="password-msg"></span>
</div>

<?php echo form::submit(null , $submit, array('id' => 'submit-join', 'class' => 'btn')) ?>

<?php echo form::close() ?>
