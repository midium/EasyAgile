<?php
function GetTimePercentage($estimates, $remaining, $logged, $percentage_of){
  switch($percentage_of){
    case 'estimates':
      if($estimates == 0) return 0;
      if($estimates >= $logged) return 100;

      return ($estimates * 100) / $logged;

      break;

    case 'logged':
      if($estimates == 0 && $logged == 0) return 0;
      if($logged >= $estimates) return 100;

      return ($logged * 100) / $estimates;

      break;

    case 'remaining':
      if($remaining == 0) return 0;

      return ($remaining * 100) / $estimates;

      break;
  }
}

function SecondsToTimesheet($seconds){
  $dtF = new DateTime("@0");
  $dtT = new DateTime("@$seconds");
  $days = $dtF->diff($dtT)->format('%a');
  $hours =  $dtF->diff($dtT)->format('%h');
  $mins = $dtF->diff($dtT)->format('%i');

  $decimal_mins = number_format(($mins/60),2);

  if($hours !='0' && $hours != '') {

      if($mins == '' || $mins == '0'){
        return $hours;

      } else {
        return $hours+$decimal_mins;

      }

  } else {
    if($mins != ''){
      return $decimal_mins;

    } else {
      return '&nbsp;';

    }

  }
}

function SecondsToTimeString($seconds){
  $dtF = new DateTime("@0");
  $dtT = new DateTime("@$seconds");
  $days = $dtF->diff($dtT)->format('%a');
  $hours =  $dtF->diff($dtT)->format('%h');
  $mins = $dtF->diff($dtT)->format('%i');

  if($days != '0' && $days != ''){
    $hours += $days * 24;

    if ($mins == '') {
      return sprintf('%dh', $hours);

    } else {
      return sprintf('%dh %dm', $hours, $mins);

    }

  } elseif($hours !='0' && $hours != '') {

      if($mins == '' || $mins == '0'){
        return sprintf('%dh', $hours);

      } else {
        return sprintf('%dh %dm', $hours, $mins);

      }

  } else {
    if($mins != '' && $mins != '0'){
      return sprintf('%dm', $mins);

    } else {
      return '&nbsp;';

    }

  }

}

function StringToTimeSeconds($string){

  $exploded = explode(' ', trim($string));

  $total = 0;

  foreach($exploded as $piece){
    switch(substr($piece,-1)){
      case 'd':
        $num = substr($piece, 0, -1);
        //24 H in day, 60 M in 1 H, 60 sec in 1 M
        $total = $total + ($num * 24 * 60 * 60);

        break;

      case 'h':
      default:
        $num = (substr($piece,-1)=='h')?substr($piece, 0, -1):$piece;
        //60 M in 1 H, 60 sec in 1 M
        $total = $total + ($num * 60 * 60);

        break;

      case 'm':
        $num = substr($piece, 0, -1);
        //60 sec in 1 M
        $total = $total + ($num * 60);

        break;
    }

  }

  return $total;

}

?>
