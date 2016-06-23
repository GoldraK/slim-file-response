<?php

namespace mhndev\slimFileResponse;

use Slim\Http\Response;
use Slim\Http\Stream;

/**
 * Class FileResponse
 * @package mhndev\slimFileResponse
 */
class FileResponse
{
    /**
     * @param Response $response
     * @param string $fileName
     *
     * @return Response|static
     */
    public static function getResponse(Response $response, $fileName)
    {
        if ($fd = fopen ($fileName, "r")) {

            $size = filesize($fileName);
            $path_parts = pathinfo($fileName);
            $ext = strtolower($path_parts["extension"]);


            switch ($ext) {
                case "pdf":
                    $response = $response->withHeader("Content-type","application/pdf");
                    break;

                case "png":
                    $response = $response->withHeader("Content-type","image/png");
                    break;

                case "gif":
                    $response = $response->withHeader("Content-type","image/gif");
                    break;

                case "jpeg":
                    $response = $response->withHeader("Content-type","image/jpeg");
                    break;

                case "jpg":
                    $response = $response->withHeader("Content-type","image/jpg");
                    break;

                case "mp3":
                    $response = $response->withHeader("Content-type","audio/mpeg");
                    break;

                default;
                    $response = $response->withHeader("Content-Disposition","attachment; filename=\"".$path_parts["basename"]."\"");
                    $response = $response->withHeader("Content-type","application/octet-stream");
                    $response = $response->withHeader("Content-Disposition","filename=\"".$path_parts["basename"]."\"");
                    break;
            }
            $response = $response->withHeader("Cache-control","private");
            $response = $response->withHeader("Content-length",$size);

        }

        $stream = new Stream($fd);

        $response = $response->withBody($stream);

        return $response;
    }
}