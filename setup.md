This consists of 2 apis first to shorten the API the other to fetch the shorten API.

You can use URL shorten by using the api /api/shortenurl with post params {"url":"Url needs to shorten"} along with Authorization named key in the HTTP header. This API will return the short url for the long url provided.

You can then use the short url provided using simple GET to access the actual long url.

