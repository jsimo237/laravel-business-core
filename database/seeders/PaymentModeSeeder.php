<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Kirago\BusinessCore\Data\PaymentMethodData;
use Kirago\BusinessCore\Models\PaymentManagement\PaymentMethod;
use Kirago\BusinessCore\Models\PaymentManagement\PaymentProvider;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder{

    public function run(){


        DB::beginTransaction();
        try {
            $methods = PaymentMethodData::items();

            $this->command->alert(strtoupper("[BEGIN] Payment methods"));

            $this->command->info(__(":count payments providers detected",['count' => format_amount(count($methods))]));

            if ($methods){
                foreach ($methods as $method) {
                    $code = $method['code'];
                    $logo = $method['logo'];
                    //$method['url'] = "NONE";
//                    unset($method['default_config']);
//                    unset($method['code']);
//                    unset($method['logo']);

                    $method = Arr::except($method,["logo","code"]);

                    PaymentMethod::updateOrCreate( ["code" => $code], $method );

                    $method = PaymentMethod::find($code);

                   // if (blank($method->getFirstMedia()) and filled($logo)){
                    if ($logo && 1==2){
                        if ($method->media){
                            $method->media()->delete();
                        }

                        $path = $logo;
                        $file = new UploadedFile($path,$logo);
                        $method->uploadFiles($file);
                    }

                    $this->command->info(__(":name ===> OK",['name' => $method['name']]));
                }
            }
            $this->command->alert(strtoupper("[END] Payment providers"));
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();

            echo format_exception_message($exception);
        }

    }
}
