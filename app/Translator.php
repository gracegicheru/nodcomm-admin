<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Google\Cloud\Translate\TranslateClient;
class Translator extends Model
{
		public $table='translation';
	    protected $fillable = [
        'lang_code', 'lang'
        ];
	    public function translate($text,$target){

    	if(isset($text) && !empty($text)){
    		putenv('GOOGLE_APPLICATION_CREDENTIALS='.base_path('/keys/writenod-f6dc142b47a8.json'));
			$project_id = 'writenod-196613';

	    	$translate = new TranslateClient([
			    'projectId' => $project_id
			]);

			# Translates some text
			$translation = $translate->translate($text, [
			    'target' => $target
			]);
			return $translation['text'];
		}
    }
	 public function translate_langs(){
		putenv('GOOGLE_APPLICATION_CREDENTIALS='.base_path('/keys/writenod-f6dc142b47a8.json'));
		$project_id = 'writenod-196613';
		$translate = new TranslateClient([
			    'projectId' => $project_id
		]);
		$result = $translate->localizedLanguages([]);
		return $result;

	 }
}
