<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Employee;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController
{
    public function surveyorDashboard()
    {
        $employee = Auth::user();

        $clientMapPoints = $this->clientsAssignedToSurveyor($employee)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'client_id', 'first_name', 'middle_name', 'last_name', 'suffix', 'survey_status', 'latitude', 'longitude'])
            ->filter(fn ($client) => is_numeric($client->latitude) && is_numeric($client->longitude))
            ->map(fn ($client) => [
                'id' => $client->id,
                'client_id' => $client->client_id,
                'name' => $this->formatClientName($client),
                'survey_status' => $client->survey_status ?? 'pending',
                'latitude' => (float) $client->latitude,
                'longitude' => (float) $client->longitude,
                'url' => route('surveyor.clients.show', $client),
            ])
            ->values();

        return view('private.surveyor-dashboard', compact('employee', 'clientMapPoints'));
    }

    public function showForSurveyor(Client $client)
    {
        $employee = Auth::user();

        abort_unless($this->clientBelongsToSurveyor($client, $employee), 403);

        $clientMapPoint = null;
        if (is_numeric($client->latitude) && is_numeric($client->longitude)) {
            $clientMapPoint = [
                'id' => $client->id,
                'client_id' => $client->client_id,
                'name' => $this->formatClientName($client),
                'latitude' => (float) $client->latitude,
                'longitude' => (float) $client->longitude,
            ];
        }

        return view('private.surveyor-client-show', compact('employee', 'client', 'clientMapPoint'));
    }

    private function clientsAssignedToSurveyor($employee)
    {
        return Client::query()
            ->where(function ($query) use ($employee) {
                $query->where('surveyed_by', $employee->id);

                if (!empty($employee->district)) {
                    $query->orWhere('district', $employee->district);
                }

                if (!empty($employee->district_code)) {
                    $cityCodes = DB::table('city_municipality')
                        ->where('district_code', $employee->district_code)
                        ->pluck('code');

                    if ($cityCodes->isNotEmpty()) {
                        $query->orWhereIn('city_municipality', $cityCodes);
                    }
                }
            });
    }

    private function clientBelongsToSurveyor(Client $client, $employee): bool
    {
        if ((string) $client->surveyed_by === (string) $employee->id) {
            return true;
        }

        if (!empty($employee->district) && (string) $client->district === (string) $employee->district) {
            return true;
        }

        if (!empty($employee->district_code) && !empty($client->city_municipality)) {
            return DB::table('city_municipality')
                ->where('district_code', $employee->district_code)
                ->where('code', $client->city_municipality)
                ->exists();
        }

        return false;
    }

    private function formatClientName(Client $client): string
    {
        return collect([
            $client->first_name,
            $client->middle_name,
            $client->last_name,
            $client->suffix && $client->suffix !== '--N/A--' ? $client->suffix : null,
        ])->filter()->implode(' ') ?: 'Unnamed Client';
    }

    public function getByBarangay(Request $request)
    {
        $barangayCode = $request->query('barangay_code');
        if (!$barangayCode) {
            return response()->json([]);
        }

        $clients = Client::where('barangay', $barangayCode)
            ->orderBy('created_at', 'desc')
            ->get();

        // Resolve location names from codes
        $regionCodes = $clients->pluck('region')->unique()->filter();
        $provinceCodes = $clients->pluck('province')->unique()->filter();
        $cityCodes = $clients->pluck('city_municipality')->unique()->filter();
        $barangayCodes = $clients->pluck('barangay')->unique()->filter();

        $regionNames = $regionCodes->isNotEmpty()
            ? DB::table('region')->whereIn('code', $regionCodes)->pluck('name', 'code')
            : collect();
        $provinceNames = $provinceCodes->isNotEmpty()
            ? DB::table('province')->whereIn('code', $provinceCodes)->pluck('name', 'code')
            : collect();
        $cityNames = $cityCodes->isNotEmpty()
            ? DB::table('city_municipality')->whereIn('code', $cityCodes)->pluck('name', 'code')
            : collect();
        $barangayNames = $barangayCodes->isNotEmpty()
            ? DB::table('barangay')->whereIn('code', $barangayCodes)->pluck('name', 'code')
            : collect();

        $result = $clients->map(function ($client) use ($regionNames, $provinceNames, $cityNames, $barangayNames) {
            return [
                'id' => $client->id,
                'client_id' => $client->client_id,
                'first_name' => $client->first_name,
                'middle_name' => $client->middle_name,
                'last_name' => $client->last_name,
                'suffix' => $client->suffix,
                'category_of_client' => $client->category_of_client,
                'msme_classification' => $client->msme_classification,
                'status_of_client' => $client->status_of_client,
                'created_at' => $client->created_at,
                'show_url' => route('surveyor.clients.show', $client),
                'region_name' => $regionNames[$client->region] ?? $client->region,
                'province_name' => $provinceNames[$client->province] ?? $client->province,
                'city_name' => $cityNames[$client->city_municipality] ?? $client->city_municipality,
                'barangay_name' => $barangayNames[$client->barangay] ?? $client->barangay,
            ];
        });

        return response()->json($result);
    }


    //Creates client record
    public function mergeToCentralDatabase(Request $request) {

        $validated = $request->validate([
            "statusOfClient"                   => "nullable",
            "specifyLevel"                     => "nullable",
            "categoryOfClient"                 => "nullable",
            "socialClassification"             => "nullable",
            "diffAbledType"                    => "nullable",
            "isSenior"                         => "nullable",
            "isIndigeneous"                    => "nullable",
            "levelOfDigitalization"            => "nullable",
            "digitalTools"                     => "nullable",
            "msmeClassification"               => "nullable",
            "clientDesignation"                => "nullable",
            "firstName"                        => "nullable",
            "middleName"                       => "nullable",
            "lastName"                         => "nullable",
            "suffix"                           => "nullable",
            "civilStatus"                      => "nullable",
            "sex"                              => "nullable",
            "birthdate"                        => "nullable",
            "citizenship"                      => "nullable",
            "id"                               => "nullable", // Client ID
            "dtiKonekId"                       => "nullable",
            "philippineIdentificationSystem"   => "nullable",
            "regionCode"                       => "nullable",
            "provinceCode"                     => "nullable",
            "cityMunicipalityCode"             => "nullable",
            "barangayCode"                     => "nullable",
            "district"                         => "nullable",
            "zipCode"                          => "nullable",
            "address"                          => "nullable",
            "latitude"                         => "nullable",
            "longitude"                        => "nullable",
            "locationAccuracy"                 => "nullable",
            "locationCapturedAt"               => "nullable",
            "mobileNumber"                     => "nullable",
            "emailAddress"                     => "nullable",
            "landlineNumber"                   => "nullable",
            "faxNumber"                        => "nullable",
            "socialMedia"                      => "nullable",
            "website"                          => "nullable",
            "eCommercePlatform"                => "nullable",
            "surveyed_by"                      => "nullable"
        ]);

        $client = Client::create([
            // Client Classification
            'status_of_client'                 => $validated['statusOfClient'] ?? null,
            'specify_level'                    => $validated['specifyLevel'] ?? null,
            'category_of_client'               => $validated['categoryOfClient'] ?? null,
            'social_classification'            => $validated['socialClassification'] ?? null,
            'diff_abled_type'                  => $validated['diffAbledType'] ?? null,
            'client_is_senior'                 => isset($validated['isSenior']) ? true : false,
            'client_is_indigeneous'            => isset($validated['isIndigeneous']) ? true : false,

            // MSME & Digitalization
            'level_of_digitalization'          => $validated['levelOfDigitalization'] ?? null,
            'digital_tools'                    => $validated['digitalTools'] ?? null,
            'msme_classification'              => $validated['msmeClassification'] ?? null,
            'client_designation'               => $validated['clientDesignation'] ?? null,

            // Personal Information
            'first_name'                       => $validated['firstName'] ?? null,
            'middle_name'                      => $validated['middleName'] ?? null,
            'last_name'                        => $validated['lastName'] ?? null,
            'suffix'                           => $validated['suffix'] ?? null,
            'civil_status'                     => $validated['civilStatus'] ?? null,
            'sex'                              => $validated['sex'] ?? null,
            'birthdate'                        => $validated['birthdate'] ?? null,
            'citizenship'                      => $validated['citizenship'] ?? 'Filipino',

            // Identifiers (client_id is auto-generated by the Client model)
            //old_client_id'                    => $validated['oldId'] ?? null,
            //'dti_konek_id'                     => $validated['dtiKonekId'] ?? null,
            'philippine_identification_system' => $validated['philippineIdentificationSystem'] ?? null,

            // Contact Details
            'mobile_number'                    => $validated['mobileNumber'] ?? null,
            'email_address'                    => $validated['emailAddress'] ?? null,
            'landline_number'                  => $validated['landlineNumber'] ?? null,
            'fax_number'                       => $validated['faxNumber'] ?? null,
            'social_media'                     => $validated['socialMedia'] ?? null,
            'website'                          => $validated['website'] ?? null,
            'e_commerce_platform'              => $validated['eCommercePlatform'] ?? null,

            // Location
            'region'                           => $validated['regionCode'] ?? null,
            'province'                         => $validated['provinceCode'] ?? null,
            'city_municipality'                => $validated['cityMunicipalityCode'] ?? null,
            'barangay'                         => $validated['barangayCode'] ?? null,
            'district'                         => $validated['district'] ?? null,
            'zip_code'                         => $validated['zipCode'] ?? null,
            'address'                          => $validated['address'] ?? null,
            'latitude'                         => $validated['latitude'] ?? null,
            'longitude'                        => $validated['longitude'] ?? null,

            //surveyor
            'survey_status'                    => 'pending',
            'surveyed_by'                      => $validated['surveyed_by'] ?? null,
        ]);
        

        //Updates the surveyor's location after saving the client
        //IF the client has a latitude and longitude and the account role is "ROLE_SURVEYOR"
        if (
            is_numeric($validated['latitude'] ?? null) &&
            is_numeric($validated['longitude'] ?? null) &&
            !empty($validated['surveyed_by'])
        ) {
            Employee::whereKey($validated['surveyed_by'])
                ->where('role', 'ROLE_SURVEYOR')
                ->update([
                    'current_latitude' => $validated['latitude'],
                    'current_longitude' => $validated['longitude'],
                    'current_location_updated_at' => now(),
                ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client data synced successfully']);
        }

        return redirect() -> back() -> with('success', 'Client data successfully sent to the central database');
    }


    //Updates the survey status of the client
    //then returns the admin to the #verification section of the page
    public function updateSurveyStatus(Request $request, Client $client)
    {
        $validated = $request->validate([
            'survey_status' => 'required|in:pending,verified,rejected,returned',
        ]);

        $client->update([
            'survey_status' => $validated['survey_status'],
            'updated_at' => now(),
        ]);

        return redirect()
            ->to(route('admin') . '#verification')
            ->with('success', 'Client verification status updated.');
    }

    
    //Updates client information returned to the surveyor
    //Then updates surveyor's location
    public function updateReturnedForSurveyor(Request $request, Client $client)
    {
        //Retrieves the currently logged-in user's information
        $employee = Auth::user();

        //Safety check
        //Aborts the operation if the condition below meets the requirements
        abort_unless(
            $employee &&
            (string) $client->surveyed_by === (string) $employee->id &&
            ($client->survey_status ?? null) === 'returned',
            403
        );

        $validated = $request->validate([
            "statusOfClient" => "nullable",
            "specifyLevel" => "nullable",
            "categoryOfClient" => "nullable",
            "socialClassification" => "nullable",
            "diffAbledType" => "nullable",
            "isSenior" => "nullable",
            "isIndigeneous" => "nullable",
            "levelOfDigitalization" => "nullable",
            "digitalTools" => "nullable",
            "msmeClassification" => "nullable",
            "clientDesignation" => "nullable",
            "firstName" => "nullable",
            "middleName" => "nullable",
            "lastName" => "nullable",
            "suffix" => "nullable",
            "civilStatus" => "nullable",
            "sex" => "nullable",
            "birthdate" => "nullable",
            "citizenship" => "nullable",
            "philippineIdentificationSystem" => "nullable",
            "regionCode" => "nullable",
            "provinceCode" => "nullable",
            "cityMunicipalityCode" => "nullable",
            "barangayCode" => "nullable",
            "district" => "nullable",
            "zipCode" => "nullable",
            "address" => "nullable",
            "latitude" => "nullable",
            "longitude" => "nullable",
            "mobileNumber" => "nullable",
            "emailAddress" => "nullable",
            "landlineNumber" => "nullable",
            "faxNumber" => "nullable",
            "socialMedia" => "nullable",
            "website" => "nullable",
            "eCommercePlatform" => "nullable",
        ]);

        $client->update([
            'status_of_client' => $validated['statusOfClient'] ?? null,
            'specify_level' => $validated['specifyLevel'] ?? null,
            'category_of_client' => $validated['categoryOfClient'] ?? null,
            'social_classification' => $validated['socialClassification'] ?? null,
            'diff_abled_type' => $validated['diffAbledType'] ?? null,
            'client_is_senior' => ($validated['isSenior'] ?? null) === 'Yes',
            'client_is_indigeneous' => ($validated['isIndigeneous'] ?? null) === 'Yes',
            'level_of_digitalization' => $validated['levelOfDigitalization'] ?? null,
            'digital_tools' => $validated['digitalTools'] ?? null,
            'msme_classification' => $validated['msmeClassification'] ?? null,
            'client_designation' => $validated['clientDesignation'] ?? null,
            'first_name' => $validated['firstName'] ?? null,
            'middle_name' => $validated['middleName'] ?? null,
            'last_name' => $validated['lastName'] ?? null,
            'suffix' => $validated['suffix'] ?? null,
            'civil_status' => $validated['civilStatus'] ?? null,
            'sex' => $validated['sex'] ?? null,
            'birthdate' => $validated['birthdate'] ?? null,
            'citizenship' => $validated['citizenship'] ?? 'Filipino',
            'philippine_identification_system' => $validated['philippineIdentificationSystem'] ?? null,
            'region' => $validated['regionCode'] ?? null,
            'province' => $validated['provinceCode'] ?? null,
            'city_municipality' => $validated['cityMunicipalityCode'] ?? null,
            'barangay' => $validated['barangayCode'] ?? null,
            'district' => $validated['district'] ?? null,
            'zip_code' => $validated['zipCode'] ?? null,
            'address' => $validated['address'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'mobile_number' => $validated['mobileNumber'] ?? null,
            'email_address' => $validated['emailAddress'] ?? null,
            'landline_number' => $validated['landlineNumber'] ?? null,
            'fax_number' => $validated['faxNumber'] ?? null,
            'social_media' => $validated['socialMedia'] ?? null,
            'website' => $validated['website'] ?? null,
            'e_commerce_platform' => $validated['eCommercePlatform'] ?? null,
            'updated_at' => now(),
        ]);

        // Update surveyor location on the map, same as the new-survey flow
        if (
            is_numeric($validated['latitude'] ?? null) &&
            is_numeric($validated['longitude'] ?? null)
        ) {
            Employee::where('id', $employee->id)
                ->where('role', 'ROLE_SURVEYOR')
                ->update([
                    'current_latitude' => $validated['latitude'],
                    'current_longitude' => $validated['longitude'],
                    'current_location_updated_at' => now(),
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Returned client record updated.',
        ]);
    }



    //Sends a returned client survey back to the central database
    //Changes the client's survey_status from 'returned' to 'pending'
    //Also updates the surveyor's location on the admin map
    public function sendBackReturnedSurvey(Request $request, Client $client)
    {
        $employee = Auth::user();

        //Safety check: the surveyor must own this record and it must still be 'returned'
        abort_unless(
            $employee &&
            (string) $client->surveyed_by === (string) $employee->id &&
            ($client->survey_status ?? null) === 'returned',
            403
        );

        $validated = $request->validate([
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        //Update the client's survey status back to 'pending'
        $client->update([
            'survey_status' => 'pending',
            'updated_at'    => now(),
        ]);

        //Update the surveyor's location on the admin map
        if (
            is_numeric($validated['latitude'] ?? null) &&
            is_numeric($validated['longitude'] ?? null)
        ) {
            Employee::where('id', $employee->id)
                ->where('role', 'ROLE_SURVEYOR')
                ->update([
                    'current_latitude'            => $validated['latitude'],
                    'current_longitude'            => $validated['longitude'],
                    'current_location_updated_at' => now(),
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Returned client survey sent back for verification.',
        ]);
    }


    //Removes client information
    public function destroyRejected(Client $client)
    {
        if (($client->survey_status ?? 'pending') !== 'rejected') {
            return redirect()
                ->to(route('admin') . '#verification')
                ->withErrors(['client' => 'Only rejected client records can be deleted.']);
        }

        $client->delete();

        return redirect()
            ->to(route('admin') . '#verification')
            ->with('success', 'Rejected client record deleted.');
    }
}
