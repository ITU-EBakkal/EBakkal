-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 26 Kas 2017, 09:34:48
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
-- Tablo için tablo yapısı `eb_ebakkals`
--

CREATE TABLE `eb_ebakkals` (
  `id` int(11) NOT NULL,
  `adi` varchar(60) NOT NULL,
  `user_id` int(11) NOT NULL,
  `adres` varchar(200) NOT NULL,
  `telefon_no` varchar(11) NOT NULL,
  `durum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_ebakkals`
--

INSERT INTO `eb_ebakkals` (`id`, `adi`, `user_id`, `adres`, `telefon_no`, `durum`) VALUES
(1, 'Mert Market', 4, 'Rasathane', '05309240735', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_orders`
--

CREATE TABLE `eb_orders` (
  `id` int(11) NOT NULL,
  `ebakkal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `durum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_orders`
--

INSERT INTO `eb_orders` (`id`, `ebakkal_id`, `user_id`, `tarih`, `durum`) VALUES
(1, 4, 5, '0000-00-00', 1),
(2, 4, 6, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_order_details`
--

CREATE TABLE `eb_order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_products`
--

CREATE TABLE `eb_products` (
  `id` int(11) NOT NULL,
  `ad` varchar(30) NOT NULL,
  `ucret` double NOT NULL,
  `aciklama` varchar(140) NOT NULL,
  `stok_sayisi` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_users`
--

CREATE TABLE `eb_users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(120) NOT NULL,
  `is_ebakkal` int(1) NOT NULL DEFAULT '0',
  `ad` varchar(40) NOT NULL,
  `soyad` varchar(50) NOT NULL,
  `il` int(11) NOT NULL,
  `ilce` int(11) NOT NULL,
  `adres` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_users`
--

INSERT INTO `eb_users` (`id`, `email`, `password`, `is_ebakkal`, `ad`, `soyad`, `il`, `ilce`, `adres`) VALUES
(4, 'mrtkprc@gmail.com', '123456', 1, 'Mert', 'Koprucu', 34, 0, ''),
(6, 'mrtkprc@yandex.com', '123456', 0, '', '', 0, 0, '');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `eb_ebakkals`
--
ALTER TABLE `eb_ebakkals`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `eb_orders`
--
ALTER TABLE `eb_orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `eb_order_details`
--
ALTER TABLE `eb_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `eb_products`
--
ALTER TABLE `eb_products`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `eb_users`
--
ALTER TABLE `eb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `eb_ebakkals`
--
ALTER TABLE `eb_ebakkals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `eb_orders`
--
ALTER TABLE `eb_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `eb_order_details`
--
ALTER TABLE `eb_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `eb_products`
--
ALTER TABLE `eb_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `eb_users`
--
ALTER TABLE `eb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
