<?php

include 'includes/geoip/geoipi.inc';

echo 'is shbat';

$timeup  =  microtime( true );

var_dump( check_shbat( "95.86.76.181" ) );

echo microtime( true ) - $timeup;

var_dump( jdtojewish( unixtojd( mktime(0,0,0,4,5,2012) ) ) );


var_dump( ( 1 & 1 ) ? true : false );

var_dump( date('c') );
var_dump( date('c',date_sunset( time() , SUNFUNCS_RET_TIMESTAMP , 31.7800459 , 35.2186025 , 90.846567 , 0 )) );

echo '<br />done';


/////////////////////////////////
////////////////////////////////

function check_shbat( $ip ){
	
	$time =  mktime(16,14,0,2,3,2012) ;//mktime(6,0,0,2,4,2012) ; //time( );
	$date = getdate( $time );
	
	$jd = unixtojd( $time );

	$maybeshabat = !( $date['wday'] < 5 && $date['wday'] > 0 );
	
	$h1 = check_holiday( jdtojewish( $jd - 1 ) );
	$h2 = check_holiday( jdtojewish( $jd     ) );
	$h3 = check_holiday( jdtojewish( $jd + 1 ) );
	
 	$holiday  =  $h1 || $h2 || $h3 ;
	
    if (!$maybeshabat && !$holiday) return true;
	
    
    
	$ii = get_ip_info( $ip );

	var_dump( date_sunset( $time , SUNFUNCS_RET_STRING , 31.7800459 , 35.2186025 , 90.846567 , 2 ));
	
	$set_time  =  date_sunset( $time , SUNFUNCS_RET_DOUBLE , 31.7800459 , 35.2186025 , 90.846567 , 2 );
	
	
	$preend = true;
	if( $set_time < 10 ) $preend = false;
	
	
    
	$h_now = ( ( ( $date['seconds'] / 60 ) + $date['minutes'] ) / 60 ) + $date['hours'];

    var_dump($ii);
	var_dump($date);
	var_dump($set_time);
	$time_space = 1;
	
    if($maybeshabat){
      if(  ( ($preend) &&
      	 ( ($date['wday'] == 5 && $h_now > $set_time - $time_space)||
      	   ($date['wday'] == 6 && $h_now < $set_time + $time_space)  )
      ) || ( (!$preend) &&
      	 ( ($date['wday'] == 6 && $h_now > $set_time - $time_space)||
           ($date['wday'] == 0 && $h_now < $set_time + $time_space)  )
      ) ){
      	return false;
      }
    }
    
    $isr = ( $ii->country_code == "IL" ) ? 1 : 3 ;
    
    if($holiday){
    	
       if( ( ($preend) &&
          ((($isr & $h2) && $h_now < $set_time + $time_space)||
           (($isr & $h3) && $h_now > $set_time - $time_space) )
        ) || ( (!$preend) &&
          ((($isr & $h1) && $h_now < $set_time + $time_space)||
           (($isr & $h2) && $h_now > $set_time - $time_space) )
        ) ){
       	return false;
       }
       return true;
       
    }else{
    	
       return true;

    }
	
   
}

function check_holiday( $jew_time ){
	
	$d = explode( '/', $jew_time );  
	if( count( $d ) < 3 )return -1;
	
	$month = $d[0];
	$day   = $d[1];
	
	switch( $month )
	{
		case 1:
			switch( $day ){
				case 1:
				case 2:
				case 10:
				case 15:
				case 22:
					return 1;
				case 16:
				case 23:
					return 2;
				default:
					return 0;
			}
		case 8:
			switch( $day ){
				case 15:
				case 21:
					return 1;
				case 16:
				case 22:
					return 2;
				default:
					return 0;
			}
		case 10:
			switch( $day ){
				case 6:
					return 1;
				case 7:
					return 2;
				default:
					return 0;
			}
		default:
			return 0;
	}
	return -1;
}
