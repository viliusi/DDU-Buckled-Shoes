CREATE TABLE `salutation` (
    `salutation_id` int(11) NOT NULL AUTO_INCREMENT,
    `salutation` varchar(10) NOT NULL,
    PRIMARY KEY (`salutation_id`)
);

CREATE TABLE `membership` (
    `membership_id` int(11) NOT NULL AUTO_INCREMENT,
    `full_name` varchar(255) NOT NULL,
    `physical_address` varchar(255) NOT NULL,
    age int(5) NOT NULL,
    `salutation_id` int(11) NOT NULL,
    PRIMARY KEY (`membership_id`),
    FOREIGN KEY (`salutation_id`) REFERENCES `salutation` (`salutation_id`)
        ON DELETE CASCADE 
        ON UPDATE CASCADE 
);

CREATE TABLE `rentals` (
    `rental_id` int(11) NOT NULL AUTO_INCREMENT,
    `membership_id` int(11) NOT NULL,
    `rented_movie` varchar(255) NOT NULL,
    PRIMARY KEY (`rental_id`),
    FOREIGN KEY (`membership_id`) REFERENCES `membership` (`membership_id`)
        ON DELETE CASCADE 
        ON UPDATE CASCADE 
);

-- Inserting values into the salutation table
INSERT INTO `salutation` (`salutation`, `salutation_id`)
VALUES
    ('Mr', NULL),
    ('Mrs', NULL),
    ('Miss', NULL),
    ('Dr', NULL);