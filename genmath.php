<?php 
	ini_set('display_errors','off');
    require '../vendor_sekolak/autoload.php';
	// function OpenCon()
	// {
	// 	$dbhost = "157.230.39.190";
	// 	$dbuser = "sekolak";
	// 	$dbpass = "SierraButane@951#8*";
	// 	$db = "math";
	// 	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);

	// 	return $conn;
	// }

	define("DO_KEY", 'DO00GRF2EBJGXYHQ39ZT');
	define("DO_SEC", 'sq81SABcmIl+INUVQuesgCbxeHbszT6KzJSuwbr5JoU');
    define("DO_IMG_PATH", 'https://fortisid.sgp1.digitaloceanspaces.com/sekolak/math/');
	define("DO_IMG_HEAD", 'math');

	if (isset($_POST['c'])) {
	    $formula = $_POST['c'];
		// $formula = '\int_0^\infty e^{-x^2} dx = \frac{\sqrt{\pi}}{2}';
	    $formula = html_entity_decode($_POST['c'], ENT_QUOTES | ENT_HTML5);

	    $cmd = 'node render.js ' . escapeshellarg($formula);
	    $svg = shell_exec($cmd);

	    if ($svg) {
	        $fileName = time() . '_' . uniqid() . '_' . bin2hex(random_bytes(2));
	        $svgFile = $fileName . ".svg";
			$pngFile = $fileName . ".png";
			file_put_contents($svgFile, $svg);

			// -a untuk menjaga aspect ratio, -w untuk menentukan lebar (opsional)
			// install dulu
			// sudo apt-get update
			// sudo apt-get install librsvg2-bin
			$cmd = "rsvg-convert -a -b white " . escapeshellarg($svgFile) . " -o " . escapeshellarg($pngFile);
			// $cmd = "rsvg-convert -a " . escapeshellarg($svgFile) . " -o " . escapeshellarg($pngFile);
			shell_exec($cmd);

			$s3 = new Aws\S3\S3Client([
	            'region'  => 'ap-southeast-1',
	            'version' => 'latest',
	            'endpoint' => 'https://sgp1.digitaloceanspaces.com',
	            'credentials' => [
	                'key'    => DO_KEY,
	                'secret' => DO_SEC,
	            ]
	        ]);

	        // $conn = OpenCon();
    		// $sql = "INSERT INTO generate (clean,source) VALUES (?,?)";
	        // $stmt = $conn->prepare($sql);
	        // $stmt->bind_param("ss", $formula,$pngFile); 
	        // $stmt->execute();
	        // $stmt->close();

	        $result = $s3->putObject([
	            'Bucket' => 'fortisid',
	            'Key'    => 'sekolak/'.DO_IMG_HEAD.'/'.$pngFile,
	            'Body'   => 'this is the body!',
	            'SourceFile' => $pngFile,
	            "ACL" => 'public-read'
	        ]);

			echo $pngFile;
	    } else {
	        echo "Error: Gagal merender formula.";
	    }
	}

	// $pngFile = $svgFile.".png";
	// // echo "convert $svgFile.svg $pngFile";
	// $cmd = "inkscape $svgFile --export-dpi=300 --export-type=png --export-filename=$pngFile";
	// shell_exec($cmd);

	// echo "PNG created: $pngFile";
	// <img src="1765019193.svg">
?>
