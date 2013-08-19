<script src="static/appScript/NavigViewRightCtrl.js"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="NavigViewRightCtrl">

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
          <legend>NavigViewRight</legend>  
		  <div class="control-group" ng-class="{error: myForm.Navigations.$invalid}">
		<label class="control-label" for="Navigations">Navigations</label>
		<div class="controls">
		  <select ng-options="s.NavigationId as s.NavName for s in NavigationsList"  name="Navigations" id="Navigations" ng-model="item.Navigations" required ></select>
		  <span ng-show="myForm.Navigations.$error.required" class="help-inline">Required</span>
		</div>
	  </div>
<div class="control-group" ><label class="control-label" for="Roles">Roles</label>
		<div class="controls">
		  <select ng-options="s.RoleId as s.RoleName for s in RolesList"  name="Roles" id="Roles" ng-model="item.Roles" ></select>		  
		</div></div>
<div class="control-group" ><label class="control-label" for="Users">Users</label>
		<div class="controls">
		  <select ng-options="s.UserId as s.UserName for s in UsersList"  name="Users" id="Users" ng-model="item.Users" ></select>		  
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
            <h3>NavigViewRight</h3>
        </div>
        <div class="modal-body">
           <form name="myForm" class="form-horizontal">
  			 <div class="control-group" ><label class="control-label" for="Navigations">Navigations</label>
		<div class="controls">
		  <select ng-options="s.NavigationId as s.NavName for s in NavigationsList"  name="Navigations" id="Navigations" ng-model="search.Navigations" ></select>		  
		</div></div>
<div class="control-group" ><label class="control-label" for="Roles">Roles</label>
		<div class="controls">
		  <select ng-options="s.RoleId as s.RoleName for s in RolesList"  name="Roles" id="Roles" ng-model="search.Roles" ></select>		  
		</div></div>
<div class="control-group" ><label class="control-label" for="Users">Users</label>
		<div class="controls">
		  <select ng-options="s.UserId as s.UserName for s in UsersList"  name="Users" id="Users" ng-model="search.Users" ></select>		  
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
