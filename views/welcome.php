<?php if ($name): ?>

<style>
#tag {
	width:100%;
}
.selected-tag, .tags-element:hover {
	border: 1px solid #ddd !important;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.controls {
	display: none;
}
.selected-tag > .controls {
	display: block;
}
.tags-element {
	border: 1px solid #fff;
	margin: 3px;
	padding: 3px;
	width:100%;
}
.controls {
	position: absolute;
	margin: 0px 0px 0px 1px;
	bottom: 0px;
	right: 0px;
}
</style>

<div id="user-data" data-name="<?php echo $name ?>" data-token="<?php echo $token ?>"></div>

<script>
var enter = 13;
$(function() {

	var $tag = $('#tag');
	var $user = $('#user-data');

	var attachTags = function attachTags(list, id, type) {
		var html = '';
		var controls = '<span class="controls"><i class="icon-edit"></i><i class="icon-trash"></i></span>';
		$.each(list, function(i, tag) {
			html += '<div id="tag' + i + '" class="tags-element btn-group" data-id="' + i + '"><span class="tag-text">' + tag.name + '</span>' + controls + '</div>';
		});

		if (type === 'before') {
			$(id).before(html);
		} else if (type === 'after') {
			$(id).after(html);
		}
	}

	var updateTags = function updateTags(list) {
		$tag.data('id', '');
		$.each(list, function(i, tag) {
			$('#tag' + i + ' .tag-text').html(tag.name);
		});
	}

	$.ajaxSetup({
		dataType: 'json'
	});

	$.ajax({
		url: '/v1/tag/list',
		data: {token: $user.data('token')}
	}).done(function(x) {
		if (!x.error) {
			attachTags(x.list, '#tags-anchor', 'before');
		}
	});

	$('#tags-elements').on('click', '.icon-edit', function(e) {
		var $element = $(this).parents('.tags-element');
		var tagText = $element.find('.tag-text').html();
		$tag.data('id', $element.data('id'));
		$tag.val(tagText);
		$('body').animate({scrollTop: 1}, 1000);
		$tag.focus();
		return false;
	});

	$('#tags-elements').on('click', '.icon-trash', function(e) {
		var id = $(this).parents('.tags-element').data('id');
		$.ajax({
			url: '/v1/tag/remove',
			data: {id: id, token: $user.data('token')}
		}).done(function(x) {
			$('#tag' + x.id).hide('slow');
		});
		return false;
	});

	$('#form-tags').on('keypress', '#tag', function(e) {

		var key = e.keyCode || e.which || e.charCode || 0;

		if (key === enter) {

			$(this).prop('disabled', true);
			$('.help-inline').empty();
			var tag = $(this).val();
			console.log(this);
			$.ajax({
				url: $('#form-tags').attr('api-action'),
				type: 'POST',
				data: {tag: tag, token: $user.data('token'), id: $(this).data('id')},
				tagElement: this
			}).done(function(x) {

				$el = $(this.tagElement);
				$el.prop('disabled', false);
				var dataID = $el.data('id');

				if (!x.error) {
					$tag.val('');
					if (x.insert) {
						attachTags(x.list, '#tag-anchor', 'after');
					} else {
						updateTags(x.list);
					}
				} else {
					$.each(x.errors, function(i, msg) {
						$('#' + i + '-msg').text(msg);
					});
				}

				if (dataID) {
					$('body').animate({scrollTop: $('#tag' + dataID).offset().top - 20}, 1000);
				}
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

<?php echo form::open(null, array('api-action' => '/v1' . $action, 'id' => 'form-tags', 'autocomplete' => 'off')) ?>

<?php echo form::input('tag', '', array('id' => 'tag', 'placeholder' => ' enter ')) ?>

<span class="help-inline" id="tag-msg"></span>

<?php echo form::close() ?>

<div id="tags-elements">
	<span id="tag-anchor"></span>
	<span id="tags-anchor"></span>
</div>


<?php endif ?>
