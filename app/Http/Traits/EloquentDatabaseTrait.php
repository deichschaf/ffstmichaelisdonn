<?php

namespace App\Http\Traits;

use App\Http\Enum\ActiveEnum;

trait EloquentDatabaseTrait
{
    /**
     * @param string|null $value
     * @return string|null
     */
    public function checkEmptyValueSetNull(string|null $value = ''): null|string
    {
        $value = trim($value);
        if ($value === '' || $value === null) {
            return null;
        }
        return $value;
    }

    /**
     * @param $content
     * @return string
     */
    public function fixTruncatedColumn($content = ''): string
    {
        return (string)$content;
    }

    /**
     * @param $boolean
     * @return ActiveEnum
     */
    public function setBoolean($boolean=true): ActiveEnum
    {
        if ($boolean === true || $boolean === 1) {
            return ActiveEnum::Active;
        }
        return ActiveEnum::Deactive;
    }

    public function setBooleanInt($boolean=true):int
    {
        if ($boolean === true || $boolean === 1) {
            return (int)ActiveEnum::Active;
        }
        return (int)ActiveEnum::Deactive;
    }

    /**
     * @param $boolean
     * @return bool
     */
    public function setBooleanText($boolean=1):bool
    {
        if ($boolean === true || $boolean === 1) {
            return true;
        }
        return false;
    }
}
