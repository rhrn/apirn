<script>
$(function() {

	$('input[name=email]').css('border', '1px solid blue');
	$('input[name=password]').css('border', '1px solid gray');

	$('#from_join').on('submit', function(e) {
		
		$.ajax({
			url: '/v1' + $(this).attr('action'),
			dataType: 'json',
			type: 'POST',
			data: $(this).serialize(),
			success: function (x) {
				$('.errors_msg').empty();
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
				//console.log(x);
			}
		});

		e.preventDefault();
	});

});
</script>

<?php echo form::open($action, array('id' => 'from_join')) ?>

<?php echo form::input('email', '', array('placeholder' => 'email')) ?>
<div class="errors_msg" id="email_msg"></div>
<?php echo form::password('password', '', array('placeholder' => 'password')) ?>
<div class="errors_msg" id="password_msg"></div>
<?php echo form::submit(null , $submit) ?>

<?php echo form::close() ?>
