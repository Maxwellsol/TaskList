CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `login` VARCHAR (255) NOT NULL ,
    `password` VARCHAR (255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE (`login`)
);

CREATE TABLE `tasks`(
     `id` INT NOT NULL AUTO_INCREMENT,
     `user_id` INT NOT NULL,
     `description` TEXT NOT NULL,
     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     `status` BOOL NOT NULL DEFAULT FALSE,
     PRIMARY KEY (`id`),
     FOREIGN KEY (`user_id`)  REFERENCES `users` (`id`)
);

