
Windows kullanan arkadaşlar,
1. Laragonun internet sitesinden laragonu kurun.
   https://laragon.org/

2. c:/laragon/www içine repoyu clonlayın
laragon terminaline girip:
    cd healthTracker
    php artisan migrate
    php artisan serve

    diyin.

3. http://127.0.0.1:8000/test adresine tarayıcınızdan girin. "Laravel çalışıyor!" çıktısı alırsanız kurulum tamamlanmıştır.

Database kurulumu;
1.Laragonda "hepsini başlat" butonuna tıkladıktan sonra laragondan veritabanı tuşuna basın.
2.Açılan pencerede Laragon.MySQL adlı oturuma çift tıklayın. Eğer healthtracker adlı bir scheme varsa droplayın. Sonrasında sırayla aşağıdaki sorguları runlayın.

CREATE DATABASE health_tracker;
USE health_tracker;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE medications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    time TIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL, -- Doktor adı
    time TIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE fitness_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    repetitions INT NOT NULL, -- Yapılan tekrar sayısı
    goal INT NOT NULL, -- Günlük hedef
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

3.Sonradan db güncellebilir.
