-- COMMENTAIRE : IL FAUT REVOIR LE MODELE DE LA TABLE MESURE
-- PROPOSITION : METTRE LES MESURES EN ELLES-MEMES DANS UNE AUTRE TABLE, ET ID_MESURE SERA DONC ASSOCIE A UN ENSEMBLE DE VALEURS NUMERIQUES DE CETTE NOUVELLE TABLE

DROP TABLE IF EXISTS MEDECIN;
DROP TABLE IF EXISTS PATIENT;
DROP TABLE IF EXISTS SUIVRE;
DROP TABLE IF EXISTS RENDEZ-VOUS;
DROP TABLE IF EXISTS MESURES;
DROP TABLE IF EXISTS PREFERENCES_MEDECIN;
DROP TABLE IF EXISTS HISTORIQUE_CONSOLE;
DROP TABLE IF EXISTS GRAPHIQUE;
DROP TABLE IF EXISTS SEUIL_ALERTE;
DROP TABLE IF EXISTS ALERTE;


CREATE TABLE MEDECIN (
    med_id INT,
    prenom VARCHAR(50) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    sexe CHAR(1) NOT NULL
    specialite VARCHAR(50) NOT NULL 
    CONSTRAINT pk_medecin PRIMARY KEY(med_id),
    CONSTRAINT ck_sexe CHECK(sexe IN ('M', 'F')),
    CONSTRAINT ck_specialite CHECK(specialite IN (
        'Addictologie',
        'Algologie',
        'Allergologie',
        'Anesthésie-Réanimation',
        'Cancérologie',
        'Cardio-vasculaire HTA',
        'Chirurgie',
        'Dermatologie',
        'Diabétologie-Endocrinologie',
        'Génétique',
        'Gériatrie',
        'Gynécologie-Obstétrique',
        'Hématologie',
        'Hépato-gastro-entérologie',
        'Imagerie médicale',
        'Immunologie',
        'Infectiologie',
        'Médecine du sport',
        'Médecine du travail',
        'Médecine générale',
        'Médecine légale',
        'Médecine physique et de réadaptation',
        'Néphrologie',
        'Neurologie',
        'Nutrition',
        'Ophtalmologie',
        'ORL',
        'Pédiatrie',
        'Pneumologie',
        'Psychiatrie',
        'Radiologie',
        'Rhumatologie',
        'Sexologie',
        'Toxicologie',
        'Urologie'
    ))
);

CREATE TABLE PATIENT (
	pt_id INT,
	prenom VARCHAR(50) NOT NULL,
	nom VARCHAR(100) NOT NULL,
	email VARCHAR(150) UNIQUE NOT NULL,
	sexe CHAR(1) NOT NULL,
	groupe_sanguin VARCHAR(3) NOT NULL,
	date_naissance DATE NOT NULL,
	telephone VARCHAR(50) UNIQUE NOT NULL,
	ville VARCHAR(100),
	code_postal VARCHAR(5),
	adresse VARCHAR(255),
	CONSTRAINT pk_patient PRIMARY KEY (pt_id),
	CONSTRAINT ck_sexe CHECK(sexe IN ('M', 'F')),
	CONSTRAINT ck_groupe_sanguin CHECK(groupe_sanguin IN('AB+','AB-','A+','A-','B+','B-','O+','O-')
);

CREATE TABLE SUIVRE (
	med_id INT,
	pt_id INT,
	date_debut DATE NOT NULL,
	date_fin DATE,
	CONSTRAINT pk_suivre PRIMARY KEY(med_id,pt_id),
	CONSTRAINT fk_suivre FOREIGN KEY(med_id) REFERENCES MEDECIN(med_id),
	CONSTRAINT fk2_suivre FOREIGN KEY(pt_id) REFERENCES PATIENT(pT_id)
);

CREATE TABLE RENDEZ-VOUS (
	id_rdv INT,
	med_it INT,
	pt_id INT,
	date_rdv DATE NOT NULL,
	heure_rdv TIME NOT NULL,
	motif VARCHAR(100) NOT NULL,
	statut VARCHAR(10) NOT NULL,
	CONSTRAINT pk_rdv PRIMARY KEY(id_rdv),
	CONSTRAINT fk_rdv FOREIGN KEY(med_id) REFERENCES MEDECIN(med_id),
	CONSTRAINT fk2_rdv FOREIGN KEY(pt_id) REFERENCES patient(pt_id),
	CONSTRAINT ck_rdv CHECK(statut IN('prévu','réalisé','annulé'))
);

CREATE TABLE MESURES(
	id_mesure BIGINT,
	pt_id INT,
	valeur REAL NOT NULL,
	type_mesure VARCHAR(100) NOT NULL,
	unite VARCHAR(5) NOT NULL,
	date_mesure DATE NOT NULL,
	heure_mesure TIME NOT NULL,
	CONSTRAINT pk_mesures PRIMARY KEY(id_mesure),
	CONSTRAINT fk_mesures FOREIGN KEY(pt_id) REFERENCES PATIENT(pt_id)
);

CREATE TABLE PREFERENCES_MEDECIN (
	id_prefp INT,
	med_id INT,
	theme VARCHAR(20),
	langue VARCHAR(50),
	CONSTRAINT pk_preferences PRIMARY KEY(id_prefp),
	CONSTRAINT fk_preferences FOREIGN KEY(med_id) REFERENCES MEDECIN(med_id)
);

CREATE TABLE HISTORIQUE_CONSOLE (
	log_id BIGINT,
	med_id INT,
	type_action VARCHAR(20) NOT NULL,
	date_action DATE NOT NULL,
	heure_action TIME NOT NULL,
	CONSTRAINT pk_historique PRIMARY KEY(log_id),
	CONSTRAINT fk_historique FOREIGN KEY(med_id) REFERENCES MEDECIN(med_id),
	CONSTRAINT ck_historique CHECK(type_action IN('réduire','ouvrir'))
);

CREATE TABLE GRAPHIQUE (
	graph_id INT,
	id_mesure INT,
	titre VARCHAR(255) NOT NULL,
	type_graph VARCHAR(50) NOT NULL,
	CONSTRAINT pk_graph PRIMARY KEY(graph_id),
	CONSTRAINT fk_graph FOREIGN KEY(id_mesure) REFERENCES MESURES(id_mesure),
	CONSTRAINT ck_graph CHECK(type_graph IN('histogramme','courbes','nuage','secteurs','autre'))
);

CREATE TABLE SEUIL_ALERTE (
	seuil_id INT,
	id_mesure INT,
	seuil_min REAL NOT NULL,
	seuil_max REAL NOT NULL,
	CONSTRAINT pk_seuil PRIMARY KEY(seuil_id),
	CONSTRAINT fk_seuil FOREIGN KEY(id_mesure) REFERENCES MESURES(id_mesure)
);




