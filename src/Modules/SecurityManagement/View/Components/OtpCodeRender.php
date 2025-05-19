<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcOtpCode;

class OtpCodeRender extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public BcOtpCode $otp, public array $options = [])
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.otp-code-render');
    }
}
