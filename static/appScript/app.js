angular.module('project', ['ui.bootstrap', 'ngGrid']).
  config(function($routeProvider) {
    $routeProvider.
      when('/', { templateUrl:BASE_URL+'home_ctrl'}).
      		when('/Department', { templateUrl:BASE_URL+'Department_ctrl'}).
		when('/Navigations', { templateUrl:BASE_URL+'Navigations_ctrl'}).
		when('/NavigViewRight', { templateUrl:BASE_URL+'NavigViewRight_ctrl'}).
		when('/Roles', { templateUrl:BASE_URL+'Roles_ctrl'}).
		when('/Shafi', { templateUrl:BASE_URL+'Shafi_ctrl'}).
		when('/Student', { templateUrl:BASE_URL+'Student_ctrl'}).
		when('/Test', { templateUrl:BASE_URL+'Test_ctrl'}).
		when('/Users', { templateUrl:BASE_URL+'Users_ctrl'}).

      otherwise({redirectTo:'/'});
  });