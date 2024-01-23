<?php

namespace App\Http\Traits;

use App\Http\Models\Changelog;
use App\Http\Models\ChangelogDetails;
use Illuminate\Support\Facades\Request;

trait ChangeLogTrait
{
    public function getListChangeLog(): array
    {
        $data = [];
        $ChangeLog = Changelog::orderBy('datum', 'DESC')->orderBy('id', 'DESC')->get();
        $ChangeLog->each(function ($cl) use (&$data) {
            $data[] = [
                'id' => $cl->id,
                'release' => $cl->release,
                'title' => $cl->release,
                'datum' => $this->getDatumDe($cl->datum),
                'date' => $this->getDatumDe($cl->datum),
                'tasks' => $this->getLastChangeLogDetails($cl->id),
                'description' => $this->getLastChangeLogDetails($cl->id),
            ];
        });
        return $data;
    }

    private function getLastChangeLogDetails(int $id): array
    {
        $content = [];
        $Details = ChangelogDetails::where('changelog_id', '=', $id)->orderBy('pos', 'ASC')->get();
        $Details->each(function ($d) use (&$content) {
            $content[] = $d->tasks;
        });

        return $content;
    }

    public function getLastChangeLogDetailsEdit(int $id): array
    {
        $tasks = [];
        $Details = ChangelogDetails::where('changelog_id', '=', $id)->orderBy('pos', 'ASC')->get();
        $Details->each(function ($d) use (&$tasks) {
            $tasks[] = [
                'id'=>$d->id,
                'task'=>$d->tasks,
                'value'=>$d->tasks,
            ];
        });

        return $tasks;
    }

    public function getLastChangeLog(int $count = 3): array
    {
        $data = [];
        $ChangeLog = Changelog::orderBy('datum', 'DESC')->orderBy('id', 'DESC')->take($count)->get();
        $ChangeLog->each(function ($cl) use (&$data) {
            $data[] = [
                'release' => $cl->release,
                'datum' => $this->getDatumDe($cl->datum),
                'tasks' => implode(', ', $this->getLastChangeLogDetails($cl->id)),
                'headline' => $cl->release,
                'description' => implode(', ', $this->getLastChangeLogDetails($cl->id)),
                'type' => 'info',
                'date' => $this->getDatumDe($cl->datum)
            ];
        });
        return $data;
    }

    /**
     * @param Request $request
     * @return bool[]
     */
    public function saveChangeLog(Request $request): array
    {
        try {
            $inputs = $request->all();
            $save = new Changelog();
            $save->release = $inputs['release'];
            $save->datum = date('Y-m-d');
            $save->save();
            $id = $save->id;

            foreach ($inputs['tasks'] as $k => $value) {
                if ('' != trim($value)) {
                    $save_task = new ChangelogDetails();
                    $save_task->task = trim($value);
                    $save_task->changelog_id = $id;
                    $save_task->save();
                }
            }
            return ['success' => true];
        } catch (\Exception $e) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $e->getCode(),
                $e->getMessage(),
                0
            );
        }
    }
}
