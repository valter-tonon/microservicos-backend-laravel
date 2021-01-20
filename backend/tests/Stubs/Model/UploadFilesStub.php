<?php


namespace Tests\Stubs\Model;


use App\Models\Traits\UploadFiles;
use Illuminate\Database\Eloquent\Model;

class UploadFilesStub extends Model
{
    use UploadFiles;

    protected $table;
    protected $fillable = ['name', 'file1', 'file2'];
    protected static $fileFields = ['file1', 'file2', 'file3'];

    public static function makeTable()
    {
        \Schema::create('upload_file_stubs', function ($table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('file1');
            $table->string('file2');
            $table->timestamps();
        });
    }

    public static function dropTable()
    {
        \Schema::dropIfExists('upload_file_stubs');
    }

    protected function UploadDir()
    {
        return "1";
    }
}
