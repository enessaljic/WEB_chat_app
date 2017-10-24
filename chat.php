<?php
	session_start();
	if(isset($_GET['odjava'])) //hvata iz linka 'odjava' i pritom unistava sesiju i korisnika vodi na stranicu za prijavu
	{
		session_destroy();
		header('location:index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>chat</title>
	<link rel="stylesheet" type="text/css" href="chat.css">
</head>
<body contextmenu = "false">
	<?php 
        if (! isset ( $_SESSION['korisnickoIme'])) //u slucaju da korisnik uspe da preskoci index.php, tj. sranicu za prijavu i pristupi stranici chat.php 
        {										   //sve u tagu <body> nece bit prikazano
            header('location:index.php');
        }
    ?>
	<div id="kontenjer">
		<div id="zaglavlje">
			<table>
				<tr>
					<td id="korisnickoIme"><?php echo "<p>".$_SESSION['korisnickoIme']."</p>";?></td>
					<td id="odj" name="odj"><input type="submit" id="slikaOdjava" onclick="odjava()"/></td>
				</tr>
			</table>
		</div>
		<div id="polje"></div>
		<form action="" method="post">
			<input type="text" name="poruka" id="poruka"/>
			<input type="submit" name="posalji" id="posalji" onclick="autoSkrol()" />
		</form>
	</div>
	<?php
		include 'enkripcija.php';
	?>
</body>
<script type="text/javascript">      
	//funkcija za odjavu
	function odjava()
	{
		var b =  confirm("Da li ste sigurni da zelite da napustite razgovor?");
		if(b == true)
			window.location = 'chat.php?odjava=true'; //postavlja 'odjava' u linku koju hvata php get metoda
	}
	//auto skrol funkcija poziva php fajl za dekripciju poruka
 	function autoSkrol()
    {    //pristup php fajlu u kojem se nalazi kod za dekripciju 
     	$.ajax(
        {
            url: "dekripcija.php",
            cache: false,
            complete: function(p)
         	{    
         		document.getElementById("polje").innerHTML = p.responseText; //i stanpa rezultat dekripcije u polju predvidjenom za poruke
 	 			var polje = document.getElementById("polje"); //
				polje.scrollTop = polje.scrollHeight;//automatski skrol do dna polja
			},
		});    
    }
  	setInterval(autoSkrol, 1000);
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
</html>