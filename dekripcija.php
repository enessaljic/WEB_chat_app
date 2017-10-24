<?php 
    session_start();
    function dekript($string) //funkcija za dekripciju texta
    {
        $izlaz = false;
     
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'moj kljuc';
        $secret_iv = 'Moj secret iv';
     
        $key = hash('sha256', $secret_key);
        
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $izlaz = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
       
        return $izlaz;
    }
    $citanje = fopen ( "poruke.xml", "r" ); //selekcija fajla za citanje
    $poruke="<poruke>"; //postavljamo na prvom mjestu xml tag <poruke> koji nam u ovom slucaju sluzi kao root tag
    $p = null; //pomocna promjenjljiva
    while(!feof($citanje)) 
    {
        $poruka = fgets ($citanje); //cita tekst red po red iz fajla
        $p .= dekript($poruka); // Poziva funkciju za dekripciju poreuke i salje red po red na prevodjenje. 
    }                           //Prevedenu poruku konkatenizuje na sadrzaj pomocne promjenjljive $p
    $poruke .= $p; //Nakon iscitavanja i prevodjenja cijelog fajla konpletan sadrzaj se konkatenizuje sa sadrzajem promenljive $poruke
    $poruke .= "</poruke>"; //na sta se jos i dodaje zatvoreni root tag </poruke> kako bi konplektan sadrzaj zadovoljio xml pravila
    $izlaz=null;
    $xml=simplexml_load_string($poruke);
    foreach ($xml as $por) //u ovoj petlji ce proc kroz cio sadrzaj promjenjljive $poruke uzimajuci podatke po dagovima
    {
        if($por->korisnik == $_SESSION['korisnickoIme']) //ako je vrijednos predstavljena tagom <korisnik> jednaka korisnickom imenu prijavljenog korisnika 
        {                                               //on ce se smatrati domacinom konverzacije i njegove poruke ce se ispisivati sa desne strane (css)
            $izlaz .= "<div id='tekstPoruke1'><div id='korisnik'>".$por->korisnik.":
            <br><b id='vrijeme'>".$por->vrijeme."</b></div> <div id='text'>".$por->text.
            "</div></div><br/>";
        }
        else //ako nije onda se smatra sagovornikom i poruke ce bit ispisane sa lijeve strane (css)
        {
            $izlaz .= "<div id='tekstPoruke'><div id='korisnik'>".$por->korisnik.":
            <br><b id='vrijeme'>".$por->vrijeme."</b></div> <div id='text'>".$por->text.
            "</div></div><br/>";
        }
    }
    echo $izlaz;   
    fclose ( $citanje );
?>