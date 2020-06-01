CREATE TABLE wp_atoutcom_users_events_facture(
	id int(11) NOT NULL auto_increment,
	PRIMARY KEY (id),
	periode CHAR(50),
	numero CHAR(50),
	date_facture DATETIME,
	destinataire CHAR(100),
	intitule CHAR(250),
	annee CHAR(10),
	montantHT DECIMAL(10,2),
	aka_tauxTVA DECIMAL(10,2),
	montantTVA DECIMAL(10,2),
	montantTTC DECIMAL(10,2),
	montantNET DECIMAL(10,2),
	total DECIMAL(10,2),
	accompte DECIMAL(10,2),
	restedu DECIMAL(10,2),
	paye DECIMAL(10,2),
	encaisse DECIMAL(10,2),
	date_reglement DATETIME,
	commentaire CHAR(250),
	concerne CHAR(50)
		
);