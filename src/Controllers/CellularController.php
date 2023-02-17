<?php

namespace Cellular\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class CellularController extends BaseController
{
    use ResponseTrait;

    /**
     * The main entry point that handles the request and response
     * for a cellular components.
     *
     * This is not responsible for the intial rendering of the cell,
     * as that is rendered in the view.
     */
    public function index()
    {
        $cellular = service('cellular');

        // Parse the incoming snapshot and determine which cell we're working with.
        try {
            $snapshot = $cellular->snapshotFromRequest($this->request);
            $cell = $cellular->fromSnapshot($snapshot['snapshot']);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }

        $cellular->handleActions($snapshot, $cell);

        // Render the cell and return the HTML and snapshot.
        [$html, $snapshot] = $cellular->toSnapshot($cell);

        return $this->respond([
            'html' => $html,
            'snapshot' => $snapshot,
        ]);
    }
}
