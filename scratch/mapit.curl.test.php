<?php
echo 'Enter a postcode: ';
$postcode = trim(fgets(STDIN)); // reads one line from STDIN
$mapitResult = json_decode(file_get_contents("http://mapit.mysociety.org/postcode/".urlencode($postcode)));

//Need to calculate Ward and Council using shortcuts because 
$a['ward'] = $mapitResult->areas->{$mapitResult->shortcuts->ward}->name;
$a['council'] = $mapitResult->areas->{$mapitResult->shortcuts->council}->name;

$fieldsToReturn = array('UK Parliament constituency' => 'constituency',  'European region' => 'eu_region');

foreach($mapitResult->areas as $area) {
	if(in_array($area->type_name, array_keys($fieldsToReturn))){
		$a[$fieldsToReturn[$area->type_name]]=$area->name;
	}
}

$a['ward_ons'] = $mapitResult->areas->{$mapitResult->shortcuts->ward}->codes->ons;
$a['council_ons'] = $mapitResult->areas->{$mapitResult->shortcuts->council}->codes->ons;

print_r($a);