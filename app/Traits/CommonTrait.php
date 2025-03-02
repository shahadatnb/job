<?php
namespace App\Traits;

use App\Models\Location;

trait CommonTrait {

    public function zilaArray() {
        $parants = Location::where('parent_id', null)->get();
        $plocations = [];
        foreach ($parants as $parant) {
            $plocations[$parant->id] = $parant->name;
        }
        return $plocations;
    }

    public function upaZilaArray($parent_id) {
        $parants = Location::where('parent_id', $parent_id)->get();
        $plocations = [];
        foreach ($parants as $parant) {
            $plocations[$parant->id] = $parant->name;
        }
        return $plocations;
    }

}
