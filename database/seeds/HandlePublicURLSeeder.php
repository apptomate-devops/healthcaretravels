<?php

use Illuminate\Database\Seeder;

class HandlePublicURLSeeder extends Seeder
{
    public function updatePathFields($model, $column, $subject, $replace = "")
    {
        $rows = $model
            ::query()
            ->where($column, 'LIKE', "%" . $subject . "%")
            ->get();
        Log::info($column . ' that needs to be replaced: count: ' . count($rows));
        $this->command->info($column . ' that needs to be replaced: count: ' . count($rows));
        foreach ($rows as $row) {
            $new_url = str_replace($subject, $replace, $row->$column);
            $model::where('id', $row->id)->update([$column => $new_url]);
        }
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cs = 'https://healthcaretravels.com/public'; // Common Subject
        $this->updatePathFields(\App\Models\AmenitiesList::class, 'icon_url', 'public/');
        $this->updatePathFields(\App\Models\Documents::class, 'document_url', $cs);
        $this->updatePathFields(\App\Models\HomeListing::class, 'image_url', $cs);
        $this->updatePathFields(\App\Models\Propertyamenties::class, 'amenties_icon', $cs);
        $this->updatePathFields(\App\Models\Propertyimage::class, 'image_url', $cs);
        $this->updatePathFields(\App\Models\Users::class, 'profile_image', $cs);
        $this->updatePathFields(\App\Models\Settings::class, 'value', $cs);
        // Note: Ignoring test_table as it is not being used in the code
    }
}
