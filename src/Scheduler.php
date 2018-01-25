<?php

namespace MatviiB\Scheduler;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    /**
     * Define database table for service
     *
     * @var $table
     */
    protected $table;

    /**
     * The attributes that can be changed by user.
     *
     * @var array
     */
    protected $fillable = ['command', 'is_active',  'expression',
        'description', 'last_execution', 'without_overlapping'];

    /**
     * Scheduler constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->table = config('scheduler.table');
    }
}