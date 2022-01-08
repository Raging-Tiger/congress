<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Material;
use App\Models\Event;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     */
    public function __construct() {
       
        $this->middleware('commercial')->only(['index', 'upload']);
    }
    
    /**
     * Display a listing of all own materials list.
     *
     * @return corresponing view.
     */
    public function index()
    {
        $registration = Bill::where('user_id', '=', auth()->user()->id)
                ->where('total_cost_per_materials', '!=', NULL)
                ->orderBy('id', 'desc')->get();
 
        return view('materials/materials_list', ['materials' => $registration]);
    }
    
    /**
     * Upload material by commercial participant.
     *
     * @param  $request from the form.
     * @return action MaterialController@index.
     */
    public function upload(Request $request)
    {
        $rules = array(
            'material' => 'required|image',
        );        
        $this->validate($request, $rules); 
      
        $material = Material::where('event_id', $request->event_id)
                              ->where('user_id', '=', auth()->user()->id)
                              ->first();
        
        
        /* Creates path for material storage */
        $file = $request->file('material');
        $event_name = Event::where('id', $request->event_id)->first('name');
        $folder_name = str_replace(' ', '_', strtolower($event_name->name));
       
        $materials_path = '/public/materials/'.$folder_name.'/';
        $uniqe_id = uniqid();
        $file_name = $uniqe_id.'.'.\File::extension($file->getClientOriginalName());
        
        /* If material was already uploaded - deletes existing version */
        if($material != NULL)
        {
            /* If material is stoted - deletes curren version */
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
        
        /* Else creates ne DB entry */
        else 
        { 
            Material::create([			
                'reference' => $file_name,
                'user_id' => auth()->user()->id,
                'event_id' => $request->event_id,
            ]);
        }
        
        /* Stores submitted material */
        $file->storeAs($materials_path, $file_name);
 
     return redirect()->action('App\Http\Controllers\MaterialController@index');       
    }

    /**
     * Displays all materials for selected event. Exact files are rendered in the view itself.
     *
     * @param  int  $id - corresponds to the database event ID.
     * @return corresponding view.
     */
    public function show($id)
    {
        /* All materials for selected event */
        $materials = Material::where('event_id', $id)->get();
        
        /* If no materials found - abort */
        if($materials->isEmpty())
        {
            abort(404);
        }
        
        return view('materials/materials_event', ['materials' => $materials]);
    }
    
    /**
     * Helper function. Generates path for folder associated with selected event.
     *
     * @param  string  $event_name - corresponds to the event name in the DB.
     * @return string $path.
     */
    public static function path($event_name)
    {
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        return '/materials/'.$folder_name.'/';
    }
}
