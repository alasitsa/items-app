<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Repositories\iface\IItemRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ItemController extends Controller
{
    private IItemRepository $itemRepository;
    private const COUNT = 5;

    public function __construct(IItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page');
        if (!$page) {
            $page = 1;
        }
        $key = "items_page_{$page}";
        $items = Cache::get($key);
        if (!$items) {
            $offset = ($page - 1) * self::COUNT;
            $items = $this->itemRepository->getWithPagination($offset, self::COUNT);
            Cache::forever($key, $items);
            return response()->json([
                'items' => $items,
                'message' => 'from DB',
            ]);
        }
        return response()->json([
            'items' => $items,
            'message' => 'from cache',
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $item = new Item();
            $params = $request->all();
            $item->name = $params['name'];
            $item->url = $params['url'];
            $this->itemRepository->add($item);
            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $item = $this->itemRepository->get($id);
        if ($item) {
            return response()->json($item);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $item = $this->itemRepository->get($id);
            if (!$item) {
                return response()->json(['message' => 'Not found'], 404);
            }
            $params = $request->all();
            if (isset($params['name'])) {
                $item->name = $params['name'];
            }
            if (isset($params['url'])) {
                $item->url = $params['url'];
            }
            $this->itemRepository->edit($item);
            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $item = $this->itemRepository->get($id);
            if (!$item) {
                return response()->json(['message' => 'Not found'], 404);
            }
            $this->itemRepository->delete($id);
            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
