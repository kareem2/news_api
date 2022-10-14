## News API

News API is a simple api to retentive new from https://newsapi.org/ 

### Endpoints
There is only one endpoint for the API:<br>
`/api/news`<br>
The API can accept a `query` parameter to search on the news.

### Authentication
The API uses [HTTP Basic Authentication](https://en.wikipedia.org/wiki/Basic_access_authentication) the request must contain a header field in the form of Authorization: Basic <credentials>, where credentials is the Base64 encoding of email and password joined by a single colon.
