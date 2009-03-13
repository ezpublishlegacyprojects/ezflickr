
CREATE TABLE `ezflickrselection` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER NOT NULL,
  `flickr_id` VARCHAR(255),
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8;