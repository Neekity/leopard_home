<?php

namespace App\Http\Controllers;

use App\Models\Xiaobook;
use Illuminate\Http\Request;

class LabBookController extends Controller
{
    public function search(Request $request)
    {

        $keyword = '%' . $request['keyword'] . '%';

        $labbooks = Xiaobook::where('bookName', 'like', $keyword)->paginate(3);

        return view('labbooks.index', ['labbooks' => $labbooks, 'keyword' => $keyword]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $labbooks = Xiaobook::paginate(5);

        return view('labbooks.index', ['labbooks' => $labbooks, 'keyword' => '']);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('labbooks.create');
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
        $this->validate($request, [
                'bookName'      => 'required|max:40',
                'borrowerName'  => 'required|max:40',
                'borrowerEmail' => 'required|email',
            ]
        );

        $bookName               = $request['bookName'];
        $borrowerName           = $request['borrowerName'];
        $borrowerEmail          = $request['borrowerEmail'];
        $labbook                = new Xiaobook();
        $labbook->bookName      = $bookName;
        $labbook->borrowerName  = $borrowerName;
        $labbook->borrowerEmail = $borrowerEmail;

        $labbook->save();

        return redirect()->route('labbooks.index')
            ->with(' 新增成功!');
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
        $labbook=Xiaobook::findOrFail($id);
        return view('labbooks.edit')->with('labbook',$labbook);
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
        $labbook=Xiaobook::findOrFail($id);
        $this->validate($request,[
            'bookName'      => 'required|max:40',
            'borrowerName'  => 'required|max:40',
            'borrowerEmail' => 'required|email',
        ]);
        $input = $request->all();
        $labbook->fill($input)->save();
        return redirect()->route('labbooks.index')
            ->with('flash_message',
                $labbook->bookName . ' 更新成功');
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
        //
    }
}
