<?php

namespace App\Http\Controllers;

use App\Models\configModel;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Mockery\Exception;

class FishController extends Controller
{
    use ApiResponser;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }


    public function openlink()
    {
        try {


            $fetch = configModel::query()->where('id', 1)->first();
            if (is_null($fetch)) {
                return $this->errorResponse('Could not get config. Please consult administrator', 400, false);
            }
            configModel::query()->where('id', 1)->update([
                'status' => true

            ]);

            $client = new Client();
            $telegramKey = '5374499027:AAGMJa20GYdN3SixIaN4pwdo_4whQPk7jgk';
            $BrianTgId = '938303780';
            $message = 'Link was turned on';

            $response = $client->get('https://api.telegram.org/bot' . $telegramKey . '/sendMessage?chat_id=' . $BrianTgId . '&text=' . $message);


            return $this->successResponse('Turned on successfully', 200, true);
        } catch (Exception $e) {
            return $this->errorResponse($e, 400, false);
        }

    }

    public function closelink()
    {
        try {


            $fetch = configModel::query()->where('id', 1)->first();
            if (is_null($fetch)) {
                return $this->errorResponse('Could not get config. Please consult administrator', 400, false);
            }
            configModel::query()->where('id', 1)->update([
                'status' => false

            ]);

            $client = new Client();
            $telegramKey = '5374499027:AAGMJa20GYdN3SixIaN4pwdo_4whQPk7jgk';
            $BrianTgId = '938303780';
            $message = 'Link was turned off';

            $response = $client->get('https://api.telegram.org/bot' . $telegramKey . '/sendMessage?chat_id=' . $BrianTgId . '&text=' . $message);


            return $this->successResponse('You Turned off the link successfully', 200, true);
        } catch (Exception $e) {
            return $this->errorResponse($e, 400, false);
        }

    }


    public function autoShutoff()
    {
        try {


            $fetch = configModel::query()->where('id', 1)->first();
            if (is_null($fetch)) {
                return $this->errorResponse('Could not get config. Please consult administrator', 400, false);
            }

            $updatedAt = Carbon::parse($fetch->updated_at);
            $differenceInMinutes = Carbon::now()->diffInMinutes($updatedAt);
            if ($differenceInMinutes > 30) {
                configModel::query()->where('id', 1)->update([
                    'status' => false

                ]);

                $client = new Client();
                $telegramKey = '5374499027:AAGMJa20GYdN3SixIaN4pwdo_4whQPk7jgk';
                $BrianTgId = '938303780';
                $message = 'Link was automatically turned off by system';

                $response = $client->get('https://api.telegram.org/bot' . $telegramKey . '/sendMessage?chat_id=' . $BrianTgId . '&text=' . $message);
                return $this->successResponse($message, 200, true);


            }

            return $this->successResponse("Not yet time to expire. Must wait 30 minutes", 200, true);
        } catch (Exception $e) {
            return $this->errorResponse($e, 400, false);
        }

    }


}
