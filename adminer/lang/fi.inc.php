<?php
$translations = array(
	// label for database system selection (MySQL, SQLite, ...)
	'System' => 'Järjestelmä',
	'Server' => 'Palvelin',
	'Username' => 'Käyttäjänimi',
	'Password' => 'Salasana',
	'Permanent login' => 'Haluan pysyä kirjautuneena',
	'Login' => 'Kirjaudu',
	'Logout' => 'Kirjaudu ulos',
	'Logged as: %s' => 'Olet kirjautunut käyttäjänä: %s',
	'Logout successful.' => 'Uloskirjautuminen onnistui.',
	'Invalid credentials.' => 'Virheelliset kirjautumistiedot.',
	'Too many unsuccessful logins, try again in %d minute(s).' => array('Liian monta epäonnistunutta sisäänkirjautumisyritystä, kokeile uudestaan %d minuutin kuluttua.', 'Liian monta epäonnistunutta sisäänkirjautumisyritystä, kokeile uudestaan %d minuutin kuluttua.'),
	'Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.' => 'Master-salasana ei ole enää voimassa. <a href="https://www.adminer.org/en/extension/"%s>Toteuta</a> %s-metodi sen tekemiseksi pysyväksi.',
	'Language' => 'Kieli',
	'Invalid CSRF token. Send the form again.' => 'Virheellinen CSRF-vastamerkki. Lähetä lomake uudelleen.',
	'If you did not send this request from Adminer then close this page.' => 'Jollet lähettänyt tämä pyyntö Adminerista, sulje tämä sivu.',
	'No extension' => 'Ei laajennusta',
	'None of the supported PHP extensions (%s) are available.' => 'Mitään tuetuista PHP-laajennuksista (%s) ei ole käytettävissä.',
	'Session support must be enabled.' => 'Istuntotuki on oltava päällä.',
	'Session expired, please login again.' => 'Istunto vanhentunut, kirjaudu uudelleen.',
	'%s version: %s through PHP extension %s' => '%s versio: %s PHP-laajennuksella %s',
	'Refresh' => 'Virkistä',
	
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	
	'Privileges' => 'Oikeudet',
	'Create user' => 'Luo käyttäjä',
	'User has been dropped.' => 'Käyttäjä poistettiin.',
	'User has been altered.' => 'Käyttäjää muutettiin.',
	'User has been created.' => 'Käyttäjä luotiin.',
	'Hashed' => 'Hashed',
	'Column' => 'Sarake',
	'Routine' => 'Rutiini',
	'Grant' => 'Myönnä',
	'Revoke' => 'Kiellä',
	
	'Process list' => 'Prosessilista',
	'%d process(es) have been killed.' => array('%d prosessi lopetettu.', '%d prosessia lopetettu..'),
	'Kill' => 'Lopeta',
	
	'Variables' => 'Muuttujat',
	'Status' => 'Tila',
	
	'SQL command' => 'SQL-komento',
	'%d query(s) executed OK.' => array('%d kysely onnistui.', '%d kyselyä onnistui.'),
	'Query executed OK, %d row(s) affected.' => array('Kysely onnistui, kohdistui %d riviin.', 'Kysely onnistui, kohdistui %d riviin.'),
	'No commands to execute.' => 'Ei komentoja suoritettavana.',
	'Error in query' => 'Virhe kyselyssä',
	'Execute' => 'Suorita',
	'Stop on error' => 'Pysähdy virheeseen',
	'Show only errors' => 'Näytä vain virheet',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Historia',
	'Clear' => 'Tyhjennä',
	'Edit all' => 'Muokkaa kaikkia',
	
	'File upload' => 'Tiedoston lataus palvelimelle',
	'From server' => 'Verkkopalvelimella Adminer-kansiossa oleva tiedosto',
	'Webserver file %s' => 'Verkkopalvelintiedosto %s',
	'Run file' => 'Suorita tämä',
	'File does not exist.' => 'Tiedostoa ei ole.',
	'File uploads are disabled.' => 'Tiedostojen lataaminen palvelimelle on estetty.',
	'Unable to upload a file.' => 'Tiedostoa ei voida ladata palvelimelle.',
	'Maximum allowed file size is %sB.' => 'Suurin sallittu tiedostokoko on %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Liian suuri POST-datamäärä. Pienennä dataa tai kasvata arvoa %s konfigurointitiedostossa.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Voit ladata suuren SQL-tiedoston FTP:n kautta ja tuoda sen sitten palvelimelta.',
	'You are offline.' => 'Olet offline-tilassa.',
	
	'Export' => 'Vienti',
	'Output' => 'Tulos',
	'open' => 'avaa',
	'save' => 'tallenna',
	'Saving' => 'Tallennetaan',
	'Format' => 'Muoto',
	'Data' => 'Data',
	
	'Database' => 'Tietokanta',
	'database' => 'tietokanta',
	'Use' => 'Käytä',
	'Select database' => 'Valitse tietokanta',
	'Invalid database.' => 'Tietokanta ei kelpaa.',
	'Database has been dropped.' => 'Tietokanta on poistettu.',
	'Databases have been dropped.' => 'Tietokannat on poistettu.',
	'Database has been created.' => 'Tietokanta on luotu.',
	'Database has been renamed.' => 'Tietokanta on nimetty uudelleen.',
	'Database has been altered.' => 'Tietokantaa on muutettu.',
	'Alter database' => 'Muuta tietokantaa',
	'Create database' => 'Luo tietokanta',
	'Database schema' => 'Tietokantakaava',
	
	// link to current database schema layout
	'Permanent link' => 'Pysyvä linkki',
	
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	'Engine' => 'Moottori',
	'Collation' => 'Kollaatio',
	'Data Length' => 'Datan pituus',
	'Index Length' => 'Indeksin pituus',
	'Data Free' => 'Vapaa tila',
	'Rows' => 'Riviä',
	'%d in total' => '%d kaikkiaan',
	'Analyze' => 'Analysoi',
	'Optimize' => 'Optimoi',
	'Vacuum' => 'Siivoa',
	'Check' => 'Tarkista',
	'Repair' => 'Korjaa',
	'Truncate' => 'Tyhjennä',
	'Tables have been truncated.' => 'Taulujen sisältö on tyhjennetty.',
	'Move to other database' => 'Siirrä toiseen tietokantaan',
	'Move' => 'Siirrä',
	'Tables have been moved.' => 'Taulut on siirretty.',
	'Copy' => 'Kopioi',
	'Tables have been copied.' => 'Taulut on kopioitu.',
	
	'Routines' => 'Rutiinit',
	'Routine has been called, %d row(s) affected.' => array('Rutiini kutsuttu, kohdistui %d riviin.', 'Rutiini kutsuttu, kohdistui %d riviin.'),
	'Call' => 'Kutsua',
	'Parameter name' => 'Parametrin nimi',
	'Create procedure' => 'Luo proseduuri',
	'Create function' => 'Luo funktio',
	'Routine has been dropped.' => 'Rutiini on poistettu.',
	'Routine has been altered.' => 'Rutiinia on muutettu.',
	'Routine has been created.' => 'Rutiini on luotu.',
	'Alter function' => 'Muuta funktiota',
	'Alter procedure' => 'Muuta proseduuria',
	'Return type' => 'Palautustyyppi',
	
	'Events' => 'Tapahtumat',
	'Event has been dropped.' => 'Tapahtuma on poistettu.',
	'Event has been altered.' => 'Tapahtumaa on muutettu.',
	'Event has been created.' => 'Tapahtuma on luotu.',
	'Alter event' => 'Muuta tapahtumaa',
	'Create event' => 'Luo tapahtuma',
	'At given time' => 'Tiettynä aikana',
	'Every' => 'Joka',
	'Schedule' => 'Aikataulu',
	'Start' => 'Aloitus',
	'End' => 'Lopetus',
	'On completion preserve' => 'Säilytä, kun valmis',
	
	'Tables' => 'Taulut',
	'Tables and views' => 'Taulut ja näkymät',
	'Table' => 'Taulu',
	'No tables.' => 'Ei tauluja.',
	'Alter table' => 'Muuta taulua',
	'Create table' => 'Luo taulu',
	'Table has been dropped.' => 'Taulu on poistettu.',
	'Tables have been dropped.' => 'Tauluja on poistettu.',
	'Tables have been optimized.' => 'Taulut on optimoitu.',
	'Table has been altered.' => 'Taulua on muutettu.',
	'Table has been created.' => 'Taulu on luotu.',
	'Table name' => 'Taulun nimi',
	'Show structure' => 'Näytä rakenne',
	'engine' => 'moottori',
	'collation' => 'kollaatio',
	'Column name' => 'Sarakkeen nimi',
	'Type' => 'Tyyppi',
	'Length' => 'Pituus',
	'Auto Increment' => 'Automaattinen lisäys',
	'Options' => 'Asetukset',
	'Comment' => 'Kommentit',
	'Default value' => 'Oletusarvo',
	'Default values' => 'Oletusarvot',
	'Drop' => 'Poista',
	'Are you sure?' => 'Oletko varma?',
	'Size' => 'Koko',
	'Compute' => 'Laske',
	'Move up' => 'Siirrä ylös',
	'Move down' => 'Siirrä alas',
	'Remove' => 'Poista',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Kenttien sallittu enimmäismäärä ylitetty. Kasvata arvoa %s.',
	
	'Partition by' => 'Osioi arvolla',
	'Partitions' => 'Osiot',
	'Partition name' => 'Osion nimi',
	'Values' => 'Arvot',
	
	'View' => 'Näkymä',
	'Materialized view' => 'Materialisoitunut näkymä',
	'View has been dropped.' => 'Näkymä on poistettu.',
	'View has been altered.' => 'Näkymää on muutettu.',
	'View has been created.' => 'Näkymä on luotu.',
	'Alter view' => 'Muuta näkymää',
	'Create view' => 'Luo näkymä',
	
	'Indexes' => 'Indeksit',
	'Indexes have been altered.' => 'Indeksejä on muutettu.',
	'Alter indexes' => 'Muuta indeksejä',
	'Add next' => 'Lisää seuraava',
	'Index Type' => 'Indeksityyppi',
	'Column (length)' => 'Sarake (pituus)',
	
	'Foreign keys' => 'Vieraat avaimet',
	'Foreign key' => 'Vieras avain',
	'Foreign key has been dropped.' => 'Vieras avain on poistettu.',
	'Foreign key has been altered.' => 'Vierasta avainta on muutettu.',
	'Foreign key has been created.' => 'Vieras avain on luotu.',
	'Target table' => 'Kohdetaulu',
	'Change' => 'Muuta',
	'Source' => 'Lähde',
	'Target' => 'Kohde',
	'Add column' => 'Lisää sarake',
	'Alter' => 'Muuta',
	'Add foreign key' => 'Lisää vieras avain',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Lähde- ja kohdesarakkeiden tulee olla samaa tietotyyppiä, kohdesarakkeisiin tulee olla indeksi ja dataa, johon viitataan, täytyy olla.',
	
	'Triggers' => 'Liipaisimet',
	'Add trigger' => 'Lisää liipaisin',
	'Trigger has been dropped.' => 'Liipaisin on poistettu.',
	'Trigger has been altered.' => 'Liipaisinta on muutettu.',
	'Trigger has been created.' => 'Liipaisin on luotu.',
	'Alter trigger' => 'Muuta liipaisinta',
	'Create trigger' => 'Luo liipaisin',
	'Time' => 'Aika',
	'Event' => 'Tapahtuma',
	'Name' => 'Nimi',
	
	'select' => 'valitse',
	'Select' => 'Valitse',
	'Select data' => 'Valitse data',
	'Functions' => 'Funktiot',
	'Aggregation' => 'Aggregaatiot',
	'Search' => 'Hae',
	'anywhere' => 'kaikkialta',
	'Search data in tables' => 'Hae dataa tauluista',
	'Sort' => 'Lajittele',
	'descending' => 'alenevasti',
	'Limit' => 'Raja',
	'Limit rows' => 'Rajoita rivimäärää',
	'Text length' => 'Tekstin pituus',
	'Action' => 'Toimenpide',
	'Full table scan' => 'Koko taulun läpikäynti',
	'Unable to select the table' => 'Taulua ei voitu valita',
	'No rows.' => 'Ei rivejä.',
	'%d / ' => '%d / ',
	'%d row(s)' => array('%d rivi', '%d riviä'),
	'Page' => 'Sivu',
	'last' => 'viimeinen',
	'Load more data' => 'Lataa lisää dataa',
	'Loading' => 'Ladataan',
	'Whole result' => 'Koko tulos',
	'%d byte(s)' => array('%d tavu', '%d tavua'),
	
	'Import' => 'Tuonti',
	'%d row(s) have been imported.' => array('%d rivi tuotiin.', '%d riviä tuotiin.'),
	'File must be in UTF-8 encoding.' => 'Tiedoston täytyy olla UTF-8-muodossa.',
	
	// in-place editing in select
	'Modify' => 'Muuta',
	'Ctrl+click on a value to modify it.' => 'Ctrl+napsauta arvoa muuttaaksesi.',
	'Use edit link to modify this value.' => 'Käytä muokkaa-linkkiä muuttaaksesi tätä arvoa.',
	
	// %s can contain auto-increment value
	'Item%s has been inserted.' => 'Tietue%s lisättiin.',
	'Item has been deleted.' => 'Tietue poistettiin.',
	'Item has been updated.' => 'Tietue päivitettiin.',
	'%d item(s) have been affected.' => array('Kohdistui %d tietueeseen.', 'Kohdistui %d tietueeseen.'),
	'New item' => 'Uusi tietue',
	'original' => 'alkuperäinen',
	// label for value '' in enum data type
	'empty' => 'tyhjä',
	'edit' => 'muokkaa',
	'Edit' => 'Muokkaa',
	'Insert' => 'Lisää',
	'Save' => 'Tallenna',
	'Save and continue edit' => 'Tallenna ja jatka muokkaamista',
	'Save and insert next' => 'Tallenna ja lisää seuraava',
	'Selected' => 'Valitut',
	'Clone' => 'Kloonaa',
	'Delete' => 'Poista',
	'You have no privileges to update this table.' => 'Sinulla ei ole oikeutta päivittää tätä taulua.',
	
	'E-mail' => 'S-posti',
	'From' => 'Lähettäjä',
	'Subject' => 'Aihe',
	'Attachments' => 'Liitteet',
	'Send' => 'Lähetä',
	'%d e-mail(s) have been sent.' => array('% sähköpostiviestiä lähetetty.', '% sähköpostiviestiä lähetetty.'),
	
	// data type descriptions
	'Numbers' => 'Numerot',
	'Date and time' => 'Päiväys ja aika',
	'Strings' => 'Merkkijonot',
	'Binary' => 'Binäärinen',
	'Lists' => 'Luettelot',
	'Network' => 'Verkko',
	'Geometry' => 'Geometria',
	'Relations' => 'Suhteet',
	
	'Editor' => 'Editori',
	// date format in Editor: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5.$3.$1',
	// hint for date format - use language equivalents for day, month and year shortcuts
	'[yyyy]-mm-dd' => 'pp.kk.[vvvv]',
	// hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',
	'now' => 'nyt',
	'yes' => 'kyllä',
	'no' => 'ei',
	
	// general SQLite error in create, drop or rename database
	'File exists.' => 'Tiedosto on olemassa.',
	'Please use one of the extensions %s.' => 'Käytä jotain %s-laajennuksista.',
	
	// PostgreSQL and MS SQL schema support
	'Alter schema' => 'Muuta kaavaa',
	'Create schema' => 'Luo kaava',
	'Schema has been dropped.' => 'Kaava poistettiin.',
	'Schema has been created.' => 'Kaava luotiin.',
	'Schema has been altered.' => 'Kaavaa muutettiin.',
	'Schema' => 'Kaava',
	'Invalid schema.' => 'Kaava ei kelpaa.',
	
	// PostgreSQL sequences support
	'Sequences' => 'Sekvenssit',
	'Create sequence' => 'Luo sekvenssi',
	'Sequence has been dropped.' => 'Sekvenssi on poistettu.',
	'Sequence has been created.' => 'Sekvenssi on luotu.',
	'Sequence has been altered.' => 'Sekvenssiä on muutettu.',
	'Alter sequence' => 'Muuta sekvenssiä',
	
	// PostgreSQL user types support
	'User types' => 'Käyttäjän tyypit',
	'Create type' => 'Luo tyyppi',
	'Type has been dropped.' => 'Tyyppi poistettiin.',
	'Type has been created.' => 'Tyyppi luotiin.',
	'Alter type' => 'Muuta tyyppiä',

	'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.' => 'Kiitos, kun käytät Admineriä, voit <a href="https://www.adminer.org/en/donation/">tehdä lahjoituksen tästä</a>.',
	'Drop %s?' => 'Poistetaanko %s?',
	'overwrite' => 'kirjoittaen päälle',
	'DB' => 'TK',
	'ATTACH queries are not supported.' => 'ATTACH-komennolla tehtyjä kyselyjä ei tueta.',
	'Warnings' => 'Varoitukset',
	'Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.' => 'Adminer ei tue pääsyä tietokantaan ilman salasanaa, katso tarkemmin <a href="https://www.adminer.org/en/password/"%s>täältä</a>.',
	'The action will be performed after successful login with the same credentials.' => 'Toiminto suoritetaan sen jälkeen, kun on onnistuttu kirjautumaan samoilla käyttäjätunnuksilla uudestaan.',
	'Connecting to privileged ports is not allowed.' => 'Yhteydet etuoikeutettuihin portteihin eivät ole sallittuja.',
	'There is a space in the input password which might be the cause.' => 'Syynä voi olla syötetyssä salasanassa oleva välilyönti.',
	'Unknown error.' => 'Tuntematon virhe.',
	'Database does not support password.' => 'Tietokanta ei tue salasanaa.',
	'Disable %s or enable %s or %s extensions.' => 'Poista käytöstä %s tai ota käyttöön laajennus %s tai %s.',
);
