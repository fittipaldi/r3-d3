<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SpacecraftArmament;
use App\Models\Spacecraft;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpacecraftController extends BaseController
{

    private $pageQtd = 5;

    /**
     * @param Request $request
     * @return Response
     */
    public function getSpacecrafts(Request $request)
    {
        try {
            $rows = Spacecraft::paginate($this->pageQtd);

            $items = [];
            foreach ($rows as $row) {
                $item = new \stdClass();
                $item->id = $row->id;
                $item->name = $row->name;
                $item->status = $row->status;
                $items[] = $item;
            }

            return response()->json([
                'status' => true,
                'items_per_page' => $this->pageQtd,
                'next_page_link' => $rows->nextPageUrl(),
                'max_page' => get_max_page_number($rows->total(), $rows->perPage()),
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return Response
     */
    public function getSpacecraftById(int $id)
    {
        try {
            $row = Spacecraft::find($id);
            if (!$row) {
                $httpStatusException = 404;
                throw new \Exception('Spacecraft not found');
            }

            $item = new \stdClass();
            $item->id = $row->id;
            $item->name = $row->name;
            $item->class = $row->class;
            $item->crew = $row->crew;
            $item->image = $row->image;
            $item->value = $row->value;
            $item->status = $row->status;
            $item->note = $row->note;
            $item->armament = [];
            if ($row->armaments) {
                foreach ($row->armaments as $arm) {
                    $aItem = new \stdClass();
                    $aItem->title = $arm->title;
                    $aItem->qtd = $arm->qtd;
                    $item->armament[] = $aItem;
                }
            }

            return response()->json([
                'status' => true,
                'data' => $item,
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], $httpStatusException);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function setSpacecraft(Request $request)
    {
        $httpStatusException = 500;
        try {

            if (!Spacecraft::ValidateRequestData($request)) {
                throw new \Exception('Request data invalid.');
            }

            $item = new Spacecraft();
            $item->name = $request->input('name');
            $item->class = $request->input('class');
            $item->crew = $request->input('crew');
            $item->image = $request->input('image');
            $item->value = $request->input('value');
            $item->status = $request->input('status');
            $note = $request->input('note');
            if ($note) {
                $item->note = $note;
            }

            if ($item->save()) {
                $armament = $request->input('armament', []);
                foreach ($armament as $arm) {
                    $spacecraftArmament = new SpacecraftArmament();
                    $spacecraftArmament->title = $arm['title'];
                    $spacecraftArmament->qtd = $arm['qtd'];
                    $spacecraftArmament->spacecraft_id = $item->id;
                    if (!$spacecraftArmament->save()) {
                        $item->delete();
                        throw new \Exception('There was an error to save.');
                    }
                }

                return response()->json([
                    'id' => $item->id,
                    'status' => true,
                    'message' => 'Saved successfully.'
                ], 200);
            } else {
                throw new \Exception('There was an error to save.');
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], $httpStatusException);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editSpacecraft(Request $request, int $id)
    {
        $httpStatusException = 500;
        try {

            if (!Spacecraft::ValidateRequestData($request)) {
                throw new \Exception('Request data invalid.');
            }

            $item = Spacecraft::find($id);
            if (!$item) {
                $httpStatusException = 404;
                throw new \Exception('Spacecraft not found');
            }

            $name = $request->input('name');
            if ($name) {
                $item->name = $name;
            }
            $class = $request->input('class');
            if ($class) {
                $item->class = $class;
            }
            $crew = $request->input('crew');
            if ($crew) {
                $item->crew = $crew;
            }
            $image = $request->input('image');
            if ($image) {
                $item->image = $image;
            }
            $value = $request->input('value');
            if ($value) {
                $item->value = $value;
            }
            $status = $request->input('status');
            if ($status) {
                $item->status = $status;
            }
            $note = $request->input('note');
            if ($note) {
                $item->note = $note;
            }

            if ($item->save()) {
                $armament = $request->input('armament', []);
                if (!SpacecraftArmament::where('spacecraft_id', '=', $item->id)->delete()) {
                    throw new \Exception('There was an error to save.');
                }
                foreach ($armament as $arm) {
                    $spacecraftArmament = new SpacecraftArmament();
                    $spacecraftArmament->title = $arm['title'];
                    $spacecraftArmament->qtd = $arm['qtd'];
                    $spacecraftArmament->spacecraft_id = $item->id;
                    if (!$spacecraftArmament->save()) {
                        throw new \Exception('There was an error to save.');
                    }
                }

                return response()->json([
                    'uid' => $item->id,
                    'status' => true,
                    'message' => 'Updated successfully . '
                ], 200);
            } else {
                throw new \Exception('There was an error to update.');
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], $httpStatusException);
        }

    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteSpacecraft(int $id)
    {
        $httpStatusException = 500;
        try {
            $item = Spacecraft::find($id);
            if (!$item) {
                $httpStatusException = 404;
                throw new \Exception('Spacecraft not found');
            }

            if (!SpacecraftArmament::where('spacecraft_id', '=', $item->id)->delete()) {
                throw new \Exception('There was an error to save.');
            }

            if ($item->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Deleted successfully.'
                ], 200);
            } else {
                throw new \Exception('There was an error to delete.');
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], $httpStatusException);
        }
    }

}