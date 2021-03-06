<?php

namespace engine;

class timezone extends singleton {

    private $tz_data = array();

    /**
     * Get all available zone => utc_offset data as array ['zone' => 'utc-offset', ... ]
     * @return array
     */
    public function getZoneUTC() {
        return $this->tz_data;
    }

    /**
     * Get all available zones
     * @return array
     */
    public function getZone() {
        return array_keys($this->tz_data);
    }

    /**
     * Get UTC/GMT offset for zone
     * @param $zone
     * @return array|null
     */
    public function getUTCforZone($zone) {
        return $this->tz_data[$zone];
    }

    public function init() {
        // generated in 22.10.2014 with FFCMS dev tools
        $this->tz_data = array(
            'Africa/Abidjan' => 'UTC/GMT +00:00',
            'Africa/Accra' => 'UTC/GMT +00:00',
            'Africa/Addis_Ababa' => 'UTC/GMT +03:00',
            'Africa/Algiers' => 'UTC/GMT +01:00',
            'Africa/Asmara' => 'UTC/GMT +03:00',
            'Africa/Bamako' => 'UTC/GMT +00:00',
            'Africa/Bangui' => 'UTC/GMT +01:00',
            'Africa/Banjul' => 'UTC/GMT +00:00',
            'Africa/Bissau' => 'UTC/GMT +00:00',
            'Africa/Blantyre' => 'UTC/GMT +02:00',
            'Africa/Brazzaville' => 'UTC/GMT +01:00',
            'Africa/Bujumbura' => 'UTC/GMT +02:00',
            'Africa/Cairo' => 'UTC/GMT +02:00',
            'Africa/Casablanca' => 'UTC/GMT +00:00',
            'Africa/Ceuta' => 'UTC/GMT +02:00',
            'Africa/Conakry' => 'UTC/GMT +00:00',
            'Africa/Dakar' => 'UTC/GMT +00:00',
            'Africa/Dar_es_Salaam' => 'UTC/GMT +03:00',
            'Africa/Djibouti' => 'UTC/GMT +03:00',
            'Africa/Douala' => 'UTC/GMT +01:00',
            'Africa/El_Aaiun' => 'UTC/GMT +00:00',
            'Africa/Freetown' => 'UTC/GMT +00:00',
            'Africa/Gaborone' => 'UTC/GMT +02:00',
            'Africa/Harare' => 'UTC/GMT +02:00',
            'Africa/Johannesburg' => 'UTC/GMT +02:00',
            'Africa/Juba' => 'UTC/GMT +03:00',
            'Africa/Kampala' => 'UTC/GMT +03:00',
            'Africa/Khartoum' => 'UTC/GMT +03:00',
            'Africa/Kigali' => 'UTC/GMT +02:00',
            'Africa/Kinshasa' => 'UTC/GMT +01:00',
            'Africa/Lagos' => 'UTC/GMT +01:00',
            'Africa/Libreville' => 'UTC/GMT +01:00',
            'Africa/Lome' => 'UTC/GMT +00:00',
            'Africa/Luanda' => 'UTC/GMT +01:00',
            'Africa/Lubumbashi' => 'UTC/GMT +02:00',
            'Africa/Lusaka' => 'UTC/GMT +02:00',
            'Africa/Malabo' => 'UTC/GMT +01:00',
            'Africa/Maputo' => 'UTC/GMT +02:00',
            'Africa/Maseru' => 'UTC/GMT +02:00',
            'Africa/Mbabane' => 'UTC/GMT +02:00',
            'Africa/Mogadishu' => 'UTC/GMT +03:00',
            'Africa/Monrovia' => 'UTC/GMT +00:00',
            'Africa/Nairobi' => 'UTC/GMT +03:00',
            'Africa/Ndjamena' => 'UTC/GMT +01:00',
            'Africa/Niamey' => 'UTC/GMT +01:00',
            'Africa/Nouakchott' => 'UTC/GMT +00:00',
            'Africa/Ouagadougou' => 'UTC/GMT +00:00',
            'Africa/Porto-Novo' => 'UTC/GMT +01:00',
            'Africa/Sao_Tome' => 'UTC/GMT +00:00',
            'Africa/Tripoli' => 'UTC/GMT +02:00',
            'Africa/Tunis' => 'UTC/GMT +01:00',
            'Africa/Windhoek' => 'UTC/GMT +02:00',
            'America/Adak' => 'UTC/GMT -09:00',
            'America/Anchorage' => 'UTC/GMT -08:00',
            'America/Anguilla' => 'UTC/GMT -04:00',
            'America/Antigua' => 'UTC/GMT -04:00',
            'America/Araguaina' => 'UTC/GMT -02:00',
            'America/Argentina/Buenos_Aires' => 'UTC/GMT -03:00',
            'America/Argentina/Catamarca' => 'UTC/GMT -03:00',
            'America/Argentina/Cordoba' => 'UTC/GMT -03:00',
            'America/Argentina/Jujuy' => 'UTC/GMT -03:00',
            'America/Argentina/La_Rioja' => 'UTC/GMT -03:00',
            'America/Argentina/Mendoza' => 'UTC/GMT -03:00',
            'America/Argentina/Rio_Gallegos' => 'UTC/GMT -03:00',
            'America/Argentina/Salta' => 'UTC/GMT -03:00',
            'America/Argentina/San_Juan' => 'UTC/GMT -03:00',
            'America/Argentina/San_Luis' => 'UTC/GMT -03:00',
            'America/Argentina/Tucuman' => 'UTC/GMT -03:00',
            'America/Argentina/Ushuaia' => 'UTC/GMT -03:00',
            'America/Aruba' => 'UTC/GMT -04:00',
            'America/Asuncion' => 'UTC/GMT -03:00',
            'America/Atikokan' => 'UTC/GMT -05:00',
            'America/Bahia' => 'UTC/GMT -03:00',
            'America/Bahia_Banderas' => 'UTC/GMT -05:00',
            'America/Barbados' => 'UTC/GMT -04:00',
            'America/Belem' => 'UTC/GMT -03:00',
            'America/Belize' => 'UTC/GMT -06:00',
            'America/Blanc-Sablon' => 'UTC/GMT -04:00',
            'America/Boa_Vista' => 'UTC/GMT -04:00',
            'America/Bogota' => 'UTC/GMT -05:00',
            'America/Boise' => 'UTC/GMT -06:00',
            'America/Cambridge_Bay' => 'UTC/GMT -06:00',
            'America/Campo_Grande' => 'UTC/GMT -03:00',
            'America/Cancun' => 'UTC/GMT -05:00',
            'America/Caracas' => 'UTC/GMT -04:30',
            'America/Cayenne' => 'UTC/GMT -03:00',
            'America/Cayman' => 'UTC/GMT -05:00',
            'America/Chicago' => 'UTC/GMT -05:00',
            'America/Chihuahua' => 'UTC/GMT -06:00',
            'America/Costa_Rica' => 'UTC/GMT -06:00',
            'America/Creston' => 'UTC/GMT -07:00',
            'America/Cuiaba' => 'UTC/GMT -03:00',
            'America/Curacao' => 'UTC/GMT -04:00',
            'America/Danmarkshavn' => 'UTC/GMT +00:00',
            'America/Dawson' => 'UTC/GMT -07:00',
            'America/Dawson_Creek' => 'UTC/GMT -07:00',
            'America/Denver' => 'UTC/GMT -06:00',
            'America/Detroit' => 'UTC/GMT -04:00',
            'America/Dominica' => 'UTC/GMT -04:00',
            'America/Edmonton' => 'UTC/GMT -06:00',
            'America/Eirunepe' => 'UTC/GMT -04:00',
            'America/El_Salvador' => 'UTC/GMT -06:00',
            'America/Fortaleza' => 'UTC/GMT -03:00',
            'America/Glace_Bay' => 'UTC/GMT -03:00',
            'America/Godthab' => 'UTC/GMT -02:00',
            'America/Goose_Bay' => 'UTC/GMT -03:00',
            'America/Grand_Turk' => 'UTC/GMT -04:00',
            'America/Grenada' => 'UTC/GMT -04:00',
            'America/Guadeloupe' => 'UTC/GMT -04:00',
            'America/Guatemala' => 'UTC/GMT -06:00',
            'America/Guayaquil' => 'UTC/GMT -05:00',
            'America/Guyana' => 'UTC/GMT -04:00',
            'America/Halifax' => 'UTC/GMT -03:00',
            'America/Havana' => 'UTC/GMT -04:00',
            'America/Hermosillo' => 'UTC/GMT -07:00',
            'America/Indiana/Indianapolis' => 'UTC/GMT -04:00',
            'America/Indiana/Knox' => 'UTC/GMT -05:00',
            'America/Indiana/Marengo' => 'UTC/GMT -04:00',
            'America/Indiana/Petersburg' => 'UTC/GMT -04:00',
            'America/Indiana/Tell_City' => 'UTC/GMT -05:00',
            'America/Indiana/Vevay' => 'UTC/GMT -04:00',
            'America/Indiana/Vincennes' => 'UTC/GMT -04:00',
            'America/Indiana/Winamac' => 'UTC/GMT -04:00',
            'America/Inuvik' => 'UTC/GMT -06:00',
            'America/Iqaluit' => 'UTC/GMT -04:00',
            'America/Jamaica' => 'UTC/GMT -05:00',
            'America/Juneau' => 'UTC/GMT -08:00',
            'America/Kentucky/Louisville' => 'UTC/GMT -04:00',
            'America/Kentucky/Monticello' => 'UTC/GMT -04:00',
            'America/Kralendijk' => 'UTC/GMT -04:00',
            'America/La_Paz' => 'UTC/GMT -04:00',
            'America/Lima' => 'UTC/GMT -05:00',
            'America/Los_Angeles' => 'UTC/GMT -07:00',
            'America/Lower_Princes' => 'UTC/GMT -04:00',
            'America/Maceio' => 'UTC/GMT -03:00',
            'America/Managua' => 'UTC/GMT -06:00',
            'America/Manaus' => 'UTC/GMT -04:00',
            'America/Marigot' => 'UTC/GMT -04:00',
            'America/Martinique' => 'UTC/GMT -04:00',
            'America/Matamoros' => 'UTC/GMT -05:00',
            'America/Mazatlan' => 'UTC/GMT -06:00',
            'America/Menominee' => 'UTC/GMT -05:00',
            'America/Merida' => 'UTC/GMT -05:00',
            'America/Metlakatla' => 'UTC/GMT -08:00',
            'America/Mexico_City' => 'UTC/GMT -05:00',
            'America/Miquelon' => 'UTC/GMT -02:00',
            'America/Moncton' => 'UTC/GMT -03:00',
            'America/Monterrey' => 'UTC/GMT -05:00',
            'America/Montevideo' => 'UTC/GMT -02:00',
            'America/Montreal' => 'UTC/GMT -04:00',
            'America/Montserrat' => 'UTC/GMT -04:00',
            'America/Nassau' => 'UTC/GMT -04:00',
            'America/New_York' => 'UTC/GMT -04:00',
            'America/Nipigon' => 'UTC/GMT -04:00',
            'America/Nome' => 'UTC/GMT -08:00',
            'America/Noronha' => 'UTC/GMT -02:00',
            'America/North_Dakota/Beulah' => 'UTC/GMT -05:00',
            'America/North_Dakota/Center' => 'UTC/GMT -05:00',
            'America/North_Dakota/New_Salem' => 'UTC/GMT -05:00',
            'America/Ojinaga' => 'UTC/GMT -06:00',
            'America/Panama' => 'UTC/GMT -05:00',
            'America/Pangnirtung' => 'UTC/GMT -04:00',
            'America/Paramaribo' => 'UTC/GMT -03:00',
            'America/Phoenix' => 'UTC/GMT -07:00',
            'America/Port-au-Prince' => 'UTC/GMT -04:00',
            'America/Port_of_Spain' => 'UTC/GMT -04:00',
            'America/Porto_Velho' => 'UTC/GMT -04:00',
            'America/Puerto_Rico' => 'UTC/GMT -04:00',
            'America/Rainy_River' => 'UTC/GMT -05:00',
            'America/Rankin_Inlet' => 'UTC/GMT -05:00',
            'America/Recife' => 'UTC/GMT -03:00',
            'America/Regina' => 'UTC/GMT -06:00',
            'America/Resolute' => 'UTC/GMT -05:00',
            'America/Rio_Branco' => 'UTC/GMT -04:00',
            'America/Santa_Isabel' => 'UTC/GMT -07:00',
            'America/Santarem' => 'UTC/GMT -03:00',
            'America/Santiago' => 'UTC/GMT -03:00',
            'America/Santo_Domingo' => 'UTC/GMT -04:00',
            'America/Sao_Paulo' => 'UTC/GMT -02:00',
            'America/Scoresbysund' => 'UTC/GMT +00:00',
            'America/Shiprock' => 'UTC/GMT -06:00',
            'America/Sitka' => 'UTC/GMT -08:00',
            'America/St_Barthelemy' => 'UTC/GMT -04:00',
            'America/St_Johns' => 'UTC/GMT -02:30',
            'America/St_Kitts' => 'UTC/GMT -04:00',
            'America/St_Lucia' => 'UTC/GMT -04:00',
            'America/St_Thomas' => 'UTC/GMT -04:00',
            'America/St_Vincent' => 'UTC/GMT -04:00',
            'America/Swift_Current' => 'UTC/GMT -06:00',
            'America/Tegucigalpa' => 'UTC/GMT -06:00',
            'America/Thule' => 'UTC/GMT -03:00',
            'America/Thunder_Bay' => 'UTC/GMT -04:00',
            'America/Tijuana' => 'UTC/GMT -07:00',
            'America/Toronto' => 'UTC/GMT -04:00',
            'America/Tortola' => 'UTC/GMT -04:00',
            'America/Vancouver' => 'UTC/GMT -07:00',
            'America/Whitehorse' => 'UTC/GMT -07:00',
            'America/Winnipeg' => 'UTC/GMT -05:00',
            'America/Yakutat' => 'UTC/GMT -08:00',
            'America/Yellowknife' => 'UTC/GMT -06:00',
            'Antarctica/Casey' => 'UTC/GMT +08:00',
            'Antarctica/Davis' => 'UTC/GMT +07:00',
            'Antarctica/DumontDUrville' => 'UTC/GMT +10:00',
            'Antarctica/Macquarie' => 'UTC/GMT +11:00',
            'Antarctica/Mawson' => 'UTC/GMT +05:00',
            'Antarctica/McMurdo' => 'UTC/GMT +13:00',
            'Antarctica/Palmer' => 'UTC/GMT -03:00',
            'Antarctica/Rothera' => 'UTC/GMT -03:00',
            'Antarctica/South_Pole' => 'UTC/GMT +13:00',
            'Antarctica/Syowa' => 'UTC/GMT +03:00',
            'Antarctica/Vostok' => 'UTC/GMT +06:00',
            'Arctic/Longyearbyen' => 'UTC/GMT +02:00',
            'Asia/Aden' => 'UTC/GMT +03:00',
            'Asia/Almaty' => 'UTC/GMT +06:00',
            'Asia/Amman' => 'UTC/GMT +03:00',
            'Asia/Anadyr' => 'UTC/GMT +12:00',
            'Asia/Aqtau' => 'UTC/GMT +05:00',
            'Asia/Aqtobe' => 'UTC/GMT +05:00',
            'Asia/Ashgabat' => 'UTC/GMT +05:00',
            'Asia/Baghdad' => 'UTC/GMT +03:00',
            'Asia/Bahrain' => 'UTC/GMT +03:00',
            'Asia/Baku' => 'UTC/GMT +05:00',
            'Asia/Bangkok' => 'UTC/GMT +07:00',
            'Asia/Beirut' => 'UTC/GMT +03:00',
            'Asia/Bishkek' => 'UTC/GMT +06:00',
            'Asia/Brunei' => 'UTC/GMT +08:00',
            'Asia/Choibalsan' => 'UTC/GMT +08:00',
            'Asia/Chongqing' => 'UTC/GMT +08:00',
            'Asia/Colombo' => 'UTC/GMT +05:30',
            'Asia/Damascus' => 'UTC/GMT +03:00',
            'Asia/Dhaka' => 'UTC/GMT +06:00',
            'Asia/Dili' => 'UTC/GMT +09:00',
            'Asia/Dubai' => 'UTC/GMT +04:00',
            'Asia/Dushanbe' => 'UTC/GMT +05:00',
            'Asia/Gaza' => 'UTC/GMT +02:00',
            'Asia/Harbin' => 'UTC/GMT +08:00',
            'Asia/Hebron' => 'UTC/GMT +02:00',
            'Asia/Ho_Chi_Minh' => 'UTC/GMT +07:00',
            'Asia/Hong_Kong' => 'UTC/GMT +08:00',
            'Asia/Hovd' => 'UTC/GMT +07:00',
            'Asia/Irkutsk' => 'UTC/GMT +09:00',
            'Asia/Jakarta' => 'UTC/GMT +07:00',
            'Asia/Jayapura' => 'UTC/GMT +09:00',
            'Asia/Jerusalem' => 'UTC/GMT +02:00',
            'Asia/Kabul' => 'UTC/GMT +04:30',
            'Asia/Kamchatka' => 'UTC/GMT +12:00',
            'Asia/Karachi' => 'UTC/GMT +05:00',
            'Asia/Kashgar' => 'UTC/GMT +08:00',
            'Asia/Kathmandu' => 'UTC/GMT +05:45',
            'Asia/Khandyga' => 'UTC/GMT +10:00',
            'Asia/Kolkata' => 'UTC/GMT +05:30',
            'Asia/Krasnoyarsk' => 'UTC/GMT +08:00',
            'Asia/Kuala_Lumpur' => 'UTC/GMT +08:00',
            'Asia/Kuching' => 'UTC/GMT +08:00',
            'Asia/Kuwait' => 'UTC/GMT +03:00',
            'Asia/Macau' => 'UTC/GMT +08:00',
            'Asia/Magadan' => 'UTC/GMT +12:00',
            'Asia/Makassar' => 'UTC/GMT +08:00',
            'Asia/Manila' => 'UTC/GMT +08:00',
            'Asia/Muscat' => 'UTC/GMT +04:00',
            'Asia/Nicosia' => 'UTC/GMT +03:00',
            'Asia/Novokuznetsk' => 'UTC/GMT +07:00',
            'Asia/Novosibirsk' => 'UTC/GMT +07:00',
            'Asia/Omsk' => 'UTC/GMT +07:00',
            'Asia/Oral' => 'UTC/GMT +05:00',
            'Asia/Phnom_Penh' => 'UTC/GMT +07:00',
            'Asia/Pontianak' => 'UTC/GMT +07:00',
            'Asia/Pyongyang' => 'UTC/GMT +09:00',
            'Asia/Qatar' => 'UTC/GMT +03:00',
            'Asia/Qyzylorda' => 'UTC/GMT +06:00',
            'Asia/Rangoon' => 'UTC/GMT +06:30',
            'Asia/Riyadh' => 'UTC/GMT +03:00',
            'Asia/Sakhalin' => 'UTC/GMT +11:00',
            'Asia/Samarkand' => 'UTC/GMT +05:00',
            'Asia/Seoul' => 'UTC/GMT +09:00',
            'Asia/Shanghai' => 'UTC/GMT +08:00',
            'Asia/Singapore' => 'UTC/GMT +08:00',
            'Asia/Taipei' => 'UTC/GMT +08:00',
            'Asia/Tashkent' => 'UTC/GMT +05:00',
            'Asia/Tbilisi' => 'UTC/GMT +04:00',
            'Asia/Tehran' => 'UTC/GMT +03:30',
            'Asia/Thimphu' => 'UTC/GMT +06:00',
            'Asia/Tokyo' => 'UTC/GMT +09:00',
            'Asia/Ulaanbaatar' => 'UTC/GMT +08:00',
            'Asia/Urumqi' => 'UTC/GMT +08:00',
            'Asia/Ust-Nera' => 'UTC/GMT +11:00',
            'Asia/Vientiane' => 'UTC/GMT +07:00',
            'Asia/Vladivostok' => 'UTC/GMT +11:00',
            'Asia/Yakutsk' => 'UTC/GMT +10:00',
            'Asia/Yekaterinburg' => 'UTC/GMT +06:00',
            'Asia/Yerevan' => 'UTC/GMT +04:00',
            'Atlantic/Azores' => 'UTC/GMT +00:00',
            'Atlantic/Bermuda' => 'UTC/GMT -03:00',
            'Atlantic/Canary' => 'UTC/GMT +01:00',
            'Atlantic/Cape_Verde' => 'UTC/GMT -01:00',
            'Atlantic/Faroe' => 'UTC/GMT +01:00',
            'Atlantic/Madeira' => 'UTC/GMT +01:00',
            'Atlantic/Reykjavik' => 'UTC/GMT +00:00',
            'Atlantic/South_Georgia' => 'UTC/GMT -02:00',
            'Atlantic/St_Helena' => 'UTC/GMT +00:00',
            'Atlantic/Stanley' => 'UTC/GMT -03:00',
            'Australia/Adelaide' => 'UTC/GMT +10:30',
            'Australia/Brisbane' => 'UTC/GMT +10:00',
            'Australia/Broken_Hill' => 'UTC/GMT +10:30',
            'Australia/Currie' => 'UTC/GMT +11:00',
            'Australia/Darwin' => 'UTC/GMT +09:30',
            'Australia/Eucla' => 'UTC/GMT +08:45',
            'Australia/Hobart' => 'UTC/GMT +11:00',
            'Australia/Lindeman' => 'UTC/GMT +10:00',
            'Australia/Lord_Howe' => 'UTC/GMT +11:00',
            'Australia/Melbourne' => 'UTC/GMT +11:00',
            'Australia/Perth' => 'UTC/GMT +08:00',
            'Australia/Sydney' => 'UTC/GMT +11:00',
            'Europe/Amsterdam' => 'UTC/GMT +02:00',
            'Europe/Andorra' => 'UTC/GMT +02:00',
            'Europe/Athens' => 'UTC/GMT +03:00',
            'Europe/Belgrade' => 'UTC/GMT +02:00',
            'Europe/Berlin' => 'UTC/GMT +02:00',
            'Europe/Bratislava' => 'UTC/GMT +02:00',
            'Europe/Brussels' => 'UTC/GMT +02:00',
            'Europe/Bucharest' => 'UTC/GMT +03:00',
            'Europe/Budapest' => 'UTC/GMT +02:00',
            'Europe/Busingen' => 'UTC/GMT +02:00',
            'Europe/Chisinau' => 'UTC/GMT +03:00',
            'Europe/Copenhagen' => 'UTC/GMT +02:00',
            'Europe/Dublin' => 'UTC/GMT +01:00',
            'Europe/Gibraltar' => 'UTC/GMT +02:00',
            'Europe/Guernsey' => 'UTC/GMT +01:00',
            'Europe/Helsinki' => 'UTC/GMT +03:00',
            'Europe/Isle_of_Man' => 'UTC/GMT +01:00',
            'Europe/Istanbul' => 'UTC/GMT +03:00',
            'Europe/Jersey' => 'UTC/GMT +01:00',
            'Europe/Kaliningrad' => 'UTC/GMT +03:00',
            'Europe/Kiev' => 'UTC/GMT +03:00',
            'Europe/Lisbon' => 'UTC/GMT +01:00',
            'Europe/Ljubljana' => 'UTC/GMT +02:00',
            'Europe/London' => 'UTC/GMT +01:00',
            'Europe/Luxembourg' => 'UTC/GMT +02:00',
            'Europe/Madrid' => 'UTC/GMT +02:00',
            'Europe/Malta' => 'UTC/GMT +02:00',
            'Europe/Mariehamn' => 'UTC/GMT +03:00',
            'Europe/Minsk' => 'UTC/GMT +03:00',
            'Europe/Monaco' => 'UTC/GMT +02:00',
            'Europe/Moscow' => 'UTC/GMT +04:00',
            'Europe/Oslo' => 'UTC/GMT +02:00',
            'Europe/Paris' => 'UTC/GMT +02:00',
            'Europe/Podgorica' => 'UTC/GMT +02:00',
            'Europe/Prague' => 'UTC/GMT +02:00',
            'Europe/Riga' => 'UTC/GMT +03:00',
            'Europe/Rome' => 'UTC/GMT +02:00',
            'Europe/Samara' => 'UTC/GMT +04:00',
            'Europe/San_Marino' => 'UTC/GMT +02:00',
            'Europe/Sarajevo' => 'UTC/GMT +02:00',
            'Europe/Simferopol' => 'UTC/GMT +03:00',
            'Europe/Skopje' => 'UTC/GMT +02:00',
            'Europe/Sofia' => 'UTC/GMT +03:00',
            'Europe/Stockholm' => 'UTC/GMT +02:00',
            'Europe/Tallinn' => 'UTC/GMT +03:00',
            'Europe/Tirane' => 'UTC/GMT +02:00',
            'Europe/Uzhgorod' => 'UTC/GMT +03:00',
            'Europe/Vaduz' => 'UTC/GMT +02:00',
            'Europe/Vatican' => 'UTC/GMT +02:00',
            'Europe/Vienna' => 'UTC/GMT +02:00',
            'Europe/Vilnius' => 'UTC/GMT +03:00',
            'Europe/Volgograd' => 'UTC/GMT +04:00',
            'Europe/Warsaw' => 'UTC/GMT +02:00',
            'Europe/Zagreb' => 'UTC/GMT +02:00',
            'Europe/Zaporozhye' => 'UTC/GMT +03:00',
            'Europe/Zurich' => 'UTC/GMT +02:00',
            'Indian/Antananarivo' => 'UTC/GMT +03:00',
            'Indian/Chagos' => 'UTC/GMT +06:00',
            'Indian/Christmas' => 'UTC/GMT +07:00',
            'Indian/Cocos' => 'UTC/GMT +06:30',
            'Indian/Comoro' => 'UTC/GMT +03:00',
            'Indian/Kerguelen' => 'UTC/GMT +05:00',
            'Indian/Mahe' => 'UTC/GMT +04:00',
            'Indian/Maldives' => 'UTC/GMT +05:00',
            'Indian/Mauritius' => 'UTC/GMT +04:00',
            'Indian/Mayotte' => 'UTC/GMT +03:00',
            'Indian/Reunion' => 'UTC/GMT +04:00',
            'Pacific/Apia' => 'UTC/GMT +14:00',
            'Pacific/Auckland' => 'UTC/GMT +13:00',
            'Pacific/Chatham' => 'UTC/GMT +13:45',
            'Pacific/Chuuk' => 'UTC/GMT +10:00',
            'Pacific/Easter' => 'UTC/GMT -05:00',
            'Pacific/Efate' => 'UTC/GMT +11:00',
            'Pacific/Enderbury' => 'UTC/GMT +13:00',
            'Pacific/Fakaofo' => 'UTC/GMT +13:00',
            'Pacific/Fiji' => 'UTC/GMT +13:00',
            'Pacific/Funafuti' => 'UTC/GMT +12:00',
            'Pacific/Galapagos' => 'UTC/GMT -06:00',
            'Pacific/Gambier' => 'UTC/GMT -09:00',
            'Pacific/Guadalcanal' => 'UTC/GMT +11:00',
            'Pacific/Guam' => 'UTC/GMT +10:00',
            'Pacific/Honolulu' => 'UTC/GMT -10:00',
            'Pacific/Johnston' => 'UTC/GMT -10:00',
            'Pacific/Kiritimati' => 'UTC/GMT +14:00',
            'Pacific/Kosrae' => 'UTC/GMT +11:00',
            'Pacific/Kwajalein' => 'UTC/GMT +12:00',
            'Pacific/Majuro' => 'UTC/GMT +12:00',
            'Pacific/Marquesas' => 'UTC/GMT -09:30',
            'Pacific/Midway' => 'UTC/GMT -11:00',
            'Pacific/Nauru' => 'UTC/GMT +12:00',
            'Pacific/Niue' => 'UTC/GMT -11:00',
            'Pacific/Norfolk' => 'UTC/GMT +11:30',
            'Pacific/Noumea' => 'UTC/GMT +11:00',
            'Pacific/Pago_Pago' => 'UTC/GMT -11:00',
            'Pacific/Palau' => 'UTC/GMT +09:00',
            'Pacific/Pitcairn' => 'UTC/GMT -08:00',
            'Pacific/Pohnpei' => 'UTC/GMT +11:00',
            'Pacific/Port_Moresby' => 'UTC/GMT +10:00',
            'Pacific/Rarotonga' => 'UTC/GMT -10:00',
            'Pacific/Saipan' => 'UTC/GMT +10:00',
            'Pacific/Tahiti' => 'UTC/GMT -10:00',
            'Pacific/Tarawa' => 'UTC/GMT +12:00',
            'Pacific/Tongatapu' => 'UTC/GMT +13:00',
            'Pacific/Wake' => 'UTC/GMT +12:00',
            'Pacific/Wallis' => 'UTC/GMT +12:00',
            'UTC' => 'UTC/GMT +00:00',
        );
    }

}