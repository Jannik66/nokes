CREATE database IF NOT EXISTS nokes;
CREATE TABLE IF NOT EXISTS `nokes`.`user` (
    `userid` VARCHAR(20) NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`userid`)
);
CREATE TABLE IF NOT EXISTS `nokes`.`note` (
    `id` VARCHAR(40) NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `content` VARCHAR(500) NOT NULL,
    `fk_userid` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_note_user` FOREIGN KEY (`fk_userid`) REFERENCES `nokes`.`user`(`userid`) ON DELETE CASCADE ON UPDATE NO ACTION
);
CREATE USER 'NokesUser' @'localhost' IDENTIFIED BY 'nokesUserP4ssw0rd';
GRANT SELECT,
    INSERT,
    UPDATE,
    DELETE ON nokes.* TO 'NokesUser' @'localhost';