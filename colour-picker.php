<?php
/**
 * Output UI for Alfred
 * 
 * @TODO allow for hex, so `up > #00A299`
 * @TODO `random`
 * @TODO `rainbow` (needs API support)
 */

require 'workflows.php';
require 'helpers.php';

$workflow = new Workflows();

$query = ! isset( $argv[1] ) || empty( $argv[1] ) ? false : $argv[1];

$query      = trim( $query );
$subtitle   = '';

$colours = json_decode( file_get_contents( 'colour-lib.json' ), JSON_OBJECT_AS_ARRAY );
foreach ( $colours as $colour ) {

	$name = $colour[0];
	$rgb  = $colour[1];
	$hex  = $colour[2];

	if ( ! $query || ( $query && search_keyword_in_string( $query, $name ) ) ) {
		$workflow->result(
			md5( $hex ),
			json_encode([
				'name' => $name,
				'rgb'  => $rgb,
				'hex'  => $hex,
			]),
			ucfirst( $name ),
			$subtitle,
			'' // @TODO serve locally ..somehow. Alfred only accepts PNGs and ICNS.
		);
		$shown++;
	}
}

echo $workflow->toxml(); 
