<?php
	function create_pdf_and_show($link){
		ob_clean();
	$file='pdf.pdf';
    $pdf_dir = $pdf = dirname(__FILE__) . '/tmp/';
    if( is_dir($pdf_dir) === false && mkdir($pdf_dir) === false)
    {
         die( "Could not create $pdf_dir");
    }

	$pdf = $pdf_dir . $file;
	//echo $link;exit();

	$cmd = sprintf("/usr/bin/xvfb-run /usr/bin/wkhtmltopdf -O Landscape -s A4 %s %s", $link, $pdf);
	exec($cmd);
    
    header('Content-type: application/pdf');
	header(sprintf('Content-Disposition: inline; filename="%s"', $file));
	@readfile($pdf);
	}

?>
