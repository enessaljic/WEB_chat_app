<?php
	function provjera($korIme,$lozinka)
	{
		$kon= new mysqli("localhost","root","123456","chat");
        if($kon->konect_error)
        {
            die("Konekcija nije uspjesnja: ". $kon->connect_error);
        }

        $korIme = mysqli_real_escape_string($kon, $korIme); 
        $lozinka= mysqli_real_escape_string($kon, $lozinka); 

        $upit= "SELECT korIme, lozinka from korisnici where korIme = '$korIme' and lozinka = '$lozinka'";
        $rezultat = $kon->query($upit);
        if($rezultat->num_rows > 0)
        {
        	return true;
        }
        else return false;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Prijavljivanje</title>
	<link rel="stylesheet" type="text/css" href="prijava.css">
</head>
<body>
	<div id="kontenjer">
		<form action="" method="post">
            <p>Prijavljivanje</p><br>
            <input type="text" name="korisnickoIme" id="unos" placeholder="korisnicko ime" onkeyup="lettersOnly(this)"/><br/>
            <input type="password" name="lozinka" id="unos" placeholder="pasvord" onkeyup="letteAndNumrsOnly(this)"/><br><br>
            <input type="submit" name="prijava" id="prijava" value="Prijavi se" />
        </form>
	</div>
	<?php
		if (isset($_POST["prijava"]) && $_POST["korisnickoIme"] != ""  && $_POST['lozinka'] != '') 
		{
			if(provjera($_POST["korisnickoIme"], $_POST['lozinka']) == true)
			{
				session_start ();
				$_SESSION['korisnickoIme'] = $_POST["korisnickoIme"];
				header('location:chat.php');
			}
			else 
				echo "<script>alert('Molimo vas unesite ispravno korisnicko ime i pasvord.');</script>";
		}
	?>
	<script>
		function lettersOnly(input) 
		{
		    var regex = /[^a-z ]/gi;
		    input.value = input.value.replace(regex, "");
		}
		function letteAndNumrsOnly(input) 
		{
		    var regex = /[^a-z0-9 ]/gi;
		    input.value = input.value.replace(regex, "");
		}
	</script>
</body>
</html>