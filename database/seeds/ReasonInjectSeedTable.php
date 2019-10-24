<?php

use Illuminate\Database\Seeder;

class ReasonInjectSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");
        DB::table('reason_Reject')->insert([
            [
                'name' => 'Diagnosis is not covered by the policy',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Inconsistent Tests',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Benefit is not covered by the policy (Vaccination, extra bed, personal items, cosmetic-related service, eye examination, public transportation, Treatment plan, Claimant is not the covered person, etc.)',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim was incurred outside plan coverage period',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Routine physical exam,non-prescription,vitamins are not covered',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Item(s) is(are) not covered by the policy',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pre-existing condition',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Inconsistent Medicine',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Provisional receipt is not accepted, please provide original receipt',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sport',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fighting or related to ancohol',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Service type is not covered by the policy',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Location of provider is within Treatment Area Limit and is not covered',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Amount below minimum payable limit',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim was incurred out of member effective period',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim was incurred within the reinstatement period is not covered',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim is not payable because it is over 1 year from date of service',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Non disclosed pre-existing condition is not covered',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '1-year waiting period',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '30-day waiting period',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Not enough document',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Policy has been denied',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Claim is partially paid by gov/ but client still submits claim or Payment by other insurance / medicare has been deducted from allowed expenses',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per year for the benefit exhausted',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per visit exceeded',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per day exceeded',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per disability per visit for the benefit exhausted',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum no. of days per disability per year for the service exceeded',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per disability per lifetime for the benefit exhausted',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Follow-up over 90 days after discharge date or no hospital accommodation found',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per year for the service exhausted',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maximum amount per disability per lifetime for the service exhausted',
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
