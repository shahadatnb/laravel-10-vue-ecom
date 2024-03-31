<?php
namespace App\Http\Traits;
use Illuminate\Support\Arr;
use App\Models\Taxonomy;
use App\Facades\CustomHelperFacade as CustomHelper;

trait PostTrait {

	protected $postType = array(
        'post' => array(
            'title'     => 'Post',
            'postType'  => 'post',
            'icon'  => 'fa-thumbtack',
            'taxonomy'  => true,
            'support'   => array('title','body','image','slug'),
        ),        
        'page' => array(
            'title'     => 'Page',
            'postType'  => 'page',
            'icon'      => 'fa-file',
            'taxonomy'  => false,
            'support'   => array('title','body','image','slug'),
        ),
        'slide' => array(
            'title'     => 'Slide',
            'postType'  => 'slide',
            'icon'      => 'fa-image',
            'taxonomy'  => false,
            'support'   => array('title','body','image'),
            'postMeta'  => array(
                array('name'=>'link','title'=>'Link','fildType'=>'text','required'=>true),
            )
        ),
        // 'photogallery' => array(
        //     'title'     => 'Photo gallery',
        //     'postType'  => 'photogallery',
        //     'icon'      => 'fa-image',
        //     'taxonomy'  => true,
        //     'support'   => array('title','image'),
        // ),        
        'offer' => array(
            'title'     => 'Offer',
            'postType'  => 'offer',
            'icon'      => 'fa-thumbtack',
            'taxonomy'  => false,
            'support'   => array('title','image'),//,'postMeta'
            'postMeta'  => array(
                array('name'=>'line2','title'=>'Line2','fildType'=>'text','required'=>true),
                array('name'=>'link','title'=>'Link','fildType'=>'text','required'=>true),
            )
        ),
        
        'review' => array(
            'title'     => 'Testimonial',
            'postType'  => 'review',
            'icon'      => 'fa-thumbtack',
            'taxonomy'  => false,
            'support'   => array('title','body','image'),//,'postMeta'
            'postMeta'  => array(
                array('name'=>'profession','title'=>'Profession','fildType'=>'text','required'=>true),
                array('name'=>'ratting','title'=>'Ratting','fildType'=>'number','required'=>false),
            )
        ),
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