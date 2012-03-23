<?php if ($name): ?>

<div id="user-data" data-name="<?php echo $name ?>" data-token="<?php echo $token ?>"></div>

<style>
	ul {list-style:none}
</style>

<script>
var enter = 13;
$(function() {

	var $user = $('#user-data');

	function attachTags(list) {
		$.each(list, function(i, tag) {
			$('#tags_anchor').after('<li data-id="' + i + '">' + tag.name + '</li>');
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
					}
				}
			});
			e.preventDefault();
		}
	});
});
</script>

<?php echo form::open($action, array('id' => 'form_tags')) ?>

<ul>

<li>
	Hello, <?php echo $name ?>!
</li>

<li>
	<?php echo form::input('tags', '', array('id' => 'tags', 'placeholder' => ' enter ')) ?>
</li>

<li id="tags_anchor"></li>

</ul>

<?php echo form::close() ?>

<?php endif ?>
