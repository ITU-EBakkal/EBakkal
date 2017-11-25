-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 25 Kas 2017, 11:08:17
-- Sunucu sürümü: 5.7.17-log
-- PHP Sürümü: 5.6.30

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
-- Tablo için tablo yapısı `eb_orders`
--

CREATE TABLE `eb_orders` (
  `id` int(11) NOT NULL,
  `ebakkal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `durum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `stok_sayisi` int(11) NOT NULL
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
-- Dökümü yapılmış tablolar için indeksler
--

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
-- Tablo için AUTO_INCREMENT değeri `eb_orders`
--
ALTER TABLE `eb_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
