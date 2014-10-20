ColorMe: API client for カラーミー
=================================

カラーミー (Color Me) is a Japanese eCommerce platform.
An API is provided to access products, categories, sales, deliveries, etc.

Homepage: https://shop-pro.jp

Developer: https://api.shop-pro.jp/developers/sign_in



Installation
------------

ColorMe API client is installed through [Composer](https://getcomposer.org/).

The package is not submitted to Packagist yet. Please include the repository url
in composer.json:

```json
"require": {
    "fredfilo/colorme": "1.*"
},
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/fredfilo/colorme"
    }
]
```



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




### Request resources

Requesting resources is made by calling the corresponding function of the
ColorMe instance. For example, if you want a list of products,
call `$response = $colorme->products()->get();`.
You will receive a `ColorMe\Response` object.

```php
try {

    $response = $colorme->products()->get();

    // You can use the total, offset and limit values to create a pagination
    // system.
    $total = $response->total;
    $offset = $response->offset;
    $limit = $response->limit;

    // Use the `items` property to access the products.
    foreach ($response->items as $product) {
        var_dump($product);
    }

    // You can also use an alias that takes the name of the resource.
    // For example, for the `products` resource, you can use the `products`
    // property:
    foreach ($response->products as $product) {
        var_dump($product);
    }

} catch (\Exception $e) {
    // The request failed
    var_dump($e);
}
```

By default, the `offset` is set to __0__ and `limit` is set to __10__.
You can change those values by sending filters:

```php
try {

    $filters = array(
        "offset" => 10,
        "limit" => 20,
    );

    $response = $colorme->products()->get($filters);

    // ...

} catch (\Exception $e) {
    // ...
}
```




### Request a single resource

You can request a single resource, by setting the resource's `id` like this
(in the following example, the id is 1234):

```php
try {

    $response = $colorme->products(1234)->get();
    $product = $response->item;

    // Just like accessing many resources, you can use the resource alias:
    $product = $response->product;

} catch (\Exception $e) {
    // ...
}
```




