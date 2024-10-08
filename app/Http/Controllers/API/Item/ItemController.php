<?php

namespace App\Http\Controllers\API\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Models\Checklist;
use App\Models\Item;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(string $checklistId)
    {

        $checklist = Checklist::find($checklistId);

        if (!$checklist) {
            return $this->error(
                '',
                'Not found',
                404
            );
        }

        $items = $checklist->items;

        if ($items->isNotEmpty()) {
            return $this->success($items);
        } else {
            return $this->error(
                '',
                'Not found',
                404
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request, string $checklistId)
    {
        $validated = $request->validated();
        $checklist = Checklist::find($checklistId);

        if (!$checklist) {
            return $this->error(
                '',
                'Not found',
                404
            );
        }

        $item = $checklist->items()->create(["name" => $validated['itemName']]);

        return $this->success($item);
    }

    public function show($checklistId, $itemId)
    {
        $checklist = Checklist::find($checklistId);

        if (!$checklist) {
            return $this->error(
                '',
                'Not found',
                404
            );
        }

        // Temukan item dalam checklist
        $item = $checklist->items()->find($itemId);

        if (!$item) {
            return $this->error(
                '',
                'Not found',
                404
            );
        }

        return $this->success($item);
    }

    public function update($checklistId, $itemId)
    {

        $item = Item::where("checklist_id", $checklistId)->find($itemId);

        if (!$item) {
            return $this->error('', 'Item not found', 404);
        }

        $newStatus = $item->completed ? 0 : 1;

        $item->update(['completed' => $newStatus]);


        return $this->success($item);
    }

    public function destroy($checklistId, $itemId)
    {
        $item = Item::where("checklist_id", $checklistId)->find($itemId);

        if (!$item) {
            return $this->error(
                '',
                'Not found',
                404
            );
        }

        $item->delete();

        return $this->success(["message" => "Item deleted successfully"]);
    }

    public function rename(Request $request, $checklistId, $itemId)
    {
        $validated = $request->validate([
            "itemName" => "required|string|max:255",
        ]);

        $item = Item::where("checklist_id", $checklistId)->find($itemId);

        if (!$item) {
            return $this->error(
                '',
                'Not found',
                404
            );
        }

        $item->update(["name" => $validated["itemName"]]);

        return $this->success($item);
    }
}
