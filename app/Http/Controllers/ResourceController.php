<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Services\ResourceServices;
use App\Services\Tables\ResourcesTableContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, ResourcesTableContract $table)
    {
        $data = ResourceServices::list($request->all())->paginate(20);

        return $table->setData($data)->renderOn('resources.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);
        if (auth()->user()->hasAnyRole('超级管理员')) {
            Storage::disk('local')->delete($resource->fileUrl);
            $resource->delete();

            return $this->ajaxSuccess([], '删除成功！');
        } else {
            return $this->ajaxError([], '删除失败！');
        }
    }
}
