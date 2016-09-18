<?php ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<style>
			/* Remove the navbar's default margin-bottom and rounded borders */
			.navbar {
			margin-bottom: 0;
			border-radius: 0;
			}

			/* Set height of the grid so .sidenav can be 100% (adjust as needed) */
			.row.content {height: 450px}

			/* Set gray background color and 100% height */
			.sidenav {
			padding-top: 20px;
			background-color: #f1f1f1;
			height: 100%;
			}

			/* Set black background color, white text and some padding */
			footer {
			background-color: #555;
			color: white;
			padding: 15px;
			}

			/* On small screens, set height to 'auto' for sidenav and grid */
			@media screen and (max-width: 767px) {
			.sidenav {
			height: auto;
			padding: 15px;
			}
			.row.content {height:auto;}
			}

			textarea
			{
			  width:100%;
			}
			#process, #summary-result, #error{
				display: none;
			}
		</style>

		<script>

			<?php echo $baseURI = "http://localhost/summarizer/summarizer/"; ?>

			$url = "<?php echo $baseURI; ?>summarize-api.php";

			function summarize($type){

				$("#error").hide();
				$("#process").show();
				$("#summary-result").hide();

				if ($type == "url"){
					$value = $('#url').val();
				}else if ($type == "text"){
					$value = $('#text').val();
					if (!$value.trim()) {
					    $("#error-msg" ).html("Empty content.");
					    $("#error").show();
					    $("#process").hide();
					    return;
					}
				}else{
					alert ("unknown type!");
					$("#process").hide();
					return;
				}

				$lang = $('input[name=language]:checked', '#lang-form').val();

				if (!$lang){
					$("#error-msg" ).html("Please select a language.");
				    $("#error").show();
				    $("#process").hide();
				    return;
				}

				$.ajax({
					type: 'POST',
					url: $url,
					data: {
						value: $value,
						type: $type,
						lang: $lang
					},
					success: function(data) {
						try{
							console.log('data:', data);
							data = jQuery.parseJSON( data);
						}
						catch(err){
							$("#error-msg" ).html("Some error occurred. Please check text/URL's format. Eg: <b><i><u>http://www.address.com</b></i></u>");
							$("#error").show();		
							$("#process").hide();
							return;
						}
						if(!data["error"]){
							
							$( "#words" ).html("");
							$( "#summary" ).html("");
							
							if(data["summary"]){
								if (data["summary"].length <= 0){
									// $("#summary").hide();
								}
								else{
									Object.keys(data["summary"]).forEach(function (key) {
										if (data["summary"][key].trim().length > 0)
											$( "#summary" ).html( $( "#summary" ).html() + ' <li> '+data["summary"][key]+' </li>' );
									});
								}
							}

							if(data["words"]){
								if (data["words"].length <= 0){
									// alert("in");
									$("#words-div").hide();
								}
								else{
									Object.keys(data["words"]).forEach(function (key) {
										$( "#words" ).html( $( "#words" ).html() + ' <li class="list-group-item">'+key+' ('+data["words"][key]+')</li>' );
									});
									$("#words-div").show();
								}
							}
							$("#summary-result").show();
						}
						else{
							if (data["type"] == "url"){
								$("#error-msg" ).html("Can't open URL. Please check URL's format: http://www.address.com");
								$("#summary-result").hide();
							}
							else{
								$("#error-msg" ).html("Some error occurred. "+data["message"]);
								$("#summary-result").hide();
							}
							$("#error").show();
						}
						$("#process").hide();
					},
					error: function (xhr, ajaxOptions, thrownError) {
						$("#process").hide();
						$("#error-msg" ).html("Some error occurred. Please check text/URL's format. Eg: <b><i><u>http://www.address.com</b></i></u>");
						$("#error").show();	
						$("summary-result").hide();
					}
				});
			}

		</script>

	</head>
	<body>

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				
				<!-- <div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Projects</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					</ul>
				</div> -->
			</div>
		</nav>

		<div class="container-fluid text-center">
			<div class="row content">
				<div class="col-sm-2 sidenav" style="background-color: white;">
				<!-- <p><a href="#">Link</a></p>
				<p><a href="#">Link</a></p>
				<p><a href="#">Link</a></p> -->
				</div>
				<div class="col-sm-8 text-left">
					<!-- <center>
					<img src="<? echo $baseURI;?>logo.png" width="80">
					</center> -->
					
					<center><h3>Summary of Web Articles</h3></center>
					<hr>
					
					<div id="error" class="alert alert-danger">
						<strong>Error!</strong> <p id="error-msg">Some error occurred.</p>
					</div>
					
					<label for="usr">URL:</label>
					<div class="input-group">
						<input id="url" type="text" class="form-control" placeholder="URL to fetch text from">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" onclick="summarize('url');">Summarize</button>
						</span>
					</div>
					
					<br>
					
					<label for="usr">Text:</label>
					<div class="input-group">
						<textarea class="form-control" id="text" rows="4" placeholder="Text To Summarize"></textarea>
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" onclick="summarize('text');">Summarize</button>
						</span>
					</div>

					<br>

					<center>
						<form id="lang-form">
							<label class="radio-inline">
								<input type="radio" name="language" checked="checked" value="en">English
							</label>

							<label class="radio-inline">
								<input type="radio" name="language" value="ru">Russian
							</label>
							
							<label class="radio-inline">
								<input type="radio" name="language" value="he">Hebrew
							</label>
						</form>
					</center>

					<hr>
					
					<center>
						<div id="process">
							<img src="<? echo $baseURI;?>process.gif" width="150">
						</div>
					</center>

					<div id="summary-result">
						<center><h3>Result</h3></center>
						
						<h4>Summary</h4>
						<ol id="summary">
						</ol>
						<br>
						<div id="words-div">
							<h4>Popular Words</h4>
							<ul class="list-group" id="words">
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-2 sidenav" style="background-color: white;">
					<!-- <div class="well">
					<p>ADS</p>
					</div>
					<div class="well">
					<p>ADS</p>
					</div> -->
				</div>
			</div>
		</div>
		<br>

<footer style="background: #f8f8f8; color: black; border: 1px #e7e7e7;">
</footer>
		<!-- <footer style="background: #f8f8f8; color: black; border: 1px #e7e7e7;">
			<div class="container">
				<div class="row">     
					<div class="col-sm-2  ">
						<center>
							<a href="#"><img src="<? echo $baseURI;?>logo.png" width="50" class="img-responsive center-to-left"/></a>
						</center>
						<br>
						<br>
						<div class="small center-to-left ">&copy; 2013 Company, Inc.</div>
						</div>

					<div class="col-sm-8">
						<div class="text-center">
							<p><a href="#">Host Company, Inc.</a><br>
							<a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a></p>
							<p>social media icons</p>
						</div>
					</div>

					<div class="col-sm-2  ">
						<center>
							<a href="#"><img src="<? echo $baseURI;?>logo.png" width="50" class="img-responsive center-to-left"/></a>
						</center>
						<br>
						<br>
						<div class="small center-to-left ">&copy; 2013 Company, Inc.</div>
					</div>
				</div>
			</div>
		</footer> -->

	</body>
</html>		