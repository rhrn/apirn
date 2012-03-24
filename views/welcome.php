<?php if ($name): ?>

<div id="user-data" data-name="<?php echo $name ?>" data-token="<?php echo $token ?>"></div>

<script>
var enter = 13;
$(function() {

	var $user = $('#user-data');

	function attachTags(list) {
		$.each(list, function(i, tag) {
			$('#tags_anchor').after('<div data-id="' + i + '">' + tag.name + '</div>');
		});
	}

	$.ajax({
		url: '/v1/tag/list',
		dataType: 'json',
		data: {token: $user.data('token')},
		success: function(x) {
			if (!x.error) {
				attachTags(x.list);
			}
		}
	});

	$('#form_tags').on('keypress', '#tags', function(e) {

		var key = e.keyCode || e.which || e.charCode || 0;

		if (key === enter) {
			$(this).attr("disabled", "disabled");
			$('.help-inline').empty();
			var tags = $(this).val();
			$.ajax({
				url: '/v1' + $('#form_tags').attr('action'),
				type: 'POST',
				data: {tags: tags, token: $user.data('token')},
				dataType: 'json',
				success: function(x) {
					if (!x.error) {
						$('#tags').val('');
						attachTags(x.list);
					} else {
						console.log(x.errors);
						$.each(x.errors, function(i, msg) {
							$('#' + i + '_msg').text(msg);
						});
					}
					$('#tags').removeAttr('disabled');
				}
			});
			e.preventDefault();
		}
	});
});
</script>

<div class="row-fluid show-grid">
	<div class="span12">
		Hello, <?php echo $name ?>!
	</div>
</div>

<div class="row-fluid show-grid">

	<div class="span12">

		<?php echo form::open($action, array('id' => 'form_tags', 'autocomplete' => 'off')) ?>

		<?php echo form::input('tags', '', array('id' => 'tags', 'placeholder' => ' enter ')) ?>

		<span class="help-inline" id="tags_msg"></span>

		<span id="tags_anchor"></span>

		<?php echo form::close() ?>

	</div>

</div>

<?php endif ?>
