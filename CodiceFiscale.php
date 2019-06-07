<?php
/**
 * Classe per la validazione dei Codici fiscali
 * @author SimoneNigro
 *
 */
class CodiceFiscale 
{
	// Espressione regolare per il controllo formale del codice fiscale
	const REGEX_CODICEFISCALE = '/^[a-z]{6}[0-9]{2}[a-z][0-9]{2}[a-z][0-9]{3}[a-z]$/i';
	
	// Carattere utilizzato per le donne
	const CHAR_FEMMINA = 'F';
	
	// Carattere utilizzato per gli uomini
	const CHAR_MASCHIO = 'M';
	
	
	/**
	* Validità del codice fiscale
	* @var bool
	*/
	private $isValido = false;
 
	/**
	* Sesso del codice fiscale
	* @var string
	*/
	private $Sesso = null;
 
	/**
	* Comune di nascita del codice fiscale
	* @var integer
	*/
	private $ComuneNascita = null;
 
	/**
	* Giorno di nascita del codice fiscale
	* @var integer
	*/
	private $GiornoNascita = null;
 
	/**
	* Mese di nascita del codice fiscale
	* @var integer
	*/
	private $MeseNascita = null;
 
	/**
	* Anno di nascita del codice fiscale
	* @var integer
	*/
	private $AnnoNascita = null;
 
	/**
	* Primo errore generato nel processo di validazione
	* @var string
	*/
	private $Errore = null;
 
	/**
	* Lista sostituzioni per omocodia
	* @var array
	*/
	private $ListaDecOmocodia = array('A' => '!', 'B' => '!', 'C' => '!', 'D' => '!', 'E' => '!', 'F' => '!', 'G' => '!', 'H' => '!', 'I' => '!', 'J' => '!', 'K' => '!', 'L' => '0', 'M' => '1', 'N' => '2', 'O' => '!', 'P' => '3', 'Q' => '4', 'R' => '5', 'S' => '6', 'T' => '7', 'U' => '8', 'V' => '9', 'W' => '!', 'X' => '!', 'Y' => '!', 'Z' => '!', );
 
	/**
	* Posizioni caratteri interessati ad alterazione di codifica in caso di omocodia
	* @var array
	*/
	private $ListaSostOmocodia = array(6,7,9,10,12,13,14);
 
	/**
	* Lista peso caratteri PARI
	* @var array
	*/
	private $ListaCaratteriPari = array('0' => 0 , '1' => 1 , '2' => 2 , '3' => 3 , '4' => 4 , '5' => 5 , '6' => 6 , '7' => 7 , '8' => 8 , '9' => 9 , 'A' => 0 , 'B' => 1 , 'C' => 2 , 'D' => 3 , 'E' => 4 , 'F' => 5 , 'G' => 6 , 'H' => 7 , 'I' => 8 , 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25);
 
	/**
	* Lista peso caratteri DISPARI
	* @var unknown_type
	*/
	private $ListaCaratteriDispari = array('0' => 1 , '1' => 0 , '2' => 5 , '3' => 7 , '4' => 9 , '5' => 13, '6' => 15, '7' => 17, '8' => 19, '9' => 21, 'A' => 1 , 'B' => 0 , 'C' => 5 , 'D' => 7 , 'E' => 9 , 'F' => 13, 'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21, 'K' => 2 , 'L' => 4 , 'M' => 18, 'N' => 20, 'O' => 11, 'P' => 3 , 'Q' => 6 , 'R' => 8 , 'S' => 12, 'T' => 14, 'U' => 16, 'V' => 10, 'W' => 22, 'X' => 25, 'Y' => 24, 'Z' => 23  );
 
	/**
	* Lista calcolo codice CONTOLLO (carattere 16)
	* @var array
	*/
	private $ListaCodiceControllo = array( 0 => 'A',  1 => 'B',  2 => 'C',  3 => 'D',  4 => 'E',  5 => 'F',  6 => 'G',  7 => 'H',  8 => 'I',  9 => 'J', 10 => 'K', 11 => 'L', 12 => 'M', 13 => 'N', 14 => 'O', 15 => 'P', 16 => 'Q', 17 => 'R', 18 => 'S', 19 => 'T', 20 => 'U', 21 => 'V', 22 => 'W', 23 => 'X', 24 => 'Y', 25 => 'Z');
 
	/**
	*  Array per il calcolo del mese
	* @var array
	*/
	private $ListaDecMesi = array('A' => '01', 'B' => '02', 'C' => '03', 'D' => '04', 'E' => '05', 'H' => '06', 'L' => '07', 'M' => '08', 'P' => '09', 'R' => '10', 'S' => '11', 'T' => '12');
 
	/**
	* Lista messaggi di Errore
	* @var unknown_type
	*/
	private $ListaErrori = array(0 => 'Codice da analizzare assente', 1 => 'Lunghezza codice da analizzare non corretta', 2 => 'Il codice da analizzare contiene caratteri non corretti', 3 => 'Carattere non valido in decodifica omocodia', 4 => 'Codice fiscale non corretto');
 
	
	/**
	* Costruttore
	* @return CodiceFiscale
	*/
	public function __construct() 
	{
 	
	}
 
	
	/**
	 * Distruttore
	 * @return void
	 */
	public function __destruct()
	{
		
	}
	
	
	/**
	 * Getter isValido
	 * @return boolean
	 */
	public function GetIsValido()
	{
		return $this->isValido;
	}
	
	
	/**
	 * Getter Errore
	 * @return string
	 */
	public function GetErrore()
	{
		return $this->Errore;
	}
	
	
	/**
	 * Getter Sesso
	 * @return string
	 */
	public function GetSesso()
	{
		return $this->Sesso;
	}
	
	
	/**
	 * Getter ComuneNascita
	 * @return integer
	 */
	public function GetComuneNascita()
	{
		return $this->ComuneNascita;
	}
	
	
	/**
	 * Getter AnnoNascita
	 * @return integer
	 */
	public function GetAnnoNascita()
	{
		return $this->AnnoNascita;
	}
	
	
	/**
	 * Getter MeseNascita
	 * @return integer
	 */
	public function GetMeseNascita()
	{
		return $this->MeseNascita;
	}
	
	
	/**
	 * Getter GiornoNascita
	 * @return integer
	 */
	public function GetGiornoNascita()
	{
		return $this->GiornoNascita;
	}
 
	
	/**
	* Valida Codice Fiscale
    * @param string $CodiceFiscale
    * @return boolean
    */
	public function ValidaCodiceFiscale($CodiceFiscale)
	{
 		$this->ResettaProprieta();

		try
		{
			// Verifico che il Codice Fiscale sia valorizzato
			if ( empty($CodiceFiscale) ) 
				$this->RaiseException(0);
			
			// Verifico che la lunghezza sia almeno di 16 caratteri
			if ( strlen($CodiceFiscale) !== 16) 
				$this->RaiseException(1);

			// Controllo che la forma sia corretta
			if( !preg_match(self::REGEX_CODICEFISCALE, $CodiceFiscale) ) 
				$this->RaiseException(2);

			// Converto in maiuscolo
			$CodiceFiscale = strtoupper($CodiceFiscale);
				
			// Converto la stringa in array
			$CodiceFiscaleArray = str_split($CodiceFiscale);
			
			
			// Verifica la correttezza delle alterazioni per omocodia
			for ($i = 0; $i < count($this->ListaSostOmocodia); $i++)
			{
				if (!is_numeric($CodiceFiscaleArray[$this->ListaSostOmocodia[$i]]))
				{
					if ($this->ListaDecOmocodia[$CodiceFiscaleArray[$this->ListaSostOmocodia[$i]]]==='!') 
						$this->RaiseException(3);
				}
			}			

			$Pari    = 0;
			$Dispari = $this->ListaCaratteriDispari[$CodiceFiscaleArray[14]];
			
			// Giro sui primi 14 elementi a passo due
			for ($i = 0; $i < 13; $i+=2)
			{
				$Dispari = $Dispari + $this->ListaCaratteriDispari[$CodiceFiscaleArray[$i]];
				$Pari    = $Pari    + $this->ListaCaratteriPari[$CodiceFiscaleArray[$i+1]];
			}
			
			// Verifica congruenza dei valori calcolati sui primi 15 caratteri, con il codice di controllo (carattere 16)
			if (!($this->ListaCodiceControllo[($Pari+$Dispari) % 26]  === $CodiceFiscaleArray[15]))
				$this->RaiseException(4);
			
			// Sostituzione per risolvere eventuali omocodie
			for ($i = 0; $i < count($this->ListaSostOmocodia); $i++)
			{
				if (!is_numeric($CodiceFiscaleArray[$this->ListaSostOmocodia[$i]]))
					$CodiceFiscaleArray[$this->ListaSostOmocodia[$i]] = $this->ListaDecOmocodia[$CodiceFiscaleArray[$this->ListaSostOmocodia[$i]]];
			}
			
			// Converto l'array in stringa
			$CodiceFiscaleAdattato = implode($CodiceFiscaleArray);
			
			// Estraggo i dati
			$this->Sesso         = ((int)(substr($CodiceFiscaleAdattato,9,2) > 40) ? self::CHAR_FEMMINA : self::CHAR_MASCHIO);
			$this->ComuneNascita = substr($CodiceFiscaleAdattato, 11, 4);
			$this->AnnoNascita   = substr($CodiceFiscaleAdattato, 6,  2);
			$this->GiornoNascita = substr($CodiceFiscaleAdattato, 9,  2);
			$this->MeseNascita   = $this->ListaDecMesi[substr($CodiceFiscaleAdattato,8,1)];

			// Recupero giorno di nascita se Sesso=F
			if($this->Sesso == self::CHAR_FEMMINA) 
			{
				$this->GiornoNascita = $this->GiornoNascita - 40;
				
				if (strlen($this->GiornoNascita)===1)
					$this->GiornoNascita = '0'.$this->GiornoNascita;
			}
			
			// Controlli teminati
			$this->isValido = true;
			$this->Errore   = null;
		}
		catch(\Exception $e)
		{
			$this->Errore   = $e->getMessage();
			$this->isValido = false;
		}
		
		return $this->isValido;
	}
 
	
	/**
	 * Resetta le proprietà della classe
	 * @return void
	 */
	private function ResettaProprieta()
	{
		$this->isValido      = false;
		$this->Sesso         = null;
		$this->ComuneNascita = null;
		$this->GiornoNascita = null;
		$this->MeseNascita   = null;
		$this->AnnoNascita   = null;
		$this->Errore        = null;
	}
	
	
	/**
	 * Alza un eccezione
	 * @param integer $ErrorNum
	 * @throws \Exception
	 * @return void
	 */
	private function RaiseException($ErrorNum)
	{
		$ErrMessage = isset($this->ListaErrori[$ErrorNum]) ? $this->ListaErrori[$ErrorNum] : 'Eccezione non gestita';
	
		throw new \Exception($ErrMessage, $ErrorNum);
	}
}

