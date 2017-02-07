<?php

/* * ********************************************************************
 * Customization Services by ModulesGarden.com
 * Copyright (c) ModulesGarden, INBS Group Brand, All Rights Reserved 
 * (2014-01-02, 09:40:26)
 * 
 *
 *  CREATED BY MODULESGARDEN       ->        http://modulesgarden.com
 *  CONTACT                        ->       contact@modulesgarden.com
 *
 *
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 * ******************************************************************** */

/**
 * @author Grzegorz Draganik <grzegorz@modulesgarden.com>
 */

$domain = $argv[1];
if (!$domain)
	die('Error: empty domain');

include_once dirname(__FILE__) . '/../../lib/plugin.php';

$conf = new Configuration();
if ($conf->get('automatically_add_domains')){
	
	// auto-adding to spamexperts
	echo 'Adding domain '.$domain.' to SpamExperts<br/>';
	
	$hostname = $conf->get('api_hostname');
	$username = $conf->get('api_username');
	$password = $conf->get('api_password');
	
	// no credentials in configuration
	if (!$hostname || !$username || !$password)
		die('Unable to add domain to SpamExperts - check credentials on plugin\'s configuration');
	
	$api = new SpamExperts_API($hostname, $username, $password);
	$res = $api->protectDomains(array($domain), $conf, new DirectAdmin_API());
	
	if (isset($res[$domain]['result'])){
		
		die( $res[$domain]['result'] ? 'Domain has been added to the SpamExperts' : 'Error during adding domain to the SpamExperts' );
		
	} else {
		die('Error during adding domain to the SpamExperts');
	}
	
} else {
	// auto-adding to spamexperts disabled -> no action
}