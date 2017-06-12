<?php

namespace App;

/*
 * Antvel - Comment Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\ActionType;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    protected $fillable = ['action_type_id', 'comment', 'source_id', 'user_id'];

    public function action()
    {
        return $this->belongsTo(ActionType::class, 'action_type_id', 'id');
    }

    public function source()
    {
        //here we validate the type and return the source reference
        switch ($this->action->source_type) {
            case 'order':
                $source = Order::class;
            break;
        }

        return $source ? $this->hasOne($source) : null;
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
