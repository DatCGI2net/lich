<?php
	function create_pdf_and_show($link){
		ob_clean();
	$file='pdf.pdf';

	$pdf = dirname(__FILE__) . '/tmp/' . $file;
	#echo $pdf;exit();

	$cmd = sprintf("/usr/bin/xvfb-run /usr/bin/wkhtmltopdf -O Landscape -s A3 %s %s", $link, $pdf);
	exec($cmd);	
    	header('Content-type: application/pdf');
	header(sprintf('Content-Disposition: inline; filename="%s"', $file));
	@readfile($pdf);
	}

?>
