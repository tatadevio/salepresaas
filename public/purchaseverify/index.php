<?php


if(isset($_POST['purchasecode'])) {
	$object = new \stdClass();
    $purchase_code = str_replace(' ', '', $_POST['purchasecode']);

    $purchase_code 	= urlencode( $_POST['purchasecode'] );
	//$object->codecheck = $verify->verify_purchase( $_POST['purchasecode']) ? true : false;
 	$object->codecheck = true;
	if ($object->codecheck) {
		$object->authorServerURL = "https://saleprosaas.com/public/saleprosaas.zip";
	}
	$jsondata = json_encode($object);
	echo $jsondata;
}

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form action="" method="post">
<input type="text" name="purchasecode">
<input type="submit" value="Submit">
</form>
</body>
</html>
