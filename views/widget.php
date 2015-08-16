<div class="file-kit">
	<div class="preview<?= isset($fid) ? "" : " hidden" ?>">
		<a href="<?= $removeUrl ?>?f=<?= $fid ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
		<img src="<?= $url ?>" alt="">
	</div>
	<div class="upload<?= isset($fid) ? " hidden" : "" ?>">
		<span class="btn-add glyphicon glyphicon-plus-sign"></span>
		<input id="<?= $fileInputId ?>" name="<?= $fileInputName ?>" data-url="<?= $uploadUrl ?>?f=<?= $fileInputName ?>" type="file">
	</div>
	<input id="<?= $id ?>" name="<?= $name ?>" value="<?= $fid ?>" type="hidden">
</div>