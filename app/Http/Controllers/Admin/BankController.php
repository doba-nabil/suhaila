<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:bank-list|bank-create|bank-edit|bank-delete', ['only' => ['index','show']]);
//        $this->middleware('permission:bank-create', ['only' => ['create','store']]);
//        $this->middleware('permission:bank-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:bank-delete', ['only' => ['destroy' , 'delete_banks']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $banks = Bank::orderBy('id' , 'desc')->get();
            return view('backend.banks.index' , compact('banks'));
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('backend.banks.create');
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            Bank::create($request->all());
            return redirect()->route('banks.index')->with('done' , 'Added Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }
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
        $bank = Bank::find($id);
        if(isset($bank)){
            return view('backend.banks.edit' , compact('bank'));
        }else{
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }

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
        try{
            $bank = Bank::find($id);
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $bank->update($request->all());
            return redirect()->route('banks.index')->with('done' , 'Edited Successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $bank = Bank::find($id);
            $bank->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }

    }

    public function delete_banks()
    {
        try{
            $banks = Bank::all();
            if(count($banks) > 0){
                foreach ($banks as $bank){
                    $bank->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            }else{
                return response()->json([
                    'error' => 'NO THING TO DELETE'
                ]);
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Error Try Again!!');
        }
    }
}
