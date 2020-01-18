<?php

namespace Modules\ChallengeHashtag\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Modules\Challenge\Entities\Question;
use Modules\ChallengeHashtag\Entities\Hashtag;

class ChallengeHashtagDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $tags = [
            'love',
            'fashion',
            'sports',
            'science',
            'movies',
            'history',
            'games'
        ];

        foreach ($tags as $tag) {
            DB::table('hashtags')->insert(['tag' => $tag]);
        }

        $questions = Question::all();
        foreach ($questions as $question) {
            $tags = Hashtag::all()->random(2);
            $tagArray = [];
            foreach ($tags as $tag) {
                $tagArray[] = $tag->id;
            }
            $question->hashtag = implode(',', $tagArray);
            $question->save();
        }
    }
}
