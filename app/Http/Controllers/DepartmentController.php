<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\User;

use App\DepartmentAgent;

use App\Department;


class DepartmentController extends Controller
{
     public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {

		/*if (Auth::user()->admin && Auth::user()->company_id==0){
    	$users= User::all();
		$departments= Department::all();
		}else{*/
		$users= User::where('company_id', Auth::user()->company_id)->get();
		$departments= Department::where('company_id', Auth::user()->company_id)->get();
		
		//}
		$data = array(
		'users'=>$users,
		'departments'=>$departments
		);
        return view('settings.department')->with($data);
    }
			public function adddepartment(Request $request){

        try{
			if(!empty($request->id)){
				 try{
					$department= Department::where('id','=' ,$request->id)->first();
					$department_agents = DB::table('department_agents')
					->where('department_id','=', $request->id)->count();
					if($department_agents>0){
					$agents = DB::table('departments')
					->leftjoin('department_agents', 'departments.id', '=', 'department_agents.department_id')
					->leftjoin('users', 'users.id', '=', 'department_agents.agent_id')
					->where('users.company_id','=', Auth::user()->company_id)
					->where('departments.id','=', $request->id)
					->get();


					$agentids = DB::table('department_agents')
					->select(DB::raw('GROUP_CONCAT(agent_id) as agent_id'))
					->where('department_id', '=', $request->id)
					 ->groupBy('department_id')
					->first()->agent_id;

					$users = DB::table('users')
					->select(DB::raw('*'))
					->where('users.company_id','=', Auth::user()->company_id)
					->whereNotIn('id', explode(",",$agentids))
					->get();
					}else{
					$agents = [];
					$users = DB::table('users')
				   ->where('users.company_id','=', Auth::user()->company_id)
					->get();
					}
				     return response(['status'=>'success', 'details'=>array('department'=>$department,'agents'=>$agents,'users'=>$users)]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			 if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter a department name"]);
			}
			 else if($request->description==''){
				return response(['status'=>'error', 'details'=>"Please enter a department description"]);
			}
			else{
            $department = new Department;
            $department->department_name = $request->input('name');
			$department->description = $request->input('description');
			$department->company_id = Auth::user()->company_id;
            $department->save();
			$ids= explode(",",$request->input('agentids'));

			$final = [];
			if(!empty($ids) && !empty($ids[0])){
			foreach($ids as $id){
			$final[]=array('agent_id'=>$id,'department_id'=>$department->id);	
			}

			DB::table('department_agents')->insert($final);
			}
			$departments= Department::where('company_id', Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$departments]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	    public function updatedepartment(Request $request){

        try{

			 if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter a department name"]);
			}
			 else if($request->description==''){
				return response(['status'=>'error', 'details'=>"Please enter a department description"]);
			}
			else{
            $department =  Department::find($request->input('id'));
            $department->department_name = $request->input('name');
			$department->description = $request->input('description');
			
            $department->save();
			DB::table('department_agents')->where('department_id', '=', $request->input('id'))->delete();
			$ids= explode(",",$request->input('agentids'));
	
			$final = [];
			foreach($ids as $id){
			$final[]=array('agent_id'=>$id,'department_id'=>$request->input('id'));	
			}
			DB::table('department_agents')->insert($final);
		
			$departments= Department::where('company_id', Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$departments]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	   	public function view_department($id)
    {
			$departments = User::find($id);
			$data = array(
			'departments'=>$departments
			);
			
			return view('agent_department')->with($data);
	}
		   	public function view_agent($id)
    {
			$agents = Department::find($id);
			$data = array(
			'agents'=>$agents
			);
			
			return view('department_agents')->with($data);
	}
}
