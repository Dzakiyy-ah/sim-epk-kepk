<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if  (  !  function_exists('xTimeAgo'))
{
	function  xTimeAgo($oldTime, $newTime, $timeType)
	{
		$timeCalc = strtotime($newTime) - strtotime($oldTime);       
        if ($timeType == "x") {
            if ($timeCalc = 60) {
                $timeType = "m";
            }
            if ($timeCalc = (60*60)) {
                $timeType = "h";
            }
            if ($timeCalc = (60*60*24)) {
                $timeType = "d";
            }
        }       
        if ($timeType == "s") {
            $timeCalc .= " detik yang lalu";
        }
        if ($timeType == "m") {
            $timeCalc = round($timeCalc/60) . " menit yang lalu.";
        }       
        if ($timeType == "h") {
            $timeCalc = round($timeCalc/60/60) . " jam yang lalu.";
        }
        if ($timeType == "d") {
            $timeCalc = round($timeCalc/60/60/24) . " hari yang lalu.";
        }       
        return $timeCalc;	
	}
}

if  (  !  function_exists('timeAgo'))
{
	function  timeAgo($sekarang)
	{
		date_default_timezone_set('Asia/Jakarta');
		//$lalu 	= date('d.m.Y.H.i.s');
		$lalu 	= date('Y-m-d H:i:s');
		$isi	= str_replace("-","",xTimeAgo($lalu,$sekarang,"m"));
		$isi2	= str_replace("-","",xTimeAgo($lalu,$sekarang,"h"));
		$isi3	= str_replace("-","",xTimeAgo($lalu,$sekarang,"d"));
		$go		= "";
		if($isi > 60){
			$go = $isi2;
		}
		elseif($isi > 24){
			$go = $isi3;
		}
		elseif($isi < 61){
			$go = $isi;
		}
		return $go;
	}
}

if ( ! function_exists('bulan_list'))
{
  function bulan_list($kosong = 0)
  {
    $CI =& get_instance();
    $CI->lang->load('calendar');

    if($kosong) $result[0] = 'Semua bulan';
    $result['01'] = $CI->lang->line('cal_january');
    $result['02'] = $CI->lang->line('cal_february');
    $result['03'] = $CI->lang->line('cal_march');
    $result['04'] = $CI->lang->line('cal_april');
    $result['05'] = $CI->lang->line('cal_may');
    $result['06'] = $CI->lang->line('cal_june');
    $result['07'] = $CI->lang->line('cal_july');
    $result['08'] = $CI->lang->line('cal_august');
    $result['09'] = $CI->lang->line('cal_september');
    $result['10'] = $CI->lang->line('cal_october');
    $result['11'] = $CI->lang->line('cal_november');
    $result['12'] = $CI->lang->line('cal_december');

    return $result;
  }
}

if ( ! function_exists('bln_list'))
{
  function bln_list($kosong = 0)
  {
    $CI =& get_instance();
    $CI->lang->load('calendar');

    if($kosong) $result[0] = 'Semua bulan';
    $result['01'] = $CI->lang->line('cal_jan');
    $result['02'] = $CI->lang->line('cal_feb');
    $result['03'] = $CI->lang->line('cal_mar');
    $result['04'] = $CI->lang->line('cal_apr');
    $result['05'] = $CI->lang->line('cal_may');
    $result['06'] = $CI->lang->line('cal_jun');
    $result['07'] = $CI->lang->line('cal_jul');
    $result['08'] = $CI->lang->line('cal_aug');
    $result['09'] = $CI->lang->line('cal_sep');
    $result['10'] = $CI->lang->line('cal_oct');
    $result['11'] = $CI->lang->line('cal_nov');
    $result['12'] = $CI->lang->line('cal_dec');

    return $result;
  }
}

if ( ! function_exists('nama_bulan'))
{
  function nama_bulan($bulan)
  {
    $array_bulan = bulan_list();
    if(strlen($bulan) == 1) $bulan = '0'.$bulan;
    return $array_bulan[$bulan];
  }
}

if ( ! function_exists('nama_bln'))
{
  function nama_bln($bulan)
  {
    $array_bulan = bln_list();
    if(strlen($bulan) == 1) $bulan = '0'.$bulan;
    return $array_bulan[$bulan];
  }
}

if ( ! function_exists('to_rupiah'))
{
  function to_rupiah($value)
  {
    if($value < 0)
    {
      return '( Rp '.number_format(abs($value), 0, ',', '.').' )';
    }
    else
    {
      return 'Rp '.number_format($value, 0, ',', '.').'  ';
    }
  }
}

if ( ! function_exists('format_rupiah'))
{
  function format_rupiah($value)
  {
    if($value < 0)
    {
      return '( '.number_format(abs($value), 2, ',', '.').' )';
    }
    else
    {
      return '  '.number_format($value, 2, ',', '.').'  ';
    }
  }
}

if ( ! function_exists('prepare_numeric'))
{
  function prepare_numeric($value, $default = null)
  {
    if(isset($value) && $value != '')
      return floatval(str_replace('.','',$value)) * 1;
    return $default;
  }
}

if ( ! function_exists('format_date'))
{
  function format_date($date, $style='d/m/Y')
  {
    if (isset($date))
      return date($style, strtotime( $date ) );
    return '';
  }
}

if ( ! function_exists('prepare_date'))
{
  function prepare_date($date)
  {
    if (isset($date) && $date != '')
      return implode( "-", array_reverse( explode("/", $date ) ) );
    return null;
  }
}

if ( ! function_exists('periode_text'))
{
  function periode_text($date)
  {
    if (isset($date) && $date != '')
    {
      $month = nama_bulan(date("m",strtotime($date)));
      $year = date("Y", strtotime($date));

      return $month.' '.$year;
    }
    return null;
  }
}

if  (  !  function_exists('simpan_logaktivitas_tim_kepk'))
{
  function  simpan_logaktivitas_tim_kepk($aktivitas, $user_kepk, $user)
  {
    $ci =& get_instance();
    $ci->load->database();

    date_default_timezone_set('Asia/Jakarta');
    $waktu   = date('d.m.Y.H.i.s');

    $data = array(
        'aktivitas' => $aktivitas,
        'id_user_kepk' => $user_kepk,
        'id_user' => $user
      );
    $ci->db->insert('log_aktivitas_tim_kepk', $data);
  }
}

if ( ! function_exists('get_order_by_str'))
{
  function get_order_by_str($param, $fieldmap)
  {
    $ob = '';
    if (array_key_exists($param, $fieldmap))
    {
      $ob = $fieldmap[ $param ];
    }
    return $ob;
  }
}

if ( ! function_exists('get_where_str'))
{
  function get_where_str($param, $fieldmap)
  {
    $wh = array();
    foreach($param as $key => $value){
      if (array_key_exists($key, $fieldmap))
      {
        $fld = "";
        $datatype = isset($value['search_datatype']) ? $value['search_datatype'] : null;
        $op = $value['search_op'];
        if ($datatype === 'date')
        {
          $fld = $fieldmap[ $key ];
          $str = isset($value['search_str']) ? strtoupper(prepare_date($value['search_str'])) : null;
          $str2 = isset($value['search_str2']) ? strtoupper(prepare_date($value['search_str2'])) : null;
        }
        else
        {
          $fld = "UPPER(".$fieldmap[ $key ].")";
          $str = isset($value['search_str']) ? strtoupper($value['search_str']) : null;
          $str2 = isset($value['search_str2']) ? strtoupper($value['search_str2']) : null;
        }

        if ($datatype === 'numeric')
        {
          switch($op)
          {
            case "eq" : $fld .= " = "; $str = $str; $wh[ $fld ] = (double)$str; break;
            case "ne" : $fld .= " != "; $str = $str; $wh[ $fld ] = (double)$str; break;
            case "lt" : $fld .= " < "; $str = $str; $wh[ $fld ] = (double)$str; break;
            case "le" : $fld .= " <= "; $str = $str; $wh[ $fld ] = (double)$str; break;
            case "gt" : $fld .= " > "; $str = $str; $wh[ $fld ] = (double)$str; break;
            case "ge" : $fld .= " <= "; $str = $str; $wh[ $fld ] = (double)$str; break;
            case "in" : $fld .= " >= "; $fld1 = $fieldmap[ $key ]." <= "; $wh[ $fld ] = (double)$str; $wh[ $fld1 ] = (double)$str2; break;
            default : ;
          }
        }
    else if ($datatype === 'time')
        {
          switch($op)
          {
            case "cn" : $fld .= " LIKE "; $str = "%".$str."%"; $wh[ $fld ] = $str; break;
            case "ne" : $fld .= " != "; $str = $str; $wh[ $fld ] = $str; break;
            case "lt" : $fld .= " < "; $str = $str; $wh[ $fld ] = $str; break;
            case "le" : $fld .= " <= "; $str = $str; $wh[ $fld ] = $str; break;
            case "gt" : $fld .= " > "; $str = $str; $wh[ $fld ] = $str; break;
            case "ge" : $fld .= " <= "; $str = $str; $wh[ $fld ] = $str; break;
            case "in" : $fld .= " >= "; $fld1 = $fieldmap[ $key ]." <= "; $wh[ $fld ] = $str; $wh[ $fld1 ] = $str2; break;
            default : ;
          }
    }
        else if ($datatype === 'date')
        {
          switch($op)
          {
            case "eq" : $fld .= " = "; $str = $str; $wh[ $fld ] = $str; break;
            case "ne" : $fld .= " != "; $str = $str; $wh[ $fld ] = $str; break;
            case "lt" : $fld .= " < "; $str = $str; $wh[ $fld ] = $str; break;
            case "le" : $fld .= " <= "; $str = $str; $wh[ $fld ] = $str; break;
            case "gt" : $fld .= " > "; $str = $str; $wh[ $fld ] = $str; break;
            case "ge" : $fld .= " <= "; $str = $str; $wh[ $fld ] = $str; break;
            case "in" : $fld .= " >= "; $fld1 = $fieldmap[ $key ]." <= "; $wh[ $fld ] = $str; $wh[ $fld1 ] = $str2; break;
            default : ;
          }
        }
        else
        {
          switch($op)
          {
            case "eq" : $fld .= " = "; $str = $str; $wh[ $fld ] = $str;  break;
            case "ne" : $fld .= " != "; $str = $str; $wh[ $fld ] = $str; break;
            case "lt" : $fld .= " < "; $str = $str; $wh[ $fld ] = $str; break;
            case "le" : $fld .= " <= "; $str = $str; $wh[ $fld ] = $str; break;
            case "gt" : $fld .= " > "; $str = $str; $wh[ $fld ] = $str; break;
            case "ge" : $fld .= " <= "; $str = $str; $wh[ $fld ] = $str; break;
            case "bw" : $fld .= " LIKE "; $str = $str."%"; $wh[ $fld ] = $str; break;
            case "bn" : $fld .= " NOT LIKE "; $str = $str."%"; $wh[ $fld ] = $str; break;
            case "in" : $fld .= " >= "; $fld1 = "UPPER(".$fieldmap[ $key ].") <= "; $wh[ $fld ] = $str; $wh[ $fld1 ] = $str2; break;
            case "ew" : $fld .= " LIKE "; $str = "%".$str; $wh[ $fld ] = $str; break;
            case "en" : $fld .= " NOT LIKE "; $str = "%".$str; $wh[ $fld ] = $str; break;
            case "cn" : $fld .= " LIKE "; $str = "%".$str."%"; $wh[ $fld ] = $str; break;
            case "nc" : $fld .= " NOT LIKE "; $str = "%".$str."%"; $wh[ $fld ] = $str; break;
            case "nu" : $str = " NULL "; $wh[ $fld ] = $str; break;
            case "nn" : $str = " NOT NULL "; $wh[ $fld ] = $str; break;
            default : ;
          }
        }
      }
    }
    return $wh;
  }
}


if ( ! function_exists('get_working_days'))
{
  function get_working_days($startDate, $endDate)
  {
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate ?? '');


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
    //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
    $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    return $workingDays;
  }
}
