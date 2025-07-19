<?php

namespace App\Services\Lightcast;

use App\Enums\LogDiscordTypeEnum;
use App\Models\Skill;
use App\Utility\LogDiscordUtility;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LightcastSkillServiceImpl implements LightcastSkillService
{
    private string $cachePrefix = "skill-set-";

    /**
     * @inheritDoc
     */
    public function searchSkill(string $searchTerm): SkillCollection
    {
        if (empty($searchTerm)) {
            throw new Exception("Search term must be defined to find skills");
        }

        $searchTerm = str($searchTerm)->lower();

        $token = $this->auth();
        $url = config('lightcast-skill.searchSkillUrl');
        $cacheKey = $this->cachePrefix . $searchTerm;

        $result = Cache::get($cacheKey);

        // Check if result is cached
        if ($result) {
            return $result;
        }

        // Build query parameters for API request
        $query = [
            "typeIds" => config("lightcast-skill.typeIds"),
            "fields" => config("lightcast-skill.fields"),
            "limit" => config("lightcast-skill.limit"),
            "q" => $searchTerm,
        ];

        // Attempt API request twice if the first attempt fails
        for ($i = 0; $i < 2; $i++) {
            try {
                $response = Http::withHeader("Authorization", "Bearer $token")->get($url, $query);

                // Check for unsuccessful response status
                if ($response->status() >= 400) {
                    sleep(1); // Pause before retrying
                    if ($i == 1) {
                        // Fallback to database on second failure
                        return $this->getFromDB($searchTerm);
                    }
                    continue;
                }
                // Transform API response data into a collection
                $result = collect($response->json("data", []))->map(function ($item) {
                    return [
                        "lightcast_id" => $item['id'],
                        "skill_name" => $item['name'],
                    ];
                });

                // get existing skill from database
                $existingSkills = DB::table('skills')
                    ->distinct()
                    ->pluck('lightcast_id')
                    ->toArray();


                // check if skill already on database
                $readyToInsertDB = [];
                foreach ($result as $item) {
                    if (!in_array($item['lightcast_id'], $existingSkills)) {
                        array_push($readyToInsertDB, $item);
                    }
                }

                // Optionally store results in database
                // DB::table("skills")->upsert($result->toArray(), ['lightcast_id'], ['skill_name']);

                if (count($readyToInsertDB) > 0) {
                    DB::table('skills')->insert($readyToInsertDB);
                }
                $skills = $this->getFromDB($searchTerm);

                // Cache the result for 3 days
                Cache::put($cacheKey, $skills, now()->addDays(3));
                return $skills;
            } catch (\Throwable $th) {
                // Log the error and fallback to database on failure
                LogDiscordUtility::sendLog(LogDiscordTypeEnum::ERROR, "Error fetching searchSkill", LogDiscordUtility::jTraceEx($th));
                return $this->getFromDB($searchTerm);
            }
        }

        // Fallback to database as final return
        return $this->getFromDB($searchTerm);
    }

    /**
     * Retrieve skills from the database based on a search term.
     *
     * @param string $searchTerm The term to search for.
     * @return SkillCollection A collection of skills matching the search term from the database.
     */
    private function getFromDB(string $searchTerm): SkillCollection
    {
        return Skill::where("skill_name", "like", "%$searchTerm%")
            ->orderBy("skill_name")->limit(config('lightcast-skill.limit'))
            ->get();
    }

    /**
     * Authenticate with the Lightcast API and retrieve a bearer token.
     *
     * @return string The authentication token.
     * @throws Exception If authentication fails due to server or client error.
     */
    private function auth(): string
    {
        // Retrieve cached token if available
        $token = Cache::get("lightcast_token");

        if ($token) {
            return $token;
        }

        // Authenticate with Lightcast API to get a new token
        $url = config('lightcast-skill.authUrl');
        $response = Http::asForm()->post($url, [
            "client_id" => config("lightcast-skill.clientId"),
            "client_secret" => config("lightcast-skill.clientSecret"),
            "grant_type" => "client_credentials",
            "scope" => config("lightcast-skill.scope"),
        ]);

        // Handle failed authentication response
        if ($response->status() >= 400) {
            $message = $response->status() >= 500 ? "Error on Lightcast server." : "Invalid authentication data.";
            throw new Exception($message);
        }

        // Parse response and cache token with expiration time
        $result = $response->json();
        Cache::put("lightcast_token", $result["access_token"], now()->addSeconds($result["expires_in"]));

        return $result["access_token"];
    }
}
