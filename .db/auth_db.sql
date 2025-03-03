SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `prousers` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pp` varchar(255) NOT NULL DEFAULT 'default-pp.png',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `prousers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `prousers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;


CREATE TABLE `recusers` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pp` varchar(255) NOT NULL DEFAULT 'default-pp.png',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `recusers`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `recusers`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

CREATE TABLE `giveAdopt` (
  `pet_id` int(100) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `petcatagory` varchar(255) NOT NULL,
  `petage` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `cinfo` varchar(255) NOT NULL,
  `up` varchar(255) NOT NULL ,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `giveAdopt`
MODIFY COLUMN `pet_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

CREATE TABLE `productsell` (
  `product_id` int(100) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `productcatagory` varchar(255) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `cinfo` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `up` varchar(255) NOT NULL ,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `productsell`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

CREATE TABLE `cart`(
  `product_id` int(111)NOT NULL AUTO_INCREMENT,
  `user_id1` int(11) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `cart`
   MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;


CREATE TABLE `petcart`(
  `pet_id` int(111)NOT NULL,
  `user_id1` int(11) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `petcart`
   MODIFY `pet_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

