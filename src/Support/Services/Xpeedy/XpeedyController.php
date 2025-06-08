<?php

namespace Kirago\BusinessCore\Support\Services\Xpeedy;

use Illuminate\Routing\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kirago\BusinessCore\Modules\LocalizationManagement\Constants\SettingsKeys;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\Xpeedy\Services\XpeedyService;


class XpeedyController extends Controller
{

    protected XpeedyService $service;

    public function __construct()
    {

        /**
         * @var Organization $organization
         */
        if($organization = currentOrganization()){
            $xpeedyConfig = $organization->getSettingOf(SettingsKeys::XPEEDY_CONFIG);
            $this->service = new XpeedyService($xpeedyConfig);
        }
    }


    /**
     * @throws Exception
     */
    public function init(Request $request) : Response
    {
        $data = $request->all();

        [$response,$status] = $this->service->initTransaction($data);
        $status = ($status === 401) ? 500 : $status;

        if (app()->isProduction()){
            unset($response['exception']);
        }
        return response($response,$status);

    }

    /**
     * @throws Exception
     */
    public function check(string $transactionId): Response {

        [$response,$status] = $this->service->checkTransaction($transactionId);
        $status = ($status === 401) ? 500 : $status;
        if (app()->isProduction()){
            unset($response['exception']);
        }
        return response($response,$status);
    }

    /**
     * @throws Exception
     */
    public function getWalletDetails() : Response{

        [$response,$status] = $this->service->walletDetails();
        $status = ($status === 401) ? 500 : $status;
        if (app()->isProduction()){
            unset($response['exception']);
        }
        return response($response,$status );

    }

}
