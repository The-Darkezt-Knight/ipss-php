<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    protected $table = 'client';

    protected $fillable = [
        "old_client_id",
        "client_id",
        "date_created",
        "status_of_client",
        "specify_level",
        "category_of_client",
        "social_classification",
        "diff_abled_type",
        "client_is_senior",
        "client_is_indigeneous",
        "level_of_digitalization",
        "digital_tools",
        "msme_classification",
        "client_designation",
        "first_name",
        "middle_name",
        "last_name",
        "suffix",
        "civil_status",
        "sex",
        "birthdate",
        "citizenship",
        "dti_konek_id",
        "philippine_identification_system",
        "region",
        "province",
        "city_municipality",
        "barangay",
        "district",
        "zip_code",
        "address",
        "latitude",
        "longitude",
        "landline_number",
        "fax_number",
        "mobile_number",
        "email_address",
        "social_media",
        "website",
        "e_commerce_platform",
        "surveyed_by"
    ];

    /**
     * City/Municipality PSGC code → 3-letter prefix mapping.
     * Used to auto-generate location-based client IDs (e.g. BCD-0000001).
     */
    protected static array $cityPrefixMap = [
        // Cities
        '064501000' => 'BCD',  // City of Bacolod
        '064502000' => 'BGO',  // City of Bago
        '064504000' => 'CDZ',  // City of Cadiz
        '064509000' => 'ESC',  // City of Escalante
        '064510000' => 'HMA',  // City of Himamaylan
        '064515000' => 'KBK',  // City of Kabankalan
        '064516000' => 'LCT',  // City of La Carlota
        '064523000' => 'SGY',  // City of Sagay
        '064524000' => 'SNC',  // City of San Carlos
        '064526000' => 'SLY',  // City of Silay
        '064527000' => 'SIP',  // City of Sipalay
        '064528000' => 'TLS',  // City of Talisay
        '064531000' => 'VIC',  // City of Victorias

        // Municipalities
        '064503000' => 'BNB',  // Binalbagan
        '064505000' => 'CLV',  // Calatrava
        '064506000' => 'CND',  // Candoni
        '064507000' => 'CUY',  // Cauayan
        '064532000' => 'DSB',  // Salvador Benedicto (Don Salvador Benedicto)
        '064508000' => 'EBM',  // Enrique B. Magalona (E.B. Magalona)
        '064511000' => 'HIN',  // Hinigaran
        '064512000' => 'HNB',  // Hinoba-An
        '064513000' => 'ILG',  // Ilog
        '064514000' => 'ISB',  // Isabela
        '064517000' => 'LCS',  // La Castellana
        '064518000' => 'MNP',  // Manapla
        '064519000' => 'MPD',  // Moises Padilla
        '064520000' => 'MRC',  // Murcia
        '064521000' => 'PTV',  // Pontevedra
        '064522000' => 'PLP',  // Pulupandan
        '064525000' => 'SNE',  // San Enrique
        '064529000' => 'TBS',  // Toboso
        '064530000' => 'VLD',  // Valladolid
    ];

    /**
     * Boot the model and register the `creating` event
     * to auto-generate the location-based client_id.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Client $client) {
            // Only generate if client_id is not already set
            if (!empty($client->client_id)) {
                return;
            }

            $cityCode = $client->city_municipality;
            $prefix = static::$cityPrefixMap[$cityCode] ?? 'UNK';

            // Find the highest existing sequence number for this prefix
            $lastClient = static::where('client_id', 'like', $prefix . '-%')
                ->orderByRaw("CAST(SUBSTRING(client_id FROM '[0-9]+$') AS INTEGER) DESC")
                ->first();

            if ($lastClient && preg_match('/(\d+)$/', $lastClient->client_id, $matches)) {
                $nextNumber = (int) $matches[1] + 1;
            } else {
                $nextNumber = 1;
            }

            $client->client_id = $prefix . '-' . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);
        });
    }
}
