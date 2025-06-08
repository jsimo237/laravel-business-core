<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up(){

        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if(!Schema::hasTable($tableNames['permissions'])){
            Schema::create($tableNames['permissions'], function (Blueprint $table) {
                $table->bigIncrements('id'); // permission id
                $table->string('name',125)
                    ->comment("Le nom (Ex:'role-list')");       // For MySQL 8.0 use string('name', 125);

                $table->string('guard_name',125); // For MySQL 8.0 use string('guard_name', 125);

                $table->text('description')->nullable();

                $table->string('group')->nullable();

                $table->timestamps();

                $table->unique(['name', 'guard_name'],uniqid("UQ_"));
            });
        }
        if(!Schema::hasTable($tableNames['roles'])){
            Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
                $table->bigIncrements('id'); // role id
                if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                    $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                    $table->index($columnNames['team_foreign_key'], uniqid("IDX_"));
                }
                $table->string('name',125)
                    ->comment("Le nom (Ex:'role-list')");       // For MySQL 8.0 use string('name', 125);
                $table->string('guard_name',125)
                    ->comment("La guard d'authentification (Ex : 'users')"); // For MySQL 8.0 use string('guard_name', 125);

                $table->boolean("editable")->default(true)
                    ->comment("Determine si la ligne est modifiable par le frontend");

                $table->text('description')->nullable();

                $table->timestamps();
                $table->softDeletes();
                if ($teams || config('permission.testing')) {
                    $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
                } else {
                    $table->unique(['name', 'guard_name'], uniqid("UQ_"));
                }
            });
        }

        if(!Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams, $pivotPermission) {
                $table->unsignedBigInteger($pivotPermission);

                $table->string('model_type',125);
                //$table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->string($columnNames['model_morph_key'],100);
                $table->index([$columnNames['model_morph_key'], 'model_type'], uniqid("IDX_"));

                $table->foreign($pivotPermission)
                    ->references('id') // permission id
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');
                if ($teams) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key']);
                    $table->index($columnNames['team_foreign_key'], uniqid("IDX_"));

                    $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                        uniqid("IDX_"));
                } else {
                    $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                        uniqid("IDX_"));
                }

            });
        }

        if(!Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::create($tableNames['model_has_roles'], function (Blueprint $table)
            use ($tableNames, $columnNames, $teams, $pivotRole) {
                $table->unsignedBigInteger($pivotRole);

                $table->string('model_type',125);
                //$table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->string($columnNames['model_morph_key'],100);
                $table->index([$columnNames['model_morph_key'], 'model_type'], uniqid("IDX_"));

                $table->foreign($pivotRole)
                    ->references('id') // role id
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');
                if ($teams) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key']);
                    $table->index($columnNames['team_foreign_key'], uniqid("IDX_"));

                    $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                        uniqid("PK_"));
                } else {
                    $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                        uniqid("PQ_"));
                }
            });
        }
        if(!Schema::hasTable($tableNames['role_has_permissions'])) {
            Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
                $table->unsignedBigInteger($pivotPermission);
                $table->unsignedBigInteger($pivotRole);

                $table->foreign($pivotPermission)
                    ->references('id') // permission id
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->foreign($pivotRole)
                    ->references('id') // role id
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                $table->primary([$pivotPermission, $pivotRole],
                    uniqid("PK_"));
            });
        }
        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down(){
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged.
             Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
