CREATE DATABASE `shopping` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `status` TINYINT DEFAULT 1,
  PRIMARY KEY `pk_id`(`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `price` float,
  `sale_price` float DEFAULT 0,
  `image` VARCHAR(255),
  `status` TINYINT DEFAULT 1,
  `category_id` INT NOT NULL,
  PRIMARY KEY `pk_id`(`id`)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `email` VARCHAR(255) UNIQUE,
  `password` VARCHAR(255),
  `phone` VARCHAR(11) UNIQUE,
  `status` TINYINT DEFAULT 1,
  `role` TINYINT DEFAULT 0,
  PRIMARY KEY `pk_id`(`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `ship_address` text NOT NULL,
  `phone` VARCHAR(11),
  `note` text,
  `status` TINYINT DEFAULT 0,
  PRIMARY KEY `pk_id`(`id`),
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `orders_detail` (
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` float
) ENGINE = InnoDB;

ALTER TABLE `product`
ADD CONSTRAINT `fk_product_far_category`
  FOREIGN KEY (`category_id`)
  REFERENCES `category` (`id`);

ALTER TABLE `orders`
ADD CONSTRAINT `fk_orders_far_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`);

ALTER TABLE `orders_detail`
ADD CONSTRAINT `fk_orders_detail_far_orders`
    FOREIGN KEY (`order_id`)
    REFERENCES `orders` (`id`);

ALTER TABLE `orders_detail`
ADD CONSTRAINT `fk_orders_detail_far_product`
    FOREIGN KEY (`product_id`)
    REFERENCES `product` (`id`);

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `status`, `role`) VALUES (NULL, 'Admin Manager', 'admin@gmail.com', 'admin123', '0392689213', '1', '1');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `status`, `role`) VALUES (NULL, 'User1', 'user@gmail.com', 'user123', '0392689214', '1', '0');