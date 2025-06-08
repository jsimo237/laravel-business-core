<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

class CreateStaffCommand extends Command
{
    protected $signature = 'bc:create-staff {--organization= : Le slug de l’organisation}';
    protected $description = 'Créer un staff et un utilisateur lié';

    public function handle()
    {
        $slug = $this->option('organization');
        $organization = null;

        if ($slug) {
            $organization = Organization::findBySlug($slug);
        } else {
            $organizations = Organization::all();

            if ($organizations->isNotEmpty()) {
                $choices = $organizations->map(fn($org) => "{$org->slug} - {$org->name}")->toArray();
                $selected = $this->choice("Sélectionnez une organisation", $choices);
                $slugSelected = explode(' - ', $selected)[0];
                $organization = Organization::findBySlug($slugSelected);
            } else {
                $this->warn("⚠️ Aucune organisation trouvée. Le staff sera créé sans organisation.");
            }
        }

        DB::beginTransaction();

        try {
            $staff = $this->createStaff($organization);

            DB::commit();
            $this->info("🎉 Staff créé avec succès !");
            dump($staff->toArray());

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Erreur : " . format_exception_message($e));
            return Command::FAILURE;
        }
    }

    protected function createStaff(?Organization $organization): Staff
    {
        $this->alert("Ajout d’un utilisateur dans la base de données");

        $staff = new Staff();

        do {
            $staff->firstname = $this->ask('Nom *');
            if (blank($staff->firstname)) {
                $this->error('❌ Le nom est obligatoire.');
            }
        } while (blank($staff->firstname));

        $staff->lastname = $this->ask('Prénom');
        $staff->username = $this->ask("Nom d'utilisateur");

        do {
            $staff->email = $this->ask('Email (laisser vide si vous utilisez un téléphone)');
            $staff->phone = $this->ask('Téléphone (laisser vide si vous utilisez un email)');
            if (blank($staff->email) && blank($staff->phone)) {
                $this->error('❌ Vous devez saisir au moins un email ou un numéro de téléphone.');
            }
        } while (blank($staff->email) && blank($staff->phone));

        $password = null;
        $maxAttempts = 3;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $password = $this->secret('Mot de passe : ');
            $confirmation = $this->secret('Confirmer le mot de passe : ');

            if (blank($password)) {
                $this->error('❌ Le mot de passe est obligatoire.');
                $attempt++;
                continue;
            }

            if ($password !== $confirmation) {
                $this->error('❌ Les mots de passe ne correspondent pas.');
                $attempt++;
                continue;
            }

            break;
        }

        throw_if(
            ($attempt === $maxAttempts),
            new \Exception('Échec de la confirmation du mot de passe après 3 tentatives.')
        );

        if ($organization) {
            $staff->organization()->associate($organization);
        }

        $staff->save();

        $user = new User();
        $user->firstname = $staff->firstname;
        $user->lastname = $staff->lastname;
        $user->username = $staff->username;
        $user->email = $staff->email;
        $user->phone = $staff->phone;
        $user->email_verified_at = now();
        $user->phone_verified_at = now();
        $user->{Staff::getAuthPasswordField()} = $password;
        $user->entity()->associate($staff);

        if ($organization) {
            $user->organization()->associate($organization);
        }

        $user->save();
        $user->assignRole(Role::SUPER_ADMIN);

        $this->info("✅ Utilisateur créé avec succès.");

        return $staff;
    }
}
