<?php
	function create_pdf_and_show($link){
		ob_clean();
	$cmd = "/usr/bin/xvfb-run /usr/local/bin/wkhtmltopdf -O Landscape -s A3 $link pdf.pdf";
	exec($cmd);	
    $file='pdf.pdf';
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="pdf.pdf"');
	@readfile($file);
	}

?>