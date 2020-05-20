<?php
define("IN_CODE",1);
include("dbh.php");

$query= "SELECT ip_address FROM Tablename;";
$result =mysqli_query($con,$query);

if(mysqli_num_rows($result)>0)
{
   while($row = mysqli_fetch_array($result))
   {
	$ip = $row['ip'];
	$url = 'https://geoip-db.com/json/'.$ip;
	$file = file_get_contents($url);
	$arr = json_decode($file, true);

	if($arr == true) //bring geolocation 
	{
		$country = $arr['country_name'];
		$country_code = $arr['country_code'];
		$latitude = $arr['latitude'];
		$longitude = $arr['longitude'];
		$city = mysqli_real_escape_string($con,$arr['city']);
		$state = mysqli_real_escape_string($con,$arr['state']);


echo "\nIP: $ip ==> country: $country, country_code: $country_code, state: $state, city: $city, latitude: $latitude, longitude: $longitude\n";

        //check if contry, contry code, city, state, latitude, longitute is not found
		$sql="UPDATE IPTABLE SET ";
		if ($country == "Not found")
			$sql = $sql . " country=null";
		else
			$sql = $sql . " country='$country'";

		if ($country_code == "Not found")
			$sql = $sql . ", country_code=null";
		else
			$sql = $sql . ", country_code='$country_code'";

		if ($city == "Not found")
			$sql = $sql . ", city=null";
		else
			$sql = $sql . ", city='$city'";

		if ($state == "Not found")
			$sql = $sql . ", state=null";
		else
			$sql = $sql . ", state='$state'";

		if ($latitude == "Not found")
			$sql = $sql . ", latitude=null";
		else
			$sql = $sql . ", latitude=$latitude";

		if ($longitude == "Not found")
			$sql = $sql . ", longitude=null";
		else
			$sql = $sql . ", longitude=$longitude";

		$sql = $sql . " WHERE ip='$ip'";

#		$insert = "UPDATE IPTABLE SET city = '$city', country = '$country', country_code = '$country_code', latitude = $latitude, longitude = $longitude WHERE ip='$ip'";
		if(mysqli_query($con, $sql)) {
			if (mysqli_affected_rows($con)>0)
				echo "$ip, success - $sql"." <br> \n";
			else
				echo "$ip, no row updated - $sql"." <br> \n";
		}else {

			echo "Error!, cannot run - $sql\n";
		}
	} else { //fail to bring geolocation 
		$i=0;
		while($i<20){
			sleep(30); //sleep for 10 mins
			$i++;
		}	
			echo data('h:i:s');
	}
  } 
}

mysqli_close($con);


?>
