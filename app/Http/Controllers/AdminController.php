<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\AdminRequest;
use Auth;
use Config;
use Illuminate\Http\Request;
use Image;
use Storage;

class AdminController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct() {
		// $this->middleware(function ($request, $next) {
		// 	$id = Auth::user()->id;
		// 	if ($id == 1) {
		// 		return $next($request);
		// 	} else {
		// 		return response()->make(view('adminManagement.error'), 404);
		// 	}

		// });
	}
	public function index(Request $request) {

		$itemPerPage = Config::get('constants.paginator.itemPerPage');
		$admin = Config::get('constants.roles.Admin');
		$email = $request->get('searchEmail');
		$name = $request->get('searchName');
		$status = $request->get('searchStatus');
		$created_at = $request->get('searchCreated_at');

		$admins = User::orderBy('id', 'DESC')->where(function ($query) use ($email, $name, $status, $created_at) {
			if ($email != NULL) {
				$query->where('email', 'LIKE', '%' . $email . '%');
			}
			if ($name != NULL) {
				$query->where('name', 'LIKE', '%' . $name . '%');
			}
			if ($status != NULL) {
				$query->where('status', $status);
			}
			if ($created_at != NULL) {
				$query->where('created_at', '>=', date($created_at . ' 00:00:00'))->where('created_at', '<=', date($created_at . ' 23:59:59'));
			}
			$query->where('id', '!=', '1');
		})->paginate($itemPerPage);

		return view('adminManagement.index', compact('admins', 'email', 'name', 'status', 'created_at'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('adminManagement.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AdminRequest $request) {
		$dataNew = $request->except('profile_image');
		
		$dataNew['password'] = bcrypt($dataNew['password']);
		if ($admin = User::Create($dataNew)) {
			$request->session()->flash('status', __('message.add_account'));
			return redirect('/admin/admins/');

		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$admin = User::findOrFail($id);
		return view('adminManagement.show', compact('admin'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$admin = User::findOrFail($id);
		return view('adminManagement.edit', compact('admin'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(AdminRequest $request, $id) {
		$upLoadPath = Config::get('constants.uploadDirectory.User');
		$upLoadPathResize = Config::get('constants.uploadDirectory.userResize');
		$thumbNail = Config::get('constants.uploadDirectory.thumbNail');
		$widthThumbNail = Config::get('constants.uploadDirectory.widthThumbNail');
		$widthProfile = Config::get('constants.uploadDirectory.widthProfile');
		$request->validated();
		$dataNew = $request->except('profile_image', '_method', '_token');
		$newImage = request()->profile_image;

		// handle file upload
		if ($newImage) {
			//get file name with extension
			$fileNameWithExt = $newImage->getClientOriginalName();
			$fileNameToStore = time() . $fileNameWithExt;
			$newImage->storeAs($upLoadPath, $fileNameToStore);
			$thumbNailPath = public_path($upLoadPathResize . '/' . $fileNameToStore);
			$image = Image::make($thumbNailPath)->resize($widthProfile, NULL, function ($constraint) {$constraint->aspectRatio();})->encode('jpg');
			$store = Storage::put($upLoadPath . '/' . $fileNameToStore, $image->__toString());
			$imageThumbNail = Image::make($thumbNailPath)->resize($widthThumbNail, NULL, function ($constraint) {$constraint->aspectRatio();})->encode('jpg');
			$storeThumbNail = Storage::put($thumbNail . '/' . $fileNameToStore, $imageThumbNail->__toString());
		}
		$admin = User::findOrFail($id);
		if ($newImage) {
			Storage::delete($upLoadPath . '/' . $admin->profile_image);
			Storage::delete($thumbNail . '/' . $admin->profile_image);
			$dataNew['profile_image'] = $fileNameToStore;
		}

		User::updateOrCreate(['id' => $id], $dataNew);
		$request->session()->flash('status', __('message.update_account'));
		return redirect('/admin/admins');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$upLoadPath = Config::get('constants.uploadDirectory.User');
		$thumbNail = Config::get('constants.uploadDirectory.thumbNail');
		$admin = User::findOrFail($id);
		if ($admin->profile_image != 'noimage.jpg') {
			Storage::delete($upLoadPath . '/' . $admin->profile_image);
			Storage::delete($thumbNail . '/' . $admin->profile_image);
		}
		$admin->delete();
		return redirect('/admin/admins')->with('status', __('message.delete_account'));
	}

}
