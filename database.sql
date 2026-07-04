CREATE DATABASE IF NOT EXISTS db_pengurus;

USE db_pengurus;

CREATE TABLE IF NOT EXISTS tbl_pengurus (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nama    VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50)  NOT NULL,
    divisi  ENUM(
                'PH',
                'Kaderisasi',
                'Humas',
                'Ristek',
                'Content Creator',
                'Keilmuan',
                'Programming',
                'Multimedia',
                'Sistem Robotika'
            ) NOT NULL,
    foto    VARCHAR(150) NULL
);

TRUNCATE TABLE tbl_pengurus;

INSERT INTO tbl_pengurus (nama, jabatan, divisi, foto) VALUES
('Angga Dwi Saputra', 'Ketua Umum', 'PH', 'ASSETS/FOTO PENGURUS/PH/Angga.png'),
('Mutia Nur Azizah', 'Wakil Ketua', 'PH', 'ASSETS/FOTO PENGURUS/PH/Mutia.png'),
('Ida Feriani Nurya', 'Sekretaris 1', 'PH', 'ASSETS/FOTO PENGURUS/PH/Ida.png'),
('Lilis Adi Pratiwi', 'Sekretaris 2', 'PH', 'ASSETS/FOTO PENGURUS/PH/lILIS.png'),
('Dwi Rizkia Ashari', 'Bendahara 1', 'PH', 'ASSETS/FOTO PENGURUS/PH/KIA.png'),
('Maylinda Eka Saputri', 'Bendahara 2', 'PH', 'ASSETS/FOTO PENGURUS/PH/AYA.png'),

('Nalendra Alamsyah Sutomo', 'Koordinator Kaderisasi', 'Kaderisasi', 'ASSETS/FOTO PENGURUS/KADERISASI/ALEN.png'),
('Diva Aura Jelita', 'Kaderisasi', 'Kaderisasi', 'ASSETS/FOTO PENGURUS/KADERISASI/DIVA AURA JELITA.JPG'),
('Mayada Beni Pratiwi', 'Kaderisasi', 'Kaderisasi', 'ASSETS/FOTO PENGURUS/KADERISASI/MAYADA.png'),
('Fondyta Putri Bercahya', 'Kaderisasi', 'Kaderisasi', 'ASSETS/FOTO PENGURUS/KADERISASI/POPON.png'),
('Radith Saifurrohman', 'Kaderisasi', 'Kaderisasi', 'ASSETS/FOTO PENGURUS/KADERISASI/IPUL.png'),
('Seneng Rahayu', 'Kaderisasi', 'Kaderisasi', 'ASSETS/FOTO PENGURUS/KADERISASI/AYU.png'),

('Nibras Asykar Zen', 'Koordinator Humas', 'Humas', 'ASSETS/FOTO PENGURUS/HUMAS/NIBRAS.png'),
('Dias Catur Putra', 'Humas', 'Humas', 'ASSETS/FOTO PENGURUS/HUMAS/CATUR.png'),
('Fajar Suci Lestari', 'Humas', 'Humas', 'ASSETS/FOTO PENGURUS/HUMAS/SUCI.png'),
('Lailatul Mauliyah', 'Humas', 'Humas', 'ASSETS/FOTO PENGURUS/HUMAS/LAILA.png'),
('Friska Amalia Putri', 'Humas', 'Humas', 'ASSETS/FOTO PENGURUS/HUMAS/FRISKA.png'),
('Tifa Fitriana', 'Humas', 'Humas', 'ASSETS/FOTO PENGURUS/HUMAS/TIFA.png'),

('Da\'i Gustiantoro', 'Koordinator Content', 'Content Creator', 'ASSETS/FOTO PENGURUS/CC/DA_I.png'),
('Rahmat Hidayat', 'Content', 'Content Creator', 'ASSETS/FOTO PENGURUS/CC/RAHMAT.png'),
('Yusuf Bahtiar', 'Content', 'Content Creator', 'ASSETS/FOTO PENGURUS/CC/YUSUF.png'),
('Dini Suci Inayatus Saniah', 'Content', 'Content Creator', 'ASSETS/FOTO PENGURUS/CC/DIN DIN.png'),
('Bagas Adhiel Firmansyah', 'Content', 'Content Creator', 'ASSETS/FOTO PENGURUS/CC/BAGAS.png'),
('Khansa Hasna Putri Karunia', 'Content', 'Content Creator', 'ASSETS/FOTO PENGURUS/CC/SASA.png'),

('Niha Octafiana Ramadhani', 'Koordinator Ristek', 'Ristek', 'ASSETS/FOTO PENGURUS/RISTEK/OCTAF.png'),
('M Bryan Kaska Nurhakim', 'Ristek', 'Ristek', 'ASSETS/FOTO PENGURUS/RISTEK/BRYAN.png'),
('Siti Halimah', 'Ristek', 'Ristek', 'ASSETS/FOTO PENGURUS/RISTEK/SITI.png'),
('Daway Rahmat Tinata', 'Ristek', 'Ristek', 'ASSETS/FOTO PENGURUS/RISTEK/DAWAY.png'),
('Livia Agnes Adwitiya', 'Ristek', 'Ristek', 'ASSETS/FOTO PENGURUS/RISTEK/LIPI.png'),
('Abidah Ardelia Kendra W', 'Ristek', 'Ristek', 'ASSETS/FOTO PENGURUS/RISTEK/ABIDAH.png'),

('Sofyan Khoiron Mukhlis', 'Koordinator Keilmuan', 'Keilmuan', 'ASSETS/FOTO PENGURUS/KEILMUAN/SOFYAN.png'),

('Rizky Julianto', 'Koordinator Programming', 'Programming', 'ASSETS/FOTO PENGURUS/PROGRAMMING/RIZJUL.png'),
('Rubben Mulyo Santoso', 'Programming', 'Programming', 'ASSETS/FOTO PENGURUS/PROGRAMMING/RUBBEN.png'),
('Rizki Triananda', 'Programming', 'Programming', 'ASSETS/FOTO PENGURUS/PROGRAMMING/RIZKI.png'),
('Faizurrohim Ramadhani', 'Programming', 'Programming', 'ASSETS/FOTO PENGURUS/PROGRAMMING/FAIZ.png'),
('Adzma Futra Al Falah', 'Programming', 'Programming', 'ASSETS/FOTO PENGURUS/PROGRAMMING/ADZMA.png'),

('Firdaus Purwantoro', 'Koordinator Multimedia', 'Multimedia', 'ASSETS/FOTO PENGURUS/Multimedia/idos.png'),
('Zaidan Haidar Syahputra', 'Multimedia', 'Multimedia', 'ASSETS/FOTO PENGURUS/Multimedia/ZAIDAN.png'),
('Kharisma Aprilia', 'Multimedia', 'Multimedia', 'ASSETS/FOTO PENGURUS/Multimedia/RISMA.png'),
('Vonny Pramadhanti', 'Multimedia', 'Multimedia', 'ASSETS/FOTO PENGURUS/Multimedia/vonny.png'),
('Fawwaz Zaharza Al Baihaqi', 'Multimedia', 'Multimedia', 'ASSETS/FOTO PENGURUS/Multimedia/fawwaz.png'),

('Shendy Fiilanzi', 'Koordinator Robotika', 'Sistem Robotika', 'ASSETS/FOTO PENGURUS/ROBOTIK/SHENDY.png'),
('Bagus Setiawan', 'Robotika', 'Sistem Robotika', 'ASSETS/FOTO PENGURUS/ROBOTIK/BAGUS.png'),
('Davy Irsyad Tulloh', 'Robotika', 'Sistem Robotika', 'ASSETS/FOTO PENGURUS/ROBOTIK/DAVY.png'),
('Febrian Bagus Utomo', 'Robotika', 'Sistem Robotika', 'ASSETS/FOTO PENGURUS/ROBOTIK/FEBRIAN.png');

CREATE TABLE IF NOT EXISTS tbl_kritik_saran (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    jenis_target   ENUM('Pengurus', 'Divisi') NOT NULL,
    id_pengurus    INT NULL,
    divisi_target  ENUM(
                       'PH',
                       'Kaderisasi',
                       'Humas',
                       'Ristek',
                       'Content Creator',
                       'Keilmuan',
                       'Programming',
                       'Multimedia',
                       'Sistem Robotika'
                   ) NOT NULL,
    isi_kritik     TEXT NULL,
    isi_saran      TEXT NULL,
    tanggal_masuk  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pengurus) REFERENCES tbl_pengurus(id) ON DELETE SET NULL
);
