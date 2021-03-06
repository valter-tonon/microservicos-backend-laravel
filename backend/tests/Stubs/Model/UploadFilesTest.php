<?php


namespace Tests\Stubs\Model\UploadFilesStub;


use Tests\Stubs\Model\UploadFilesStub;
use Tests\TestCase;

class UploadFilesTest extends TestCase
{
    private $obj;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->obj = new UploadFilesStub();
    }

    public function testMakeOldFieldsOnSaving()
    {
        UploadFilesStub::dropTable();
        UploadFilesStub::makeTable();

        $this->obj->fill([
            'name' => 'test',
            'file1' => 'test1.mp4',
            'file2' => 'test2.mp4'
        ]);
        $this->obj->save();
        $this->assertCount(0, $this->obj->oldFiles);

    }

}
