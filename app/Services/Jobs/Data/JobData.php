<?php

namespace App\Services\Jobs\Data;

class JobData
{
    public function __construct(
        public readonly string $source,
        public readonly ?string $externalId,
        public readonly string $title,
        public readonly string $company,
        public readonly string $locationText,
        public readonly string $companyUrl,
        public readonly string $url,
        public readonly string $description,
        public readonly string $datePosted,
        public readonly bool $isRemote,
        public readonly array $payload,
    ) {}

    public function fingerprint(): string
    {
        return sha1(implode('|', [
            $this->source,
            $this->externalId ?? $this->url,
            $this->title,
            $this->company,
            $this->url,
        ]));
    }
}
