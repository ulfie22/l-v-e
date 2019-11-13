<?php

namespace Tests\Feature;

use App\Messages;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class imageStore extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_saves_am_image()
    {
        // Given
        $post_values = [
            'uuid' => '150cb461-4d6e-43be-b0b9-13b2ea9d81a0',
            'key' => 'tmp/150cb461-4d6e-43be-b0b9-13b2ea9d81a0',
            'bucket' => 'laravel-vapor-example',
            'name' => 'AutomaticMergePossible-2013-08-22_22-13-09.png',
            'content_type' => 'image/png',
        ];

        //Storage::delete(['https://s3.console.aws.amazon.com/s3/object/laravel-vapor-example/images/' . $post_values['uuid'] . '.png']);
        Storage::disk('s3')->delete('images/' . $post_values['uuid'] . '.png');
        // When
        $response = $this->post('/submit', $post_values)
            ->assertStatus(200);

        $mess = Messages::all()->last();
        //dump ($mess);

        $mediaItems = $mess->getMedia('message-images');
        $publicUrl = $mediaItems[0]->getUrl();
        $publicFullUrl = $mediaItems[0]->getFullUrl(); //url including domain
        $fullPathOnDisk = $mediaItems[0]->getPath();
        $temporaryS3Url = $mediaItems[0]->getTemporaryUrl(Carbon::now()->addMinutes(5));

        dump($publicUrl, $publicFullUrl, $fullPathOnDisk, $temporaryS3Url);

        dump ($mediaItems);

     }
}
