<?php

namespace Weemple\SwapiImporter\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

use Weemple\SwapiImporter\Models\Planet;
use Weemple\SwapiImporter\Models\People;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swapi:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all new peoples information and their related planet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function formatText($result, $key)
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = trim($result[$key]);
        return empty($value) || $value == 'unknown' ? null : $value;
    }

    private function formatNumber($result, $key)
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = str_replace(',', '', trim($result[$key]));
        return empty($value) || $value == 'unknown' ? null : $value;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Retrieve peoples
            $url = 'https://swapi.dev/api/people';
            do {
                $client = new Client();
                $response = $client->request('GET', $url, [
                    'http_errors' => false,
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]);

                if ($response->getStatusCode() != 200) {
                    echo "Impossible to retrieve data from " . $url;
                    return -1;
                }
                
                $peoples = json_decode($response->getBody(), true);
                foreach ($peoples['results'] as $people) {
                    $planet_id = null;
                    if (!empty($people['homeworld'])) {
                        $planet_id = rtrim($people['homeworld'], '/');
                        $planet_id = substr($planet_id, strrpos($planet_id, '/') + 1);
                    }

                    if (!is_null($planet_id)) {
                        if (!Planet::where('id', $planet_id)->exists()) {
                            // Retrieve planet
                            $client = new Client();
                            $response = $client->request('GET', $people['homeworld'], [
                                'http_errors' => false,
                                'headers' => [
                                    'Accept' => 'application/json'
                                ]
                            ]);

                            if ($response->getStatusCode() != 200) {
                                echo "Impossible to retrieve data from " . $people['homeworld'];
                                return -1;
                            }
                            
                            $planet = json_decode($response->getBody(), true);
                            Planet::create([
                                'id' => $planet_id,
                                'name' => trim($planet['name']),
                                'rotation_period' => self::formatNumber($planet, 'rotation_period'),
                                'orbital_period' => self::formatNumber($planet, 'orbital_period'),
                                'diameter' => self::formatNumber($planet, 'diameter'),
                                'climate' => self::formatText($planet, 'climate'),
                                'gravity' => self::formatText($planet, 'gravity'),
                                'terrain' => self::formatText($planet, 'terrain'),
                                'surface_water' => self::formatText($planet, 'surface_water'),
                                'population' => self::formatNumber($planet, 'population'),
                            ]);
                        }
                    }

                    People::updateOrCreate([
                        'name' => trim($people['name']),
                    ], [
                        'height' => self::formatNumber($people, 'height'),
                        'mass' => self::formatNumber($people, 'mass'),
                        'hair_color' => self::formatText($people, 'hair_color'),
                        'eye_color' => self::formatText($people, 'eye_color'),
                        'birth_year' => self::formatText($people, 'birth_year'),
                        'gender' => $people['gender'] == 'male' ? 'male' : ($people['gender'] == 'female' ? 'female' : ($people['gender'] == 'n/a' ? 'n/a' : 'none')),
                        'planet_id' => $planet_id
                    ]);
                }
                $url = $peoples['next'];
            } while (!empty($url));
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return -1;
        }

        return 0;
    }
}
