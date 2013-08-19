<script src="static/appScript/NavigationsCtrl.js"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="NavigationsCtrl">

<div ng-show="fgShowHide" class="btn-toolbar">
	<div class="btn-group">
	 <button type="button" ng-show="auth.insert" ng-click="showForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Add Item</b></button>
	  <button type="button" ng-click="openSearchDialog()"  class="btn btn-inverse" ng-click="getMysqlScript()"><i class="icon-search icon-white"></i><b> Quick Search	</b> </button>
	</div>
</div>
<div ng-show="fgShowHide" class="gridStyle" ng-grid="gridOptions"></div>
<div ng-show="!fgShowHide" style="display:none">
	<form name="myForm" class="form-horizontal well">
	   <fieldset>  
          <legend>Navigations</legend>  
		  <div class="control-group" ng-class="{error: myForm.NavName.$invalid}">
		<label class="control-label" for="NavName">NavName</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="NavName" id="NavName" ng-model="item.NavName" required />
		  <span ng-show="myForm.NavName.$error.required" class="help-inline">Required</span>
		</div>
	  </div>
 <div class="control-group" ng-class="{error: myForm.NavOrder.$invalid}">
		<label class="control-label" for="NavOrder">NavOrder</label>
		<div class="controls">
		  <input type="number" name="NavOrder" id="NavOrder" ng-model="item.NavOrder" required />
		  <span ng-show="myForm.NavOrder.$error.required" class="help-inline">Required</span>
		  <span ng-show="myForm.NavOrder.$error.number" class="help-inline">Not a valid number</span>
		</div>
	  </div>
 <div class="control-group" ng-class="{error: myForm.ActionPath.$invalid}">
		<label class="control-label" for="ActionPath">ActionPath</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="ActionPath" id="ActionPath" ng-model="item.ActionPath" required />
		  <span ng-show="myForm.ActionPath.$error.required" class="help-inline">Required</span>
		</div>
	  </div>
<div class="control-group" ><label class="control-label" for="ParentNavId">ParentNavId</label>
		<div class="controls">
		  <select ng-options="s.NavigationId as s.NavName for s in NavigationsList"  name="ParentNavId" id="ParentNavId" ng-model="item.ParentNavId" ></select>		  
		</div></div>
	
		  <div class="form-actions">
			<button ng-click="saveItem()" ng-disabled="myForm.$invalid" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save</button>
			 <button class="btn btn-warning cancel" ng-click="hideForm()"><i class="icon-close icon-white"></i>Cancel</button>		
		  </div>
	  </fieldset>
	</form>
</div>
<div modal="searchDialog"  options="opts">
        <div class="modal-header">
		 <a class="close" ng-click="closeSearchDialog()" data-dismiss="modal">&times;</a>
            <h3>Navigations</h3>
        </div>
        <div class="modal-body">
           <form name="myForm" class="form-horizontal">
  			 <div class="control-group" ><label class="control-label" for="NavName">NavName</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="NavName" id="NavName" ng-model="search.NavName" />		  
		</div></div>
<div class="control-group" ><label class="control-label" for="ParentNavId">ParentNavId</label>
		<div class="controls">
		  <select ng-options="s.NavigationId as s.NavName for s in NavigationsList"  name="ParentNavId" id="ParentNavId" ng-model="search.ParentNavId" ></select>		  
		</div></div>
	   
			</form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning cancel" ng-click="closeSearchDialog()"><i class="icon-close icon-white"></i>Cancel</button>
			<button class="btn btn-primary cancel" ng-click="refreshSearch()"><i class="icon-refresh icon-white"></i> Refresh</button>
			 <button class="btn btn-primary cancel" ng-click="doSearch()"><i class="icon-search icon-white"></i> Search</button>
        </div>
</div>
<?php else: ?>
<p> Not permitted</p>
<?php endif; ?>
