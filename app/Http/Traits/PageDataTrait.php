<?php

namespace App\Http\Traits;

use App\Http\Models\CacheModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

trait PageDataTrait
{
    /**
     * @todo Clear Cache Files in Storage!!!!
     * @return void
     */
    public function cleanPageData()
    {
        try {
            $cache = CacheModel::where('value', '!=', '')->delete();
            $cache2 = Artisan::call('cache:clear');
            $cache3 = Artisan::call('debugbar:clear');
            $cache4 = Artisan::call('view:clear');
            $data=[];
            $data['success'] = true;
        } catch (\Exception $exception) {
            $data=[];
            $data['success'] = false;
            $data['errors'] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
            Log::error(__CLASS__.'>'.__FUNCTION__.'>'.__LINE__, $data);
        }
        return $data;
    }
}
