<?php
	function enkripcija($string) //funkcija za enkripciju poruke
	{
	    $izlaz = false;
	 
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'moj kljuc';
	    $secret_iv = 'Moj secret iv';
	 
	    $key = hash('sha256', $secret_key);

	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    $izlaz = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	    $izlaz = base64_encode($izlaz);
	    
	    return $izlaz;
	}

	if(isset($_POST["posalji"]) && $_POST["poruka"] != "") //kreira se sadrzaj promjenjljive poruka gdje se podaci o korisniku, unijetoj
	{			 											//poruci i vremenu kada je poruka poslana cuvaju u posebnim tagovima
		$poruka = "<poruka>
					<korisnik>".$_SESSION['korisnickoIme']."</korisnik> 
					<text>".$_POST['poruka']."</text>
					<vrijeme>".date('g:i')."</vrijeme>
					</poruka>";
		$kriptovanaPoruka = enkripcija($poruka)."\n"; //poziv funkcije za enkripciju i zapisivanje kriptovane poruke u fajlu
		$fajl = fopen('poruke.xml', 'a');
		fwrite($fajl, $kriptovanaPoruka);
		fclose($fajl);
		echo '<script> autoSkrol(); </script>';
	}
?>