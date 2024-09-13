INSERT INTO `accounts` (`id`, `account_no`, `name`, `initial_balance`, `total_balance`, `note`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '019912229', 'Sales Account', 0, 0, 'This is the default account.', 1, 1, '2023-02-05 07:12:15', '2023-02-05 07:12:15');

INSERT INTO `billers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test Biller', NULL, 'Test Company', NULL, 'test@gmail.com', '12312', 'Test address', 'Test City', NULL, NULL, NULL, 1, '2023-05-28 06:53:51', '2023-05-28 06:53:51');

INSERT INTO `brands` (`id`, `title`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test Brand', NULL, 1, '2023-05-28 06:51:38', '2023-05-28 06:51:38');

INSERT INTO `categories` (`id`, `name`, `image`, `parent_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test Category', NULL, NULL, 1, '2023-05-28 06:51:00', '2023-05-28 06:51:00');

INSERT INTO `customers` (`id`, `customer_group_id`, `user_id`, `name`, `company_name`, `email`, `phone_number`, `tax_no`, `address`, `city`, `state`, `postal_code`, `country`, `points`, `is_active`, `created_at`, `updated_at`, `deposit`, `expense`) VALUES
(1, 1, NULL, 'John Doe', 'Test Company', 'john@gmail.com', '231312', NULL, 'Test address', 'Test City', NULL, NULL, NULL, NULL, 1, '2023-05-28 06:53:04', '2023-05-28 06:53:04', NULL, NULL);

INSERT INTO `customer_groups` (`id`, `name`, `percentage`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'General', '0', 1, '2023-05-28 06:51:29', '2023-05-28 06:51:29');

INSERT INTO `currencies` (`id`, `name`, `code`, `exchange_rate`, `created_at`, `updated_at`) VALUES
(1, 'US Dollar', 'USD', 1, '2020-11-01 00:22:58', '2020-11-01 00:34:55');

INSERT INTO `external_services` (`id`, `name`, `type`, `details`, `active`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', 'payment', 'Client ID,Client Secret;AU-pRAZjrZ7nl667IgXPVtqxmPUEI1REtA7nBSbarnwpf31Sk5Pf87qqGwR2AlqwlgTkI-AE8bE7hNr7,wxyz5678', 1, NULL, NULL),
(2, 'Stripe', 'payment', 'Public Key,Private Key;pk_test_51Md63PExArnuChIZi2smeN9IRcIQST5B5MoJ3IDaiQyXPkCY0nlclwIbtbEse4xv3isONK4CieQwUHmM7AcOr9WU00TfA1pfDv,sk_test_51Md63PExArnuChIZuvQRKVz0SrCjYb7DdDjsQXAU9ErJe1c0AkEitGTxCjTH9H9CCGMV3W9KSmeI3EX6hONUnojv00o6wViuoS', 1, NULL, NULL),
(3, 'Razorpay', 'payment', 'Key,Secret;rzp_test_Y4MCcpHfZNU6rR,3Hr7SDqaZ0G5waN0jsLgsiLx', 1, NULL, NULL),
(4, 'Paystack', 'payment', 'public_Key,Secret_Key;pk_test_e8d220b7463d64569f0053e78534f38e6b10cf4a,sk_test_6d62cb976e1e0ab43f1e48b2934b0dfc7f32a1fe', 1, NULL, NULL),
(5, 'Mpesa', 'payment', 'consumer_Key,consumer_Secret;fhfgkj,dtrddhd', 1, NULL, NULL),
(6, 'Mollie', 'payment', 'api_key;test_dHar4XY7LxsDOtmnkVtjNVWXLSlXsM', 1, NULL, NULL);

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `is_rtl`, `currency`, `package_id`, `subscription_type`, `staff_access`, `date_format`, `developed_by`, `invoice_format`, `state`, `theme`, `modules`, `created_at`, `updated_at`, `currency_position`, `expiry_date`) VALUES
(1, 'SalePro POS SaaS', '20231113033910.png', 0, '1', 1, 'monthly', 'own', 'd/m/Y', 'LionCoders inc', 'standard', 1, 'default.css', 'ecommerce', '2018-07-06 06:13:11', '2022-09-05 06:59:05', 'prefix', '2024-09-20');

INSERT INTO `roles` (`id`, `name`, `description`, `guard_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin can access all data...', 'web', 1, '2018-06-01 23:46:44', '2018-06-02 23:13:05'),
(2, 'Owner', 'Staff of shop', 'web', 1, '2018-10-22 02:38:13', '2022-02-01 13:13:30'),
(4, 'staff', 'staff has specific acess...', 'web', 1, '2018-06-02 00:05:27', '2022-02-01 13:13:04'),
(5, 'Customer', NULL, 'web', 1, '2020-11-05 06:43:16', '2020-11-15 00:24:15');

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'products-edit', 'web', '2018-06-03 01:00:09', '2018-06-03 01:00:09'),
(5, 'products-delete', 'web', '2018-06-03 22:54:22', '2018-06-03 22:54:22'),
(6, 'products-add', 'web', '2018-06-04 00:34:14', '2018-06-04 00:34:14'),
(7, 'products-index', 'web', '2018-06-04 03:34:27', '2018-06-04 03:34:27'),
(8, 'purchases-index', 'web', '2018-06-04 08:03:19', '2018-06-04 08:03:19'),
(9, 'purchases-add', 'web', '2018-06-04 08:12:25', '2018-06-04 08:12:25'),
(10, 'purchases-edit', 'web', '2018-06-04 09:47:36', '2018-06-04 09:47:36'),
(11, 'purchases-delete', 'web', '2018-06-04 09:47:36', '2018-06-04 09:47:36'),
(12, 'sales-index', 'web', '2018-06-04 10:49:08', '2018-06-04 10:49:08'),
(13, 'sales-add', 'web', '2018-06-04 10:49:52', '2018-06-04 10:49:52'),
(14, 'sales-edit', 'web', '2018-06-04 10:49:52', '2018-06-04 10:49:52'),
(15, 'sales-delete', 'web', '2018-06-04 10:49:53', '2018-06-04 10:49:53'),
(16, 'quotes-index', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(17, 'quotes-add', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(18, 'quotes-edit', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(19, 'quotes-delete', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(20, 'transfers-index', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(21, 'transfers-add', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(22, 'transfers-edit', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(23, 'transfers-delete', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(24, 'returns-index', 'web', '2018-06-04 22:50:24', '2018-06-04 22:50:24'),
(25, 'returns-add', 'web', '2018-06-04 22:50:24', '2018-06-04 22:50:24'),
(26, 'returns-edit', 'web', '2018-06-04 22:50:25', '2018-06-04 22:50:25'),
(27, 'returns-delete', 'web', '2018-06-04 22:50:25', '2018-06-04 22:50:25'),
(28, 'customers-index', 'web', '2018-06-04 23:15:54', '2018-06-04 23:15:54'),
(29, 'customers-add', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(30, 'customers-edit', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(31, 'customers-delete', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(32, 'suppliers-index', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(33, 'suppliers-add', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(34, 'suppliers-edit', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(35, 'suppliers-delete', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(36, 'product-report', 'web', '2018-06-24 23:05:33', '2018-06-24 23:05:33'),
(37, 'purchase-report', 'web', '2018-06-24 23:24:56', '2018-06-24 23:24:56'),
(38, 'sale-report', 'web', '2018-06-24 23:33:13', '2018-06-24 23:33:13'),
(39, 'customer-report', 'web', '2018-06-24 23:36:51', '2018-06-24 23:36:51'),
(40, 'due-report', 'web', '2018-06-24 23:39:52', '2018-06-24 23:39:52'),
(41, 'users-index', 'web', '2018-06-25 00:00:10', '2018-06-25 00:00:10'),
(42, 'users-add', 'web', '2018-06-25 00:00:10', '2018-06-25 00:00:10'),
(43, 'users-edit', 'web', '2018-06-25 00:01:30', '2018-06-25 00:01:30'),
(44, 'users-delete', 'web', '2018-06-25 00:01:30', '2018-06-25 00:01:30'),
(45, 'profit-loss', 'web', '2018-07-14 21:50:05', '2018-07-14 21:50:05'),
(46, 'best-seller', 'web', '2018-07-14 22:01:38', '2018-07-14 22:01:38'),
(47, 'daily-sale', 'web', '2018-07-14 22:24:21', '2018-07-14 22:24:21'),
(48, 'monthly-sale', 'web', '2018-07-14 22:30:41', '2018-07-14 22:30:41'),
(49, 'daily-purchase', 'web', '2018-07-14 22:36:46', '2018-07-14 22:36:46'),
(50, 'monthly-purchase', 'web', '2018-07-14 22:48:17', '2018-07-14 22:48:17'),
(51, 'payment-report', 'web', '2018-07-14 23:10:41', '2018-07-14 23:10:41'),
(52, 'warehouse-stock-report', 'web', '2018-07-14 23:16:55', '2018-07-14 23:16:55'),
(53, 'product-qty-alert', 'web', '2018-07-14 23:33:21', '2018-07-14 23:33:21'),
(54, 'supplier-report', 'web', '2018-07-30 03:00:01', '2018-07-30 03:00:01'),
(55, 'expenses-index', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(56, 'expenses-add', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(57, 'expenses-edit', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(58, 'expenses-delete', 'web', '2018-09-05 01:07:11', '2018-09-05 01:07:11'),
(59, 'general_setting', 'web', '2018-10-19 23:10:04', '2018-10-19 23:10:04'),
(60, 'mail_setting', 'web', '2018-10-19 23:10:04', '2018-10-19 23:10:04'),
(61, 'pos_setting', 'web', '2018-10-19 23:10:04', '2018-10-19 23:10:04'),
(62, 'hrm_setting', 'web', '2019-01-02 10:30:23', '2019-01-02 10:30:23'),
(63, 'purchase-return-index', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(64, 'purchase-return-add', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(65, 'purchase-return-edit', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(66, 'purchase-return-delete', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(67, 'account-index', 'web', '2019-01-02 22:06:13', '2019-01-02 22:06:13'),
(68, 'balance-sheet', 'web', '2019-01-02 22:06:14', '2019-01-02 22:06:14'),
(69, 'account-statement', 'web', '2019-01-02 22:06:14', '2019-01-02 22:06:14'),
(70, 'department', 'web', '2019-01-02 22:30:01', '2019-01-02 22:30:01'),
(71, 'attendance', 'web', '2019-01-02 22:30:01', '2019-01-02 22:30:01'),
(72, 'payroll', 'web', '2019-01-02 22:30:01', '2019-01-02 22:30:01'),
(73, 'employees-index', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(74, 'employees-add', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(75, 'employees-edit', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(76, 'employees-delete', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(77, 'user-report', 'web', '2019-01-16 06:48:18', '2019-01-16 06:48:18'),
(78, 'stock_count', 'web', '2019-02-17 10:32:01', '2019-02-17 10:32:01'),
(79, 'adjustment', 'web', '2019-02-17 10:32:02', '2019-02-17 10:32:02'),
(80, 'sms_setting', 'web', '2019-02-22 05:18:03', '2019-02-22 05:18:03'),
(81, 'create_sms', 'web', '2019-02-22 05:18:03', '2019-02-22 05:18:03'),
(82, 'print_barcode', 'web', '2019-03-07 05:02:19', '2019-03-07 05:02:19'),
(83, 'empty_database', 'web', '2019-03-07 05:02:19', '2019-03-07 05:02:19'),
(84, 'customer_group', 'web', '2019-03-07 05:37:15', '2019-03-07 05:37:15'),
(85, 'unit', 'web', '2019-03-07 05:37:15', '2019-03-07 05:37:15'),
(86, 'tax', 'web', '2019-03-07 05:37:15', '2019-03-07 05:37:15'),
(87, 'gift_card', 'web', '2019-03-07 06:29:38', '2019-03-07 06:29:38'),
(88, 'coupon', 'web', '2019-03-07 06:29:38', '2019-03-07 06:29:38'),
(89, 'holiday', 'web', '2019-10-19 08:57:15', '2019-10-19 08:57:15'),
(90, 'warehouse-report', 'web', '2019-10-22 06:00:23', '2019-10-22 06:00:23'),
(91, 'warehouse', 'web', '2020-02-26 06:47:32', '2020-02-26 06:47:32'),
(92, 'brand', 'web', '2020-02-26 06:59:59', '2020-02-26 06:59:59'),
(93, 'billers-index', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(94, 'billers-add', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(95, 'billers-edit', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(96, 'billers-delete', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(97, 'money-transfer', 'web', '2020-03-02 05:41:48', '2020-03-02 05:41:48'),
(98, 'category', 'web', '2020-07-13 12:13:16', '2020-07-13 12:13:16'),
(99, 'delivery', 'web', '2020-07-13 12:13:16', '2020-07-13 12:13:16'),
(100, 'send_notification', 'web', '2020-10-31 06:21:31', '2020-10-31 06:21:31'),
(101, 'today_sale', 'web', '2020-10-31 06:57:04', '2020-10-31 06:57:04'),
(102, 'today_profit', 'web', '2020-10-31 06:57:04', '2020-10-31 06:57:04'),
(103, 'currency', 'web', '2020-11-09 00:23:11', '2020-11-09 00:23:11'),
(104, 'backup_database', 'web', '2020-11-15 00:16:55', '2020-11-15 00:16:55'),
(105, 'reward_point_setting', 'web', '2021-06-27 04:34:42', '2021-06-27 04:34:42'),
(106, 'revenue_profit_summary', 'web', '2022-02-08 13:57:21', '2022-02-08 13:57:21'),
(107, 'cash_flow', 'web', '2022-02-08 13:57:22', '2022-02-08 13:57:22'),
(108, 'monthly_summary', 'web', '2022-02-08 13:57:22', '2022-02-08 13:57:22'),
(109, 'yearly_report', 'web', '2022-02-08 13:57:22', '2022-02-08 13:57:22'),
(110, 'discount_plan', 'web', '2022-02-16 09:12:26', '2022-02-16 09:12:26'),
(111, 'discount', 'web', '2022-02-16 09:12:38', '2022-02-16 09:12:38'),
(112, 'product-expiry-report', 'web', '2022-03-30 05:39:20', '2022-03-30 05:39:20'),
(113, 'purchase-payment-index', 'web', '2022-06-05 14:12:27', '2022-06-05 14:12:27'),
(114, 'purchase-payment-add', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(115, 'purchase-payment-edit', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(116, 'purchase-payment-delete', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(117, 'sale-payment-index', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(118, 'sale-payment-add', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(119, 'sale-payment-edit', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(120, 'sale-payment-delete', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(121, 'all_notification', 'web', '2022-06-05 14:12:29', '2022-06-05 14:12:29'),
(122, 'sale-report-chart', 'web', '2022-06-05 14:12:29', '2022-06-05 14:12:29'),
(123, 'dso-report', 'web', '2022-06-05 14:12:29', '2022-06-05 14:12:29'),
(124, 'product_history', 'web', '2022-08-25 14:04:05', '2022-08-25 14:04:05'),
(125, 'supplier-due-report', 'web', '2022-08-31 09:46:33', '2022-08-31 09:46:33'),
(126, 'custom_field', 'web', '2023-11-13 06:23:34', '2023-11-13 06:23:34'),
(127, 'incomes-index', 'web', '2024-07-11 13:16:43', '2024-07-11 13:16:43'),
(128, 'incomes-add', 'web', '2024-07-11 13:16:44', '2024-07-11 13:16:44'),
(129, 'incomes-edit', 'web', '2024-07-11 13:16:44', '2024-07-11 13:16:44'),
(130, 'incomes-delete', 'web', '2024-07-11 13:16:44', '2024-07-11 13:16:44'),
(131, 'packing_slip_challan', 'web', '2024-07-22 14:16:17', '2024-07-22 14:16:17');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 1),(5, 1),(6, 1),(7, 1),(8, 1),(9, 1),(10, 1),(11, 1),(12, 1),(13, 1),(14, 1),(15, 1),(28, 1),(29, 1),(30, 1),(31, 1),(32, 1),(33, 1),(34, 1),(35, 1),(41, 1),(42, 1),(43, 1),(44, 1),(59, 1),(60, 1),(61, 1),(80, 1),(81, 1),(82, 1),(83, 1),(84, 1),(85, 1),(86, 1),(87, 1),(88, 1),(91, 1),(92, 1),(93, 1),(94, 1),(95, 1),(96, 1),(98, 1),(100, 1),(101, 1),(102, 1),(103, 1),(104, 1),(105, 1),(106, 1),(107, 1),(108, 1),(109, 1),(110, 1),(111, 1),(113, 1),(114, 1),(115, 1),(116, 1),(117, 1),(118, 1),(119, 1),(120, 1),(121, 1),(124, 1),(126, 1),(131, 1),(24,1),(25,1),(26,1),(27,1),(63,1),(64,1),(65,1),(66,1),(55,1),(56,1),(57,1),(58,1),(127,1),(128,1),(129,1),(130,1),(20,1),(21,1),(22,1),(23,1),(16,1),(17,1),(18,1),(19,1),(99,1),(78,1),(79,1),(36,1),(37,1),(38,1),(39,1),(40,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(77,1),(90,1),(112,1),(122,1),(123,1),(125,1),(62,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(89,1),(67,1),(68,1),(69,1),(97,1);

INSERT INTO `pos_setting` (`id`, `customer_id`, `warehouse_id`, `biller_id`, `product_number`, `keybord_active`, `stripe_public_key`, `stripe_secret_key`, `paypal_live_api_username`, `paypal_live_api_password`, `paypal_live_api_secret`, `payment_options`, `invoice_option`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 1, NULL, NULL, NULL, NULL, NULL, 'cash,card,cheque,gift_card,deposit,paypal', 'thermal', '2023-05-28 06:57:03', '2023-05-28 06:57:03');

INSERT INTO `products` (`id`, `name`, `code`, `type`, `barcode_symbology`, `brand_id`, `category_id`, `unit_id`, `purchase_unit_id`, `sale_unit_id`, `cost`, `price`, `qty`, `alert_quantity`, `daily_sale_objective`, `promotion`, `promotion_price`, `starting_date`, `last_date`, `tax_id`, `tax_method`, `image`, `file`, `is_embeded`, `is_variant`, `is_batch`, `is_diffPrice`, `is_imei`, `featured`, `product_list`, `variant_list`, `qty_list`, `price_list`, `product_details`, `variant_option`, `variant_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test Product', '11486508', 'standard', 'C128', 1, 1, 1, 1, 1, 10, 20, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '<p>This is a test product.</p>', NULL, NULL, 1, '2023-05-28 06:55:37', '2023-05-28 07:00:57');

INSERT INTO `product_purchases` (`id`, `purchase_id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `qty`, `recieved`, `purchase_unit_id`, `net_unit_cost`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, 10, 10, 1, 10, 0, 10, 10, 110, '2023-05-28 06:59:29', '2023-05-28 06:59:29');

INSERT INTO `product_warehouse` (`id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `warehouse_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(1, '1', NULL, NULL, NULL, 1, 10, 20, '2023-05-28 06:59:29', '2023-05-28 07:00:57');

INSERT INTO `purchases` (`id`, `reference_no`, `user_id`, `warehouse_id`, `supplier_id`, `currency_id`, `exchange_rate`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_cost`, `order_tax_rate`, `order_tax`, `order_discount`, `shipping_cost`, `grand_total`, `paid_amount`, `status`, `payment_status`, `document`, `note`, `created_at`, `updated_at`) VALUES
(1, 'pr-20230528-125929', 1, 1, NULL, 1, 1, 1, 10, 0, 10, 110, 0, 0, 0, 0, 110, 0, 1, 1, NULL, NULL, '2023-05-28 06:59:29', '2023-05-28 06:59:29');

INSERT INTO `suppliers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', NULL, 'Test Company', NULL, 'john@gmail.com', '231312', 'Test address', 'Test City', NULL, NULL, NULL, 1, '2023-05-28 06:53:04', '2023-05-28 06:53:04');

INSERT INTO `taxes` (`id`, `name`, `rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'VAT 10%', 10, 1, '2023-05-28 06:52:08', '2023-05-28 06:52:08');

INSERT INTO `units` (`id`, `unit_code`, `unit_name`, `base_unit`, `operator`, `operation_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pc', 'piece', NULL, '*', 1, 1, '2023-05-28 06:51:50', '2023-05-28 06:51:50');

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `phone`, `company_name`, `role_id`, `biller_id`, `warehouse_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'tata2', 'tatadev@gmail.com', '$2y$10$skuLDDlQKBQwh3XMvkBzCemdgQS/nzn0/s/HjD1aakH.4P/LLaeAS', '6mN44MyRiQZfCi0QvFFIYAU9LXIUz9CdNIlrRS5Lg8wBoJmxVu8auzTP42ZW', '3894755345',  'tatadev2', 1, NULL, NULL, 1, 0, '2018-06-02 03:24:15', '2018-09-05 00:14:15');

INSERT INTO `warehouses` (`id`, `name`, `phone`, `email`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test Shop', '9991111', NULL, 'Test address', 1, '2023-05-28 06:51:19', '2023-05-28 06:51:19');
