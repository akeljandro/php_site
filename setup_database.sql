-- Table to store drawings
CREATE TABLE IF NOT EXISTS picasso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL DEFAULT 'Untitled Drawing',
    image_data LONGBLOB NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Index for better performance
CREATE INDEX idx_created_at ON picasso(created_at);

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

-- Create table for buttons
CREATE TABLE IF NOT EXISTS buttons(
    name VARCHAR(255) PRIMARY KEY,
    image_data LONGBLOB NOT NULL,
    link VARCHAR(255) NOT NULL
);

-- Note: Buttons table should be populated using populate_buttons.php script
-- The INSERT statements are removed because they contain file paths instead of binary data

-- Create table for character sprites
CREATE TABLE character_sprites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    alt_text TEXT NOT NULL,
    character_name VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    series VARCHAR(100) NOT NULL
);
INSERT INTO character_sprites (image_path, alt_text, character_name, title, series) VALUES
('/img/tord.png', 'Earthbound styled sprite of Tord from Eddsworld', 'Tord', 'Tord from Eddsworld (cringe)', 'Eddsworld'),
('/img/homura.png', 'Earthbound styled sprite of Homura Akemi from Puella Magi Madoka Magica', 'Homura Akemi', 'Homura Akemi from Puella Magi Madoka Magica', 'Puella Magi Madoka Magica'),
('/img/toko.png', 'Earthbound styled sprite of Toko Fukawa from Danganronpa: Trigger Happy Havoc', 'Toko Fukawa', 'Toko Fukawa from Danganronpa: Trigger Happy Havoc (oh no)', 'Danganronpa: Trigger Happy Havoc'),
('/img/jeff.png', 'Jeff original sprite', 'Jeff Andonuts', 'Jeff Andonuts from Earthbound/MOTHER 2', 'Earthbound/MOTHER 2'),
('/img/kakyoin.png', 'Earthbound styled sprite of Noriaki Kakyoin from JoJo''s Bizarre Adventure: Stardust Crusaders', 'Noriaki Kakyoin', 'Noriaki Kakyoin from JoJo''s Bizarre Adventure: Stardust Crusaders', 'JoJo''s Bizarre Adventure: Stardust Crusaders');

-- Create table for social links
CREATE TABLE social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    display_text VARCHAR(100) NOT NULL,
    icon_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NOT NULL,
    is_nsfw TINYINT(1) DEFAULT 0
);

-- Insert the social links
INSERT INTO social_links (platform, url, display_text, icon_path, alt_text, is_nsfw) VALUES
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

-- Create table for pages/links
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    url VARCHAR(500) NOT NULL,
    description TEXT,
    tags TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- INSERT statements generated from pages.json
INSERT INTO pages (name, url, description, tags) VALUES
('3DS Hacks Guide', 'https://3ds.hacks.guide/', 'A guide to 3DS homebrewing.', 'Tools,Video Games'),
('AlternativeTo', 'https://alternativeto.net/', 'A website that compares software.', 'Tools,Software,Directory'),
('Animal Photo Art References Search', 'https://x6ud.github.io/#/', 'A website that allows you to search for animal photos.', 'Tools,Art,Archive'),
('AnimeEffects', 'https://animeeffectsdevs.github.io/', 'An open source 2D animation tool which doesn''t require a carefully thought-out plan, it simplifies animation by providing various functions based on the deformation of polygon meshes.', 'Animation,Software'),
('Animongers Flash Archive', 'http://animonger.com/flash-tools-archive', 'Free Flash/Animate plugins. ', 'Animation,Plugins'),
('Anytype', 'https://anytype.io/', 'Anytype is a note-taking app that allows you to create and manage notes in a way that is both flexible and powerful powerful.', 'Software,Software,Writing'),
('Artist Resource Links', 'https://docs.google.com/spreadsheets/d/18aQ_VMkW_p8v45-6XjcDvW5vmX-EONp5xQsD3atZcQU/edit#gid=715443551', 'A list of resources for artists.', 'Tools,Art,Directory'),
('Backgrounds Archive', 'http://backgroundsarchive.com', 'A website that allows you to search for backgrounds.', 'Tools,Art,Archive'),
('Beginner''s Guide to Digital Zines!', 'https://yamino.itch.io/beginners-guide-to-digital-zines', 'A guide to digital zines.', 'Reading,Art,Guides'),
('Boil The Frog', 'http://boilthefrog.playlistmachinery.com/', 'Create a (nearly) seamless playlist between (almost) any two artists.', 'Tools,Music'),
('Bre''s Zine Resources', 'https://docs.google.com/document/d/11Lc8s3w5HLrs8ekKiIGrbxNjVUV591MRvLdIOp_5fiA/edit?usp=sharing', 'A list of resources for zine creators.', 'Tools,Art,Reading,Directory'),
('Catppuccin', 'https://catppuccin.com', 'Catppuccin is a pastel, soothing color scheme (four themes).', 'Plugins'),
('Circlejourney''s Toyhouse Live Code Editor', 'https://th.circlejourney.net/', 'A live code editor for web development.', 'Tools,Development'),
('Cobalt', 'https://cobalt.tools/', 'Download any archive from anywhere.', 'Tools,Internet,Make Corpos Angry'),
('ConvertICO', 'https://convertico.com/', 'Convert your images to ICO format.', 'Tools'),
('DeGoogle-ify Internet', 'https://degooglisons-internet.org/en/', 'Non profit proyect by Framasoft dedicated towards safer and trustworthy software solutions.', 'Tools,Internet,Make Corpos Angry'),
('Deploy to Neocities with Github', 'https://webcatz.neocities.org/writing/blog/?entry=deploy-neocities-github/', 'A guide to deploy to Neocities with Github.', 'Tools,Internet,Development,Guides'),
('Dracula', 'https://draculatheme.com', 'Dracula is a dark color scheme for your terminal, code editor, and more.', 'Plugins'),
('Eliasz'' OTP Prompt Generator', 'https://atsuzaki-playground.neocities.org/otp-prompt-generator/', 'A tool to generate OTP prompts.', 'Tools,Fun,Writing'),
('Ellipsus', 'https://ellipsus.com/', 'Google Docs alternative', 'Tools,Writing'),
('Escargot', 'https://escargot.chat/', 'Escargot is a new service that makes old versions of MSN Messenger and Windows Live Messenger work again. ', 'Software,Tools,Internet'),
('F-droid', 'https://f-droid.org/', 'F-Droid is a free and open source app store for Android. ', 'Software'),
('FileGarden', 'https://filegarden.com/', 'A file hosting service.', 'Tools,Internet'),
('Flashpoint Archive', 'https://archive.flashpoint.com/', 'Flashpoint Archive is a collection of Flash games. ', 'Software,Video Games,Archive'),
('Forebears', 'https://forebears.io/', 'Search millions of names & places', 'Tools,Internet,Reading'),
('Free Online Image Editor', 'https://www.online-image-editor.com/', 'A free online image editor.', 'Tools,Internet,Art'),
('freeformatter.com', 'https://www.freeformatter.com/', 'Tools for developers!', 'Tools,Internet,Development'),
('FREEMEDIAHECKYEAH', 'https://fmhy.pages.dev/', ':3', 'Tools,Internet,Make Corpos Angry,Directory'),
('FreeTube', 'https://freetubeapp.io/', 'YouTube Client, with AdBlock and SponsorBlock.', 'Software,Internet,Make Corpos Angry'),
('GeekUninstaler', 'https://geekuninstaller.com/', 'Debloater for Windows. ', 'Software,Make Corpos Angry'),
('Importing your streaming history to Last.FM', 'https://docs.google.com/document/d/1IhFMol3wZs24uKnh2rbxHpLaxhETcfB8KqzYIkEW_iM/edit?tab=t.0/', 'Guide to add your Spotify history to Last.FM', 'Tools,Internet,Music,Guides'),
('irasutoya', 'https://www.irasutoya.com/', 'Various free ilustrations', 'Art,Archive'),
('Jpegify.me', 'https://jpegify.me/', 'Convert your images to JPEG format.', 'Tools,Internet,Art'),
('khinsider', 'https://downloads.khinsider.com/', 'A website to download game music.', 'Tools,Internet,Music,Video Games,Archive'),
('Krita', 'https://krita.org/', 'Krita is a free and open source painting program. ', 'Software,Art,Animation'),
('LibreOffice', 'https://www.libreoffice.org/', 'LibreOffice is a free and open source office suite. ', 'Software,Tools'),
('List of really, really, really stupid article ideas that you really, really, really should not create', 'https://en.wikipedia.org/wiki/Wikipedia:List_of_really,_really,_really_stupid_article_ideas_that_you_really,_really,_really_should_not_create ', 'Posibly the funniest Wikipedia page', 'Reading,Fun'),
('Los 600 de Latinoamérica', 'https://www.600discoslatam.com/', 'The best 600 music albums from LatinoAmerica', 'Music,Reading'),
('Mariocube', 'https://mariocube.com/', 'Archival of Nintendo goodies from the 2000s', 'Video Games,Internet,Archive'),
('Name Generator', 'https://www.name-generator.org.uk/', 'Generate random names.', 'Tools,Internet,Fun,Writing'),
('Name that Color', 'https://chir.ag/projects/name-that-color/', 'Select a color and it will find the closest name to it.', 'Tools,Art,Fun,Writing'),
('Newgrounds Wiki: Creator Resources', 'https://newgrounds.com/wiki/creator-resources', 'Resources for Newgrounds creators.', 'Tools,Internet,Development,Video Games,Art,Music,Reading'),
('OpenToonz', 'https://www.opentoonz.org/', 'OpenToonz is a free and open source animation program. ', 'Software,Animation'),
('OTP Prompt Generator', 'https://otppromps.neocities.org/', 'Generate OTP prompts.', 'Tools,Internet,Fun,Writing'),
('Picmix', 'https://en.picmix.com/', 'Blingee alternative ', 'Tools,Internet,Art'),
('Picryl', 'https://picryl.com/', 'A website to search for images.', 'Tools,Internet,Art'),
('POSEMANIACS', 'https://www.posemaniacs.com', 'Posemaniacs.com is a royalty free pose reference for all artists.', 'Tools,Art'),
('Proyect Gutenberg', 'https://www.gutenberg.org/', 'A website to search for books.', 'Reading,Archive'),
('Reference Angle', 'http://referenceangle.com', 'Searches pictures of faces based off the position of a 3d model.', 'Tools,Art'),
('RefSeek', 'https://www.refseek.com/', 'RefSeek is a web search engine for students and researchers that aims to make academic information easily accessible to everyone. ', 'Tools,Reading'),
('Resources List for the Personal Web', 'https://discourse.32bit.cafe/t/resources-list-for-the-personal-web/49', 'Resources for the personal web.', 'Tools,Internet,Development'),
('Ruffle', 'https://ruffle.rs/', 'Flash player emulator.', 'Software,Tools'),
('Shinigami Eyes', 'https://shinigami-eyes.github.io/', 'A browser addon that highlights transphobic and trans-friendly social network pages and users with different colors. ', 'Tools'),
('Skelux Flash', 'http://skelux.net/flash.php', 'Flash games archive.', 'Tools,Internet,Video Games'),
('Springhole', 'https://www.springhole.net/index.html', 'A place for writers, roleplayers, artists, and other creative people to find help, inspiration, or just some fun! ', 'Tools,Internet,Writing,Art'),
('Starmen.net', 'https://starmen.net/index.php', 'Starmen.net is a large fansite and community based on the somewhat overlooked Mother/EarthBound series of video games.', 'Internet,Video Games'),
('Templatemaker.nl', 'https://templatemaker.nl/', 'Templatemaker.nl is a website to create templates.', 'Tools'),
('The Odin Project', 'https://www.theodinproject.com/', 'Online courses for Web Development, no login needed', 'Development,Reading'),
('The Oldschool PC Font Resource', 'https://int10h.org/oldschool-pc-fonts/fontlist', 'The Oldschool PC Font Resource is a website to search for fonts.', 'Tools,Internet,Art'),
('tinytools.directory', 'https://tinytools.directory/', 'tinytools.directory is a website to search for tools.', 'Tools,Internet,Directory'),
('Tip of my Tongue', 'https://chir.ag/projects/tip-of-my-tongue/', 'Find that word that you''ve been thinking about all day but just can''t seem to remember.', 'Tools,Writing'),
('Tomodachi Life Save Editor', 'https://github.com/Brionjv/Tomodachi-Life-Save-Editor/', 'A save editor for Tomodachi Life. ', 'Tools,Video Games'),
('Transparent Textures', 'https://www.transparenttextures.com/', 'Transparent Textures for any of your Texture Needs!', 'Tools,Art'),
('uBlock Origin', 'https://ublockorigin.com/', 'A free and open source ad blocker. ', 'Tools,Internet'),
('Universal Android Debloater', 'https://github.com/0x192/universal-android-debloater', 'Deletes software one may not be able to get rid otherwise (android)', 'Tools'),
('vern', 'https://vern.cc', '~vern is a non-commercial tilde focused on free software and services!', 'Tools,Internet,Make Corpos Angry'),
('Vimm´s Lair ', 'https://vimm.net/', 'Videogame archival website.', 'Video Games,Archive'),
('W3Schools', 'https://www.w3schools.com/', 'W3Schools is a website to learn HTML, CSS, JavaScript, and more.', 'Tools,Internet,Development'),
('Wolframalpha', 'https://www.wolframalpha.com/', 'Compute expert-level answers using Wolfram''s breakthrough algorithms, knowledgebase and AI technology.', 'Tools,Internet'),
('XYZ.CRD.CO', 'https://xyz.crd.co/', 'Graphics Collection', 'Art,Internet,Archive'),
('ZineWorld', 'http://zineworld.org/index.html', 'Archive of the eponymous zine ', 'Reading,Archive'),
('fluffmoth''d id buttons', 'https://idbuttons.neocities.org/', 'tiny identity buttons', 'Archive,Internet');

create table if not exists portfolio(
    id INT AUTO_INCREMENT PRIMARY KEY,
    year int not null,
    number int not null,
    intellectual_property TEXT NOT NULL,
    pictures_url VARCHAR(255) NOT NULL
);

-- Insert portfolio items from existing galeria images
INSERT INTO portfolio (year, number, intellectual_property, pictures_url) VALUES
(2023, 1, 'Original Character', '/img/portfolio/2023(1).webp'),
(2023, 2, 'Eddsworld', '/img/portfolio/2023(2).webp'),
(2023, 3, 'Original Character', '/img/portfolio/2023(3).webp'),
(2023, 4, 'Eddsworld', '/img/portfolio/2023(4).webp'),
(2023, 5, 'Original Character', '/img/portfolio/2023(5).webp'),
(2023, 6, 'Original Character', '/img/portfolio/2023(6).webp'),
(2023, 7, 'Eddsworld & Dead Space', '/img/portfolio/2023(7).webp'),
(2024, 1, 'Original Character', '/img/portfolio/2024(1).webp'),
(2024, 2, 'Xenia', '/img/portfolio/2024(2).webp'),
(2024, 3, 'Eddsworld', '/img/portfolio/2024(3).webp'),
(2024, 4, 'Original Character', '/img/portfolio/2024(4).webp'),
(2024, 5, 'Anastasia "Nastya" Kreslina, of band IC3PEAK', '/img/portfolio/2024(5).webp'),
(2024, 6, 'Original Character', '/img/portfolio/2024(6).webp'),
(2024, 7, 'Original Character', '/img/portfolio/2024(7).webp'),
(2024, 8, 'Original Character', '/img/portfolio/2024(8).webp'),
(2025, 1, 'Original Character', '/img/portfolio/2025(1).webp'),
(2025, 2, 'Original Character', '/img/portfolio/2025(2).webp'),
(2025, 3, 'Original Character', '/img/portfolio/2025(3).webp'),
(2025, 4, 'Original Character', '/img/portfolio/2025(4).webp'),
(2025, 5, 'The Binding of Isaac', '/img/portfolio/2025(5).webp'),
(2025, 6, 'Original Character', '/img/portfolio/2025(6).webp');
