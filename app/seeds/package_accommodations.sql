

INSERT INTO `package_accommodations` (`id`, `package_id`, `city_id`, `country_id`, `accommodation_type`, `rooms`, `checkin`, `checkout`, `nights`, `hotel_name`, `area_name`, `room_type`, `room_view`, `stars`, `note`, `other_services`, `created_at`, `updated_at`) VALUES
(1, 1, 32, 17, 'apartment', '[]', '2018-11-12', '2018-11-22', 10, NULL, 'mohram bek', NULL, NULL, NULL, NULL, '[{\"rent_car\": true, \"car_level\": \"premium\", \"need_tours\": false, \"car_with_driver\": false}]', '2018-11-13 12:34:39', '2018-11-13 12:34:39'),
(2, 1, 48, 9, 'hotel', '[{\"adults\": 2, \"children\": [{\"id\": 1, \"age\": \"child -12 years\"}], \"room_number\": 1}, {\"adults\": 1, \"children\": [{\"id\": 0, \"age\": \"child -6 years\"}], \"room_number\": 2}]', '2018-11-22', '2018-12-18', 26, 'plaza', 'montaza', 'Standard', 'Garden View', 5, NULL, '[{\"rent_car\": true, \"car_level\": \"premium\", \"need_tours\": false, \"car_with_driver\": true}]', '2018-11-13 12:34:39', '2018-11-13 12:34:39'),
(3, 1, 84, 21, 'hotel', '[]', '2018-12-18', '2019-01-28', 41, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"rent_car\": false, \"car_level\": null, \"need_tours\": false, \"car_with_driver\": false}]', '2018-11-13 12:34:39', '2018-11-13 12:34:39');
COMMIT;
