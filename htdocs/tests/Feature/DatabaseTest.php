<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function testHasAdmin()
    {
        // Проверка наличия админа
        $this->assertDatabaseHas('users', [
            'name' => 'admin',
            'role_id' => DB::table('roles')->min('id')
        ]);

        // Првоерка наличия модератора
        $this->assertDatabaseHas('users', [
            'name' => 'moderator',
            'role_id' => DB::table('roles')->take(1)->skip(1)->get()->first()->id
        ]);
    }

    public function testComments($iNumComments = 100)
    {
        // Добавляем комментарии через фабрику
        factory(\App\Models\ArticleComment::class, $iNumComments)->make()->each(function ($v) {
            $this->addComment($v);
        });

        // Проверка комментариев на соответствия принципам nested sets
        // 1. Левый ключ ВСЕГДА меньше правого;
        $iRecords = DB::table('articles_comments')->whereColumn('left_key', '>', 'right_key')->count();
        $this->assertEquals($iRecords, 0);

        // 2. Наименьший левый ключ ВСЕГДА равен 1;
        $iMinLeftKey = DB::table('articles_comments')->min('left_key');
        $this->assertEquals($iMinLeftKey, 1);

        // 3. Наибольший правый ключ ВСЕГДА равен двойному числу узлов;
        $iMaxRightKey = DB::table('articles_comments')->max('right_key');
        $iNumSets = DB::table('articles_comments')->count();
        $this->assertEquals($iMaxRightKey, 2 * $iNumSets);

        // 4. Разница между правым и левым ключом ВСЕГДА нечетное число;
        $aErrRecords = DB::table('articles_comments')->where(DB::raw('MOD((right_key - left_key), 2)'), 0)->count();
        $this->assertEquals($aErrRecords, 0);

        // 5. Если уровень узла нечетное число то тогда левый ключ ВСЕГДА нечетное число, то же самое и для четных чисел;
        $aErrRecords = DB::table('articles_comments')->where(DB::raw('MOD((left_key - level + 2), 2)'), 1)->count();
        $this->assertEquals($aErrRecords, 0);

        // 6. Ключи ВСЕГДА уникальны, вне зависимости от того правый он или левый;
        $aErrRecords = DB::select('SELECT COUNT(*) AS number
                                   FROM bpl_articles_comments AS ac1,
                                        bpl_articles_comments AS ac2
                                   WHERE (
                                            ac1.left_key = ac2.left_key OR
                                            ac1.left_key = ac2.right_key OR
                                            ac1.right_key = ac2.left_key OR
                                            ac1.right_key = ac2.right_key
                                          )
                                          AND ac1.id <> ac2.id;')[0];
        $this->assertEquals($aErrRecords->number, 0);
    }

    private function addComment($oComment)
    {
        $oRandomComment = DB::table('articles_comments')
            ->where('article_id', $oComment->article_id)
            ->take(1)
            ->inRandomOrder()
            ->get()
            ->first();
        $oComment->parent_id = $oRandomComment == null ? 0 : $oRandomComment->id;

        if ($oComment->parent_id == 0) {
            $iRightKey = DB::table('articles_comments')->max('right_key') + 1;
            $iLevel = 0;
        } else {
            $oParentInfo = DB::table('articles_comments')
                ->where('id', $oComment->parent_id)
                ->get(['right_key', 'level'])
                ->first();
            $iRightKey = $oParentInfo->right_key;
            $iLevel = $oParentInfo->level;
        }
        DB::update('UPDATE ' . DB::getTablePrefix() .'articles_comments
                          SET right_key = right_key + 2,
                            left_key = IF(left_key > :rKey, left_key + 2, left_key)
                          WHERE right_key >= :rKey', ['rKey' => $iRightKey]);
        $oComment->level = $iLevel + 1;
        $oComment->left_key = $iRightKey;
        $oComment->right_key = $iRightKey + 1;
        $oComment->save();
    }
}
