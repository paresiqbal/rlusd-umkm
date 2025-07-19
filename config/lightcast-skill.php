<?php

return [
    "clientId" => env("LIGHTCAST_CLIENT_ID"),
    "clientSecret" => env("LIGHTCAST_CLIENT_SECRET"),
    "scope" => env("LIGHTCAST_SCOPE"),
    "version" => env("LIGHTCAST_SKILL_VERSION", "latest"),
    "typeIds" => "ST1,ST2",
    "fields" => "id,name",
    "limit" => 30,
    "authUrl" => "https://auth.emsicloud.com/connect/token",
    "searchSkillUrl" => "https://emsiservices.com/skills/versions/" . env('LIGHTCAST_SKILL_VERSION', 'latest') . "/skills",
];
