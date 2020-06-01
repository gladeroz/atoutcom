
CREATE TABLE IF NOT EXISTS wp_atoutcom_users (
	id int(11) NOT NULL auto_increment,
	PRIMARY KEY (id),
	nom VARCHAR(255) NOT NULL,
	prenom VARCHAR(255) NOT NULL,
	email VARCHAR(320) NOT NULL,
	password VARCHAR(500) NOT NULL,
	adresse CHAR(255),
	codepostal CHAR(10),
	ville CHAR(60),
	pays CHAR(60),
	telephone_mobile CHAR(20),
	telephone_fixe CHAR(20),
	dateinscription CHAR(20) NOT NULL,
	statut VARCHAR(15),
	specialite VARCHAR(100),
	categorie VARCHAR(20),
	isUpdate VARCHAR(10),
	organisme_facturation CHAR(100),
	email_facturation CHAR(255),
	adresse_facturation CHAR(255),
	ville_facturation CHAR(60),
	codepostal_facturation CHAR(10),
	pays_facturation CHAR(50)
	
);

CREATE TABLE IF NOT EXISTS wp_atoutcom_users_file (
	id int(11) NOT NULL auto_increment,
	PRIMARY KEY (id),
	email VARCHAR(320) NOT NULL,
	fichier VARCHAR(500) NOT NULL,
	chemin VARCHAR(500) NOT NULL,
	date_enregistrement VARCHAR(500) NOT NULL,
	type_doc VARCHAR(100) NOT NULL
	
);

CREATE TABLE IF NOT EXISTS wp_atoutcom_events (
	id int(11) NOT NULL auto_increment,
	PRIMARY KEY (id),
	evenement VARCHAR(255),
	date_evenement VARCHAR(20),
	nom VARCHAR(50),
	prenom VARCHAR(50),
	email VARCHAR(50),
	telephone VARCHAR(20),
	adresse VARCHAR(50),
	code_postal VARCHAR(50),
	ville VARCHAR(100),
	pays VARCHAR(50) 
	
);

CREATE TABLE IF NOT EXISTS wp_atoutcom_users_events_status (
	id int(11) NOT NULL auto_increment,
	PRIMARY KEY (id),
	email VARCHAR(320) NOT NULL,
	id_event int(11) NOT NULL,
	status VARCHAR(50) NOT NULL
	
);

CREATE TABLE IF NOT EXISTS wp_atoutcom_users_events_facture (
	id int(11) NOT NULL auto_increment,
	PRIMARY KEY (id),
	periode CHAR(50),
	numero CHAR(50),
	date_facture CHAR(20),
	destinataire CHAR(100),
	intitule CHAR(250),
	specialite CHAR(20),
	annee CHAR(10),
	montantHT DECIMAL(10,2),
	aka_tauxTVA DECIMAL(10,2),
	montantTVA DECIMAL(10,0),
	montantTTC DECIMAL(10,0),
	montantNET DECIMAL(10,0),
	total DECIMAL(10,0),
	accompte DECIMAL(10,0),
	restedu DECIMAL(10,0),
	paye DECIMAL(10,0),
	encaisse DECIMAL(10,0),
	date_reglement CHAR(20),
	commentaire CHAR(250),
	concerne CHAR(50)
		
);