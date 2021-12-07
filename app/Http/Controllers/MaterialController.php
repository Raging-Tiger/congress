<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Material;
use App\Models\Event;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $registration = Bill::where('user_id', '=', auth()->user()->id)
                ->where('total_cost_per_materials', '!=', NULL)
                ->orderBy('id', 'desc')->get();
 
        return view('materials/materials_list', ['materials' => $registration]);
    }
    
    public function upload(Request $request)
    {
        $rules = array(
            'material' => 'required|image',
        );        
        $this->validate($request, $rules); 
      
        $file = $request->file('material');
        $event_name = Event::where('id', $request->event_id)->first('name');
        $folder_name = str_replace(' ', '_', strtolower($event_name->name));
       
        $material = Material::where('event_id', $request->event_id)
                              ->where('user_id', '=', auth()->user()->id)
                              ->first();
        $materials_path = '/public/materials/'.$folder_name.'/';
        $uniqe_id = uniqid();
        $file_name = $uniqe_id.'.'.\File::extension($file->getClientOriginalName());
        
        if($material != NULL)
        {
            if($material->reference != NULL)
            {
                if(\Storage::disk('local')->exists($materials_path.$material->reference))
                {
                    \Storage::delete($materials_path.$material->reference);
                }
            }

            $material->reference = $file_name;
            $material->save();
        }
        
        else 
        { 
            Material::create([			
                'reference' => $file_name,
                'user_id' => auth()->user()->id,
                'event_id' => $request->event_id,
            ]);
        }

        $file->storeAs($materials_path, $file_name);
 
     return redirect()->action('App\Http\Controllers\MaterialController@index');       
    }


    public function show($id)
    {
        $materials = Material::where('event_id', $id)->get();
        //dd($materials);
        if($materials->isEmpty())
        {
            abort(404);
        }
        
        return view('materials/materials_event', ['materials' => $materials]);
    }
    
    public static function path($event_name)
    {
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        return '/materials/'.$folder_name.'/';

    }
}
