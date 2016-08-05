<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fallout Pip-Boy</title>
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/map.css" />
<link rel="stylesheet" type="text/css" href="css/scan.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/INVstyle.css" />
<link href='https://fonts.googleapis.com/css?family=Share+Tech+Mono' rel='stylesheet' type='text/css'>

</head>

<body>
  <input type="checkbox" id="switch" checked>
<label for="switch" class="switch-label">Turn </label>
<div class="container">

<ul class="tabs-demo screen">
  <li>
    <input type="radio" name="tab" id="tab1" checked>
    <label for="tab1">Statistics</label>
    <div class="section sec-style">
    <div class="stats-info"><p>The user interface, in the industrial design field of human–machine interaction, is the space where interactions between humans and machines occur.</p></div>
      <div class="fall-anim">
        <img src="images/fall-tran.gif">
      </div>
    </div>
  </li>
  <li>
    <input type="radio" name="tab" id="tab2" />
    <label for="tab2">Inventory</label>
    <div class="section  wrap">

      <!-- <div class="wrap"> -->

    		<div class="task-list">
    			<ul>

    			<?php
    				require("includes/connect.php");

    				$query = mysql_query("SELECT * FROM tasks ORDER BY date ASC, time ASC");
    				$numrows = mysql_num_rows($query);

    				if($numrows>0){
    					while( $row = mysql_fetch_assoc( $query ) ){

    						$task_id = $row['id'];
    						$task_name = $row['task'];

    						echo '<li>
    								<span>'.$task_name.'</span>
    								<img id="'.$task_id.'" class="delete-button" width="10px" src="images/close.svg" />
    							  </li>';
    					}
    				}
          ?>
    			</ul>
    		</div>
    		<form class="add-new-task" autocomplete="off">
    			<input type="text" name="new-task" placeholder="Add a new item..." />
    		</form>

    	<!-- </div> wrap-->
    	<!-- JavaScript-->
    	<script src="http://code.jquery.com/jquery-latest.min.js"></script>

    	<script>

    		add_task(); // Call the add_task function
    		delete_task(); // Call the delete_task function

    		function add_task() {

    			$('.add-new-task').submit(function(){

    				var new_task = $('.add-new-task input[name=new-task]').val();

    				if(new_task != ''){

    					$.post('includes/add-task.php', { task: new_task }, function( data ) {

    						$('.add-new-task input[name=new-task]').val('');

    						$(data).appendTo('.task-list ul').hide().fadeIn();

    						delete_task();
    					});
    				}

    				return false; // Ensure that the form does not submit twice
    			});
    		}

    		function delete_task() {

    			$('.delete-button').click(function(){

    				var current_element = $(this);

    				var id = $(this).attr('id');

    				$.post('includes/delete-task.php', { task_id: id }, function() {

    					current_element.parent().fadeOut("fast", function() { $(this).remove(); });
    				});
    			});
    		}

    	</script>

    </div>
  </li>
  <li>
    <input type="radio" name="tab" id="tab3" />
    <label for="tab3">Map</label>
    <div class="section">
      <input id="pac-input" class="controls" type="text" placeholder="Search Box">
      <div id="map"></div>
      <script>
  function initAutocomplete() {
    var mapOptions = {
        zoom: 9,
        center: new google.maps.LatLng(42.3132882,-71.1972408), // Boston
        disableDefaultUI: true,
        styles: [{"featureType":"all","elementType":"geometry","stylers":[{"color":"#0b300b"}]},{"featureType":"all","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#00c105"}]},{"featureType":"all","elementType":"labels","stylers":[{"color":"#00ff10"},{"visibility":"on"}]},{"featureType":"all","elementType":"labels.text","stylers":[{"color":"#bde1b9"},{"weight":"1.04"},{"gamma":"4.75"},{"lightness":"11"},{"saturation":"44"},{"visibility":"on"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"gamma":0.01},{"lightness":20},{"color":"#07ff00"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#576456"},{"saturation":"11"},{"lightness":"24"},{"gamma":"1.87"}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative.neighborhood","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#0b300b"}]},{"featureType":"landscape","elementType":"geometry.stroke","stylers":[{"color":"#911818"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"visibility":"on"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"landscape.natural.terrain","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"saturation":20}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"lightness":20},{"saturation":-20}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":10},{"saturation":-30}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"saturation":25},{"lightness":25},{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway.controlled_access","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.highway.controlled_access","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"geometry.fill","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"lightness":-20},{"visibility":"on"}]}]
        };
    var mapElement = document.getElementById('map');
    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);
    // Let's also add a marker while we're at it
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(42.3132882,-71.1972408),
        map: map,
        title: 'Fallout!'
    });
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });
    var markers = [];
    // [START region_getplaces]
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }
      // Clear out the old markers.
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];
      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };
        // Create a marker for each place.
        markers.push(new google.maps.Marker({
          map: map,
          icon: icon,
          title: place.name,
          position: place.geometry.location
        }));
        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
    });
    // [END region_getplaces]
  }
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCs_kqfSbgDs94mTlX3AhRAdEt_hkYr9Qk&libraries=places&callback=initAutocomplete"
           async defer></script>
    </div>
  </li>
  <li>
    <input type="radio" name="tab" id="tab4" />
    <label for="tab4">Radio</label>
    <div class="section">
      <ul>
        <li style="margin-top: 2em;"><object style="float: right;" type="application/x-shockwave-flash" width="150" height="25" data="https://www.youtube.com/v/m7ICBPF7Hwo?version=2&loop=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/m7ICBPF7Hwo?version=2&loop=1&theme=dark" /><param name="wmode" value="transparent" /></object>Silver Shroud Radio</li>

        <li style="margin-top: 2em;"><object style="float: right;" type="application/x-shockwave-flash" width="150" height="25" data="https://www.youtube.com/v/NdN7CzbkfTE?version=2&loop=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/NdN7CzbkfTE?version=2&loop=1&theme=dark" /><param name="wmode" value="transparent" /></object>Diamond City Radio</li>

        <li style="margin-top: 2em;"><object style="float: right;" type="application/x-shockwave-flash" width="150" height="25" data="https://www.youtube.com/v/i8bDQ4VKkaY?version=2&loop=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/i8bDQ4VKkaY?version=2&loop=1&theme=dark" /><param name="wmode" value="transparent" /></object>Minutemen Radio</li>
        <li></li>
        <li></li>
      </ul>
    </div>
  </li>
</ul>
<div class="overlay">Fallout </br> Pip-Boy</div>
</div>
</body>
</html>
