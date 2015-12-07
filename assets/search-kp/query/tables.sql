CREATE TABLE user (
username varchar(100) PRIMARY KEY,
nama varchar(200),
password varchar(100)
);

CREATE TABLE soal (
nama_soal varchar(200) PRIMARY KEY,
username varchar(100),
jenis varchar(100),
keterangan varchar(500),
waktu INT,
FOREIGN KEY (username) REFERENCES user(username)
);

CREATE TABLE pertanyaan (
id_pertanyaan INT PRIMARY KEY AUTO_INCREMENT,
nama_soal varchar(200),
pertanyaan varchar(1024),
pilihan1 varchar(800),
pilihan2 varchar(800),
pilihan3 varchar(800),
pilihan4 varchar(800),
pilihan5 varchar(800),
jawaban_benar varchar(800),
FOREIGN KEY (nama_soal) REFERENCES soal(nama_soal)
);

CREATE TABLE jawaban (
id_jawaban INT PRIMARY KEY AUTO_INCREMENT,
username varchar(100),
id_pertanyaan INT,
jawaban_saya varchar(800),
status varchar(100),
FOREIGN KEY (username) REFERENCES user(username),
FOREIGN KEY (id_pertanyaan) REFERENCES pertanyaan(id_pertanyaan)
);