<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * 关键字查询
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request){
        $keyword='%'.$request['keyword'].'%';
//        $resources = Resource::where('fileName','like',$keyword)->paginate(999999);
        $resources = Resource::where('fileName','like',$keyword)->paginate(3);

        return view('resources.index',['resources'=>$resources,'keyword'=>$keyword]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resource::paginate(5);

        return view('resources.index',['resources'=>$resources,'keyword'=>'']);
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);
        if (auth()->user()->hasAnyRole('超级管理员')) {
            Storage::disk('local')->delete($resource->fileUrl);
            $resource->delete();
            Paper::where('fileName','=',$resource->fileUrl)->delete();
            return redirect()->route('resources.index')
                ->with('flash_message',
                    '成功删除！');
        } else {
            return redirect()->route('resources.index')
                ->with('flash_message',
                    '您不是超级管理员，无法删除此项！');
        }
    }
}
