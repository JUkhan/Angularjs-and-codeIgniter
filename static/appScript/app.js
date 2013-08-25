angular.module('project', ['ui.bootstrap', 'ngGrid', 'jQuery-ui']).
  config(function($routeProvider) {
    $routeProvider.
      when('/', { templateUrl:BASE_URL+'home_ctrl'}).
      		
		when('/Navigations', { templateUrl:BASE_URL+'Navigations_ctrl'}).
		when('/NavigViewRight', { templateUrl:BASE_URL+'NavigViewRight_ctrl'}).
		when('/Roles', { templateUrl:BASE_URL+'Roles_ctrl'}).		
		when('/Users', { templateUrl:BASE_URL+'Users_ctrl'}).

      otherwise({redirectTo:'/'});
  });