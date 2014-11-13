CHANGELOG
=========

v1.1
----

1. Fixed the PUT requests.
   Guzzle doesn't provide the same type of body that is used for POST requests.
   Also, the API requires the request to be sent as a json encoded string and
   therefore requires a `Content-Type: application/json` header.
