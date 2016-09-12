<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>SPARQL Environment</title>
		<meta name="copyright" content="2014 W.S. Blackwell, W.S. Catron, S. Hill MIT"/>

		<!-- Online Environment Dependencies -->
		<!-- jQuery and jQuery UI -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
	    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
	   	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

		<!-- Local Environment Files -->
		<link rel="stylesheet" href="webroot/css/default.css" /> <!-- Default Theme -->
		<script type="text/javascript" src="webroot/js/default.js"> </script>
		<script type="text/javascript" src="webroot/js/jquery.fullscreen.js"> </script>
		<script type="text/javascript" src="webroot/js/jquery.sparql.js"> </script>

	</head>
  <!-- nav -->
  <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="homepage.php">SPARQL-Environment</a>
      <p class="navbar-text">Signed in as
        <b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b>
      </p>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="edit_user.php">Edit Account</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  </nav>
	<body>
		<div id="menu">
		<div id="menu-tools">
			<div id='menu-datasets'><span id="datasets-icon" class="icons">&#xf1c0;</span><span class='name'>Datasets</span></div>
		</div>
			<div id="menu-title">SPARQL Environment</div>
			<div id='menu-window'>
				<a class='icons selected' id='window-equal' href='javascript:environment.equalizeInputsOutputs()'><div>&#xe602;</div></a>
				<a class='icons' id='window-output' href='javascript:environment.maximizeOutputs()'><div>&#xe600;</div></a>
				<a class='icons' id='window-input' href='javascript:environment.maximizeInputs()' style="border-right: 1px solid #CCC;"><div>&#xe601;</div></a>
				<a class='icons' id='window-input' href='javascript:environment.rotateDatasetViews()'>&#xf01e;</a>
				<a class="icons" id='fullScreen'>&#xf065;</a>
				<a class="icons" id='details-toggle'>&#xf05a;</a>
			</div>
		</div>
		<div id="workspace">
			<div id="datasets">
				<div class="panel-menu">
					<span id="datasets-icon" class="icons">&#xf1c0;</span> Datasets
					<a class="icons panel-menu-tools" title="Export configuration" id="export-config-button">&#xf01b;</a>
					<a class="icons panel-menu-tools" title="Import configuration" id="import-config-button">&#xf01a;</a>
				</div>
				<div class="panel-list">
					<ul>
					</ul>
					<div id='import-config'><input id='import-config-url' type='text' placeholder='URL to Config File' /><input id='import-config-btn' type='submit' value='Add'></div>
					<div id='import-config-file'>Drag Config File Here<a id="import-config-file-hide">Hide</a></div>
				</div>
			</div>
			<div id="data-area">
				<div id="data-input">
					<div class="panel-menu">

						<div class="panel-menu-tabs">
						</div>
						<a class="icons panel-menu-tools" title="SparqIt" href="">&#xf045;</a>
						<a class="icons panel-menu-tools" title="Save Query" href="">&#xf0c7;</a>
					</div>
					<div id="inputs">

					</div>
				</div>
				<div id="data-output">
					<!--<div id="data-output-history">
						<div class="panel-menu">
							<span id="datasets-icon" class="icons">&#xf1da;</span> History
							<a href="javascript:environment.clearHistory();" class="icons panel-menu-tools" title="Clear History" href="">&#xf014;</a>
						</div>
						<ul>
						</ul>
					</div>-->
					<div class="panel-menu">
						<div class="panel-menu-tabs">
						</div>
						<a class="icons panel-menu-tools" title="SparqIt" href="">&#xf045;</a>
					</div>
					<div id="outputs">
					</div>
				</div>
			</div>
			<div id="detail">
				<div class="panel-menu">
					<div class="panel-menu-tabs">
					</div>
					<!--<span id="datasets-icon" class="icons">&#xf05a;</span> Detail Panel-->
					<!--<a class="icons panel-menu-tools" title="Help" href="">&#xf128;</a>-->
				</div>
				<div id="details">

				</div>
			</div>
		</div>
		<div id="config-editor">
			<div class="panel-menu">
				<span id="datasets-icon" class="icons">&#xf05a;</span> Edit Configuration
				<a class="icons panel-menu-tools" title="Help" href="">&#xf128;</a>
			</div>
			<input type='text' value='' placeholder="Name of dataset" id='config_editor_name' /><br/>
			<input type='text' value='' placeholder="Description of dataset" id='config_editor_description' /><br/>
			<input type='text' value='' placeholder="Source node for dataset" id='config_editor_source' /><br/>
			<div>
			<ul id="config_editor_prefixes">
				<li><input type="text" placeholder="Prefix Key" value="prefix-key" /><input type="text" value="prefix-value" placeholder="Prefix Value"></li>
			</ul>
				<div id="config_editor_prefixes_add" class='icons'>&#xf055;</div>
			</div>
			<a class='btn' href='javascript:environment.saveDataset();'>Save</a> | <a class='btn' href='javascript:environment.editor.close();'>Cancel</a> | <a class='btn' href='javascript:environment.deleteDataset();'>Delete</a>
		</div>
	</body>
</html>
