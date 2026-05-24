<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        "birth_year",
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
}
