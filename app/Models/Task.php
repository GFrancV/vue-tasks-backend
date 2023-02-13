<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model {
	use HasFactory;

	protected $connection = 'mongodb';

	protected $fillable = [
		'id',
		'title',
		'description',
		'user_id',
	];

	/**
	 * Get the user that owns the Task
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class, 'id');
	}

}
