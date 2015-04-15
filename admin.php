<?php
	session_start();
	
	//ini_set('display_errors', 1); 
	//error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Banga: Transfer money around the globe
		</title>
		
		<!-- Some SEO -->
		<meta name="Generator" content="Notepad++"/>
		<meta name="Author" content="Banga"/>
		<meta name="Keywords" content="money, transfer, global, world, currency, bitcoins"/>
		<meta name="Description" content="Banga"/>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"/>
		
		<!-- Style sheets importeren -->
		<link rel="stylesheet" type="text/css" href="styles/bootstrap.css"/>
		
		<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>
		
		<script type="text/javascript" async="" src="http://s3.buysellads.com/ac/bsa.js"></script>
		<script type="text/javascript" id="_bsap_js_c466df00a3cd5ee8568b5c4983b6bb19" src="http://s3.buysellads.com/r/s_c466df00a3cd5ee8568b5c4983b6bb19.js?v=1382493600000" async="async"></script>
		
		<script src="scripts/jquery.js"></script>
		<script src="scripts/bootstrap.min.js"></script>
		<script src="scripts/bootswatch.js"></script>
		<script src="scripts/Chart.js"></script>

<style>
.heading {
  margin-right: 200px;
  font-family: "proxima-nova";
  font-weight: 600;
  font-size: 22px;
  line-height: 40px;
}

.rec {
	margin-right: 100px;
}

.section {
	float: left;
	width: 400px;
	margin-right: 40px;
}

.secRec {
	margin-bottom: 50px;
}

svg {
  font: 10px sans-serif;
}

.y.axis path {
  display: none;
}

.y.axis line {
  stroke: #fff;
  stroke-opacity: .2;
  shape-rendering: crispEdges;
}

.y.axis .zero line {
  stroke: #000;
  stroke-opacity: 1;
}

.title {
  font: 300 78px Helvetica Neue;
  fill: #666;
}

.birthyear,
.age {
  text-anchor: middle;
}

.birthyear {
  fill: #fff;
}

rect {
  fill-opacity: .6;
  fill: #e377c2;
}

rect:first-child {
  fill: #1f77b4;
}

</style>


	</head>
	<body style>
		<script src="scripts/bsa.js"></script>
		<?php
			// Import controller class
			require('includes/classes/class.controller.php');
			
			// Create instance of controller
			$controller = new Controller();
			$wrongLogin = false;

			if(isset($_POST['login'])) {
			
				// User tried to log in
				$user = user::checkLogin($_POST['username'], $_POST['userpass']);
			
				if($user->get("uid") >= 1)
				{
					$controller->setLoggedIn(true, $user);
				}
				else 
				{
					$wrongLogin = true;
				}
			}	
		?>
		
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div cass="navbar-header">
					<a class="navbar-brand" href="index.php?p=home">
						Banga Merchant Admin Page
					</a>
				
					<?php
					if($controller->getLoggedIn()) {
						$user = new user($controller->getUserID());
					?>
					
					<span class="navbar-brand">
						<?php
							//echo $user->get("first_name");
						?>
					</span>
					
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				  	</button>
				  	
				<?php
					}
				?>
				</div>
				
				<?php
					if($controller->getLoggedIn()) {
						$user = new user($controller->getUserID());
				?>
				
				<div class="navbar-collapse collapse" id="navbar-main" style="height: auto;">		
				</div>
				
				<?php
					}
				?>
				
			</div>
		</div>
		
		<!-- This is the main content, switching it with a php switch -->
		<div class="container">
			<div class="page-header" id="banner">
				<div class="row">
					<div class="col-lg-6">
				  	</div>
				</div>
			</div>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script>

var margin = {top: 20, right: 40, bottom: 30, left: 20},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom,
    barWidth = Math.floor(width / 19) - 1;

var x = d3.scale.linear()
    .range([barWidth / 2, width - barWidth / 2]);

var y = d3.scale.linear()
    .range([height, 0]);

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("right")
    .tickSize(-width)
    .tickFormat(function(d) { return Math.round(d / 1e6) + "M"; });

// An SVG element with a bottom-right origin.
var svg = d3.select("panel-body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

console.log(svg);

// A sliding container to hold the bars by birthyear.
var birthyears = svg.append("g")
    .attr("class", "birthyears");

// A label for the current year.
var title = svg.append("text")
    .attr("class", "title")
    .attr("dy", ".71em")
    .text(2000);

d3.csv("population.csv", function(error, data) {

  // Convert strings to numbers.
  data.forEach(function(d) {
    d.people = +d.people;
    d.year = +d.year;
    d.age = +d.age;
  });

  // Compute the extent of the data set in age and years.
  var age1 = d3.max(data, function(d) { return d.age; }),
      year0 = d3.min(data, function(d) { return d.year; }),
      year1 = d3.max(data, function(d) { return d.year; }),
      year = year1;

  // Update the scale domains.
  x.domain([year1 - age1, year1]);
  y.domain([0, d3.max(data, function(d) { return d.people; })]);

  // Produce a map from year and birthyear to [male, female].
  data = d3.nest()
      .key(function(d) { return d.year; })
      .key(function(d) { return d.year - d.age; })
      .rollup(function(v) { return v.map(function(d) { return d.people; }); })
      .map(data);

  // Add an axis to show the population values.
  svg.append("g")
      .attr("class", "y axis")
      .attr("transform", "translate(" + width + ",0)")
      .call(yAxis)
    .selectAll("g")
    .filter(function(value) { return !value; })
      .classed("zero", true);

  // Add labeled rects for each birthyear (so that no enter or exit is required).
  var birthyear = birthyears.selectAll(".birthyear")
      .data(d3.range(year0 - age1, year1 + 1, 5))
    .enter().append("g")
      .attr("class", "birthyear")
      .attr("transform", function(birthyear) { return "translate(" + x(birthyear) + ",0)"; });

  birthyear.selectAll("rect")
      .data(function(birthyear) { return data[year][birthyear] || [0, 0]; })
    .enter().append("rect")
      .attr("x", -barWidth / 2)
      .attr("width", barWidth)
      .attr("y", y)
      .attr("height", function(value) { return height - y(value); });

  // Add labels to show birthyear.
  birthyear.append("text")
      .attr("y", height - 4)
      .text(function(birthyear) { return birthyear; });

  // Add labels to show age (separate; not animated).
  svg.selectAll(".age")
      .data(d3.range(0, age1 + 1, 5))
    .enter().append("text")
      .attr("class", "age")
      .attr("x", function(age) { return x(year - age); })
      .attr("y", height + 4)
      .attr("dy", ".71em")
      .text(function(age) { return age; });

  // Allow the arrow keys to change the displayed year.
  window.focus();
  d3.select(window).on("keydown", function() {
    switch (d3.event.keyCode) {
      case 37: year = Math.max(year0, year - 10); break;
      case 39: year = Math.min(year1, year + 10); break;
    }
    update();
  });

  function update() {
    if (!(year in data)) return;
    title.text(year);

    birthyears.transition()
        .duration(750)
        .attr("transform", "translate(" + (x(year1) - x(year)) + ",0)");

    birthyear.selectAll("rect")
        .data(function(birthyear) { return data[year][birthyear] || [0, 0]; })
      .transition()
        .duration(750)
        .attr("y", y)
        .attr("height", function(value) { return height - y(value); });
  }
});

$(document).ready(function(){
	$("canvas").each(function(){
		var $canvas = $(this);
		var ctx = this.getContext("2d");
var data = {
	labels : ["January","February","March","April","May","June","July"],
	datasets : [
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			data : [1228,1148,1340,1019,996,1027,1100]
		}
	]
};
		eval($("code[data-for='" + $canvas.attr("id") + "']").text());
		
		var evalString = "new Chart(ctx)." + $canvas.data("type") + "(data);";
		eval(evalString);
					
	});
});

</script>

<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg-4">        
        	<div class="panel panel-default">
            	<div class="panel-body">
                	
                	<div class="section">
<p>
<span class="heading">Revenue</span>
<span class="col-lg-12">More>></span>
</p>
<canvas id="line" data-type="Line" width="400" height="300" style="width: 600px; height: 400px;"></canvas>

					</div>

					<div class="section">
						<span class="heading rec">Recent Transaction</span>
						<span class="col-lg-12">More>></span>
						</p>
						<div class="list-group">
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Tomato
								</h4>
								<p class="list-group-item-text">
									17lbs to Bob Marley
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Brian's Chicken
								</h4>
								<p class="list-group-item-text">
									2ea to Dirk Wit
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Tomato
								</h4>
								<p class="list-group-item-text">
									6lbs to Seema Hari
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Rice
								</h4>
								<p class="list-group-item-text">
									37lbs to Max Gutman
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Straus Milk
								</h4>
								<p class="list-group-item-text">
									3ea to Renu Bora 
								</p>
							</div>
						</div>

					</div>

					<div class="section">
						<span class="heading">Inventory</span>
						<span class="col-lg-12">More>></span>
						</p>
						<div class="list-group">
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Rice
								</h4>
								<p class="list-group-item-text">
									30000lbs left
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Brian's Chicken
								</h4>
								<p class="list-group-item-text">
									587ea left
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Tomato
								</h4>
								<p class="list-group-item-text">
									2540lbs left
								</p>
							</div>
						</div>

					</div>

					<div class="section">
						<span class="heading">Finance&nbsp;&nbsp;&nbsp;</span>
						<span class="col-lg-12">More>></span>
						</p>
						<div class="list-group">
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Brian Bloomer
								</h4>
								<p class="list-group-item-text">
									<font color="#9EE22D">$32/$128</font>
								</p>
							</div>
							<div class="list-group-item">
								<h4 class="list-group-item-heading">
									Dirk Wit
								</h4>
								<p class="list-group-item-text">
									<font color="#E1246A">$46/$256</font>
								</p>
							</div>
						</div>

					</div>
                	
              	</div>
            </div>
        </div>
    </div>
</div>
		
			<?php
				/*
				if($controller->getLoggedIn()) {
					include('includes/pages.php');
				}
				else {
					if(!isset($_GET['p']))
						$_GET['p'] = "home";
					
					switch($_GET['p'])
					{	
						case "home":
							include ('includes/pages/login.php');
							break;
						case "register":
							include ('includes/pages/createAccount.php');
							break;
						default:
							include ('includes/pages/login.php');
							break;
					}
				}
				*/
			?>
		
			<footer>
				<div class="row">
					<div class="col-lg-12">
						<p>Copyright - Banga. 2013 beta</p>
					</div>
				</div>
			</footer>
		</div>
		<!-- End of content -->
	</body>
</html>
