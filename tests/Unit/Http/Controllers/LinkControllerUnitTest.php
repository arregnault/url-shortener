<?php

namespace Tests\Unit\Http\Services;

use App\Exceptions\RecordNotFoundException;
use App\Http\Controllers\LinkController;
use App\Http\Requests\Links\StoreLinkRequest;
use App\Http\Requests\Links\UpdateLinkRequest;
use App\Http\Services\LinkService;
use App\Models\Link;
use App\Shared\Consts\Entities\LinkConsts;
use App\Shared\Consts\Tests\ValueConsts;
use App\Shared\Helpers\LinkHelper;
use Illuminate\Http\Request;
use Tests\TestCase;

class LinkControllerUnitTest extends TestCase
{


    /**
     * Test set-up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->linkService    = $this->mockery::mock(LinkService::class);
        $this->unitController = new LinkController($this->linkService);
        $this->request        = new Request();
        $this->record         = null;
        $this->records        = collect([]);
        $this->filters        = [];
        $this->table          = LinkConsts::TABLE_NAME;

    }//end setUp()


    public function testGetLinkCollection()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->first();
        $this->request = new Request(['search' => $this->record->url, 'orderBy' => LinkConsts::CREATED_AT, 'orderType' => true]);
        $this->linkService->shouldReceive('getLinkCollection')
            ->with(['search' => $this->record->url], LinkConsts::CREATED_AT, true)
            ->once()
            ->andReturns($this->records);
        $response = $this->unitController->index($this->request);
        $this->assertLinkResource($this->record, $response->getData()->data[0]);

    }//end testGetLinkCollection()


    public function testGetLinkById()
    {

        $this->record = Link::factory()->create();
        $this->linkService->shouldReceive('getLink')
            ->with($this->record->id)
            ->once()
            ->andReturns($this->record);
        $response = $this->unitController->show(new Request(), $this->record->id);
        $this->assertLinkResource($this->record, $response->getData()->data);

    }//end testGetLinkById()


    public function testRedirectTotLink()
    {

        $this->record = Link::factory()->create();
        $this->linkService->shouldReceive('redirectTotLink')
            ->with($this->record->code)
            ->once()
            ->andReturns(LinkHelper::redirectTo($this->record));
        $response     = $this->unitController->redirect($this->record->code);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals($this->record->url, $response->getTargetUrl());

    }//end testRedirectTotLink()


    public function testCreateLink()
    {
        $this->record  = Link::factory()->create();
        $this->request = new StoreLinkRequest([LinkConsts::URL => $this->record->url]);
        $this->linkService->shouldReceive('createLink')
            ->with($this->request->toArray())
            ->once()
            ->andReturns($this->record);
        $response = $this->unitController->store($this->request);
        $this->assertLinkResource($this->record, $response->getData()->data);

    }//end testCreateLink()


    public function testUpdateLink()
    {
        $this->record  = Link::factory()->create();
        $this->request = new UpdateLinkRequest([LinkConsts::URL => $this->record->url]);
        $this->linkService->shouldReceive('updateLink')
            ->with($this->record->id, $this->request->toArray())
            ->once()
            ->andReturns($this->record);
        $response = $this->unitController->update($this->request, $this->record->id);
        $this->assertLinkResource($this->record, $response->getData()->data);

    }//end testUpdateLink()


    public function testDeleteLink()
    {
        $this->record  = Link::factory()->create();
        $this->request = new UpdateLinkRequest([LinkConsts::URL => $this->record->url]);
        $this->linkService->shouldReceive('deleteLink')
            ->with($this->record->id)
            ->once()
            ->andReturns($this->record);
        $response = $this->unitController->destroy($this->record->id);
        $this->assertLinkResource($this->record, $response->getData()->data);
        $this->assertSuccessResponse($response);

    }//end testDeleteLink()


    private function assertLinkResource($record, $data)
    {
        $this->assertIsObject($data);
        $this->assertEquals($record->id, $data->id);
        $this->assertEquals($record->url, $data->url);
        $this->assertObjectHasAttribute('short_url', $data);
        $this->assertNotEmpty($data->short_url);
        $this->assertStringContainsString($record->code, $data->short_url);

    }//end assertLinkResource()


}//end class
