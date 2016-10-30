<?php

include 'classes/calendar.php';
require_once("lich_conv.php");
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
		<link type="text/css" rel="stylesheet" media="all" href="css/style.css?<?php echo $_GET['x'];?> " />
        <style type="text/css" media="print">
.landscape { 
    width: 100%; 
    height: 100%; 
    margin: 0% 0% 0% 0%; filter: progid:DXImageTransform.Microsoft.BasicImage(Rotation=1); 
}

</style>
	</head>
	<body>
	
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
								
									<span class="date2 <?php echo " " . $class?>">
									
								<?php
									echo $al[0];
									if($al[0] ==1)
										echo '/' . $al[1];
										
									
									
								?>
								
								</span>
								
									
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
    //echo $html;
    
    include('mpdf60/mpdf.php');
    $mpdf=new mPDF('c','A3','','',32,25,27,25,16,13); 

    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output('mpdf.pdf','I');
    
    
}
