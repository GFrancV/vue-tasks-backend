<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$tasks = Auth::user()->tasks;

		return response()->json($tasks, 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$validated = $request->validate([
			'title' => 'required|max:50',
		]);

		$task              = new Task;
		$task->title       = $request->title;
		$task->description = $request->description;
		$task->completed   = false;
		$task->user_id     = Auth::id();
		$task->save();

		return response()->json($task, 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$task = Task::find($id);

		$validated = $request->validate([
			'title' => 'required|max:50',
		]);

		$task->title       = $request->title;
		$task->description = $request->description;
		$task->completed   = $request->completed;
		$task->save();

		return response()->json($task, 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$task = Task::find($id);

		$task->delete();

		return response()->json($task, 200);
	}
}
