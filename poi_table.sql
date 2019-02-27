

CREATE TABLE `poi` (
  `id` int(11) NOT NULL,
  `name` varchar(160) CHARACTER SET utf8 NOT NULL,
  `lat` decimal(10,8) NOT NULL COMMENT 'latitiude',
  `lng` decimal(10,8) NOT NULL COMMENT 'longitiude',
  `city` varchar(160) CHARACTER SET utf8 DEFAULT NULL,
  `country_code` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `street` varchar(160) CHARACTER SET utf8 DEFAULT NULL,
  `street_number` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `poi`
--
ALTER TABLE `poi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `poi`
--
ALTER TABLE `poi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
