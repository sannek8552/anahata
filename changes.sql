ALTER TABLE `code_guestbook_posts` ADD `deleted` INT NOT NULL ;
ALTER TABLE `code_guestbook_answers` ADD `deleted` INT NOT NULL ;

ALTER TABLE `code_news_module_entry` ADD `image` VARCHAR( 255 ) NOT NULL ;

CREATE TABLE `anahata`.`code_preps` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`fio` VARCHAR( 255 ) NOT NULL ,
`photo` VARCHAR( 255 ) NOT NULL ,
`bio` TEXT NOT NULL ,
`created` INT( 10 ) NOT NULL ,
`updated` INT( 10 ) NOT NULL
) ENGINE = MYISAM ;