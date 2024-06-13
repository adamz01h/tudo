CREATE TABLE `users` (
	`uid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` TEXT NOT NULL COLLATE 'utf8mb4_bin',
	`password` TEXT NOT NULL COLLATE 'utf8mb4_bin',
	`description` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	PRIMARY KEY (`uid`) USING BTREE,
	UNIQUE INDEX `uid` (`uid`) USING BTREE
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;

CREATE TABLE `motd` (
	`mid` INT(10) NOT NULL AUTO_INCREMENT,
	`text` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	INDEX `Index 1` (`mid`) USING BTREE
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;

CREATE TABLE `tokens` (
    tid BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uid BIGINT(20) UNSIGNED NOT NULL,
    token TEXT NOT NULL COLLATE 'utf8mb4_bin',
    FOREIGN KEY (uid) REFERENCES users (uid)
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB;

CREATE TABLE class_posts (
	cid SERIAL PRIMARY KEY NOT NULL,
	code TEXT NOT NULL,
	name TEXT NOT NULL,
	professor TEXT NOT NULL,
	ects DECIMAL NOT NULL,
	description TEXT NOT NULL
);

CREATE TABLE motd_images (
	iid SERIAL PRIMARY KEY NOT NULL,
	path TEXT NOT NULL,
	title TEXT NOT NULL
);

INSERT INTO users 
(username, password, description)
VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'BOSS'),
('user1', '0a041b9462caa4a31bac3567e0b6e6fd9100787db2ab433d96f6d178cabfce90', 'Head of Security'),
('user2', '6025d18fe48abd45168528f18a82e265dd98d421a7084aa09f61b341703901a3', 'Head of Management');

INSERT INTO class_posts
(code, name, professor, ects, description)
VALUES
('187.B12', 'Denkweisen der Informatik', 'Purgathofer, Peter', 5.5, 'Very easy, but can be a bit frustrating'),
('186.866', 'Algorithmen und Datenstrukturen', 'Kronegger, Martin', 8.0, 'Pretty hard, but very interesting'),
('184.735', 'Einführung in die Künstliche Intelligenz', 'Eiter, Thomas', 3.0, 'Very lucky if you pass. Dont underestimate.'),
('188.982', 'Privacy Enhancing Technologies ', 'Weippl, Edgar', 3.0, 'Very fun, and easy to get a perfect grade. Takes a lot of time.');

INSERT INTO motd_images
(path, title)
VALUES
('images/motd_1.png','TU Library'),
('images/motd_2.png','TU Hauptgebaude'),
('images/motd_3.png','TU Freihaus');
