<?php

namespace App\Services\Kraken;

use Kraken as Client;
use Illuminate\Http\UploadedFile;
use App\Services\Kraken\Exceptions\InvalidUrlException;

final class Kraken
{
    private readonly Client $client;

    public function __construct()
    {
        $config = config('kraken');

        $this->client = new Client($config['api_key'], $config['api_secret']);
    }

    public function optimizeImageUpload(UploadedFile $image): string
    {
        $params = $this->getParams();
        $params['file'] = $image->getPathname();

        $response = $this->client->upload($params);

        return $response['kraked_url'];
    }

    /**
     * @throws InvalidUrlException
     */
    public function optimizeImageUrl(string $url): string
    {
        $params = $this->getParams();
        $params['url'] = $url;

        $response = $this->client->url($params);

        if (! isset($response['kraked_url'])) {
            throw new InvalidUrlException(
                'Provided url is invalid.'
            );
        }

        return $response['kraked_url'];
    }

    private function getParams(): array
    {
        $config = config('aws-s3');

        return [
            'wait' => true,
            'lossy' => true,
            'resize' => [
                'width' => 70,
                'height' => 70,
                'strategy' => 'fit',
            ],
            "s3_store" => [
                "key" => $config['key'],
                "secret" => $config['secret'],
                "bucket" => $config['bucket'],
                "region" => $config['region'],
                'path' => 'images/' . uniqid() . '.jpeg',
            ],
        ];
    }
}
