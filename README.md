ColorMe: API client for the Japanese E-commerce platform
========================================================


Installation
------------

ColorMe is installed through [Composer](https://getcomposer.org/).



Usage
-----

### Setup

First, create an instance of ColorMe:

```php
use ColorMe\ColorMe;
$colorme = new ColorMe();
```

Then, configure its authentication object:

```php
$colorme->auth->clientId = "YOUR_CLIENT_ID";
$colorme->auth->clientSecret = "YOUR_CLIENT_SECRET";
$colorme->auth->redirectUri = "YOUR_REDIRECT_URI";
```

If you already have an access token:

```php
$colorme->auth->accessToken = "THE_ACCESS_TOKEN";
```

### Request an access token

The procedure to request an access token begins by sending the user
to the developer's website. In the following example, we include all possible
permissions in the `$scope` variable, but you can restrict the permissions to
what your application needs.

```php
$scope = array(
    'read_products',
    'write_products',
    'read_sales',
    'write_sales',
);

$url = $colorme->getAuthorizationUrl($scope);
```

With the URL, you can create a link in your website, or redirect the request to
the URL.

Once the authorization process is complete, the developer website will redirect
the user to your application, at the URL you decided as `redirect_uri`.

In case of success, an authorization code will be provided in the request as a
GET parameter. That code must be exchanged for an access token.

In case of failure, an error code and description should be provided in the request
as GET parameters.

In both cases, you can use `$colorme->auth->requestAccessToken()`.
If an error occurred, an exception will be thrown. Otherwise the function will
return the access token:

```php
try {
    $accessToken = $colorme->auth->requestAccessToken();
    // Save the access token for later use
    // The access token can also be retreived at: $colorme->auth->accessToken
} catch (\ColorMe\Exception\AuthorizationException $e) {
    // Authorization failed due to an error or user cancellation.
}
```
