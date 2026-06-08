-- ============================================================
-- Attack On Titan Website Database
-- Database: aot_website
-- ============================================================

CREATE DATABASE IF NOT EXISTS aot_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aot_website;

-- ============================================================
-- Table: users
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Table: homepage
-- ============================================================
CREATE TABLE IF NOT EXISTS homepage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    subtitle VARCHAR(300),
    banner_image VARCHAR(255),
    description TEXT
) ENGINE=InnoDB;

-- ============================================================
-- Table: seasons
-- ============================================================
CREATE TABLE IF NOT EXISTS seasons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    season_number INT NOT NULL,
    description TEXT,
    synopsis TEXT,
    characters_featured TEXT,
    key_events TEXT,
    image VARCHAR(255),
    release_year INT,
    rating DECIMAL(3,1),
    studio VARCHAR(100),
    episode_count INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Table: characters
-- ============================================================
CREATE TABLE IF NOT EXISTS characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    description TEXT,
    biodata TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Table: creator
-- ============================================================
CREATE TABLE IF NOT EXISTS creator (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    biography TEXT,
    career_journey TEXT,
    influence TEXT
) ENGINE=InnoDB;

-- ============================================================
-- Default Admin User (password: admin123)
-- ============================================================
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@aotwebsite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- NOTE: The hash above is for 'password' (Laravel default). Replace with actual bcrypt hash.
-- Run this PHP to get hash for 'admin123':
-- echo password_hash('admin123', PASSWORD_DEFAULT);

-- ============================================================
-- Homepage Default Data
-- ============================================================
INSERT INTO homepage (title, subtitle, banner_image, description) VALUES
(
    'Attack On Titan',
    'Shingeki no Kyojin — The Story of Humanity\'s Last Stand',
    'banner.jpg',
    'In a world where humanity lives within enormous walled cities to protect themselves from Titans — gigantic humanoid creatures who devour humans seemingly without reason — the last remnants of civilization cling to survival. When the walls are breached and Eren Yeager witnesses the death of his mother, he vows to exterminate every last Titan from the face of the earth.'
);

-- ============================================================
-- Seasons Data
-- ============================================================
INSERT INTO seasons (title, season_number, description, synopsis, characters_featured, key_events, image, release_year, rating, studio, episode_count) VALUES
(
    'Season 1',
    1,
    'The first season introduces us to the world inside the walls, the Titans, and Eren Yeager\'s burning desire for revenge.',
    'After a Colossal Titan breaches Wall Maria, Eren Yeager witnesses the death of his mother. Years later, Eren, Mikasa, and Armin join the Survey Corps to fight back against the Titans. Eren discovers he has the ability to transform into a Titan himself, changing the course of humanity\'s battle.',
    'Eren Yeager, Mikasa Ackerman, Armin Arlert, Levi Ackerman, Erwin Smith, Hange Zoe',
    'Fall of Wall Maria, Death of Carla Yeager, Battle of Trost District, Eren\'s Titan transformation revealed, Female Titan arc',
    'season1.jpg',
    2013,
    9.0,
    'Wit Studio',
    25
),
(
    'Season 2',
    2,
    'Secrets behind the Titans are unveiled as the Survey Corps ventures outside the walls and discovers terrifying truths.',
    'The Survey Corps investigates the Wall Titans hidden within Wall Rose. Eren and his friends uncover shocking revelations about Warriors from Marley — Reiner Braun is the Armored Titan and Bertolt Hoover is the Colossal Titan.',
    'Eren Yeager, Mikasa Ackerman, Armin Arlert, Reiner Braun, Levi Ackerman, Historia Reiss',
    'Beast Titan appearance, Revelation of Armored and Colossal Titan identities, Battle of Utgard Castle, Eren vs Reiner fight',
    'season2.jpg',
    2017,
    9.1,
    'Wit Studio',
    12
),
(
    'Season 3 Part 1',
    3,
    'Political intrigue and internal conflict shake the Survey Corps as dark secrets about the Royal Government are exposed.',
    'The Survey Corps clashes with the Military Police and a mysterious group called the Ackerman clan. Historia\'s true identity as the heir to the throne is revealed. Kenny Ackerman hunts Levi and the Survey Corps.',
    'Eren Yeager, Mikasa Ackerman, Levi Ackerman, Historia Reiss, Kenny Ackerman, Erwin Smith',
    'Kenny Ackerman introduced, Historia\'s royal bloodline revealed, Capture of Eren and Historia, Uprising against the false king',
    'season3p1.jpg',
    2018,
    9.2,
    'Wit Studio',
    12
),
(
    'Season 3 Part 2',
    4,
    'The epic Battle of Shiganshina unfolds as the Survey Corps attempts to reclaim humanity\'s home and unlock the secrets in Grisha\'s basement.',
    'The Survey Corps returns to Shiganshina District to reclaim Wall Maria and reach Grisha Yeager\'s basement. The Beast Titan leads a devastating assault. Erwin Smith leads a suicidal charge. The basement reveals the truth about Titans and the outside world.',
    'Eren Yeager, Armin Arlert, Levi Ackerman, Erwin Smith, Reiner Braun, Zeke Yeager',
    'Battle of Shiganshina, Death of Erwin Smith, Armin becomes Colossal Titan, Basement secrets revealed — Titans are humans from Marley',
    'season3p2.jpg',
    2019,
    9.8,
    'Wit Studio',
    10
),
(
    'Season 4 Part 1',
    5,
    'The story shifts to Marley, revealing the world beyond the walls and Eren\'s transformed, darker mission.',
    'Four years after Shiganshina, the perspective shifts to Marley — the enemy nation. Reiner and Warriors fight in a global war. Eren infiltrates Marley undercover and launches a devastating attack on a Marleyan military ceremony, signaling a new, darker era.',
    'Eren Yeager, Reiner Braun, Zeke Yeager, Gabi Braun, Falco Grice, Mikasa Ackerman',
    'Introduction of Marley, Marley\'s global war, Eren\'s infiltration of Liberio, Attack on Liberio — Eren vs Jaw Titan',
    'season4p1.jpg',
    2020,
    9.0,
    'MAPPA',
    16
),
(
    'Season 4 Part 2',
    6,
    'Alliances crumble and are reforged as Eren activates the Rumbling — the ultimate weapon of mass destruction.',
    'Eren breaks free and rallies the Yeagerists. The alliance between Paradis and Marley collapses. Eren activates the Rumbling — unleashing millions of Wall Titans to flatten the world. Former enemies must unite to stop Eren before global genocide is complete.',
    'Eren Yeager, Mikasa Ackerman, Armin Arlert, Reiner Braun, Zeke Yeager, Hange Zoe',
    'Zeke\'s euthanasia plan, Eren unleashes the Rumbling, Yeagerists takeover, Hange\'s death, Alliance formed with Warriors',
    'season4p2.jpg',
    2022,
    9.1,
    'MAPPA',
    12
),
(
    'Season 4 Part 3 (1st Half)',
    7,
    'The alliance races to stop Eren\'s Rumbling as billions of lives hang in the balance.',
    'The alliance — Survey Corps and Warriors together — chase Eren\'s Rumbling across the world. Battles ensue. Sacrifices are made. The true scale of Eren\'s plan and his anguished motivations begin to surface.',
    'Eren Yeager, Mikasa Ackerman, Armin Arlert, Reiner Braun, Annie Leonhart, Levi Ackerman',
    'Alliance vs Yeagerists, Annie returns, Flight to Fort Salta, Battle above the Rumbling',
    'season4p3a.jpg',
    2023,
    9.3,
    'MAPPA',
    1
),
(
    'Season 4 Part 3 (2nd Half)',
    8,
    'The final confrontation — humanity\'s last stand against Eren Yeager and the Titans at Fort Salta.',
    'In the climactic finale, the alliance fights the Titan horde and Eren\'s ultimate Titan form. Armin leads a final desperate gamble. Mikasa makes the hardest choice of her life. The cycle of hatred comes to its tragic, inevitable end.',
    'Eren Yeager, Mikasa Ackerman, Armin Arlert, Reiner Braun, Levi Ackerman, Historia Reiss',
    'Final battle at Fort Salta, Armin\'s explosion plan, Mikasa kills Eren, End of the Titans, Aftermath and epilogue',
    'season4p3b.jpg',
    2023,
    9.5,
    'MAPPA',
    1
);

-- ============================================================
-- Characters Data
-- ============================================================
INSERT INTO characters (name, image, description, biodata) VALUES
(
    'Eren Yeager',
    'eren.jpg',
    'The main protagonist of Attack on Titan. Eren begins as a passionate, hot-headed boy driven by vengeance for his mother\'s death. Over time, he evolves into one of the most complex and tragic characters in anime history — a freedom fighter who crosses the line into becoming a genocidal villain in his pursuit of true freedom for his people.',
    'Age: 19 (final arc) | Height: 183cm | Affiliation: Survey Corps / Founding Titan | Titan Forms: Attack Titan, Founding Titan, War Hammer Titan | Status: Deceased'
),
(
    'Mikasa Ackerman',
    'mikasa.jpg',
    'One of the most skilled soldiers humanity has ever produced. Mikasa is calm, focused, and devastatingly lethal in combat. Her bond with Eren defines much of her journey, and her final choice — to kill Eren to stop the Rumbling — is one of the most emotionally devastating moments in the series.',
    'Age: 19 (final arc) | Height: 170cm | Affiliation: Survey Corps / Ackerman Clan | Skills: Master combatant, ODM gear expert | Status: Alive'
),
(
    'Armin Arlert',
    'armin.jpg',
    'Humanity\'s greatest strategic mind. Though physically average, Armin\'s brilliance in tactics and his ability to see beyond the battlefield make him indispensable. He inherits the Colossal Titan power and becomes Commander of the Survey Corps after the final battle.',
    'Age: 19 (final arc) | Height: 163cm | Affiliation: Survey Corps | Titan Form: Colossal Titan | Role: Commander, Strategist | Status: Alive'
),
(
    'Levi Ackerman',
    'levi.jpg',
    'Humanity\'s Strongest Soldier. Captain Levi is a man of few words but extraordinary action. His ODM combat skills are beyond any other human alive. Despite his cold exterior, Levi carries deep grief for every soldier lost under his command — making him one of the most respected and heartbreaking characters in the series.',
    'Age: 30s | Height: 160cm | Affiliation: Survey Corps, Special Operations Squad | Title: Humanity\'s Strongest Soldier | Status: Alive (severely wounded)'
),
(
    'Erwin Smith',
    'erwin.jpg',
    'The 13th Commander of the Survey Corps. Erwin is a brilliant, calculating leader who sacrifices everything — including his own humanity — for humanity\'s survival. His death at the Battle of Shiganshina, leading a suicidal charge against the Beast Titan, is regarded as one of the greatest moments in anime.',
    'Age: Late 30s | Height: 188cm | Affiliation: Survey Corps | Role: Commander | Status: Deceased (Battle of Shiganshina)'
),
(
    'Hange Zoe',
    'hange.jpg',
    'Section Commander and lead scientist of the Survey Corps. Hange\'s eccentric enthusiasm for Titan research masks a deeply capable military mind. As the 14th Commander after Erwin\'s death, Hange leads with heart and sacrifice — dying to hold off the Wall Titans during the final arc.',
    'Age: 30s | Height: 170cm | Affiliation: Survey Corps | Role: Commander, Lead Scientist | Status: Deceased'
),
(
    'Reiner Braun',
    'reiner.jpg',
    'One of the most tragic characters in the series. Reiner is a Marleyan Warrior who infiltrated Paradis as a spy, yet genuinely bonded with his comrades. Torn between his duty to Marley and his love for his Survey Corps friends, Reiner\'s psychological collapse mirrors the moral complexity at the heart of Attack on Titan.',
    'Age: 21 (final arc) | Height: 188cm | Affiliation: Marleyan Warriors | Titan Form: Armored Titan | Status: Alive'
),
(
    'Zeke Yeager',
    'zeke.jpg',
    'Eren\'s older half-brother and the Beast Titan. A figure of terrifying intelligence and power, Zeke\'s plan to "save" the Eldian people through euthanasia puts him in direct conflict with Eren\'s vision of freedom. His complex relationship with Eren drives the final arc\'s most profound philosophical questions.',
    'Age: 29 (final arc) | Height: 183cm | Affiliation: Marleyan Warriors | Titan Form: Beast Titan | Status: Deceased'
);

-- ============================================================
-- Creator Data
-- ============================================================
INSERT INTO creator (name, image, biography, career_journey, influence) VALUES
(
    'Hajime Isayama',
    'isayama.jpg',
    'Hajime Isayama (諫山創) was born on August 29, 1986, in Oyama, Hita, Ōita, Japan. Growing up in a rural mountain town, he found escape and inspiration in manga. From a young age, Isayama dreamed of creating a story that would leave an impact — a story about the terror of something vast and unstoppable, and humanity\'s defiant spirit in the face of overwhelming odds.\n\nHe enrolled at Kyushu Designer Gakuin in Fukuoka to study manga and design. Despite initial rejections from major publishers, his persistence led to Attack on Titan being serialized in Kodansha\'s Monthly Shōnen Magazine in September 2009. The series ran for 11 years and 34 volumes, concluding in April 2021.',
    'Isayama\'s early career was marked by rejection. His original drafts were turned down by Weekly Shōnen Jump before Kodansha recognized the story\'s dark, unconventional potential. When Attack on Titan debuted, it quickly became a cultural phenomenon. The anime adaptation by Wit Studio in 2013 brought the series to global audiences. By the time MAPPA completed the final season, Attack on Titan had sold over 140 million manga volumes worldwide — one of the best-selling manga series in history. Isayama has stated that his core fear of strangers and the outside world inspired the terror of the Titans.',
    'Attack on Titan fundamentally changed what mainstream anime and manga could achieve. Its willingness to kill beloved characters, subvert moral expectations, and tackle themes of war, imperialism, genocide, and cycles of hatred elevated the medium globally. Isayama\'s work demonstrated that shōnen manga could be as philosophically dense and emotionally devastating as literary fiction. The series inspired a generation of creators and changed how international audiences perceived anime and manga as an art form.'
);

-- ============================================================
-- End of SQL
-- ============================================================
