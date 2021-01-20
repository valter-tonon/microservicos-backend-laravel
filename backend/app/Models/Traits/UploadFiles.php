<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

trait UploadFiles
{
    protected abstract function UploadDir();
    public $oldFiles = [];

    public static function bootUploadFiles()
    {
        static::updating(function (Model $model){
            $fielsUpdated = array_keys($model->getDirty());
            $filesUpdated = array_intersect($fielsUpdated, self::$fileFields);
            $filesFiltered = Arr::where($filesUpdated, function($fileField) use($model){
                return $model->getOriginal($fileField);
            });
            $model->oldFiles = array_map(function($fileField) use ($model) {
                return $model->getOriginal($fileField);
            }, $filesFiltered);
        });
    }
    /**
     * @param UploadedFile $files
     */
    public function uploadFiles(array $files)
    {
        foreach ($files as $file) {
            $this->uploadFile($file);
        }
    }

    public function uploadFile(UploadedFile $file)
    {
        $file->store($this->UploadDir());
    }

    public function deleteOldFiles()
    {
        $this->deleteFiles($this->oldFiles);

    }

    public function deleteFiles(array $files)
    {
        foreach ($files as $file) {
            $this->deleteFile($file);
        }
    }

    /**
     * @param string|UploadedFile $file
     */
    public function deleteFile($file)
    {
        $filename = $file instanceof UploadedFile ? $file->hashName() : $file;
        \Storage::delete("{$this->UploadDir()}/{$filename}");
    }

    public static function extractFiles(array &$attributes = [])
    {
        $files = [];
        foreach (self::$fileFields as $file) {
            if ( isset($attributes[$file]) && $attributes[$file] instanceof UploadedFile) {
                $files[] = $attributes[$file];
                $attributes[$file] = $attributes[$file]->hashName();
            }
        }
        return $files;
    }

    protected function getFileUrl($fileName)
    {
        return \Storage::url("{$this->UploadDir()}/$fileName");
    }
}
