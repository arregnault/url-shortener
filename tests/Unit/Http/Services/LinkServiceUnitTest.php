<?php

namespace Tests\Unit\Http\Repositories;

use App\Exceptions\RecordNotFoundException;
use App\Http\Contracts\Repositories\LinkRepository;
use App\Http\Services\LinkService;
use App\Models\Link;
use App\Shared\Consts\Entities\LinkConsts;
use App\Shared\Consts\Tests\ValueConsts;
use Tests\TestCase;

class LinkServiceUnitTest extends TestCase
{


    /**
     * Test set-up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->linkRepository = $this->mockery::mock(LinkRepository::class);
        $this->unitService    = new LinkService($this->linkRepository);
        $this->record         = null;
        $this->records        = collect([]);
        $this->filters        = [];
        $this->table          = LinkConsts::TABLE_NAME;

    }//end setUp()


    public function testGetLinkCollectionWhenOrderByAsc()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->first();
        $this->filters = ['search' => $this->record->url];
        $this->linkRepository->shouldReceive('getLinkCollection')
            ->with($this->filters, LinkConsts::ID, false)
            ->once()
            ->andReturns($this->records);
        $response      = $this->unitService->getLinkCollection($this->filters, LinkConsts::ID, false);
        $this->assertCount($this->records->count(), $response);
        $this->assertLink($this->record, $response->first());

    }//end testGetLinkCollectionWhenOrderByAsc()


    public function testGetLinkCollectionWhenOrderByDesc()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->first();
        $this->filters = ['search' => $this->record->url];
        $this->linkRepository->shouldReceive('getLinkCollection')
            ->with($this->filters, LinkConsts::ID, true)
            ->once()
            ->andReturns($this->records);
        $response      = $this->unitService->getLinkCollection($this->filters, LinkConsts::ID, true);
        $this->assertCount($this->records->count(), $response);
        $this->assertLink($this->record, $response->first());

    }//end testGetLinkCollectionWhenOrderByDesc()


    public function testGetLinkById()
    {

        $this->record = Link::factory()->create();
        $this->linkRepository->shouldReceive('getLink')
            ->with($this->record->id)
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->getLink($this->record->id);
        $this->assertLink($this->record, $response);

    }//end testGetLinkById()


    public function testGetLinkByIdWhenThrowsRecordNotFoundException()
    {

        $this->expectException(RecordNotFoundException::class);
        $this->linkRepository->shouldReceive('getLink')
            ->with(ValueConsts::FIRST_ID)
            ->once()
            ->andReturns(null);
        $this->unitService->getLink(ValueConsts::FIRST_ID);

    }//end testGetLinkByIdWhenThrowsRecordNotFoundException()


    public function testRedirectTotLink()
    {

        $this->record = Link::factory()->create();
        $this->linkRepository->shouldReceive('getLinkByCode')
            ->with($this->record->code)
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->redirectTotLink($this->record->code);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals($this->record->url, $response->getTargetUrl());

    }//end testRedirectTotLink()


    public function testRedirectTotLinkWhenLinkDoesntExists()
    {

        $this->record = Link::factory()->make();
        $this->linkRepository->shouldReceive('getLinkByCode')
            ->with($this->record->code)
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->redirectTotLink($this->record->code);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertNotEquals($this->record->url, "/");

    }//end testRedirectTotLinkWhenLinkDoesntExists()


    public function testCreateLink()
    {
        $this->record = Link::factory()->create();
        $this->linkRepository->shouldReceive('createLink')
            ->withAnyArgs($this->record->only([LinkConsts::CODE, LinkConsts::URL]))
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->createLink($this->record->only([LinkConsts::URL]));
        $this->assertLink($this->record, $response);

    }//end testCreateLink()


    public function testUpdateLink()
    {
        $this->record = Link::factory()->create();
        $this->linkRepository->shouldReceive('getLink')
            ->with($this->record->id)
            ->times(2)
            ->andReturns($this->record)
            ->getMock()
            ->shouldReceive('updateLink')
            ->with($this->record->id, [LinkConsts::URL => $this->record->url])
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->updateLink($this->record->id, [LinkConsts::URL => $this->record->url]);
        $this->assertLink($this->record, $response);

    }//end testUpdateLink()


    public function testUpdateLinkWhenThrowsRecordNotFoundException()
    {

        $this->expectException(RecordNotFoundException::class);
        $this->linkRepository->shouldReceive('getLink')
            ->with(ValueConsts::FIRST_ID)
            ->once()
            ->andReturns(null);
        $this->unitService->updateLink(ValueConsts::FIRST_ID, [LinkConsts::URL => $this->faker->url()]);

    }//end testUpdateLinkWhenThrowsRecordNotFoundException()


    public function testDeleteLink()
    {
        $this->record     = Link::factory()->create();
        $this->linkRepository->shouldReceive('getLink')
            ->with($this->record->id)
            ->once()
            ->andReturns($this->record)
            ->getMock()
            ->shouldReceive('deleteLink')
            ->with($this->record->id)
            ->once()
            ->andReturns(true);
        $response     = $this->unitService->deleteLink($this->record->id);
        $this->assertLink($this->record, $response);

    }//end testDeleteLink()


    public function testDeleteLinkWhenThrowsRecordNotFoundException()
    {

        $this->expectException(RecordNotFoundException::class);
        $this->linkRepository->shouldReceive('getLink')
            ->with(ValueConsts::FIRST_ID)
            ->once()
            ->andReturns(null);
        $this->unitService->deleteLink(ValueConsts::FIRST_ID);

    }//end testDeleteLinkWhenThrowsRecordNotFoundException()


    private function assertLink($record, $data)
    {
        $this->assertIsObject($data);
        $this->assertEquals($record->id, $data->id);
        $this->assertEquals($record->url, $data->url);
        $this->assertEquals($record->code, $data->code);

    }//end assertLink()


}//end class
