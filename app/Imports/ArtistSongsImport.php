<?php

namespace App\Imports;

use App\Models\Song;
use App\Models\User;
use App\Models\Artist;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArtistSongsImport implements ToModel, WithProgressBar, SkipsEmptyRows, WithHeadingRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(empty($row['origin_name']) && !isset($row['author_composer'])){
            return null;
        }

        // user uussen
        if($row['phone']){
            $user = User::where('phone', '+976 '.$row['phone'])->first();

        }else{
            $u = explode(" ", $row['author_composer']);
            if(count($u) > 1){
                $user = User::where("first_name", $u[1])->where('last_name', $u[0])->first();
            }else{
                return null;
            }
        }
        if(!$user){
            $us = explode(" ", $row['author_composer']);

            $user = User::create([
                'first_name' => $us[1],
                'last_name' => $us[0],
                'phone' => '+976 '.$row['phone'],
                'password' => 'P@ssw0rd',
                'role' => 'artist'
            ]);
            $artist = $user->artist()->create([
                'ipi_code' => $row['ipi_code'],
                'mgl_code' => $row['mgl_code'],
                'type' => $row['status']
            ]);
        }else{
            $artist = $user->artist;
        }
        if($artist){
            // uussen bwal
            if($row['song_code']){
                $song = Song::where('song_code', $row['song_code'])->first();
                if($song) {
                    if ($row['status'] === 'C') {
                        $song->c_iswc = $row['iswc'];
                        $song->composer_id = $artist->id;
                    } elseif ($row['status'] === 'A') {
                        $song->a_iswc = $row['iswc'];
                        $song->author_id = $artist->id;
                    }
                    $song->save();
                }else{
                    $song = Song::create([
                        'song_code' => $row['song_code'] ?? null,
                        'year' => $row['year'] ?? null,
                        'origin_name' => $row['origin_name'] ?? null,
                        'category' => $row['category'] ?? null,
                        'performer' => $row['performer'] ?? null,
                    ]);
                    if ($row['status'] === 'C') {
                        $song->c_iswc =  $row['iswc'];
                        $song->composer_id = $artist->id;
                    } elseif ($row['status'] === 'A') {
                        $song->a_iswc =  $row['iswc'];
                        $song->author_id = $artist->id;
                    }
            
                    $song->save();
                }
            }else{
                // songcode bhgu bol excels neg duu gdgiig ingj yalgaj baigaa.
                $song = Song::where('origin_name', $row['origin_name'])->first();
                
                if($song){
                    if ($row['status'] === 'C') {
                        $song->c_iswc =  $row['iswc'];
                        $song->composer_id = $artist->id;
                    } elseif ($row['status'] === 'A') {
                        $song->a_iswc =  $row['iswc'];
                        $song->author_id = $artist->id;
                    }
            
                    $song->save();
                }else {
                    $song = Song::create([
                        'song_code' => $row['song_code'] ?? null,
                        'year' => $row['year'] ?? null,
                        'origin_name' => $row['origin_name'] ?? null,
                        'category' => $row['category'] ?? null,
                        'performer' => $row['performer'] ?? null,
                    ]);
                    if ($row['status'] === 'C') {
                        $song->c_iswc =  $row['iswc'];
                        $song->composer_id = $artist->id;
                    } elseif ($row['status'] === 'A') {
                        $song->a_iswc =  $row['iswc'];
                        $song->author_id = $artist->id;
                    }
            
                    $song->save();
                }
            }
            // uuseegu bol uusgene
            
        }
        return $user;
        // $ipiArtist = Artist::where('ipi_code', $row['ipi_code'])->first();
        // if($ipiArtist){
        //     //artist oldloo
        //     // duu nemne
        //     $ifExistSong = Song::where('song_code', $row['song_code'])->first();
            
        //     if($ifExistSong){
        //         if ($row['status'] === 'C') {
        //             // $ifExistSong->c_iswc = $row['iswc'];
        //             $ifExistSong->composer_id = $ipiArtist->id;
        //         } elseif ($row['status'] === 'A') {
        //             // $ifExistSong->a_iswc = $row['iswc'];
        //             $ifExistSong->author_id = $ipiArtist->id;
        //         }
        //         $ifExistSong->save();
        //         return $ifExistSong;
        //     }else{
        //         $ifExistsArtistSong = Song::create([
        //             'song_code' => $row['song_code'] ?? null,
        //             'year' => $row['year'] ?? null,
        //             'origin_name' => $row['origin_name'] ?? null,
        //             'category' => $row['category'] ?? null,
        //             'performer' => $row['performer'] ?? null,
        //         ]);
        //         if ($row['status'] === 'C') {
        //             // $ifExistsArtistSong->c_iswc = $row['iswc'];
        //             $ifExistsArtistSong->composer_id = $ipiArtist->id;
        //         } elseif ($row['status'] === 'A') {
        //             // $ifExistsArtistSong->a_iswc = $row['iswc'];
        //             $ifExistsArtistSong->author_id = $ipiArtist->id;
        //         }
        
        //         $ifExistsArtistSong->save();
        //         return $ifExistsArtistSong;
        //     }
           
        // }

        // $userNames = explode(" ", $row['author_composer']);
        // if(count($userNames) < 2){
        //     $userNames = ['Хоосон', 'Хоосон'];
        // }
        // $user = User::create([
        //     'first_name' => $userNames[1],
        //     'last_name' => $userNames[0],
        //     'phone' => '+976 '.$row['phone'],
        //     'password' => 'P@ssw0rd',
        //     'role' => 'artist'
        // ]);
        // $artist = $user->artist()->create([
        //     'ipi_code' => $row['ipi_code'],
        //     'mgl_code' => $row['mgl_code'],
        // ]);
        // $ifExistSong1 = Song::where('song_code', $row['song_code'])->first();
            
        // if($ifExistSong1){
        //     if ($row['status'] === 'C') {
        //         // $ifExistSong1->c_iswc = $row['iswc'];
        //         $ifExistSong1->composer_id = $artist->id;
        //     } elseif ($row['status'] === 'A') {
        //         // $ifExistSong1->a_iswc = $row['iswc'];
        //         $ifExistSong1->author_id = $artist->id;
        //     }
        //     $ifExistSong1->save();
        //     return $ifExistSong1;
        // }else{
        //     $artistSong = Song::create([
        //         'song_code' => $row['song_code'] ?? null,
        //         'year' => $row['year'] ?? null,
        //         'origin_name' => $row['origin_name'] ?? null,
        //         'category' => $row['category'] ?? null,
        //         'performer' => $row['performer'] ?? null,
        //     ]);
        //     if ($row['status'] === 'C') {
        //         // $artistSong->c_iswc =  $row['iswc'];
        //         $artistSong->composer_id = $artist->id;
        //     } elseif ($row['status'] === 'A') {
        //         // $artistSong->a_iswc =  $row['iswc'];
        //         $artistSong->author_id = $artist->id;
        //     }
    
        //     $artistSong->save();
    
        //     return $artistSong;
        // }
       
    }

    public function batchSize()
    {
        return 2360;
    }
}
