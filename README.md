# Slim Framework File Response Plus v1.0.1

Slim Framework 3 File Response with Fallback Image or 404 Not Found

## Install via composer

```sh
composer require mycodebox/slim-file-response-plus
```

## Sample usage

```php
<?php

// path returns  a PNG
$app->get('/test/image', function ($request, $response) {

    $filePath = $_SERVER["DOCUMENT_ROOT"]. "/path/to/your/image/file.png";

    return \MyCodebox\SlimFileResponse\FileResponse::getResponse($response, $filePath);
});

// path returns  a PDF file
$app->get('/test/pdf', function ($request, $response) {

    $filePath = $_SERVER["DOCUMENT_ROOT"]. "/path/to/your/pdf/file.pdf";

    return mhndev\slimFileResponse\FileResponse::getResponse($response, $filePath, 'myDocument');
});

// path returns  the given `filename` attribute
$app->get('/test/file/{filename}', function ($request, $response) {

    $fileName = $request->getAttribute('filename');
    $filePath = $_SERVER["DOCUMENT_ROOT"]. "/path/to/your/file/$fileName";

    return \MyCodebox\SlimFileResponse\FileResponse::getResponse($response, $filePath);
});

// path returns a `file_not_found.png` in case the given file is not found
$app->get('/test/file/{filename}', function ($request, $response) {

    $notFound = $_SERVER["DOCUMENT_ROOT"]. "/path/to/your/image/file_not_found.png";
    $fileName = $request->getAttribute('filename');
    $filePath = $_SERVER["DOCUMENT_ROOT"]. "/path/to/your/file/$fileName";
    $caching  = true; // default is false - withLastModified( filemtime(fileName) )

    return \MyCodebox\SlimFileResponse\FileResponse::getResponse($response, $filePath, null, $notFound, $caching);
});
```
