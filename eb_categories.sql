-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 26 Kas 2017, 11:37:35
-- Sunucu sürümü: 5.7.17-log
-- PHP Sürümü: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ebakkal_model`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_categories`
--

CREATE TABLE `eb_categories` (
  `id` int(11) NOT NULL,
  `ad` varchar(30) NOT NULL,
  `cat_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_categories`
--

INSERT INTO `eb_categories` (`id`, `ad`, `cat_num`) VALUES
(1, 'Temel Gıda', 10),
(2, 'Kahvaltılık', 11),
(3, 'Meyve & Sebze', 12),
(4, 'İçecek', 13),
(5, 'Bakliyat', 14),
(6, 'Tatlı & Şeker', 15),
(7, 'Temel Gıda Diğer', 16),
(9, 'Unlu Mamüller', 20),
(10, 'Ekmek', 21),
(11, 'Pasta', 22),
(12, 'Poğaça & Simit', 23),
(13, 'Unlu Mamüller Diğer', 24),
(14, 'Kasap', 30),
(15, 'Kırmızı Et', 31),
(16, 'Beyaz Et', 32),
(17, 'Kasap Diğer', 33),
(18, 'Temizlik Ürünleri', 40),
(19, 'Deterjan', 41),
(20, 'Bulaşık Yıkama', 42),
(21, 'Şampuan & Sabun', 43),
(22, 'Ev Temizlik', 44),
(23, 'Temizlik Ürünleri Diğer', 45),
(24, 'Diğer Ürünler', 51);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `eb_categories`
--
ALTER TABLE `eb_categories`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `eb_categories`
--
ALTER TABLE `eb_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
