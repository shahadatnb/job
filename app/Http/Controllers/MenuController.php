<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Post;

class MenuController extends Controller
{

    public function index()
    {
        $menus = Menu::where('branch_id', session('branch')['id'])->orderBy('title', 'asc')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function menuSl(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach($ids as $key=>$id){
            $data = MenuItem::findOrFail($id);
            $data->sl = $key;
            $data->save();
        }
        return response()->json(array('msg'=> $ids), 200);
    }

    protected function menuType(){
        return [
            'others' => 'In site',
            'extrenal' => 'Extrenal',
            'home' => 'Home page',
        ];
    }

    protected function parent_id($menu_id){
        $MenuItem = MenuItem::where('menu_id',$menu_id)->where('parent_id',null)->orderBy('sl','asc')->get();
        $menu_id = array();
        foreach ($MenuItem as $value) {
            $menu_id[$value->id] = $value->lebel;
        }
        return $menu_id;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'Title'=>['required','string','max:200'],
            'menu_id'=>['required','unique:menus','alpha_dash'],
        ]);

        $data = new Menu;
        $data->branch_id = session('branch')['id'];
        $data->Title = $request->Title;
        $data->menu_id = $request->menu_id;
        $data->save();

        session()->flash('success', "Saved.");
        return redirect()->route('menus.index');
    }
    
    public function show($id)
    {
        $menu = Menu::where('branch_id', session('branch')['id'])->where('id', $id)->first();
        $menuType = $this->menuType();
        $parent_id = $this->parent_id($menu->id);
        $pages = Post::where('post_type', 'page')->where('branch_id', session('branch')['id'])->orderBy('title', 'asc')->get();
        return view('admin.menus.show', compact('menu','menuType','parent_id','pages'));
    }
    
    public function menuItemStore(Request $request)
    {
        $this->validate($request, [
            'lebel'=>['required','string','max:200'],
            'menu_url'=>['required','string','max:200'],
            'menuType'=>['required','string','max:200'],
            'menu_class'=>['nullable','string','max:200'],
        ]);

        $data = new MenuItem;
        $data->lebel = $request->lebel;
        $data->menu_url = $request->menu_url;
        $data->menuType = $request->menuType;
        $data->parent_id =  $request->parent_id;
        $data->menu_id = $request->menu_id;
        $data->menu_class = $request->menu_class;
        $data->save();
        
        session()->flash('success', "Saved.");
        return redirect()->back();
    }
    
    public function menuItemEdit($id)
    {
        $menu = MenuItem::where('id', $id)->first();
        $menuType = $this->menuType();
        $parent_id = $this->parent_id($menu->menu_id);
        return view('admin.menus.menuItemEdit', compact('menu','menuType','parent_id'));
    }

    public function menuItemUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'lebel'=>['required','string','max:200'],
            'menu_url'=>['required','string','max:200'],
            'menu_class'=>['nullable','string','max:80'],
            'menuType'=>['required','string','max:200'],
        ]);

        $data = MenuItem::findOrFail($id);
        $data->lebel = $request->lebel;
        $data->menu_url = $request->menu_url;
        $data->menu_class = $request->menu_class;
        $data->menuType = $request->menuType;
        $data->parent_id = $request->parent_id;
        $data->save();

        session()->flash('success', "Saved.");
        return redirect()->back();
        //return redirect()->route('menus.show',$data->menu_id);
    }
        
    public function menuItemDelete($id)
    {
        $data = MenuItem::findOrFail($id);
        $data->delete();
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $data = Menu::findOrFail($id);
        if($data->menuItem()->count() > 0){
            session()->flash('warning', "please delete sub menu first");
            return redirect()->back();
        }
        $data->delete();
        return redirect()->back();
    }
}
