<!DOCTYPE html>
<html>
<head>
<title>Yahaal Challenge - Aeraf</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="/img/favicon.png">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXQRkRD6kfFvZvjemcqZ85G9VWBGowM_I">
</script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey">
  <div id="app">
    <header class="w3-bar w3-top w3-yellow w3-large" style="z-index:4">
      <span class="w3-bar-item w3-right">
        <img src="/img/yahaal.png" width="150">
      </span>
    </header>

    <div class="w3-main" style="margin-left:10px;margin-top:43px;">

      <div class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> People Statistics </b></h5>
      </div>

      <stats-component></stats-component>

      <div class="w3-container">
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-dark-grey">
            <h5>Map</h5>
            <p> Map will be displayed here </p>
          </div>
        </div>
      </div>
      <hr>

      <hr>
      <br>
      <footer class="w3-container w3-padding-16 w3-light-grey">
        <p>Created by <a href="https://www.linkedin.com/in/aeraf/" target="_blank">Aeraf Abuhuseina</a></p>
      </footer>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
