-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2019 at 11:25 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pacific_cross`
--

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

CREATE TABLE `claim` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_claim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `claim`
--

INSERT INTO `claim` (`id`, `code_claim`, `url_file`, `created_user`, `updated_user`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, '5039985', '1572544849aca006868ccce9960cdbdb4d11735064.csv', 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(2, '5106893', NULL, 1, 1, '2019-10-31 11:39:43', '2019-11-01 01:53:12', 0, NULL),
(3, '5292790', NULL, 1, 1, '2019-11-01 01:57:04', '2019-11-01 01:57:04', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_of_claim`
--

CREATE TABLE `item_of_claim` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `claim_id` int(11) DEFAULT NULL,
  `reason_reject_id` int(11) DEFAULT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_of_claim`
--

INSERT INTO `item_of_claim` (`id`, `content`, `amount`, `status`, `claim_id`, `reason_reject_id`, `parameters`, `created_user`, `updated_user`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'Tổng phân tích tế bào máu ngoại vi (bằng máy đếm laser)', '163,040', 1, 1, 1, '[\"Tổng phân tích tế bào máu ngoại vi (bằng máy đếm laser)\", \"163,040\"]', 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:01:17', 0, NULL),
(2, 'Định lượng Estradiol', '295,680', 1, 1, 2, '[\"\\u0110\\u1ecbnh l\\u01b0\\u1ee3ng Estradiol\",\"295,680\"]', 1, 1, '2019-10-31 11:00:49', '2019-11-01 01:42:47', 0, NULL),
(3, 'Định lượng CEA (CarcinoEmbry onic Antigen)', '360,000', 1, 1, 3, '[\"\\u0110\\u1ecbnh l\\u01b0\\u1ee3ng CEA (CarcinoEmbry onic Antigen)\",\"360,000\",\"2019-11-08\",\"5555\"]', 1, 1, '2019-10-31 11:00:49', '2019-11-01 01:42:47', 0, NULL),
(4, 'Định lượng CA 15-3(Cancer Antigen 15-3)', '500,000', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(5, 'Định lượng Bilirubin toànphần', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(6, 'Định lượng Albumin', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(7, 'Định lượng Ure', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(8, 'Định lượng Creatinin', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(9, 'Điện giải đồ (Na, K, Cl)', '126,880', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(10, 'Định lượng Creatinin', '100,000', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(11, 'Định lượng Glucose', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(12, 'Định lượng Axit uric', '100,000', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(13, 'Đo hoạt độ AST (GOT)', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(14, 'Đo hoạt độ ALT (GPT)', '82,800', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(15, 'Zoladex, 3.6mg,Hộp (,Greatbritain)', '1,155,762', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(16, 'Lưu viện phòng tiêu chuấn(2411)', '3,500,000', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:00:49', 0, NULL),
(17, 'Gói chi phí tiêu haothuốc/Vậttư', '27,228', 1, 1, NULL, NULL, 1, 1, '2019-10-31 11:00:49', '2019-10-31 11:01:17', 0, NULL),
(18, 'CT Bụng Chậu', '100,000', 1, 2, 1, NULL, 1, 1, '2019-11-01 01:53:12', '2019-11-01 01:53:12', 0, NULL),
(19, 'X-quang xương chính mũi', '100,000', 1, 2, 2, NULL, 1, 1, '2019-11-01 01:53:12', '2019-11-01 01:53:12', 0, NULL),
(20, 'Thallium 201 (T1-201)', '100,000', 1, 2, 3, NULL, 1, 1, '2019-11-01 01:53:12', '2019-11-01 01:53:12', 0, NULL),
(21, 'Anti DS DNA (Định lượng kháng thể kháng DNA)', '100,000', 1, 3, 1, '[\"Anti DS DNA (\\u0110\\u1ecbnh l\\u01b0\\u1ee3ng kh\\u00e1ng th\\u1ec3 kh\\u00e1ng DNA)\",\"100,000\"]', 1, 1, '2019-11-01 01:57:04', '2019-11-01 01:57:04', 0, NULL),
(22, 'Định lượng Estradiol 2', '100,000', 1, 3, 3, '[\"\\u0110\\u1ecbnh l\\u01b0\\u1ee3ng Estradiol 2\",\"100,000\",\"2019-11-06\",\"sadasd\"]', 1, 1, '2019-11-01 01:57:04', '2019-11-01 01:57:04', 0, NULL),
(23, 'CT Scan 1 - Nhóm 2 (Đầu, Ngực, Bụng, Xương chậu)', '50,000', 1, 3, 2, '[\"CT Scan 1 - Nh\\u00f3m 2 (\\u0110\\u1ea7u, Ng\\u1ef1c, B\\u1ee5ng, X\\u01b0\\u01a1ng ch\\u1eadu)\",\"50,000\"]', 1, 1, '2019-11-01 01:57:04', '2019-11-01 01:57:04', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `letter_template`
--

CREATE TABLE `letter_template` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `letter_template`
--

INSERT INTO `letter_template` (`id`, `name`, `template`, `is_deleted`, `created_user`, `updated_user`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Thanh Toán Một Phần', '<p><em><strong>K&iacute;nh gửi Qu&yacute; kh&aacute;ch</strong></em>: <strong>[[$applicantName]]</strong></p>\r\n<p>C&ocirc;ng ty Bảo Hiểm Nh&acirc;n Thọ Dai-ichi Việt Nam (&ldquo;Dai-ichi Life Việt Nam&rdquo;) xin gửi đến Qu&yacute; kh&aacute;ch lời ch&agrave;o tr&acirc;n trọng.</p>\r\n<p>Ch&uacute;ng t&ocirc;i th&ocirc;ng b&aacute;o đến Qu&yacute; kh&aacute;ch kết quả xem x&eacute;t hồ sơ y&ecirc;u cầu bồi thường li&ecirc;n quan đến <strong>[[$IOPDiag]]</strong>.</p>\r\n<p>Căn cứ c&aacute;c điều khoản đ&atilde; k&yacute; kết trong Hợp đồng <strong>[[$PRefNo]]</strong>&nbsp;quyền lợi bảo hiểm được giải quyết như sau:</p>\r\n<table style=\"border-style: solid; width: 100%; border-color: #0f0303; margin-left: auto; margin-right: auto;\" border=\"1px\" width=\"100%\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 106px; text-align: center; background-color: #c9c5c5;\">\r\n<p>B&ecirc;n mua bảo hiểm</p>\r\n</td>\r\n<td style=\"width: 99px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Số hợp đồng</p>\r\n</td>\r\n<td style=\"width: 180px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Người được bảo hiểm</p>\r\n</td>\r\n<td style=\"width: 80px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Ng&agrave;y chấp</p>\r\n<p>nhận</p>\r\n</td>\r\n<td style=\"width: 94px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Số tiền</p>\r\n<p>y&ecirc;u cầu</p>\r\n<p>bồi thường</p>\r\n<p>(đồng)</p>\r\n</td>\r\n<td style=\"width: 98px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Số tiền</p>\r\n<p>bồi thường</p>\r\n<p>(đồng)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 106px; text-align: center;\">\r\n<p><strong>[[$PhName]]</strong></p>\r\n</td>\r\n<td style=\"width: 99px; text-align: center;\">\r\n<p><strong>[[$PRefNo]]</strong></p>\r\n</td>\r\n<td style=\"width: 180px; text-align: center;\">\r\n<p><strong>[[$memberNameCap]]</strong></p>\r\n</td>\r\n<td style=\"width: 80px; text-align: center;\">\r\n<p><strong>[[$ltrDate]]</strong></p>\r\n</td>\r\n<td style=\"width: 94px; text-align: center;\">\r\n<p><strong>[[$pstAmt]]</strong></p>\r\n</td>\r\n<td style=\"width: 98px; text-align: center;\">\r\n<p><strong>[[$apvAmt]]</strong></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Số tiền tr&ecirc;n được chi trả cho Qu&yacute; kh&aacute;ch bằng h&igrave;nh thức &nbsp;[[$payMethod]]&nbsp;</p>\r\n<p>Đối với khoản tiền &nbsp;[[$deniedAmt]]&nbsp;<strong>&nbsp;VNĐ</strong> c&ograve;n lại, ch&uacute;ng t&ocirc;i rất tiếc khoản tiền n&agrave;y kh&ocirc;ng được thanh to&aacute;n v&igrave;:</p>\r\n<p>&nbsp;[[$CSRRemark]]&nbsp;</p>\r\n<p><em>Qu&yacute; kh&aacute;ch vui l&ograve;ng tham khảo C&aacute;c Định nghĩa của Quy tắc v&agrave; Điều khoản bảo hiểm Chăm s&oacute;c sức khỏe:</em></p>\r\n<p><em>[[$TermRemark]]</em></p>\r\n<p>&nbsp;</p>\r\n<p>Ch&uacute;ng t&ocirc;i xin chia sẻ v&agrave; ch&uacute;c NĐBH&nbsp;[[$applicantName]]&nbsp; thật nhiều sức khỏe.</p>\r\n<p>Trường hợp Qu&yacute; Kh&aacute;ch cần trao đổi th&ecirc;m, vui l&ograve;ng li&ecirc;n hệ Tổng đ&agrave;i Dịch vụ kh&aacute;ch h&agrave;ng, điện thoại: (028) 38230108 hoặc qua thư điện tử <a href=\"mailto:customer.services@dai-ichi-life.com.vn\">customer.services@dai-ichi-life.com.vn</a><u>.</u> Ch&uacute;ng t&ocirc;i lu&ocirc;n sẵn s&agrave;ng phục vụ Qu&yacute; kh&aacute;ch.</p>\r\n<p>Tr&acirc;n trọng k&iacute;nh ch&agrave;o,</p>\r\n<p><strong>Ph&ograve;ng Nghiệp Vụ</strong></p>\r\n<p><strong>C&ocirc;ng ty BHNT Dai-ichi Việt Nam</strong></p>', 0, 1, 2, NULL, '2019-10-31 10:34:16', '2019-11-01 05:38:17'),
(2, 'Thanh Toán Toàn phần', '<p>K&iacute;nh gửi Qu&yacute; kh&aacute;ch: &nbsp;[[$applicantName]]&nbsp;</p>\r\n<p>C&ocirc;ng ty Bảo Hiểm Nh&acirc;n Thọ Dai-ichi Việt Nam (&ldquo;Dai-ichi Life Việt Nam&rdquo;) xin gửi đến Qu&yacute; kh&aacute;ch lời ch&agrave;o tr&acirc;n trọng.</p>\r\n<p>Ch&uacute;ng t&ocirc;i th&ocirc;ng b&aacute;o đến Qu&yacute; kh&aacute;ch kết quả xem x&eacute;t hồ sơ y&ecirc;u cầu bồi thường li&ecirc;n quan đến &nbsp;[[$IOPDiag]]&nbsp;</p>\r\n<p>Căn cứ c&aacute;c điều khoản đ&atilde; k&yacute; kết trong Hợp đồng &nbsp;[[$PRefNo]]&nbsp;&nbsp;quyền lợi bảo hiểm được giải quyết như sau:</p>\r\n<p>&nbsp;</p>\r\n<table style=\"border-color: #666363; width: 100%; border-style: solid;\" width=\"100%\">\r\n<tbody>\r\n<tr>\r\n<td style=\"background-color: #bfb8b8;\" width=\"111\">\r\n<p>B&ecirc;n mua bảo hiểm</p>\r\n</td>\r\n<td style=\"background-color: #bfb8b8;\" width=\"87\">\r\n<p>Số hợp đồng</p>\r\n</td>\r\n<td style=\"background-color: #bfb8b8;\" width=\"165\">\r\n<p>Người được bảo hiểm</p>\r\n</td>\r\n<td style=\"background-color: #bfb8b8;\" width=\"82\">\r\n<p>Ng&agrave;y chấp nhận</p>\r\n</td>\r\n<td style=\"background-color: #bfb8b8;\" width=\"89\">\r\n<p>Số tiền</p>\r\n<p>y&ecirc;u cầu</p>\r\n<p>bồi thường (đồng)</p>\r\n</td>\r\n<td style=\"background-color: #bfb8b8;\" width=\"92\">\r\n<p>Số tiền</p>\r\n<p>bồi thường (đồng)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"111\">\r\n<p>&nbsp;[[$PhName]]&nbsp;</p>\r\n</td>\r\n<td width=\"87\">\r\n<p>&nbsp;[[$PRefNo]]&nbsp;</p>\r\n</td>\r\n<td width=\"165\">\r\n<p>&nbsp;[[$memberNameCap]]&nbsp;</p>\r\n</td>\r\n<td width=\"82\">\r\n<p>&nbsp;[[$ltrDate]]</p>\r\n</td>\r\n<td width=\"89\">\r\n<p>&nbsp;[[$pstAmt]]&nbsp;</p>\r\n</td>\r\n<td width=\"92\">\r\n<p>&nbsp;[[$apvAmt]]&nbsp;</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Số tiền tr&ecirc;n được chi trả cho Qu&yacute; kh&aacute;ch bằng h&igrave;nh thức &nbsp;[[$payMethod]]&nbsp;<em>.</em></p>\r\n<p>Ch&uacute;ng t&ocirc;i xin chia sẻ v&agrave; ch&uacute;c NĐBH Trần Minh Qu&acirc;n&nbsp;thật nhiều sức khỏe.</p>\r\n<p>Trường hợp Qu&yacute; Kh&aacute;ch cần trao đổi th&ecirc;m, vui l&ograve;ng li&ecirc;n hệ Tổng đ&agrave;i Dịch vụ kh&aacute;ch h&agrave;ng, điện thoại: (028) 38230108 hoặc qua thư điện tử <a href=\"mailto:customer.services@dai-ichi-life.com.vn\">customer.services@dai-ichi-life.com.vn</a><u>.</u> Ch&uacute;ng t&ocirc;i lu&ocirc;n sẵn s&agrave;ng phục vụ Qu&yacute; kh&aacute;ch.</p>\r\n<p>Tr&acirc;n trọng k&iacute;nh ch&agrave;o,</p>\r\n<p><strong>Ph&ograve;ng Nghiệp Vụ</strong></p>\r\n<p><strong>C&ocirc;ng ty BHNT Dai-ichi Việt Nam</strong></p>', 0, 1, 1, NULL, '2019-10-31 10:35:08', '2019-10-31 10:35:08'),
(3, 'Tạm Thời Đình Chỉ', '<p>K&iacute;nh gửi Qu&yacute; kh&aacute;ch: &nbsp;[[$applicantName]]&nbsp;</p>\r\n<p>C&ocirc;ng ty Bảo hiểm Nh&acirc;n thọ Dai-ichi Việt Nam (&ldquo;Dai-ichi Life Việt Nam&rdquo;) xin gửi đến Qu&yacute; kh&aacute;ch lời ch&agrave;o tr&acirc;n trọng.</p>\r\n<p>Ch&uacute;ng t&ocirc;i rất tiếc phải th&ocirc;ng b&aacute;o đến Qu&yacute; kh&aacute;ch việc tạm đ&igrave;nh chỉ xem x&eacute;t Hồ sơ y&ecirc;u cầu giải quyết quyền lợi bảo hiểm li&ecirc;n quan đến &nbsp;[[$IOPDiag]]&nbsp;.</p>\r\n<p>Do Dai-ichi Life Việt Nam chưa nhận được chứng từ đ&atilde; n&ecirc;u trong c&aacute;c Th&ocirc;ng b&aacute;o y&ecirc;u cầu bổ sung hồ sơ đ&atilde; gửi đến Qu&yacute; kh&aacute;ch bao gồm:</p>\r\n<ol>\r\n<li><strong>Chứng từ y tế (Sổ kh&aacute;m bệnh, B&igrave;a sổ kh&aacute;m bệnh, Phiếu kh&aacute;m bệnh, B&aacute;o c&aacute;o y tế, Toa thuốc&hellip;) c&oacute; thể hiện t&ecirc;n bệnh nh&acirc;n l&agrave; Qu&yacute; kh&aacute;ch, chẩn đo&aacute;n bệnh, c&oacute; chữ k&yacute; v&agrave; t&ecirc;n B&aacute;c sĩ điều trị </strong><strong>v&agrave;o ng&agrave;y 20/07/2019, ng&agrave;y 21/07/2019, ng&agrave;y 22/07/2019, ng&agrave;y 23/07/2019, ng&agrave;y 24/07/2019, ng&agrave;y 25/07/2019, 26/07/2019 tại Ph&ograve;ng Kh&aacute;m Đa Khoa Phục Hồi Chức Năng An Nhi&ecirc;n</strong><strong>.</strong></li>\r\n<li><strong>Chứng từ y tế (Sổ kh&aacute;m bệnh, B&igrave;a sổ kh&aacute;m bệnh, Phiếu kh&aacute;m bệnh, B&aacute;o c&aacute;o y tế, Toa thuốc&hellip;) c&oacute; thể hiện t&ecirc;n bệnh nh&acirc;n l&agrave; Qu&yacute; kh&aacute;ch, chẩn đo&aacute;n bệnh, c&oacute; chữ k&yacute; v&agrave; t&ecirc;n B&aacute;c sĩ điều trị </strong><strong>v&agrave;o ng&agrave;y 22/07/2019 tại Bệnh Viện Th&acirc;n D&acirc;n.</strong></li>\r\n<li><strong>Chứng từ y tế (Sổ kh&aacute;m bệnh, B&igrave;a sổ kh&aacute;m bệnh, Phiếu kh&aacute;m bệnh, B&aacute;o c&aacute;o y tế, Toa thuốc&hellip;) c&oacute; thể hiện t&ecirc;n bệnh nh&acirc;n l&agrave; Qu&yacute; kh&aacute;ch, chẩn đo&aacute;n bệnh, c&oacute; chữ k&yacute; v&agrave; t&ecirc;n B&aacute;c sĩ điều trị</strong><strong> v&agrave;o ng&agrave;y 30/07/2019 tại Ph&ograve;ng Kh&aacute;m Đa Khoa Medic H&ograve;a Hảo.</strong></li>\r\n<li><strong>H&oacute;a đơn gi&aacute; trị gia tăng bản gốc của chi ph&iacute; 1.000.000 đồng ng&agrave;y 30/07/2019 c&oacute; đ&oacute;ng dấu mộc tr&ograve;n, c&oacute; chữ k&yacute; v&agrave; t&ecirc;n người b&aacute;n h&agrave;ng.</strong></li>\r\n</ol>\r\n<p>Ch&uacute;ng t&ocirc;i sẵn s&agrave;ng mở lại hồ sơ xem x&eacute;t nếu trong v&ograve;ng 01 năm kể từ ng&agrave;y xảy ra sự kiện bảo hiểm Qu&yacute; kh&aacute;ch cung cấp cho ch&uacute;ng t&ocirc;i đầy đủ c&aacute;c chứng từ n&ecirc;u tr&ecirc;n.</p>\r\n<p>Trường hợp Qu&yacute; kh&aacute;ch cần trao đổi th&ecirc;m, vui l&ograve;ng li&ecirc;n hệ Tổng đ&agrave;i Dịch vụ kh&aacute;ch h&agrave;ng, điện thoại: (028) 38230108. Ch&uacute;ng t&ocirc;i lu&ocirc;n sẵn s&agrave;ng phục vụ Qu&yacute; kh&aacute;ch.</p>\r\n<p>Tr&acirc;n trọng k&iacute;nh ch&agrave;o,</p>\r\n<p><strong>Ph&ograve;ng Nghiệp Vụ</strong></p>\r\n<p><strong>C&ocirc;ng ty BHNT Dai-ichi Việt Nam</strong></p>', 0, 1, 1, NULL, '2019-10-31 10:35:50', '2019-10-31 10:35:50'),
(4, 'Bổ Túc Hồ Sơ', '<p>K&iacute;nh gửi Qu&yacute; kh&aacute;ch:&nbsp;[[$applicantName]]&nbsp;</p>\r\n<p>C&ocirc;ng ty Bảo Hiểm Nh&acirc;n Thọ Dai-ichi Việt Nam (&ldquo;Dai-ichi Life Việt Nam&rdquo;) xin gửi đến Qu&yacute; kh&aacute;ch lời ch&agrave;o tr&acirc;n trọng.</p>\r\n<p>Ch&uacute;ng t&ocirc;i đ&atilde; nhận được hồ sơ y&ecirc;u cầu bồi thường li&ecirc;n quan đến &nbsp;[[$IOPDiag]].</p>\r\n<p>Để hồ sơ đủ cơ sở thanh to&aacute;n bồi thường Qu&yacute; kh&aacute;ch vui l&ograve;ng bổ sung cho ch&uacute;ng t&ocirc;i c&aacute;c chứng từ sau:</p>\r\n<ol>\r\n<li><strong>Qu&yacute; kh&aacute;ch vui l&ograve;ng cho biết bệnh &ldquo;Hen phế quản&rdquo; được ph&aacute;t hiện lần đầu ti&ecirc;n l&agrave; khi n&agrave;o?</strong></li>\r\n<li><strong>Phương thức thanh to&aacute;n của Qu&yacute; kh&aacute;ch do Qu&yacute; kh&aacute;ch đ&atilde; tr&ecirc;n 18 tuổi. (Trường hợp Qu&yacute; kh&aacute;ch muốn ủy quyền cho BMBH nhận tiền, vui l&ograve;ng gửi giấy x&aacute;c nhận c&oacute; c&ocirc;ng chứng phường x&atilde;)</strong></li>\r\n</ol>\r\n<p>Ch&uacute;ng t&ocirc;i rất mong nhận được sự hợp t&aacute;c của Qu&yacute; kh&aacute;ch v&agrave; sẽ xem x&eacute;t y&ecirc;u cầu bồi thường n&agrave;y ngay sau khi nhận được đầy đủ c&aacute;c chứng từ n&ecirc;u tr&ecirc;n.</p>\r\n<p>Trường hợp Qu&yacute; kh&aacute;ch cần trao đổi th&ecirc;m, vui l&ograve;ng li&ecirc;n hệ Tổng đ&agrave;i Dịch vụ kh&aacute;ch h&agrave;ng, điện thoại: (028) 38230108. Ch&uacute;ng t&ocirc;i lu&ocirc;n sẵn s&agrave;ng phục vụ Qu&yacute; kh&aacute;ch.</p>\r\n<p>Tr&acirc;n trọng k&iacute;nh ch&agrave;o,</p>\r\n<p><strong>Ph&ograve;ng Nghiệp Vụ</strong></p>\r\n<p><strong>C&ocirc;ng ty BHNT Dai-ichi Việt Nam</strong></p>', 0, 1, 1, NULL, '2019-10-31 10:36:28', '2019-10-31 10:36:28'),
(5, 'Từ Chối Bồi Thường', '<p>K&iacute;nh gửi Qu&yacute; kh&aacute;ch: &nbsp;<strong>[[$applicantName]]</strong>&nbsp;</p>\r\n<p>C&ocirc;ng ty Bảo Hiểm Nh&acirc;n Thọ Dai-ichi Việt Nam (&ldquo;Dai-ichi Life Việt Nam&rdquo;) xin gửi đến Qu&yacute; kh&aacute;ch lời ch&agrave;o tr&acirc;n trọng.</p>\r\n<p>Ch&uacute;ng t&ocirc;i xin th&ocirc;ng b&aacute;o đến Qu&yacute; kh&aacute;ch kết quả xem x&eacute;t hồ sơ y&ecirc;u cầu bồi thường li&ecirc;n quan đến &nbsp;<strong>[[$IOPDiag]]</strong>&nbsp; v&agrave; xin được ph&uacute;c đ&aacute;p như sau:</p>\r\n<table style=\"border-style: solid; width: 100%; border-color: #0f0303; margin-left: auto; margin-right: auto;\" border=\"1px\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 106px; text-align: center; background-color: #c9c5c5;\">\r\n<p>B&ecirc;n mua bảo hiểm</p>\r\n</td>\r\n<td style=\"width: 99px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Số hợp đồng</p>\r\n</td>\r\n<td style=\"width: 180px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Người được bảo hiểm</p>\r\n</td>\r\n<td style=\"width: 80px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Ng&agrave;y chấp</p>\r\n<p>nhận</p>\r\n</td>\r\n<td style=\"width: 94px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Số tiền</p>\r\n<p>y&ecirc;u cầu</p>\r\n<p>bồi thường</p>\r\n<p>(đồng)</p>\r\n</td>\r\n<td style=\"width: 98px; text-align: center; background-color: #c9c5c5;\">\r\n<p>Số tiền</p>\r\n<p>bồi thường</p>\r\n<p>(đồng)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 106px; text-align: center;\">\r\n<p><strong>[[$PhName]]</strong></p>\r\n</td>\r\n<td style=\"width: 99px; text-align: center;\">\r\n<p><strong>[[$PRefNo]]</strong></p>\r\n</td>\r\n<td style=\"width: 180px; text-align: center;\">\r\n<p><strong>[[$memberNameCap]]</strong></p>\r\n</td>\r\n<td style=\"width: 80px; text-align: center;\">\r\n<p><strong>[[$ltrDate]]</strong></p>\r\n</td>\r\n<td style=\"width: 94px; text-align: center;\">\r\n<p><strong>[[$pstAmt]]</strong></p>\r\n</td>\r\n<td style=\"width: 98px; text-align: center;\">\r\n<p><strong>&nbsp;[[$apvAmt]]</strong>&nbsp;</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Thưa Qu&yacute; kh&aacute;ch, ch&uacute;ng t&ocirc;i rất lấy l&agrave;m tiếc y&ecirc;u cầu bồi thường của Qu&yacute; kh&aacute;ch kh&ocirc;ng được thanh to&aacute;n v&igrave;:</p>\r\n<p>&nbsp;[[$CSRRemark]]&nbsp;</p>\r\n<p>Qu&yacute; kh&aacute;ch vui l&ograve;ng tham khảo Quy tắc v&agrave; điều khoản bảo hiểm Chăm s&oacute;c sức khỏe :</p>\r\n<p>&nbsp;[[$CSRRemark]]&nbsp;</p>\r\n<p>Ch&uacute;ng t&ocirc;i xin chia sẻ v&agrave; mong Qu&yacute; kh&aacute;ch hiểu v&agrave; đồng thuận với quyết định n&agrave;y.</p>\r\n<p>Trường hợp Qu&yacute; kh&aacute;ch cần trao đổi th&ecirc;m, vui l&ograve;ng li&ecirc;n hệ Tổng đ&agrave;i Dịch vụ kh&aacute;ch h&agrave;ng, điện thoại: (028) 38230108. Ch&uacute;ng t&ocirc;i lu&ocirc;n sẵn s&agrave;ng phục vụ Qu&yacute; kh&aacute;ch.</p>\r\n<p>Tr&acirc;n trọng k&iacute;nh ch&agrave;o,</p>\r\n<p><strong>Ph&ograve;ng Nghiệp Vụ</strong></p>\r\n<p><strong>C&ocirc;ng ty BHNT Dai-ichi Việt Nam</strong></p>', 0, 1, 1, NULL, '2019-10-31 10:37:01', '2019-11-01 01:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_09_19_045100_create_claim_table', 1),
(5, '2019_10_02_032603_create_reason_reject_table', 1),
(6, '2019_10_02_033856_create_item_of_claim_table', 1),
(7, '2019_10_07_172416_create_product_table', 1),
(8, '2019_10_08_093755_index_product', 1),
(9, '2019_10_20_081322_create_permission_tables', 1),
(10, '2019_10_23_043719_create_terms_table', 1),
(11, '2019_10_29_045737_create_letter_template_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(1, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'view_claim', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(2, 'add_claim', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(3, 'edit_claim', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(4, 'delete_claim', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(5, 'publish_claim', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(6, 'unpublish_claim', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(7, 'view_product', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(8, 'add_product', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(9, 'edit_product', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(10, 'delete_product', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(11, 'publish_product', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(12, 'unpublish_product', 'web', '2019-10-31 10:15:52', '2019-10-31 10:15:52', 0, NULL),
(13, 'view_term', 'web', '2019-10-31 10:15:54', '2019-10-31 10:15:54', 0, NULL),
(14, 'add_term', 'web', '2019-10-31 10:15:54', '2019-10-31 10:15:54', 0, NULL),
(15, 'edit_term', 'web', '2019-10-31 10:15:54', '2019-10-31 10:15:54', 0, NULL),
(16, 'delete_term', 'web', '2019-10-31 10:15:54', '2019-10-31 10:15:54', 0, NULL),
(17, 'publish_term', 'web', '2019-10-31 10:15:54', '2019-10-31 10:15:54', 0, NULL),
(18, 'unpublish_term', 'web', '2019-10-31 10:15:54', '2019-10-31 10:15:54', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `created_user`, `updated_user`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'Soi dạ dày', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(2, 'Soi dạ dày đường mũi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(3, 'Soi đại tràng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(4, 'Soi phế quản', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(5, 'Soi thanh quản', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(6, 'Soi tai mũi họng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(7, 'CT cột sống thắt lưng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(8, 'CT 2 phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(9, 'CT 3 phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(10, 'CT Bụng Chậu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(11, 'CT Bụng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(12, 'CT Chậu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(13, 'CT Cột sống cổ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(14, 'CT Cột sống ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(15, 'CT Mạch', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(16, 'CT Ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(17, 'CT sọ não', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(18, 'CT sọ xoang', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(19, 'CT tai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(20, 'CT Scan 1 - Nhóm 1 (Xoang, Quỹ đạo, Khớp, Cột sống, Phân đoạn xương)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(21, 'CT Scan 1 - Nhóm 2 (Đầu, Ngực, Bụng, Xương chậu)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(22, 'CT Scan 1 - Nhóm 3 (Uroscan, Dentascan)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(23, 'CT Scan 1 - Nhóm 4 (Uroscan + Bụng X-Ray)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(24, 'CT Scan 1 - Nhóm 5 (Arthroscan)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(25, 'CT Scan 2 (2 Vùng cơ thể)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(26, 'CT Scan 3 (3 vùng cơ thể)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(27, 'CT Scan 4 (Hơn 3 vùng cơ thể)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(28, 'CT Scan Đơn giản (Đo lường)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(29, 'MRI 2 phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(30, 'MRI 3 phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(31, 'MRI bụng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(32, 'MRI Chậu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(33, 'MRI Cột sống cổ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(34, 'MRI cột sống ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(35, 'MRI cột sống thắt lưng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(36, 'MRI gan, mật', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(37, 'MRI khớp gối', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(38, 'MRI khớp háng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(39, 'MRI khớp nhỏ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(40, 'MRI khớp vai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(41, 'MRI sọ não', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(42, 'MRI trên 3 phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(43, 'ECG', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(44, 'Siêu âm tim qua lồng ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(45, 'Holter điện tim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(46, 'Xét nghiệm gắng sức tim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(47, 'Holter Huyết áp', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(48, 'Siêu âm bụng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(49, 'Siêu âm đánh dấu chọc dò dịch báng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(50, 'Siêu âm đánh dấu tràn dịch màng phổi ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(51, 'Siêu âm độ mờ da gáy', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(52, 'Siêu âm động mạch chi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(53, 'Siêu âm hình thái học', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(54, 'siêu âm hướng dẫn sinh thiết gan, tuyến giáp', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(55, 'Siêu âm khớp háng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(56, 'Siêu âm lồng ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(57, 'Siêu âm động mạch cảnh ngoại sọ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(58, 'Siêu âm mạch máu thận', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(59, 'Siêu âm phụ khoa đầu dò âm đạo', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(60, 'Siêu âm phụ khoa qua đường bụng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(61, 'Siêu âm phụ khoa qua ngã trực tràng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(62, 'Siêu âm thai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(63, 'Siêu âm tim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(64, 'Siêu âm tinh hoàn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(65, 'Siêu âm tĩnh mạch chi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(66, 'Siêu âm tràn dịch khớp háng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(67, 'Siêu âm tuyến giáp', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(68, 'Siêu âm vú', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(69, 'Siêu âm vùng cổ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(70, 'Siêu âm đàn hồi gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(71, 'Siêu âm đàn hồi vú', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(72, 'Siêu âm đàn hồi tuyến giáp', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(73, 'Chụp nhũ ảnh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(74, 'X-quang Xoang Blondeau-Hirzt ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(75, 'X-quang bàn chân', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(76, 'X-quang bàn tay ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(77, 'X-quang bụng ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(78, 'X-quang cẳng chân', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(79, 'X-quang cẳng tay', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(80, 'X-quang cánh tay', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(81, 'X-quang cổ chân', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(82, 'X-quang cổ tay', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(83, 'X-quang cột sống cổ ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(84, 'X-quang cột sống ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(85, 'X-quang cột sống thắt lưng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(86, 'X-quang gót chân', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(87, 'X-quang khớp gối', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(88, 'X-quang khớp háng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(89, 'X-quang khớp thái dương hàm', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(90, 'X-quang khớp vai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(91, 'X-quang khung chậu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(92, 'X-quang khung sườn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(93, 'X-quang khuỷu tay', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(94, 'X-quang phổi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(95, 'X-quang phổi nghiêng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(96, 'X-quang schuller', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(97, 'X-quang sọ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(98, 'X-quang thực quản, dạ dày, tá tràng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(99, 'X-quang ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(100, 'X-quang IVU/X-quang hệ niệu có cản quang', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(101, 'X-quang xương chính mũi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(102, 'X-quang xương cùng cụt', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(103, 'X-quang xương đòn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(104, 'X-quang đùi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(105, 'X-quang hàm', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(106, 'X-quang xương ức', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(107, 'ACTH (Hormone vỏ thượng thận)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(108, 'ADH (Hormone chống lợi tiểu)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(109, 'AFP (Xác định dị tật thai nhi)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(110, 'Albumin máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(111, 'Aldosterone', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(112, 'Phosphatase kiềm', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(113, 'Kháng nguyên dị ứng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(114, 'AMH (Tiên lượng khả năng sinh sản của buồng trứng)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(115, 'Amphetamine nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(116, 'Amylase máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(117, 'ANA (kháng thể đa nhân)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(118, 'Anti CCP (Định lượng tự kháng thể IgG kháng peptid citrullin mạch vòng)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(119, 'RF (xác định yếu tố viêm dạng thấp)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(120, 'Anti DS DNA (Định lượng kháng thể kháng DNA)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(121, 'Kháng thể tự miễn GAD', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(122, 'Định lượng Anti - TPO', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(123, 'kháng thể kháng nhân SM (RO) - Lupus', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(124, 'Định lượng Anti-Tg (Tuyến giáp, Hasimoto, ung thư giáp, Basedow)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(125, 'APTT (TCK) - Xét nghiệm đông máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(126, 'ASO - (Đo lượng kháng thể anti-streptolysin O (ASO) trong máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(127, 'ALT (SGPT) - Kiểm tra men gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(128, 'AST (SGOT) - Kiểm tra men gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(129, 'Axit folic (còn gọi là: Vitamin B9-Folacin - Folat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(130, 'Bartiturates nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(131, 'Benzodiazepine nước tiêu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(132, 'Định lượng Beta HCG (β-hCG)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(133, 'Xét nghiệm Bilirubin - sắc tố mật', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(134, 'BK - Xét nghiệm bệnh Lao', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(135, 'Định lượng lượng hormone BNP - để chẩn đoán suy tim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(136, 'CA 125 - Ung thư buồng trứng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(137, 'CA 15-3 - Ung thư vú', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(138, 'CA 19-9 - Ung thư tụy', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(139, 'CA 72 -4', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(140, 'Định lượng Cyfra 21-1 - Ung thư phổi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(141, 'CEA', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(142, 'Calcitonin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(143, 'Xét nghiệm cặn lắng nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(144, 'Canxi máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(145, 'Catecholamin (máu)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(146, 'Catecholamin (Nước tiểu)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(147, 'Cấy nấm', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(148, 'Kháng sinh đồ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(149, 'Cấy vi trùng lao', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(150, 'Xét nghiệm cell block dịch cơ thể', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(151, 'Chì huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(152, 'Chì nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(153, 'Xét nghiệm Chlamydia trachomatis IgA, IgG', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(154, 'Định lượng Cholesterol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(155, 'Định lượng Triglycerid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(156, 'Định lượng HDL-C (High density lipoprotein Cholesterol)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(157, 'Định lượng LDL - C (Low density lipoprotein Cholesterol)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(158, 'Nhiễm virus CMV', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(159, 'Xét nghiệm Double test ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(160, 'Xét nghiệm Triple test', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(161, 'Cortisol huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(162, 'Cortisol nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(163, 'Xét nghiệm peptide C ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(164, 'CPK/CPK-MB', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(165, 'CK/CK-MB', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(166, 'Creatinine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(167, 'CRP (Protein phản ứng C)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(168, 'Công thức máu (CBC)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(169, 'Đạm niệu 24 giờ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(170, 'D-Dimer - huyết khối tĩnh mạch não', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(171, 'Sốt xuất huyết', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(172, 'DHEA.SO4', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(173, 'Điện di đạm', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(174, 'Điện di Hb', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(175, 'Digoxin - rung nhĩ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(176, 'Độ thanh lọc Creatinine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(177, 'Đồng huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(178, 'Đường huyết bất kỳ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(179, 'Đường huyết lúc đói', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(180, 'Đường huyết sau ăn 1h', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(181, 'Đường huyết sau ăn 2h', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(182, 'EBV ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(183, 'Xét nghiệm Estrogens (Estradiol)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(184, 'Xét nghiệm Ferritin - thiếu máu thiếu sắt', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(185, 'Xét nghiệm huyết học định lượng Fibrinogen - đông máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(186, 'PSA - xét nghiệm tiền ung thư tuyến tiền liệt', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(187, 'T4 toàn phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(188, 'T4 tự do', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(189, 'T3', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(190, 'T3 tự do', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(191, 'Xét nghiệm hormon kích thích tuyến giáp (TSH)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(192, 'GGT -  xét nghiệm chức năng gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(193, 'Lậu cầu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(194, 'Xét nghiệm tìm kháng thể H.pylori trong phân ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(195, 'Test vi khuẩn HP - IgG, IgM', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(196, 'Định lượng haptoglobin trong máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(197, 'Virus viêm gan siêu vi A, B, C, D, E', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(198, 'Xét nghiệm HbA1c', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(199, 'Xét nghiệm Beta hCG trong thai kỳ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(200, 'HSV-1; HSV-1 -IgG, IgM', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(201, 'HIV/AIDS', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(202, 'Hồng cầu lưới', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(203, 'HPV', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(204, 'Xét nghiệm sùi mào gà', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(205, 'Kháng thể chống tế bào đảo tụy - Đái tháo đường', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(206, 'Định lượng IgE', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(207, 'Định lượng IgG', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(208, 'Đánh giá mức độ hình thành các cục máu đông - INR', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(209, 'Insulin (Đói, sau ăn)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(210, 'Nhiễm sắc thể đồ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(211, 'KST sốt rét', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(212, 'Kháng nguyên cúm A/B', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(213, 'Tế bào lupus', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(214, 'Xoắn khuẩn vàng da - Leptospirosis', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(215, 'Xét nghiệm lipase', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(216, 'Lipid panel', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(217, 'Magne máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(218, 'Methamphetamine nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(219, 'Phân tích tiết niệu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(220, 'Phát hiện các chất gây nghiện', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(221, 'Nhóm máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(222, 'Nhóm máu và rh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(223, 'NSE - đặc hiệu cho ung thư phổi tế bào nhỏ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(224, 'Định lượng PAPP-A', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(225, 'Phết tế bào cổ tử cung', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(226, 'Sán lá phổi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(227, 'RIDA Allergy Panel 1-4', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(228, 'Phân tích sỏi thận', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(229, 'Phân tích tế bào cặn lắng nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(230, 'Phenytoin level', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(231, 'Phospho máu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(232, 'Peptide natri lợi niệu não (BNP)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(233, 'Hormone steroid nội sinh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(234, 'Hormone Prolactin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(235, 'Xét nghiệm đông máu PT (TQ)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(236, 'Nội tiết tố tuyến cận giáp (PTH)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(237, 'Hệ thống nhóm máu Rh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(238, 'Rubella IgG, IgM', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(239, 'Sắt huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(240, 'Kháng nguyên ung thư biểu mô tế bào vảy', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(241, 'Sinh thiết gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(242, 'Soi tế bào da tìm nấm', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(243, 'Soi huyết tương trắng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(244, 'Streptococcus', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(245, 'Xét nghiệm tuyến giáp', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(246, 'Khả năng gắn sắt toàn phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(247, 'Xét nghiệm tìm máu ẩn trong phân', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(248, 'Xoắn khuẩn Treponema pallidum - Giang mai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(249, 'Tổng phân tích nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(250, 'Tổng phân tích nước tiểu 10 thông số', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(251, 'Xét nghiệm đánh giá rối loạn chuyển hóa sắt  ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(252, 'Troponin 1', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(253, 'Troponin T', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(254, 'Tỷ số A/G - xét nghiệm chức năng gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(255, 'Acid uric ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(256, 'Xét nghiệm tìm kháng thể giang mai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(257, 'Viêm não Nhật bản', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(258, 'Vitamin B12', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(259, 'Tốc độ lắng máu/ tốc độ lắng hồng cầu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(260, 'Salmonella Widal - Thương hàn (Typhoid Fever)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(261, 'Xét nghiệm máu thử kháng thể thhury đậu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(262, 'Xét nghiệm phân tìm ký sinh trùng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(263, 'Vi rút varicella zoster IgA, IgG, IgM', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(264, 'Sinh thiết tủy xương', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(265, 'Sinh thiết nội soi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(266, 'Sinh thiết da', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(267, 'Sinh thiết ung thư', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(268, 'Sinh thiết dạ dày', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(269, 'Sinh thiết gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(270, 'Cấy vi khuẩn HP bằng mẫu sinh thiết nội soi', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(271, 'Đọc tế bào dịch bệnh lý', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(272, 'Đọc tế bào lấy sinh thiết hút (FNA) vú, giáp', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(273, 'Bệnh sán lá gan nhỏ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(274, 'Trùng cong', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(275, 'Giun tròn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(276, 'Giun đũa', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(277, 'Sán dãi heo', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(278, 'Sán dãi chó', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(279, 'Entamoeba histolytica (IgG)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(280, 'Sán lá gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(281, 'Sán đầu gai', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(282, 'Sán máng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(283, 'Giun lươn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(284, 'Giun xoắn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(285, 'Sán đũa chó', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(286, 'Giun Chỉ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(287, 'Giun lươn', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(288, 'Giun đũa chó, mèo', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(289, 'Sán lá phổi ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(290, 'Chụp ảnh võng mạc', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(291, 'Siêu âm A và B', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(292, 'Thị trường', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(293, 'Kiểm tra thính lực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(294, 'T4 toàn phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(295, 'T4 tự do', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(296, 'T3', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(297, 'T3 tự do', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(298, 'xét nghiệm hormon kích thích tuyến giáp (TSH)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(299, 'Định lượng Anti - TPO', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(300, 'Xét nghiệm calcitonin ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(301, 'Anti Thyroglobulin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(302, 'Xét nghiệm CEA', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(303, 'Test vi khuẩn HP', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(304, 'Xét nghiệm pepsinogen I, II trong huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(305, 'Xét nghiệm Gastrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(306, 'Xét nghiệm qua hơi thở', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(307, 'Trùng cong', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(308, 'Virus Rubella', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(309, 'Cytomegalovirus (CMV)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(310, 'Herpes Simplex (HSV-1 & HSV-2) ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(311, 'Xét nghiệm TPHA - Giang mai ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(312, 'Virus viêm gan siêu vi A, B, C, D, E', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(313, 'Virus Coxsackie', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(314, 'Epstein-Bar virus (EBV)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(315, 'Human papiloma virus (HPV)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(316, 'HIV/ AIDS', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(317, 'Virus gây bệnh Thủy đậu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(318, 'Xét nghiệm Double test ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(319, 'Xét nghiệm Triple test', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(320, 'Tổng phân tích tế bào máu ngoại vi (bằng máy đếm laser)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(321, 'Định lượng Glucose', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(322, 'Định lượng Cholesterol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(323, 'Định lượng Triglycerid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(324, 'Định lượng HDL-C (High density lipoprotein Cholesterol)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(325, 'Định lượng LDL - C (Low density lipoprotein Cholesterol)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(326, 'Định lượng Creatinin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(327, 'Định lượng Ure', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(328, 'Đo hoạt độ AST (GOT)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(329, 'Đo hoạt độ ALT (GPT)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(330, 'Điện giải đồ (Na, K, Cl)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(331, 'Định lượng Axit uric', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(332, 'Định lượng CRP hs (C-Reactive Protein high sesitivity)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(333, 'Định lượng HbA1c', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(334, 'Tổng phân tích nước tiểu (Bằng máy tự động)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(335, 'Định lượng MAU (Micro Albumin Arine)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(336, 'Điện tim thường', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(337, 'Siêu âm tim, màng tim qua thành ngực', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(338, 'Siêu âm doppler động mạch cảnh, Doppler xuyên sọ (động mạch cảnh)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(339, 'Nghiệm pháp gắng sức điện tâm đồ', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(340, 'Alanin transaminase (ALT)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(341, 'Aspartate transaminase (AST)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(342, 'Phosphatase kiềm (ALP)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(343, 'Albumin & Total protein', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(344, 'Bilirubin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(345, 'Gamma–glutamyltransferase (GGT) -  xét nghiệm chức năng gan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(346, 'L–Lactate dehydrogenase (LD)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(347, 'Thời gian prothrombin (PT)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(348, 'Độ lọc cầu thận (GFR)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(349, 'Creatinine huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(350, 'Cystatin C huyết thanh', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(351, 'Xét nghiệm ure máu (BUN)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(352, 'Điện di nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(353, 'Tổng phân tích nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(354, 'Protein trong nước tiểu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(355, 'Xét nghiệm hệ số thanh thải của Creatinine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(356, 'Xét nghiệm Microalbumin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(357, 'β2 – microglobulin ( β – M)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(358, 'Xét nghiệm Myoglobin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(359, 'Xét nghiệm y tế đo lượng nitơ urê', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(360, 'Atropin sulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(361, 'Bupivacain hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(362, 'Desfluran', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(363, 'Dexmedetomidin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(364, 'Diazepam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(365, 'Etomidat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(366, 'Fentanyl', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(367, 'Halothan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(368, 'Isofluran', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(369, 'Ketamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(370, 'Levobupivacain', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(371, 'Lidocain hydroclodrid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(372, 'Lidocain + epinephrin (adrenalin)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(373, 'Lidocain + prilocain', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(374, 'Midazolam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(375, 'Morphin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(376, 'Oxy dược dụng', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(377, 'Pethidin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(378, 'Procain hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(379, 'Proparacain hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(380, 'Propofol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(381, 'Ropivacain hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(382, 'Sevofluran', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(383, 'Sufentanil', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(384, 'Thiopental (muối natri)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(385, 'Atracurium besylat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(386, 'Neostigmin metylsulfat (bromid)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(387, 'Pancuronium bromid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(388, 'Pipecuronium bromid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(389, 'Rocuronium bromid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(390, 'Suxamethonium clorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(391, 'Vecuronium bromid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(392, 'Aceclofenac', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(393, 'Aescin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(394, 'Celecoxib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(395, 'Dexibuprofen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(396, 'Diclofenac', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(397, 'Etodolac', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(398, 'Etoricoxib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(399, 'Fentanyl', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(400, 'Floctafenin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(401, 'Flurbiprofen natri', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(402, 'Ibuprofen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(403, 'Ibuprofen + codein', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(404, 'Ketoprofen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(405, 'Ketorolac', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(406, 'Loxoprofen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(407, 'Meloxicam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(408, 'Methyl salicylat + dl-camphor + thymol + l-menthol + glycol salicylat + tocopherol acetat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(409, 'Morphin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(410, 'Nabumeton', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(411, 'Naproxen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(412, 'Naproxen + esomeprazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(413, 'Nefopam hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(414, 'Oxycodone', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(415, 'Paracetamol (acetaminophen)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(416, 'Paracetamol + chlorphemramin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(417, 'Paracetamol + codein phosphat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(418, 'Paracetamol + diphenhydramin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(419, 'Paracetamol + ibuprofen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(420, 'Paracetamol + methocarbamol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(421, 'Paracetamol + phenylephrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(422, 'Paracetamol + pseudoephedrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(423, 'Paracetamol + tramadol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(424, 'Paracetamol + chlorpheniramin + dextromethorphan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(425, 'Paracetamol + chlorpheniramin + phenylephrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(426, 'Paracetamol + chlorpheniramin + pseudoephedrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(427, 'Paracetamol + diphenhydramin + phenylephrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(428, 'Paracetamol + phenylephrin + dextromethorphan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(429, 'Paracetamol + chlorpheniramin + phenylephrine + dextromethorphan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(430, 'Pethidin hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(431, 'Piroxicam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(432, 'Tenoxicam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(433, 'Tiaprofenic acid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(434, 'Tramadol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(435, 'Allopurinol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(436, 'Colchicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(437, 'Probenecid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(438, 'Diacerein', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(439, 'Glucosamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(440, 'Adalimumab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(441, 'Alendronat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(442, 'Alendronat natri + cholecalciferol (Vitamin D3)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(443, 'Alpha chymotrypsin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(444, 'Calcitonin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(445, 'Etanercept', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(446, 'Golimumab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(447, 'Infliximab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(448, 'Leflunomid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(449, 'Methocarbamol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(450, 'Risedronat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(451, 'Tocilizumab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(452, 'Zoledronic acid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(453, 'Alimemazin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(454, 'Bilastine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(455, 'Cetirizin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(456, 'Cinnarizin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(457, 'Chlorpheniramin (hydrogen maleat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(458, 'Chlorpheniramin + dextromethorphan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(459, 'Chlorpheniramin + phenylephrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(460, 'Desloratadin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(461, 'Dexchlorpheniramin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(462, 'Diphenhydramin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(463, 'Ebastin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(464, 'Epinephrin (adrenalin)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(465, 'Fexofenadin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(466, 'Ketotifen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(467, 'Levocetirizin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(468, 'Loratadin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(469, 'Loratadin + pseudoephedrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(470, 'Mequitazin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(471, 'Promethazin hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(472, 'Rupatadine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(473, 'Acetylcystein', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(474, 'Atropin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(475, 'Calci gluconat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(476, 'Dantrolen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(477, 'Deferoxamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(478, 'Dimercaprol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(479, 'Edetat natri calci (EDTA Ca - Na)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(480, 'Ephedrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(481, 'Esmolol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(482, 'Flumazenil', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(483, 'Fomepizol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(484, 'Glucagon', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(485, 'Glutathion', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(486, 'Hydroxocobalamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(487, 'Calci folinat (folinic acid, leucovorin)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(488, 'Naloxon hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(489, 'Naltrexon', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(490, 'Natri hydrocarbonat (natri bicarbonat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(491, 'Natri nitrit', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(492, 'Natri thiosulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(493, 'Nor-epinephrin (Nor- adrenalin)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(494, 'Penicilamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(495, 'Phenylephrin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(496, 'Polystyren', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(497, 'Pralidoxim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(498, 'Protamin sulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(499, 'Meglumin natri succinat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(500, 'Sorbitol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(501, 'Silibinin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(502, 'Succimer', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(503, 'Sugammadex', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(504, 'Than hoạt', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(505, 'Than hoạt + sorbitol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(506, 'Xanh methylen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(507, 'Carbamazepin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(508, 'Gabapentin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(509, 'Lamotrigine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(510, 'Levetiracetam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(511, 'Oxcarbazepin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(512, 'Phenobarbital', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(513, 'Phenytoin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(514, 'Pregabalin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(515, 'Topiramat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(516, 'Valproat natri', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(517, 'Valproat natri + valproic acid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(518, 'Valproic acid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(519, 'Albendazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(520, 'Diethylcarbamazin (dihydrogen citrat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(521, 'Ivermectin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(522, 'Mebendazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(523, 'Niclosamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(524, 'Praziquantel', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(525, 'Pyrantel', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(526, 'Triclabendazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(527, 'Amoxicilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(528, 'Amoxicilin + acid clavulanic', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(529, 'Amoxicilin + sulbactam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(530, 'Ampicilin (muối natri)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(531, 'Ampicilin + sulbactam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(532, 'Benzathin benzylpenicilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(533, 'Benzylpenicilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(534, 'Cefaclor', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(535, 'Cefadroxil', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(536, 'Cefalexin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(537, 'Cefalothin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(538, 'Cefamandol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(539, 'Cefazolin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(540, 'Cefdinir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(541, 'Cefepim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(542, 'Cefixim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(543, 'Cefmetazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(544, 'Cefoperazon', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(545, 'Cefoperazon + sulbactam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(546, 'Cefotaxim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(547, 'Cefotiam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(548, 'Cefoxitin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(549, 'Cefpirom', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(550, 'Cefpodoxim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(551, 'Cefradin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(552, 'Ceftazidim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(553, 'Ceftibuten', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(554, 'Ceftizoxim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(555, 'Ceftriaxon', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(556, 'Cefuroxim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL);
INSERT INTO `product` (`id`, `name`, `created_user`, `updated_user`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(557, 'Cloxacilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(558, 'Doripenem*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(559, 'Ertapenem*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(560, 'Imipenem + cilastatin*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(561, 'Meropenem*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(562, 'Oxacilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(563, 'Piperacilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(564, 'Piperacilin + tazobactam', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(565, 'Phenoxy methylpenicilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(566, 'Procain benzylpenicilin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(567, 'Sultamicillin (Ampicilin + sulbactam)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(568, 'Ticarcillin + acid clavulanic', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(569, 'Amikacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(570, 'Gentamicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(571, 'Neomycin (sulfat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(572, 'Neomycin + polymyxin B', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(573, 'Neomycin + polymyxin B + dexamethason', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(574, 'Netilmicin sulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(575, 'Tobramycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(576, 'Tobramycin + dexamethason', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(577, 'Cloramphenicol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(578, 'Metronidazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(579, 'Metronidazol + neomycin + nystatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(580, 'Secnidazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(581, 'Tinidazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(582, 'Clindamycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(583, 'Azithromycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(584, 'Clarithromycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(585, 'Erythromycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(586, 'Roxithromycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(587, 'Spiramycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(588, 'Spiramycin + metronidazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(589, 'Tretinoin + erythromycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(590, 'Ciprofloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(591, 'Levofloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(592, 'Lomefloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(593, 'Moxifloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(594, 'Nalidixic acid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(595, 'Norfloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(596, 'Ofloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(597, 'Pefloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(598, 'Sulfadiazin bạc', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(599, 'Sulfadimidin (muối natri)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(600, 'Sulfadoxin + pyrimethamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(601, 'Sulfaguanidin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(602, 'Sulfamethoxazol + trimethoprim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(603, 'Sulfasalazin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(604, 'Doxycyclin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(605, 'Minocyclin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(606, 'Tigecyclin*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(607, 'Tetracyclin hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(608, 'Argyrol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(609, 'Colistin*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(610, 'Daptomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(611, 'Fosfomycin*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(612, 'Linezolid*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(613, 'Nitrofurantoin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(614, 'Rifampicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(615, 'Teicoplanin*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(616, 'Vancomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(617, 'Abacavir (ABC)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(618, 'Darunavir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(619, 'Efavirenz (EFV hoặc EFZ)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(620, 'Lamivudin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(621, 'Nevirapin (NVP)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(622, 'Raltegravir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(623, 'Ritonavir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(624, 'Tenofovir (TDF)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(625, 'Zidovudin (ZDV hoặc AZT)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(626, 'Lamivudin + tenofovir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(627, 'Lamivudine+ zidovudin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(628, 'Lopinavir + ritonavir (LPV/r)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(629, 'Tenofovir + lamivudin + efavirenz', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(630, 'Zidovudin (ZDV hoặc AZT) + lamivudin + nevirapin (NVP)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(631, 'Daclatasvir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(632, 'Sofosbuvir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(633, 'Sofosbuvir + ledipasvir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(634, 'Sofosbuvir + velpatasvir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(635, 'Pegylated interferon (peginterferon) alpha (2a hoặc 2b)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(636, 'Aciclovir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(637, 'Entecavir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(638, 'Gancyclovir*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(639, 'Oseltamivir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(640, 'Ribavirin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(641, 'Valganciclovir*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(642, 'Zanamivir', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(643, 'Amphotericin B*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(644, 'Butoconazol nitrat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(645, 'Caspofungin*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(646, 'Ciclopiroxolamin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(647, 'Clotrimazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(648, 'Dequalinium clorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(649, 'Econazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(650, 'Fluconazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(651, 'Fenticonazol nitrat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(652, 'Flucytosin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(653, 'Griseofulvin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(654, 'Itraconazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(655, 'Ketoconazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(656, 'Miconazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(657, 'Natamycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(658, 'Nystatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(659, 'Policresulen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(660, 'Posaconazol*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(661, 'Terbinafin (hydroclorid)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(662, 'Voriconazol*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(663, 'Clotrimazol + betamethason', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(664, 'Clorquinaldol + promestrien', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(665, 'Miconazol + hydrocortison', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(666, 'Nystatin + metronidazol + neomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(667, 'Nystatin + neomycin + polymyxin B', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(668, 'Diiodohydroxyquinolin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(669, 'Hydroxy cloroquin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(670, 'Metronidazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(671, 'Ethambutol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(672, 'Isoniazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(673, 'Isoniazid + ethambutol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(674, 'Pyrazinamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(675, 'Rifampicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(676, 'Rifampicin + isoniazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(677, 'Rifampicin + isoniazid + pyrazinamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(678, 'Rifampicin + isoniazid + pyrazinamid + ethambutol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(679, 'Streptomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(680, 'Amikacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(681, 'Bedaquiline', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(682, 'Capreomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(683, 'Clofazimine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(684, 'Cycloserin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(685, 'Delamanid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(686, 'Ethionamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(687, 'Kanamycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(688, 'Linezolid*', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(689, 'Levofloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(690, 'Moxifloxacin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(691, 'PAS-Na', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(692, 'Prothinamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(693, 'Artesunat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(694, 'Cloroquin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(695, 'Piperaquin + dihydroartemisinin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(696, 'Primaquin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(697, 'Quinin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(698, 'Dihydro ergotamin mesylat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(699, 'Ergotamin (tartrat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(700, 'Flunarizin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(701, 'Sumatriptan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(702, 'Arsenic trioxid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(703, 'Bendamustine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(704, 'Bleomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(705, 'Bortezomib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(706, 'Busulfan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(707, 'Capecitabin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(708, 'Carboplatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(709, 'Carmustin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(710, 'Cisplatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(711, 'Cyclophosphamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(712, 'Cytarabin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(713, 'Dacarbazin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(714, 'Dactinomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(715, 'Daunorubicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(716, 'Decitabin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(717, 'Docetaxel', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(718, 'Doxorubicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(719, 'Epirubicin hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(720, 'Etoposid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(721, 'Everolimus', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(722, 'Fludarabin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(723, 'Fluorouracil (5-FU)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(724, 'Gemcitabin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(725, 'Hydroxyurea (Hydroxycarbamid)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(726, 'Idarubicin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(727, 'Ifosfamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(728, 'Irinotecan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(729, 'L-asparaginase', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(730, 'Melphalan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(731, 'Mercaptopurin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(732, 'Mesna', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(733, 'Methotrexat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(734, 'Mitomycin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(735, 'Mitoxantron', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(736, 'Oxaliplatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(737, 'Paclitaxel', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(738, 'Pemetrexed', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(739, 'Procarbazin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(740, 'Tegafur-uracil (UFT hoặc UFUR)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(741, 'Tegafur + gimeracil + oteracil kali', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(742, 'Temozolomid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(743, 'Tretinoin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(744, 'Vinblastin sulfat (All-trans retinoic acid)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(745, 'Vincristin sulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(746, 'Vinorelbin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(747, 'Afatinib dimaleate', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(748, 'Bevacizumab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(749, 'Cetuximab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(750, 'Erlotinib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(751, 'Gefitinib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(752, 'Imatinib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(753, 'Nilotinib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(754, 'Nimotuzumab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(755, 'Pazopanib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(756, 'Rituximab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(757, 'Sorafenib', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(758, 'Trastuzumab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(759, 'Abiraterone acetate', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(760, 'Anastrozol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(761, 'Bicalutamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(762, 'Degarelix', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(763, 'Exemestan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(764, 'Flutamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(765, 'Fulvestrant', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(766, 'Goserelin acetat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(767, 'Letrozol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(768, 'Leuprorelin acetat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(769, 'Tamoxifen', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(770, 'Triptorelin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(771, 'Anti thymocyte globulin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(772, 'Azathioprin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(773, 'Các kháng thể gắn với interferon ở người', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(774, 'Ciclosporin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(775, 'Basiliximab', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(776, 'Glycyl funtumin (hydroclorid)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(777, 'Lenalidomid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(778, 'Mycophenolat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(779, 'Tacrolimus', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(780, 'Thalidomid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(781, 'Clodronat disodium', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(782, 'Pamidronat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(783, 'Alfuzosin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(784, 'Dutasterid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(785, 'Flavoxat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(786, 'Lipidosterol serenoarepense (Lipid-sterol của Serenoa repens)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(787, 'Pinene + camphene + cineol + fenchone + bomeol + anethol + olive oil', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(788, 'Solifenacin succinate', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(789, 'Tamsulosin hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(790, 'Levodopa + carbidopa', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(791, 'Levodopa + carbidopa monohydrat + entacapone', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(792, 'Levodopa + benserazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(793, 'Piribedil', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(794, 'Pramipexol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(795, 'Tolcapon', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(796, 'Rotigotine', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(797, 'Trihexyphenidyl hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(798, 'Acid folic (vitamin B9)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(799, 'Sắt fumarat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(800, 'Sắt (III) hydroxyd polymaltose', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(801, 'Sắt protein succinylat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(802, 'Sắt sucrose (hay dextran)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(803, 'Sắt sulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(804, 'Sắt ascorbat + acid folic', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(805, 'Sắt fumarat + acid folic', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(806, 'Sắt (III) hydroxyd polymaltose + acid folic', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(807, 'Sắt sulfat + acid folic', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(808, 'Carbazochrom', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(809, 'Cilostazol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(810, 'Enoxaparin (natri)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(811, 'Ethamsylat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(812, 'Heparin (natri)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(813, 'Nadroparin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(814, 'Phytomenadion (vitamin K1)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(815, 'Protamin sulfat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(816, 'Trancxamic acid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(817, 'Triflusal', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(818, 'Warfarin (muối natri)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(819, 'Albumin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(820, 'Albumin + immuno globulin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(821, 'Huyết tương', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(822, 'Khối bạch cầu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(823, 'Khối hồng cầu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(824, 'Khối tiểu cầu', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(825, 'Máu toàn phần', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(826, 'Phức hợp kháng yếu tố ức chế yếu tố VIII bắc cầu (Factor Eight Inhibitor Bypassing Activity - FEIBA)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(827, 'Yếu tố VIIa', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(828, 'Yếu tố VIII', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(829, 'Yếu tố IX', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(830, 'Yếu tố VIII + yếu tố von Willebrand', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(831, 'Dextran 40', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(832, 'Dextran 60', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(833, 'Dextran 70', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(834, 'Gelatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(835, 'Gelatin succinyl + natri clorid + natri hydroxyd', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(836, 'Tinh bột este hóa (hydroxyethyl starch)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(837, 'Deferasirox', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(838, 'Deferipron', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(839, 'Eltrombopag', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(840, 'Erythropoietin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(841, 'Filgrastim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(842, 'Methoxy polyethylene glycol epoetin beta', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(843, 'Pegfilgrastim', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(844, 'Diltiazem', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(845, 'Glyceryl trinitrat (Nitroglycerin)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(846, 'Isosorbid (dinitrat hoặc mononitrat)', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(847, 'Nicorandil', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(848, 'Trimetazidin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(849, 'Adenosin triphosphat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(850, 'Amiodaron hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(851, 'Isoprenalin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(852, 'Propranolol hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(853, 'Sotalol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(854, 'Verapamil hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(855, 'Acebutolol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(856, 'Amlodipin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(857, 'Amlodipin + atorvastatin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(858, 'Amlodipin + losartan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(859, 'Amlodipin + lisinopril', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(860, 'Amlodipin + indapamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(861, 'Amlodipin + indapamid + perindopril', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(862, 'Amlodipin + telmisartan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(863, 'Amlodipin + valsartan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(864, 'Amlodipin + valsartan + hydrochlorothiazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(865, 'Atenolol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(866, 'Benazepril hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(867, 'Bisoprolol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(868, 'Bisoprolol + hydroclorothiazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(869, 'Candesartan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(870, 'Candesartan + hydrochlorothiazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(871, 'Captopril', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(872, 'Captopril + hydroclorothiazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(873, 'Carvedilol', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(874, 'Cilnidipin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(875, 'Clonidin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(876, 'Doxazosin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(877, 'Enalapril', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(878, 'Enalapril + hydrochlorothiazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(879, 'Felodipin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(880, 'Felodipin + Lisinopril tartrat', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(881, 'Hydralazin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(882, 'Imidapril', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(883, 'Indapamid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(884, 'Irbesartan', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(885, 'Irbesartan + hydroclorothiazid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(886, 'Lacidipin', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(887, 'Lercanidipin hydroclorid', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(888, 'Lisinopril', 1, 1, '2019-10-31 10:31:07', '2019-10-31 10:31:07', 0, NULL),
(889, 'Lisinopril + hydroclorothiazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(890, 'Losartan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(891, 'Losartan + hydroclorothiazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(892, 'Methyldopa', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(893, 'Metoprolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(894, 'Nebivolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(895, 'Nicardipin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(896, 'Nifedipin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(897, 'Perindopril', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(898, 'Perindopril + amlodipin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(899, 'Perindopril + indapamid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(900, 'Quinapril', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(901, 'Ramipril', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(902, 'Rilmenidin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(903, 'Telmisartan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(904, 'Telmisartan + hydroclorothiazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(905, 'Valsartan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(906, 'Valsartan + hydroclorothiazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(907, 'Heptaminol hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(908, 'Carvedilol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(909, 'Digoxin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(910, 'Dobutamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(911, 'Dopamin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(912, 'Ivabradin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(913, 'Milrinon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(914, 'Acenocoumarol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(915, 'Acetylsalicylic acid (DL-lysin-acetylsalicylat)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(916, 'Acetylsalicylic acid + clopidogrel', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(917, 'Alteplase', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(918, 'Clopidogrel', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(919, 'Dabigatran', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(920, 'Dipyridamol + acetylsalicylic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(921, 'Eptifibatid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(922, 'Fondaparinux sodium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(923, 'Rivaroxaban', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(924, 'Streptokinase', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(925, 'Tenecteplase', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(926, 'Ticagrelor', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(927, 'Urokinase', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(928, 'Atorvastatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(929, 'Atorvastatin + ezetimibe', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(930, 'Bezafibrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(931, 'Ciprofibrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(932, 'Ezetimibe', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(933, 'Fenofibrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(934, 'Fluvastatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(935, 'Gemfibrozil', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(936, 'Lovastatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(937, 'Pravastatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(938, 'Rosuvastatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(939, 'Simvastatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(940, 'Simvastatin + ezetimibe', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(941, 'Bosentan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(942, 'Iloprost', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(943, 'Prostaglandin E1', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(944, 'Fructose 1,6 diphosphat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(945, 'Indomethacin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(946, 'Magnesi clorid + kali clorid + procain hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(947, 'Naftidrofuryl', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(948, 'Nimodipin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(949, 'Nitric oxid (nitrogen monoxid) (NO)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(950, 'Succinic acid + nicotinamid + inosine + riboflavin natri phosphat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(951, 'Sulbutiamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(952, 'Tolazolin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(953, 'Acitretin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(954, 'Adapalen', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(955, 'Alpha - terpineol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(956, 'Amorolfin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(957, 'Azelaic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(958, 'Benzoic acid + salicylic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(959, 'Benzoyl peroxid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(960, 'Bột talc', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(961, 'Calcipotriol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(962, 'Calcipotriol + betamethason dipropionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(963, 'Capsaicin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(964, 'Clotrimazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(965, 'Clobetasol propionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(966, 'Clobetasol butyrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(967, 'Cortison', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(968, 'Cồn A.S.A', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(969, 'Cồn boric', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(970, 'Cồn BSI', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(971, 'Crolamiton', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(972, 'Dapson', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(973, 'Desonid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(974, 'Dexpanthenol (panthenol, vitamin B5)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(975, 'Diethylphtalat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(976, 'S-bioallethrin + piperonyl butoxid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(977, 'Flumethason + clioquinol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(978, 'Fusidic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(979, 'Fusidic acid + betamethason', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(980, 'Fusidic acid + hydrocortison', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(981, 'Isotretinoin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(982, 'Kẽm oxid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(983, 'Mometason furoat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(984, 'Mometason furoat + salicylic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(985, 'Mupirocin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(986, 'Natri hydrocarbonat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(987, 'Nepidermin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(988, 'Nước oxy già', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(989, 'Para aminobenzoic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(990, 'Recombinant human Epidermal Growth Factor (rhEGF)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(991, 'Salicylic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(992, 'Salicylic acid + betamethason dipropionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(993, 'Secukinumab', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(994, 'Tacrolimus', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(995, 'Tretinoin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(996, 'Trolamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(997, 'Tyrothricin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(998, 'Urea', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(999, 'Ustekinumab', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1000, 'Fluorescein (natri)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1001, 'Adipiodon (meglumin)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1002, 'Amidotrizoat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1003, 'Bari sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1004, 'Ethyl ester của acid béo iod hóa trong dầu hạt thuốc phiện', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1005, 'Gadobenic acid (dimeglumin)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1006, 'Gadobutrol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1007, 'Gadoteric acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1008, 'Iobitridol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1009, 'lodixanol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1010, 'Iohexol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1011, 'lopamidol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1012, 'Iopromid acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1013, 'Ioxitalamat natri + ioxitalamat meglumin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1014, 'Muối natri và meglumin của acid ioxaglic', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1015, 'Polidocanol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1016, 'Cồn 70°', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1017, 'Cồn iod', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1018, 'Đồng sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1019, 'Povidon iodin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1020, 'Natri hypoclorid đậm đặc', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1021, 'Natri clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1022, 'Furosemid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1023, 'Furosemid + spironolacton', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1024, 'Hydroclorothiazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1025, 'Spironolacton', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1026, 'Aluminum phosphat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1027, 'Attapulgit mormoiron hoạt hóa + hỗn hợp magnesi carbonat-nhôm hydroxyd', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1028, 'Bismuth', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1029, 'Cimetidin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1030, 'Famotidin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1031, 'Guaiazulen + dimethicon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1032, 'Lansoprazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1033, 'Magnesi hydroxyd + nhôm hydroxyd', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1034, 'Magnesi hydroxyd + nhôm hydroxyd + simethicon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1035, 'Magnesi trisilicat + nhôm hydroxyd', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1036, 'Nizatidin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1037, 'Omeprazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1038, 'Esomeprazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1039, 'Pantoprazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1040, 'Rabeprazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1041, 'Ranitidin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1042, 'Ranitidin + bismuth + sucralfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1043, 'Rebamipid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1044, 'Sucralfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1045, 'Dimenhydrinat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1046, 'Domperidon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1047, 'Granisetron hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1048, 'Metoclopramid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1049, 'Ondansetron', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1050, 'Palonosetron hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1051, 'Alverin citrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1052, 'Alverin citrat + simethicon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1053, 'Atropin sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1054, 'Drotaverin clohydrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1055, 'Hyoscin butylbromid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1056, 'Mebeverin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1057, 'Papaverin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1058, 'Phloroglucinol hydrat + trimethyl phloroglucinol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1059, 'Tiemonium methylsulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1060, 'Tiropramid hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1061, 'Bisacodyl', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1062, 'Docusate natri', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1063, 'Glycerol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1064, 'Lactulose', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1065, 'Macrogol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1066, 'Macrogol + natri sulfat + natri bicarbonat + natri clorid + kali clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1067, 'Magnesi sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1068, 'Monobasic natri phosphat + dibasic natri phosphat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1069, 'Sorbitol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1070, 'Sorbitol + natri citrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1071, 'Attapulgit mormoiron hoạt hóa', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1072, 'Bacillus subtilis', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1073, 'Bacillus clausii', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1074, 'Berberin (hydroclorid)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1075, 'Dioctahedral smectit', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1076, 'Diosmectit', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1077, 'Gelatin tannat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1078, 'Kẽm sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1079, 'Kẽm gluconat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1080, 'Lactobacillus acidophilus', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1081, 'Loperamid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1082, 'Nifuroxazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1083, 'Racecadotril', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1084, 'Saccharomyces boulardii', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1085, 'Cao ginkgo biloba + heptaminol clohydrat + troxerutin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1086, 'Diosmin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1087, 'Diosmin + hesperidin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1088, 'Amylase + lipase + protease', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1089, 'Citrullin malat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1090, 'Itoprid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1091, 'L-Ornithin - L- aspartat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1092, 'Mesalazin (mesalamin)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1093, 'Octreotid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1094, 'Simethicon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1095, 'Silymarin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1096, 'Somatostatin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1097, 'Terlipressin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1098, 'Trimebutin maleat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1099, 'Ursodeoxycholic acid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1100, 'Otilonium bromide', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1101, 'Beclometason (dipropional)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1102, 'Betamethason', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1103, 'Danazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1104, 'Dexamethason', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1105, 'Dexamethason phosphat + neomycin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1106, 'Betamethasone + dexchlorpheniramin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1107, 'Fludrocortison acetat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1108, 'Fluocinolon acetonid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1109, 'Hydrocortison', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1110, 'Methyl prednisolon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1111, 'Prednisolon acetat (natri phosphate)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1112, 'Prednison', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1113, 'Triamcinolon acetonid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1114, 'Triamcinolon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1115, 'Triamcinolon + econazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1116, 'Cyproteron acetat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1117, 'Somatropin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1118, 'Dydrogesteron', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1119, 'Estradiol valerate', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1120, 'Estriol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1121, 'Estrogen + norgestrel', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1122, 'Ethinyl estradiol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1123, 'Ethinyl estradiol + cyproterone acetate', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1124, 'Lynestrenol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1125, 'Nandrolon decanoat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1126, 'Norethisteron', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1127, 'Nomegestrol acetat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1128, 'Promestrien', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1129, 'Progesteron', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL);
INSERT INTO `product` (`id`, `name`, `created_user`, `updated_user`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1130, 'Raloxifen', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1131, 'Testosteron (acetat propionat, undecanoat)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1132, 'Acarbose', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1133, 'Dapagliflozin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1134, 'Empagliflozin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1135, 'Glibenclamid + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1136, 'Gliclazid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1137, 'Gliclazid + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1138, 'Glimepirid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1139, 'Glimepirid + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1140, 'Glipizid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1141, 'Insulin analog tác dụng nhanh, ngắn (Aspart, Lispro, Glulisine)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1142, 'Insulin analog tác dụng chậm, kéo dài (Glargine, Detemir, Degludec)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1143, 'Insulin analog trộn, hỗn hợp', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1144, 'Insulin người tác dụng nhanh, ngắn', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1145, 'Insulin người tác dụng trung bình, trung gian', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1146, 'Insulin người trộn, hỗn hợp', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1147, 'Linagliptin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1148, 'Linagliptin + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1149, 'Liraglutide', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1150, 'Metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1151, 'Repaglinid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1152, 'Saxagliptin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1153, 'Saxagliptin + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1154, 'Sitagliptin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1155, 'Sitagliptin + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1156, 'Vildagliptin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1157, 'Vildagliptin + metformin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1158, 'Carbimazol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1159, 'Levothyroxin (muối natri)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1160, 'Propylthiouracil (PTU)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1161, 'Thiamazol Empagliflozin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1162, 'Desmopressin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1163, 'Vasopressin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1164, 'Alglucosidase alfa', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1165, 'Immune globulin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1166, 'Huyết thanh kháng bạch hầu', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1167, 'Huyết thanh kháng dại', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1168, 'Huyết thanh kháng nọc rắn', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1169, 'Huyết thanh kháng uốn ván', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1170, 'Baclofen', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1171, 'Botulinum toxin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1172, 'Eperison', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1173, 'Mephenesin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1174, 'Pyridostigmin bromid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1175, 'Rivastigmine', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1176, 'Tizanidin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1177, 'Thiocolchicosid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1178, 'Tolperison', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1179, 'Acetazolamid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1180, 'Atropin sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1181, 'Besifloxacin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1182, 'Betaxolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1183, 'Bimatoprost', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1184, 'Bimatoprost + timolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1185, 'Brimonidin tartrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1186, 'Brimonidin tartrat + timolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1187, 'Brinzolamid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1188, 'Brinzolamid + timolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1189, 'Bromfenac', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1190, 'Carbomer', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1191, 'Cyclosporin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1192, 'Dexamethason + framycetin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1193, 'Dexpanthenol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1194, 'Dinatri inosin monophosphat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1195, 'Fluorometholon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1196, 'Glycerin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1197, 'Hexamidine di-isetionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1198, 'Hyaluronidase', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1199, 'Hydroxypropylmethylcellulose', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1200, 'Indomethacin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1201, 'Kali iodid + natri iodid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1202, 'Latanoprost', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1203, 'Latanoprost + Timolol maleat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1204, 'Loteprednol etabonat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1205, 'Moxifloxacin + dexamethason', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1206, 'Natamycin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1207, 'Natri carboxymethylcellulose (natri CMC)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1208, 'Natri carboxymethylcellulose + glycerin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1209, 'Natri clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1210, 'Natri diquafosol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1211, 'Natri hyaluronat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1212, 'Nepafenac', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1213, 'Olopatadin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1214, 'Pemirolast kali', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1215, 'Pilocarpin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1216, 'Pirenoxin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1217, 'Polyethylen glycol + propylen glycol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1218, 'Ranibizumab', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1219, 'Tafluprost', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1220, 'Tetracain', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1221, 'Tetryzolin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1222, 'Timolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1223, 'Travoprost', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1224, 'Travoprost + timolol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1225, 'Tropicamid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1226, 'Tropicamide + phenylephrine hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1227, 'Betahistin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1228, 'Cồn boric', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1229, 'Fluticason furoat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1230, 'Fluticason propionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1231, 'Naphazolin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1232, 'Natri borat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1233, 'Phenazon + lidocain hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1234, 'Rifamycin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1235, 'Tixocortol pivalat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1236, 'Triprolidin hydroclorid + pseudoephedrin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1237, 'Tyrothricin + benzocain+ benzalkonium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1238, 'Xylometazolin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1239, 'Carbetocin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1240, 'Carboprost tromethamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1241, 'Dinoproston', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1242, 'Levonorgestrel', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1243, 'Methyl ergometrin maleat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1244, 'Oxytocin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1245, 'Ergometrin (hydrogen maleat)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1246, 'Misoprostol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1247, 'Atosiban', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1248, 'Papaverin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1249, 'Salbutamol sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1250, 'Dung dịch lọc màng bụng', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1251, 'Dung dịch lọc máu dùng trong thận nhân tạo (bicarbonat hoặc acetat)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1252, 'Dung dịch lọc máu liên tục (có hoặc không có chống đông bằng citrat; có hoặc không có chứa lactat)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1253, 'Bromazepam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1254, 'Clorazepat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1255, 'Diazepam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1256, 'Etifoxin chlohydrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1257, 'Hydroxyzin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1258, 'Lorazepam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1259, 'Rotundin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1260, 'Zolpidem', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1261, 'Zopiclon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1262, 'Acid thioctic (Meglumin thioctat)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1263, 'Alprazolam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1264, 'Amisulprid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1265, 'Clorpromazin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1266, 'Clozapin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1267, 'Clonazepam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1268, 'Donepezil', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1269, 'Flupentixol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1270, 'Fluphenazin decanoat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1271, 'Haloperidol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1272, 'Levomepromazin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1273, 'Levosulpirid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1274, 'Meclophenoxat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1275, 'Olanzapin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1276, 'Quetiapin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1277, 'Risperidon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1278, 'Sulpirid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1279, 'Thioridazin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1280, 'Tofisopam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1281, 'Ziprasidon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1282, 'Zuclopenthixol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1283, 'Amitriptylin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1284, 'Citalopram', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1285, 'Clomipramin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1286, 'Fluoxetin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1287, 'Fluvoxamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1288, 'Methylphenidate hydrochloride', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1289, 'Mirtazapin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1290, 'Paroxetin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1291, 'Sertralin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1292, 'Tianeptin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1293, 'Venlafaxin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1294, 'Acetyl leucin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1295, 'Peptid (Cerebrolysin concentrate)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1296, 'Choline alfoscerat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1297, 'Citicolin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1298, 'Panax notoginseng saponins', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1299, 'Cytidin-5monophosphat disodium + uridin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1300, 'Galantamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1301, 'Ginkgo biloba', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1302, 'Mecobalamin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1303, 'Pentoxifyllin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1304, 'Piracetam', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1305, 'Vinpocetin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1306, 'Aminophylin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1307, 'Bambuterol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1308, 'Budesonid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1309, 'Budesonid + formoterol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1310, 'Fenoterol + ipratropium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1311, 'Formoterol fumarat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1312, 'Indacaterol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1313, 'lndacaterol + glycopyrronium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1314, 'Ipratropium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1315, 'Natri montelukast', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1316, 'Omalizumab', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1317, 'Salbutamol sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1318, 'Salbutamol + ipratropium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1319, 'Salmeterol + fluticason propionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1320, 'Terbutalin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1321, 'Theophylin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1322, 'Tiotropium', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1323, 'Ambroxol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1324, 'Bromhexin hydroclorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1325, 'Carbocistein', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1326, 'Carbocistein + promethazin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1327, 'Codein camphosulphonat + sulfogaiacol + cao mềm grindelia', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1328, 'Codein + terpin hydrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1329, 'Dextromethorphan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1330, 'Eprazinon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1331, 'Fenspirid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1332, 'N-acetylcystein', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1333, 'Chất ly giải vi khuẩn đông khô của Haemophilus influenzae + Diplococcus pneumoniae + Klebsiella pneumoniae and ozaenae + Staphylococcus aureus + Streptococcus pyogenes and viridans + Neisseria catarrhalis', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1334, 'Bột talc', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1335, 'Cafein citrat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1336, 'Mometason furoat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1337, 'Surfactant (Phospholipid chiết xuất từ phổi lợn hoặc phổi bò; hoặc chất diện hoạt chiết xuất từ phổi bò (Bovine lung surfactant))', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1338, 'Kali clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1339, 'Magnesi aspartat + kali aspartat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1340, 'Natri clorid + kali clorid + natri citrat + glucose khan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1341, 'Natri clorid + natri bicarbonat + kali clorid + dextrose khan', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1342, 'Acid amin*', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1343, 'Acid amin + điện giải (*)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1344, 'Acid amin + glucose + điện giải (*)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1345, 'Acid amin + glucose + lipid (*)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1346, 'Calci clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1347, 'Glucose', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1348, 'Kali clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1349, 'Magnesi sulfat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1350, 'Magnesi aspartat + kali aspartat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1351, 'Manitol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1352, 'Natri clorid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1353, 'Natri clorid + dextrose/glucose', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1354, 'Nhũ dịch lipid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1355, 'Natri clorid +- kali clorid + monobasic kali phosphat + natri acetat + magnesi sulfat + kẽm sulfat + dextrose', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1356, 'Ringer lactat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1357, 'Natri clorid + natri lactat + kali clorid + calcium clorid + glucose\n(Ringer lactat + glucose)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1358, 'Nước cất pha tiêm', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1359, 'Calci acetat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1360, 'Calci carbonat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1361, 'Calci carbonat + calci gluconolactat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1362, 'Calci carbonat + vitamin D3', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1363, 'Calci lactat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1364, 'Calci gluconat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1365, 'Calci glubionat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1366, 'Calci glucoheptonatc + vitamin D3', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1367, 'Calci gluconolactat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1368, 'Calci glycerophosphat + magnesi gluconat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1369, 'Calci-3-methyl-2-oxovalerat + calci-4-methyl-2- oxovalerat + calci-2-oxo-3-phenylpropionat + caIci-3-methyl-2-oxobutyrat + calci-DL-2-hydroxy-4-methylthiobutyrat + L-lysin acetat + L-threonin + L-tryptophan + L-histidin + L-tyrosin (*)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1370, 'Calcitriol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1371, 'Dibencozid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1372, 'Lysin + Vitamin + Khoáng chất', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1373, 'Sắt gluconat + mangan gluconat + đồng gluconat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1374, 'Sắt clorid + kẽm clorid + mangan clorid + đồng clorid + crôm clorid + natri molypdat dihydrat + natri selenid pentahydrat + natri fluorid + kali iodid', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1375, 'Tricalcium phosphat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1376, 'Vitamin A', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1377, 'Vitamin A + D2\n(Vitamin A + D3)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1378, 'Vitamin B1', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1379, 'Vitamin B1 + B6 + B12', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1380, 'Vitamin B2', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1381, 'Vitamin B3', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1382, 'Vitamin B5', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1383, 'Vitamin B6', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1384, 'Vitamin B6 + magnesi lactat', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1385, 'Vitamin B12\n(cyanocobalamin, hydroxocobalamin)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1386, 'Vitamin C', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1387, 'Vitamin D2', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1388, 'Vitamin D3', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1389, 'Vitamin E', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1390, 'Vitamin H (B8)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1391, 'Vitamin K', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1392, 'Vitamin PP', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1393, 'BromoMercurHydrxyPropan (BMHP)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1394, 'Carbon 11 (C-11)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1395, 'Cesium 137 (Cesi-137)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1396, 'Chromium 51 (Cr-51)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1397, 'Coban 57 (Co-57)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1398, 'Coban 60 (Co-60)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1399, 'Diethylene Triamine Pentaacetic acid (DTPA)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1400, 'Dimecapto Succinic Acid (DMSA)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1401, 'Dimethyl-iminodiacetic acid (HIDA)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1402, 'Diphosphono Propane Dicarboxylic acid (DPD)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1403, 'Ethyl cysteinate dimer (ECD)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1404, 'Ethylenediamine-tetramethylenephosphonic acid (EDTMP)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1405, 'Fluorine 18 Fluoro L-DOPA (F 18DOPA)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1406, 'Fluorine 18 Fluorodeoxyglucose (F-18FDG)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1407, 'F18-NaF', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1408, 'Gallium citrate 67 (Ga-67)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1409, 'Gallium citrate 68 (Ga-68)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1410, 'Hexamethylpropyleamineoxime (HMPAO)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1411, 'Holmium 166 (Ho-166)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1412, 'Human Albumin Microphere (HAM)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1413, 'Human Albumin Mini-Micropheres (HAMM)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1414, 'Human Albumin Serum (HAS, SENTI-SCINT)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1415, 'Hydroxymethylene Diphosphonate (HMDP)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1416, 'Imino Diacetic Acid (IDA)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1417, 'Indiumclorid 111 (In-111)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1418, 'Iode 123 (I-123)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1419, 'Iode 125 (I-125)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1420, 'Iode 131 (I-131)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1421, 'Iodomethyl 19 Norcholesterol', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1422, 'Iridium 192 (Ir-192)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1423, 'Keo vàng 198 (Au-198 Colloid)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1424, 'Lipiodol I-131', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1425, 'MacroAgregated Albumin (MAA)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1426, 'Mecapto Acetyl Triglicerine (MAG 3)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1427, 'Metaiodbelzylguanidine (MIBG I-131)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1428, 'Methionin', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1429, 'Methoxy isobutyl isonitrine (MIBI)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1430, 'Methylene Diphosphonate (MDP)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1431, 'Nanocis (Colloidal Rhenium Sulphide)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1432, 'Nitrogen 13-amonia', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1433, 'Octreotide Indium-111', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1434, 'Orthoiodohippurate\n(I-131OIH, Hippuran I-131)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1435, 'Osteocis\n(Hydroxymethylened phosphonate)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1436, 'Phospho 32 (P-32)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1437, 'Phospho 32 (P-32) - Silicon', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1438, 'Phytate (Phyton, Fyton)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1439, 'Pyrophosphate (Pyron)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1440, 'Rhennium 188 (Re-188)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1441, 'Rose Bengal I-131', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1442, 'Samarium 153 (Sm-153)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1443, 'Sestamibi (6-methoxy isobutyl isonitrile)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1444, 'Strontrium 89 (Sr-89)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1445, 'Sulfur Colloid (SC)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1446, 'Technetium 99m (Tc-99m)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1447, 'Teroboxime (Boronic acid adducts of technetium dioxime complexes)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1448, 'Tetrofosmin (1,2 bis (2-ethoxyethyl) phosphino) ethane', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1449, 'Thallium 201 (T1-201)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1450, 'Urea (NH2 14CoNH2)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL),
(1451, 'Ytrium 90 (Y-90)', 1, 1, '2019-10-31 10:31:08', '2019-10-31 10:31:08', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reason_reject`
--

CREATE TABLE `reason_reject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term_id` int(11) DEFAULT NULL,
  `template` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reason_reject`
--

INSERT INTO `reason_reject` (`id`, `name`, `term_id`, `template`, `created_user`, `updated_user`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'thuộc khoản Quý khách tự thanh toán', 12, '<p>&nbsp;<strong class=\"text-danger\">[##nameItem##]</strong> ,&nbsp; &nbsp;<strong class=\"text-danger\">[##amountItem##]</strong>&nbsp;&nbsp;đồng thuộc khoản Qu&yacute; kh&aacute;ch thanh to&aacute;n</p>', 1, 1, '2019-10-31 10:41:28', '2019-10-31 10:41:28', 0, NULL),
(2, 'không liên quan trực tiếp với chẩn đoán bệnh', 12, '<p>&nbsp;<strong class=\"text-danger\">[##nameItem##]</strong> , &nbsp;<strong class=\"text-danger\">[##amountItem##]</strong> đồng kh&ocirc;ng li&ecirc;n quan trực tiếp đến chẩn đo&aacute;n bệnh&nbsp; thuộc khoản loại trừ bảo hiểm C&aacute;c quy định loại trừ tr&aacute;ch nhiệm bảo hiểm của Quy tắc v&agrave; điều khoản bảo hiểm Chăm s&oacute;c sức khỏe</p>', 1, 1, '2019-10-31 10:46:09', '2019-10-31 10:46:09', 0, NULL),
(3, 'là thực phẩm chức năng', 6, '<p>&nbsp;<strong class=\"text-danger\">[##nameItem##]</strong> ,&nbsp; &nbsp;<strong class=\"text-danger\">[##amountItem##]</strong>&nbsp;v&agrave;o ng&agrave;y &nbsp;<strong class=\"text-danger\">[##Date##]</strong> c&oacute; số đăng k&yacute; &nbsp;<strong class=\"text-danger\">[##Text##]</strong> l&agrave; thực phẩm chức năng, kh&ocirc;ng phải l&agrave; thuốc n&ecirc;n kh&ocirc;ng thuộc phạm vi bảo hiểm theo điều 3.6 của Quy tắc v&agrave; điều khoản bảo hiểm Chăm s&oacute;c sức khỏe .</p>', 1, 1, '2019-10-31 10:50:38', '2019-10-31 10:50:38', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'Admin', 'web', '2019-10-31 10:13:55', '2019-10-31 10:13:55', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `description`, `is_deleted`, `created_user`, `updated_user`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '3.1', 'Các tình trạng tồn tại trước mà không được khai báo và không được Công ty chấp nhận.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(2, '3.2', 'Các tình trạng bẩm sinh và các khuyết tật khi sinh hoặc sự phát triển và sự tăng trưởng cơ thể bất thường hoặc những vấn đề về gen (bao gồm cả các chứng thoát vị cho tới 10 tuổi).', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(3, '3.3', 'Bệnh động kinh, tất cả các hình thức của tràn dịch não, tất cả các hình thức của hẹp bao quy đầu và các biến chứng của chúng, tất cả các trường hợp vẹo vách ngăn mũi.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(4, '3.4', 'Viêm khớp xương, loãng xương, vẹo cột sống và tất cả các hình thức của bệnh thoái hóa xương.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(5, '3.5', 'Phẫu thuật thẩm mỹ hoặc việc điều trị hay các biến chứng có liên quan đến việc làm đẹp bao gồm cả việc điều trị các vấn đề về da, viêm nang lông (trứng cá), rám da, tàn nhang, mụn thịt, thiếu sắc tố da, gàu.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(6, '3.6', 'Giảm cân và tăng cân, các biến chứng về rụng tóc, sẹo, tiếp nhận hoặc sử dụng mỹ phẩm có tác dụng thuốc, vitamin, khoáng chất, sữa, chất dinh dưỡng bổ sung, các chương trình kiểm soát cân nặng và điều trị hoặc phẫu thuật lựa chọn.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(7, '3.7', 'Phẫu thuật chỉnh hình, trừ khi bị thương tích do tai nạn và phẫu thuật chỉnh hình là cần thiết để khôi phục lại chức năng của Người được bảo hiểm.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(8, '3.8', 'Các dịch vụ liên quan đến vô sinh, thai sản, sinh đẻ, sẩy thai, ph thai hoặc bất kỳ nguyên nhân nào có liên quan đến thai sản, việc triệt sản hoặc kiểm tra việc triệt sản.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(9, '3.9', 'Các tình trạng có liên quan đến hội chứng suy giảm miễn dich mắc phải (AIDS) hoặc các bệnh lây truyền qua đường tình dục (STD).', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(10, '3.10', 'Điều trị hoặc phòng ngừa để giảm nhẹ các triệu chứng thông thường liên quan đến tuổi già, sự mãn kinh, loãng xương hoặc dậy thì sớm, loạn chức năng giới tính hoặc thay đổi giới tính.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(11, '3.11', 'Kiểm tra sức khỏe, chăm sóc dưỡng bệnh bao gồm cả chữa bệnh bằng cách nghỉ ngơi và việc phục hồi.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(12, '3.12', 'Bất kỳ sự điều trị, thuốc hoặc các đồ dùng y tế nào không liên quan đến chẩn đoán; và chẩn đoán không liên quan đến thương tích hoặc ốm đau hoặc không theo sự cần thiết về mặt y tế và những tiêu chuẩn thông thường.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(13, '3.13', 'Xét nghiệm bảng dị ứng cho sự không dung nạp thực phẩm, xét nghiệm các mức độ vitamin và các mức độ khoáng chất vi lượng.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(14, '3.14', 'Tất cả các chi phí y tế liên quan đến sự bất thường của thị lực bao gồm nhưng không chỉ giới hạn ở tất cả các hình thức lác mắt (lé), kính đeo mắt, kính sát tròng, phẫu thuật LASIK và bất kỳ chi phí nào có liên quan đến việc điều trị trợ giúp thị giác.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(15, '3.15', 'Bất kỳ sự điều trị nào để chẩn đoán, điều trị hoặc phòng ngừa một tình trạng nha khoa hoặc phẫu thuật chỉnh hình có liên quan đến răng, nướu hoặc hm trong trường hợp có liên quan đến răng, răng giả, cầu răng, điều trị ống chân răng, trám răng, chỉnh răng, lấy cao răng, nhổ răng và cấy implant, ngoại trừ thương tích do tai nạn đối với răng trong thời gian sản phẩm bảo hiểm bổ sung này đang có hiệu lực hoặc trừ khi được bảo hiểm theo quyền lợi chăm sóc răng của sản phẩm bảo hiểm bổ sung này. ', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(16, '3.16', 'Điều trị y tế có liên quan đến chứng nghiện rượu, sử dụng chất cĩ cồn, sử dụng và nghiện thuốc lá, ma túy hoặc các chất gây nghiện khác hoặc các chất tạo thành thói quen.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(17, '3.17', 'Điều trị y tế có liên quan đến các rối loạn thần kinh, các rối loạn tâm thần, lo âu, các vấn đề về tâm thần, các rối loạn nhân cách, các rối loạn về nói, tự kỷ, stress, các rối loạn về ăn và các tình trạng rối loạn tăng động giảm chú ý (ADHD). ', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(18, '3.18', 'Điều trị y tế mà đang trong giai đoạn thử nghiệm hoặc đang trong sự phát triển thí nghiệm.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(19, '3.19', 'Điều trị các rối loạn về ngủ, các rối loạn về thở có liên quan đến giấc ngủ bao gồm cả ngy v ngưng thở trong lúc ngủ.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(20, '3.20', 'Bất kỳ sự tiêm chủng hoặc chủng ngừa nào, ngoại trừ vắc xin bệnh dại cần thiết sau khi bị động vật tấn công hoặc chích ngừa uốn ván cần thiết sau khi bị tai nạn hoặc bị thương tật.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(21, '3.21', 'Điều trị không được xem là y học hiện đại, ngoại trừ y học thay thế được chi trả theo quyền lợi điều trị ngoại trú.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(22, '3.22', 'Bất kỳ sự điều trị y tế nào do Bác sĩ y khoa thực hiện mà người này là cha mẹ, anh chị em ruột, vợ chồng hoặc con cái của Người được bảo hiểm. Người được bảo hiểm là Bác sĩ y khoa có đăng ký sẽ không được bồi hoàn cho các điều trị do tự mình thực hiện.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(23, '3.23', 'Tự tử hoặc cố gắng tự tử, tự gây thương tích hoặc cố gắng tự gây thương tích cho dù là chính mình làm hoặc cho phép (những) người khác làm trong lúc có mất trí hay không. Điều này cũng bao gồm cả những tai nạn đối với Người được bảo hiểm do hít, sử dụng, uống, hoặc tiêm chích chất độc vào trong cơ thể hoặc sử dụng thuốc quá liều.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(24, '3.24', 'Bất kỳ tổn thất hoặc thương tích nào phát sinh từ hành động của Người được bảo hiểm dưới ảnh hưởng của chất có cồn, thuốc gây nghiện, thuốc gây mê.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(25, '3.25', 'Thương tật do các hành vi tham gia ẩu đả của Người được bảo hiểm, trừ khi chứng minh được đó là hành động phòng vệ chính đáng. ', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(26, '3.26', 'Thương tật trong khi Người được bảo hiểm phạm tội hoặc trong khi Người được bảo hiểm đang bị bắt giữ hoặc đang trốn thoát khỏi sự bắt giữ của cơ quan có thẩm quyền.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(27, '3.27', 'Các thương tật do vi phạm luật giao thông.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(28, '3.28', 'Thương tật trong khi Người được bảo hiểm tham gia thể thao chuyên nghiệp (bao gồm cả việc luyện tập cho môn thể thao đó), các môn thể thao hoặc các hoạt động nguy hiểm, và các môn thể thao tiếp xúc.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(29, '3.29', 'Thương tật trong khi Người được bảo hiểm đi lên xuống hoặc di chuyển trên một máy bay không có giấy phép chuyên chở hành khách hoặc không hoạt động như là một máy bay thương mại.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(30, '3.30', 'Thương tật trong khi Người được bảo hiểm đang lái máy bay hoặc đang làm việc trên máy bay như là một nhân viên của một công ty hàng không.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(31, '3.31', 'Thương tật trong khi Người được bảo hiểm phục vụ như là một quân nhân, cảnh sát, hoặc một người tình nguyện và tham gia vào chiến tranh hoặc ngăn chặn tội phạm.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(32, '3.32', 'Khủng bố, chiến tranh (cho dù có được tuyên bố hay không), sự xâm lược, các hành động của kẻ thù nước ngoài, nội chiến, cách mạng, nổi dậy, bạo động dân sự, dân chúng nổi dậy chống chính phủ, nổi loạn, đình công.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(33, '3.33', 'Các bức xạ ion hóa hoặc nhiễm phóng xạ từ nhiên liệu hạt nhân hoặc từ chất thải hạt nhân từ sự đốt cháy nhiên liệu hạt nhân. Phóng xạ, độc hại, nổ hoặc tính chất nguy hiểm khác của bất kỳ sự tập hợp hạt nhân dễ nổ nào hoặc thành phần hạt nhân của nó.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55'),
(34, '3.34', 'Điều trị y tế có liên quan đến việc nhiễm/ngộ độc trực tiếp hoặc gián tiếp do hóa chất hoặc thuốc.', 0, 1, 1, NULL, '2019-10-31 10:13:55', '2019-10-31 10:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@pacificcross.com.vn', NULL, '$2y$10$WeIkuVIKVFb1Y9CgZKkA9.WLPT6qzrZwnY2.TL3TvHRlXWsTw.zma', 'MZjUQYM89DIaWmXhIN2Kp8WTyUq3BMNokVnDGc6bGKoxMt0VI5bmNEl71a4i', NULL, NULL),
(2, 'thanhtinh', 'tinhnguyen@pacificcross.com.vn', NULL, '$2y$10$89V4lt4W1701/WM34nj4s.oCvW9Lak4.fLi9T0qt2LlyITJz1dO.y', 'lBC8DcCXABoGFVHuRF2HsqJdeA7DMsYdWwlWORCtUlnsYDrn6JjsvlLUOe2h', '2019-11-01 05:24:10', '2019-11-01 05:25:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claim`
--
ALTER TABLE `claim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_of_claim`
--
ALTER TABLE `item_of_claim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letter_template`
--
ALTER TABLE `letter_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `product` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `reason_reject`
--
ALTER TABLE `reason_reject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claim`
--
ALTER TABLE `claim`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_of_claim`
--
ALTER TABLE `item_of_claim`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `letter_template`
--
ALTER TABLE `letter_template`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1452;

--
-- AUTO_INCREMENT for table `reason_reject`
--
ALTER TABLE `reason_reject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
