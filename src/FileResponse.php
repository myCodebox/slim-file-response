<?php

namespace MyCodebox\SlimFileResponsePlus;

use Slim\Http\Response;
use Slim\Http\Stream;

/**
 * Class FileResponse
 * @package MyCodebox\SlimFileResponsePlus
 */
class FileResponse
{
    /**
     * @param Response $response
     * @param string $fileName
     *
     * @param null $outputName
     * @param null $notFoundImage
     * @return Response|static
     */
    public static function getResponse(Response $response, $fileName, $outputName = null, $notFoundImagePath = null)
    {
        if (!$fd = fopen($fileName, "r")) {
            $fileName = !is_null($notFoundImagePath) ? $notFoundImagePath : __DIR__."/file_not_found.png";
        }

        if ($fd = fopen($fileName, "r")) {
            $size = filesize($fileName);
            $path_parts = pathinfo($fileName);
            $ext = strtolower($path_parts["extension"]);

            if (!$outputName) {
                $outputName = $path_parts["basename"];
            } else {
                if (count(explode('.', $outputName)) <= 1) {
                    $outputName = $outputName.'.'.$ext;
                }
            }

            switch ($ext) {
                case "pdf":
                    $response = $response->withHeader("Content-type", "application/pdf");
                    break;

                case "png":
                    $response = $response->withHeader("Content-type", "image/png");
                    break;

                case "gif":
                    $response = $response->withHeader("Content-type", "image/gif");
                    break;

                case "jpeg":
                    $response = $response->withHeader("Content-type", "image/jpeg");
                    break;

                case "jpg":
                    $response = $response->withHeader("Content-type", "image/jpg");
                    break;

                case "mp3":
                    $response = $response->withHeader("Content-type", "audio/mpeg");
                    break;

                default:
                    $response = $response->withHeader("Content-type", "application/octet-stream");
                    break;
            }

            $response = $response->withHeader("Content-Disposition", 'filename="'.$outputName.'"');
            $response = $response->withHeader("Cache-control", "private");
            $response = $response->withHeader("Content-length", $size);

        } else {

            return $response->withStatus(404);

        }

        $stream = new Stream($fd);

        $response = $response->withBody($stream);

        return $response;
    }
}
