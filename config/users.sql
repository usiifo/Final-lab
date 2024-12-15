USE bookmarking_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL
);

INSERT INTO users(username, pass) VALUES("usiifo", 2136374)