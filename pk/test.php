<?php

include '../classes/calendar.php';
require_once("../lich_conv.php");
//$mons=array('th.1',',th.2','th.3','th.4','th.5','th.6','th.7','th.8','th.9','th.10','th.11','th.12');
$WDAYS=array('Monday' => 'THỨ HAI','Tuesday' => 'THỨ BA','Wednesday' => 'THỨ TƯ','Thursday' => 'THỨ NĂM','Friday' => 'THỨ SÁU','Saturday' => 'THỨ BẢY', 'Sunday' =>'CHỦ NHẬT');

$month = isset($_GET['m']) ? $_GET['m'] : NULL;
$year  = isset($_GET['y']) ? $_GET['y'] : date("Y")+1;
//$year=date("Y"); 
$pdf = isset($_GET['pdf']) ? $_GET['pdf'] : NULL;

if($pdf !== NULL)
    ob_start();


$pdays=array();//'1' => array(), '2' => array(), );
$pdays[1][1]='p';
$pdays[2][3]='i';
$pdays[2][14]='i';
$pdays[2][27]='i';
$pdays[3][8]='i';
$pdays[3][10]='p';
$pdays[4][30]='p';
$pdays[5][1]='p';
$pdays[6][1]='i';
$pdays[7][27]='i';
$pdays[9][2]='p';
$pdays[10][20]='i';
$pdays[11][20]='i';
$pdays[12][22]='i';
$pdays[12][24]='i';

$pdays2=array();
$pdays2[1][1]='datei';
$pdays2[1][2]='datei';
$pdays2[1][3]='datei';
$pdays2[5][5]='datei';
$pdays2[8][15]='datei';
//var_dump($pdays);
/*
$event1 = $calendar->event()->condition('timestamp', strtotime(date('F').' 21, '.date('Y')))->title('Hello All')->output('<a href="http://google.com">Going to Google</a>');
$event2 = $calendar->event()->condition('timestamp', strtotime(date('F').' 21, '.date('Y')))->title('Something Awesome')->output('<a href="http://coreyworrell.com">My Portfolio</a><br />It\'s pretty cool in there.');

$calendar->standard('today')
	->standard('prev-next')
	->standard('holidays')
	->attach($event1)
	->attach($event2);
	
	*/
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Lịch công tác</title>
		<link type="text/css" rel="stylesheet" media="all" href="css/style_v2.css?v=1.18" />
     
	</head>
	<body >
<?php 
if((!isset($pdf))){
?>	
<div class="pdf-button">

<a id="pdf" href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']; ?>?pdf=1">
<button type="button" >PDF </button>
</a>
</div>
<?php } ?>
<?php
$wc=1;

for($m=1;$m<=12;$m++):

$calendar = Calendar::factory($m, $year, array('week_start' => 1));	

$wdays = $calendar->days();
$weeks = $calendar->weeks();



?>
				
					<?php foreach ($weeks as $week): 
                        //ignore the first week if it is printed in previous month
                        //var_dump($week[0][1]);
                        
                        //list($checknumber, $checkcurrent, $checkdata) = $week[0];
                        
                        if ($week[0][1] === false && $m >1)
                            continue;
                        
                            
                    ?>
					<?php //if ($wc++ > 1) echo "<p>";
                    ?>
					<table class="calendar">
					<thead>
					<tr class="navigation">
						<th class="prev-month"></th>
						<th colspan="5" class="current-month"><?php echo $m . '/' . $year ?> </th>
						<th class="next-month"></th>
					</tr>
					
				</thead>
					<tbody>
					<tr class="weekdays">
						<?php 
						
						foreach ($wdays as $day): ?>
							<td class="<?php echo "$day "; if($day > 5) echo 'weekends';?>"><?php echo $WDAYS[$day] ?></td>
						<?php endforeach ?>
					</tr>
						<tr class="main">
							<?php 
							$i=0;
							$c=0;
							foreach ($week as $day): ?>
								<?php
								$i++;
								list($number, $current, $data) = $day;
                                
                                
                                
                                
								//var_dump($day);
								// to lunar
								$mm=$m;
								$yy=$year;
								if($current == 1){
									/*
									if($number==1  )
										$mm++;
									if($mm>12){
										$mm=1;
										$yy++;
									}
									*/
									$c++;
								}else{
									if($c < 1){
									// first columns
										$mm--;
										if($mm<1){
											$mm=12;
											$yy--;
										/*}elseif($mm==1){
											$mm=12;
											$yy--;
											
										}elseif($mm==12){
											$mm=1;
											$yy++;
											*/
										}
									}else{
										// last columns
										$mm++;
										if($mm>12){
											$mm=1;
											$yy++;
										
										}
									}
								}
								
								
								$classes = array();
								$output  = '';
								$class="";
									if($i < 6 )
										$class.=$pdays[$mm][$number];
										
								$al = convertSolar2Lunar($number, $mm, $yy, 7.0);
								if($class == ""){
									if(($al[1] == 1) && ($al[0]>=1 && $al[0] <=3))
										$class="p";
								}
								?>
								<td class="day <?php echo $class ?>">
								
									<span class="date <?php echo ' date-' , $i; echo " " , $class;?>" ><?php echo $number ;
									if($number ==1)
										echo '/' . $mm;
									//echo 'cur:' , $current;

									?></span>
									<?php
									
									$class="";
								$class.=$pdays2[$a1[1]][$a1[0]];
								?>
								
									<p class="date2 <?php echo " " . $class?>">
									
								<?php
									echo $al[0];
									if($al[0] ==1)
										echo '/' . $al[1];
										
									
									
								?>
								
								</p>
								<?php
									if($i == 1){
										echo '<p class="date3"> ĐK NGHỈ :</p>';
										echo '<span class="fix-add nhs"> NHS</span>';
										echo '<span class="fix-add nhs-1">1</span>';
										
										echo '<span class="fix-add nhs-2">2</span>';
										echo '<span class="fix-add nhs-3">3</span>';
										echo '<span class="fix-add nhs-4">4</span>';
										echo '<span class="fix-add nhs-5">5</span>';
										echo '<span class="fix-add nhs-6">6</span>';
										echo '<span class="fix-add tn">NHS THẾ NGHỈ</span>';
										echo '<span class="fix-add tn1">1</span>';
										echo '<span class="fix-add tn2">2</span>';
										echo '<span class="fix-add tn3">3</span>';
										echo '<span class="fix-add tn4">4</span>';
										echo '<span class="fix-add tn5">5</span>';
										echo '<span class="fix-add tn6">6</span>';
										echo '<span class="fix-add k">KHÁC</span>';
										echo '<span class="fix-add hln">HL NGHỈ</span>';
									}
									elseif($i == 6 or $i == 7){
										echo '<span class="fix-add bs">BS CHO THUỐC</span>';
										echo '<span class="fix-add nhs-small">NHS SALL</span>';
									}
								?>
								
									
									<div class="day-content">
										<?php echo $output ?>
									</div>
							
								</td>
							<?php endforeach ?>
						</tr>
						</tbody>
						</table>
					<?php endforeach ?>
				
			
		
<?php
endfor;
?>
		
	</body>
	
</html>


<?php 

if($pdf !== NULL){
    $html = ob_get_contents(); 
	//file_put_contents('filer.txt',$html);	 /usr/bin/xvfb-run /usr/local/bin/wkhtmltopdf -O Landscape -s A3 http://lich.cgito.net/lich/sa/ sa.pdf
  include('mpdf60/mpdf.php');
	ob_clean();
	$cmd = '/usr/bin/xvfb-run /usr/local/bin/wkhtmltopdf -O Landscape -s A3 http://lich.cgito.net/lich/sa/ sa.pdf';

	exec($cmd);
 /*   $mpdf=new mPDF('utf-8','A3','','',32,25,27,25,16,13); 
	$mpdf->AddPage('L');
	$mpdf->autoScriptToLang = true;
	 
	$mpdf->autoVietnamese = true;
	
	$mpdf->autoLangToFont = true;
    
	$mpdf->list_indent_first_level = 0;

	$stylesheet = file_get_contents('css/style_v2.css');
	file_put_contents('stylesheet.css',$stylesheet);	
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html, 2);
   
    $mpdf->Output('mpdf.pdf','I');  
 
 */  
   
}
