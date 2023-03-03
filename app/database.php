<?php

// Fonction de connexion et fonction de déconnexion à la BDD

$mysql = null;

function dbConnect(): mysqli
{
	global $mysql;

	if( is_null( $mysql ) ) {
		$mysql = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	}

	return $mysql;
}

function dbClose(): void
{
	global $mysql;

	if( ! is_null( $mysql ) ) {
		mysqli_close( $mysql );
	}

	$mysql = null;
}
