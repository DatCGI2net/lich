<html>
<body>
<!-- http://www.informatik.uni-leipzig.de/~duc/amlich/amlich-php.txt -->
<?php
require_once("lich_conv.php");
?>

<h3>&#272;&#7893;i ng&#224;y d&#432;&#417;ng ra ng&#224;y &#226;m</h3>

<?php
$date_array = getdate();
$dd = $_REQUEST['dd'];
$mm = $_REQUEST['mm'];
$yy = $_REQUEST['yy'];
if ($dd == 0) $dd = $date_array['mday'];
if ($mm == 0) $mm = $date_array['mon'];
if ($yy == 0) $yy = $date_array['year'];
$al = convertSolar2Lunar($dd, $mm, $yy, 7.0);

echo "<p><form action=\"\" method=\"POST\">\n";
echo "Ng&#224;y: <input name=\"dd\" size=2 value=\"$dd\">\n";
echo "Th&#225;ng: <input name=\"mm\" size=2 value=\"$mm\">\n";
echo "N&#259;m: <input name=\"yy\" size=4 value=\"$yy\">\n";
echo "<input type=\"submit\">\n";
echo "</form>\n";

echo "D&#432;&#417;ng l&#7883;ch: $dd/$mm/$yy => ";
$s = "&#194;m l&#7883;ch: $al[0]/$al[1]/$al[2]";
if ($al[3] == 1) $s = $s . " nhu&#7853;n";
echo "$s\n";
?>
</body>
</html>