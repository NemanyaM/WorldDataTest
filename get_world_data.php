<?php

$sort = "";
$dir = "";

if(isset($_POST["data"])) {
    $data = $_POST["data"];
	
   
    $sort_column_index = $data[2]["value"][0]["column"];
	$sort = strtolower($data[1]['value'][$sort_column_index]['data']);
	
	if ($sort != 'continent' &&
		$sort != 'region' &&
		$sort != 'countries' &&
		$sort != 'lifeexpectancy' &&
		$sort != 'cities' &&
		$sort != 'languages' &&
		$sort != 'population') {
		$sort = "";
	}
	
   
    $dir = $data[2]["value"][0]["dir"];
	if ($dir != 'asc' &&
		$dir != 'desc') {
		$dir = "asc";
	}
		
}
  
  
$con = mysql_connect("localhost", "root", "");
if (!$con) {
    die("Error: " . mysql_error());
}
mysql_select_db("world", $con);
$query = 'select
                Continent,
                Region,
                count(LocalName) as Countries,
                avg(LifeExpectancy) as LifeExpectancy, #sum(LifeExpectancy * Population)/sum(Population)
                sum(Cities) as Cities,
                sum(Languages) as Languages,
                sum(Population) as Population
            from country t1
            join (select CountryCode, count(ID) as Cities
                from city group by CountryCode) t2
                on t1.Code = t2.CountryCode
            join (select CountryCode, count(Language) as Languages
                from countrylanguage group by CountryCode) t3
                on t1.Code = t3.CountryCode
            group by Continent, Region';

if ($sort != "") {
    $query = $query . ' order by ' . $sort . ' ' . $dir;
}
$result = mysql_query($query);
$worldinfo = array();
while ($row = mysql_fetch_assoc($result))
    $worldinfo[] = $row;


$response = array();
$response['success'] = true;
$response['aaData'] = $worldinfo;
$json_result = json_encode($response);
print_r($json_result);
?>
	

















