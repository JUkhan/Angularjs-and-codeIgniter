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
	  
      .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}
      .CodeMirror-focused .cm-matchhighlight {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAFklEQVQI12NgYGBgkKzc8x9CMDAwAAAmhwSbidEoSQAAAABJRU5ErkJggg==);
        background-position: bottom;
        background-repeat: repeat-x;
      }
    .CodeMirror-activeline-background {background: #e8f2ff !important;}
	.CodeMirror-foldmarker {
        color: blue;
        text-shadow: #b9f 1px 1px 2px, #b9f -1px -1px 2px, #b9f 1px -1px 2px, #b9f -1px 1px 2px;
        font-family: arial;
        line-height: .3;
        cursor: pointer;
      }
      .CodeMirror-foldgutter {
        width: .7em;
      }
      .CodeMirror-foldgutter-open,
      .CodeMirror-foldgutter-folded {
        color: #555;
        cursor: pointer;
      }
      .CodeMirror-foldgutter-open:after {
        content: "\25BE";
      }
      .CodeMirror-foldgutter-folded:after {
        content: "\25B8";
      }
    </style>
    <link href="../static/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../static/css/ng-grid.min.css" rel="stylesheet">
	 <link href="../static/css/font-awesome.css" rel="stylesheet"/>
	  <link href="../static/css/smoothness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet"/>
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
		  <a class="brand" href="#/model">Model</a>
		   <a class="brand" href="#/view">View</a>
		    <a class="brand" href="#/ctrl">Controller</a>
			 <a class="brand" href="#/script">Javascript</a>
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
	<script src="../static/js/jquery-ui-1.10.2.custom.min.js"></script>
	<script src="../static/js/toastr.min.js"></script>	
    <script src="tool.js"></script>
	<link href="../static/css/toastr.min.css" rel="stylesheet">
	
	 <!-- codemirror -->		
	<link rel="stylesheet" href="codemirror/lib/codemirror.css">
    <script src="codemirror/lib/codemirror.js"></script>
	 <script src="codemirror/addon/edit/matchbrackets.js"></script>
    <script src="codemirror/addon/edit/continuecomment.js"></script>
	 <script src="codemirror/addon/comment/comment.js"></script>
	 <script src="codemirror/addon/hint/show-hint.js"></script>
    <link rel="stylesheet" href="codemirror/addon/hint/show-hint.css">
    <script src="codemirror/addon/hint/xml-hint.js"></script>
    <script src="codemirror/addon/hint/html-hint.js"></script>
	 <script src="codemirror/addon/search/searchcursor.js"></script>
    <script src="codemirror/addon/search/match-highlighter.js"></script>
	 <script src="codemirror/addon/selection/active-line.js"></script>
	  <script src="codemirror/addon/edit/closetag.js"></script>
	  <script src="codemirror/addon/fold/foldcode.js"></script>
    <script src="codemirror/addon/fold/foldgutter.js"></script>
    <script src="codemirror/addon/fold/brace-fold.js"></script>
    <script src="codemirror/addon/fold/xml-fold.js"></script>
	 
    <script src="codemirror/htmlmixed.js"></script>
    <script src="codemirror/xml.js"></script>
    <script src="codemirror/javascript.js"></script>
    <script src="codemirror/css.js"></script>
    <script src="codemirror/clike.js"></script>
    <script src="codemirror/php.js"></script>

  </body>
</html>