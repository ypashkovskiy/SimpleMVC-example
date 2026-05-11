CREATE TABLE `categories` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb3;

ALTER TABLE notes
ADD COLUMN categoryId SMALLINT UNSIGNED NOT NULL,
ADD CONSTRAINT fk_articles_category
FOREIGN KEY (categoryId) REFERENCES categories(id)
ON DELETE RESTRICT;
