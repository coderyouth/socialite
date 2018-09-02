<?php

namespace CoderYouth\Socialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

class CoderYouthExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'coderyouth',
            Provider::class
        );
    }
}
