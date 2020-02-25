<?php

use Illuminate\Database\Seeder;

class StatusTransSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");
        DB::table('role_change_status')->insert([
            [
                'name' => 'New',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim Approved',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim Rejected',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim Repealed',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lead Approved',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lead Rejected',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lead Repealed',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Manager Approved',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Manager Rejected',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Manager Repealed',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'QC Approved',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'QC Rejected',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'QC Repealed',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
