-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 15, 2022 lúc 12:41 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `em`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(25, '2014_10_12_000000_create_users_table', 1),
(26, '2014_10_12_100000_create_password_resets_table', 1),
(27, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2022_03_14_125822_create_nhanviens_table', 1),
(29, '2022_03_14_143729_create_phongbans_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanviens`
--

CREATE TABLE `nhanviens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ma_nhan_vien` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ho_ten` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phong_ban_id` int(11) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `ngay_dau_tien` date NOT NULL,
  `trang_thai` int(11) NOT NULL DEFAULT 1 COMMENT '1: Đang làm việc, 0: Đã nghỉ việc',
  `anh_dai_dien` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quyen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanviens`
--

INSERT INTO `nhanviens` (`id`, `ma_nhan_vien`, `ho_ten`, `phong_ban_id`, `ngay_sinh`, `ngay_dau_tien`, `trang_thai`, `anh_dai_dien`, `so_dien_thoai`, `quyen`, `created_at`, `updated_at`) VALUES
(6, 'EMPIT0001', 'Vũ Huy Quang', 1, '2000-01-02', '2022-03-15', 1, '1647342754.png', '0344396798', 'admin', '2022-03-15 03:46:14', '2022-03-15 04:12:34'),
(7, 'EMPIT0002', 'Phạm Tân Long', 1, '2000-01-01', '2022-01-01', 1, '1647343394.png', '0987654123', 'manager', '2022-03-15 04:23:14', '2022-03-15 04:24:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phongbans`
--

CREATE TABLE `phongbans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ma_phong_ban` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `truong_phong_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phongbans`
--

INSERT INTO `phongbans` (`id`, `ma_phong_ban`, `ten`, `mo_ta`, `truong_phong_id`, `created_at`, `updated_at`) VALUES
(1, 'DEPIT', 'Công nghệ thông tin', NULL, 7, '2022-03-14 20:50:33', '2022-03-15 04:24:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nhanviens`
--
ALTER TABLE `nhanviens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nhanviens_ma_nhan_vien_unique` (`ma_nhan_vien`),
  ADD UNIQUE KEY `nhanviens_so_dien_thoai_unique` (`so_dien_thoai`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `phongbans`
--
ALTER TABLE `phongbans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phongbans_ma_phong_ban_unique` (`ma_phong_ban`),
  ADD UNIQUE KEY `phongbans_ten_unique` (`ten`),
  ADD UNIQUE KEY `phongbans_truong_phong_id_unique` (`truong_phong_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `nhanviens`
--
ALTER TABLE `nhanviens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `phongbans`
--
ALTER TABLE `phongbans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
