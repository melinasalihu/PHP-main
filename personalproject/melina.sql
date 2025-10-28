CREATE TABLE users (
    id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    confirm_password VARCHAR(255) NOT NULL,
    is_admin VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE clothes (
    id INT(11) NOT NULL,
    clothes_name VARCHAR(255) NOT NULL,
    clothes_image VARCHAR(255) NOT NULL,
    clothes_rating VARCHAR(255) NOT NULL,
    clothes_price VARCHAR(255) NOT NULL,
    clothes_quantity VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE orders (
    id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    clothes_id INT(11) NOT NULL,
    nr_orders INT(11) NOT NULL,
    date VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);


ALTER TABLE users ADD PRIMARY KEY (id)

ALTER TABLE clothes ADD PRIMARY KEY (id);
ALTER TABLE orders ADD PRIMARY KEY (id);

ALTER TABLE users MODIFY id int(11) NOT NULL AUTO_INCREMENT
ALTER TABLE clothes MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE orders MODIFY id int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `confirm_password`, `is_admin`) VALUES
(1, 'Melina', 'Salihu', 'melina@gmail.com', 1234, 1234, '1' ),
(2, 'Elda', 'Salihu', 'elda@gmail.com', 12345, 12345, '0');

INSERT INTO `clothes` (`id`, `clothes_name`, `clothes_image`, `clothes_rating`, `clothes_price`, `clothes_quantity`) VALUES 
(1, 'Dress', 'e.jpg', 10, '30$'),
(2, 'T-shirt', 'photo(1).webp', 7, '15$'),
(3, 'Jeans', 'el.jpg', 9, '25$');

INSERT INTO `orders` (`id`, `user_id`, `clothes_id`, `is_approved`) VALUES
(3,2,1, 'true');



 