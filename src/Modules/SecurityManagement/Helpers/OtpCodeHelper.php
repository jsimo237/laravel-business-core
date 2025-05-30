<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcOtpCode;
use Kirago\BusinessCore\Support\Helpers\OtpCode;

final class OtpCodeHelper
{
    /**
     * Génère un code OTP pour un identifiant morphable
     *
     * @param BaseBcModel|Model $identifier
     * @param int $ttl en secondes (durée de vie)
     * @param int $length Longueur du code OTP
     * @param bool $invalidate
     * @return BcOtpCode
     * @throws Exception
     */
    public static function generateFor(
        BaseBcModel|Model $identifier,
        int $ttl = 1800, int $length = 6, bool $invalidate = true): BcOtpCode
    {

        // Assurer que le modèle utilise ULID
        if (! method_exists($identifier, 'getUlid')) {
         //   throw new \InvalidArgumentException('Le modèle doit utiliser ULID pour l’identifiant.');
        }

        $organization = $identifier->organization ?? currentOrganization();

        // Invalider les anciens OTP si demandé
        if ($invalidate) {
            self::invalidateOldOtps($identifier, $organization);
        }

        $code = self::generateUniqueCode($length, $organization?->id);

        $otp = new BcOtpCode();
        $otp->code = $code;
        $otp->expired_at = now()->addSeconds($ttl);
        $otp->identifier()->associate($identifier);
        if($organization){
            $otp->organization()->associate($organization);
        }

        $otp->save();

        return $otp;
    }

    /**
     * Vérifie un code OTP pour un identifiant
     */
    public static function verify(BaseBcModel|Model $identifier, string $code): bool
    {
        return BcOtpCode::where('identifier_type', $identifier->getMorphClass())
                        ->where('identifier_id', $identifier->getKey())
                        ->where('organization_id', $identifier->organization_id)
                        ->where('code', $code)
                        ->where('expired_at', '>', now())
                        ->exists();
    }

    /**
     * Génère un code unique par organisation
     * @throws Exception
     */
    protected static function generateUniqueCode(int $length, int|string|null $organizationId): string
    {
        do {
            $code = Str::password($length, false, true, false, false);
            //$code = Str::upper(Str::random($length)); // ou sprintf('%06d', random_int(0, 999999)) pour un code numérique
        } while (
            BcOtpCode::where('code', $code)
                    ->where('organization_id', $organizationId)
                    ->exists()
        );

        return $code;
    }

    /**
     * Sassures qu’il n’y a qu’un OTP actif par utilisateur et par organisation
     *
     * @param BaseBcModel|Model $identifier
     * @param BcOrganization|null $organization
     * @return void
     */
    protected static function invalidateOldOtps(BaseBcModel|Model $identifier, BcOrganization|null $organization): void
    {
        BcOtpCode::where('identifier_type', $identifier->getMorphClass())
                ->where('identifier_id', $identifier->getKey())
                ->where('organization_id', $organization?->id)
                ->where('expired_at', '>', now()) // uniquement ceux encore valides
                ->delete(); // soft delete (grâce au trait SoftDeletes)
    }

}
