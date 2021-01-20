<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Genero;
use App\Models\Traits\UploadFiles;
use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestUploads;
use Tests\Traits\TestValidtions;

class VideoControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidtions, TestSaves, TestUploads;

    protected $video;
    private $sendData;
    protected function setUp(): void
    {
        parent::setUp();

        $this->video = factory(Video::class)->create();
        $this->sendData = [
            'title' => 'title',
            'description' => 'description',
            'year_launched' => 2010,
            'rating' => Video::RATING_LIST[1],
            'duration' => 10,
            'opened' => false,
        ];
    }

    public function testIndex()
    {
        $response = $this->get(route('videos.index'));
        $response->assertStatus(200)
                 ->assertJson([$this->video->toArray()]);

    }

    public function testShow()
    {
        $response = $this->get(route('videos.show', [$this->video->id]));
        $response
            ->assertStatus(200)
            ->assertJson($this->video->toArray());
    }

    public function testInvalidationData()
    {
        $data = [
            'title' => '',
            'description' => '',
            'year_launched' => '',
            'rating' => '',
            'duration' => '',
            'categories_id' => '',
            'generos_id' => ''
        ];
        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');

        $data = [
            'title' => str_repeat('a', 256)
        ];
        $this->assertInvalidationInStoreAction($data, 'max.string', ['max'=> 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max'=> 255]);

        $data = [
            'duration' => 's'
        ];
        $this->assertInvalidationInStoreAction($data, 'integer');
        $this->assertInvalidationInUpdateAction($data, 'integer');

        $data = [
            'year_launched' => 'a'
        ];
        $this->assertInvalidationInStoreAction($data, 'date_format', ['format' => 'Y']);
        $this->assertInvalidationInUpdateAction($data, 'date_format', ['format' => 'Y']);

        $data = [
            'opened' => 'sim'
        ];
        $this->assertInvalidationInStoreAction($data, 'boolean');
        $this->assertInvalidationInUpdateAction($data, 'boolean');
    }

    public function testInvalidationCategoriesFields()
    {
        $data = [
            'categories_id' => 'a'
        ];
        $this->assertInvalidationInStoreAction($data, 'array');
        $this->assertInvalidationInUpdateAction($data, 'array');

        $data = [
            'categories_id' => [100]
        ];
        $this->assertInvalidationInStoreAction($data, 'exists');
        $this->assertInvalidationInUpdateAction($data, 'exists');
    }

//    public function testInvalidationGenerosFields()
//    {
//        $data = [
//            'generos_id' => 'a'
//        ];
//        $this->assertInvalidationInStoreAction($data, 'array');
//        $this->assertInvalidationInUpdateAction($data, 'array');

//        $data = [
//            'generos_id' => [100]
//        ];
//        $this->assertInvalidationInStoreAction($data, 'exists');
//        $this->assertInvalidationInUpdateAction($data, 'exists');
//    }
    public function testSave()
    {
        $category = factory(Category::class)->create();
        $genre = factory(Genero::class)->create();
        $genre->categories()->sync($category->id);

        $data = [
            [
                'send_data' => $this->sendData + [
                    'categories_id' => [$category->id],
                    'generos_id' => [$genre->id]
                ],
                'test_data' => $this->sendData + ['opened' => false]
            ],
            [
                'send_data' => $this->sendData + [
                    'opened' => true,
                    'categories_id' => [$category->id],
                    'generos_id' => [$genre->id]
                ],
                'test_data' => $this->sendData + ['opened' => true]
            ],
            [
                'send_data' => $this->sendData + [
                    'rating' => Video::RATING_LIST[1],
                    'categories_id' => [$category->id],
                    'generos_id' => [$genre->id]
                ],
                'test_data' => $this->sendData + ['rating' => Video::RATING_LIST[1]]
            ],
        ];
        foreach ($data as $key => $value) {
            $response = $this->assertStore(
                $value['send_data'],
                $value['test_data'] + ['deleted_at' => null]
            );
            $response->assertJsonStructure([
                'created_at',
                'updated_at'
            ]);

            $this->assertHasCategory(
                $response->json('id'),
                $value['send_data']['categories_id'][0]
            );
            $this->assertHasGenre(
                $response->json('id'),
                $value['send_data']['generos_id'][0]
            );
            $response = $this->assertUpdate(
                $value['send_data'],
                $value['test_data'] + ['deleted_at' => null]
            );
            $response->assertJsonStructure([
                'created_at',
                'updated_at'
            ]);
        }
    }

    public function testDelete()
    {
        $response = $this->delete(route('videos.destroy',
            ['video' => $this->video->id]));
        $response
            ->assertStatus(204);
        $this->assertNull(Video::find($this->video->id));

    }

//    public function testInvalidationVideoField()
//    {
//        $this->assertInvalidationFile(
//            'video_file',
//            'mp4',
//            12,
//            'mymetypes', [ 'values' => 'video/mp4']
//        );
//    }

    protected function assertHasCategory($videoId, $categoryId)
    {
        $this->assertDatabaseHas('category_video', [
            'video_id' => $videoId,
            'category_id' => $categoryId
        ]);
    }

    protected function assertHasGenre($videoId, $genreId)
    {
        $this->assertDatabaseHas('genero_video',[
            'video_id' => $videoId,
            'genero_id' => $genreId
        ]);
    }

    protected function routeStore()
    {
        return route('videos.store');
    }
    protected function routeUpdate()
    {
        return route( 'videos.update', ['video' => $this->video]);
    }

    protected function model()
    {
        return Video::class;
    }

}
