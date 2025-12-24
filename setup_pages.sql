-- Create table for pages/links
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    url VARCHAR(500) NOT NULL,
    description TEXT,
    tags JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert pages from JSON data
INSERT INTO pages (name, url, description, tags) VALUES
('3DS Hacks Guide', 'https://3ds.hacks.guide/', 'A guide to 3DS homebrewing.', '["Tools", "Video Games"]'),
('AlternativeTo', 'https://alternativeto.net/', 'A website that compares software.', '["Tools", "Software", "Directory"]'),
('Animal Photo Art References Search', 'https://x6ud.github.io/#/', 'A website that allows you to search for animal photos.', '["Tools", "Art", "Archive"]'),
('AnimeEffects', 'https://animeeffectsdevs.github.io/', 'An open source 2D animation tool which doesn\'t require a carefully thought-out plan, it simplifies animation by providing various functions based on the deformation of polygon meshes.', '["Animation", "Software"]'),
('Animongers Flash Archive', 'http://animonger.com/flash-tools-archive', 'Free Flash/Animate plugins.', '["Animation", "Plugins"]');
