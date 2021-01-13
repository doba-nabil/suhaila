<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $countries = Country::all();
            return view('backend.countries.index', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('backend.countries.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        try {
            $country = new Country();
            $country->name_ar = $request->name_ar;
            $country->name_en = $request->name_en;
            $country->code = $request->code;
            if ($request->active) {
                $country->active = 1;
            } else {
                $country->active = 0;
            }
            $country->save();
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/countries', $country->id , Country::class, 'main');
            }
            return redirect()->route('countries.index')->with('done', 'Added Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
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
        $country = Country::find($id);
        if (isset($country)) {
            return view('backend.countries.edit', compact('country'));
        } else {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        try {
            $country = Country::find($id);
            $country->name_ar = $request->name_ar;
            $country->name_en = $request->name_en;
            $country->code = $request->code;
            if ($request->active) {
                $country->active = 1;
            } else {
                $country->active = 0;
            }
            $country->save();
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/countries', $country->id , Country::class, 'main');
            }
            return redirect()->route('countries.index')->with('done', 'Added Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
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
        try {
            $country = Country::find($id);
            $this->deleteimages($country->id , 'pictures/countries/' , Country::class);
            $country->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    public function delete_countries()
    {
        try {
            $countries = Country::all();
            if (count($countries) > 0) {
                foreach ($countries as $country) {
                    $this->deleteimages($country->id , 'pictures/countries/' , Country::class);
                    $country->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Record TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
}
