<?php

namespace Database\Seeders;

use App\Models\DeleteReason;
use Illuminate\Database\Seeder;

class DeleteReasonSeeder extends Seeder
{
  public function run()
  {
    DeleteReason::factory()->count(1)->create();
  }
}
