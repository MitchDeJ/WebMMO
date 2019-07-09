<?php

namespace App;

use App\Http\Controllers\ObjectController;
use Illuminate\Database\Eloquent\Model;

class AreaObject extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function getIconPath() {
        $skill = Skill::find(1);
        $action = ObjectController::getSkillAction(1, $this->id);
        if (count($action) > 1)
            $action = $action[0];
        if (ObjectController::hasSkillAction($this->id))
            return url($skill->getIconPath($action->skill_id));

        if (ObjectController::opensMarket($this->id))
            return url('/img/icons/Trade.png');

        if (ObjectController::opensBank($this->id))
            return url('/img/icons/chest.png');
    }
}
