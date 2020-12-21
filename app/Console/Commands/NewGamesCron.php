<?php

namespace App\Console\Commands;

use App\Models\GooglePlayStoreCategory;
use App\Models\GooglePlayStoreDeveloper;
use App\Models\GooglePlayStoreDeveloperEmailAddress;
use App\Models\GooglePlayStoreGame;
use App\Models\GooglePlayStoreGameAddCategory;
use App\Models\GooglePlayStoreGameScreen;
use App\Models\GooglePlayStoreGameVersion;
use App\Models\RunCronJob;
use Illuminate\Console\Command;
use Nelexa\GPlay\Exception\GooglePlayException;
use Nelexa\GPlay\GPlayApps;

class NewGamesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function createdGameByDeveloper(GooglePlayStoreDeveloper $developer)
    {
        $google = new GPlayApps();
        try {
            $apps = $google->getDeveloperApps($developer->devId);
            foreach ($apps as $appId) {
                try {
                    $game = GooglePlayStoreGame::where('packagesName', $appId->getId())->first();
                    if ($game) {
                        continue 1;
                    }
                    $app = $google->getAppInfo($appId->getId());
                    $category = GooglePlayStoreCategory::where('code', $app->getCategory()->getId())->first();
                    if (!$category) {
                        continue 1;
                    }
                    $this->createdGame($app, $developer, $category);
                } catch (GooglePlayException $exception) {
                    continue 1;
                }
                catch (\Exception $exception) {
                    continue 1;
                }
            }
        } catch (GooglePlayException $exception) {
        }
        catch (\Exception $exception) {
        }

    }

    public function createdGame($app, $developer, $category)
    {
        $game = GooglePlayStoreGame::where('packagesName', $app->getId())->first();
        if (!$game) {
            $game = GooglePlayStoreGame::create([
                "developer_id" => $developer->id,
                "category_id" => $category->id,
                "packagesName" => $app->getId(),
                "categoryName" => $category->category,
                "contentRating" => $app->getContentRating(),
                "country" => $app->getCountry(),
                "description" => $app->getDescription(),
                "fullUrl" => $app->getFullUrl(),
                "installs" => $app->getInstalls(),
                "videoUrl" => $app->getVideo() ? $app->getVideo()->getVideoUrl() : '',
                "videoImgUrl" => $app->getVideo() ? $app->getVideo()->getImageUrl() : '',
                "videoId" => $app->getVideo() ? $app->getVideo()->getYoutubeId() : '',
                "releaseDate" => $app->getReleased() ? $app->getReleased()->format('Y-m-d h:i:s') : date('Y-m-d h:i:s'),
                "updatedDate" => $app->getUpdated() ? $app->getUpdated()->format('Y-m-d h:i:s') : date('Y-m-d h:i:s'),
                "oldUpdatedDate" => null,
                "versionDate" => date('Y-m-d h:i:s'),
                "oldVersionDate" => null,
                "score" => $app->getScore(),
                "appVersion" => $app->getAppVersion(),
                "size" => $app->getSize(),
                "minAndroidVersion" => $app->getMinAndroidVersion(),
                "androidVersion" => $app->getAndroidVersion(),
                "icon" => $app->getIcon(),
                "numberReviews" => $app->getNumberReviews(),
                "numberVoters" => $app->getNumberVoters(),
                "versionCount" => 1,
                "oldVersion" => null,
                "isAutoTranslatedDescription" => $app->isAutoTranslatedDescription(),
                "isContainsAds" => $app->isContainsAds(),
                "isContainsIAP" => $app->isContainsIAP(),
                "isEditorsChoice" => $app->isEditorsChoice(),
                "isFree" => $app->isFree(),
                "locale" => $app->getLocale(),
                "privacyPoliceUrl" => $app->getPrivacyPoliceUrl(),
                "url" => $app->getUrl(),
                "price" => $app->getPrice(),
                "priceText" => $app->getPriceText()
            ]);
            foreach ($app->getScreenshots() as $screenshot) {
                GooglePlayStoreGameScreen::create([
                    'game_id' => $game->id,
                    'hashUrl' => $screenshot->getHashUrl(),
                    'size' => $screenshot->getSize(),
                    'url' => $screenshot->getUrl()
                ]);
            }
            if ($game->appVersion) {
                GooglePlayStoreGameVersion::create([
                    'game_id' => $game->id,
                    'version' => $game->appVersion,
                ]);
            }
            GooglePlayStoreGameAddCategory::create([
                'game_id' => $game->id,
                'category_id' => $category->id,
                'name' => $category->category,
                'code' => $category->code,
            ]);
            if ($developer->lastReleasedDate < $game->releaseDate) {
                $developer->lastReleasedDate = $game->releaseDate;
            }
            if ($developer->lastUpdatedDate < $game->updatedDate) {
                $developer->lastUpdatedDate = $game->updatedDate;
            }
            if ($developer->lastVersionDate < $game->versionDate) {
                $developer->lastVersionDate = $game->versionDate;
            }
            $developer->gameCount++;
            $developer->save();
        } else {
            if ($app->getUpdated()) {
                if ($developer->lastUpdatedDate < $app->getUpdated()->format('Y-m-d h:i:s')) {
                    $developer->lastUpdatedDate = $app->getUpdated()->format('Y-m-d h:i:s');
                }
                if ($app->getUpdated()->format('Y-m-d h:i:s') !== $game->updatedDate) {
                    $game->oldUpdatedDate = $game->updatedDate;
                    $game->updatedDate = $app->getUpdated()->format('Y-m-d h:i:s');
                }
            }
            if ($app->getAppVersion() && $game->appVersion !== $app->getAppVersion()) {
                if ($developer->lastVersionDate < $game->versionDate) {
                    $developer->lastVersionDate = date('Y-m-d h:i:s');;
                }
                $game->oldVersionDate = $game->versionDate;
                $game->versionDate = date('Y-m-d h:i:s');
                $game->appVersion = $app->getAppVersion();
                GooglePlayStoreGameVersion::create([
                    'game_id' => $game->id,
                    'version' => $game->appVersion,
                ]);
                $game->versionCount++;
            }
            $game->contentRating = $app->getContentRating();
            $game->description = $app->getDescription();
            $game->fullUrl = $app->getFullUrl();
            $game->installs = $app->getInstalls();
            if ($app->getVideo()) {
                $game->videoUrl = $app->getVideo()->getVideoUrl();
                $game->videoImgUrl = $app->getVideo()->getImageUrl();
                $game->videoId = $app->getVideo()->getYoutubeId();
            }
            $game->score = $app->getScore();
            $game->size = $app->getSize();
            $game->minAndroidVersion = $app->getMinAndroidVersion();
            $game->androidVersion = $app->getAndroidVersion();
            $game->icon = $app->getIcon();
            $game->numberReviews = $app->getNumberReviews();
            $game->numberVoters = $app->getNumberVoters();
            $game->isAutoTranslatedDescription = $app->isAutoTranslatedDescription();
            $game->isContainsAds = $app->isContainsAds();
            $game->isContainsIAP = $app->isContainsIAP();
            $game->isEditorsChoice = $app->isEditorsChoice();
            $game->isFree = $app->isFree();
            $game->locale = $app->getLocale();
            $game->privacyPoliceUrl = $app->getPrivacyPoliceUrl();
            $game->url = $app->getUrl();
            $game->price = $app->getPrice();
            $game->priceText = $app->getPriceText();
            if ($app->getCategory() && $game->categoryName !== $app->getCategory()->getName()) {
                GooglePlayStoreGameAddCategory::create([
                    'game_id' => $game->id,
                    'category_id' => $category->id,
                    'name' => $category->category,
                    'code' => $category->code,
                ]);
                $game->categoryName = $app->getCategory()->getName();
            }
            $developer->save();
            $game->save();
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ok = 0;
        $err_req = 0;
        $newGameCount = 0;
        $google = new GPlayApps();
        for ($i = 0; $i <= 190000; $i++){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://ws75.aptoide.com/api/7/apps/get?group_name=games&limit=100&offset={$i}&sort=added&order=DESC",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 0,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $response = json_decode($response, true);
            if (empty($response['datalist']['list'])){
                $this->info(var_export([
                    'page' => $i,
                ], true));
                break 1;
            }
            foreach ($response['datalist']['list'] as $item) {
                $game = GooglePlayStoreGame::where('packagesName', $item['package'])->first();
                if (!$game) {
                    try {
                        $ok++;
                        $app = $google->getAppInfo($item['package']);
                        $developer = GooglePlayStoreDeveloper::where('devId', $app->getDeveloper()->getId())->first();
                        $category = GooglePlayStoreCategory::where('code', $app->getCategory()->getId())->first();
                        if (!$category) {
                            continue 1;
                        }
                        if (!$developer) {
                            $developer = GooglePlayStoreDeveloper::create([
                                'name' => $app->getDeveloper()->getName(),
                                'devId' => $app->getDeveloper()->getId(),
                                'gameCount' => 0,
                                'email' => $app->getDeveloper()->getEmail(),
                                'url' => $app->getDeveloper()->getUrl(),
                                'website' => $app->getDeveloper()->getWebsite(),
                                'cover' => $app->getDeveloper()->getCover() ? $app->getDeveloper()->getCover()->getUrl() : '',
                                'icon' => $app->getDeveloper()->getIcon() ? $app->getDeveloper()->getIcon()->getUrl() : '',
                                'address' => $app->getDeveloper()->getAddress(),
                            ]);

                            if ($app->getDeveloper()->getEmail()) {
                                GooglePlayStoreDeveloperEmailAddress::create([
                                    'dev_id' => $developer->id,
                                    'email' => $app->getDeveloper()->getEmail()
                                ]);
                            }
                            $this->createdGameByDeveloper($developer);
                        } else {
                            $developerEmailAddress = GooglePlayStoreDeveloperEmailAddress::where('email', $app->getDeveloper()->getEmail())->where('dev_id', $developer->id)->first();
                            if (!$developerEmailAddress && $app->getDeveloper()->getEmail()) {
                                GooglePlayStoreDeveloperEmailAddress::create([
                                    'dev_id' => $developer->id,
                                    'email' => $app->getDeveloper()->getEmail()
                                ]);
                            }
                        }
                        $this->createdGame($app, $developer, $category);
                        $newGameCount++;
                    } catch (GooglePlayException $exception) {
                        $err_req++;
                        continue 1;
                    }
                    catch (\Exception $exception) {
                        continue 1;
                    }
                }
            }
        }
//        $this->info(var_export($ids, true));
        $this->info(var_export([
            'err' => $err_req,
            'ok' => $ok,
            'new' => $newGameCount
        ], true));
        return true;
    }
}
