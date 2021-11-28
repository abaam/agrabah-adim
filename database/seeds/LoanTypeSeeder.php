<?php

use Illuminate\Database\Seeder;

class LoanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
//            'Short Loan',
//            'Long Term Loan',
//            'PO Financing',
//            'Equipment Loan',
//            'Crop Insurance',
//            'Trade Insurance',
            'Short term loan',
            'Long term loan',
            'Equipment loan',
            'Vehicle loan',
            'Educational loan',
            'Crop Insurance',
            'Life Insurance',
            'Health Insurance',
            'Bank Account Opening',
        );

        foreach($types as $type) {
            \App\LoanType::create(array(
                'name' => stringSlug($type),
                'display_name' => $type
            ));
        }
    }
}
