<?php
require_once '/Users/michaelmcandrew/htdocs/civimapit/sites/all/modules/civicrm/civicrm.config.php';
require_once('/Users/michaelmcandrew/htdocs/civimapit/sites/default/civicrm.settings.php');
require_once 'CRM/Core/Config.php';
$config = CRM_Core_Config::singleton();
require_once('civimapit.module');

$query = "
SELECT contact_id, postal_code
FROM `civicrm_address`
WHERE is_primary AND contact_id AND postal_code IS NOT NULL";
require_once('CRM/Core/DAO.php');
$result = CRM_Core_DAO::executeQuery( $query );

echo "Updating area information.\n";

while($result->fetch()){
	civimapit_updateContactAreaInfo($result->contact_id,$result->postal_code);
	echo '.';
}
echo "Done.\n";
?>