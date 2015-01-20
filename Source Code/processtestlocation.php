<?php



require_once 'GMaps.php';

require_once 'dbconfig.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());
mysql_select_db($db_database)
 or die ("Unable to select database" .mysql_error());
print "Connection Succeeded";






function google_maps_populate($location){


 
// Your google key
$google_key = 'AIzaSyDyHif5XyNDMIocdSxvP383V5WWS_yUB9Y';
 

  $search= $location;
    
  // Get the Google Maps Object
  $GMap = new GMaps($google_key);
  if ($GMap->getInfoLocation($search)) {
     
           
                 
     /*  
    echo 'Address: '.$GMap->getAddress().'<br>';
    echo 'Country name: '.$GMap->getCountryName().'<br>';
    echo 'Country name code: '.$GMap->getCountryNameCode().'<br>';
    echo 'Administrative area name: '.$GMap->getAdministrativeAreaName().'<br>';
    echo 'Postal code: '.$GMap->getPostalCode().'<br>';
    
    */

                   
                                   
    $latitude = $GMap->getLatitude();
    $longitude = $GMap->getLongitude();
    
    
    $query = "INSERT INTO google_maps VALUES ('$location', '$latitude',  '$longitude')";
	$sql_result = mysql_query($query);
	if(!$sql_result) die ("Database access failed(Insert Query): " .mysql_error());
    
  } 
  
  else {
   return null;
  }

}



function safeClean($n)
{
    $n = trim($n);

    if(get_magic_quotes_gpc())
    {
        $n = stripslashes($n);
    } 

    $n = mysql_escape_string($n);
    $n = htmlentities($n);

    return $n;
}



function compare ($location_broken)
{
 
  $query = "SELECT * FROM `country_dictionary` WHERE state_name LIKE '$location_broken' OR state_code LIKE '$location_broken' OR country_name LIKE '$location_broken'";
  
  
  $sql_result = mysql_query($query);
  
  if(!$sql_result) die ("//Database access failed: " .mysql_error());

  
  
  while(1){
  
  $row = mysql_fetch_row($sql_result);

  $result = $row[0]; 

  if($result != null){

    $result = $row[3].", ".$row[1];
          
    return $result;

  }
 
  else{ 
    
    
    return null;
  
  }

}//while end

} //func end








/////////////



$consumerKey = '7zcuiPjSVRO8ppIchJLYdg';
$consumerSecret = 'afefUnffMn1dN6G1hqrIcMtGIdclHRAbbAEtBlCFQik';
$oauthToken = '63680306-8LTReuJgZZOp4CpeA3hKhiLsZ34W4i6jK60wn41SE';
$oauthSecret = 'NBg8AZzrXokwlMvPDlFhd27ZKz6pvVwgJt3LjyU1c';
 
 
 
include "OAuth.php";
include "twitteroauth.php";
 
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthSecret);










try{

$id_count = 0;

$null = 0;

$successful = 0;

$profile_input = $_POST['profile_input'];

if($profile_input == null){
echo "<br><br><br><br><b>Please enter a valid profile name!</b>";
exit();
}

////




try{

$xml = $connection->get("users/show/$profile_input");

 

}

catch(Exception $e){
echo "API call limit exceeded, can't make more API requests right now, please try again later.<br><br>Exiting......";

exit();
}



$actual_location = (string) $xml->location;

$time_zone = (string) $xml->time_zone;


$count =  $xml->followers_count +  $xml->friends_count;


if($count > 50000){

echo "<br><br><br><br><b>Too many API calls required, can't process! Please enter a profile having less than 50000 Followers + Friends. <br><br>Exiting...</b>";

exit();

}


//////



$count = 0;

while(1){


  try{

if ($count == 0){

    $params = array("screen_name"=>"$profile_input","cursor"=>"-1");
    
    $xml1 = $connection->get("statuses/followers", $params);

}

else{
   $params = array("screen_name"=>"$profile_input","cursor"=>"$next_cursor1");
 
   $xml1 = $connection->get("statuses/followers", $params);
    
}

     $next_cursor1 = (string)$xml1->next_cursor_str;
     
    if($xml1->next_cursor_str == null){
     throw new Exception();
     
     goto a1;
     }

     
        foreach($xml1->users as $user){

        $id_count = $id_count + 1;

        $flag = 0;


        $location = safeClean($user->location);


        if($location == null){

        $null = $null + 1;
        continue;

        }



        $location_broken = strtok($location, " ,\n\t-/");




        while ($location_broken !== false) 

        {

        $result = compare( safeClean($location_broken));


    
            if($result != null){
    
            $query = "INSERT INTO user_locations_followers VALUES ('$result')";
            $sql_result = mysql_query($query);
            if(!$sql_result) die ("Database access failed(Insert Query): " .mysql_error());
    
            if($sql_result != FALSE){
            $flag = 1;
            }

            }
    


        $location_broken = strtok(" ,\n\t-/");
 
        }//while end


        if($flag == 1){
        $successful = $successful + 1;
        $flag = 0;
        }   


        }//foreach end


     }// try end
     
     
     
  catch(Exception $e){
     
     a1 :
  
     if ($count == 0){
     $xmldata1 = "http://api.twitter.com/1/statuses/followers/$profile_input.xml?cursor=-1";
     }

     else{
     $xmldata1 = "http://api.twitter.com/1/statuses/followers/$profile_input.xml?cursor=$next_cursor1";
     }
     
     
     $open = fopen($xmldata1, 'r');
     $content = stream_get_contents($open);
     fclose($open);
     $xml1 = new SimpleXMLElement($content);
     
     $next_cursor1 = (string)$xml1->next_cursor;
      
       
       foreach($xml1->users->user as $user){

        $id_count = $id_count + 1;

        $flag = 0;


        $location = safeClean($user->location);


        if($location == null){

        $null = $null + 1;
        continue;

        }



        $location_broken = strtok($location, " ,\n\t-/");




        while ($location_broken !== false) 

        {

        $result = compare( safeClean($location_broken));


    
            if($result != null){
    
            $query = "INSERT INTO user_locations_followers VALUES ('$result')";
            $sql_result = mysql_query($query);
            if(!$sql_result) die ("Database access failed(Insert Query): " .mysql_error());
    
            if($sql_result != FALSE){
            $flag = 1;
            }

            }
    


        $location_broken = strtok(" ,\n\t-/");
 
        }//while end


        if($flag == 1){
        $successful = $successful + 1;
        $flag = 0;
        }   


        }//foreach end
      
    }// catch
       
       
       
         
             







$count = $count + 1;

if($next_cursor1==0 || $next_cursor1==null){
break;
}


}//while end





/////////////////




$count = 0;


while(1){




    try{

    if ($count == 0){
    $params = array("screen_name"=>"$profile_input","cursor"=>"-1");
    
    $xml2 = $connection->get("statuses/friends", $params);
    }

    else{
    $params = array("screen_name"=>"$profile_input","cursor"=>"$next_cursor2");
 
    $xml2 = $connection->get("statuses/friends", $params);
       
       }
       
       
       
       $next_cursor2 = (string)$xml2->next_cursor_str;
       
        if($xml1->next_cursor_str == null){
     throw new Exception();
     
     goto a2;
     }
       
        foreach($xml2->users as $user){

            $id_count = $id_count + 1;

            $flag = 0;

            $location = safeClean($user->location);


            if($location == null){

            $null = $null + 1;
            continue;

            }


            $location_broken = strtok($location, " ,\n\t-/");





            while ($location_broken !== false) 

            {



            $result = compare( safeClean($location_broken));


    
            if($result != null){
    

            $query = "INSERT INTO user_locations_friends VALUES ('$result')";
            $sql_result = mysql_query($query);
            if(!$sql_result) die ("Database access failed(Insert Query): " .mysql_error());
    
            if($sql_result != FALSE){
            $flag = 1;
            }
    
                }
    


            $location_broken = strtok(" ,\n\t-/");
 
            }


            if($flag == 1){
            $successful = $successful + 1;
            $flag = 0;
            }


            }//foreach end
       
       }// try
       
       
    
  
    
          
    catch(Exception $e){
    
       a2:
    
       if ($count == 0){
        
        $xmldata2 = "http://api.twitter.com/1/statuses/friends/$profile_input.xml?cursor=-1";
       }

       else{
        $xmldata2 = "http://api.twitter.com/1/statuses/friends/$profile_input.xml?cursor=$next_cursor2";
       }

     $open = fopen($xmldata2, 'r');
     $content = stream_get_contents($open);
     fclose($open);
     $xml2 = new SimpleXMLElement($content);



     $next_cursor2 = (string)$xml2->next_cursor;
     
     
       foreach($xml2->users->user as $user){

            $id_count = $id_count + 1;

            $flag = 0;

            $location = safeClean($user->location);


            if($location == null){

            $null = $null + 1;
            continue;

            }


            $location_broken = strtok($location, " ,\n\t-/");





            while ($location_broken !== false) 

            {



            $result = compare( safeClean($location_broken));


    
            if($result != null){
    

            $query = "INSERT INTO user_locations_friends VALUES ('$result')";
            $sql_result = mysql_query($query);
            if(!$sql_result) die ("Database access failed(Insert Query): " .mysql_error());
    
            if($sql_result != FALSE){
            $flag = 1;
            }
    
                }
    


            $location_broken = strtok(" ,\n\t-/");
 
            }


            if($flag == 1){
            $successful = $successful + 1;
            $flag = 0;
            }


            }//foreach end

       
     }// catch   
















$count = $count + 1;

if($next_cursor2==0 || $next_cursor2==null){
break;
}


}//while end



////

echo "<br>--------------------------------------------------------------------------------------------------------------
";




if($actual_location != null){

echo "<br><br><br><br>The person has uploaded his location as $actual_location";

}

if($time_zone != null){

echo "<br><br><br>The user's profile time zone is - $time_zone<br><br>";

}



echo "<br><br>However, based on successful matches with the data dictionary, the user's guessed location is--><br><br><br>";

echo "--------------------------------------------------------------------------------------------------------------
";




////


$query = "SELECT Location, Count(*) AS Count FROM `user_locations_followers` GROUP BY Location ORDER BY Count DESC";
$sql_result = mysql_query($query);
if(!$sql_result) die ("//Database access failed: " .mysql_error());

$row = mysql_fetch_row($sql_result);


$location_1 = $row[0];


if($location_1 != null){
echo "<br><br><br><b>FOLLOWERS--></b><br><br>Based on followers, the user is from $location_1";

google_maps_populate($location_1);



$counter = 2;



if($location_1 != null){

while($counter < 6){

$row = mysql_fetch_row($sql_result);

if ($row[0] == null){
break;
}

if(($row[0] != null) && ($row[0] != $location_1)){

$location_1 = $row[0];

if ($location_1 == null){
break;
}

echo "<br><br><br><br>Based on followers, the next probable location is $location_1";

google_maps_populate($location_1);


$counter = $counter + 1;

}

// if($counter > 3){
// break;
// }

}


}

}


else
{
echo "<br><br><br><b>FOLLOWERS--></b><br><br>Based on followers, the user has no follower.";
}








////////////////
echo "<br><br><br>--------------------------------------------------------------------------------------------------------------
";




$query = "SELECT Location, Count(*) AS Count FROM `user_locations_friends` GROUP BY Location ORDER BY Count DESC";
$sql_result = mysql_query($query);
if(!$sql_result) die ("//Database access failed: " .mysql_error());

$row = mysql_fetch_row($sql_result);


$location_2 = $row[0];


if($location_2 != null){
echo "<br><br><br><b>FRIENDS--></b><br><br>Based on friends (following), the user is from $location_2";

google_maps_populate($location_2);


$counter = 2;



if($location_2 != null){

while($counter < 6){

$row = mysql_fetch_row($sql_result);

if ($row[0] == null){
break;
}

if(($row[0] != null) && ($row[0] != $location_2)){

$location_2 = $row[0];


echo "<br><br><br><br>Based on friends (following), the next probable location is $location_2";

google_maps_populate($location_2);


$counter = $counter + 1;

}

// if($counter > 3){
// break;
// }

}


}

}




else
{
echo "<br><br><br><b>FRIENDS--></b><br><br>Based on friends (following), the user has no follower.";
}






echo "<br><br><br>--------------------------------------------------------------------------------------------------------------
";


echo "<br><br><br>No. of total profiles available as test data (followers + friends) - $id_count";

$difference = $id_count - $null;

echo "<br><br><br><br>No. of profiles whose locations were available (tested values) - $difference";


echo "<br><br><br><br>No. of profiles whose location were null (Wasted values) - $null";


echo "<br><br><br><br>No. of successful matches found in the data dictionary  - $successful";

echo "<br><br><br>--------------------------------------------------------------------------------------------------------------
";





}

catch(Exception $e){
echo "Sorry, something went wrong, we are trying to find out, please try again later.<br><br>Exiting......";

exit();
}


?>












<?php



$query = "SELECT * FROM `google_maps`";
$sql_result = mysql_query($query);
if(!$sql_result) die ("//Database access failed: " .mysql_error());


$row = mysql_fetch_row($sql_result);


echo "<br><br><br><b>The above clusters plotted on Google Maps--></b><br><br>";

?>

<html> 

<script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>

<body>
  <div id="map" style="width: 1050px; height: 770px;"></div>

  <script type="text/javascript">
    
  
     

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 2,
      center: new google.maps.LatLng(0, 0),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
         

   
   
    var i=0; 
   
    <?php for ($i = 0; $i < 11; $i++) {         
      
      
    $row = mysql_fetch_row($sql_result); ?> 
     
    var name = "<?php echo $row[0]; ?>";
    var latitude = "<?php echo $row[1]; ?>";
    var longitude = "<?php echo $row[2]; ?>";
     
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(name);
          infowindow.open(map, marker);
        }
      })(marker, i));
    
     i++;
    
    // <?php $row = mysql_fetch_row($sql_result); ?>
    
   <?php } ?>
    
   
  </script>
</body>
</html>









<?php

echo "<br><br><br>--------------------------------------------------------------------------------------------------------------";



$query = "Delete FROM user_locations_followers";
$sql_result = mysql_query($query);
if(!$sql_result) die ("Database access failed: " .mysql_error());


$query = "Delete FROM user_locations_friends";
$sql_result = mysql_query($query);
if(!$sql_result) die ("Database access failed: " .mysql_error());

$query = "Delete FROM google_maps";
$sql_result = mysql_query($query);
if(!$sql_result) die ("Database access failed: " .mysql_error());




mysql_close($db_server);

?>

