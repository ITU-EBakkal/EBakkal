-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 11 Ara 2017, 18:50:49
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
-- Tablo için tablo yapısı `eb_baskets`
--

CREATE TABLE `eb_baskets` (
  `id` int(11) NOT NULL,
  `ebakkal_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'Mert Market', 4, 'Rasathane', '05309240735', 1),
(2, 'Kurt Market', 10, 'Nazilli', '', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_orders`
--

CREATE TABLE `eb_orders` (
  `id` int(11) NOT NULL,
  `ebakkal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `durum` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_order_details`
--

CREATE TABLE `eb_order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_products`
--

CREATE TABLE `eb_products` (
  `id` int(11) NOT NULL,
  `ad` varchar(30) NOT NULL,
  `ucret` double NOT NULL,
  `ebakkal_id` int(11) NOT NULL,
  `aciklama` varchar(140) NOT NULL,
  `stok_sayisi` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `img_path` varchar(250) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_products`
--

INSERT INTO `eb_products` (`id`, `ad`, `ucret`, `ebakkal_id`, `aciklama`, `stok_sayisi`, `cat_id`, `img_path`, `is_active`) VALUES
(6, 'Armut', 2.5, 4, 'Deveci Armutu', 999, 12, 'pirinc.png', 1),
(7, 'Kiraz', 1.54, 4, 'adsa', 999, 13, 'kiraz.PNG', 1),
(8, 'Pirinç', 5.47, 10, 'Kırık Pirinç', 20, 14, 'pirinc.png', 1),
(9, 'Pirinç', 5.47, 10, 'Kırık Pirinç', 20, 14, 'pirinc.png', 1),
(10, 'Kiraz 2', 1.94, 4, 'adsa', 999, 11, 'kiraz.PNG', 1),
(11, 'Kiraz 3', 1.94, 4, 'adsa', 999, 11, 'kiraz.PNG', 1),
(12, 'Kiraz 4', 1.94, 4, 'adsa', 999, 11, 'kiraz.PNG', 1),
(13, 'Tereyağı 1 KG', 35, 4, '', 1, 11, '16903337_10155005245378187_294398666191129227_o.jpg', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eb_provinces`
--

CREATE TABLE `eb_provinces` (
  `il_no` int(11) NOT NULL,
  `isim` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_provinces`
--

INSERT INTO `eb_provinces` (`il_no`, `isim`) VALUES
(1, 'Adana'),
(2, 'Adıyaman'),
(3, 'Afyonkarahisar'),
(4, 'Ağrı'),
(5, 'Amasya'),
(6, 'Ankara'),
(7, 'Antalya'),
(8, 'Artvin'),
(9, 'Aydın'),
(10, 'Balıkesir'),
(11, 'Bilecik'),
(12, 'Bingöl'),
(13, 'Bitlis'),
(14, 'Bolu'),
(15, 'Burdur'),
(16, 'Bursa'),
(17, 'Çanakkale'),
(18, 'Çankırı'),
(19, 'Çorum'),
(20, 'Denizli'),
(21, 'Diyarbakır'),
(22, 'Edirne'),
(23, 'Elâzığ'),
(24, 'Erzincan'),
(25, 'Erzurum'),
(26, 'Eskişehir'),
(27, 'Gaziantep'),
(28, 'Giresun'),
(29, 'Gümüşhane'),
(30, 'Hakkâri'),
(31, 'Hatay'),
(32, 'Isparta'),
(33, 'Mersin'),
(34, 'İstanbul'),
(35, 'İzmir'),
(36, 'Kars'),
(37, 'Kastamonu'),
(38, 'Kayseri'),
(39, 'Kırklareli'),
(40, 'Kırşehir'),
(41, 'Kocaeli'),
(42, 'Konya'),
(43, 'Kütahya'),
(44, 'Malatya'),
(45, 'Manisa'),
(46, 'Kahramanmaraş'),
(47, 'Mardin'),
(48, 'Muğla'),
(49, 'Muş'),
(50, 'Nevşehir'),
(51, 'Niğde'),
(52, 'Ordu'),
(53, 'Rize'),
(54, 'Sakarya'),
(55, 'Samsun'),
(56, 'Siirt'),
(57, 'Sinop'),
(58, 'Sivas'),
(59, 'Tekirdağ'),
(60, 'Tokat'),
(61, 'Trabzon'),
(62, 'Tunceli'),
(63, 'Şanlıurfa'),
(64, 'Uşak'),
(65, 'Van'),
(66, 'Yozgat'),
(67, 'Zonguldak'),
(68, 'Aksaray'),
(69, 'Bayburt'),
(70, 'Karaman'),
(71, 'Kırıkkale'),
(72, 'Batman'),
(73, 'Şırnak'),
(74, 'Bartın'),
(75, 'Ardahan'),
(76, 'Iğdır'),
(77, 'Yalova'),
(78, 'Karabük'),
(79, 'Kilis'),
(80, 'Osmaniye'),
(81, 'Düzce');

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
  `cep_tel` varchar(11) NOT NULL,
  `il` int(11) NOT NULL,
  `ilce` int(11) NOT NULL,
  `adres` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `eb_users`
--

INSERT INTO `eb_users` (`id`, `email`, `password`, `is_ebakkal`, `ad`, `soyad`, `cep_tel`, `il`, `ilce`, `adres`) VALUES
(4, 'mrtkprc@gmail.com', '1', 1, 'Mert', 'Koprucu', '', 34, 0, 'İlçe: Rasathan\nMahalle: Çukur\nSokak:Kazma\nTarif :Vartolu adresi'),
(6, 'mrtkprc@yandex.com', '123456', 0, '', '', '', 0, 0, 'İlçe: Ayazağa\nMahalle: -\nSokak:-\nTarif :İstanbul Teknik Üniversitesi Gölet Yurtları'),
(10, 'tugrulkurt@gmail.com', '123456', 1, 'Tuğrul', 'KURT', '', 34, 0, ''),
(11, 'l@gmail.com', '1', 0, 'Latif', 'Reis', '', 34, 0, 'Yeşilcaminin karşısı');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `eb_baskets`
--
ALTER TABLE `eb_baskets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `eb_categories`
--
ALTER TABLE `eb_categories`
  ADD PRIMARY KEY (`id`);

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
-- Tablo için indeksler `eb_provinces`
--
ALTER TABLE `eb_provinces`
  ADD PRIMARY KEY (`il_no`);

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
-- Tablo için AUTO_INCREMENT değeri `eb_baskets`
--
ALTER TABLE `eb_baskets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- Tablo için AUTO_INCREMENT değeri `eb_categories`
--
ALTER TABLE `eb_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Tablo için AUTO_INCREMENT değeri `eb_ebakkals`
--
ALTER TABLE `eb_ebakkals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `eb_orders`
--
ALTER TABLE `eb_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Tablo için AUTO_INCREMENT değeri `eb_order_details`
--
ALTER TABLE `eb_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Tablo için AUTO_INCREMENT değeri `eb_products`
--
ALTER TABLE `eb_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Tablo için AUTO_INCREMENT değeri `eb_users`
--
ALTER TABLE `eb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
