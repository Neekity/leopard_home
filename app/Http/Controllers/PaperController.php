<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $papers=Paper::paginate(3);

        return view('papers.index')->with('papers',$papers);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paper=Paper::findOrFail($id);
        return view('papers.edit')->with('paper',$paper);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paper=Paper::findOrFail($id);
        $this->validate($request,[
            'fileName'=>'required',
            'originName'=>'required',
            'FirstAuthor'=>'required|max:40',
            'communicationAuthor'=>'required|max:40'
        ]);
        $input = $request->all();
        $paper->fill($input)->save();
        return redirect()->route('papers.index')
            ->with('flash_message',
                'Permission' . $paper->name . ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paper=Paper::findOrFail($id);
        if (auth()->user()->hasAnyRole('超级管理员')){
            Storage::disk('local')->delete($paper->fileName);
            $paper->delete();
            Resource::where('fileUrl','=',$paper->fileName)
                ->delete();
            return redirect()->route('papers.index')
                ->with('flash_message',
                    '成功删除！');
        } else{
            return redirect()->route('papers.index')
                ->with('flash_message',
                    '您不是超级管理员，无法删除此项！');
        }

    }
}
