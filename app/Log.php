<?php

namespace App;

/*
 * Antvel - Log Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'logs';

    protected $fillable = ['action_type_id', 'details', 'source_id', 'user_id'];

    protected $appends = ['source_type', 'action_type'];

    protected $hidden = ['action', 'source'];

    public function action()
    {
        return $this->belongsTo(ActionType::class, 'action_type_id', 'id');
    }

    public function source()
    {
        return [];
    }

    public function getSourceTypeAttribute()
    {
        return $this->action->source_type;
    }

    public function getActionTypeAttribute()
    {
        return $this->action->action;
    }
}
