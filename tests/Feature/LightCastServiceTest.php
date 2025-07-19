<?php

use App\Services\Lightcast\LightcastSkillService;
use App\Services\Lightcast\SkillCollection;

// Test dependency injection with the real singleton instance

it('can search for a skill using the singleton instance', function () {
    $lightcastSkillService = app(LightcastSkillService::class);

    $searchTerm = 'PHP';
    // Call the method on the singleton instance
    $result = $lightcastSkillService->searchSkill($searchTerm);

    expect($result)->toBeInstanceOf(SkillCollection::class);
});
