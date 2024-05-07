<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\{User};
use Session;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\Cast\Object_;

class OrganisationController extends Controller
{

    function index()
    {

        $page_data['all_users'] = User::select('id', 'manager', 'photo as imageURL', 'name', 'designation')->where('status', 'active')->orderBy('sort')->get()->toArray();
// var_dump($page_data['all_users']);exit;
        foreach($page_data['all_users'] as $key => $user){
            if($user['id'] == $user['manager']){
                $page_data['all_users'][$key]['manager']= 0;
            }
            if($user['imageURL']){
                $page_data['all_users'][$key]['imageURL']=  '/hr/public/uploads/user-image/' . $user['imageURL'];
            }else{
                $page_data['all_users'][$key]['imageURL']=  '/hr/public/uploads/user-image/placeholder/placeholder.png';
            }
        }
        $page_data['all_users_structure'] = $this->buildTree($page_data['all_users']);

        $cc = $this->getRandomColor();
        $icc = $this->invertColor($cc);
        $page_data['all_users_structure'] = [
            "id"=> "0",
            "data"=> [
                "imageURL"=> "/hr/public/assets/images/zettamine-logo.png",
                "name"=> "Zettamine",
            ],
            "options"=> [
                "nodeBGColor"=> $cc,
                "nodeBGColorHover"=> $icc,
            ],
            "children"=>$page_data['all_users_structure']
        ];
        return view(auth()->user()->role . '.organisation.index', $page_data);
    }

    // Function to convert flat array to hierarchical structure
    function buildTree(array $elements, $parentId = 0)
    {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['manager'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                
                $element = $this->changeStructure($element);
                $branch[] = $element;
            }
        }
        return $branch;
    }

    function changeStructure($element){
        $cc = $this->getRandomColor();
        $icc = $this->invertColor($cc);
        if(isset($element['children'])){
            return array('id'=>(string)$element['id'], 'data'=>array('imageURL'=>$element['imageURL'], 'name'=>$element['name'].'('.$element['designation'].')'), 'options'=>array('nodeBGColor'=>$cc, 'nodeBGColorHover'=>$icc), 'children'=>$element['children']);
        }else{
            return array('id'=>(string)$element['id'], 'data'=>array('imageURL'=>$element['imageURL'], 'name'=>$element['name'].'('.$element['designation'].')'), 'options'=>array('nodeBGColor'=>$cc, 'nodeBGColorHover'=>$icc));
        }

    }

    // Function to convert hierarchical structure to desired format
    function formatTree(array $tree)
    {
        $formatted = [];
        foreach ($tree as $node) {
            $formattedNode = [
                'id' => $node['id'],
                'data' => [
                    'imageURL' => $node['image'],
                    'name' => $node['name'],
                ],
                'options' => [
                    'nodeBGColor' => '#cdb4db',
                    'nodeBGColorHover' => '#cdb4db',
                ],
            ];
            if (isset($node['children'])) {
                $formattedNode['children'] = $this->formatTree($node['children']);
            }
            $formatted[] = $formattedNode;
        }
        return $formatted;
    }


    function getRandomColor()
    {
        // Generate a random integer between 0 and 16777215
        $randomInt = mt_rand(0, 16777215);
        // Convert the integer to a hexadecimal string
        $hexColor = dechex($randomInt);
        // Ensure the hexadecimal string is 6 characters long, pad with zeros if necessary
        $hexColor = str_pad($hexColor, 6, '0', STR_PAD_LEFT);
        // Prefix with '#' and return the color
        return '#' . $hexColor;
    }

    function invertColor($hexColor)
    {
        // Remove the hash if it's there
        $hexColor = str_replace('#', '', $hexColor);

        // Calculate inverted (complementary) color
        $r = 255 - hexdec(substr($hexColor, 0, 2));
        $g = 255 - hexdec(substr($hexColor, 2, 2));
        $b = 255 - hexdec(substr($hexColor, 4, 2));

        // Convert RGB back to hex
        $invertedColor = sprintf("#%02x%02x%02x", $r, $g, $b);

        return $invertedColor;
    }

    function getParentStructure($data, $parent_structure, $child_id)
    {
        foreach ($data as $k => $v) {
            if ($v->id == $child_id) {
                array_unshift($parent_structure, $v->parent);
                if ($v->parent != 0) {
                    $this->getParentStructure($data, $parent_structure, $v->parent);
                } else {
                    return $parent_structure;
                }
            }
        }
    }

    function setDataInChildrenArray(&$array, $keys, $value, $depth = 0)
    {
        if (empty($keys)) {
            // If no more keys, set the value
            $array = $value;
            return;
        }

        $currentKey = array_shift($keys); // Get the current key and advance the keys array

        // Ensure there is a 'children' array to navigate into
        if (!isset($array[$currentKey]['children'])) {
            $array[$currentKey]['children'] = []; // Initialize if the key doesn't exist
        }

        // Check if there are still keys left to navigate through
        if (!empty($keys)) {
            // Recursively navigate deeper into the 'children'
            $this->setDataInChildrenArray($array[$currentKey]['children'], $keys, $value, $depth + 1);
        } else {
            // If at the final depth, set the value
            $array[$currentKey]['children'][] = $value;
        }

        return $array;
    }
}
