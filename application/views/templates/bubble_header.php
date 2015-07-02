<html>
  <head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawSeriesChart);

    function drawSeriesChart() {
      
		var jsonData = $.ajax({
      			url: '<?php echo site_url('graph')."/load_bubble_data";?>',
				dataType:"json",
				async: false
				}).responseText;
		  
		// Create our data table out of JSON data loaded from server.
		var data = new google.visualization.DataTable(jsonData);
    
      	var options = {
      	  title: '<?php echo $title; ?>',
      	  hAxis: {title: '<?php echo $xaxis; ?>'},
      	  vAxis: {title: '<?php echo $yaxis; ?>'},
      	  bubble: {opacity: 0},
      	  bubble: {
      		textStyle: {fontSize: 12, fontName: 'Times-Roman', color: 'none'}	
        }
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>
  <body> 