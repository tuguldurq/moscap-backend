<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Heir;
use App\Models\Artist;
use App\Models\EmergencyContact;
use App\Models\UserBanks;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class UsersImport implements ToModel, WithUpserts, WithUpsertColumns, SkipsEmptyRows, WithProgressBar
{
    use Importable;
    /**
    * @param Row $row
    */
    public function model(array $row)
    {
            $ifexistsUser = User::where('email', $row[12])->first();
            if (!isset($row[3]) || !isset($row[4]) || !empty($ifexistsUser)) {
                return null;
            }
            $user = User::create([
                'first_name' =>$row[3] ?? null,
                'last_name' => $row[4] ?? null,
                'register_number' => $row[9] ?? null,
                'phone' => $row[11] != null ? "+976 "  . $row[11] : null,
                'citizen' => 'mongolia',
                'role' => 'artist',
                'sex' => $row[8] == 'эр' ? 'male' : 'female',
                'email' => $row[12] ?? null,
                'password' => '$2y$10$9Ck6IaEdVDHWNOKX7cN8QuSIuQOKAMtC5qAs28IsFOeK5dbyQOGbe',
            ]);
            $emergency = $user->emergency()->create([
                'name' => $row[15], // null bolgoh
                'type_id' => $row[16], // null bolgoh
                'phone' => $row[17], // null bolgoh
            ]);

            $bank = $user->bank()->create([
                'name' => $row[18],
                'account' => $row[19]
            ]);

            $artist = $user->artist()->create([
                'mgl_code' => $row[0],
                'type' => $row[1],
                'stage_name' => $row[5],
            ]);

            $heir_names = explode(" ", $row[25]);

            $heir = $user->heir()->create([
                'first_name' => $heir_names[0] ?? null, 
                'last_name' => $heir_names[1] ?? null, 
                'register_number' => $row[27] ?? null,
                'type' => $row[24] ?? null,
                'email' => null,
                'phone' => $row[26] != null ? "+976 " . $row[26] : null,
                'file_path' => null, 
            ]);
        return $user;
    }

    public function batchSize(){
        return 3;
    }
    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'email';
    }

    /**
     * @return array
     */
    public function upsertColumns()
    {
        return ['first_name', 'last_name', 'password'];
    }

}
