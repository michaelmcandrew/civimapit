<?php
echo 'Enter a postcode: ';
$postcode = trim(fgets(STDIN)); // reads one line from STDIN
if($postcode==''){
	echo 'No postcode entered, using E5 0DR';
	$postcode = 'E5 0DR';
}
$mapitResult = json_decode(file_get_contents("http://mapit.mysociety.org/postcode/".urlencode($postcode)));

//Need to calculate Ward and Council using shortcuts because 
$areaData['ward'] = $mapitResult->areas->{$mapitResult->shortcuts->ward}->name;
$areaData['council'] = $mapitResult->areas->{$mapitResult->shortcuts->council}->name;

$fieldsToReturn = array('WMC' => 'constituency',  'EUR' => 'eu_region');

foreach($mapitResult->areas as $area) {
	if(in_array($area->type, array_keys($fieldsToReturn))){
		$areaData[$fieldsToReturn[$area->type]]=$area->name;
	}
}

$areaData['ward_ons'] = $mapitResult->areas->{$mapitResult->shortcuts->ward}->codes->ons;
$areaData['council_ons'] = $mapitResult->areas->{$mapitResult->shortcuts->council}->codes->ons;

print_r($areaData);