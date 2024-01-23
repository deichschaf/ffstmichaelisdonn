<?php

namespace App\Http\Traits;

use App\Http\Models\Termine;
use Carbon\Carbon;

trait StartpageTrait
{
    public function getHydrantCheck(): array
    {
        $data = [];
        $list = Termine::where('is_hydrant_maintenance', '=', '1')->where('date_start', '>=', date('Y-m-d'))->get();
        $list->each(function ($t) use (&$data) {
            $data = ['date' => $t->date_start, 'time' => $t->time_start];
        });
        return $data;
    }

    /**
     * @todo Abfragen der Termine auf unseren Feuerwehrball
     * Wenn nicht.. Return [];
     * Anzeigen +2 Monate
     * Bis +1 Tag
     */
    public function getDanceBall(): array
    {
        $pagedata = $this->getPage(241); // Feuerwehrball iD
        $date = $this->getCalendarEntry('danceball');
        if ($date === []) {
            return [];
        }
        $date_time = explode('-', $date['date_start']);
        return $this->getContentArr($pagedata, $date, 'danceball', 'feuerwehrball_' . $date_time[0]);
    }

    /**
     * @param string $type
     * @return array
     */
    private function getCalendarEntry(string $type): array
    {
        $data = [];
        if ($type === 'danceball') {
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->addMonth(2);
        }
        if ($type === 'annualgeneralmeeting') {
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->addMonth(2);
        }
        if ($type === 'extraordinarygeneralmeeting') {
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->addMonth(2);
        }
        if ($type === 'hydrant_maintenance') {
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->addMonth(2);
        }
        $Entry = Termine::where('is_' . $type, '=', '1')->where('active', '=', '1')->where('is_public', '=', '1')->whereBetween('date_start', [$currentDateTime->format('Y-m-d'), $newDateTime->format('Y-m-d')])->get();
        $Entry->each(function ($e) use (&$data) {
            $data['id'] = $e->id;
            $data['showuntil'] = $e->date_start;
            $data['date_start'] = $e->date_start;
            $data['date_end'] = $e->date_end;
            $data['time_start'] = $e->time_start;
            $data['time_end'] = $e->time_end;
            $data['place'] = $e->place;
            $data['place_id'] = $e->place_id;
            $data['title'] = $e->title;
            $data['description'] = $e->description;
            $data['organzier'] = $e->organzier;
            $data['costs'] = $e->costs;
            $data['registration'] = $e->registration;
            $data['route'] = $e->route;
            $data['wearing'] = $e->wearing;
            $data['wear_id'] = $e->wear_id;
            $data['sign'] = $e->sign;
            $data['must_be'] = $e->must_be;
            $data['is_cancel'] = $e->is_cancel;
            $data['is_cancel_text'] = $e->is_cancel_text;
        });
        return $data;
    }

    /**
     * @param array $data
     * @param array $date
     * @param string $folder
     * @param string $filename
     * @return array
     */
    private function getContentArr(array $data, array $date, string $folder, string $filename): array
    {
        $title = $date['title'];
        $content = $date['description'];
        if ($data !== []) {
            $title = $data['title'];
            $content = $data['pagetext'];
        }
        $images = ['feuerwehrball_2024'];
        $img = 0;
        $filelink = null;
        $fileicon = null;
        $filesize = 0;
        $file = '/fileadmin/' . $folder . '/' . $filename . '.pdf';
        if (is_file(public_path($file))) {
            $filelink = $file;
            $fileicon =
            $filesize = $this->getFileSize(public_path($file));
        }

        $images = [];
        $image = $this->buildImageMedia($folder, $filename . '-large.jpg', 'jpg', '(min-width: 641px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-large.png', 'png', '(min-width: 641px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-large.webp', 'webp', '(min-width: 641px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-medium.jpg', 'jpg', '(min-width: 321px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-medium.png', 'png', '(min-width: 321px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-medium.webp', 'webp', '(min-width: 321px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-small.jpg', 'jpg', '(max-width: 320px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-small.png', 'png', '(max-width: 320px)');
        if ($image !== []) {
            $images[] = $image;
        }
        $image = $this->buildImageMedia($folder, $filename . '-small.webp', 'webp', '(max-width: 320px)');
        if ($image !== []) {
            $images[] = $image;
        }

        $data = [
            'datetime' => $date['date_start'] . ' ' . $date['time_start'],
            'showuntil' => $date['showuntil'],
            'text' => $title,
            'content' => $content,
            'href' => $file,
            'icon' => 'file-pdf',
            'size' => $filesize,
            'target' => '_blank',
            'linktext' => 'Flyer',
            'img' => $filename . '-small.jpg',
            'images' => $images,
        ];
        return $data;
    }

    /**
     * @param string $folder
     * @param string $filename
     * @param string $type
     * @param string $media
     * @return array
     */
    private function buildImageMedia(string $folder, string $filename, string $type, string $media): array
    {
        $file = '/fileadmin/' . $folder . '/' . $filename;
        if (is_file(public_path($file))) {
            return [
                'image' => $filename,
                'type' => $type,
                'media' => $media,
            ];
        }
        return [];
    }

    /**
     * @todo Abfragen der Termine auf unsere JAhreshauptversammlung bzw. Außerordentliche Mitgliederversammlung
     * Wenn nicht.. Return [];
     * Anzeigen +2 Monate
     * Bis +0 Tag
     */

    public function getGeneralMeeting(): array
    {
        $annualGeneralMeeting = $this->getAnnualGeneralMeeting();
        $extraOrdinaryGeneralMeeting = $this->getExtraOrdinaryGeneralMeeting();
        if ($extraOrdinaryGeneralMeeting !== []) {
            return $extraOrdinaryGeneralMeeting;
        }
        if ($annualGeneralMeeting !== []) {
            return $annualGeneralMeeting;
        }
        return [];
    }

    /**
     * @todo Abfragen der Termine auf unsere JAhreshauptversammlung bzw. Außerordentliche Mitgliederversammlung
     * Wenn nicht.. Return [];
     * Anzeigen +2 Monate
     * Bis +0 Tag
     */

    private function getAnnualGeneralMeeting(): array
    {
        $pagedata = $this->getPage(0); // iD
        $date = $this->getCalendarEntry('annualgeneralmeeting');
        if ($date === []) {
            return [];
        }
        $date_time = explode('-', $date['date_start']);
        return $this->getContentArr($pagedata, $date, 'generalmeeting', 'jahreshauptversammlung_' . $date_time[0]);
    }

    /**
     * @todo Abfragen der Termine auf unsere JAhreshauptversammlung bzw. Außerordentliche Mitgliederversammlung
     * Wenn nicht.. Return [];
     * Anzeigen +2 Monate
     * Bis +0 Tag
     */

    private function getExtraOrdinaryGeneralMeeting(): array
    {
        $pagedata = $this->getPage(0); // iD
        $date = $this->getCalendarEntry('extraordinarygeneralmeeting');
        if ($date === []) {
            return [];
        }
        $date_time = explode('-', $date['date_start']);
        return $this->getContentArr($pagedata, $date, 'generalmeeting', 'mitgliederversammlung_' . $date_time[0]);
    }

    public function getStartStatistic(): array
    {
        $data = ['fire_department_statistic' => $this->getFireDepartmentStatistic(),];
        return $data;
    }
}
