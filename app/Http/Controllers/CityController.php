<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
    public function importCities(Request $request)
    {
        $data = $request->json()->all();

        if (isset($data['cities'])) {
            foreach ($data['cities'] as $cityData) {
                City::updateOrCreate(
                    ['id' => $cityData['id']],
                    [
                        'name' => $cityData['name'],
                        'country' => $cityData['country'],
                        'admin1' => $cityData['admin1'],
                        'lat' => $cityData['lat'],
                        'lon' => $cityData['lon'],
                        'pop' => $cityData['pop'],
                    ]
                );
            }
        }

        return response()->json(['message' => 'Cities imported successfully'], 201);
    }

    public function importCities2(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);

        $filePath = $request->input('file_path');

        // Đảm bảo đường dẫn file là đúng
        if (!Storage::exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Đọc nội dung file
        $jsonContent = Storage::get($filePath);
        $data = json_decode($jsonContent, true);

        // Kiểm tra và import dữ liệu
        if (isset($data['cities'])) {
            foreach ($data['cities'] as $cityData) {
                City::updateOrCreate(
                    ['id' => $cityData['id']],
                    [
                        'name' => $cityData['name'],
                        'country' => $cityData['country'],
                        'admin1' => $cityData['admin1'],
                        'lat' => $cityData['lat'],
                        'lon' => $cityData['lon'],
                        'pop' => $cityData['pop'],
                    ]
                );
            }
        }

        return response()->json(['message' => 'Cities imported successfully'], 201);
    }
}

