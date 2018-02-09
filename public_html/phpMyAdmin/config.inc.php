<?php
	$cfg['PmaAbsoluteUri'] = 'http://www.sivusem31.fr/phpMyAdmin/index.php'; // ici url complete vers /phpMyAdmin/

	/**
	* Configuration serveur ici chez OVH - hebergement mutualise
	**/

	$i = 0;
	//$i++;
	$cfg['Servers'][$i]['host'] = 'localhost'; // ici
	$cfg['Servers'][$i]['port'] = '';
	$cfg['Servers'][$i]['socket'] = '';
	$cfg['Servers'][$i]['connect_type'] = 'tcp';
	$cfg['Servers'][$i]['compress'] = false;
	$cfg['Servers'][$i]['controluser'] = '';
	$cfg['Servers'][$i]['controlpass'] = '';
	$cfg['Servers'][$i]['auth_type'] = 'config';
	$cfg['Servers'][$i]['user'] = 'sivusem31'; // ici
	$cfg['Servers'][$i]['password'] = 'exvViZZOlJY4RucevZqR'; // ici
	$cfg['Servers'][$i]['only_db'] = 'sivusem31'; // ici
?>