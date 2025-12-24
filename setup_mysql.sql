-- MySQL Database Setup Script
-- Run this as root/admin user to set up the database and user

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS akel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user and grant privileges
CREATE USER IF NOT EXISTS 'akel_admin'@'localhost' IDENTIFIED BY 'zli52_D8^LZtfvyv';
GRANT ALL PRIVILEGES ON akel_db.* TO 'akel_admin'@'localhost';
FLUSH PRIVILEGES;

-- Use the database
USE akel_db;

-- Table to store drawings
CREATE TABLE IF NOT EXISTS picasso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL DEFAULT 'Untitled Drawing',
    image_data LONGBLOB NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Index for better performance
CREATE INDEX IF NOT EXISTS idx_created_at ON picasso(created_at);

-- Table to store messages
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT
);

-- Index for better performance
CREATE INDEX IF NOT EXISTS idx_messages_created_at ON messages(created_at);

-- Create table for buttons
CREATE TABLE IF NOT EXISTS buttons(
    name VARCHAR(255) PRIMARY KEY,
    image_data LONGBLOB NOT NULL,
    link VARCHAR(255) NOT NULL
);

-- Create table for character sprites
CREATE TABLE IF NOT EXISTS character_sprites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    alt_text TEXT NOT NULL,
    character_name VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    series VARCHAR(100) NOT NULL
);

-- Create table for social links
CREATE TABLE IF NOT EXISTS social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    display_text VARCHAR(100) NOT NULL,
    icon_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NOT NULL,
    is_nsfw TINYINT(1) DEFAULT 0
);

-- Create table for pages/links
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    url VARCHAR(500) NOT NULL,
    description TEXT,
    tags TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert button images (using LOAD_FILE with correct absolute paths)
INSERT IGNORE INTO buttons (name, image_data, link) VALUES
('boypussy', LOAD_FILE('/home/akel/Documentos/php/img/buttons/boypussy.gif'), 'https://boypussy.neocities.org/'),
('doqmeat', LOAD_FILE('/home/akel/Documentos/php/img/buttons/doqmeat.png'), 'https://doqmeat.com/'),
('Leirin', LOAD_FILE('/home/akel/Documentos/php/img/buttons/fzbanner1.png'), 'https://leirin.neocities.org/'),
('Meriamelie', LOAD_FILE('/home/akel/Documentos/php/img/buttons/heart-soda.gif'), 'https://meriamelie.neocities.org/'),
('HumanFinny', LOAD_FILE('/home/akel/Documentos/php/img/buttons/humanfinny.gif'), 'https://humanfinny.neocities.org/'),
('Lars From Mars', LOAD_FILE('/home/akel/Documentos/php/img/buttons/lars.png'), 'https://larsfrommars.neocities.org/'),
('Norisowl', LOAD_FILE('/home/akel/Documentos/php/img/buttons/norisowl_button_face.png'), 'https://norisowl.neocities.org/'),
('SuperKirbyLover', LOAD_FILE('/home/akel/Documentos/php/img/buttons/superkirbylover.gif'), 'https://superkirbylover.me/'),
('Whimsical', LOAD_FILE('/home/akel/Documentos/php/img/buttons/whimsical.gif'), 'http://whimsical.heartette.net/'),
('Xiokka', LOAD_FILE('/home/akel/Documentos/php/img/buttons/xiokka.png'), 'https://xiokka.neocities.org/');

-- Insert the social links
INSERT IGNORE INTO social_links (platform, url, display_text, icon_path, alt_text, is_nsfw) VALUES
('tumblr', 'https://psi-sulfur.tumblr.com/', 'Blog Personal/Principal', 'img/tumblr.png', 'Tumblr Logo', 0),
('tumblr', 'https://a-akel.tumblr.com/', 'Blog de arte', 'img/tumblr.png', 'Tumblr Logo', 0),
('tumblr', 'https://one-eighty-zazzers.tumblr.com/', 'Blog de Self Insert/Shipping', 'img/tumblr.png', 'Tumblr Logo', 0),
('tumblr', 'https://tordistic.tumblr.com/', 'Blog de Eddsworld', 'img/tumblr.png', 'Tumblr Logo', 0),
('bluesky', 'https://bsky.app/profile/akel.bsky.social', 'SFW Bsky', 'img/bsky.png', 'Bluesky Logo', 0),
('neocities', 'https://neocities.org/site/akel', 'Perfil de Neocities', 'img/neocities.png', 'Neocities Logo', 0),
('youtube', 'https://www.youtube.com/@akelboye', 'Canal en español', 'img/yt.png', 'Youtube logo', 0),
('youtube', 'https://www.youtube.com/@a-akel', 'Canal en inglés', 'img/yt.png', 'Youtube logo', 0),
('pinterest', 'https://cl.pinterest.com/aaak3l/', 'Pinterest', 'img/pintrs.png', 'Pinterest logo', 0),
('tumblr', 'https://akels-x.tumblr.com/', 'Blog erótico', 'img/tumblr.png', 'Tumblr Logo', 1),
('bluesky', 'https://bsky.app/profile/akels.bsky.social', 'NSFW Bsky', 'img/bsky.png', 'Bluesky Logo', 1),
('pillowfort', 'https://pillowfort.neocities.org/', 'Pillowfort', 'img/pillow.png', 'Pillowfort logo', 1);

-- Insert character sprites
INSERT IGNORE INTO character_sprites (image_path, alt_text, character_name, title, series) VALUES
('/img/tord.png', 'Earthbound styled sprite of Tord from Eddsworld', 'Tord', 'Tord from Eddsworld (cringe)', 'Eddsworld'),
('/img/homura.png', 'Earthbound styled sprite of Homura Akemi from Puella Magi Madoka Magica', 'Homura Akemi', 'Homura Akemi from Puella Magi Madoka Magica', 'Puella Magi Madoka Magica'),
('/img/toko.png', 'Earthbound styled sprite of Toko Fukawa from Danganronpa: Trigger Happy Havoc', 'Toko Fukawa', 'Toko Fukawa from Danganronpa: Trigger Happy Havoc (oh no)', 'Danganronpa: Trigger Happy Havoc'),
('/img/jeff.png', 'Jeff original sprite', 'Jeff Andonuts', 'Jeff Andonuts from Earthbound/MOTHER 2', 'Earthbound/MOTHER 2'),
('/img/kakyoin.png', 'Earthbound styled sprite of Noriaki Kakyoin from JoJo''s Bizarre Adventure: Stardust Crusaders', 'Noriaki Kakyoin', 'Noriaki Kakyoin from JoJo''s Bizarre Adventure: Stardust Crusaders', 'JoJo''s Bizarre Adventure: Stardust Crusaders');
