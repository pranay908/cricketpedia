This consists of 2 apis first to shorten the API the other to fetch the shorten API.

You can use URL shorten by using the api /api/shortenurl with post params {"url":"Url needs to shorten"} along with Authorization named key in the HTTP header. This API will return the short url for the long url provided.

You can then use the short url provided using simple GET to access the actual long url.

You need the following DB Table in order to run this.

CREATE TABLE `short_urls` (
  `id` int(11) NOT NULL,
  `long_url` text COLLATE utf8_unicode_ci NOT NULL,
  `short_code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `short_urls`
--
ALTER TABLE `short_urls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `short_urls`
--
ALTER TABLE `short_urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;