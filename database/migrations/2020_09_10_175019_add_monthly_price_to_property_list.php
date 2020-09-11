<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthlyPriceToPropertyList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_list', function (Blueprint $table) {
            //
            $table->string('monthly_rate')->default(0);
            $table->string('security_deposit')->default(0);
            $table->string('cleaning_fee')->default(0);
            $table->string('check_in')->default('9:00');
            $table->string('check_out')->default('9:00');
        });
        $rows = DB::table('property_list')
            ->whereNotNull('id')
            ->where('is_complete', 1)
            ->get(['id']);
        foreach ($rows as $row) {
            DB::table('property_list')
                ->where('id', $row->id)
                ->update([
                    'monthly_rate' => rand(111, 999),
                    'security_deposit' => rand(11, 99),
                    'cleaning_fee' => rand(11, 99),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_list', function (Blueprint $table) {
            //
            $table->dropColumn(['monthly_rate', 'security_deposit', 'cleaning_fee', 'check_in', 'check_out']);
        });
    }
}
