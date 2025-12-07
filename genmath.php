<?php 
	// $formula = '\int_0^\infty e^{-x^2} dx = \frac{\sqrt{\pi}}{2}';
	if (isset($_POST['c'])) {
		$formula = $_POST['c'];

		$cmd = 'node render.js ' . escapeshellarg($formula);
		$svg = shell_exec($cmd);
		// echo $svg;

		// Save SVG
		$svgFile = time();
		file_put_contents($svgFile.".svg", $svg);

		echo $svgFile.".svg";
	}

	// $pngFile = $svgFile.".png";
	// // echo "convert $svgFile.svg $pngFile";
	// $cmd = "inkscape $svgFile --export-dpi=300 --export-type=png --export-filename=$pngFile";
	// shell_exec($cmd);

	// echo "PNG created: $pngFile";
	// <img src="1765019193.svg">
?>
