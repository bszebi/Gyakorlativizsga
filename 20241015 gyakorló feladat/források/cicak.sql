CREATE TABLE IF NOT EXISTS cicak (
	azonosito smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	cicafoto varchar(64) NOT NULL DEFAULT 'nincskep.png',
	cicaneve varchar(20) DEFAULT NULL,
	cicafajta varchar(20) DEFAULT NULL,
	cicakora varchar(60) DEFAULT NULL,
	PRIMARY KEY (azonosito)
);

INSERT INTO cicak (azonosito, cicafoto, cicaneve, cicafajta, cicakora) VALUES
(1, 'cirmi.jpg', 'Cirmi', 'Házi macska', '3 hetes'),
(2, 'picur.jpg', 'Picur', 'Házi macska', '4 hetes'),
(3, 'pöttöm.jpg', 'Pöttöm', 'Házi macska', '2 hetes');