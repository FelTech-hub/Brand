<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Headquaters;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Rules\Uppercase;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    public function index()
    {

        //Query Bilder
        // $cars = DB::table('cars')->paginate(4);
        

        $cars = Car::paginate(3);
        return view('cars.index', [
            'cars' => $cars,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Methods we can use on request
        //guessExtension()
        //getMimetype()
        //store()
        //asStore()
        //storePublic()
        //move()
        //getClientOriginalName
        //getClientMimeType()
        //guessClientExtension()
        //getSize()
        //getError()
        //isValid()

        //Validate Field Input
        $request->validate([
            'name' => 'required|unique:cars',
            'founded' => 'required|integer|min:0|max:2020',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:5048'
        ]);


        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $newImageName);

        //If validate create
        $cars = Car::create([
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description'),
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id,
        ]);
       return redirect('/cars');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);

        $hq = Headquaters::find($id);
        // var_dump($car->products);
        $products = Product::find($id);
        return view('cars.show')->with('car', $car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);
        return view('cars.edit')->with('car', $car);
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
        $cars = Car::where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'founded' => $request->input('founded'),
                'description' => $request->input('description'),
        ]);
       return redirect('/cars');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect('/cars');
    }
}
