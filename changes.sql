ALTER TABLE `code_guestbook_posts` ADD `deleted` INT NOT NULL ;
ALTER TABLE `code_guestbook_answers` ADD `deleted` INT NOT NULL ;

ALTER TABLE `code_news_module_entry` ADD `image` VARCHAR( 255 ) NOT NULL ;