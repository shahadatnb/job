<?php
namespace App\Http\Traits;
use Illuminate\Support\Arr;
use App\Models\Taxonomy;

trait PostTrait {

	protected $postType = array(
        'page' => array(
            'title'     => 'Page',
            'postType'  => 'page',
            'icon'      => 'fa-file',
            'taxonomy'  => false,
            'supports'   => array('title','body','image','slug'),
        ),
        'result' => array(
            'title'     => 'Result',
            'postType'  => 'result',
            'icon'      => 'fa-image',
            'taxonomy'  => false,
            'supports'   => array('title','image'),
        ),
        'notice' => array(
            'title'     => 'Notice',
            'postType'  => 'notice',
            'icon'      => 'fa-image',
            'taxonomy'  => false,
            'supports'   => array('title','image'),
        ),
        'slider' => array(
            'title'     => 'Slider',
            'postType'  => 'slider',
            'icon'      => 'fa-image',
            'taxonomy'  => false,
            'supports'   => array('title','image'),
        ),
        'teacher' => array(
            'title'     => 'Teacher',
            'postType'  => 'teacher',
            'icon'      => 'fa-image',
            'taxonomy'  => false,
            'supports'   => array('title','image','body'),
            'postMeta'  => array(
                array('name'=>'dasignation','title'=>'Designation','fildType'=>'text','required'=>true),
            )
        ),
        'stuff' => array(
            'title'     => 'Stuff',
            'postType'  => 'stuff',
            'icon'      => 'fa-image',
            'taxonomy'  => false,
            'supports'   => array('title','image','body'),
            'postMeta'  => array(
                array('name'=>'dasignation','title'=>'Designation','fildType'=>'text','required'=>true),
            )
        )
    );

    public function postTypeCheck($request){
        if(!empty($request->type)){
            if(Arr::has($this->postType, $request->type)){
                return Arr::get($this->postType, $request->type);
            }else{
                return Arr::get($this->postType, 'post');
            }
        }else {
            return Arr::get($this->postType, 'post');
        }
    }

    public function postTypeIs($postType){
        if(Arr::has($this->postType, $postType)){
            return true;
        }else{
            return false;
        }
    }
/*
    public function postTypeCheck(){
        if(!empty(Input::get('type'))){
            if(array_has($this->postType, Input::get('type'))){
                return array_get($this->postType, Input::get('type'));
            }else{
                return array_get($this->postType, 'post');
            }
        }else {
            return array_get($this->postType, 'post');
        }
    } */

    public function taxByType($postType){
        $tax = Taxonomy::where('post_type',$postType)->where('status',1)->orderBy('title','asc')->get();
        return $tax;
    }


    public function taxArray($postType){
        $tax = $this->taxByType($postType);
        $taxs = array();
        foreach ($tax as $value) {
            $taxs[$value->id] = $value->title;
        }
        return $taxs;
    }

    public function taxIdBySlug($slug){
        $tax = Taxonomy::where('slug',$slug)->where('status',1)->first();
        //dd($tax);
        if($tax){
            return $tax;
        }else{
            //$tax = array();
            return null;
        }
    }

}
