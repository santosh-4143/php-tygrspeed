<?php
/*
 * Created on 20-Sep-2016
 *
 * Created By Moloy
 * Page to display dashboard of Tygr Speed
 */
 include_once('./config/config.php');
 include_once('./config/database.php');
 include_once('./config/query.php');
 $dashBoardData				=	loginUserDetails($conn);
?>
 <!DOCTYPE html>
<html >
  <head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="30">
    <title>Map - Tygr Speed</title>
 
        <style>
         html, body {
        height: 100%;
        
        margin: 0;
        padding: 0;
      }
        
        	 #map {
        height:100%;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
      #pac-input1,#pac-input2 {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin: 5px 0px 12px 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input1:focus,#pac-input2:focus {
        border-color: #4d90fe;
      }
     
        </style>
  </head>

  <body>
    <div id="map">
      
    </div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 
    <script>
    	var  map;
 		var infoWindow;
 		var base_url ='<?php echo $config['base_url']; ?>';
 		var bounds;
 		var currentPopup;
 		var geocoder;
 		var currLat='<?php echo $_SESSION['LAT'];?>';
 		var currLng='<?php echo $_SESSION['LNG'];?>';
 		var logImg	= '<?php echo $config['base_url']; ?>uploads/<?php echo $dashBoardData['logo_path']; ?>';
    </script>
     <script src="<?php echo $config['base_url']; ?>js/gmapinit.js"></script>
      <script async defer
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo $config['gmap_api_key'];?>&libraries=places&callback=initMap">
    </script>
  </body>
  </html>
