-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 09:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(72, 3, 'Gantz', 999, 1, 'manga-6.png'),
(74, 3, 'Bleach', 123, 2, 'manga-3.jpg'),
(77, 3, 'Vagabond', 599, 1, 'manga-7.png'),
(80, 1, 'Oyasumi Punpun', 666, 1, 'manga-8.jpg'),
(100, 1, 'D.Gray-Man', 640, 3, 'manga-29.jpeg'),
(101, 1, 'Claymore', 570, 3, 'manga-28.jpeg'),
(102, 3, 'Fire Punch', 120, 1, 'manga-10.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(21, 6, 'Luffy', '09398727050', 'luffy@gmail.com', 'cash on delivery', 'BLK 25 LOT 13 LAPAZ AVENUE, LAPAZ HOMES 2 PHASE 1, Philippines - 4109', 'Gantz (1)', 999, '15-Aug-2025', 'completed'),
(22, 6, 'Luffy', '09398727050', 'luffy@gmail.com', 'cash on delivery', 'BLK 25 LOT 13 LAPAZ AVENUE, LAPAZ HOMES 2 PHASE 1, Philippines - 123', 'Jojo part 7 (1), One Piece (1), Vagabond (1), Bleach (1)', 1702, '15-Aug-2025', 'pending'),
(23, 1, 'Justin                                  ', '096969696969', 'justin@gmail.com', 'cash on delivery', 'BLK 666 LOT 999 TRECE LANG, Philippines - 4109', 'D.Gray-Man (1)', 640, '15-Aug-2025', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`) VALUES
(1, 'Vagabond', 599, 'The story starts in 1600, in the aftermath of the decisive Battle of Sekigahara. Two 17-year-old teenagers who joined the losing side, Takezō Shinmen and Matahachi Hon\'iden, lie wounded in the battlefield and pursued by survivor hunters. They manage to escape and swear to become \"Invincible Under The Heavens\" (天下無双, Tenka Musō). Their paths separate: Takezō decides to become a vagabond and wander the world challenging strong opponents, and Matahachi chooses to stay with women. Takezō returns to his hometown, the Miyamoto village, to tell Matahachi\'s mother, Osugi Hon\'iden, that her son is alive. However, Osugi reacts hostile because the village detests Takezō for his extremely violent and antisocial tendencies, and because the future of the Hon\'iden gentry family is compromised now that their heir Matahachi is missing. Osugi pulls strings to accuse Takezō of being a criminal. Takezō fights his pursuers but is eventually caught by the monk Takuan Sōhō, who makes him reconsider his purpose in life. Takuan frees him and, to make him start his life anew, renames after his hometown, Musashi of Miyamoto.', 'manga-7.png'),
(2, 'Gantz', 999, 'Gantz (stylized in all caps) is a Japanese manga series written and illustrated by Hiroya Oku. It was serialized in Shueisha\'s seinen manga magazine Weekly Young Jump from June 2000 to June 2013, with its chapters collected in 37 tankōbon volumes. It tells the story of Kei Kurono and Masaru Kato, both of whom died in a train accident and become part of a semi-posthumous \"game\" in which they and several other recently deceased people are forced to hunt down and kill aliens armed with a handful of futuristic items, equipment, and weaponry.\r\n\r\nAn anime television series adaptation, directed by Ichiro Itano and animated by Gonzo, was broadcast for 26 episodes, divided into two seasons, in 2004. A series of two live-action films based on the manga were produced and released in January and April 2011. A CGI anime film, Gantz: O, was released in 2016.', 'manga-6.png'),
(3, 'Jojo part 7', 690, 'Steel Ball Run (Japanese: スティール・ボール・ラン, Hepburn: Sutīru Bōru Ran) (stylized in all caps when written in Latin script) is the seventh main story arc of the Japanese manga series JoJo\'s Bizarre Adventure, written and illustrated by Hirohiko Araki. Set in the United States in 1890, it follows the journey of Johnny Joestar, a paraplegic former jockey who desires to regain the use of his legs, and Gyro Zeppeli, a disgraced Neapolitan former executioner who seeks to win amnesty for a child on death row. They compete in the titular cross-country horse race for a $50 million grand prize, but find themselves targeted after discovering the hidden agenda of the race\'s sponsor.', 'manga-5.jpg'),
(4, 'One Piece', 911, 'One Piece is a Japanese manga series written and illustrated by Eiichiro Oda. It follows the adventures of Monkey D. Luffy and his crew, the Straw Hat Pirates, as he explores the Grand Line in search of the mythical treasure known as the \"One Piece\" to become the next King of the Pirates.\r\n\r\nThe manga has been serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump since July 1997, with its chapters compiled in 111 tankōbon volumes as of March 2025. It was licensed for an English language release in North America and the United Kingdom by Viz Media and in Australia by Madman Entertainment. Becoming a media franchise, it has been adapted into a festival film by Production I.G, and an anime series by Toei Animation, which began broadcasting in 1999. Additionally, Toei has developed 14 animated feature films and one original video animation. Several companies have developed various types of merchandising and media, such as a trading card game and video games. Netflix released a live action TV series adaptation in 2023.', 'manga-1.jpg'),
(5, 'Bleach', 123, 'Bleach is a Japanese manga series written and illustrated by Tite Kubo. It follows the adventures of teenager Ichigo Kurosaki, who obtains the powers of a Soul Reaper—a death personification similar to a Grim Reaper—from another Soul Reaper, Rukia Kuchiki. His new-found powers allow him to take on the duties of defending humans from evil spirits called Hollows and guiding departed souls to the afterlife, and set him on journeys to various ghostly realms of existence.\r\n\r\nBleach was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from August 2001 to August 2016, with its chapters collected in 74 tankōbon volumes. The series has spawned a media franchise that includes an anime television series adaptation produced by studio Pierrot from 2004 to 2012, two original video animation (OVA) episodes, four animated feature films, ten stage musicals, and numerous video games, as well as many types of Bleach-related merchandise. A Japanese live-action film adaptation produced by Warner Bros. premiered in 2018. A sequel to the anime television series, which adapts the manga\'s final story arc, premiered in 2022.', 'manga-3.jpg'),
(6, 'Naruto', 450, 'Naruto is a Japanese manga series written and illustrated by Masashi Kishimoto. It tells the story of Naruto Uzumaki, a young ninja who seeks recognition from his peers and dreams of becoming the Hokage, the leader of his village. The story is told in two parts: the first is set in Naruto\'s pre-teen years (volumes 1–27), and the second in his teens (volumes 28–72). The series is based on two one-shot manga by Kishimoto: Karakuri (1995), which earned Kishimoto an honorable mention in Shueisha\'s monthly Hop Step Award the following year, and Naruto (1997).\r\n\r\nNaruto was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from September 1999 to November 2014, with its 700 chapters collected in 72 tankōbon volumes. Viz Media licensed the manga for North American production and serialized Naruto in their digital Weekly Shonen Jump magazine. The manga was adapted into two anime television series by Pierrot and Aniplex, which ran from October 2002 to March 2017 on TV Tokyo. Pierrot also produced 11 animated films and 12 original video animations (OVAs). The franchise also includes light novels, video games, and trading cards. The story continues in Boruto, where Naruto\'s son Boruto Uzumaki creates his own ninja path instead of following his father\'s.', 'manga-2.jpeg'),
(7, 'Dragon Ball', 642, 'Dragon Ball (Japanese: ドラゴンボール, Hepburn: Doragon Bōru) is a Japanese media franchise created by Akira Toriyama. The initial manga, written and illustrated by Toriyama, was serialized in Weekly Shōnen Jump from 1984 to 1995, with the 519 individual chapters collected in 42 tankōbon volumes by its publisher Shueisha. Dragon Ball was originally inspired by the classical 16th-century Chinese novel Journey to the West, combined with elements of Hong Kong martial arts films. Dragon Ball characters also use a variety of East Asian martial arts styles, including karate[1][2][3] and Wing Chun (kung fu).[2][3][4] The series follows the adventures of protagonist Son Goku from his childhood through adulthood as he trains in martial arts. He spends his childhood far from civilization until he meets a teen girl named Bulma, who encourages him to join her quest in exploring the world in search of the seven orbs known as the Dragon Balls, which summon a wish-granting dragon when gathered. Along his journey, Goku makes several other friends, becomes a family man, discovers his alien heritage, and battles a wide variety of villains, many of whom also seek the Dragon Balls.', 'manga-4.png'),
(8, 'Oyasumi Punpun', 666, 'Goodnight Punpun (Japanese: おやすみプンプン, Hepburn: Oyasumi Punpun) is a Japanese manga series written and illustrated by Inio Asano. It was originally serialized in Shogakukan\'s seinen manga magazine Weekly Young Sunday between 2007 and 2008, and was transferred to Weekly Big Comic Spirits, where it ran from 2008 to 2013. Its chapters were collected in thirteen tankōbon volumes. In North America, it was licensed for English release by Viz Media.\r\n\r\nA coming-of-age drama story, it follows the life of a child named Onodera Punpun, from his elementary school years to his early 20s, as he copes with his dysfunctional family, love life, friends, life goals and hyperactive mind, while occasionally focusing on the lives and struggles of his schoolmates and family. Punpun and the members of his family are normal humans, but are depicted to the reader in the form of crudely drawn birds. The manga explores themes such as depression, love, trauma, social isolation, death, and family.', 'manga-8.jpg'),
(9, 'Berserk', 187, 'Berserk (Japanese: ベルセルク, Hepburn: Beruseruku) is a Japanese manga series written and illustrated by Kentaro Miura. Set in a medieval Europe–inspired dark fantasy world, the story centers on the characters of Guts, a lone swordsman, and Griffith, the leader of a mercenary band called the \"Band of the Hawk\". The series follows Guts\' journey seeking revenge on Griffith, who betrayed him and the rest of their comrades.\r\n\r\nMiura premiered a prototype of Berserk in 1988. The series began the following year in Hakusensha\'s seinen manga magazine Monthly Animal House [ja], which was replaced in 1992 by the semimonthly magazine Young Animal, where Berserk has continued its publication. Following Miura\'s death in May 2021, the final chapter that he worked on was published posthumously in September of the same year; the series resumed in June 2022, under supervision of Miura\'s fellow manga artist and childhood friend Kouji Mori [ja] and Miura\'s group of assistants and apprentices from Studio Gaga.', 'manga-9.jpeg'),
(10, 'Fire Punch', 120, 'Fire Punch (Japanese: ファイアパンチ, Hepburn: Faia Panchi) is a Japanese web manga series written and illustrated by Tatsuki Fujimoto. It was serialized through Shueisha\'s Shōnen Jump+ website from April 2016 to January 2018, with its chapters collected in eight tankōbon volumes. In North America, Viz Media licensed the manga for English release.\r\n\r\nFire Punch takes place on an Earth that has become frozen over and barren. The series follows Agni, a young man who is able to regenerate his body. After his village succumbs to inextinguishable flames he is left constantly on fire, leaving him in anguish and vowing to get revenge.', 'manga-10.jpeg'),
(12, 'Death Note', 480, 'Death Note is a Japanese manga series written by Tsugumi Ohba and illustrated by Takeshi Obata. It was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from December 2003 to May 2006, with its chapters collected in 12 tankōbon volumes. The story follows Light Yagami, a genius high school student who discovers a mysterious notebook: the \"Death Note\", which belonged to the shinigami Ryuk, and grants the user the supernatural ability to kill anyone whose name is written in its pages. The series centers around Light\'s subsequent use of the Death Note to carry out a worldwide massacre of individuals whom he deems immoral and to create a crime-free society, using the alias of a god-like vigilante named \"Kira\", and the subsequent efforts of an elite Japanese police task force, led by enigmatic detective L, to apprehend him.', 'manga-12.jpeg'),
(13, 'Attack on Titan', 799, 'Attack on Titan (Japanese: 進撃の巨人, Hepburn: Shingeki no Kyojin; lit. \'The Advancing Giant\') is a Japanese manga series written and illustrated by Hajime Isayama. Set in a world where humanity is forced to live in cities surrounded by three enormous walls that protect them from gigantic man-eating humanoids referred to as Titans, the story follows Eren Yeager, an adolescent boy who vows to exterminate the Titans after they bring about the destruction of his hometown and the death of his mother. It was serialized in Kodansha\'s monthly magazine Bessatsu Shōnen Magazine from September 2009 to April 2021, with its chapters collected in 34 tankōbon volumes.', 'manga-13.jpeg'),
(14, 'Fullmetal Alchemist', 620, 'Fullmetal Alchemist (Japanese: 鋼の錬金術師, Hepburn: Hagane no Renkinjutsushi; lit. \"Alchemist of Steel\") is a Japanese manga series written and illustrated by Hiromu Arakawa. It was serialized in Square Enix\'s shōnen manga anthology magazine Monthly Shōnen Gangan between July 2001 and June 2010; the publisher later collected the individual chapters in 27 tankōbon volumes. Set in a fictional universe in which alchemy is a widely practiced science, the series follows the journey of two alchemist brothers, Edward and Alphonse Elric, as they search for the philosopher\'s stone to restore their bodies after a failed attempt to bring their mother back to life using alchemy. The steampunk world of Fullmetal Alchemist is primarily styled after the European Industrial Revolution.', 'manga-14.jpeg'),
(15, 'Tokyo Ghoul', 700, 'Tokyo Ghoul (Japanese: 東京喰種トーキョーグール, Hepburn: Tōkyō Gūru) is a Japanese dark fantasy manga series written and illustrated by Sui Ishida. It was serialized in Shueisha\'s seinen manga magazine Weekly Young Jump from September 2011 to September 2014, with its chapters collected in 14 tankōbon volumes. The manga has been licensed for English release in North America by Viz Media.\r\n\r\nThe story is set in an alternate version of Tokyo where humans coexist with ghouls, beings who look like humans but can only survive by eating human flesh. Ken Kaneki is a college student who is transformed into a half-ghoul after an encounter with one of them. He must navigate the complex social and political dynamics between humans and ghouls while struggling to maintain his humanity.\r\n\r\nA prequel, titled Tokyo Ghoul [Jack], ran online on Jump Live in 2013, with its chapters collected in a single tankōbon volume. A sequel, titled Tokyo Ghoul:re, was serialized in Weekly Young Jump from October 2014 to July 2018, its chapters were collected in 16 tankōbon volumes.', 'manga-15.jpeg'),
(16, 'Hunter x Hunter', 530, 'Hunter × Hunter (pronounced \"hunter hunter\"[4]) is a Japanese manga series written and illustrated by Yoshihiro Togashi. It has been serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump since March 1998, although the manga has frequently gone on extended hiatuses since 2006. Its chapters have been collected in 38 tankōbon volumes as of September 2024. The story focuses on a young boy named Gon Freecss who discovers that his father, who left him at a young age, is actually a world-renowned Hunter, a licensed professional who specializes in fantastical pursuits such as locating rare or unidentified animal species, treasure hunting, surveying unexplored enclaves, or hunting down lawless individuals. Gon departs on a journey to become a Hunter and eventually find his father. Along the way, Gon meets various other Hunters and encounters the paranormal.', 'manga-16.jpeg'),
(17, 'Black Clover', 590, 'Black Clover (Japanese: ブラッククローバー, Hepburn: Burakku Kurōbā) is a Japanese manga series written and illustrated by Yūki Tabata. It started in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump in February 2015. The series ran in the magazine until August 2023, and moved to Jump Giga in December of the same year. Its chapters have been collected in 36 tankōbon volumes as of February 2024. Set in a world where people are born with the ability to use magic, the story follows Asta, a young boy without any magic power who is given a rare grimoire that grants him anti-magic abilities. With his fellow mages from the Black Bulls, Asta plans to become the next Wizard King.', 'manga-17.jpeg'),
(18, 'Fairy Tail', 640, 'Fairy Tail is a Japanese manga series written and illustrated by Hiro Mashima. It was serialized in Kodansha\'s Weekly Shōnen Magazine from August 2006 to July 2017, with the individual chapters collected and published into 63 tankōbon volumes. The story follows the adventures of Natsu Dragneel, a member of the popular wizard[b] guild Fairy Tail, as he searches the fictional world of Earth-land for the dragon Igneel.\r\n\r\nThe manga has been adapted into an anime series by A-1 Pictures, Dentsu Inc., Satelight, Bridge, and CloverWorks which was broadcast in Japan on TV Tokyo from October 2009 to March 2013. A second series was broadcast from April 2014 to March 2016. A third and final series was aired from October 2018 to September 2019. The series has also inspired numerous spin-off manga, including a prequel by Mashima, Fairy Tail Zero, and a sequel storyboarded by him, titled Fairy Tail: 100 Years Quest. Additionally, A-1 Pictures has developed nine original video animations and two animated feature films.', 'manga-18.jpeg'),
(19, 'Blue Lock', 560, 'Blue Lock (Japanese: ブルーロック, Hepburn: Burū Rokku) (stylized as BLUELOCK) is a Japanese manga series written by Muneyuki Kaneshiro and illustrated by Yusuke Nomura [ja]. It has been serialized in Kodansha\'s Weekly Shōnen Magazine since August 2018, with its chapters collected in 35 tankōbon volumes as of August 2025.\r\n\r\nAn anime television series adaptation produced by Eight Bit aired from October 2022 to March 2023. An anime film adaptation based on the Episode Nagi spin-off manga premiered in April 2024. A second season, subtitled vs. U-20 Japan, aired from October to December 2024.\r\n\r\nBy March 2025, the manga had over 45 million copies in circulation worldwide, making it one of the best-selling manga series of all time. In 2021, Blue Lock won the 45th Kodansha Manga Award in the shōnen category.', 'manga-19.jpeg'),
(20, 'Jujutsu Kaisen', 750, 'Jujutsu Kaisen (呪術廻戦; rgh. \'Sorcery Battle\'[a]) is a Japanese manga series written and illustrated by Gege Akutami. It was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from March 2018 to September 2024, with its chapters collected in 30 tankōbon volumes. The story follows high school student Yuji Itadori as he joins a secret organization of Jujutsu Sorcerers to eliminate a powerful Curse named Ryomen Sukuna, of whom Yuji becomes the host. Jujutsu Kaisen is a sequel to Akutami\'s Tokyo Metropolitan Curse Technical School, serialized in Shueisha\'s Jump Giga from April to July 2017, later collected in a single tankōbon volume, retroactively titled as Jujutsu Kaisen 0, in December 2018.\r\n\r\nJujutsu Kaisen is licensed for English-language release in North America by Viz Media, which has published the manga in print since December 2019. Shueisha publishes the series in English on the Manga Plus online platform. Two novels, written by Ballad Kitaguni, were published in May 2019 and January 2020, respectively. An anime television series adaptation, produced by MAPPA, aired its first season on MBS from October 2020 to March 2021; a second season aired from July to December 2023. A sequel covering the \"Culling Game\" arc has been announced.\r\n\r\nBy September 2024, the Jujutsu Kaisen manga had over 100 million copies in circulation, including related novels, digital versions, and Jujutsu Kaisen 0, making it one of the best-selling manga series of all time.', 'manga-20.jpeg'),
(21, 'Solo Leveling', 880, 'Jujutsu Kaisen (呪術廻戦; rgh. \'Sorcery Battle\'[a]) is a Japanese manga series written and illustrated by Gege Akutami. It was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from March 2018 to September 2024, with its chapters collected in 30 tankōbon volumes. The story follows high school student Yuji Itadori as he joins a secret organization of Jujutsu Sorcerers to eliminate a powerful Curse named Ryomen Sukuna, of whom Yuji becomes the host. Jujutsu Kaisen is a sequel to Akutami\'s Tokyo Metropolitan Curse Technical School, serialized in Shueisha\'s Jump Giga from April to July 2017, later collected in a single tankōbon volume, retroactively titled as Jujutsu Kaisen 0, in December 2018.\r\n\r\nJujutsu Kaisen is licensed for English-language release in North America by Viz Media, which has published the manga in print since December 2019. Shueisha publishes the series in English on the Manga Plus online platform. Two novels, written by Ballad Kitaguni, were published in May 2019 and January 2020, respectively. An anime television series adaptation, produced by MAPPA, aired its first season on MBS from October 2020 to March 2021; a second season aired from July to December 2023. A sequel covering the \"Culling Game\" arc has been announced.\r\n\r\nBy September 2024, the Jujutsu Kaisen manga had over 100 million copies in circulation, including related novels, digital versions, and Jujutsu Kaisen 0, making it one of the best-selling manga series of all time.', 'manga-21.jpg'),
(22, 'The Promised Neverland', 670, 'The Promised Neverland (Japanese: 約束のネバーランド, Hepburn: Yakusoku no Nebārando) is a Japanese manga series written by Kaiu Shirai and illustrated by Posuka Demizu. It was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from August 2016 to June 2020, with its chapters collected in 20 tankōbon volumes. In North America, Viz Media licensed the manga for English release and serialized it on their digital Weekly Shonen Jump magazine. The series follows a group of orphaned children in their plan to escape from their orphanage, after learning the dark truth behind their existence and the purpose of the orphanage.', 'manga-22.jpeg'),
(23, 'Homunculus', 600, 'Homunculus (Japanese: ホムンクルス, Hepburn: Homunkurusu) is a Japanese manga series written and illustrated by Hideo Yamamoto. It was serialized in Shogakukan\'s seinen manga magazine Weekly Big Comic Spirits from March 2003 to February 2011, with its chapters collected in 15 tankōbon volumes. A live-action film adaptation, directed by Takashi Shimizu and starring Gō Ayano premiered in April 2021.', 'manga-23.jpeg'),
(24, 'Parasyte', 600, 'Parasyte (Japanese: 寄生獣, Hepburn: Kiseijū; lit. \'Parasitic Beasts\') is a Japanese science fiction horror manga series written and illustrated by Hitoshi Iwaaki. It was published in Kodansha\'s Morning Open Zōkan (1989) and Monthly Afternoon (1989 to 1994). The manga was published in North America first by Tokyopop, then Del Rey, and finally Kodansha USA. The series follows Shinichi Izumi, a high school senior who is the victim of a failed attempt by a parasitic organism to take over his brain. The parasite, Migi, instead infects and takes over his arm, and both are forced in a peculiar partnership to fight other parasites.', 'manga-24.jpeg'),
(25, 'Vinland Saga', 950, 'Vinland Saga (Japanese: ヴィンランド・サガ, Hepburn: Vinrando Saga) is a Japanese manga series written and illustrated by Makoto Yukimura. The series is published by Kodansha, and was first serialized in the boys-targeted manga magazine Weekly Shōnen Magazine from April to October 2005 before moving to Monthly Afternoon, aimed at young adult men, where it ran from December 2005 to July 2025. As of June 2024, its chapters have been collected in 28 tankōbon volumes. Vinland Saga has been licensed for English-language publication by Kodansha USA. The story is a dramatization of the story of Thorfinn Karlsefni and his expedition to find Vinland, with the majority of the story covering his fictional counterpart\'s transition from a bloodthirsty, revenge-filled teenager into a pacifistic young man; juxtaposed against this is the rise to power of King Canute, the journey of his own counterpart directly contrasting with that of Thorfinn\'s.', 'manga-25.jpeg'),
(26, 'Devilman Crybaby', 610, 'Devilman Crybaby is a 2018 Japanese original net animation (ONA) series based on Go Nagai\'s manga series Devilman. The web anime is directed by Masaaki Yuasa, produced by Aniplex and Dynamic Planning, animated by Science Saru, and released by Netflix. Yuasa was offered the opportunity to create a Devilman project by Aniplex, and envisioned Devilman Crybaby. Announced in 2017 to mark Nagai\'s 50th anniversary as a creator, Crybaby was made available for worldwide streaming on January 5, 2018, as a Netflix original series.', 'manga-26.jpeg'),
(27, 'Neon Genesis Evangelion', 890, 'Neon Genesis Evangelion (Japanese: 新世紀エヴァンゲリオン, Hepburn: Shinseiki Evangerion; lit. \'New Century Evangelion\' in Japanese and lit. \'New Beginning Gospel\' in Greek), also known as Evangelion or Eva, is a Japanese anime television series produced by Gainax and Tatsunoko Production, and directed by Hideaki Anno. It was broadcast on TV Tokyo and its affiliates from October 1995 to March 1996. The story, set fifteen years after a worldwide cataclysm in the futuristic fortified city of Tokyo-3, follows Shinji Ikari, a teenage boy who is recruited by his father Gendo Ikari to the mysterious organization Nerv. Shinji must pilot an Evangelion, a giant biomechanical mecha, to fight beings known as Angels.', 'manga-27.jpeg'),
(28, 'Claymore', 570, 'Claymore (stylized in all caps) is a Japanese dark fantasy manga series written and illustrated by Norihiro Yagi. It debuted in Shueisha\'s shōnen manga magazine Monthly Shōnen Jump in June 2001, where it continued until the magazine was shut down in June 2007. The series was transferred to the newly launched Jump Square, serialized from November 2007 to October 2014. Its chapters were collected in 27 tankōbon volumes.\r\n\r\nA 26-episode anime television series adaptation by Madhouse was broadcast on Nippon Television from April to September 2007. A CD soundtrack for the anime and a CD of character songs using its voice actresses were released in July and September 2007, respectively.\r\n\r\nThe Claymore manga was licensed for English release in North America by Viz Media and released its 27 volumes from April 2006 to October 2015. The anime adaptation was licensed for release in North America by Funimation. Madman Entertainment has licensed the anime for release in Australia and New Zealand and the anime is sub-licensed by Manga Entertainment for UK distribution.', 'manga-28.jpeg'),
(29, 'D.Gray-Man', 640, 'D.Gray-man is a Japanese manga series written and illustrated by Katsura Hoshino. Set in an alternate 19th century, it tells the story of a young Allen Walker, who joins an organization of exorcists named the Black Order. They use an ancient substance, Innocence, to combat a man known as the Millennium Earl and his demonic army of Akuma who intend to destroy humanity. Many characters are adapted from Hoshino\'s previous works and drafts, such as Zone. The series is noted for its dark narrative; Hoshino once rewrote a scene she thought too violent for her young readers.\r\n\r\nThe manga started serialization in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump in May 2004. Production of the series was suspended several times due to Hoshino\'s health problems. D.Gray-man made the transition from a weekly to a monthly series in November 2009, when it began serialization in Jump Square. In January 2013, the series went on indefinite hiatus. It resumed serialization in July 2015 after the release of Jump SQ.Crown, a spin-off from the magazine Jump SQ. After Jump SQ.Crown ceased publication, the series was switched to Jump SQ.Rise, starting in April 2018. The manga\'s chapters have been collected in 29 tankōbon volumes as of July 2025. The manga is licensed for English release in North America by Viz Media, which has released 28 volumes by November 2023.', 'manga-29.jpeg'),
(30, 'Trigun', 760, 'Trigun (Japanese: トライガン, Hepburn: Toraigan) is a Japanese manga series written and illustrated by Yasuhiro Nightow. It was first serialized in Tokuma Shoten\'s shōnen manga magazine Monthly Shōnen Captain from March 1995 to December 1996, until the magazine ceased its publication; its chapters were collected in three tankōbon volumes. The series continued its publication in Shōnen Gahosha\'s seinen manga magazine Young King OURs, under the title Trigun Maximum, from October 1997 to March 2007. Shōnen Gahosha republished the Trigun chapters in two volumes, and collected the Trigun Maximum chapters in 14 volumes.', 'manga-30.jpeg'),
(31, 'Chainsaw Man', 550, 'Chainsaw Man (Japanese: チェンソーマン, Hepburn: Chensō Man) is a Japanese manga series written and illustrated by Tatsuki Fujimoto. Its first arc was serialized in Shueisha\'s shōnen manga magazine Weekly Shōnen Jump from December 2018 to December 2020; its second arc began serialization in Shueisha\'s Shōnen Jump+ app and website in July 2022. Its chapters have been collected in 21 tankōbon volumes as of July 2025.\r\n\r\nChainsaw Man follows the story of Denji, an impoverished teenager who makes a contract that fuses his body with that of Pochita, the dog-like Chainsaw Devil, granting him the ability to transform parts of his body into chainsaws. Denji eventually joins the Public Safety Devil Hunters, a government agency focused on combating Devils whenever they become a threat to Japan. The second arc of the story focuses on Asa Mitaka, a high school student who enters into a contract with Yoru, the War Devil, who forces her to hunt down Chainsaw Man in order to reclaim what he had stolen from her.', 'manga-11.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Justin                                  ', 'justin@gmail.com', '1c913d9d4939ef87d16e46cd545036c3', 'user'),
(2, 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(3, 'Christian Rafhael Carlos', 'rafhaelcarlos78@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(4, 'raf', 'raf@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(6, 'Luffy', 'luffy@gmail.com', '202cb962ac59075b964b07152d234b70', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `profile_image` varchar(255) DEFAULT 'images/profile-user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `user_id`, `name`, `number`, `address`, `profile_image`) VALUES
(1, 4, 'Raf', '0922222294', 'dyan dyan lang', 'images/profile-user.png'),
(2, 1, 'pogi lang', '096969696969', 'BLK 666 LOT 999 TRECE LANG\r\n', 'pic-3.png'),
(3, 6, '', '09398727050', 'BLK 25 LOT 13 LAPAZ AVENUE, LAPAZ HOMES 2 PHASE 1', 'pic-3.png'),
(4, 3, '', '09063610857', 'Block 64 Lot 12 Phase 2 WestPoint', '1755585291_rafhael.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
