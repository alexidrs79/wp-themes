<?php
/**
 * Abort unless running via CLI.
 *
 * @package Devotel
 */

if ( PHP_SAPI !== 'cli' && PHP_SAPI !== 'phpdbg' ) {
	http_response_code( 403 );
	header( 'Content-Type: text/plain; charset=UTF-8' );
	echo "Forbidden\n";
	exit( 1 );
}
