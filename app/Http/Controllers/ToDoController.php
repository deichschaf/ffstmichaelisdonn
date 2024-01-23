<?php

namespace App\Http\Controllers;

use App\Http\Models\Agent;
use App\Http\Models\ToDo;
use App\Http\Models\ToDoArea;
use App\Http\Models\ToDoStatus;
use App\Http\Models\ToDoType;
use App\Http\Traits\FxToolsTrait;
use App\Http\Traits\LoggerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToDoController extends GroundController
{
    public function todoOverviewApi(): JsonResponse
    {
        $data = [];
        $data['todos'] = $this->getTodos(0);
        $data['todo_area'] = $this->getTodoAreas();
        $data['todo_status'] = $this->getTodoStatus();
        $data['todo_type'] = $this->getTodoTypes();
        $data['form_add_url'] = $this->getAdminPath().'/todo/add';
        $data['form_edit_url'] = $this->getAdminPath().'/todo/edit';
        $data['form_save_url'] = '/api'.$this->getAdminPath().'/todo/save/';
        return response()->json($data, 200);
    }

    public function getToDoSelects(): JsonResponse
    {
        $data = [];
        $data['todo_area'] = $this->getTodoAreas();
        $data['todo_status'] = $this->getTodoStatus();
        $data['todo_type'] = $this->getTodoTypes();
        return response()->json($data, 200);
    }

    public function getToDo($id, Request $request): JsonResponse
    {
        $todo = [];
        $TODOS = ToDo::where('id', '=', $id)
            ->get();
        $TODOS->each(function ($t) use (&$todo) {
            $subtodos = $this->getTodos($t->id);
            $todo = [
                'id' => $t->id,
                'area_id' => $t->todo_area_id,
                'title' => $t->todotitle,
                'description' => $t->tododescription,
                'status_id' => $t->status_id,
                'type_id' => $t->type_id,
                'update' => FxToolsTrait::makeDatumDeStatic($t->updated_at),
                'subtodos' => $subtodos,
            ];
        });
        return response()->json($todo, 200);
    }

    public function setToDo(Request $request): JsonResponse
    {
        try {
            $inputs = $request->all();

            if (0 != $inputs['id']) {
                /**
                 * @todo add try catch if row not exists!
                 */
                $save = ToDo::find($inputs['id']);
                $save->todotitle = $this->checktext($inputs['title']);
                $save->tododescription = $this->checktext($inputs['description']);
                $save->todo_area_id = $this->checktext($inputs['area_id']);
                // $save->parent_id = $this->checktext($inputs['parent_id']);
                $save->status_id = $this->checktext($inputs['status_id']);
                $save->type_id = $this->checktext($inputs['type_id']);
                $save->save();
            } else {
                $save = new ToDo();
                $save->todotitle = $this->checktext($inputs['title']);
                $save->tododescription = $this->checktext($inputs['description']);
                $save->todo_area_id = $this->checktext($inputs['area_id']);
                // $save->parent_id = $this->checktext($inputs['parent_id']);
                $save->status_id = $this->checktext($inputs['status_id']);
                $save->type_id = $this->checktext($inputs['type_id']);
                $save->save();
                $id = $save->id;
            }
            $this->cleanPageData();
            $data = [];
            $data['success'] = true;
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            $data= [];
            $data['success'] = false;
            $data['errors'] = [
                'code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ];
            return response()->json($data, 500);
        };
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function getToDoArea($id, Request $request): JsonResponse
    {
        $todo = [];
        $ToDoArea = ToDoArea::where('id', '=', $id)
            ->get();
        $ToDoArea->each(function ($t) use (&$todo) {
            $todo = [
                'id' => $t->id,
                'area' => $t->todoarea,
                'parent_id' => $t->parent_id,
            ];
        });
        return response()->json($todo, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setToDoArea(Request $request): JsonResponse
    {
        try {
            $id = $request->get('id');
            $data = [];
            $data['success'] = true;
            $data['errors'] = [];
            $data['errorMessage'] = [];
            $data['errorCode'] = '';

            if (is_numeric($id) && $id > 0) {
                $save = ToDoArea::find($id);
            } else {
                $save = new ToDoArea;
            }
            $save->todoarea = $this->checkText($request->area);
            $save->parent_id = $this->checkText($request->parent_id);
            $save->save();
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
        }
    }

    /**
     * @return JsonResponse
     */
    public function todoAreaOverviewApi(): JsonResponse
    {
        $data = [];
        $data['areas'] = $this->getTodoAreas();
        $data['form_add_url'] = $this->getAdminPath().'/todo/area/add';
        $data['form_edit_url'] = $this->getAdminPath().'/todo/area/edit';
        $data['form_save_url'] = '/api'.$this->getAdminPath().'/todo/area/save/';
        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function todoAreaParentAreas(): JsonResponse
    {
        $data = $this->getTodoAreasParent(0, '');
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function adminStore(Request $request): JsonResponse
    {
        return $this->setToDoStore($request);
    }

    /**
     * @param int $parent_id
     * @return array
     */
    private function getTodos($parent_id = 0): array
    {
        $todos = [];
        $TODOS = ToDo::where('parent_id', '=', $parent_id)
            ->orderBy('created_at', 'ASC')
            ->get();
        $TODOS->each(function ($t) use (&$todos) {
            $subtodos = $this->getTodos($t->id);
            $todos[] = [
                'id' => $t->id,
                'area_id' => $t->todo_area_id,
                'title' => $t->todotitle,
                'description' => $t->tododescription,
                'status_id' => $t->status_id,
                'type_id' => $t->type_id,
                'update' => FxToolsTrait::makeDatumDeStatic($t->updated_at),
                'subtodos' => $subtodos,
            ];
        });
        return $todos;
    }

    /**
     * @param int $parent_id
     * @param string $name
     * @return array
     */
    private function getTodoAreas(int $parent_id=0, string $name=''): array
    {
        $areas = [];
        if ($name !== '') {
            $name=$name.' > ';
        }
        if ($parent_id === 0) {
            $areas[] = [
                'id' => 0,
                'name' => '----',
                'parent_id' => 0,
                'value' => 0,
                'label' => '----',
            ];
        }
        $AREAS = ToDoArea::where('parent_id', '=', $parent_id)->orderBy('todoarea', 'ASC')->get();
        $AREAS->each(function ($a) use (&$areas, $name) {
            $areas[] = [
                'id' => $a->id,
                'name' => $name.$a->todoarea,
                'parent_id' => $a->parent_id,
                'value' => $a->id,
                'label' => $name.$a->todoarea,
            ];
            $subareas = $this->getTodoAreas($a->id, $name.$a->todoarea);
            if (count($subareas)>0) {
                $areas = array_merge($areas, $subareas);
            }
        });
        return $areas;
    }

    /**
     * @param int $parent_id
     * @param string $name
     * @return array
     */
    private function getTodoAreasParent(int $parent_id = 0, string $name=''): array
    {
        if ($name !== '') {
            $name=$name.' > ';
        }
        $areas = [];
        if ($parent_id === 0) {
            $areas[] = [
                'id' => 0,
                'name' => '----',
                'parent_id' => 0,
                'value' => 0,
                'label' => '----',
            ];
        }
        $Areas = ToDoArea::where('parent_id', '=', $parent_id)->orderBy('todoarea', 'ASC')->get();
        $Areas->each(function ($a) use (&$areas, $name) {
            $areas[] = [
                'id' => $a->id,
                'name' => $name.$a->todoarea,
                'parent_id' => $a->parent_id,
                'value' => $a->id,
                'label' => $name.$a->todoarea,
            ];
            $subareas = $this->getTodoAreasParent($a->id, $name.$a->todoarea);
            if (count($subareas)>0) {
                $areas = array_merge($areas, $subareas);
            }
        });
        return $areas;
    }

    private function getTodoStatus(): array
    {
        $status = [];
        $STATUS = ToDoStatus::orderBy('pos', 'ASC')->get();
        $STATUS->each(function ($s) use (&$status) {
            $status[] = [
                'id'=>$s->id,
                'status' => $s->status,
                'readable' => $s->status_readable,
                'label' => $s->status_readable,
                'value' => $s->id,
            ];
        });
        return $status;
    }

    private function getTodoTypes(): array
    {
        $types = [];
        $TYPES = ToDoType::orderBy('id', 'ASC')->get();
        $TYPES->each(function ($t) use (&$types) {
            $types[] = [
                'id' => $t->id,
                'type' => $t->todo_type,
                'readable' => $t->todo_type_readable,
                'fa' => $t->fa_type,
                'icon' => $t->icon,
                'color' => $t->type_color,
                'label' => $t->todo_type_readable,
                'value' => $t->id,
            ];
        });
        return $types;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $inputs = $request->all();

        if (0 != $inputs['id']) {
            $save = ToDo::find($inputs['id']);
            $save->todotitle = $this->checktext($inputs['todotitle']);
            $save->tododescription = $this->checktext($inputs['tododescription']);
            $save->todo_area_id = $this->checktext($inputs['todo_area_id']);
            $save->parent_id = $this->checktext($inputs['parent_id']);
            $save->status_id = $this->checktext($inputs['status']);
            $save->type_id = $this->checktext($inputs['type']);
            $save->save();
        } else {
            $save = new ToDo();
            $save->todotitle = $this->checktext($inputs['todotitle']);
            $save->tododescription = $this->checktext($inputs['tododescription']);
            $save->todo_area_id = $this->checktext($inputs['todo_area_id']);
            $save->parent_id = $this->checktext($inputs['parent_id']);
            $save->status_id = $this->checktext($inputs['status_id']);
            $save->type_id = $this->checktext($inputs['type']);
            $save->save();
            $id = $save->id;
        }
        $this->clearPageCache();

        return redirect()->route('admin.todo');
    }

    /**
     * @param Request $request
     */
    public function setStatus(Request $request)
    {
    }
}
