<?php

class GooglePlayScraper
{
    const SCRIPT_REGEX = '/AF_initDataCallback\(.*?\).*?<\/script/';
    const KEY_REGEX = "/(ds:.*?)'/s";
    const VALUE_REGEX = '/data:(.*?), sideChannel: {}}\);/';

    public ?string $title;
    public ?string $summary;
    public ?string $installs;
    public ?string $minInstalls;
    public ?string $realInstalls;
    public ?string $score;
    public ?string $ratings;
    public ?string $reviews;
    public ?string $developer;
    public ?string $developerId;
    public ?string $developerEmail;
    public ?string $developerWebsite;
    public ?string $privacyPolicy;
    public ?string $genre;
    public ?string $genreId;
    public ?string $icon;
    public ?string $headerImage;
    public ?string $video;
    public ?string $videoImage;
    public ?string $contentRating;
    public ?string $contentRatingDescription;
    public ?string $adSupported;
    public ?string $containsAds;
    public ?string $released;
    public ?string $lastUpdatedOn;
    public ?string $updated;
    public ?string $version;

    public function __construct(string $package)
    {
        $source = $this->readHtmlSource($package);
        $details = $this->fetchPackageDetails($source);

        $this->title = $this->elementSpect($details, 5, [1, 2, 0, 0]);
        $this->summary = $this->elementSpect($details, 5, [1, 2, 73, 0, 1]);
        $this->installs = $this->elementSpect($details, 5, [1, 2, 13, 0]);
        $this->minInstalls = $this->elementSpect($details, 5, [1, 2, 13, 1]);
        $this->realInstalls = $this->elementSpect($details, 5, [1, 2, 13, 2]);
        $this->score = $this->elementSpect($details, 5, [1, 2, 51, 0, 1]);
        $this->ratings = $this->elementSpect($details, 5, [1, 2, 51, 2, 1]);
        $this->reviews = $this->elementSpect($details, 5, [1, 2, 51, 3, 1]);
        $this->developer = $this->elementSpect($details, 5, [1, 2, 68, 0]);
        $this->developerId = explode('id=', $this->elementSpect($details, 5, [1, 2, 68, 1, 4, 2]))[1];
        $this->developerEmail = $this->elementSpect($details, 5, [1, 2, 69, 1, 0]);
        $this->developerWebsite = $this->elementSpect($details, 5, [1, 2, 69, 0, 5, 2]);
        $this->privacyPolicy = $this->elementSpect($details, 5, [1, 2, 99, 0, 5, 2]);
        $this->genre = $this->elementSpect($details, 5, [1, 2, 79, 0, 0, 0]);
        $this->genreId = $this->elementSpect($details, 5, [1, 2, 79, 0, 0, 2]);
        $this->icon = $this->elementSpect($details, 5, [1, 2, 95, 0, 3, 2]);
        $this->headerImage = $this->elementSpect($details, 5, [1, 2, 96, 0, 3, 2]);
        $this->video = $this->elementSpect($details, 5, [1, 2, 100, 0, 0, 3, 2]);
        $this->videoImage = $this->elementSpect($details, 5, [1, 2, 100, 1, 0, 3, 2]);
        $this->contentRating = $this->elementSpect($details, 5, [1, 2, 9, 0]);
        $this->contentRatingDescription = $this->elementSpect($details, 5, [1, 2, 9, 2, 1]);
        $this->adSupported = $this->elementSpect($details, 5, [1, 2, 48]) == true;
        $this->containsAds = $this->elementSpect($details, 5, [1, 2, 48]) == true;
        $this->released = $this->elementSpect($details, 5, [1, 2, 10, 0]);
        $this->lastUpdatedOn = $this->elementSpect($details, 5, [1, 2, 145, 0, 0]);
        $this->updated = $this->elementSpect($details, 5, [1, 2, 145, 0, 1, 0]);
        $this->version = $this->elementSpect($details, 5, [1, 2, 140, 0, 0, 0], "Varies with device");
    }

    protected function fetchPackageDetails(string $source): array
    {

        $map = [];
        preg_match_all(static::SCRIPT_REGEX, $source, $scripts_matches);

        foreach ($scripts_matches[0] as $script) {
            preg_match(static::KEY_REGEX, $script, $key_matches);
            $key = $key_matches[1];
            preg_match(static::VALUE_REGEX, $script, $value_matches);
            $value = $value_matches[1];
            if (is_string($value) && json_validate($value)) {
                $map[$key] = json_decode($value, true);
            }
        }

        return $map;

    }

    protected function readHtmlSource(string $package): string
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://play.google.com/store/apps/details?id=$package");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    protected function elementSpect(array $source, string $ds_num, array $data_map, $fallback_value = null): ?string
    {
        $source = $source["ds:$ds_num"];
        $value = $this->nestedLook($source, $data_map);
        return $value ?? $fallback_value;
    }

    protected function nestedLook(array $source, array $indexs): mixed
    {
        try {
            if (count($indexs) == 1) {
                return $source[$indexs[0]];
            }

            return $this->nestedLook($source[$indexs[0]], array_slice($indexs, 1));
        } catch (TypeError | Exception $e) {
        }
        return null;
    }

}
