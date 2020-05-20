# Get_Geo_Location
*Get geo location from ip address which stored in mySQL database and insert geo data into mySQL database*
<br><br>
*this project briefly explain about connecting to mySQL database from php*

## Step 1:
- create dbh.php which connect to mySQL database. 
- To make it more secure, I added 'defined'. 

```php
<?php
    if(!defined("IN_CODE"))
    {
        die("not an entry point");
    } //you have to define this when you use this dbh.php file

    $server="server_name"; 
    $login="user_name";
    $password="password";
    $dbname="database name";

    $con= mysqli_connect($server, $login, $password, $dbname)
    OR die('Could not connect to MySQL'.mysqli_connect_error());
    //it will die when db information isn't correct or fail to connect with error msg
?>
```

## Step2: 
- add define in new 'ip_location.php' file
> ex) define("IN_CODE",1);
- include 'dbh.php' file 
> ex) include("dbh.php");
- define query 
- connect with 'mysqli_query'
- use if loop check if there are result of the query:
```php
<?php
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result))>0)
?>
``` 
- use while loop to check entire ip address of the query result:    
```php
<?php
    while($row = mysqli_fetch_array($result))
?>
```

## Step3: 
*There are a lot of websites provide geo location with ip addresses; however most of them limit certain amount in a day. I found a website that provide infinitly (still need to take some 10 mins break)*
<br><br>
https://geoip-db.com/json/ +ipaddress
<br><br>
*this website get geo locations in json format*
<br>

![Screenshot](image/Readme1.jpg)
- $ip is containing $row['ip'] address which is ip address in the database.
- $url is https://geoip-db.com/json/ + ip address.
- $file will get as a json file.
- $arr will decode json file and turn it into array. 
```php
<?php
    $ip = $row['ip'];
	$url = 'https://geoip-db.com/json/'.$ip;
	$file = file_get_contents($url);
	$arr = json_decode($file, true);
?>
```

## Step4 (success): 
*if $arr is true insert into mySQL ip-table*
- create a String builder as 
"UPDATE IP-TABLE SET" 
- if country, contry code, city, state, latitude, and longitude is 'Not found', it should change to null. 
- update to mysql 

## Step5:
- close mysql connection











