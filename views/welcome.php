<?php if ($name): ?>

<style>
#tags {
	width:100%;
}
.selected-tag {
	border: 1px solid #ddd;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.tags-element {
	margin: 3px;
	padding: 3px;
}
</style>

<div id="user-data" data-name="<?php echo $name ?>" data-token="<?php echo $token ?>"></div>

<script>
var enter = 13;
$(function() {

	var $user = $('#user-data');

	function attachTags(list) {
		$.each(list, function(i, tag) {
			$('#tags_anchor').after('<div class="tags-element" data-id="' + i + '">' + tag.name + '</div>');
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

	$('#form-tags').on('keypress', '#tags', function(e) {

		var key = e.keyCode || e.which || e.charCode || 0;

		if (key === enter) {
			$(this).prop('disabled', true);
			$('.help-inline').empty();
			var tags = $(this).val();
			$.ajax({
				url: '/v1' + $('#form-tags').attr('action'),
				type: 'POST',
				data: {tags: tags, token: $user.data('token')},
				tagElement: this,
				dataType: 'json'
			}).done(function(x) {
				if (!x.error) {
					$('#tags').val('');
					attachTags(x.list);
				} else {
					$.each(x.errors, function(i, msg) {
						$('#' + i + '-msg').text(msg);
					});
				}
				$(this.tagElement).prop('disabled', false);
			});
			e.preventDefault();
		}
	});

	$('#tags-elements').on('click', '.tags-element', function() {
		$(this).toggleClass('selected-tag');
	});
});
</script>


Hello, <?php echo $name ?>!

<?php echo form::open($action, array('id' => 'form-tags', 'autocomplete' => 'off')) ?>

<?php echo form::input('tags', '', array('id' => 'tags', 'placeholder' => ' enter ')) ?>

<span class="help-inline" id="tags-msg"></span>

<?php echo form::close() ?>

<div id="tags-elements">
	<span id="tags_anchor"></span>
</div>


<?php endif ?>
