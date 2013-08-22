var tools=angular.module('tools', ['ui.bootstrap']);
tools.config(['$routeProvider', function($routeProvider) {
        $routeProvider.when('/', {templateUrl: 'partials/homeView.html', controller:'homeCtrl'});
        $routeProvider.when('/model', {templateUrl: 'partials/model.php', controller:'modelCtrl'});
        $routeProvider.when('/ctrl', {templateUrl: 'partials/controller.php', controller:'controllerCtrl'});
		$routeProvider.when('/view', {templateUrl: 'partials/view.php', controller:'viewCtrl'});
		$routeProvider.when('/script', {templateUrl: 'partials/script_ctrl.php', controller:'scriptCtrl'});
        $routeProvider.otherwise({redirectTo: '/'});
  }]);
tools.factory("homeFactory", function($http){
	var url='Oxygen.php';
	return{
		getOutput:function( data ){	
	
			return $http({
			  method: 'POST',
			  url: url,
			  data: data,
			  headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			  //cache: $templateCache
			});				
		},
		codeGen:function( data ){			
			return $http({
			  method: 'POST',
			  url: 'code-gen.php',
			  data: data,
			  headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			  //cache: $templateCache
			});				
		}
	}
}); 
tools.controller('modelCtrl', function($scope){
CodeMirror.commands.autocomplete = function(cm) {
          CodeMirror.showHint(cm, CodeMirror.hint.html);
      }
 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true, styleActiveLine: true,autoCloseTags: true,
        enterMode: "keep",
        tabMode: "shift", extraKeys: {"Ctrl-Space": "autocomplete"}, highlightSelectionMatches: {showToken: /\w/},
		 extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		 foldGutter: true,
		 gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
      });
	 
	  //,text/javascript, application/json,text/css
	  $scope.selectModel=function(el){		
		if(el.value){	
			 $scope.fileName=el.value;
			$.post('modify.php',{action:'model', name:el.value}, function(data){var data=JSON.parse(data);editor.setValue(data.content);});			
		}		
	  };
	  $scope.updateFile=function(){
		  if($scope.fileName){
			  $.post('modify.php',{action:'model-update',name:$scope.fileName, content:editor.getValue()}, function(data){
					toastr.success('update successfully');
			  });
			
		 }
	  };
	  $scope.fileName='';
}); 
tools.controller('controllerCtrl', function($scope){
CodeMirror.commands.autocomplete = function(cm) {
          CodeMirror.showHint(cm, CodeMirror.hint.html);
      }
 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true, styleActiveLine: true,autoCloseTags: true,
        enterMode: "keep",
        tabMode: "shift", extraKeys: {"Ctrl-Space": "autocomplete"}, highlightSelectionMatches: {showToken: /\w/},
		 extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		 foldGutter: true,
		 gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
      });
	 
	  //,text/javascript, application/json,text/css
	  $scope.selectModel=function(el){		
		if(el.value){	
			 $scope.fileName=el.value;
			$.post('modify.php',{action:'controller', name:el.value}, function(data){var data=JSON.parse(data);editor.setValue(data.content);});			
		}		
	  };
	  $scope.updateFile=function(){
		  if($scope.fileName){
			  $.post('modify.php',{action:'controller-update',name:$scope.fileName, content:editor.getValue()}, function(data){
					toastr.success('update successfully');
			  });
			
		 }
	  };
	  $scope.fileName='';
}); 
tools.controller('viewCtrl', function($scope){
CodeMirror.commands.autocomplete = function(cm) {
          CodeMirror.showHint(cm, CodeMirror.hint.html);
      }
 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true, styleActiveLine: true,autoCloseTags: true,
        enterMode: "keep",
        tabMode: "shift", extraKeys: {"Ctrl-Space": "autocomplete"}, highlightSelectionMatches: {showToken: /\w/},
		 extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		 foldGutter: true,
		 gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
      });
	 
	  //,text/javascript, application/json,text/css
	  $scope.selectModel=function(el){		
		if(el.value){	
			 $scope.fileName=el.value;
			$.post('modify.php',{action:'view', name:el.value}, function(data){var data=JSON.parse(data);editor.setValue(data.content);});			
		}		
	  };
	  $scope.updateFile=function(){
		  if($scope.fileName){
			  $.post('modify.php',{action:'view-update',name:$scope.fileName, content:editor.getValue()}, function(data){
					toastr.success('update successfully');
			  });
			
		 }
	  };
	  $scope.fileName='';
}); 
tools.controller('scriptCtrl', function($scope){
CodeMirror.commands.autocomplete = function(cm) {
          CodeMirror.showHint(cm, CodeMirror.hint.html);
      }
 var editor = CodeMirror.fromTextArea(document.getElementById("codex"), {
        lineNumbers: true,
        matchBrackets: true,
        //mode: "text/javascript, application/json, text/typescript, application/typescript",
        indentUnit: 4,
        indentWithTabs: true, styleActiveLine: true,autoCloseTags: true,
        enterMode: "keep",
        tabMode: "shift", extraKeys: {"Ctrl-Space": "autocomplete"}, highlightSelectionMatches: {showToken: /\w/},
		 extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
		 foldGutter: true,
		 gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
      });
	 /*var editor = CodeMirror.fromTextArea(document.getElementById("codex"), {
        lineNumbers: true,
		mode:'text/javascript, application/json, text/typescript, application/typescript',
        matchBrackets: true,
        continueComments: "Enter",
        extraKeys: {"Ctrl-Q": "toggleComment"}
      });*/
	  //,text/javascript, application/json,text/css
	  $scope.selectModel=function(el){		
		if(el.value){	
			 $scope.fileName=el.value;
			$.post('modify.php',{action:'script', name:el.value}, function(data){var data=JSON.parse(data);editor.setValue(data.content);});			
		}		
	  };
	  $scope.updateFile=function(){
		  if($scope.fileName){
			  $.post('modify.php',{action:'script-update',name:$scope.fileName, content:editor.getValue()}, function(data){
					toastr.success('update successfully');
			  });
			
		 }
	  };
	  $scope.fileName='';
}); 
tools.controller('homeCtrl', function($scope, homeFactory, $dialog){
	$scope.tableList=[];
	$scope.shouldBeOpen_refmodal=false;
	
	$scope.opts = {
    backdropFade: true,
    dialogFade:true
  };
  $scope.col=null;
   $scope.open_refmodal = function (col) {
   //config="click:showOptions,enable:optionsText&&optionsValue"
    $scope.col=col;
    $scope.refTable=findTable(col.refTableName);
	loadColumn($scope.refTable);
	var pkcol=findPKColumn($scope.refTable);
	if(pkcol==null){
	toastr.error('Table named '+$scope.refTable.tableName+' has not been defined primary key.<br> Note: Please try second time. If does not come, define PK.');
	return;
	}	
	col.optionsValue=pkcol.colName;
	$scope.shouldBeOpen_refmodal = true;
  };
  $scope.addColumn=function(){
  
	$scope.currentTable.columns.push({
					colId:0,
					tableId:$scope.currentTable.tableId,
					colName:'',
					isForm:0,
					isGrid:0,
					isQuickSearch:0,
					dataBind:'',
					refTableName:'',
					optionsText:'',
					optionsValue:'',	
					isPk:0,
					ai:0,
					isNull:0,
					dataType:'',
					size:''
				});
  };
  $scope.saveColumn=function(item){ 
		item.action=item.colId.toString()=='0'? 'insertColumn':'updateColumn';
		homeFactory.getOutput(item)
		.success(function(res){
			item.colId=res.msg;
			toastr.success(item.colName+' saved successfully.');			
		});	
  };
   $scope.removeColumn=function(item, index){ 
   confirmDialog('Confirm!','Are you sure to remove this column ?',function(isConfirm){
		if(isConfirm){
			if(item.colId.toString()=='0')
			{
				$scope.currentTable.columns.splice(index,1);
			}
			else
			{
			   homeFactory.getOutput({action:'removeColumn', colId:item.colId})
					.success(function(res){
						 $scope.currentTable.columns.splice(index,1);
						toastr.success(item.colName+' removed successfully.');			
					});	
			}
		}	
   });
   };
  $scope.close_refmodal = function () {
    
    $scope.shouldBeOpen_refmodal = false;
  };

	$scope.typeList=['int','bigInt','varchar','date','dateTime','double','boolean'];
	loadTable();
	$scope.refTable=null;
	$scope.currentTable=null;
	$scope.addTable=function(){
	if(!$scope.tableName){toastr.warning('Table name is required.'); return;}
		homeFactory.getOutput({action:'addTable', tableName:$scope.tableName})
		.success(function(res){
			$scope.tableList.push({tableId:res.msg,tableName:$scope.tableName, loaded:false, columns:[]});
			toastr.success('Table added successfully.');$scope.tableName='';			
		});	
	};
	$scope.selectedTable=function(item){
		$scope.currentTable=item;	
		loadColumn(item);
	};
	$scope.setRefTable=function(column, refTabName){
		if(refTabName)
		loadColumn(findTable(refTabName));			
	};
	$scope.getMysqlScript=function(){
	
		homeFactory.codeGen({action:'mysql', tableName:$scope.currentTable.tableName, tableId:$scope.currentTable.tableId})
			.success(function(res){
				alert('Script',res.msg);					
			});	
	};
	$scope.dropTable=function(){
	if(confirm('sure to drop!'))
		homeFactory.getOutput({action:'drop-table', tableName:$scope.currentTable.tableName})
			.success(function(res){
				alert('Drop Table',res.msg);					
			});	
	};
	$scope.syncWithApp=function(){	
		homeFactory.codeGen({action:'syncapp', tableName:$scope.currentTable.tableName, tableId:$scope.currentTable.tableId})
			.success(function(res){
				alert('Code',res.msg);					
			});	
	};
	$('#mac').sortable({
		update: function (event, ui) {
            // $scope.saveOrder();
         }      
    });
	$scope.saveOrder=function(){
		var res=[];
	   $('#mac>li').each(function(index, item){
			res.push({orderNo:index, colId:item.id});
	   });
		homeFactory.getOutput({action:'save-order', orders:JSON.stringify(res)})
						.success(function(res){
							alert('order', 'Order saved successfully');					
						});	
					
				
	};
	function loadColumn(table){
		if(table && !table.loaded){
			homeFactory.getOutput({action:'getColumnList', tableId:table.tableId})
			.success(function(res){
				table.columns=res;
				table.loaded=true; 						
			});	
		}
	}
	function loadTable(){
		homeFactory.getOutput({action:'getTableList'}).success(function(data){
		for(var i=0,len=data.length;i<len;i++){data[i].loaded=false; data[i].columns=[];}		
		$scope.tableList=data;		
		});
	}
	function findTable(tableName){	
		for(var i=0,len=$scope.tableList.length;i<len; i++){
			if($scope.tableList[i].tableName==tableName){
				return $scope.tableList[i];				
			}
		}
		return null;
	}
	function findPKColumn(table){		
		for(var i=0,len=table.columns.length;i<len; i++){		
			if(table.columns[i].isPk=='1'){
				return table.columns[i];				
			}
		}
		return null;
		
	}
	function confirmDialog(title, msg, callback){
		var btns = [{result:'cancel', label: 'Cancel'}, {result:'ok', label: 'OK', cssClass: 'btn-primary'}];
		$dialog.messageBox(title, msg, btns)
		  .open()
		  .then(function(result){
			callback(result && result=='ok');
		});
    }
	function alert(title, msg){
		var btns = [{result:'cancel', label: 'OK', cssClass: 'btn-primary'}];
		$dialog.messageBox(title, msg, btns)
		  .open();
		  
    }

});
