  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css"/>
      <!--Icone-->
      <link rel="icon" type="image/png" href="logo.png" />
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta charset="utf-8">
       <title>SportsFinder</title>
    </head>

    <body>
              <!-- NAVBAR -->
      <div class="navbar-fixed">
        <nav style="background-color:#a80d00;opacity:0.8;">
          <div class="nav-wrapper">
            <a href="index.html" class="brand-logo"> &nbsp SPORTSFINDER</a>
            <ul class="right hide-on-med-and-down">
              <li><a href="ajout.html">Ajouter un lieu</a></li>
            </ul>
          </div>
        </nav>
      </div>
      
    
    <!-- MAIN CONTENT -->
    <div class="container">
        <div class="row">
          <div class="col s12">


              
<?php

    $sport=$_POST['sport'];
    $ville=$_POST['ville'];
    $latitude=43.47156944718504000000;
    $longitude=-1.50383681058883670000;

try
    {
    	$bdd = new PDO('mysql:host=localhost;dbname=c9;charset=utf8', 'root', '');
    }
    
catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    $reponse = $bdd->query("SELECT Nom_Activité, Adresse_Activité, Longitude, Latitude FROM Activité a
    JOIN Sport s ON (a.ID_Sport = s.ID_Sport)
    JOIN Ville v ON (a.ID_Ville = v.ID_Ville)
    WHERE Nom_Sport='".$sport."'
    AND Nom_Ville='".$ville."'
    ");

    $count = $reponse->rowCount();

    echo '<h5>';
    echo $count;
    echo '&nbsp';
    echo 'Résultat(s) trouvé(s) </h5>';
    echo '<hr>';
    echo '</div>';
    echo '<div class="col s6">';
    echo '<ul class="collection">';

  
  $i = 0;
  
while ($donnees = $reponse->fetch())
{
    
    $latcourante = $donnees['Latitude'];
    $lngcourante = $donnees['Longitude'];
    $titre = $donnees['Nom_Activité'];
    echo '<li class="collection-item avatar">';
    echo '<i class="material-icons circle">folder</i>';
    echo '<input class="title" id="titre'.$i.'" value="'.$titre.'" >';
    //echo $donnees['Nom_Activité'];
    //echo '</span>';
    echo '<p>';
    echo $donnees['Adresse_Activité'];
    echo '<br>';
    echo '</p>';
    echo '<input class="lat_markers" id="lat_marker'.$i.'" value="'.$latcourante.'" type="hidden" >';
    echo '<input class="lng_markers" id="lng_marker'.$i.'" value="'.$lngcourante.'" type="hidden" >';
    echo '<a href="#" class="secondary-content" onClick="showme('.$i.')"><i class="material-icons">location_on</i></a>';
    echo '</li>';
    
    $i++;
    

}
 

$reponse->closeCursor();
//AIzaSyBANCRVekYjrTesYW5a_sIFpvReWj2dtnc clé API Google MAPS
?>


            </ul>
          </div>
          
          <div class="col s6">
            <!--<div class="card-panel red darken-2">-->
                <div id="map"></div>
            <!--</div>-->
          </div>
        </div>
      </div>

      
     
      
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
      <script>
      $(".button-collapse").sideNav();

      var latitude = parseFloat('<?php echo $latitude; ?>');
      var longitude = parseFloat('<?php echo $longitude; ?>');
      var nbResultats = document.getElementsByClassName('lat_markers').length;
      console.log(nbResultats);
      var allMarkers=[];
      var marker;

      
      function initMap() {
      
        var bounds  = new google.maps.LatLngBounds();      
        var uluru = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: uluru,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        
        for(var i = 0 ; i < nbResultats ; i++){
            
            var myLatlng = new google.maps.LatLng(document.getElementById('lat_marker'+i+'').value,document.getElementById('lng_marker'+i+'').value);
            var titre = document.getElementById('titre'+i+'').value;
            console.log(titre);
            saved_label = String(titre);
            console.log(saved_label);
            marker = new google.maps.Marker({
              position: myLatlng,
              map: map,
              optimized: false,
              label: {
                color: 'black',
                fontWeight: 'bold',
                text: saved_label,
              }
            });
            bounds.extend(myLatlng);
            allMarkers.push(marker);
            console.log(allMarkers);
            
        }
        
        map.fitBounds(bounds);      
        map.panToBounds(bounds);
        
        
        
        /*function toggleBounce() {
          if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
          } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
          }
        }*/
        
        
        
      }
      

        showme = function(index) {
          if (marker[index].getAnimation() != google.maps.Animation.BOUNCE) {
            marker[index].setAnimation(google.maps.Animation.BOUNCE);
          } else {
            marker[index].setAnimation(null);
          }
        }
      

      
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDkqlqbVn4ItjBVAGrQK9eWCfLXwv-Hyk&callback=initMap">google.maps.event.addDomListener(window,'load', initMap);
    </script>
        <style>
 #map {
   width: 100%;
   height: 45rem;
   background-color: grey;
 }
</style>
    </body>
</html>