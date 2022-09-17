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


    public function testGetLinkCollection()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->linkRepository->shouldReceive('getLinkCollection')
            ->with([], LinkConsts::CREATED_AT, false)
            ->once()
            ->andReturns($this->records);
        $response      = $this->unitService->getLinkCollection([]);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->records->first()->id, $response->first()->id);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->first()->id,
                LinkConsts::URL  => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());

    }//end testGetLinkCollection()


    public function testGetLinkCollectionWithFilters()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->first();
        $this->filters = ['search' => $this->record->url];
        $this->linkRepository->shouldReceive('getLinkCollection')
            ->with($this->filters, LinkConsts::CREATED_AT, false)
            ->once()
            ->andReturns($this->records);
        $response      = $this->unitService->getLinkCollection($this->filters);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->record->id, $response->first()->id);
        $this->assertEquals($this->record->url, $response->first()->url);
        $this->assertEquals($this->record->code, $response->first()->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->first()->id,
                LinkConsts::URL  => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());

    }//end testGetLinkCollectionWithFilters()


    public function testGetLinkCollectionWhenOrderByAsc()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->first();
        $this->linkRepository->shouldReceive('getLinkCollection')
            ->with($this->filters, LinkConsts::ID, false)
            ->once()
            ->andReturns($this->records);
        $response      = $this->unitService->getLinkCollection([], LinkConsts::ID, false);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->record->id, $response->first()->id);
        $this->assertEquals($this->record->url, $response->first()->url);
        $this->assertEquals($this->record->code, $response->first()->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->first()->id,
                LinkConsts::URL  => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());

    }//end testGetLinkCollectionWhenOrderByAsc()


    public function testGetLinkCollectionWhenOrderByDesc()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->first();
        $this->linkRepository->shouldReceive('getLinkCollection')
            ->with($this->filters, LinkConsts::ID, true)
            ->once()
            ->andReturns($this->records);
        $response      = $this->unitService->getLinkCollection([], LinkConsts::ID, true);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->record->id, $response->first()->id);
        $this->assertEquals($this->record->url, $response->first()->url);
        $this->assertEquals($this->record->code, $response->first()->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->first()->id,
                LinkConsts::URL  => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());

    }//end testGetLinkCollectionWhenOrderByDesc()


    public function testGetLinkById()
    {

        $this->record = Link::factory()->create();
        $this->linkRepository->shouldReceive('getLink')
            ->with($this->record->id)
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->getLink($this->record->id);
        $this->assertEquals($this->record->id, $response->id);
        $this->assertEquals($this->record->url, $response->url);
        $this->assertEquals($this->record->code, $response->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->id,
                LinkConsts::URL  => $response->url,
                LinkConsts::CODE => $response->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);

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
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $this->record->id,
                LinkConsts::URL  => $this->record->url,
                LinkConsts::CODE => $this->record->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);

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
        $this->assertDatabaseMissing($this->table, [LinkConsts::CODE => $this->record->code]);
        $this->assertDatabaseCount($this->table, 0);

    }//end testRedirectTotLinkWhenLinkDoesntExists()


    public function testCreateLink()
    {
        $this->record = Link::factory()->create();
        $this->linkRepository->shouldReceive('createLink')
            ->withAnyArgs($this->record->only([LinkConsts::CODE, LinkConsts::URL]))
            ->once()
            ->andReturns($this->record);
        $response     = $this->unitService->createLink($this->record->only([LinkConsts::URL]));
        $this->assertEquals($this->record->url, $response->url);
        $this->assertEquals($this->record->code, $response->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->id,
                LinkConsts::URL  => $response->url,
                LinkConsts::CODE => $response->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);

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
        $this->assertEquals($this->record->id, $response->id);
        $this->assertEquals($this->record->url, $response->url);
        $this->assertEquals($this->record->code, $response->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID   => $response->id,
                LinkConsts::URL  => $response->url,
                LinkConsts::CODE => $response->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);

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
        $this->record     = Link::factory()->make();
        $this->record->id = $this->faker->uuid();
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
        $this->assertEquals($this->record->id, $response->id);
        $this->assertEquals($this->record->url, $response->url);
        $this->assertEquals($this->record->code, $response->code);
        $this->assertDatabaseMissing($this->table, [LinkConsts::ID => $this->record->id]);
        $this->assertDatabaseCount($this->table, 0);

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


}//end class
