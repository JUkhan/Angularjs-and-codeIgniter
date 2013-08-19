<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Oxygen Codegen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../static/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="../static/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../static/css/ng-grid.min.css" rel="stylesheet">
	 <link href="../static/css/font-awesome.css" rel="stylesheet"/>
	  <link href="smoothness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet"/>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#/">Home</a>
		  
        </div>
      </div>
    </div>

    <div class="container">

      <div ng-app="tools">
              
        <div ng-view></div>

      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	 <script src="../static/js/jquery-1.9.1.js"></script>
    <script src="../static/js/angular.js"></script>
   
    <script src="../static/js/angular-resource.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>	
	<script src="../static/js/ng-grid.js"></script>	
	<script src="../static/js/ui-bootstrap-tpls-0.5.0.min.js"></script>	
	<script src="jquery-ui-1.10.2.custom.min.js"></script>
	<script src="../static/js/toastr.min.js"></script>
	
    <script src="tool.js"></script>
	
	<link href="../static/css/toastr.min.css" rel="stylesheet">
  </body>
</html>