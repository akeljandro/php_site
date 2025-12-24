-- Database setup for storing drawings
CREATE DATABASE IF NOT EXISTS drawings_db;

USE drawings_db;

-- Table to store drawings
CREATE TABLE IF NOT EXISTS drawings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL DEFAULT 'Untitled Drawing',
    image_data LONGBLOB NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Index for better performance
CREATE INDEX idx_created_at ON drawings(created_at);

-- Table to store messages
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT
);

-- Index for better performance
CREATE INDEX idx_messages_created_at ON messages(created_at);

CREATE TABLE IF NOT EXISTS buttons(
    name VARCHAR(255) PRIMARY KEY,
    image_data LONGBLOB NOT NULL,
    link VARCHAR(255) NOT NULL
);


-- Insert button images
INSERT INTO buttons (name, image_data, link) VALUES
('boypussy', LOAD_FILE('/img/buttons/boypussy.gif'), 'https://boypussy.neocities.org/'),
('doqmeat', LOAD_FILE('/img/buttons/doqmeat.png'), 'https://doqmeat.com/'),
('Leirin', LOAD_FILE('/img/buttons/fzbanner1.png'), 'https://leirin.neocities.org/'),
('Meriamelie', LOAD_FILE('/img/buttons/heart-soda.gif'), 'https://meriamelie.neocities.org/'),
('HumanFinny', LOAD_FILE('/img/buttons/humanfinny.gif'), 'https://humanfinny.neocities.org/'),
('Lars From Mars', LOAD_FILE('/img/buttons/lars.png'), 'https://larsfrommars.neocities.org/'),
('Norisowl', LOAD_FILE('/img/buttons/norisowl_button_face.png'), 'https://norisowl.neocities.org/'),
('SuperKirbyLover', LOAD_FILE('/img/buttons/superkirbylover.gif'), 'https://superkirbylover.me/'),
('Whimsical', LOAD_FILE('/img/buttons/whimsical.gif'), 'http://whimsical.heartette.net/'),
('Xiokka', LOAD_FILE('/img/buttons/xiokka.png'), 'https://xiokka.neocities.org/');

CREATE TABLE character_sprites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    alt_text TEXT NOT NULL,
    character_name VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    series VARCHAR(100) NOT NULL);
INSERT INTO character_sprites (image_path, alt_text, character_name, title, series) VALUES
('/img/tord.png', 'Earthbound styled sprite of Tord from Eddsworld', 'Tord', 'Tord from Eddsworld (cringe)', 'Eddsworld'),
('/img/homura.png', 'Earthbound styled sprite of Homura Akemi from Puella Magi Madoka Magica', 'Homura Akemi', 'Homura Akemi from Puella Magi Madoka Magica', 'Puella Magi Madoka Magica'),
('/img/toko.png', 'Earthbound styled sprite of Toko Fukawa from Danganronpa: Trigger Happy Havoc', 'Toko Fukawa', 'Toko Fukawa from Danganronpa: Trigger Happy Havoc (oh no)', 'Danganronpa: Trigger Happy Havoc'),
('/img/jeff.png', 'Jeff original sprite', 'Jeff Andonuts', 'Jeff Andonuts from Earthbound/MOTHER 2', 'Earthbound/MOTHER 2'),
('/img/kakyoin.png', 'Earthbound styled sprite of Noriaki Kakyoin from JoJo''s Bizarre Adventure: Stardust Crusaders', 'Noriaki Kakyoin', 'Noriaki Kakyoin from JoJo''s Bizarre Adventure: Stardust Crusaders', 'JoJo''s Bizarre Adventure: Stardust Crusaders');

CREATE TABLE social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    display_text VARCHAR(100) NOT NULL,
    icon_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NOT NULL,
    is_nsfw BOOLEAN DEFAULT FALSE
);

-- Insert the social links
INSERT INTO social_links (platform, url, display_text, icon_path, alt_text, is_nsfw) VALUES
('tumblr', 'https://psi-sulfur.tumblr.com/', 'Blog Personal/Principal', 'img/tumblr.png', 'Tumblr Logo', FALSE),
('tumblr', 'https://a-akel.tumblr.com/', 'Blog de arte', 'img/tumblr.png', 'Tumblr Logo', FALSE),
('tumblr', 'https://one-eighty-zazzers.tumblr.com/', 'Blog de Self Insert/Shipping', 'img/tumblr.png', 'Tumblr Logo', FALSE),
('tumblr', 'https://tordistic.tumblr.com/', 'Blog de Eddsworld', 'img/tumblr.png', 'Tumblr Logo', FALSE),
('bluesky', 'https://bsky.app/profile/akel.bsky.social', 'SFW Bsky', 'img/bsky.png', 'Bluesky Logo', FALSE),
('neocities', 'https://neocities.org/site/akel', 'Perfil de Neocities', 'img/neocities.png', 'Neocities Logo', FALSE),
('youtube', 'https://www.youtube.com/@akelboye', 'Canal en español', 'img/yt.png', 'Youtube logo', FALSE),
('youtube', 'https://www.youtube.com/@a-akel', 'Canal en inglés', 'img/yt.png', 'Youtube logo', FALSE),
('pinterest', 'https://cl.pinterest.com/aaak3l/', 'Pinterest', 'img/pintrs.png', 'Pinterest logo', FALSE);

insert into social_links (platform, url, display_text, icon_path, alt_text, is_nsfw) values
('tumblr', 'https://akels-x.tumblr.com/', 'Blog erótico', 'img/tumblr.png', 'Tumblr Logo', TRUE),
('bluesky', 'https://bsky.app/profile/akels.bsky.social', 'NSFW Bsky', 'img/bsky.png', 'Bluesky Logo', TRUE),
('pillowfort', 'https://pillowfort.neocities.org/', 'Pillowfort', 'img/pillow.png', 'Pillowfort logo', TRUE);

