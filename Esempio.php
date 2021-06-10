<?php
require 'CodiceFiscale.php';

// Codici fiscali di fantasia da validare
$CodiciDaValidare = array('MRARSS75P14H501I', 'MRARSS82M56F205J', 'MRARSS82M56F205I');

$cf = new CodiceFiscale();

foreach ($CodiciDaValidare as $CodiceDaValidare)
{
	printf('<h5>%s</h5>', $CodiceDaValidare);

	if( $cf->ValidaCodiceFiscale($CodiceDaValidare) )
	{
		echo '<p style="color: green">Codice fiscale corretto</p>';
		printf('<p>Giorno: %s</p>', $cf->GetGiornoNascita());
		printf('<p>Mese: %s</p>',   $cf->GetMeseNascita());
		printf('<p>Anno: %s</p>',   $cf->GetAnnoNascita());
		printf('<p>Comune: %s</p>', $cf->GetComuneNascita());
		printf('<p>Sesso: %s</p>',  $cf->GetSesso());
	}
	else
	{
		printf('<p style="color: red">Errore: %s</p>', $cf->GetErrore());
	}

	echo '<hr>';
}

unset($cf);
