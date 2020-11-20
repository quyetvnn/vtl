
DROP TABLE IF EXISTS `booster_pay_dollars`;
CREATE TABLE `booster_pay_dollars` (
  `id` int(255) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `prc` text,
  `src` text,
  `Ord` text,
  `Ref` varchar(255) NOT NULL,
  `PayRef` varchar(255) NOT NULL,
  `successcode` text NOT NULL COMMENT '0: succeed;',
  `Amt` decimal(12,2) NOT NULL,
  `Cur` text NOT NULL,
  `Holder` text,
  `AuthId` text NOT NULL,
  `AlertCode` text,
  `remark` text,
  `eci` text,
  `payerAuth` text,
  `sourceIp` text NOT NULL,
  `ipCountry` text NOT NULL,
  `payMethod` text NOT NULL,
  `TxTime` datetime DEFAULT NULL,
  `panFirst4` text,
  `panLast4` int(11) NOT NULL,
  `cardIssuingCountry` text,
  `channelType` text,
  `MerchantId` text NOT NULL,
  `secureHash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booster_pay_dollars`
--
ALTER TABLE `booster_pay_dollars`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booster_pay_dollars`
--
ALTER TABLE `booster_pay_dollars`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_schools` CHANGE `credit_ratio` `credit_charge` DECIMAL(12,2) NULL DEFAULT NULL COMMENT 'number need pay by school when one student join this live';