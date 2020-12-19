<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGame extends Model
{
    protected $fillable = [
        'developer_id', 'category_id', 'androidVersion', 'appVersion', 'categoryName', 'contentRating', 'country', 'description', 'fullUrl', 'installs', 'packagesName', 'videoUrl', 'videoImgUrl', 'videoId', 'releaseDate', 'oldUpdatedDate', 'updatedDate',
        'url', 'privacyPoliceUrl', 'locale', 'isFree', 'isEditorsChoice', 'isContainsIAP', 'isContainsAds', 'isAutoTranslatedDescription', 'oldVersion', 'versionCount', 'numberVoters', 'numberReviews', 'icon', 'minAndroidVersion', 'size', 'score', 'oldVersionDate', 'versionDate',
        'price', 'priceText', 'inactive'
    ];
}
