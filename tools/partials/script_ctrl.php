 <?php require_once ('../fileinfo.php'); ?> 
<div >
	<div class="input-append">	
		<select class="span3" onchange="angular.element(this).scope().selectModel(this)">
			<option value="">Select JavaScript</option>
			<?php echo getFiles('../../static/appScript') ?> 
		</select>
		<input class="btn btn-success" type="button" ng-click="updateFile()"  value="Update {{fileName}}"/>		 
	</div> 
</div>
<div>
	<form>
		<textarea id="codex" name="codex" style="display:block; width:100%;height:500px"></textarea>
	</form>
</div>
