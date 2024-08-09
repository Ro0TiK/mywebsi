<?
function curPageURL() {
$pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$wb_status_array = array('coach'=>
							array('incomplete'=>get_component_types('workbook', $getlang).' is incomplete.', 
							'ready'=>get_component_types('workbook', $getlang).' is ready to be printed.<br>Note that once you mark it as completed, you will not be able to make any changes.<br>In order to register for a Workshop, the Workbook needs to be marked as completed.', 
							'submitted'=>get_component_types('workbook', $getlang).' has been submitted and can be printed.', 
							'failed'=>'Component(s) of '.get_component_types('workbook', $getlang).' need to be corrected.<br>Please correct items with \'X\' on the left.', 
							'passed'=>'Congratulations.  You have completed this '.get_component_types('workbook', $getlang).'.'));		

$pf_status_array = array('coach'=>
							array('incomplete'=>get_component_types('portfolio', $getlang).' is incomplete.', 
							'ready'=>get_component_types('portfolio', $getlang).' is ready to be submitted.<br>Note that once you submit it, you will not be able to make any changes.', 
							'submitted'=>get_component_types('portfolio', $getlang).' has been submitted and will be evaluated.', 
							'failed'=>'Component(s) of '.get_component_types('portfolio', $getlang).' need to be corrected.<br>Please correct items with \'X\' on the left.', 
							'passed'=>'Congratulations.  You have completed this '.get_component_types('portfolio', $getlang).'.<br>You may now register for an Evaluation.'),
					'evaluator'=>
							array('incomplete'=>get_component_types('portfolio', $getlang).' has not been completed by coach.', 
							'ready'=>get_component_types('portfolio', $getlang).' is ready to be submitted by the coach for evaluation.', 
							'submitted'=>get_component_types('portfolio', $getlang).' has been submitted by the coach and is pending evaluation.', 
							'failed'=>'Component(s) of '.get_component_types('portfolio', $getlang).' need to be corrected by the coach.', 
							'passed'=>'This coach has completed and passed this '.get_component_types('portfolio', $getlang).'.'));		

function getIP() {
		$ip;
		if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR");
		else $ip = "UNKNOWN";
		return $ip;
}

if (getIP() == '154.20.224.96'){
//if ($search_payments){	
	//$SelectStr = "SELECT * FROM NCCP_Canada_Coaches WHERE coach_payments LIKE '%20%' ORDER BY $sortby";
	//echo "$SelectStr $access_level<br>";
//}
}
if (!function_exists('valid_email')){
	function valid_email($em){
		return filter_var($em, FILTER_VALIDATE_EMAIL); 
	}
}
function GetTime ($timedifference) {

   if ($timedifference >= 3600) {
       $hval = ($timedifference / 3600);
       $hourtime = intval($hval);

       $leftoverhours = ($timedifference % 3600);

       $mval = ($leftoverhours / 60);
       $minutetime = intval($mval);

       $leftoverminutes = ($leftoverhours % 60);
       $secondtime = intval($leftoverminutes);

       $hourtime = str_pad($hourtime, 2, "0", STR_PAD_LEFT);
       $minutetime = str_pad($minutetime, 2, "0", STR_PAD_LEFT);
       $secondtime = str_pad($secondtime, 2, "0", STR_PAD_LEFT);

       return "$hourtime:$minutetime:$secondtime";
   }

   if ($timedifference >= 60) {

       $hourtime = 0;

       $mval = ($timedifference / 60);
       $minutetime = intval($mval);

       $leftoverminutes = ($timedifference % 60);
       $secondtime = intval($leftoverminutes);

       $hourtime = str_pad($hourtime, 2, "0", STR_PAD_LEFT);
       $minutetime = str_pad($minutetime, 2, "0", STR_PAD_LEFT);
       $secondtime = str_pad($secondtime, 2, "0", STR_PAD_LEFT);

       return "$hourtime:$minutetime:$secondtime";
   }

   
   $hourtime = 0;
   $minutetime = 0;
   if ($timedifference < 0 ) { $secondtime = 0; }
   else {    $secondtime = $timedifference; }

   $hourtime = str_pad($hourtime, 2, "0", STR_PAD_LEFT);
   $minutetime = str_pad($minutetime, 2, "0", STR_PAD_LEFT);
   $secondtime = str_pad($secondtime, 2, "0", STR_PAD_LEFT);

   return "$hourtime:$minutetime:$secondtime";
   
}
function duration ($seconds, $suffix=FALSE) {
   $takes_time = array(604800,86400,3600,60,0);
   $suffixes = array("Week","Day","Hour","Minute","Second");
   $delimeter = array(" W ", " D ", ":",":","");
   $output = "";
   foreach ($takes_time as $key=>$val) {
       ${$suffixes[$key]} = ($val == 0) ? $seconds : floor(($seconds/$val));
       $seconds -= ${$suffixes[$key]} * $val;
       if (${$suffixes[$key]} > 0 || (!empty($output) && $suffix == FALSE)) {
           if ($val == 0 && $suffix == FALSE && empty($output)) {
               $output .= "00:";
           }
           $output .= ($key > 1 && strlen(${$suffixes[$key]}) == 1 && $suffix == FALSE) ? "0".${$suffixes[$key]} : ${$suffixes[$key]};
           if ($suffix == "short") {
               $output .= substr($suffixes[$key],0,1)." ";
           }
           elseif ($suffix == "long") {
               $output .= (${$suffixes[$key]} > 1) ? " ".$suffixes[$key]."s " : " ".$suffixes[$key]." ";
           }
           else {
               $output .= $delimeter[$key];
           }
       }
   }
   return $output;
}

function array_csort() { 
	$args = func_get_args();
	$marray = array_shift($args);
			
	$msortline = "return(array_multisort(";
	foreach ($args as $arg) {
		$i++;
		if (is_string($arg)) {
			foreach ($marray as $row) {
				$sortarr[$i][] = $row[$arg];
			}
		} else {
			$sortarr[$i] = $arg;
		}
		$msortline .= "\$sortarr[".$i."],";
	}
	$msortline .= "\$marray));";

	eval($msortline);
	return $marray;
}

function is_date($date){

	$check_year = substr($date, 0, 4);
	$check_month = substr($date, 5, 2);
	$check_day = substr($date, 8, 2);
	//echo "is date: $check_year, $check_month, $check_day<br>";
	return checkdate ( $check_month, $check_day, $check_year );

}
 
function httpbuildquery ($arr, $glue){
	$ret = '';
	$i=0;
	foreach ($arr as $k=>$v){
		if ($i!=0){
			$ret .= $glue;
		}
		$ret .= $k."=".$v;
	}
}

function Post($url, $post = null) 
{ 
	$content = ''; 
	$flag = false; 
	$post_query = httpbuildquery($post, "&"); // name-value pairs 
	$post_query = urlencode($post_query) . "\r\n"; 
    $url = parse_url($url);
    if ($url['scheme'] != 'http') { 
        die('Only HTTP request are supported !');
    }
 
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];
	$fp = fsockopen($host, '80'); 
	// This is plain HTTP; for HTTPS, use 
	// $fp = fsockopen($host, '443'); 
	if ($fp) { 
	  fputs($fp, "POST $path HTTP/1.0\r\n"); 
	  fputs($fp, "Host: $host\r\n"); 
	  fputs($fp, "Content-length: ". strlen($post_query) ."\r\n\r\n"); 
	  fputs($fp, $post_query); 
	  while (!feof($fp)) { 
		$line = fgets($fp, 10240); 
		if ($flag) { 
		  $content .= $line; 
		} else { 
		  $headers .= $line; 
		  if (strlen(trim($line)) == 0) { 
			$flag = true; 
		  } 
		} 
	  } 
	  fclose($fp); 
	
	
	
	} 
	return $content;
	
} 



function save_buttons(){
	GLOBAL $evaluator;
	GLOBAL $evaluation;
	GLOBAL $host_url;
	
	if ($evaluator){
		$doeval = "?evaluation=$evaluation&do_evaluation=evaluator";
	} else {
		$doeval = "";
	}
	echo "
	<p align='center'><a class=bluehover href='http://$host_url/status.php$doeval'>Done</a>&nbsp;&nbsp;
	  <input type='submit' name='Submit1' value='Save'>
	  <input type='submit' name='Submit2' value='Save & Complete'>
	  <input type='submit' name='Submit3' value='Save & Exit >>'>
	</p>";
	echo "
	<p align='center'>
	<b>NOTE:</b> You will not be able to make any changes once you hit 'Save & Complete'.
	</p>
	";
}

function show_stream_boxes(){
	$breakdown_only = true;
	GLOBAL $current_language;
	GLOBAL $getlang;
	include($_SERVER["DOCUMENT_ROOT"]."/includes/mysql.php");
	#open the database
	$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect("$localhost", $MysqlName, $MysqlPW));

	$str = "SELECT * FROM NCCP_Canada_Contexts, NCCP_Canada_Streams WHERE context_stream=stream_id ORDER BY context_id ";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);
	for ($i=0;$i<$rc;$i++){
		$context_id = mysqli_result($res, $i, "context_id");
		$context_name = mysqli_result($res, $i, "context_".$getlang."_name");
		$stream_id = mysqli_result($res, $i, "context_stream");
		$context_stream = mysqli_result($res, $i, "stream_name_".$getlang);
		$context_active = mysqli_result($res, $i, "context_active");
		$linkto[$context_name] = mysqli_result($res, $i, "context_public_page");
		if ($context_active){
			$str2 = "SELECT * FROM NCCP_Canada_Levels, NCCP_Canada_Positions WHERE level_context=$context_id AND level_position=position_id ORDER BY level_position ";
			$res2 = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str2) : false);
			$rc2 = mysqli_num_rows($res2);

			for ($j=0;$j<$rc2;$j++){
				$level_modules_required = mysqli_result($res2, $j, "level_modules_required");
				$position_name = mysqli_result($res2, $j, "position_".$getlang."_name");
				$mods = explode('|', $level_modules_required);
				foreach ($mods as $modid){
					$str3 = "SELECT module_".$getlang."_name FROM NCCP_Canada_Modules WHERE module_id=$modid";
					$res3 = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str3) : false);
					$rc3 = mysqli_num_rows($res3);
					if ($rc3){
						$mod_name = mysqli_result($res3, 0, "module_".$getlang."_name");
						$status_array[$context_stream][$context_name][$position_name][] = $mod_name;
					}
				}
			}
			
		} else {
			$status_array[$context_stream][$context_name] = $context_active;
		}
		if ($stream_id == 1){
			$blank_stream = $context_stream;
		}
	}
	$status_array[$blank_stream]["&nbsp;"] = 0; // ADD BLANK BOX UNDER COMMUNITY
	$text = "<table align='center' width='600' border='0' cellpadding='4' cellspacing='12' class='blackline' style='background-color: #DDDDDD; '>\n";

	// THEN DISPLAY THE STATUS BOXES
	$text .=  "<tr align='center'>";
	foreach ($status_array as $stream=>$value1){
		if ($current_language != 'french'){
			$text .=  "<td height='20' width='33%'><u><b style='font-size: 8pt;'>$stream<br>Stream</b></u></td>";
		} else {
			$text .=  "<td height='20' width='33%'><u><b style='font-size: 8pt;'>profil<br>$stream</b></u></td>";
		}
	}		 
	$text .=  "</tr>";
	
	for ($i = 0; $i < 4;$i++){
		$text .=  "<tr align='center'>";
		foreach ($status_array as $stream=>$value1){
			$j = 0;
			foreach ($value1 as $context=>$value2){
				$span = '';
				if ($j == $i){
					if ($value2){
						$st = '';
					} else {
						$st = "style='opacity:.40;filter: alpha(opacity=40); -moz-opacity: 0.40;'";
					}
					if ( !substr_count($context,'&nbsp;')){
						$text .=  "<td height='80' width='33%' class='redline' $st>";
					} else {
						$text .=  "<td height='80' width='33%'>";
					}
					
					if ($st && !substr_count($context,'&nbsp;')){
						$text .=  "<b style='font-size: 8pt;'>$context</b>";
						if ($current_language != 'french'){
							$text .=  "<br><br><font style='font-size:8pt;'>To be developed</font>\n";
						} else {
							$text .=  utf8_encode("<br><br><font style='font-size:8pt;'>En développement</font>\n");
						}
					} elseif (!$st) {
						foreach ($value2 as $position=>$mods){
							$span = "<br><ul>";
							foreach ($mods as $k=>$val){
								$span .= "<li>";
								$span .= "$val";
								$span .= "</li>";
							}
							$span .= "</ul>";
							
							$text .=  "<a class='info' href='index.php?page=".$linkto[$context]."'>$position<span>$span</span></a><br>";
						}
					}
					$text .=  "</td>";
				}
				$j++;
			}
		}
		$text .=  "</tr>";
	}
    $text .=  "</table>\n";
	
	return $text;
}

function date_to_french($d){
	$mon_array = array('Jan'=>'Jan',
						'Feb'=>'Fév',
						'Mar'=>'Mar',
						'Apr'=>'Avr',
						'May'=>'Mai',
						'Jun'=>'Juin',
						'Jul'=>'Juil',
						'Aug'=>'Août',
						'Sep'=>'Sep',
						'Oct'=>'Oct',
						'Nov'=>'Nov',
						'Dec'=>'Déc'						
						);
	foreach ($mon_array as $key=>$value){
		if (substr_count($d, $key)){
			$d_new = str_replace($key, $value, $d);			
		}
	}
	return $d_new;
}

function safestrtotime ($s) {
       $basetime = 0;
       if (preg_match ("/19(\d\d)/", $s, $m) && ($m[1] < 70)) {
               $s = preg_replace ("/19\d\d/", 1900 + $m[1]+68, $s);
               $basetime = 0x80000000 + 1570448;
       }
       return $basetime + strtotime ($s);
}							
function get_date($val, $type, $field, $i=null, $br=null, $picker=false){
	GLOBAL $included_scripts;
	GLOBAL $current_language;
//echo "$val $type<br>";
				if ($val && !substr_count($val, '0000-00-00')){
					$val_date = strtotime ($val);
					$vmonth = date("n", $val_date);
					$vday = date("j", $val_date);
					$vyear = date("Y", $val_date);
//echo $vmonth;					
				} else {
					$vmonth = '';
					$vday = '';
					$vyear = '';
				}
				$timestr = substr ( $val, 11);  
				if (strcmp($timestr, '00:00:00') && ($val != '')){
					$val_date = strtotime ($val);	 
					$vhour = date("g", $val_date);
					$vmin = date("i", $val_date);
					$vampm = date("a", $val_date);
				} else {
					$vhour = '';
					$vmin = '';
					$vampm = '';
				}	
				
				if (is_numeric($i)){
					$ishow = "[$i]";
				} else {
					$ishow = "";
				}
				if ($picker){
					if (!$included_scripts){
						$included_scripts=true;
						echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/includes/datetimepicker/build/jquery.datetimepicker.min.css\"/ >
						<script src=\"/includes/datetimepicker/jquery.js\"></script>
						<script src=\"/includes/datetimepicker/build/jquery.datetimepicker.full.min.js\"></script>	
						";
						?>
						<script>
						$(document).ready(function(){		
							$('.datetimepicker').datetimepicker({format: 'Y-m-d H:i', step:5});
							$('.datepicker').datetimepicker({format: 'Y-m-d', timepicker:false});
							$('.timepicker').datetimepicker({format: 'H:i', step:5, datepicker:false});
						});
						</script>
						<?
					}
					if ($type == 'datetime'){
						$thisclass = 'datetimepicker';
						$placeholder = "YYYY-MM-DD HH:MM:SS";
					} elseif ($type == 'date'){
						$thisclass = 'datepicker';
						$placeholder = "YYYY-MM-DD";
					} elseif ($type == 'time'){
						$thisclass = 'timepicker';
						$placeholder = "HH:MM";
					}
					echo "<input class='$thisclass' type='text' name='$field$ishow' value='$val' placeholder='$placeholder'>\n";
					
					
				} else {
								if ($type != 'time'){
									echo "<select id='".$field."_month".$ishow."' name='".$field."_month".$ishow."' class='input-small'>\n";
									echo "<option value=''>M</option>\n";
									for ($j = 1; $j <= 12; $j++){
										if ($vmonth == $j){
											$selected = 'selected';
										} else {
											$selected = '';
										}
										$mon = date("M", mktime (0,0,0,$j,1,98));
										if ($current_language == 'french'){
											$mon = date_to_french($mon);
										}
										echo "<option value='$j' $selected>$mon</option>\n";
									}	
									echo "</select>\n";
									echo "<select id='".$field."_day".$ishow."' name='".$field."_day".$ishow."' class='input-mini'>\n";
									echo "<option value=''>D</option>\n";
									for ($j = 1; $j <= 31; $j++){
										if ($vday == $j){
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "$j $day<option value='$j' $selected>$j</option>\n";
									}	
									echo "</select>\n";
									echo "<select id='".$field."_year".$ishow."' name='".$field."_year".$ishow."' class='input-small'>\n";
									echo "<option value=''>Y</option>\n";
									if (substr_count($field, "birth")){
										$year1 = 1900;
										$year2 = date("Y");
									} else {
										$year1 = date("Y")-5;
										$year2 = date("Y")+10;
									}
									for ($j = $year1; $j <= $year2; $j++){
										if ($vyear == $j){
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "<option value='$j' $selected>$j</option>\n";
									}
									if ($vyear == '2004'){
										$selected = 'selected';
									} else {
										$selected = '';
									}
									echo "</select>\n";
								}
								if ($type != 'date'){
									if ($type == 'datetime'){
										if ($br){
											echo "<br><br>Time:";
										} else {
											echo "&nbsp;&nbsp;&nbsp;Time:";
										}
									}
									echo "<select name='".$field."_hour".$ishow."' class='input-mini' >\n";
									echo "<option value='' >H</option>\n";
									for ($j = 1; $j <= 12; $j++){
											 if ($vhour == $j){
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "<option value='$j' $selected>$j</option>\n";
									}	
									echo "</select>\n";
									echo "<select name='".$field."_minute".$ishow."' class='input-mini'>\n";
									echo "<option value='' >M</option>\n";
										for ($j = 0; $j <= 60; $j++){
											if ($j < 10){
												$j = '0'.$j;
											}
											if ($vmin == $j){
												$selected = 'selected';
											} else {
												$selected = '';
											}
											echo "<option value='$j' $selected>$j</option>\n";							
										}
									
									echo "</select>\n";              
									echo "<select name='".$field."_ampm".$ishow."' class='input-mini'>\n";
									echo "<option value='' ></option>\n";
									if ($vampm == am){
											echo "	<option value='am' selected>am</option>\n";
										echo "	<option value='pm'>pm</option>\n";
									} else {
										if ($vampm == pm){	
												echo "	<option value='am'>am</option>\n";
											echo "	<option value='pm' selected>pm</option>\n";
										} else {
												echo "	<option value='am'>am</option>\n";
											echo "	<option value='pm'>pm</option>\n";
										}	
									}	
									echo "</select>\n";  
								}					
				}
				if ($val){
					if (substr_count($field, "birth")){
						$age = get_age($val);
						echo "&nbsp;&nbsp;<b>Age:</b> $age";
					}
				}     
				//echo "&nbsp;&nbsp;$val";     
} 

function get_age($bday){ // $bday is in format YYYY-MM-DD

	if (substr_count($bday, '0000-00-00')){
		$age = 0;
	} else {
		$val_date = strtotime ($bday);
		$vmonth = date("m", $val_date);
		$vday = date("j", $val_date);
		$vyear = date("Y", $val_date);
	
		//Find the difference in year, month, and day 
		$yeardiff = date("Y") - $vyear; 
		$monthdiff = date("m") - $vmonth; 
		$daydiff = date("j") - $vday; 
		
		/* 
		 * if month or day is negative we have yet to reach it so 
		 * we need to subtract a year seeing we haven't 
		 * reached our birthday yet, else yeardiff is correct 
		 */ 
		
		if ($monthdiff <= 0){
			 if ($monthdiff == 0){
				if ($daydiff < 0){
					$age = $yeardiff - 1;
				} else {
					$age = $yeardiff;
				}			
			 } else {
				$age = $yeardiff - 1;
			 } 
			
		} else { 
		   $age = $yeardiff; 
		} 
	}		
	return $age; 
	
}

function get_columns($table){
	GLOBAL $link;
	GLOBAL $dbName;
	$columns = array();
	$SelectStr = "SHOW COLUMNS FROM $table";
	$Results = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $SelectStr) : false);
	$RowCount = mysqli_num_rows($Results);
	//echo "$SelectStr $Results $RowCount<br>";
	for ($z = 0; $z < $RowCount; $z++) {
		$field_name = mysqli_fetch_array($Results,  MYSQLI_NUM);
		$fname = $field_name[0];
		$columns[] = $fname;
		//echo "$fname<br>";
	}
	return $columns;
}
function get_component_types($compshort, $lang){
	GLOBAL $link;
	GLOBAL $dbName;
	$SelectStr = "SELECT * FROM NCCP_Canada_Component_Types WHERE type_short='$compshort'";
	$Results = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $SelectStr) : false);
	$RowCount = mysqli_num_rows($Results);
	//echo "$SelectStr $Results $RowCount<br>";
	if ($RowCount){
		if ($lang == 'french'){
			return mysqli_result($Results, 0, "type_frn");
		} else {
			return mysqli_result($Results, 0, "type_eng");
		}
	}
}

function check_workbook_complete($workbook, $coach){
	GLOBAL $link;
	GLOBAL $dbName;

	// for non-eval questions, check the number of questions for workbook against number of answers for workbook
	$str = "SELECT * FROM NCCP_Canada_Workbook_Questions WHERE w_q_workbook=$workbook AND w_q_type!='eval' AND w_q_required=1";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
	$numquestions = mysqli_num_rows($res);

	$str = "SELECT w_a_coach, w_a_question,w_a_answers  FROM NCCP_Canada_Workbook_Answers, NCCP_Canada_Workbook_Questions 
														WHERE w_a_coach=$coach 
														AND w_a_question_eval=0 
														AND w_q_workbook=$workbook 
														AND w_q_required=1 
														AND w_a_answers!='' 
														AND w_a_question=w_q_id
														GROUP BY w_a_coach, w_a_question
														ORDER BY w_a_saved_date DESC
														";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
	$numanswers = mysqli_num_rows($res);
	$na=$numanswers;
	for ($i=0;$i<$na;$i++){
		$ans = mysqli_result($res, $i, "w_a_answers");
		$ans = str_replace("|", "", $ans);
		if ($ans == ''){
			$numanswers--;
		}
	}
	if ($_SERVER['REMOTE_ADDR'] == '70.79.177.80'){
	//	echo "<BR>numquestions: $numquestions, numanswers:$numanswers<br>";
	}
	// for eval questions, check if all questions are answered
	$str = "SELECT * FROM NCCP_Canada_Workbook_Questions_Evals, NCCP_Canada_Workbook_Questions WHERE w_q_workbook=$workbook AND w_q_type='eval' AND wqe_wq_id=w_q_id";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
	$num_eval_questions = mysqli_num_rows($res);

	$str = "SELECT DISTINCT w_a_coach, w_a_question_eval FROM NCCP_Canada_Workbook_Answers, NCCP_Canada_Workbook_Questions WHERE w_a_coach=$coach AND w_a_question_eval!=0 AND w_q_workbook=$workbook AND w_a_question=w_q_id";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
	$num_eval_answers = mysqli_num_rows($res);
	//echo "<BR>num_eval_questions: $num_eval_questions, num_eval_answers:$num_eval_answers<br>";

	if ($numquestions == $numanswers && $num_eval_questions == $num_eval_answers){
		return true;
	} else {
		return false;
	}
}

// MULTIPLE OPTION FUNCTION
function do_multiple($drill_section, $category, $sub_category, $num_options=0, $x=0, $textarea=0, $colspan=1, $rowspan=1){
	
		GLOBAL $prac_option_value;
		GLOBAL $prac_drill_id;
		GLOBAL $prac_completed;
		GLOBAL $prac_drill_text;
		GLOBAL $this_section;
		GLOBAL $do_edit;
		GLOBAL $evaluation;
		GLOBAL $current_language;
		GLOBAL $translations;
		if (!$current_language){
			$current_language='english';
		}
		
		$cl = '';
		//if ($this_section[$drill_section] == 'offense' && $category != 'offense'){
			$cl = 'blacksides';
		//}
		echo "<td valign='top' colspan='$colspan' rowspan='$rowspan' align='center' class='$cl'><table border=0 width='100%'>\n";
		if ($num_options == 0 && !$textarea){ // multiple options
			if (!$sub_category){
				$num = count($prac_option_value[$current_language][$category], COUNT_RECURSIVE);
			} else {
				$num = count($prac_option_value[$current_language][$category][$sub_category]);
			}
		} else {
			$num = 1;
		}
		$num_drills = count($prac_drill_id[$drill_section]);
		//echo "num is $num<br>";
		for ($j = 1; $j <= $num; $j++){
			$this_o_id = 0;
			$disp = 'none';
			if ($j <= $num_drills+1){
				$disp = '';
			} 
			if ($do_edit || $j <= $num_drills){
				echo "<tr align='center' id='".$drill_section."_".$x."_".$j."' style='display:$disp'>\n";
				//echo "$num_drills --  $drill_section"; 
				if ($textarea){
					echo "<td align='left' class='normal'>\n";
				   if ($do_edit){		
						echo "<textarea name='drill[$drill_section][$x][$j]' cols=90 rows=6>".$prac_drill_text[$drill_section]."</textarea>";
						echo "<input type='hidden' name=\"id[$drill_section][$x][$j]\" value='".$prac_drill_id[$drill_section][$x][$j]."' >\n";
				   } else {
					echo $prac_drill_text[$drill_section];
				   }
				} else {
					echo "<td align='center' class='normal'>\n";
					echo "$j) ";
					if ($do_edit){
						echo "<select name='drill[$drill_section][$x][$j]' onChange=\"shownext('".$drill_section."_".$x."_".($j+1)."');\">\n";
						echo "<option value=''>".$translations['select one']."</option>\n";
					} else {
						echo "&nbsp;&nbsp;";
					}
					foreach ($prac_option_value as $lang=>$pov){
						foreach ($pov[$category] as $sub_cat=>$val){
							if ($sub_cat == $sub_category || !$sub_category){
								foreach ($val as $o_id=>$value){
									$selected = '';
									if ($prac_drill_id[$drill_section][$o_id][$j]){
										$selected = 'selected';
										$this_o_id = $o_id;
										if (!$do_edit){
											echo "$value";
										}
										$lang_only = false;
									} else {
										$lang_only = true;
									}
									if ($do_edit){
										if ($lang==$current_language || !$lang_only){
											echo "<option value='$o_id' $selected>$value</option>\n";
										}
									}
								}
							}		
						}
					}
					if ($do_edit){
						echo "</select>\n";
						echo "<input type='hidden' name=\"id[$drill_section][$x][$j]\" value='".$prac_drill_id[$drill_section][$this_o_id][$j]."' >\n";
					}
				}
				echo "</td>\n";
				echo "</tr>\n";
			}
		}
		echo "</table></td>\n";  
}
// MULTIPLE OPTION FUNCTION
function do_multiple_options($category, $sub_category){
	
		GLOBAL $prac_option_value;
		GLOBAL $prac_option_coach_id;
		GLOBAL $prac_option_link;
		
		echo "<td valign='top' align='center'><table border=0 width='100%'>";
		$num = count($prac_option_value[$category][$sub_category]);
		$j = 1;
		foreach ($prac_option_value[$category][$sub_category] as $o_id=>$value){
			if (!$prac_option_coach_id[$o_id]){
				echo "<tr align='center' id='".$category."_".$sub_category."_".$j."' style='display:$disp'>\n";
				echo "<td align='center' class=normal>\n";
				echo $value;
				if ($prac_option_link[$o_id]){
					echo "&nbsp;&nbsp;(<a href='$prac_option_link[$o_id]' target='_blank' class='redlink'>see drill</a>)";
				}
				echo "</td>\n";
				echo "</tr>\n";
			} else {
				$disp = 'none';
				if ($j <= count($prac_option_value[$category][$sub_category])){
					$disp = '';
				} 
				echo "<tr align='center' id='".$category."_".$sub_category."_".$j."' style='display:$disp'>\n";
				echo "<td align='center'>\n";
				echo "<input name=\"option[".$category."][".$sub_category."][$j]\" value='$value' style='text-align:center;' onFocus=\"shownext('".$category."_".$sub_category."_".($j+1)."');\">\n";
				echo "<input type='hidden' name=\"id[".$category."][".$sub_category."][$j]\" value='$o_id' >\n";
				echo "</td>\n";
				echo "</tr>\n";
				$j++;
			}
		 }
		 for ($i = $j; $i <= $j+20;$i++ ){
				$disp = 'none';
				if ($i <= $j){
					$disp = '';
				} 
				echo "<tr align='center' id='".$category."_".$sub_category."_".$i."' style='display:$disp'>\n";
				echo "<td align='center'>\n";
				echo "<input name=\"option[".$category."][".$sub_category."][$i]\" style='text-align:center;' onFocus=\"shownext('".$category."_".$sub_category."_".($i+1)."');\">\n";
				echo "</td>\n";
				echo "</tr>\n";
		 } 
		echo "</table></td>";  
}

function practice($practice, $workbook, $print){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $coach;
	GLOBAL $printable;
	GLOBAL $getlang;
	GLOBAL $language;
	GLOBAL $translations;

	$practice_array = array();
	
	$Practice_Plan = 'Practice Plan';
	$printab = 'printable';
	$Date = 'Date';
	$Time = 'Time';
	$Part = 'Part';
	$Phase = 'Objective';
	$Part_Phase = 'Part/Objective';
	$Image = 'Image';
	$Roles = 'Notes/Activity description/Directions/Guidelines';
	$team = 'Team';
	$Location = 'Location';
	$Practice_Type = 'Phase of Season';
	$Practice_Number = 'Practice Number';
	$Todays_Goals_Objectives = "Today's Goals & Objectives";
	$Reminders = 'Key messages/Reminders/Safety Points';
	$Evaluation = 'Equipment required';
	$Things_to_work_on = 'Post practice reflection/Things to work on';
	$Activity_or_Drill = 'Activity or Drill';
	$Key_Elements_Notes = 'Capacity to develop';
	$Capacity = "Capacity";
	$add_a_drill = 'add a drill';
	$add = 'add';
	$select_a_drill = 'select a drill from library';
	if ($getlang == 'frn'){
		$Practice_Plan = $translations[$Practice_Plan];
		$printab = $translations[$printab];
		$Date = $translations[$Date];
		$Time = $translations[$Time];
		$Part = 'Part';
		$Phase = 'Phase';
		$Part_Phase = "Partie de l'entrainement";
		$Image = 'Image';
		$Roles = 'Notes / Description de l’activité / Directives / Régles';
		$team = $translations[$team];
		$Location = $translations[$Location];
		$Practice_Type = $translations[$Practice_Type];
		$Practice_Number = $translations[$Practice_Number];
		$Todays_Goals_Objectives = $translations[$Todays_Goals_Objectives];
		$Reminders = $translations[$Reminders];
		$Evaluation = $translations[$Evaluation];
		$Things_to_work_on = $translations[$Things_to_work_on];
		$Activity_or_Drill = $translations[$Activity_or_Drill];
		$Key_Elements_Notes = $translations[$Key_Elements_Notes];
		$Capacity = $translations[$Capacity];
		$add_a_drill = $translations[$add_a_drill];
		$add = $translations[$add];
		$select_a_drill = $translations[$select_a_drill];
	}

	if ($practice || $workbook){
		// get the practice
		if ($practice){
			$str = "SELECT * FROM NCCP_Canada_Practice WHERE prac_id = $practice";
		} elseif ($workbook){
			$str = "SELECT * FROM NCCP_Canada_Practice WHERE prac_workbook = $workbook AND prac_coach=$coach";
		}
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		$num_pracs = mysqli_num_rows($res);
		//echo "$str $res $num_pracs<br>";
		if($num_pracs){
			$practice_array['id'] = mysqli_result($res, 0, "prac_id");
			$practice = $practice_array['id'];
			$practice_array['coach'] = mysqli_result($res, 0, "prac_coach");
			$practice_array['workbook'] = mysqli_result($res, 0, "prac_workbook");
			$workbook = $practice_array['workbook'];
			$practice_array['team'] = mysqli_result($res, 0, "prac_team");
			$practice_array['start'] = mysqli_result($res, 0, "prac_start");
			$practice_array['end'] = mysqli_result($res, 0, "prac_end");
			$practice_array['objective'] = mysqli_result($res, 0, "prac_objective");
			$practice_array['reminders'] = mysqli_result($res, 0, "prac_reminders");
			$practice_array['location'] = mysqli_result($res, 0, "prac_location");
			$practice_array['evaluation'] = mysqli_result($res, 0, "prac_evaluation");
			$practice_array['work_on'] = mysqli_result($res, 0, "prac_work_on");
			$practice_array['type'] = mysqli_result($res, 0, "prac_type");
			$practice_array['number'] = mysqli_result($res, 0, "prac_number");
		}
		// get the practice components
			$str = "SELECT * FROM NCCP_Canada_Practice_Components WHERE prac_comp_practice = $practice ORDER BY prac_comp_start";
			$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
			$num_comps = mysqli_num_rows($res);
			//echo "$str $res $num_comps<br>";
			for ($i = 0; $i < $num_comps; $i++){
				$practice_array['component']['drill'][] = mysqli_result($res, $i, "prac_comp_drill");
				$practice_array['component']['start'][] = mysqli_result($res, $i, "prac_comp_start");
				$practice_array['component']['notes'][] = mysqli_result($res, $i, "prac_comp_notes");				
				$practice_array['component']['part'][] = mysqli_result($res, $i, "prac_comp_part");				
				$practice_array['component']['phase'][] = mysqli_result($res, $i, "prac_comp_phase");				
				$practice_array['component']['image'][] = mysqli_result($res, $i, "prac_comp_image");				
				$practice_array['component']['roles'][] = mysqli_result($res, $i, "prac_comp_roles");				
			}
	}
	if (!$practice_array['start']){
		$practice_array['start'] = date("Y-m-d 18:00:00");
	}
	
	
	// get all drills
		$str = "SELECT * FROM NCCP_Canada_Practice_Drills WHERE prac_drill_public = 1 OR prac_drill_coach=$coach ORDER BY prac_drill_name_eng";
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		$num_drills = mysqli_num_rows($res);
		$drills = array();
		for ($i = 0; $i < $num_drills; $i++){
			$did = mysqli_result($res, $i, "prac_drill_id");
			$drills['id'][$did] = $did;
			$drills['name'][$did] = mysqli_result($res, $i, "prac_drill_name_eng");
			$drills['procedure'][$did] = mysqli_result($res, $i, "prac_drill_procedure_eng");
			$drills['image'][$did] = mysqli_result($res, $i, "prac_drill_image");
			$drills['sketches'][$did] = explode('|', mysqli_result($res, $i, "prac_drill_sketch"));
		}
		
	if ($practice && !$printable){
		echo "<a class='pull-right' href='/tools/practice/practice.php?practice=$practice&printable=1' target='_blank'>$printab</a>\n";
	}
	if ($practice && $practice_array['coach'] == $coach && !$printable){
	   echo "<a class='pull-right' style='padding-right: 20px;' href='delete_practice.php?practice=$practice' onClick=\"return confirm('Are you sure you want to delete this practice?')\">delete this practice</a>";
	}
	echo "<table width='95%' cellpadding=5 cellspacing=0 border=0 class='table'>\n";
	if ($print){
	   echo "<td width='25%' rowspan=2 style='border-top: none;'><img src='/images/logonew_black.png' style='height: 120px;'></td>\n";
		$csp = 1;
	} else {
		$csp = 2;
	}
	echo "<td width='75%' style='text-align:center;border-top: none;' colspan='$csp'><h3><u>$Practice_Plan</u>\n";
	echo "</h3></td>\n";
	echo "<tr>\n";
	echo "<td colspan=3 style='border-top: none;'>";
	//team
		if ($print){
			echo "<b>$team:</b> <font style='font-weight: normal'>".$practice_array['team']."</font>&nbsp;&nbsp;&nbsp;";			
		} else {
			echo "<b>$team:</b> <input class='input-medium' type='text' name='prac_team' value='".$practice_array['team']."' size=20>&nbsp;&nbsp;&nbsp;\n";
		}
	//date
		echo "<b>Date: </b>";
		if ($print){
			$stdate = date("M j/y g:ia", strtotime($practice_array['start']));
			if ($language == 'french'){
				$stdate = date_to_french($stdate);
			}
			echo "<font style='font-weight: normal'>$stdate</font>";
		} else {
			get_date($practice_array['start'], 'datetime', 'prac_start', null, null, true);
		}
	//location
		if ($print){
			echo "<br><br><b>$Location:</b> <font style='font-weight: normal'>".$practice_array['location']."</font>";			
		} else {
			echo "<br><br><b>$Location:</b><input class='input-medium' type='text' name='prac_location' value='".$practice_array['location']."' size=30>\n";
		}
	//practice type
		echo "&nbsp;&nbsp;<b>$Practice_Type:</b> ";
		
		$type_array = array(
				'general_preparation'=>'General Preparation', 
				'specific_preparation'=>'Specific Preparation', 
				'pre_competition'=>'Pre-Competition',
				'competition'=>'Competition',
				'major_competition'=>'Major Competition',
				'transition'=>'Transition'
				);
		if ($language == 'french'){
			$type_array = array(
					'general_preparation'=>'Préparation générale', 
					'specific_preparation'=>'Préparation spécifique', 
					'pre_competition'=>'Pré-compétition',
					'competition'=>'Compétition',
					'major_competition'=>'Compétition Majeur',
					'transition'=>'Transition'
					);
		}
		if ($print){
			echo "<font style='font-weight: normal'>".$type_array[$practice_array['type']]."</font>";
		} else {
			echo "<select name='prac_type' class='input-medium'>\n";
			foreach ($type_array as $t=>$val){
				if ($practice_array['type'] == $t){
					$selected = 'selected';
				} else {
					$selected = '';
				}
				echo "<option value='$t' $selected>$val</option>\n";
			}
			echo "</select>\n";
		}
	// PRACTICE NUMBER
		echo "&nbsp;&nbsp;<b>$Practice_Number:</b> ";
		
		if ($print){
			echo "<font style='font-weight: normal'>".$practice_array['number']."</font>";
		} else {
			echo "<select name='prac_number' class='input-mini'>\n";
			for ($pn = 1; $pn <= 500;$pn++){
				if ($practice_array['number'] == $pn){
					$selected = 'selected';
				} else {
					$selected = '';
				}
				echo "<option value='$pn' $selected>$pn</option>\n";
			}
			echo "</select>\n";
		}
	echo "</td>\n";
	echo "</tr></table>\n";

	echo "<table width='95%' cellpadding=5 align='center' class='table table-bordered'>\n";
	echo "<tr>\n";
	if ($print){
		echo "<td style='text-align:left; font-weight: bold;' width='50%' valign='top' height='100' class='blackdashed2'>$Todays_Goals_Objectives:<br><font style='font-weight: normal'>".$practice_array['objective']."</font></td>";
		echo "<td style='text-align:left; font-weight: bold;' width='50%' valign='top' class='blackdashed2'>$Reminders:<br><font style='font-weight: normal'>".$practice_array['reminders']."</font></td>";
	} else {
		echo "<td style='text-align:left; font-weight: bold;' width='50%' class='blackdashed2'>$Todays_Goals_Objectives:<br><textarea class='span12' name='prac_objective' id='prac_objective' rows=4 >".$practice_array['objective']."</textarea></td>";
		echo "<td style='text-align:left; font-weight: bold;' width='50%' class='blackdashed2'>$Reminders:<br><textarea class='span12' name='prac_reminders' id='prac_reminders' rows=4 >".$practice_array['reminders']."</textarea></td>";
	}
	echo "</tr>\n";
	echo "<tr>\n";
	if ($print){
		echo "<td colspan=2 style='text-align:left; font-weight: bold;' width='100%' valign='top' height='100' class='blackdashed2'>$Evaluation:<br><font style='font-weight: normal'>".$practice_array['evaluation']."</font></td>";
	} else {
		echo "<td colspan=2 style='text-align:left; font-weight: bold;' width='100%' class='blackdashed2' >$Evaluation:<br><textarea class='span12' name='prac_evaluation' id='prac_evaluation' rows=4 >".$practice_array['evaluation']."</textarea></td>";
	}
	echo "</tr>";

	
	echo "</table>\n";

	echo "<table width='95%' cellpadding=5 align='center' class='table table-bordered table-striped'>\n";
	echo "<tr>\n";
	echo "<th class='blackdashed2'>$Time</th>\n";
	echo "<th class='blackdashed2'>$Part_Phase</th>\n";
	echo "<th class='blackdashed2'>$Key_Elements_Notes</th>\n";	
	echo "<th class='blackdashed2'>$Activity_or_Drill";
	if (!$print){
		echo "<br><a class='add_drill' style='cursor:pointer;'>$add_a_drill</a>";
	}
	echo "</th>\n";
	echo "<th class='blackdashed2'>$Roles</th>\n";	
	echo "</tr>\n";

	for ($i=0;$i < 20;$i++){
		if ($practice_array['component']['drill'][$i] || ($i == count($practice_array['component']['drill'] || $i<3) && !$print)){
			$disp = '';
		} else {
			$disp = 'none';
		}
		echo "<tr style='display:$disp' id='drill".$i."'>\n";
		// TIME
		echo "<td class='blackdashed2' nowrap>";
		if ($print){
			echo "<font style='font-weight: normal'>".date("g:ia", strtotime($practice_array['component']['start'][$i]))."</font>";
		} else {
			get_date($practice_array['component']['start'][$i], 'time', 'prac_comp_start', $i, null, true);
		}
		echo "</td>\n";

		echo "<td class='blackdashed2' nowrap>";
		// PART
		echo "<b>$Part:</b> ";
			$part_array = array(
					'introduction'=>'introduction', 
					'warm_up'=>'warm up', 
					'main_part'=>'main part',
					'cool_down'=>'cool-down',
					'conclusion'=>'conclusion',
					);
			if ($language == 'french'){
				$part_array = array(
					'introduction'=>'introduction', 
					'warm_up'=>'réchauffer', 
					'main_part'=>'partie principale',
					'cool_down'=>'refroidissement',
					'conclusion'=>'conclusion',
						);
			}
		if ($print){
			echo $part_array[$practice_array['component']['part'][$i]];
		} else {
			
			//echo "<select name='part[$i]' class='input-small'>\n";
			//echo "<option value=''></option>\n";
			foreach ($part_array as $p=>$val){
				if ($practice_array['component']['part'][$i] == $p){
					$selected = 'selected';
					$checked = 'checked';
				} else {
					$selected = '';
					$checked = '';
				}
				//echo "<option value='$p' $selected>$val</option>\n";
				echo "<label><input type='radio' name='part[$i]' value='$p' $checked> $val</label>";
			}
			//echo "</select>\n";
		}
		// PHASE

			$phase_array = array(
					'introduce'=>'Introduce', 
					'develop'=>'Develop', 
					'refine'=>'Refine',
					'automate'=>'Automate',
					);
			if ($language == 'french'){
				$phase_array = array(
					'introduce'=>'Introduire', 
					'develop'=>'Développer', 
					'refine'=>'Consolidé',
					'automate'=>'Acquisition',
						);
			}
		echo "<br><b>$Phase:</b> ";
		if ($print){
			echo $phase_array[$practice_array['component']['phase'][$i]];
		} else {
			//echo "<select name='phase[$i]' class='input-small'>\n";
			//echo "<option value=''></option>\n";
			foreach ($phase_array as $p=>$val){
				if ($practice_array['component']['phase'][$i] == $p){
					$selected = 'selected';
					$checked = 'checked';
				} else {
					$selected = '';
					$checked = '';
				}
				//echo "<option value='$p' $selected>$val</option>\n";
				echo "<label><input type='radio' name='phase[$i]' value='$p' $checked> $val</label>";
			}
			//echo "</select>\n";
		}
		echo "</td>\n";
		
			$dev_array = array(
					'technical_tactical'=>'Technical/Tactical', 
					'physical'=>'Physical', 
					'psychological'=>'Psychological',
					'lifeskills'=>'Lifeskills'
					);
			if ($language == 'french'){
				$dev_array = array(
					'technical_tactical'=>'Technique / Tactique', 
					'physical'=>'Physique', 
					'psychological'=>'Psychologique',
					'lifeskills'=>'Vie quotidien'
						);
			}
		echo "<td class='blackdashed2'>";
		echo "<b>$Capacity:</b> ";
		if ($print){
			echo $dev_array[$practice_array['component']['notes'][$i]];
		} else {
			
			//echo "<select name='prac_comp_notes[$i]' class='input-medium'>\n";
			//echo "<option value=''></option>\n";
			foreach ($dev_array as $p=>$val){
				if ($practice_array['component']['notes'][$i] == $p){
					$selected = 'selected';
					$checked = 'checked';
				} else {
					$selected = '';
					$checked = '';
				}
				//echo "<option value='$p' $selected>$val</option>\n";
				echo "<label><input type='radio' name='prac_comp_notes[$i]' value='$p' $checked> $val</label>";
			}
			//echo "</select>\n";
		}
		
		echo "</td>\n";	
		
		$drill_text = '';
		if (!is_numeric($practice_array['component']['drill'][$i])){
			$drill_text = $practice_array['component']['drill'][$i];
		}
		if ($print){
			echo "<td style='text-align:left' valign='top' class='blackdashed2'><font style='font-weight: normal'>";
			if ($print && $drill_text){
				echo $drill_text;
			} else {
				$did = $practice_array['component']['drill'][$i];
				$drill_name = $drills['name'][$did];
				$drill_procedure = nl2br($drills['procedure'][$did]);
				$drill_link = $drills['link'][$did];
				$drill_image = $drills['image'][$did];
				$drill_sketches = $drills['sketches'][$did];
				if ($drill_link){
					echo "<a href='$drill_link' targetr='_blank'><b>$drill_name</b></a>";
				} else {
					echo "<b>$drill_name</b>";
				}
				if ($printable && $drill_image){
					if (substr_count($drill_image, '.pdf')){
						if ($practice_array['component']['image'][$i]){
							echo "<p align='center'>
							<object data='$drill_image' type='application/pdf' width='95%' height='600'>
							<p>It appears you don't have a PDF plugin for this browser. No biggie... you can 
							<a href='$drill_image'>click here to download the PDF file.</a></p></object></p>";							
						} else {
							echo "&nbsp;&nbsp;<a href='$drill_image' target='_blank'>click to open pdf for print</a>";
						}
					} elseif ($practice_array['component']['image'][$i]) {
						echo "<br><img src='/tools/drills/images/$drill_image' class='drill_image' width='450'><br>";
					}	
				}	
				// SKETCHES
				if ($printable && count($drill_sketches) && $practice_array['component']['image'][$i]){
					echo "<br>";
					foreach ($drill_sketches as $pd=>$sketch){
						if ($sketch){
							echo "<div class='sketch' style='display: inline-block;text-align: left;' id='sketchs$pd'><img src='/tools/drills/images/$sketch' class='drill_image'></div>";
						}
					}
				}
			}
			echo "<br>$drill_procedure</font></td>";
			echo "<td style='text-align:left' valign='top' class='blackdashed2'><font style='font-weight: normal'>".nl2br($practice_array['component']['roles'][$i])."</font></td>";
		} else {
			echo "<td align='center' class='blackdashed2'>";
			echo "<select name='prac_drill[$i]' class='input-large' onFocus=\"show('drill', ".($i+1).");\">\n";
			echo "<option value='' >$select_a_drill</option>\n";
			foreach ($drills['id'] as $k=>$didhere){
				if ($practice_array['component']['drill'][$i] == $didhere){
					$selected = 'selected';
				} else {
					$selected = '';
				}
				if (strlen($drills['name'][$k]) < 40){
					$dname = $drills['name'][$k];
				} else {
					$dname = substr($drills['name'][$k], 0, 40)."...";
				}
				echo "<option value='$didhere' $selected>$dname</option>\n";
			}
			echo "</select>&nbsp;<a class='add_drill' style='cursor:pointer;'><icon class='icon icon-plus'></a>\n";
			// ALLOW ON PRINTABLE?
			if ($practice_array['component']['image'][$i] || $i >= count($practice_array['component']['drill'])){
				$checked = 'checked';
			} else {
				$checked = '';
			}
			echo "<br><b>Print Image/PDF?</b> <input type='checkbox' name='include_image[$i]' value='1' $checked>\n";
			echo "<hr>";
			echo $translations['<b>OR</b> Enter activity'].":<br><input type='text' name='prac_drill_text[$i]' value='$drill_text'>\n";
			echo "</td>\n";
			echo "<td class='blackdashed2'><textarea class='span5' name='roles[$i]' style='width: 100%;' rows=4 >".$practice_array['component']['roles'][$i]."</textarea></td>\n";	
		}
		echo "</tr>\n";
		
	}

	echo "<tr>\n";
	if ($print){
	   echo "<td colspan=5 style='text-align:left; font-weight: bold;' width='100%' valign='top' class='blackdashed2'>$Things_to_work_on:<br><font style='font-weight: normal'>".$practice_array['work_on']."</font></td>";
	} else {
	   echo "<td colspan=5 style='text-align:left; font-weight: bold;' width='100%' class='blackdashed2' >$Things_to_work_on:<br><textarea class='span12' name='prac_work_on' id='prac_work_on' rows=4 >".$practice_array['work_on']."</textarea></td>";
	}
	echo "</tr>";
	?>
	<script>
	$(document).ready(function(){
	   $('.add_drill').click(function() {
		   var conf = confirm('This will open the drill editor.  Are you sure you want to continue before saving your practice?');
		   if (conf){
			   <?
			   $prac=$practice;
			   if (!$prac){
				   $prac=-99;
			   }
			   ?>
			   $('#add_drill').val(<?=$practice?>);
			   $('#form1').submit();
		   }
			return false;
		   /*
		   var newfont = $(this).attr('id');
		   var fnt = newfont.replace(/_/g, " ");
		   $('.teamname').css( "font-family", fnt + ", cursive");
		   $('.selectfont').removeClass( "alert-success" );
		   $('#'+newfont).addClass( "alert-success" );
		   $('#teamnamefont').val(fnt);
		   */
	   });
	});
	</script>
	<?
	echo "</table><br><br>\n";
	echo "<input type='hidden' name='workbook' value='$workbook'>\n";
}
function season($season, $workbook, $print, $season_type=0){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $coach;
	GLOBAL $printable;
	GLOBAL $host_url;
	GLOBAL $current_language;
	GLOBAL $translations;
	GLOBAL $season_type;
	
	
	$season_array = array();
		
	
	if ($season || $workbook){
		// get the season
		if ($season){
			$str = "SELECT * FROM NCCP_Canada_Season WHERE season_id = $season";
		} elseif ($workbook){
			$str = "SELECT * FROM NCCP_Canada_Season WHERE season_workbook = $workbook AND season_coach=$coach";
		}
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		$num_seas = mysqli_num_rows($res);
		//echo "$str $res $num_seas<br>";
		if ($num_seas){
			$season_array['id'] = mysqli_result($res, 0, "season_id");
			$season = $season_array['id'];
			$season_array['coach'] = mysqli_result($res, 0, "season_coach");
			$seascoach = $season_array['coach'];
			$season_array['workbook'] = mysqli_result($res, 0, "season_workbook");
			$workbook = $season_array['workbook'];
			$season_array['start'] = mysqli_result($res, 0, "season_start");
			$season_array['end'] = mysqli_result($res, 0, "season_end");
			$season_array['team'] = mysqli_result($res, 0, "season_team");
			$season_array['athlete'] = mysqli_result($res, 0, "season_athlete");
			$season_array['discipline'] = mysqli_result($res, 0, "season_discipline");
			$season_array['notes'] = mysqli_result($res, 0, "season_notes");
			$season_array['athlete_strengths'] = mysqli_result($res, 0, "season_athlete_strengths");
			$season_array['athlete_focus'] = mysqli_result($res, 0, "season_athlete_focus");
			$season_array['type'] = mysqli_result($res, 0, "season_type");
			$season_type=$season_array['type'];
		} else {
			$seascoach=$coach;
		}	
		// THEN GET ALL OF THE COMPONENTS IF THEY EXIST
			if ($season){
				$SelectStr = "SELECT * FROM NCCP_Canada_Season_Component 
													WHERE (component_season_id=$season)
													ORDER BY component_id";
				$Result = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $SelectStr) : false);
				$RowCount = mysqli_num_rows($Result);
				
				for ($i = 0; $i < $RowCount; $i++){
					$component_id = mysqli_result($Result, $i, "component_id");	
					$component_season_id = mysqli_result($Result, $i, "component_season_id");	
					$component_week_num = mysqli_result($Result, $i, "component_week_num");	
					$component_option_id = mysqli_result($Result, $i, "component_option_id");	
					$component_option_value = mysqli_result($Result, $i, "component_option_value");	
					$component_option_priority = mysqli_result($Result, $i, "component_option_priority");	
			
					$component[$component_option_id][$component_week_num]['id'] = $component_id;	
					$component[$component_option_id][$component_week_num]['value'] = $component_option_value;	
					$component[$component_option_id][$component_week_num]['priority'] = $component_option_priority;	
				}
			}
		// get the season OPTIONS
			$SelectStr = "SELECT * FROM NCCP_Canada_Season_Options WHERE option_season_type=$season_type 
												ORDER BY option_order, option_id, option_category, option_sub_category";
			$Result = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $SelectStr) : false);
			$RowCount = mysqli_num_rows($Result);
			//echo "$SelectStr $RowCount<br>";
			if ($current_language == 'french'){
				$addfr = "_fr";
			} else {
				$addfr = "";
			}
			for ($i = 0; $i < $RowCount; $i++){
				$option_id = mysqli_result($Result, $i, "option_id");	
				$option_category_en = mysqli_result($Result, $i, "option_category");	
				$option_sub_category_en = mysqli_result($Result, $i, "option_sub_category");
				$option_name_en = mysqli_result($Result, $i, "option_name");	
				$option_category = mysqli_result($Result, $i, "option_category".$addfr);	
				$option_sub_category = mysqli_result($Result, $i, "option_sub_category".$addfr);
				$option_name = mysqli_result($Result, $i, "option_name".$addfr);	
				$option_type = mysqli_result($Result, $i, "option_type");	
				$option_max = mysqli_result($Result, $i, "option_max");	
				$option_options_en = mysqli_result($Result, $i, "option_options");
				$option_options = mysqli_result($Result, $i, "option_options".$addfr);
				$option_priority = mysqli_result($Result, $i, "option_priority");	
				if (!$option_category){
					$option_category = $option_category_en;
					$option_sub_category = $option_sub_category_en;
				}
				if (!$option_name){
					$option_name = $option_name_en;
					$option_options = $option_options_en;
				}
				if ($addfr){
					$option_name = utf8_encode($option_name);
					$option_category = utf8_encode($option_category);
					$option_sub_category = utf8_encode($option_sub_category);
					$option_options = utf8_encode($option_options);
				}
				$option[$option_category][$option_sub_category][$option_id]['name'] = $option_name;	
				$option[$option_category][$option_sub_category][$option_id]['type'] = $option_type;	
				$option[$option_category][$option_sub_category][$option_id]['max'] = $option_max;	
				$option[$option_category][$option_sub_category][$option_id]['options'] = $option_options;	
				$option[$option_category][$option_sub_category][$option_id]['priority'] = $option_priority;	
			}
			if ($_SERVER['REMOTE_ADDR'] == '70.79.177.80'){
			//	var_dump($option);
			}
	}		
	// get the disciplines
		$str = "SELECT * FROM NCCP_Canada_Disciplines ORDER BY discipline_id";
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		$num_disc = mysqli_num_rows($res);
		$discipline_array = array();
		//echo "$str $res $num_comps<br>";
		for ($i = 0; $i < $num_disc; $i++){
			$discipline_id = mysqli_result($res, $i, "discipline_id");
			$discipline_array[$discipline_id] = mysqli_result($res, $i, "discipline_eng_name");
		}
		
		if ($season && !$printable){
			echo "<a class='pull-right' href='http://$host_url/tools/season/season.php?season=$season&printable=1' target='_blank'>".$translations['printable']." <i class='icon-print'></i></a>\n";
			echo "<a style='padding-right: 20px;' class='pull-right' href='http://$host_url/tools/season/season_pdf.php?season=$season&print=1' target='_blank'>".$translations['Save as PDF']." <i class='icon-download'></i></a>\n";
		}
	// SHOW THE SEASON CHART
		$img_span = 0;
		$title_span = 11;
		if ($print){
			echo "<div class='pull-left span2'><img src='/images/logo.png' style='height: 100px;'></div>\n";
			$title_span=9;
		}
		if ($season && $seascoach == $coach && !$print && !$workbook){
			echo "<a class='pull-right' style='padding-right: 20px;' href='delete_season.php?season=$season' onClick=\"return confirm('Are you sure you want to delete this season plan?')\">delete this plan</a>";
		}
		echo "<div class='span$title_span'>";
		echo "<h3><p align='center' ";
		if ($season && !$printable){
			echo "style='padding-left: 100px; '";
		}
		if ($season_type == 1){
			$sp1 = "Performance Plan";
		} else {
			$sp1 = "Yearly Training Plan";
		}
		echo "><u>".$translations[$sp1]."</u>\n";
		
		echo "</p></h3>";
		echo "<table width='95%' cellpadding=5 cellspacing=0 border=0 align='center' class='blackdashed'>\n";
		echo "<tr>\n";
		echo "<td colspan=3 align='center'>";
		//date start
			echo $translations['Start Date'].": ";
			if ($print){
				$dt = date("M j/y", strtotime($season_array['start']));
				if ($current_language == 'french'){
					$dt = date_to_french($dt);
				}
				echo "<font style='font-weight: bold'>$dt</font>";
			} else {
				get_date($season_array['start'], 'date', 'season_start');
			}
		//date end
			echo "&nbsp;&nbsp;&nbsp;&nbsp;".$translations['End Date'].": ";
			if ($print){
				$dt = date("M j/y", strtotime($season_array['end']));
				if ($current_language == 'french'){
					$dt = date_to_french($dt);
				}
				echo "<font style='font-weight: bold'>$dt</font>";
			} else {
				get_date($season_array['end'], 'date', 'season_end');
			}
			echo "<br><br>";
		//TEAM
			$tm = "Team";

			if ($print){
				if ($season_array['team']){
					echo $translations[$tm].": <font style='font-weight: bold'>".$season_array['team']."</font>";			
				}
			} else {
				echo $translations[$tm].": <input type='text' name='season_team' value='".htmlentities($season_array['team'], ENT_QUOTES)."' size=30>\n";
			}
		//ATHLETE
			if ($season_type == 1){
				$tm = "Name of Athlete";
				if ($print){
					echo "&nbsp;&nbsp;&nbsp;".$translations[$tm].": <font style='font-weight: bold'>".$season_array['athlete']."</font>";			
				} else {
					echo "&nbsp;&nbsp;&nbsp;".$translations[$tm].": <input type='text' name='season_athlete' value='".htmlentities($season_array['athlete'], ENT_QUOTES)."' size=30>\n";
				}
				$tm = "Athlete Strengths";
				if ($print){
					if ($season_array['athlete_strengths']){
						echo "<br><br>".$translations[$tm].": <font style='font-weight: bold'>".nl2br($season_array['athlete_strengths'])."</font>";			
					}
				} else {
					echo "<br><br>".$translations[$tm].": <textarea name='athlete_strengths'>".$season_array['athlete_strengths']."</textarea>\n";
				}
				$tm = "Focus for Improvement";
				if ($print){
					if ($season_array['athlete_focus']){
						echo "<br><br>".$translations[$tm].": <font style='font-weight: bold'>".nl2br($season_array['athlete_focus'])."</font>";			
					}
				} else {
					echo "&nbsp;&nbsp;&nbsp;".$translations[$tm].": <textarea name='athlete_focus'>".$season_array['athlete_focus']."</textarea>\n";
				}
			}
		//DISCIPLINE
			/*
			echo "&nbsp;&nbsp;Discipline: ";
			if ($print){
				echo "<font style='font-weight: normal'>".$discipline_array[$season_array['discipline']]."</font>";
			} else {
				echo "<select name='season_discipline'>\n";
				foreach ($discipline_array as $d=>$val){
					if ($season_array['discipline'] == $d){
						$selected = 'selected';
					} else {
						$selected = '';
					}
					echo "<option value='$d' $selected>$val</option>\n";
				}
				echo "</select>\n";
			}
			*/
			echo "<input type='hidden' name='season_discipline' value='1'>\n";
			echo "<input type='hidden' name='season_type' value='$season_type'>\n";
		echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</div><div class='clearfix'>&nbsp;</div><br>";
		
	if ($season){
		// SHOW EACH COMPOENENT
		echo "<table width='95%' cellpadding=0 cellspacing=0 border=1 align='center' class='table  table-bordered'>\n";
		
		// 1st show the week numbers
			// get the first monday
			$start = strtotime($season_array['start']);
			$next_monday = strtotime("Monday", $start);
			if (date("Y-m-d", $start) == date("Y-m-d", $next_monday)){
				$first_monday = $next_monday;
			} else {
				$first_monday = strtotime("-1 week", $next_monday);
			}
			//echo date("M d/y", $first_monday)."<br>";
			
			// get the last monday
			$end = strtotime($season_array['end']);
			$next_monday = strtotime("Monday", $end);
			if (date("Y-m-d", $end) == date("Y-m-d", $next_monday)){
				$last_monday = strtotime("+1 week", $next_monday);
			} else {
				$last_monday = $next_monday;
			}
			//echo date("M d/y", $last_monday)."<br>";
			

			// MONTH
			$curr_monday = $first_monday;
			echo "<tr> \n";
			echo "<td style='padding: 0px;text-align:right;background-color: #DDD;'>".$translations['Month']."</td>\n";
			$colspan=0;
			$curr_month = date("M", $curr_monday);
			$showing_month = $curr_month;
			$z = 1;
			while ($curr_monday <= $last_monday){
				$curr_month = date("M", $curr_monday);
				$currmon = date("Y-m-d", $curr_monday);
				$lastmon = date("Y-m-d", $last_monday);
				$curr_month = date("M", $curr_monday);
				//echo "$showing_month, $curr_month, $currmon, $lastmon, $colspan, $z<br>";
				if ($showing_month != $curr_month || $currmon == $lastmon){
					$dt = $showing_month;
					if ($current_language == 'french'){
						$dt = date_to_french($dt);
					}
					echo "<td style='padding: 0px;' colspan='$colspan'>$dt</td>";
					$showing_month = $curr_month;
					$colspan=1;
				} else {
					$colspan++;
				}
				$curr_monday = strtotime("+1 week", $curr_monday);
			}
			echo "</tr>\n";

			// DAY
			$curr_monday = $first_monday;
			$i = 1;
			echo "<tr> \n";
			echo "<td style='padding: 0px;text-align:right;background-color: #DDD;'>".$translations['Date (Monday)']."</td>\n";
			while ($curr_monday <= $end){
				if ($i % 2 == 0){
					$bgcol = '#FFFFFF';
				} else {
					$bgcol = '#ffacaa';
				}
				$curr_day = date("j", $curr_monday);
				echo "<td style='padding: 0px;background-color: $bgcol'>$curr_day</td>";
				$i++;
				$curr_monday = strtotime("+1 week", $curr_monday);
			}
			echo "</tr>\n";
			
			// WEEK
			$curr_monday = $first_monday;
			$i = 1;
			echo "<tr> \n";
			echo "<td style='padding: 0px;text-align:right;background-color: #DDD;'>".$translations['Training Week #']."</td>\n";
			while ($curr_monday <= $end){
				if ($i % 2 == 0){
					$bgcol = '#FFFFFF';
				} else {
					$bgcol = '#ffacaa';
				}
				echo "<td style='padding: 0px;background-color: $bgcol;'><b><u>$i</u></u></td>";
				$i++;
				$curr_monday = strtotime("+1 week", $curr_monday);
			}
			echo "</tr>\n";
			$num_weeks = $i;
			
			$col_width = floor(100/$num_weeks);
			
			// SHOW OPTIONS
			$totals = array();
			$practice_ids = array(1600003);
			$game_ids = array(1600004, 1600005, 1600006, 1600007, 1600008);
			
			$hour_ids = array(1600041,1600050);
				
			$optionshown=array();
			foreach ($option as $cat=>$array1b){
				// 1) SHOW A ROW WITH THE CATEGORY
					echo "<tr> \n";
					echo "<th style='font-size: 1.3em;text-align:left;padding: 0px;text-decoration:none;background-color: #CCC;' nowrap><b>$cat</b></th>\n";
					for ($j = 1; $j < $num_weeks; $j++){
						echo "<th style='text-align:left;padding: 0px;text-decoration:none;background-color: #CCC;'>&nbsp;</th>\n";
					}
					echo "</tr>\n";
				
				foreach ($array1b as $sub_cat=>$array1){
			
				// 1b) SHOW A ROW WITH THE SUB CATEGORY
				if ($sub_cat){
					echo "<tr> \n";
					echo "<th style='text-align:left;padding: 0px 0px 0px 10px;text-decoration:none;background-color: #EEE;' nowrap><b>$sub_cat</b></th>\n";
					for ($j = 1; $j < $num_weeks; $j++){
						echo "<th style='text-align:left;padding: 0px 0px 0px 10px;text-decoration:none;background-color: #EEE;'>&nbsp;</th>\n";
					}
					echo "</tr>\n";
				}
				// 2) show option name 
					foreach ($array1 as $id=>$array2){
						$o_name = $array2['name'];
						$o_type = $array2['type'];
						$o_max = $array2['max'];
						$o_options = $array2['options'];
						$o_priority = $array2['priority'];
						echo "<tr> \n";
						echo "<td style='text-align:left;padding: 10px;font-weight:normal;' nowrap>&nbsp;&nbsp;&nbsp;$o_name";
						// show legend
						if ($o_options && !$optionshown[$o_options]){
							$optionshown[$o_options] = 1;
							$short_op_array = array();
							$op_array = explode('|', $o_options);
							echo "<br><div class='answer'>";
							if ($o_priority){
								echo "<div style='float:right;border: 1px solid;'>
									<table border=0 cellspacing=0 cellpadding=0 style='font-size: 10px;color: #FFF;'>
									<tr><td style='text-align: center;padding: 2px;background-color: #FFFFFF;color: #000;'><u>Priorities</u></td></tr>
									<tr><td style='text-align: center;padding: 2px;background-color: #FF0000;'>High</td></tr>
									<tr><td style='text-align: center;padding: 2px;background-color: #00cccc'>Moderate</td></tr>
									<tr><td style='text-align: center;padding: 2px;background-color: #ff00cc'>Low</td></tr>
									</table>
									</div>";
							}
							foreach ($op_array as $val){
								$valarray = explode(" ", $val);
								if (count($valarray) > 1){
									$valarray = explode(" ", $val);
									$short_val = strtoupper(substr($valarray[0], 0, 1)).strtoupper(substr($valarray[1], 0, 1));
								} else {
									$short_val = strtoupper(substr($val, 0, 2));
								}
								echo "<font size=1>$val - $short_val</font><br>";
								$short_op_array[] = $short_val;
							}
							echo "</div>";
						}
						$optionshown++;
						echo "</td>\n";
						
						// 3)  foreach week, show a box with the selection   
							//$component[$component_option_id][$component_week_num]['id'] = $component_id;	
						for ($j = 1; $j < $num_weeks; $j++){
							$comp_id = $component[$id][$j]['id'];
							$comp_value = $component[$id][$j]['value'];
							$comp_priority = $component[$id][$j]['priority'];
							if ($comp_value){
								$fontcol = '#000000';
								if ($comp_priority ){
									$fontcol = '#FFFFFF';
								}
								if ($comp_priority == 1){
									$bgcol = '#FF0000';
								} elseif ($comp_priority == 2){
									$bgcol = '#00cccc';
								} elseif ($comp_priority == 3){
									$bgcol = '#ff00cc';
								} else {
									$bgcol = '#FFFF00';
								}
								$inclass = 'noedgesblack';
							} else {
								if ($j % 2 == 0){
									$bgcol = '#FFFFFF';
								} else {
									$bgcol = '#ffacaa';
								}
								$inclass = 'normal';					
								$fontcol = '#000000';
							}
							echo "<td align='center' style='background-color: $bgcol;cursor:pointer;' class='season_box' data-box='".$id."_".$j."'>";
							$dispa='';
							$dispv='none';
							if ($comp_value || $print){
								$dispa = 'none';
								$dispv = '';
							}
							//echo "<a id='season_a_".$id."_".$j."' class='season_box' data-box='".$id."_".$j."' style='display:$dispa;cursor:pointer;'>+</a>";
							echo "<span id='season_box_".$id."_".$j."' style='display:$dispv'>";
							if (substr_count($o_type, 'select_')){
								// type is select
								$numselects = substr($o_type, 7, 1);
								$comp_values = explode('|', $comp_value);
								if (!$print){
									for ($s=0;$s<$numselects;$s++){
										echo "<select name='component[".$id."][".$j."][".$s."]' class='input-mini'>\n";
										echo "<option value=''>-</option>\n";
										$x = 1;
										foreach ($short_op_array as $val){
											if ($comp_values[$s] == $x && isset($comp_values[$s])){
												$selected = 'selected';
											} else {
												$selected = '';
											}
											echo "<option value='$x' $selected>$val</option>\n";
											$x++;
										}
										echo "	</select><br>\n";
									}
								} else {
									for ($s=0;$s<$numselects;$s++){
										$comp_values = explode('|', $comp_value);
										if ($op_array[$comp_values[$s]-1]){
											echo "<font color='$fontcol'>".$short_op_array[$comp_values[$s]-1]."</font><br>";
										} else {
											echo "";
										}
									}
								}
							} elseif ($o_type == 'select'){
								// type is select
								if (!$print){
									echo "<select name='component[".$id."][".$j."]' class='input-mini'>\n";
									echo "<option value=''>-</option>\n";
									$x = 1;
									foreach ($short_op_array as $val){
										if ($comp_value == $x && isset($comp_value)){
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "<option value='$x' $selected>$val</option>\n";
										$x++;
									}
									echo "	</select>\n";
									
									
								} else {
									if ($op_array[$comp_value-1]){
										echo "<font color='$fontcol'><b>".$short_op_array[$comp_value-1]."</b></font>";
									} else {
										echo "-";
									}
								}
							} elseif ($o_type == 'num'){
								// type is num
								if (!$print){
									echo "<select name='component[".$id."][".$j."]' class='input-mini'>\n";
									echo "<option value=''>-</option>\n";
									$inc = 1;
									$start = 1;
									if (substr_count($o_max, ".")){
										// do .5 increment
										$inc = 0.5;
										$start = 0.5;
									}
									for ($x = $start; $x <= $o_max; $x+=$inc){
										if ($comp_value == $x && isset($comp_value)){
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "<option value='$x' $selected>$x</option>\n";
									}
									echo "	</select>\n";
								} else {
									if ($comp_value){
										echo "<font color='$fontcol'>$comp_value</font>";
									} else {
										echo "-";
									}
								}
								// TOTALS
								if (isset($comp_value) && (in_array($id, $practice_ids) || in_array($id, $game_ids) || in_array($id, $hour_ids))){
									$totals[$id][$j] = $comp_value;
								}
							} elseif ($o_type == 'checkbox'){
								// type is checkbox
								if ($comp_value && isset($comp_value)){
									$checked = 'checked';
								} else {
									$checked = '';
								}
								if (!$print){
									echo "	<input class='$inclass' type='checkbox' name='component[".$id."][".$j."]' value='1' $checked >\n";
								} else {
									if ($comp_value){
										echo "<img src='/images/credit.png' border='0'>";
									} else {
										echo "-";
									}
								}
							} elseif ($o_type == 'ratio'){
								$total_practice_hours = 0;
								$total_game_hours = 0;
								foreach ($practice_ids as $pid){
									$total_practice_hours+=$totals[$pid][$j];
								}
								foreach ($game_ids as $pid){
									$total_game_hours+=$totals[$pid][$j];
								}
								if ($total_practice_hours>0 || $total_game_hours>0){
									$bgcol = '#000000';
									$inclass = 'noedgesblack';
									$fontcol = '#FFFFFF';
								} else {
									if ($j % 2 == 0){
										$bgcol = '#FFFFFF';
									} else {
										$bgcol = '#ffacaa';
									}
									$inclass = 'normal';					
									$fontcol = '#000000';
								}
								
								echo "<font color='$fontcol'>$total_practice_hours:$total_game_hours</font>";
							} elseif ($o_type == 'num_total'){
								$total_training_hours=0;
								foreach ($hour_ids as $pid){
									$total_training_hours+=$totals[$pid][$j];
								}
								if ($total_training_hours>0){
									$bgcol = '#000000';
									$inclass = 'noedgesblack';
									$fontcol = '#FFFFFF';
								} else {
									if ($j % 2 == 0){
										$bgcol = '#FFFFFF';
									} else {
										$bgcol = '#ffacaa';
									}
									$inclass = 'normal';					
									$fontcol = '#000000';
								}
								echo "<font color='$fontcol' style='font-size: 1.2em;'><b>$total_training_hours</b></font>";
							} else {
								echo "&nbsp;";
							}
							
							if ($o_priority && !$print){
								$priority_array = array(1=>'high', 2=>'moderate', 3=>'low');
								echo "<br><select name='priority[".$id."][".$j."]' class='input-mini'>\n";
								echo "<option value=''></option>\n";
								foreach ($priority_array as $p=>$val){
									if ($comp_priority == $p){
										$selected = 'selected';
									} else {
										$selected = '';
									}
									echo "<option value='$p' $selected>$val</option>\n";
									$x++;
								}
								echo "</select>\n";
							}
							
							echo "</span>\n";
							echo "<input type='hidden' name='component_id[".$id."][".$j."]' value='$comp_id'>\n";
							echo "</td>\n";
						}
						echo "</tr>\n";
					}
				}
			}	
		echo "</table><br>\n";

		echo "<table width='95%' cellpadding=0 cellspacing=0 border=0 align='center' class='blackdashed'>\n";
		echo "<tr><td><b><u>".$translations['Notes'].":</b></u><br>";
		if (!$print){
			echo "<textarea name='season_notes' class='span8' rows=4>".$season_array['notes']."</textarea>\n";
		} else {
			echo $season_array['notes']."\n";
		}
		echo "</td></tr>\n";
		echo "</table><br><br>\n";
	}
	echo "<input type='hidden' name='workbook' value='$workbook'>\n";
}

function get_level_text($level, $short_long, $lang){
	GLOBAL $link;
	GLOBAL $dbName;

	$str = "SELECT * FROM NCCP_Canada_Levels, NCCP_Canada_Disciplines, NCCP_Canada_Contexts 
							WHERE level_discipline=discipline_id AND level_context=context_id AND level_id=$level ORDER BY level_discipline, level_context";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rowcount = mysqli_num_rows($res);
	//echo "$str $res $rowcount<br>";

	if ($rowcount){
		$ldisc =  mysqli_result($res, 0, "discipline_eng_name");
		$ldisc_short =  mysqli_result($res, 0, "discipline_short");
		$lcont =  mysqli_result($res, 0, "context_eng_name");
		$lcont_short =  mysqli_result($res, 0, "context_short");
		if ($short_long == 'long'){
			return "$ldisc - $lcont";	
		} else {
			return "$ldisc_short $lcont_short";
		}
	}
}

function PostRequest($url, $referer, $_data) {
 
    // convert variables array to string:
    $data = array();    
    while(list($n,$v) = each($_data)){
		$n = urlencode($n);
		$v = urlencode($v);
        $data[] = "$n=$v";
    }    
    $data = implode('&', $data);
 	echo "data is $data<br>";
    // format --> test1=a&test2=b etc.
 
    // parse the given URL
    $url = parse_url($url);
    if ($url['scheme'] != 'http') { 
        die('Only HTTP request are supported !');
    }
 
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];
 
    // open a socket connection on port 80
    $fp = fsockopen($host, 80);
 	echo "fp is $fp<br>";
    // send the request headers:
    fputs($fp, "POST $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp, "Referer: $referer\r\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: ". strlen($data) ."\r\n\r\n");
    //fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $data);
 
    $result = ''; 
    while(!feof($fp)) {
        // receive the results of the request
        $result .= fgets($fp, 128);

    }
 
    // close the socket connection:
    fclose($fp);
 
    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);
 
    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
 
    // return as array:
    return array($header, $content);
}
function dohome($curr_content, $home_section){
	GLOBAL $remembered_username;
	GLOBAL $current_language;
	GLOBAL $prov_info;
	GLOBAL $getlang;
	GLOBAL $page;
	GLOBAL $province;
	GLOBAL $new_province;
	GLOBAL $new_year;
	GLOBAL $year;
	GLOBAL $portuguese;
	GLOBAL $host_sport;
	GLOBAL $module;
	GLOBAL $translations;
	
	  if ($current_language != 'french'){
		  		  if ($page == 244){
					echo "<div class='clearfix'>$curr_content</div>";  
					include('news.php');
					//echo "<hr><br><br>";  
					$curr_content='';
				  } elseif ($home_section == 'Cost'){
					include('includes/cost.php');
					if ($portuguese){
						$curr_content = str_replace("All this for only <FONT size=4>__cost_display__</FONT> CAD", 
												"FPBS licensed Coaches price is <font size='4'>$cost_portuguese_member_display</font> EUR.<br>
												Non-FPBS licensed Coaches price is <font size='4'>$cost_portuguese_non_member_display</font> EUR."
												, $curr_content);		
					} else {
						$curr_content = str_replace('__cost_display__', $cost_display, $curr_content);		
					}	
				  } elseif ($home_section == 'Home'){
						/*$home_content = "<h1><p align='center'>NCCP Model - $host_sport</p></h1>";
						
						$home_content .= show_stream_boxes();
						$curr_content = str_replace('__prov_info__', $prov_info, $curr_content);		
						$curr_content = $home_content . $curr_content;*/
				  } elseif ($home_section == 'Demo'){
				  	$sortby='sm_id';
					include('includes/search_sub_modules.php');
					$temp_home_section = $home_section;
					$home_section = '';
					$curr_content .= "<blockquote><blockquote>";
					include('includes/search_pages.php');
					$currarray = array_pop($sm_array);
					foreach ($currarray as $sm_id=>$sm_value){
						if (in_array($sm_id, $page_sub_module)){
							$curr_content .= "<b>$sm_value</b><ul>\n";
							$d_array = array();
							foreach ($page_id as $page_key=>$page_value){
								if ($page_sub_module[$page_key] == $sm_id){
									if (!in_array($page_name[$page_key], $d_array)){
										$d_array[] = $page_name[$page_key];
										$curr_content .= "<li>$page_name[$page_key]</li>";
									}
								}							
							}
							$curr_content .= "</ul>\n";		
						}
					}
					$curr_content .= "</blockquote></blockquote>";
					$home_section = $temp_home_section;
				  } elseif ($page == 233){
					echo $curr_content;
					//GET PROVINCES
					if (!$province){$province = '';}
					include('includes/provinces.php');
					
					$sortby='';
					include('includes/search_modules.php');
					//GET CLINICS
					if (!$gtcomp){
						//$test=1;
						//echo "$year, $new_year<br>";
						$session_newclinics = 1;
						$sortby='clinic_start_date';
						include('includes/search_clinics.php');
					}
					include('includes/show_clinics.php');
				    $curr_content='';
				  }
		 } else { // french
				  $language = $current_language;
				  if ($page == 244){
					echo "<div class='clearfix'>$curr_content</div>";  
					include('news.php');
					//echo "<hr><br><br>";  
					$curr_content='';
				  } elseif ($page == 181){
					include('includes/cost.php');
					$curr_content = str_replace('__cost_display__', $cost_display, $curr_content);		
				  } elseif ($home_section == 'Accueil'){
					/*$home_content .= utf8_encode("<h1><p align='center'>Modèle du PNCE - $host_sport</p></h1>");
					
					$home_content .= show_stream_boxes();
					$curr_content = str_replace('__prov_info__', $prov_info, $curr_content);		
					$curr_content = $home_content . $curr_content;*/
				  } elseif ($home_section == 'Démo'){
				  	$sortby='sm_id';
					include('includes/search_sub_modules.php');
					$temp_home_section = $home_section;
					$home_section = '';
					$curr_content .= "<blockquote><blockquote>";
					include('includes/search_pages.php');
					$currarray = array_pop($sm_array);
					foreach ($currarray as $sm_id=>$sm_value){
						if (in_array($sm_id, $page_sub_module)){
							$curr_content .= "<b>$sm_value</b><ul>\n";
							$d_array = array();
							foreach ($page_id as $page_key=>$page_value){
								if ($page_sub_module[$page_key] == $sm_id){
									if (!in_array($page_name[$page_key], $d_array)){
										$d_array[] = $page_name[$page_key];
										$curr_content .= "<li>$page_name[$page_key]</li>";
									}
								}							
							}
							$curr_content .= "</ul>\n";		
						}
					}
					$curr_content .= "</blockquote></blockquote>";
					$home_section = $temp_home_section;
				  } elseif ($page == 233){
					echo $curr_content;
					//GET PROVINCES
					if (!$province){$province = '';}
					include('includes/provinces.php');
					
					//GET CLINICS
					$sortby='';
					include('includes/search_modules.php');
					//GET CLINICS
					if (!$gtcomp){
						//$test=1;
						//echo "$year, $new_year<br>";
						$session_newclinics = 1;
						$sortby='clinic_start_date';
						include('includes/search_clinics.php');
					}
					include('includes/show_clinics.php');
				    $curr_content='';
				  }
		 } 
	  return $curr_content;
}

function register($coach, $coach_name, $module, $module_name, $component, $component_type, $mc_gross, $language, $clinic=0, $mod_pay_to='NSO'){
	GLOBAL $our_email;
	GLOBAL $access;
	GLOBAL $access_level;
	GLOBAL $coach_paid;
	GLOBAL $do;
	GLOBAL $coach_province;
	GLOBAL $module_accessid_only;
	
	if ($language == 'french'){
		$regimg = 'reg_fr.gif';
		$regtext = "Inscrire";
	} else {
		$regimg = 'reg.gif';
		$regtext = "Register";
	}
	echo "
		<script language='JavaScript'>
		function change_amount(value) {
				
			if (value == 'group'){
				document.form1.mc_gross.value = $mc_gross;
			}
			if (value == 'free'){
				document.form1.mc_gross.value = 0;
			}
			if (value == 'creditcard'){
				document.form1.mc_gross.value = $mc_gross;
			}
			if (value == 'cheque'){
				document.form1.mc_gross.value = $mc_gross;
			}
			
		}
		</script>
	";
	echo "<p align='center'>\n";
	if ($clinic){
		echo "<b>$coach_name</b> is registering for <b>$module_name</b>\n";
		
		include($_SERVER["DOCUMENT_ROOT"]."/includes/search_clinics.php");
		
		if (!$clinic_cost_all[$clinic]){
			echo "<br><br><u>Select an option below:</u><br><br>";
		}
		echo "<div class='row'><div class='span6 offset3'>".show_clinic_options($clinic, true, true)."</div></div>";

		echo "<input type='hidden' id='clinic' value='$clinic'>\n";
		echo "<input type='hidden' id='coach_paid' value='".$coach_paid[$coach]."'>\n";
		echo "<input type='hidden' id='custom_start' value='$coach|'>\n";
		echo "<input type='hidden' id='coach' value='$coach'>\n";
		echo "<input type='hidden' id='access' value='$access'>\n";

	
		if ($clinic_pay_to[$clinic] == 'PSO'){
			// GET paypal email from access
			$str = "SELECT access_paypal_email FROM NCCP_Canada_Access 
					WHERE access_province='$clinic_province[$clinic]' 
					AND access_level='province'
					AND access_paypal_email IS NOT NULL
					AND access_paypal_email!=''  ";
			$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
			$rc = mysqli_num_rows($res);
			if ($rc){
				$payto =  mysqli_result($res, 0, "access_paypal_email");
			} else {
				$no_pso_for_payment = true;
			}
			//echo "$SelectStr $Results $RowCount<br>";
		} elseif ($clinic_pay_to[$clinic] == 'NSO'){
			$payto = $paypal_email;
		}
		$return = "https://$host_url/clinics.php";
		$item_number = $clinic;
		$invoice = "CLI $coach $clinic ".rand(10000, 50000);
			
		$item_name = $module_name." ".$clinic_city[$clinic]." Coaching Clinic";
		$custom = "$coach|".${'clinic_label'}[$clinic];
		$custom .= "|$firstname $lastname";
		
		$total_cost_members = 0;
		$total_cost_nonmembers = 0;
		for ($c=1;$c<=6;$c++){
			if ($c==1){
				$cdo='';
			} else {
				$cdo=$c;
			}
			$total_cost_members += ${'clinic_cost_members'.$cdo}[$clinic];
			$total_cost_nonmembers += ${'clinic_cost'.$cdo}[$clinic];
		}
		if ($coach_paid[$coach]){
			if ($clinic_cost_all[$clinic]){
				$ccost = $total_cost_members;
			} else {
				$ccost = $clinic_cost_members[$clinic];
			}
		} else {
			if ($clinic_cost_all[$clinic]){
				$ccost = $total_cost_nonmembers;
			} else {
				$ccost = $clinic_cost[$clinic];
			}
		}
		if ($access){
			$disp1='none';
			$disp2='';
		} else {
			$disp1='';
			$disp2='none';
		}
		if (!$no_pso_for_payment){
			echo paypal_button($payto, $item_name, $item_number, $ccost, $return, $invoice, $custom,'Register', $disp1);
			echo "<div align='center' style='margin: 0 auto;display:$disp2;' id='reg_button_div'><a id='reg_button' class='btn btn-primary' href='/includes/register_component.php?clinic=$clinic&coach=$coach&clinic_option_str=".urlencode(${'clinic_label'.$cdo}[$clinic])."' >Register <i class='icon-mail-forward icon-white'></i></a></div>";
		}
	} else {
		$regtexthere = "is registering for";
		if ($do == 'paid_member'){
			$regtexthere = "is accessing";
			if (paid_full_member($coach)){
				$regtexthere = "is renewing";
			}
		}
		echo "<b>$coach_name</b> $regtexthere <b>$module_name ";
		if ($mc_gross > 0){
			echo "($ $mc_gross)";
		}
		echo "</b>\n";
	}
	if ($module == 10011){
		echo "<br><br>Note: $ $mc_gross covers Practice & Game Evaluation as well";
	}
	echo "</p>\n";
	if (!$clinic){
		if ($do != 'paid_member' || !$mc_gross || $module_accessid_only[$module]){
			echo "<form name='form1' method='POST' ENCTYPE='multipart/form-data' action='register_component.php'>\n";
			echo "<p align='center'>\n";
			if ($mc_gross || $module_accessid_only[$module]){
				echo "Enter an Access ID ";
				echo "<input type='text' name='pass' class='input-large'>\n";
			}
			if ($access_level == 'all'){
				// allow to select paytype and amount
				echo "<br><br><b>OR</b> other payment method:<br><br>\n";
				echo "Pay Type: <select name='paytype' onChange='change_amount(this.value);'>\n";
		
					$paytype_array = array('group', 'free', 'creditcard', 'cheque');
					foreach ($paytype_array as $key => $value){
						echo "<option value='$value'>$value</option>\n";
					}	
					echo "</select>\n";
					
					echo "&nbsp;&nbsp;&nbsp;Cost:<input type='text' name='mc_gross' value='$mc_gross'>\n"; 
			} else {
				if ($mc_gross>0 || $module_accessid_only[$module]){
					echo "<input type='hidden' name='paytype' value='group'>\n";
				} else {
					echo "<span class='alert alert-warning text-center'>This is currently being offered at no cost.</span>";
					echo "<input type='hidden' name='paytype' value='free'>\n";
				}
				echo "<input type='hidden' name='mc_gross' value='$mc_gross'>\n";
			}
			if ($module == 10032){
				echo "<input type='hidden' name='pass_type' value='game_eval'>\n";
			} elseif ($module == 10011) {
				echo "<input type='hidden' name='pass_type' value='portfolio'>\n";
			} elseif ($component == 173) {
				echo "<input type='hidden' name='pass_type' value='online'>\n";
			} else {
				echo "<input type='hidden' name='pass_type' value='$component_type'>\n";
			}
			
			echo "&nbsp;&nbsp;<button class='btn btn-primary' name='submit'><i class='icon-ok icon-white'></i> $regtext</button>\n";
			echo "<input type='hidden' name='coach' value='$coach'>\n";
			echo "<input type='hidden' name='comp_id' value='$component'>\n";
			echo "<input type='hidden' name='module' value='$module'>\n";
			echo "<input type='hidden' name='clinic' value='$clinic'>\n";
			echo "<input type='hidden' name='do' value='$do'>\n";
			echo "</p></form>\n";
		}
		if (!$access && !$clinic && $mc_gross>0 && !$module_accessid_only[$module]){
			$item_name = $module_name;
			if ($component == 173){
				$item_number = "YRM $coach";
				$invoice = "EPF $coach YRM ".rand(10000, 50000);
			} else {
				$item_number = "EVAL $module";
				$invoice = "EPF $coach $module ".rand(10000, 50000);
			}
			$return = '';
			$custom = "$coach|$component|$component_type";
			$custom .= "|$firstname $lastname";
	
			//  PAY TO
			$payto = $our_email;
			if ($mod_pay_to == 'PSO'){
				$province_array = get_province_array($coach_province[$coach]);
				if (count($province_array)){
					$acc_id = key($province_array);
					$prov_email = $province_array[$acc_id]['access_paypal_email'];
					if ($prov_email){
						$payto = $prov_email;
					} else {
						$no_pso_for_payment = true;
					}
				}
			}
	
			if ($no_pso_for_payment){
				echo "<div class='alert alert-warning text-center'>Please contact your PSO for access code</div>";
			} else {
				echo "<p align='center'>\n";
				if ($do != 'paid_member'){
					echo "<b>OR</b> ";
					echo "Register with credit card below ";
				}
				echo paypal_button($payto, $item_name, $item_number, $mc_gross, $return, $invoice, $custom, "$regtext with Card");
				echo "</p><br><br><br><br><br><br><br><br><br>";
			}
		}
		if ($module_accessid_only[$module]){
			echo "<div class='alert alert-warning text-center'>Registration is by Access ID only.  Your PSO must provide this to you.</div>";
		}
	}
}
function paypal_button($payto, $item_name, $item_number, $amount, $return, $invoice, $custom, $reg_img='Register', $disp = ''){
	GLOBAL $host_url;

	$return = "
	<div align='center' style='margin: 0 auto;display:$disp;' id='paypal_button'>
	<form action='https://artisticswimmingcoach.ca/payform/' method='post'>
	<input type='hidden' name='cmd' value='_xclick'>
	<input type='hidden' name='business' value='$payto'>
	<input type='hidden' name='lc' value='CA'>
	<input type='hidden' name='item_name' value='$item_name' id='item_name'>
	<input type='hidden' name='item_number' value='$item_number'>
	<input type='hidden' name='amount' value='$amount' id='amount'>
	<input type='hidden' name='currency_code' value='CAD'>
	<input type='hidden' name='no_note' value='1'>
	<input type='hidden' name='no_shipping' value='1'>
	<input type='hidden' name='rm' value='1'>
	<input type='hidden' name='return' value='$return'>
	<input type='hidden' name='cancel_return' value='$return'>
	<input type='hidden' name='bn' value='PP-BuyNowBF:$img:NonHosted'>
	<input type='hidden' name='invoice' value='$invoice'>
	<input type='hidden' name='custom' value='$custom' id='custom'>
	<input type='hidden' name='tax' value='0'>
	<input type='hidden' name='notify_url' value='https://$host_url/paypal/process.php'>";
	//$return .= "<span class='label label-info'>".sprintf("$%01.2f", $amount)."</span><br><br>"; 
	$return .= "<button class='btn btn-primary' name='submit'>$reg_img <i class='icon-mail-forward icon-white'></i></button>
	<img alt='' border='0' src='https://www.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'>
	</form></div>";
	
	return $return;
}

/** PLAYER EVALUATION ***/

function player_evaluation($eval_id, $workbook, $print){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $coach;
	GLOBAL $printable;
	GLOBAL $host_url;
	GLOBAL $current_language;
	GLOBAL $translations;
	GLOBAL $sortby;
	
	$max_rows=50;
	
	$eval_array = array();
		
	
	if ($eval_id || $workbook){
		// get the season
		if ($eval_id){
			$str = "SELECT * FROM Player_Evaluations WHERE eval_id = $eval_id";
		} elseif ($workbook){
			$str = "SELECT * FROM Player_Evaluations WHERE eval_workbook = $workbook AND eval_coach=$coach";
		}
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		$num_evals = mysqli_num_rows($res);
		//echo "$str $res $num_evals<br>";
		if ($num_evals){
			$eval_array['id'] = mysqli_result($res, 0, "eval_id");
			$eval_array['coach'] = mysqli_result($res, 0, "eval_coach");
			$eval_array['name'] = mysqli_result($res, 0, "eval_name");
			$eval_array['workbook'] = mysqli_result($res, 0, "eval_workbook");
			$workbook = $eval_array['workbook'];
			$eval_array['date'] = mysqli_result($res, 0, "eval_date");
			$eval_array['location'] = mysqli_result($res, 0, "eval_location");
			$eval_array['eval_notes'] = mysqli_result($res, 0, "eval_notes");
		}
		//echo "wb is $workbook<br>";
		// THEN GET ALL OF THE TOOLS
			if ($eval_id){
				$SelectStr = "SELECT * FROM Player_Evaluation_Tools 
													WHERE (tool_eval=$eval_id)
													ORDER BY tool_order";
				$Result = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $SelectStr) : false);
				$RowCount = mysqli_num_rows($Result);
				
				for ($i = 0; $i < $RowCount; $i++){
					$tool_id = mysqli_result($Result, $i, "tool_id");	
					$tool_name_long = mysqli_result($Result, $i, "tool_name");	
					$tool_name = mysqli_result($Result, $i, "tool_name_short");	
					$tool_percent = mysqli_result($Result, $i, "tool_percentage");	
			
					$tool[$tool_id]['name_long'] = $tool_name_long;	
					$tool[$tool_id]['name'] = $tool_name;	
					$tool[$tool_id]['percent'] = $tool_percent;	
				}
			}
			//var_dump($tool);
		// get the scores
			$SelectStr = "SELECT * FROM Player_Evaluation_Scores
												WHERE (score_eval=$eval_id)
												ORDER BY score_tool";
			$Result = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $SelectStr) : false);
			$RowCount = mysqli_num_rows($Result);
			//echo "$SelectStr $RowCount<br>";
			for ($i = 0; $i < $RowCount; $i++){
				$score_row = mysqli_result($Result, $i, "score_row");	
				$score_tool = mysqli_result($Result, $i, "score_tool");	
				$score_value = mysqli_result($Result, $i, "score_value");	
				
				$score[$score_row][$score_tool] = $score_value;	
			}
	}		
	// SHOW THE SEASON CHART
		echo "<h2><p align='center' ";
		if ($eval_id && !$printable){
			echo "style='padding-left: 100px; '";
		}
		echo "><u>".$translations['Player Evaluation']."</u>\n";
		
		if ($eval_id && !$printable){
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://$host_url/tools/player_evaluation/player_eval.php?eval_id=$eval_id&sortby=$sortby&printable=1' target='_blank'>".$translations['printable']."</a>\n";
		}
		echo "</p></h2>";
		echo "<table width='95%' cellpadding=5 cellspacing=0 border=0 align='center' class='blackdashed'>\n";
		echo "<tr>\n";
		echo "<td>";
		//NAME
			if ($print){
				echo $translations['Evaluation Name'].": <font style='font-weight: normal'>".$eval_array['name']."</font>";			
			} else {
				echo $translations['Evaluation Name'].":<input type='text' name='eval_name' value='".htmlspecialchars($eval_array['name'], ENT_QUOTES)."' size=30>\n";
			}
		echo "</td>";
		echo "<td>";
		//date
			echo "Date: ";
			if ($print){
				$dt = date("M j/y", strtotime($eval_array['date']));
				if ($current_language == 'french'){
					$dt = date_to_french($dt);
				}
				echo "<font style='font-weight: normal'>$dt</font>";
			} else {
				get_date($eval_array['date'], 'date', 'eval_date');
			}
		echo "</td>";
		echo "<td>";
		//NAME
			if ($print){
				echo $translations['Location'].": <font style='font-weight: normal'>".$eval_array['location']."</font>";			
			} else {
				echo $translations['Location'].":<input type='text' name='eval_location' value='".htmlspecialchars($eval_array['location'], ENT_QUOTES)."' size=15>\n";
			}
		echo "</td>\n";
		echo "</tr>\n";
		echo "</table><br>\n";
		
	if ($eval_id){
		echo "<p align='center'><b>NOTE:</b> Grading (relative to average skill at this level): <b>4</b>-Excellent <b>3</b>-Good  <b>2</b>-Fair  <b>1</b>-Poor</p>";
		echo "<table width='95%' cellpadding=0 cellspacing=0 border=0 align='center' class='blackdashed'>\n";
		
		// SHOW EACH TOOL
			echo "<tr align='left'> \n";
			echo "<td>#</td>\n";
			$k = 0;
			if ($print){
				$nolinks = " onClick=\"return false;\"";
			}
			foreach ($tool as $tool_id=>$too){
				$name_long = $too['name_long'];
				$name = $too['name'];
				$perc = $too['percent'];
				if ($perc){
					$bg = " style='background-color: #CCCCCC;' ";
				} else {
					$bg = "";
				}
				echo "<td style='font-size: 8pt;' $bg nowrap title='$name_long'><a $nolinks title='Sort by $name_long' href='player_eval.php?eval_id=$eval_id&comeback=$comebackand&sortby=".($k++)."&printable=$printable'>$name</a></td>";
			}
		// CALCULATED SCORES
			echo "<td nwrap><a href='player_eval.php?eval_id=$eval_id&comeback=$comebackand&sortby=".($k++)."&printable=$printable' $nolinks>Total%</a></td>\n";
			echo "<td><a href='player_eval.php?eval_id=$eval_id&comeback=$comebackand&sortby=".($k++)."&printable=$printable' $nolinks>Grade</a></td>\n";
			echo "<td><a href='player_eval.php?eval_id=$eval_id&comeback=$comebackand&sortby=".($k++)."&printable=$printable' $nolinks>Rank</a></td>\n";
			echo "</tr>\n";
			echo "</tr>\n";

			echo "<tr align='left' id='toolshere'> \n";
			echo "<td>%</td>\n";
			$z = 1;
			foreach ($tool as $tool_id=>$too){
				$name = $too['name'];
				$perc = $too['percent'];
				if ($perc){
					$bg = " style='background-color: #CCCCCC;' ";
				} else {
					$bg = "";
				}
				if ($print){
					echo "<td style='font-size: 8pt;' $bg nowrap>";
					if ($perc){
						echo "$perc%";
					} else {
						echo "-";
					}
					echo "</td>";
				} else {
					echo "<td title='Click to edit' $bg ";
					if ($perc){
						echo " style='font-size: 8pt;cursor: hand;' onClick=\"show_or_not('showtool_".$tool_id."', false);show_or_not('tool_".$tool_id."', true);\"";
					}
					echo "><span id='showtool_".$tool_id."'>";
					if ($perc){
						echo "$perc%";
					} else {
						echo "-";
					}
					echo "</span>";
					echo "<input id='tool_".$tool_id."' type='text' name='tool_perc[$tool_id]' value='$perc' size=1 style='text-align: center;display:none'></td>";
				}
			}
		// CALCULATED SCORES
			echo "<td>-</td>\n";
			echo "<td>-</td>\n";
			echo "<td>-</td>\n";
			echo "</tr>\n";
		
		// GET RANKING
			$perc_array = array();
			$rank_array = array();
			$score_array = array();
			$grade_array = array('0'=>'C','50'=>'B','70'=>'A');
			
			for ($j=0; $j<$max_rows;$j++){
				$tot_perc = 0;
				foreach ($tool as $tool_id=>$too){
					$perc = $too['percent'];
					if ($score[$j]){
						$score_array[$j][] = $score[$j][$tool_id];
					}
					if ($perc){
						$tot_perc += ($score[$j][$tool_id]/4)*$perc;
					}	
				}
				if ($score[$j]){
					if ($tot_perc){
						$perc_array[$j] = $tot_perc;			
					}
					$score_array[$j][] = $tot_perc;
					if ($tot_perc == 0){
						$grade = null;
					} else {
						foreach ($grade_array as $p=>$g){
							if ($tot_perc >= $p){
								$grade = $g;
							}
						}
					}
					$score_array[$j][] = $grade;
				}
			}

			arsort($perc_array);
			$r=1;
			foreach ($perc_array as $j=>$val){
				$rank_array[$j] = $r++;
				$score_array[$j][] = $rank_array[$j];
			}
			
			//if ($sortby == '0'){
				$desc = SORT_ASC;
			//} else {
			//	$desc = SORT_DESC;
			//}			
			if (!$sortby){
				$sortby='2';
			}	
			
			//echo "sortby is $sortby<br>";
			$score_array = array_csort($score_array,"$sortby",$desc);
			//var_dump($score_array);
		
		// SHOW EACH PLAYER'S SCORES
			$long_array = array('First', 'Last', 'Comment');
			for ($j=0; $j<$max_rows;$j++){
				$disp = 'none';
				if (!$print && $j <= count($score)){
					$disp = '';
				} else {
					$k=0;
					foreach ($tool as $tool_id=>$too){
						if ($score_array[$j][$k++]){
							$disp = '';
							break;
						}
					}	
				}
				echo "<tr align='left' id='$j' style='display:$disp'> \n";
				echo "<td>".($j+1)."</td>\n";
				$k=0;
				foreach ($tool as $tool_id=>$too){
					$name = $too['name'];
					$perc = $too['percent'];
					if ($perc){
						$bg = " style='background-color: #CCCCCC;' ";
					} else {
						$bg = "";
					}
					if ($print){
						echo "<td $bg>".$score_array[$j][$k++]."</td>";
					} else {
						if (in_array($name, $long_array)){
							$size = 10;
						} else {
							$size = 1;
						}
						echo "<td $bg>";
						if ($perc){
							echo "<select name='score[$j][$tool_id]'  onFocus=\"show_or_not(".($j+1).", true);\" >";
							echo "<option value=''></option>";
							for ($n=1; $n<=4;$n++){
								if ($n == $score_array[$j][$k]){
									$selected = 'selected';
								} else {
									$selected = '';
								}
								echo "<option value='$n' $selected>$n</option>";
							}
							$k++;
							echo "</select>";
						} else {
							echo "<input style='text-align: center;' type='text' name='score[$j][$tool_id]' value='".$score_array[$j][$k++]."' size=$size onFocus=\"show_or_not(".($j+1).", true);\">";
						}
						echo "</td>";
					}
				}
				// CALCULATED SCORES
				echo "<td>".sprintf("%01.1f", $score_array[$j][$k++])."</td>";
				echo "<td>".$score_array[$j][$k++]."</td>";
				echo "<td>".$score_array[$j][$k++]."</td>";
				echo "</tr>\n";
			}


			
		echo "</table><br>\n";		
		
		echo "<table width='95%' cellpadding=0 cellspacing=0 border=0 align='center' class='blackdashed'>\n";
		echo "<tr><td>".$translations['Notes'].":<br>";
		if (!$print){
			echo "<textarea name='eval_notes' cols=100 rows=4>".$eval_array['eval_notes']."</textarea>\n";
		} else {
			echo $eval_array['eval_notes']."\n";
		}
		echo "</td></tr>\n";
		echo "</table><br><br>\n";
	}
	echo "<input type='hidden' name='workbook' value='$workbook'>\n";
	echo "<input type='hidden' name='eval_id' value='$eval_id'>\n";
	echo "<input type='hidden' name='sortby' value='$sortby'>\n";
}


class Encryption {
	var $skey 	= "A9078ASDFASAdl34"; // you can change it
 
	public function base64url_encode($s) {
		return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
	}
	
	public function base64url_decode($s) {
		return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
	}
	
    public  function encode($value){ 
 
	    if(!$value){return false;}
		$method = 'aes128';
		return $this->base64url_encode(openssl_encrypt ($value, $method, $this->skey));
    }
 
    public function decode($value){
 
        if(!$value){return false;}
		$method = 'aes128';
		return openssl_decrypt ($this->base64url_decode($value), $method, $this->skey);
    }
} 
function base64url_encode($s) {
	return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
}

function base64url_decode($s) {
	return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
}

/**
* Gets a Blip.tv video thumbnail URL when given a embed URL
* $author Ian Dunn
* @param string $embedURL e.g., http://blip.tv/play/hZBPgqbXeQA
* @param string $parse If equal to 'parse' then we'll try to parse the URL out of a larger block of text (like a post's $content), otherwise we'll assume it's the exact URL
* @return mixed If successful, the URL string e.g., http://a.images.blip.tv/Brandon-bgintro7369.jpg. If unsuccessful, boolean false
*/
function getBlipThumbnail($embedURL, $parse = '')
{
    $urlStart = strpos($embedURL, 'blip.tv/play/');
	//echo "urlStart is $urlStart<br>";
    if($urlStart === false)
        return false;
 
    // Parse out the embed URL if needed
    if($parse == 'parse')
    {
        $substrLength = strpos($embedURL, '"', $urlStart) - $urlStart;
        $embedURL = 'http://' . substr($embedURL, $urlStart, $substrLength);
    }
 
    // Open the redirect page
    $handler = curl_init();
    curl_setopt($handler, CURLOPT_URL, $embedURL);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
    $redirectPage = curl_exec($handler);
	//echo "redirectPage is $redirectPage<br>";
    curl_close($handler);
 
    // Parse out the ID
    $urlStart = strpos($redirectPage, 'file=');
    $substrLength = strpos($redirectPage, '&', $urlStart) - $urlStart;
    $redirectURL = substr($redirectPage, $urlStart, $substrLength);
    $id = substr($redirectURL, strrpos($redirectURL, '%2F') + 3);
	//echo "id is $id<br>";
 
    // Get video details
    $handler = curl_init();
    curl_setopt($handler, CURLOPT_URL, 'http://blip.tv/rss/'. $id);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
    $videoRSS = curl_exec($handler);
    curl_close($handler);
 
    // Parse out the thumbnail URL
    $urlStart = strpos($videoRSS, '');
 
    if($urlStart !== false)
    {
        $substrLength = strpos($videoRSS, '', $urlStart) - $urlStart;
        $thumbnailURL = substr($videoRSS, $urlStart + 21, $substrLength - 21);
    }
    else
    {
        $urlStart = strpos($videoRSS, 'media:thumbnail url="');
 
        if($urlStart !== false)
        {
            $substrLength = strpos($videoRSS, '"/>', $urlStart) - $urlStart;
            $thumbnailURL = substr($videoRSS, $urlStart + 21, $substrLength - 21);
        }
        else
            return false;
    }
 
    return $thumbnailURL;
}

function row_color(){
	GLOBAL $currcol;
	if ($currcol == 'FFFFCC'){
		$currcol = 'FFFFFF';
	} else {
		$currcol = 'FFFFCC';
	}
	return $currcol;
}
function random_pic($dir = 'uploads')
{
    $files = glob($dir . '/*.*');
    $file = array_rand($files);
    return $files[$file];
}

function buildTree($itemList, $parentId) {

  // return an array of items with parent = $parentId
  $result = array();
  foreach ($itemList as $item) {
    if ($item['parent'] == $parentId) {
      $newItem = $item;
      $newItem['children'] = buildTree($itemList, $newItem['id']);
      $result[] = $newItem;
    }
  }

  if (count($result) > 0) return $result;
  return null;
}

function update_sponsor($sponsor){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$today = date("Y-m-d");
	$str = "SELECT view_count FROM NCCP_Canada_Sponsor_Views WHERE view_sponsor = $sponsor AND view_day = '$today'";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
	$num_views = mysqli_num_rows($res);
		//echo "$str $res $num_pracs<br>";
	if($num_views){
		$str = "UPDATE NCCP_Canada_Sponsor_Views SET view_count=view_count+1 WHERE view_sponsor = $sponsor AND view_day = '$today'";
	} else {
		$str = "REPLACE INTO NCCP_Canada_Sponsor_Views VALUES ($sponsor, '$today', 1)";
	}
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
}

function makelink($text){
	//return preg_replace('!(http://[a-z0-9_./?=&-]+)!i', '<a href="$1" target="_blank">$1</a> ', $text." ");

	// The Regular Expression filter
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	
	// The Text you want to filter for urls
	//$text = "The text you want to filter goes here. http://google.com";
	
	// Check if there is a url in the text
	if(preg_match($reg_exUrl, $text, $url)) {
	
		   // make the urls hyper links
		   return preg_replace($reg_exUrl, "<a href=".$url[0]." target='_blank'>".$url[0]."</a> ", $text);
	
	} else {
	
		   // if no urls in the text just return the text
		   return $text;
	
	}
} 

function show_clinic_options($clinic, $doreg=false, $docheckbox=false, $reg_option=''){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $paypal_email;
	GLOBAL $coach;
	GLOBAL $access;
	
	$reg_options = explode("~", $reg_option);
	
	include($_SERVER["DOCUMENT_ROOT"]."/includes/search_clinics.php");
	
	if ($clinic_cost[$clinic] < 1){
		$ccost='-';
	} else {
		if ($doreg){
			if ($clinic_pay_to[$clinic] == 'PSO'){
				// GET paypal email from access
				$str = "SELECT access_paypal_email FROM NCCP_Canada_Access 
						WHERE access_province='$clinic_province[$clinic]' 
						AND access_level='province'
						AND access_paypal_email IS NOT NULL
						AND access_paypal_email!=''  ";
				$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
				$rc = mysqli_num_rows($res);
				if ($rc){
					$payto =  mysqli_result($res, 0, "access_paypal_email");
				} else {
					$payto = $paypal_email;
				}
				//echo "$SelectStr $Results $RowCount<br>";
			} elseif ($clinic_pay_to[$clinic] == 'NSO'){
				$payto = $paypal_email;
			}
			$return = "https://$host_url/clinics.php";
			$item_number = $clinic;
			$invoice = "CLI $coach $clinic ".rand(10000, 50000);
			
		}
		// FIRST CHECK IF OPTIONS/LABELS
		$has_labels = false;
		$different_pricing = false;
		$total_cost_members = 0;
		$total_cost_nonmembers = 0;
		for ($c=1;$c<=6;$c++){
			if ($c==1){
				$cdo='';
			} else {
				$cdo=$c;
			}
			if (${'clinic_label'.$cdo}[$clinic]){
				$has_labels = true;
			}
			if (${'clinic_cost'.$cdo}[$clinic] != ${'clinic_cost_members'.$cdo}[$clinic]){
				$different_pricing = true;
			}
			$total_cost_members += ${'clinic_cost_members'.$cdo}[$clinic];
			$total_cost_nonmembers += ${'clinic_cost'.$cdo}[$clinic];
		}
		$ccost = "<table class='table table-bordered table-striped table-hover'>";
		$ccost .= "<tr class='info'>";
		if ($clinic_cost_all[$clinic]){
			$ccost .= "<td><u>Fee</u></td>";
		} elseif ($has_labels){
			$ccost .= "<td><u>Option</u></td>";
		}
		if ($different_pricing){
			$ccost .= "<td><u>Non-Members</u></td>";
			$ccost .= "<td><u>Members</u></td>";
		} else {
			$ccost .= "<td><u>Cost</u></td>";
		}
		if ($doreg){
			if ($clinic_cost_all[$clinic]){
				$ccost .= "<td style='text-align: center;'><u>Required</u></td>";
			} elseif ($docheckbox){
				$ccost .= "<td style='text-align: center;'><u>Select Option</u></td>";
			} else {
				$ccost .= "<td style='text-align: center;'><u>Register</u></td>";
			}
		}
		$ccost .= "</tr>";
		for ($c=1;$c<=6;$c++){
			if ($c==1){
				$cdo='';
			} else {
				$cdo=$c;
			}
			$cost = ${'clinic_cost'.$cdo}[$clinic];
			if ($cost > 0 || ${'clinic_label'.$cdo}[$clinic]){
				$cl = 'info';
				$cladd='';
				if ($reg_option && in_array(${'clinic_label'.$cdo}[$clinic], $reg_options)){
					$cl = 'success';
					$cladd = "<i class='icon-ok'></i>&nbsp;";
				}
				$ccost .= "<tr class='$cl'>\n";
				
				if ($has_labels){
					$ccost .= "<td>$cladd".${'clinic_label'.$cdo}[$clinic]."</td>\n";
				}				
				$ccost .=  "<td>$".${'clinic_cost'.$cdo}[$clinic]."</td>\n";
				if ($different_pricing){
					if (${'clinic_cost_members'.$cdo}[$clinic] == 0){
						$ccost .= "<td nowrap>FREE</td>\n";
					} else {
						$ccost .= "<td nowrap>$".${'clinic_cost_members'.$cdo}[$clinic]."</td>\n";
					}
				}
				if ($doreg){
					$ccost .= "<td style='text-align: center;'>";
					if ($docheckbox){
						$checked = '';
						$disabled = '';
						if ($c==1 && !$reg_option){
							$checked = 'checked';
							if ($clinic_cost_all[$clinic]){
								$this_memcost = $total_cost_members;
								$this_nonmemcost = $total_cost_nonmembers;
							} else {
								$this_memcost = ${'clinic_cost_members'.$cdo}[$clinic];
								$this_nonmemcost = ${'clinic_cost'.$cdo}[$clinic];
							}
							$ccost .= "<input type='hidden' id='has_pay_options' value='1'>";
							$ccost .= "<input type='hidden' id='memcost' value='$this_memcost'>";
							$ccost .= "<input type='hidden' id='nonmemcost' value='$this_nonmemcost'>";
						}
						if ($clinic_cost_all[$clinic]){
							$checked = 'checked';
							$disabled = 'disabled';
						}
						$ccost .= "<input type='checkbox' class='clinic_option' name='clinic_option[]' value='".${'clinic_label'.$cdo}[$clinic]."' $checked data-memcost='".${'clinic_cost_members'.$cdo}[$clinic]."' data-nonmemcost='".${'clinic_cost'.$cdo}[$clinic]."' $disabled>";
					} elseif ($access || ${'clinic_cost_members'.$cdo}[$clinic] == 0){
						$ccost .= "<a class='btn btn-primary' href='/includes/register_component.php?clinic=$clinic&coach=$coach&clinic_option=".urlencode(${'clinic_label'.$cdo}[$clinic])."' >Register <i class='icon-mail-forward icon-white'></i></a>";
					} else {
						$item_name = $clinic_name[$clinic]." Workshop (".${'clinic_label'.$cdo}[$clinic].")";
						$custom = "$coach|".${'clinic_label'.$cdo}[$clinic];
						$custom .= "|$firstname $lastname";						
						$ccost .= paypal_button($payto, $item_name, $item_number, $this_memcost+1, $return, $invoice, $custom,'Register' );
					}
					$ccost .= "</td>\n";
					
				}
				$ccost .= "</tr>\n";
			}
		}
		$ccost .= "</table>";
		
	}
	return $ccost;
	
}

function get_clinic_price($clinic, $options){
	GLOBAL $link;
	GLOBAL $dbName;
	
	include($_SERVER["DOCUMENT_ROOT"]."/includes/search_clinics.php");
	$return_array = array();

	for ($c=1;$c<=6;$c++){
		if ($c==1){
			$cdo='';
		} else {
			$cdo=$c;
		}
		$label = ${'clinic_label'.$cdo}[$clinic];
		if (in_array($label, $options)){
			$cost = ${'clinic_cost'.$cdo}[$clinic];
			$cost_member = ${'clinic_cost_members'.$cdo}[$clinic];
			$return_array['nonmember'] += $cost;
			$return_array['member'] += $cost_member;
		}
	}
	return $return_array;

}

function paid_full_member($coach){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$str = "SELECT payment_date, payment_lifetime FROM NCCP_Canada_Payments, NCCP_Canada_Component_Registrations 
				WHERE payment_reg=reg_id
				AND payment_coach=$coach
				AND reg_component=173
				ORDER BY payment_date DESC ";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);
	if ($_SERVER['REMOTE_ADDR'] == '24.85.1.83'){
	//	echo "$str $res $rc<br>";
	}
	if ($rc){
		$payment_date =  mysqli_result($res, 0, "payment_date");
		$payment_lifetime =  mysqli_result($res, 0, "payment_lifetime");
		if ($payment_lifetime){
			return 1;
		} else {
			return $payment_date;
		}
	} else {
		return false;
	}
}

function check_member_expiry($paid_date){
	
	if ($paid_date && $paid_date != 1){
		if ($paid_date >= "2020-03-22" && $paid_date <= "2020-06-30"){
			$expiry = "2020-06-30";
		} else {
			$expiry = date("Y-m-d", strtotime("+1 year",strtotime($paid_date)));
		}
	}
	return $expiry;
	
}

function paid_cassa_member($coach){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$str = "SELECT payment_date FROM NCCP_Canada_Payments, NCCP_Canada_Component_Registrations 
				WHERE payment_reg=reg_id
				AND payment_coach=$coach
				AND reg_component=174
				ORDER BY payment_date DESC ";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);
	if ($rc){
		$payment_date =  mysqli_result($res, 0, "payment_date");
		return $payment_date;
	} else {
		return false;
	}
}

function get_expiring_coaches($when=''){ // when is month, week, day, or all expired if empty
	GLOBAL $link;
	GLOBAL $dbName;
	
	$str = "SELECT coach_id, coach_lastname, coach_firstname, coach_email, payment_date, reg_component FROM NCCP_Canada_Payments, NCCP_Canada_Component_Registrations, NCCP_Canada_Coaches
				WHERE payment_reg=reg_id
				AND reg_coach=coach_id
				AND (reg_component=173 OR reg_component=174)"; // 173 is FULL MEMBER, 174 is CAS
	if ($when){
		if ($when == 'month'){
			$whendate = date("Y-m-d", strtotime("-11 months"));
		} elseif ($when == 'week'){
			$whendate = date("Y-m-d", strtotime("-51 weeks"));
		} elseif ($when == 'day'){
			$whendate = date("Y-m-d", strtotime("-1 year"));
		}
		$str .= " AND payment_date='$whendate' ";
	} else {
		$whendate = date("Y-m-d", strtotime("-1 year"));
		$str .= " AND payment_date < '$whendate' ";
	}
	$str .= " ORDER BY payment_date DESC ";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);
	$expiring_array = array();
	if ($rc){
		for ($i = 0; $i < $rc; $i++){		
			$coach_id =  mysqli_result($res, $i, "coach_id");
			$coach_lastname =  mysqli_result($res, $i, "coach_lastname");
			$coach_firstname =  mysqli_result($res, $i, "coach_firstname");
			$coach_email =  mysqli_result($res, $i, "coach_email");
			$payment_date =  mysqli_result($res, $i, "payment_date");
			$reg_component =  mysqli_result($res, $i, "reg_component");
			if ($reg_component == 173){
				$type = 'full';
			} elseif ($reg_component == 174){
				$type = 'cassa';
			}
			$expiring_array[$coach_id]['lastname'] = $coach_lastname;
			$expiring_array[$coach_id]['firstname'] = $coach_firstname;
			$expiring_array[$coach_id]['email'] = $coach_email;
			$expiring_array[$coach_id]['payment_date'] = $payment_date;
			$expiring_array[$coach_id]['type'] = $type;
		}
	}
	return $expiring_array;
}

function get_facilitator_contexts($facilitator){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$str = "SELECT level_context FROM NCCP_Canada_Facilitators, NCCP_Canada_Levels 
			WHERE facilitator_level=level_id 
			AND facilitator_coach=$facilitator";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);
	$context_array = array();
	if ($rc){
		for ($i = 0; $i < $rc; $i++){		
			$level_context =  mysqli_result($res, $i, "level_context");
			$context_array[] = $level_context;
		}
	}
	return $context_array;
}

function check_registered_module($coach, $module){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$str = "SELECT * FROM NCCP_Canada_Component_Registrations, NCCP_Canada_Clinics 
			WHERE reg_clinic_eval=clinic_id
			AND clinic_module=$module
			AND reg_coach=$coach";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);

	if ($rc){
		return true;
	} else {
		return false;
	}
}

function get_module_context($module){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$str = "SELECT level_modules_required, level_context FROM NCCP_Canada_Levels WHERE level_active=1";
	$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
	$rc = mysqli_num_rows($res);
	
	$module_contexts = array();
	if ($rc){
		for ($i = 0; $i < $rc; $i++){		
			$level_context = mysqli_result($res, $i, "level_context");
			$level_modules_required = explode("|", mysqli_result($res, $i, "level_modules_required"));
			if (in_array($module, $level_modules_required)){
				$module_contexts[] = $level_context;
			}
		}
	}
	return $module_contexts;
}

function check_prerequisites_done($mod, $coach){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $comp_id;
	GLOBAL $module_prerequisites;
	GLOBAL $prereqs_array;
	
	$is_completed = true;
	if ($module_prerequisites[$mod]){
		$prereq_disp .= "<ul style='text-align: left;'>";
		$prereqs = $prereqs_array[$mod];					
		foreach ($prereqs as $prereq){
			// IF SO, CHECK IF PREREQUISITE COMPLETED
			$str = "SELECT * FROM NCCP_Canada_Component_Registrations, NCCP_Canada_Components 
								WHERE reg_component=component_id 
								AND component_module=$prereq
								AND reg_coach=$coach";
			if ($comp_id == 42){
				$str .= " AND (reg_status='passed')";
			} else {
				$str .= " AND (reg_status='passed' OR reg_status='credit')";
			}
			$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $str) : false);
			$rc = mysqli_num_rows($res);
			if ($_SERVER['REMOTE_ADDR'] == '24.85.1.83'){
			//echo "$str $res $rc<br>";
			}
			if (!$rc){
				$is_completed = false;
				break;
			}
		}
	}
	return $is_completed;
}

function add_full_member($coach){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $host_name;
	
	$regdate = date("Y-m-d H:i:s");
	
	// INSERT YEARLY MEMBERSHIP REGISTRATION
		$str = "INSERT INTO NCCP_Canada_Component_Registrations VALUES (null, 173, null, $coach, '$regdate', '$regdate', 0, null, 'completed', null, '', 0, null, null, null, null, null)";							
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		$reg = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
	// INSERT PAYMENT
	
		$paytype='free';
		$cost=0;
		$paypal_fee=0;
		$payment_lifetime=0;
		$receiver_email = $host_name;
  
		$str = "INSERT INTO NCCP_Canada_Payments VALUES (null, $coach, $reg, '$cost', '$regdate', '$paytype', '$pass', '', '$txn_id', $paypal_fee, $payment_lifetime, '$receiver_email')";							
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);

}

function register_exam ($module, $coach, $reg_id=0, $reg_exam_number=1){
	
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $sub_modules_array;
	
	if ($reg_id){
		$sql = "UPDATE NCCP_Canada_Component_Registrations
						SET reg_status='incomplete', 
						reg_option=$reg_exam_number
						WHERE reg_id=$reg_id";
		//echo $sql;
		$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	} else {
		
		$sub_mods = $sub_modules_array[$module];
		$sub_module = reset($sub_mods);
			
		$sql = "SELECT component_id FROM NCCP_Canada_Components WHERE component_module=$module AND component_type='exam' "; 
		$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
		$row = mysqli_fetch_assoc($query);
		$component_id = $row['component_id'];
		if ($component_id){
			$sql = "INSERT INTO NCCP_Canada_Component_Registrations
							(reg_component, reg_coach, reg_regdate, reg_status, reg_option)
							VALUES
							($component_id, $coach, NOW(), 'registered', $reg_exam_number)
							";
			//echo $sql;
			$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
			$reg = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
			return $reg;
		}
	}
}

function get_exam_registration($module, $coach, $year, $roption=''){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $sub_modules_array;
	
	if (!$year){
		$year = date("Y");
	}
	
	$sub_mods = $sub_modules_array[$module];
	$sub_module = reset($sub_mods);
	
	$roption_str = "";
	if ($roption){
		$roption_str = " AND reg_option='$roption' ";
	}
	
	$sql = "SELECT * FROM NCCP_Canada_Component_Registrations, NCCP_Canada_Components , NCCP_Canada_Coaches, NCCP_Canada_Modules
							WHERE reg_component=component_id 
							AND component_module=module_id
							AND component_module=$module 
							AND reg_coach=coach_id 
							AND reg_regdate LIKE '$year-%' 
							AND reg_coach=$coach
							$roption_str
							ORDER BY reg_id DESC
							"; 

	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);

	$reg_array = array();

	while($row = mysqli_fetch_assoc($query)){
		$reg_id = $row['reg_id'];
		foreach($row as $key=>$value) {
			$reg_array[$reg_id][$key] = $value;
		}
		// GET ANY ANSWERS
		$reg_array[$reg_id]['answers'] = get_exam_answers($reg_id, $sub_module, $coach);
	}
	
	return $reg_array;
	
}

function get_exam_registrations($year=0, $module=0, $province='', $sortby='coach_lastname'){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $sub_modules_array;
	
	if (!$year){
	//	$year = date("Y");
	}
	
	$sub_mods = $sub_modules_array[$module];
	$sub_module = reset($sub_mods);
	
	$sql = "SELECT * FROM NCCP_Canada_Coaches, NCCP_Canada_Component_Registrations, NCCP_Canada_Components, NCCP_Canada_Modules
							WHERE reg_component=component_id 
							AND component_module=module_id
							AND component_type='exam'
							AND reg_coach=coach_id ";
	if ($year){
		$sql .= " AND reg_regdate LIKE '$year-%' ";
	} 
	if ($module){
		$sql .= " AND component_module=$module ";
	}
	if ($province){
		$sql .= " AND coach_province='$province' ";
	}
	
	if ($sortby){
		$sql .= " ORDER BY $sortby, coach_lastname ";
	}
	if ($_SERVER['REMOTE_ADDR'] == '24.85.1.83'){
	//	echo "$sql<br>";
	}
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);

	$reg_array = array();

	while($row = mysqli_fetch_assoc($query)){
		$reg_id = $row['reg_id'];
		foreach($row as $key=>$value) {
			$reg_array[$reg_id][$key] = $value;
		}
	}
	
	return $reg_array;
	
}

function get_exam_answers($reg, $sub_module, $coach){
	GLOBAL $link;
	GLOBAL $dbName;
		
	$sql = "SELECT * FROM NCCP_Canada_Answers, NCCP_Canada_Questions 
							WHERE answer_question=question_id 
							AND question_sub_module=$sub_module 
							AND answer_reg=$reg
							AND answer_coach=$coach
							ORDER BY question_id"; 
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);

	$answer_array = array();

	while($row = mysqli_fetch_assoc($query)){
		$question_id = $row['question_id'];
		$question_answer = $row['question_answer'];
		$answer_answer = $row['answer_answer'];
		$answer_array[$question_id]['correct_answer'] = $question_answer;		
		$answer_array[$question_id]['answer'] = $answer_answer;		
	}
	return $answer_array;
}

function get_exam_questions ($sub_module, $exam_number){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $getlang;
	
	if (!$getlang){
		$getlang='eng';
	}
		
	$sql = "SELECT * FROM NCCP_Canada_Questions 
							WHERE question_sub_module=$sub_module 
							AND question_exam_number=$exam_number
							AND question_active=1
							ORDER BY question_id"; 
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);

	$question_array = array();

	while($row = mysqli_fetch_assoc($query)){
		$question_id = $row['question_id'];
		foreach($row as $key=>$value) {
			$question_array[$question_id][$key] = $value;
		}
		$question_type = $row['question_type'];
		if ($question_type == 'mc'){
			$sql2 = "SELECT * FROM NCCP_Canada_Question_Answers 
									WHERE q_answer_question=$question_id 
									ORDER BY q_answer_letter"; 
			$query2 = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql2) : false);
			
			while($row2 = mysqli_fetch_assoc($query2)){
				$ans_letter = $row2['q_answer_letter'];
				$answer = $row2['q_answer_'.$getlang];
				$question_array[$question_id]['possible_answers'][$ans_letter] = $answer;
			}
		}
	}
	return $question_array;
}


function get_exam_time($reg){
	GLOBAL $link;
	GLOBAL $dbName;
	$SelectStrC = "SELECT * FROM NCCP_Canada_Exam_Time WHERE et_reg=$reg ";
	$ResultsC = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $SelectStrC) : false);
	$RowcountC = mysqli_num_rows($ResultsC);
	$et_time_elapsed=0;
	if ($RowcountC){
		$et_time_elapsed = mysqli_result($ResultsC, 0, "et_time_elapsed");
	}
	return $et_time_elapsed;
}

function save_exam_time ($reg, $seconds_to_finish){
	
	GLOBAL $link;
	GLOBAL $dbName;
		
	$sql = "SELECT * FROM NCCP_Canada_Exam_Time WHERE et_reg=$reg "; 
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
	$return = "";
	$row = mysqli_fetch_assoc($query);
	//var_dump($row);
	if ($row['et_reg']){
		if ($row['et_time_elapsed'] >= $seconds_to_finish){
			return $seconds_to_finish;
		}
		$return = $row['et_time_elapsed']+10;
		$sql = "UPDATE NCCP_Canada_Exam_Time SET et_time_elapsed=et_time_elapsed+10 WHERE et_reg=$reg";
	} else {
		$sql = "INSERT INTO NCCP_Canada_Exam_Time
						(et_reg, et_time_elapsed)
						VALUES
						($reg, 10)
						";
		$return = 10;
	}
	//echo "return is $return\n";
	//echo "sql is $sql\n";
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	return $return;
}

function save_exam_answer ($coach, $reg, $question, $answer, $order=0){
	
	GLOBAL $link;
	GLOBAL $dbName;
		
	$sql = "SELECT * FROM NCCP_Canada_Answers WHERE answer_reg=$reg AND answer_coach=$coach AND answer_question=$question "; 
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
	$return = "";
	$row = mysqli_fetch_assoc($query);
	if ($row['answer_question']){
		$sql = "UPDATE NCCP_Canada_Answers SET answer_answer='$answer', answer_date=NOW() WHERE answer_reg=$reg AND answer_coach=$coach AND answer_question=$question ";
		$return = "updated";
	} else {
		$sql = "INSERT INTO NCCP_Canada_Answers
						(answer_coach, answer_reg, answer_question, answer_answer, answer_order, answer_date)
						VALUES
						($coach, $reg, $question, '$answer', $order, NOW())
						";
		$return = "inserted";
	}
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	return $return;
}

function save_finished ($sub_module, $coach, $reg_id, $exam_number){
	
	GLOBAL $link;
	GLOBAL $dbName;
	
	// FIRST MARK EXAM
	$correct_answers = mark_exam($reg_id, $sub_module, $coach);
	
	$percent_needed = get_percentage_needed($sub_module);
		
	$questions = get_exam_questions ($sub_module, $exam_number);
	
	$num_questions = count($questions);
	
	$percentage = 100*($correct_answers/$num_questions);
	$percentage_str = number_format($percentage, 2);
	
	$saved_stuff = "$correct_answers/$num_questions|$percentage_str";
	
	if ($percentage >= $percent_needed){
		$reg_status = 'passed';
	} else {
		$reg_status = 'failed';
	}
	
	$sql = "UPDATE NCCP_Canada_Component_Registrations SET reg_status='$reg_status', reg_completed_date=NOW(), reg_evaluation_comment='$saved_stuff'  WHERE reg_id=$reg_id ";
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
	$return_str = "$percentage_str|$reg_status|$sql";
	return $return_str;
}

function mark_exam($reg, $sub_module, $coach){
	
	$answers = get_exam_answers($reg, $sub_module, $coach);
	
	$num_correct = 0;
	foreach ($answers as $qid=>$astuff){
		if ($astuff['answer'] == $astuff['correct_answer']){
			$num_correct++;
		}
	}
	return $num_correct;
	
}

function get_percentage_needed($sub_module){
	
	GLOBAL $link;
	GLOBAL $dbName;
	$sql = "SELECT sm_score_needed FROM NCCP_Canada_Sub_Modules WHERE sm_id=$sub_module "; 
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
	$return = 0;
	$row = mysqli_fetch_assoc($query);
	if ($row['sm_score_needed']){
		$return = $row['sm_score_needed'];
	}
	return $return;
}

function get_exam_modules (){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $getlang;
	
	$sql = "SELECT * FROM NCCP_Canada_Modules, NCCP_Canada_Components 
					WHERE component_module=module_id 
					AND module_has_exam=1 
					ORDER BY component_order"; 
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
	$return_array = array();
	while ($row = mysqli_fetch_assoc($query)){
		$module_id = $row['module_id'];
		$module_name = $row['module_'.$getlang.'_name'];
		$component_id = $row['component_id'];
		$return_array[$module_id]['module_name'] = $module_name;
		$return_array[$module_id]['comp_id'] = $component_id;
	}
	return $return_array;
}

function get_clinic_reg($coach, $module){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $getlang;
	
	$return_array = array();
	if ($coach && $module){
		$sql = "SELECT * FROM NCCP_Canada_Component_Registrations, NCCP_Canada_Components, NCCP_Canada_Clinics
						WHERE reg_component=component_id
						AND reg_clinic_eval=clinic_id
						AND component_module=$module
						AND reg_coach=$coach
						AND (reg_status = 'passed' OR reg_status='credit')
						ORDER BY reg_completed_date DESC"; 
		$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
		
		while ($row = mysqli_fetch_assoc($query)){
			$clinic_id = $row['clinic_id'];
			foreach ($row as $key=>$value){
				$return_array[$clinic_id][$key] = $value;
			}
		}
	}
	
	return $return_array;
}

function get_module_reg($coach, $module){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $getlang;
	
	$return_array = array();
	if ($coach && $module){
		$sql = "SELECT * FROM NCCP_Canada_Component_Registrations, NCCP_Canada_Components
						WHERE reg_component=component_id
						AND component_module=$module
						AND reg_coach=$coach
						AND (reg_status = 'passed' OR reg_status='credit')
						ORDER BY reg_completed_date DESC"; 
		$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
		
		while ($row = mysqli_fetch_assoc($query)){
			$reg_id = $row['reg_id'];
			foreach ($row as $key=>$value){
				$return_array[$reg_id][$key] = $value;
			}
		}
	}
	
	return $return_array;
}

function get_province_array($province){
	GLOBAL $link;
	GLOBAL $dbName;

	$return_array = array();
	
	if ($province){
		$sql = "SELECT * FROM NCCP_Canada_Access 
						WHERE access_province='$province' 
						AND access_level='province'
						AND access_main_province=1"; 
		$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
		
		while ($row = mysqli_fetch_assoc($query)){
			$access_id = $row['access_id'];
			foreach ($row as $key=>$value){
				$return_array[$access_id][$key] = $value;
			}
		}
	}
	
	return $return_array;
	
}
function makeLinks($str) {
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?/";
	$urls = array();
	$urlsToReplace = array();
	if(preg_match_all($reg_exUrl, $str, $urls)) {
		$numOfMatches = count($urls[0]);
		$numOfUrlsToReplace = 0;
		for($i=0; $i<$numOfMatches; $i++) {
			$alreadyAdded = false;
			$numOfUrlsToReplace = count($urlsToReplace);
			for($j=0; $j<$numOfUrlsToReplace; $j++) {
				if($urlsToReplace[$j] == $urls[0][$i]) {
					$alreadyAdded = true;
				}
			}
			if(!$alreadyAdded) {
				array_push($urlsToReplace, $urls[0][$i]);
			}
		}
		$numOfUrlsToReplace = count($urlsToReplace);
		for($i=0; $i<$numOfUrlsToReplace; $i++) {
			$str = str_replace($urlsToReplace[$i], "<a class='bluebold' href='".$urlsToReplace[$i]."' target='_blank'>".$urlsToReplace[$i]."</a> ", $str);
		}
		return $str;
	} else {
		return $str;
	}
}

function search_member($search_array, $andor='OR'){
	GLOBAL $link;
	GLOBAL $dbName;
		
	$sql = "SELECT * FROM NCCP_Canada_Coaches WHERE coach_processed=1 "; 
	$searching = array();
	foreach ($search_array as $search_field=>$search_value){
		$searching[] = " $search_field LIKE '$search_value' ";
	}
	if (count($searching)){
		$search_str = implode(" $andor ", $searching);
		$sql .= " AND (".$search_str.")";
	}
	$sql .= " LIMIT 1 ";
	if ($_SERVER['REMOTE_ADDR'] == '24.85.9.12'){
	//	echo "$sql<br>";
	}
	$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
	
	$row = mysqli_fetch_assoc($query);
	$return = '';
	if ($row['coach_id']){
		foreach ($search_array as $search_field=>$search_value){
			$searchthing = $row[$search_field];
			if (strtolower($searchthing) == strtolower($search_value)){
				$searchf = str_replace("coach_", "", $search_field);
				$searchf = str_replace("_", " ", $searchf);
				$searchf = strtoupper($searchf);
				if ($searchf == 'CASSA'){
					$searchf = "CAS#";
				}
				$return .= "$searchf of $search_value is already in use.<br>";
			}
		}
	}
	return $return;
}
function url_exists($url){
	$headers = @get_headers($url);
	if(strpos($headers[0],'200')===false)return false;
}

function check_last_registration($coach, $comp_id, $clinic=0){
	GLOBAL $link;
	GLOBAL $dbName;
	
	$addclinic = "";
	if ($clinic){
		$addclinic = " AND reg_clinic_eval = $clinic ";
	}
	$qstring = "SELECT reg_regdate, reg_clinic_eval FROM NCCP_Canada_Component_Registrations
					WHERE reg_coach=$coach
					AND reg_component=$comp_id
					AND reg_completed_date IS NULL
					AND reg_status != 'credit'
					$addclinic
					ORDER BY reg_regdate DESC
					LIMIT 1
					";
	
	$result = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $qstring) : false);
		
    $last_regdate_date = "";
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$last_regdate_date = $row['reg_regdate'];
	}
	return $last_regdate_date;
}

function check_username($username){
	
	include($_SERVER["DOCUMENT_ROOT"]."/includes/mysql.php");
	$mysqli = new mysqli($localhost, $MysqlName, $MysqlPW, $dbName);
	
	$qstring = "SELECT * FROM NCCP_Canada_Coaches WHERE coach_username='$username' AND coach_processed=1";
	$result = $mysqli->query($qstring) or die($mysqli->error.__LINE__);
	$num_users = (int)$result->num_rows;

	$direxists = file_exists($_SERVER["DOCUMENT_ROOT"]."/$username");
	if ($direxists){
		$hasdir = 1;
	} else {
		$hasdir = 0;
	}
	$numused = $num_users+$hasdir;
	return $numused;

}

function get_coach($coach=0, $email=''){
	GLOBAL $link;
	GLOBAL $dbName;
	
	if (!$link){
		include($_SERVER["DOCUMENT_ROOT"]."/includes/mysql.php");
		$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect("$localhost", $MysqlName, $MysqlPW));
	}
	
	$return_array = array();
	$sql = "SELECT * FROM NCCP_Canada_Coaches WHERE coach_processed=1 ";
	
	if ($coach){
		$sql .= " AND coach_id=$coach ";
	} elseif ($email){
		$sql .= " AND coach_email='$email' ";
	}

	$result = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql ) : false);
	
	$row = $result->fetch_assoc();
	foreach ($row as $key=>$value){
		$return_array[$key] = $value;
	}

	return $return_array;
}

function reset_password_email($email, $from_admin=false){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $host_email;
	GLOBAL $host_url;
	GLOBAL $host_name;
	GLOBAL $debug_email;
	
	// GET THE COACH
	$coach_array = get_coach(0, $email);
	$successful_email = 0;
	
	if (!count($coach_array)){
		$successful_email = false;
	} else {
		$coach_id = $coach_array['coach_id'];
		$current_language = $coach_array['coach_language'];
		$firstname = $coach_array['coach_firstname'];
		$user_username = $coach_array['coach_username'];
		$email = $coach_array['coach_email'];
		
		$currdate = date("Y-m-d H:i:s");
		$cryptcode = new Encryption;
		$coach_date_encrypted = $cryptcode->encode("$coach_id|$currdate");
		
		$url = "https://$host_url/reset_password.php?coach_date=$coach_date_encrypted";
			
		// SEND AN ENCRYPTED LINK TO THE RESET PAGE
		if ($from_admin){
			$french_start = "Nous vous recommandons de réinitialiser votre mot de passe.";
			$english_start = "We recommend you reset your password.";
		} else {
			$french_start = "Vous avez demandé la réinitialisation de votre mot de passe.";
			$english_start = "You have requested to have your password reset.";
		}
		
		if ($current_language == 'french'){
	
			$temp = "<font size='2' face='Arial, Helvetica, sans-serif'>Bonjour $firstname, <br><br>
			$french_start<br><br>
			Votre nom d’utilisateur est:  <b>$user_username</b><br>
			Pour réinitialiser votre mot de passe, cliquez sur le lien ci-dessous<br><br>
			<a href='$url' target='_blank'>$url</a><br><br>
			* Ce lien expirera dans 30 minutes.<br><br>
			Ecrivez à <a href='mailto:$host_email'>$host_email</a> si vous avez des questions.<br><br>
			Merci,<br>
			<a href='https://$host_url'>$host_url</a>";
		
			// To send HTML mail, you can set the Content-type header. 
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		
			// additional headers 
			$headers .= "From: $host_name <$host_email>\n";
		
			//$headers .= "Cc: birthdayarchive@example.com\n";
			//$headers .= "Bcc: $debug_email\n";
		
			$email_to = $email;
			//$email_to = $debug_email;
			$email_subject = "$host_name réinitialiser le mot de passe";
			$email_body = $temp;
			$email_headers = $headers;
			include($_SERVER["DOCUMENT_ROOT"]."/includes/mail.php");
		
		} else {
			$temp = "<font size='2' face='Arial, Helvetica, sans-serif'>Hello $firstname, <br><br>
			$english_start<br><br>
			Your username is:  <b>$user_username</b><br><br>
			In order reset your password, go to the link below:<br><br>
			<a href='$url' target='_blank'>$url</a><br><br>
			* This link will expire in 30 minutes.<br><br>
			Email <a href='mailto:$host_email'>$host_email</a> if you have any questions.<br><br>
			Thanks again,<br>
			<a href='https://$host_url'>$host_url</a>";
		
			// To send HTML mail, you can set the Content-type header. 
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		
			// additional headers 
			$headers .= "From: $host_name <$host_email>\n";
		
			//$headers .= "Cc: birthdayarchive@example.com\n";
			//$headers .= "Bcc: $debug_email\n";
		
			$email_to = $email;
			//$email_to = $debug_email;
			$email_subject = "$host_name password reset";
			$email_body = $temp;
			$email_headers = $headers;
			include($_SERVER["DOCUMENT_ROOT"]."/includes/mail.php");
		}
	}

	return $successful_email;
	
}

function reset_password_email_admin($access_id, $from_admin){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $host_email;
	GLOBAL $host_url;
	GLOBAL $host_name;
	GLOBAL $debug_email;
	
	// GET THE COACH
	$admin_array = get_admin_array($access_id);
	$successful_email = 0;
	
	if (!count($admin_array)){
		$successful_email = false;
	} else {
		$access_id = $admin_array['access_id'];
		$current_language = $admin_array['access_language'];
		$firstname = $admin_array['access_firstname'];
		$user_username = $admin_array['access_username'];
		$email = $admin_array['access_email'];
		
		$currdate = date("Y-m-d H:i:s");
		$cryptcode = new Encryption;
		$admin_date_encrypted = $cryptcode->encode("$access_id|$currdate");
		
		$url = "https://$host_url/admin/reset_password_admin.php?admin_date=$admin_date_encrypted";
			
		// SEND AN ENCRYPTED LINK TO THE RESET PAGE
		if ($from_admin){
			$french_start = "Nous vous recommandons de réinitialiser votre mot de passe.";
			$english_start = "We recommend you reset your password.";
		} else {
			$french_start = "Vous avez demandé la réinitialisation de votre mot de passe.";
			$english_start = "You have requested to have your password reset.";
		}
		
		if ($current_language == 'french'){
	
			$temp = "<font size='2' face='Arial, Helvetica, sans-serif'>Bonjour $firstname, <br><br>
			$french_start<br><br>
			Votre nom d’utilisateur est:  <b>$user_username</b><br>
			Pour réinitialiser votre mot de passe, cliquez sur le lien ci-dessous<br><br>
			<a href='$url' target='_blank'>$url</a><br><br>
			* Ce lien expirera dans 30 minutes.<br><br>
			Ecrivez à <a href='mailto:$host_email'>$host_email</a> si vous avez des questions.<br><br>
			Merci,<br>
			<a href='https://$host_url'>$host_url</a>";
		
			// To send HTML mail, you can set the Content-type header. 
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		
			// additional headers 
			$headers .= "From: $host_name <$host_email>\n";
		
			//$headers .= "Cc: birthdayarchive@example.com\n";
			//$headers .= "Bcc: $debug_email\n";
		
			$email_to = $email;
			//$email_to = $debug_email;
			$email_subject = "$host_name réinitialiser le mot de passe";
			$email_body = $temp;
			$email_headers = $headers;
			include($_SERVER["DOCUMENT_ROOT"]."/includes/mail.php");
		
		} else {
			$temp = "<font size='2' face='Arial, Helvetica, sans-serif'>Hello $firstname, <br><br>
			$english_start<br><br>
			Your username is:  <b>$user_username</b><br><br>
			In order reset your password, go to the link below:<br><br>
			<a href='$url' target='_blank'>$url</a><br><br>
			* This link will expire in 30 minutes.<br><br>
			Email <a href='mailto:$host_email'>$host_email</a> if you have any questions.<br><br>
			Thanks again,<br>
			<a href='https://$host_url'>$host_url</a>";
		
			// To send HTML mail, you can set the Content-type header. 
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		
			// additional headers 
			$headers .= "From: $host_name <$host_email>\n";
		
			//$headers .= "Cc: birthdayarchive@example.com\n";
			//$headers .= "Bcc: $debug_email\n";
		
			$email_to = $email;
			//$email_to = $debug_email;
			$email_subject = "$host_name Admin password reset";
			$email_body = $temp;
			$email_headers = $headers;
			include($_SERVER["DOCUMENT_ROOT"]."/includes/mail.php");
		}
	}

	return $successful_email;
	
}

function valid_password($password, $cpassword){
	
	$passwordErr='';
	if(!empty($password) && ($password == $cpassword)) {
		if (strlen($password) <= '8') {
			$passwordErr = "Your Password Must Contain At Least 8 Characters!";
		}
		elseif(!preg_match("#[0-9]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Number!";
		}
		elseif(!preg_match("#[A-Z]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
		}
		elseif(!preg_match("#[a-z]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
		}
	} elseif(!empty($password) && ($password != $cpassword)) {
		$passwordErr = "Your passwords must match!";
	} elseif(!empty($password)) {
		$passwordErr = "Please Check You've Entered Or Confirmed Your Password!";
	} else {
		 $passwordErr = "Please enter password!";
	}	
	if ($passwordErr){
		$passwordErr .= "<br><br><small>NOTE: Password must contain at least 8 characters,<br>
								contain at least 1 number,<br>
								contain at least 1 capital letter,<br>
								contain at least 1 lowercase letter<br>
								</small>";
	}
	
	return $passwordErr;
	
}

function save_password($coach, $password){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $hash_secret;
	GLOBAL $hash_secret_better;

	// CHECK THE PASSWORD
	$password_error = valid_password($password, $password);
	if ($password_error == '' && $coach){
		// UPDATE THE COACH	
		$str = " UPDATE NCCP_Canada_Coaches SET coach_password=\"$password\"
					WHERE coach_id=$coach ";
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		
		return "updated";
		
	} else {
		return $password_error;
	}

}

function save_password_admin($access_id, $password){
	GLOBAL $link;
	GLOBAL $dbName;
	GLOBAL $hash_secret;
	GLOBAL $hash_secret_better;

	// CHECK THE PASSWORD
	$password_error = valid_password($password, $password);
	if ($password_error == '' && $access_id){
		// UPDATE THE COACH	
		$cryptcode = new Encryption;
		$password_encrypted = $cryptcode->encode($password);

		$str = " UPDATE NCCP_Canada_Access SET access_password_encrypted=\"$password_encrypted\"
					WHERE access_id='$access_id' ";
		$res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"],  $str) : false);
		
		return "updated";
		
	} else {
		return $password_error;
	}

}

function get_admin_array($access_id){
	GLOBAL $link;
	GLOBAL $dbName;

	$return_array = array();
	
	if ($access_id){
		$sql = "SELECT * FROM NCCP_Canada_Access 
						WHERE access_id='$access_id' "; 
		$query = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $dbName")) ? mysqli_query($GLOBALS["___mysqli_ston"], $sql) : false);
		
		while ($row = mysqli_fetch_assoc($query)){
			foreach ($row as $key=>$value){
				$return_array[$key] = $value;
			}
		}
	}
	
	return $return_array;
	
}


function get_geolocation($ip){
	
	if (!$ip){
		return 0;
	}
	
	$local_array = array();
	
	$json = file_get_contents("http://ip-api.com/json/$ip?fields=countryCode");
echo "<pre>".var_export($json, true)."</pre>";
	$obj = json_decode($json);
echo "<pre>".var_export($obj, true)."</pre>";
	$local_array['lat'] = $obj->lat;
	$local_array['long'] = $obj->lon;
	$local_array['city'] = $obj->city;
	$local_array['region'] = $obj->region;
	$local_array['country'] = $obj->countryCode;
		
	return $local_array;	
}

?>
