<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeadStatus::create(['status' => 'Active Lead']);
        LeadStatus::create(['status' => 'Prospect']);
        LeadStatus::create(['status' => 'Prospect']);
        LeadStatus::create(['status' => 'No!']);
        LeadStatus::create(['status' => 'DNC']);
        LeadStatus::create(['status' => 'Client']);
        LeadStatus::create(['status' => 'VM']);
        LeadStatus::create(['status' => 'UN']);
        LeadStatus::create(['status' => 'CE']);
        LeadStatus::create(['status' => 'HU']);
        LeadStatus::create(['status' => 'DC']);
        LeadStatus::create(['status' => 'NI']);
        LeadStatus::create(['status' => 'CF']);
        LeadStatus::create(['status' => 'CB']);
    }
}
