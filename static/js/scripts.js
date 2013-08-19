angular.module('project', ['projectApi','ui.bootstrap', 'ngGrid']).
  config(function($routeProvider) {
    $routeProvider.
      when('/', {controller:ListCtrl, templateUrl:'index.php/projects/template_list'}).
      when('/edit/:id', {controller:EditCtrl, templateUrl:'index.php/projects/template_detail'}).
      when('/new', {controller:CreateCtrl, templateUrl:'index.php/projects/template_detail'}).
	   when('/Department', { templateUrl:'index.php/Department_ctrl'}).
	    when('/Student', { templateUrl:'index.php/Student_ctrl'}).
      otherwise({redirectTo:'/'});
  });

function ListCtrl($scope, $location, Project) {


  $scope.projects = Project.query();

  $scope.destroy = function(Project) {
    Project.destroy(function() {
      $scope.projects.splice($scope.projects.indexOf(Project), 1);
    });
  };
}

function CreateCtrl($scope, $location, Project) {
  $scope.save = function() {
    Project.save($scope.project, function(project) {
      $location.path('/edit/' + project.id);
    });
  };
}

function EditCtrl($scope, $location, $routeParams, Project) {
  var self = this;

  Project.get({id: $routeParams.id}, function(project) {
    self.original = project;
    $scope.project = new Project(self.original);
  });

  $scope.isClean = function() {
    return angular.equals(self.original, $scope.project);
  };

  $scope.destroy = function() {
    self.original.destroy(function() {
      $location.path('/');
    });
  };

  $scope.save = function() {
    $scope.project.update(function() {
      $location.path('/');
    });
  };
}


angular.module('projectApi', ['ngResource']).
  factory('Project', function($resource) {
  
    var Project = $resource('index.php/api/projects/:method/:id', {}, {
      query: {method:'GET', params: {method:'index'}, isArray:true },
      save: {method:'POST', params: {method:'save'} },
      get: {method:'GET', params: {method:'edit'} },
      remove: {method:'DELETE', params: {method:'remove'} }
    });

    Project.prototype.update = function(cb) {
      return Project.save({id: this.id},
          angular.extend({}, this, {id:undefined}), cb);
    };

    Project.prototype.destroy = function(cb) {
      return Project.remove({id: this.id}, cb);
    };

    return Project;
  });