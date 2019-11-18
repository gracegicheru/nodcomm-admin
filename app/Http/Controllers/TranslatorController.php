<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use App\Translator;
use File;
use Lang;
use Redirect;
use Session;
class TranslatorController extends Controller
{
     private $translator ;
     public function __construct()
    {
	 set_time_limit(300);
    $this->middleware('auth');
	$this->translator = new Translator();
    }
	 public function index()
    {

		$data = array(
		'langs'=>$this->translator->translate_langs(),
		'languages'=>Translator::all()
		);
		return view('translator')->with($data);
	}
		public function create_lang_folder(Request $request){
			if($request->lang==''){
				return response(['status'=>'error', 'details'=>"Please select a language"]);
			}else{
			if(Translator::where('lang_code','=',$request->input('lang'))->count() == 0 ){
			
			$folder = $request->lang;
			//File::makeDirectory(base_path('resources/lang/'.$folder));
			return response(['status'=>'success', 'lang_code'=>$folder,'lang'=> $request->input('lang_text')]);
			}else{
			return response(['status'=>'error', 'details'=>'This language is already translated']);
			}
			}
		}
		
		public function create_lang_file(Request $request){

		$folder = $request->lang_code;
		$array = Lang::get('menu');
		$translated_array =[];
		foreach($array as $key => $value)
		{
			$translated_array [$key] =$this->translator->translate($value,$folder);
		}
		//file_put_contents(base_path('resources/lang/'.$folder.'/menu.php'), '<?php return ' . var_export($translated_array, true) . ';');
		return response(['status'=>'success', 'lang_code'=>$folder,'lang'=> $request->lang,'translated_array'=> $translated_array]);
		}
		/*public function create_lang_file(Request $request){

		$folder = $request->lang_code;
		$array = Lang::get('menu');
		$translated_array =[];
		foreach($array as $key => $value)
		{
			$translated_array [$key] =$this->translator->translate($value,$folder);
		}
		file_put_contents(base_path('resources/lang/'.$folder.'/menu.php'), '<?php return ' . var_export($translated_array, true) . ';');
		return response(['status'=>'success', 'lang_code'=>$folder,'lang'=> $request->lang]);
		}*/
		public function save_translated_lang(Request $request){
			$country =JSON_decode(@file_get_contents('https://restcountries.eu/rest/v2/lang/'.$request->input('lang_code')));
			if(empty($country)){
			$flag = 'https://restcountries.eu/data/usa.svg';
			$alpha2Code='';
			}else{
			$flag=$country[0]->flag;
			$alpha2Code=$country[0]->alpha2Code;
			}
			$lang = new Translator;
			$lang->lang_code = $request->input('lang_code');
			$lang->lang = $request->input('lang');
			$lang->flag = $flag;
			$lang->country = $alpha2Code;
			$lang->save();

			$langs= Translator::all();
			return response(['status'=>'success', 'details'=>$langs,'flag'=>$flag,'country'=>$alpha2Code]);	
		}
		public function changelocale(Request $request){
			   App::setLocale(json_decode($request->content,true));
			   Session::put('applocalearray', json_decode($request->content,true));
			   Session::put('applocale', $request->id);
			   return response(['status'=>'success','details'=>url()->previous()]);
		}
		public function retrieve_file(Request $request){
			
	    $data = array(
		'file'=>json_decode($request->content,true),
		'lang_code'=>$request->id
		);
		session(['file_data' => $data]);
		return response(['status'=>'success','details'=>url('/translation/view-file/'.$request->id)]);
		}
		
	   public function view_file($lang_code){
		if(Session::has('file_data') && ((Session::get('file_data')['lang_code'])==$lang_code)){
		return view('view_files')->with(Session::get('file_data'));
		}else{
		return redirect()->route('translation');
		}
		}
	    public function save_file(Request $request){
			
		$array = File::getRequire(base_path('resources/lang/'.$request->lang_code.'/menu.php'));

		$array[$request->array_key] = $request->array_value;
		
		file_put_contents(base_path('resources/lang/'.$request->lang_code.'/menu.php'), '<?php return ' . var_export($array, true) . ';');
		return response(['status'=>'success','details'=>$array]);
		}
}
