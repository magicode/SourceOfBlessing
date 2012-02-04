<?php


include  dirname( __FILE__ ) . '/geoipcity.inc';


function get_ip_info($ip){
	$load = geoip_is_load_shared_mem();

	if(! $load ){
		load_ip_db();
	}
    $gi = geoip_open( "", GEOIP_SHARED_MEMORY );
	$rec =  GeoIP_record_by_addr($gi, $ip);
	geoip_close( $gi );
	return $rec;
}

function load_ip_db(){
	geoip_load_shared_mem( dirname( __FILE__ ) . "/data/GeoLiteCity.dat" );
}