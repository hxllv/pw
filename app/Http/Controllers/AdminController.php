<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Type;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Item::get();
        $types = Type::get();

        return view('admin.admin')->with('items', $items)->with('types', $types);
    }

    public function items(Request $req)
    {
        $types = Type::get();
        $items = Item::get();

        $type = $req->input('type');
        $avail = $req->input('avail');

        if ($type !== null) 
        {
            $items = collect($items->where("type_id", $type)->all());
        }

        if ($avail !== null)
        {
            $items = collect($items->where("available", $avail)->all());
        }

        return view('admin.items')->with('items', $items)->with('types', $types)->with("curType", $type);
    }

    public function createItem()
    {
        $types = Type::get();

        return view('admin.add-item')->with('types', $types);
    }

    public function storeItem()
    {
        $data = request()->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|numeric',
            'price' => 'required|numeric',
            'main-img' => 'required|image',
            'extra-img-1' => 'image',
            'extra-img-2' => 'image',
            'extra-img-3' => 'image',
            'extra-img-4' => 'image',
            'extra-img-5' => 'image',
            'extra-img-6' => 'image'
        ]);

        $imagePath = $data['main-img']->store('uploads', 'public');

        resize($imagePath, 500);
        resize($imagePath, 1000);

        $createdItem = Type::find($data['type'])->hasManyItems()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'available' => true,
            'price' => $data['price'],
            'main_image' => $imagePath,
        ]);

        for ($i = 1; $i <= 6; $i++) {
            if (!isset($data["extra-img-$i"])) continue;

            $imagePath = $data["extra-img-$i"]->store('uploads', 'public');

            resize($imagePath, 500);
            resize($imagePath, 1000);

            Item::find($createdItem->id)->hasManyImages()->create([
                'image' => $imagePath
            ]);
        }

        return redirect('/admin/index');
    }

    public function showItem(\App\Models\Item $item)
    {
        $type = $item->belongsToType()->get();
        $imgs = $item->hasManyImages()->get();

        return view('admin.show-item')->with('item', $item)->with('type', $type)->with('imgs', $imgs);
    }

    public function editItem(\App\Models\Item $item)
    {
        $types = Type::get();
        $imgs = $item->hasManyImages()->get();

        return view('admin.add-item')->with('types', $types)->with('item', $item)->with('imgs', $imgs);
    }

    public function updateItem(\App\Models\Item $item)
    {
        if (request('available') !== null) {
            $data = request()->validate([
                'available' => 'required|numeric'
            ]);

            $item->available = $data['available'];
            $item->save();

            return $data['available'];
        }

        $data = request()->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|numeric',
            'price' => 'required|numeric',
            'main-img' => 'image',
            'extra-img-edit-1' => 'numeric',
            'extra-img-1' => 'image',
            'extra-img-edit-2' => 'numeric',
            'extra-img-2' => 'image',
            'extra-img-edit-3' => 'numeric',
            'extra-img-3' => 'image',
            'extra-img-edit-4' => 'numeric',
            'extra-img-4' => 'image',
            'extra-img-edit-5' => 'numeric',
            'extra-img-5' => 'image',
            'extra-img-edit-6' => 'numeric',
            'extra-img-6' => 'image'
        ]);

        $item->title = $data['title'];
        $item->description = $data['description'];
        $item->type_id = $data['type'];
        $item->price = $data['price'];

        if (isset($data['main-img'])) {
            $imagePath = $data['main-img']->store('uploads', 'public');
            $item->main_image = $imagePath;

            resize($imagePath, 500);
            resize($imagePath, 1000);
        }

        for ($i = 1; $i <= 6; $i++) {
            if (isset($data["extra-img-$i"])) {
                $imagePath = $data["extra-img-$i"]->store('uploads', 'public');

                resize($imagePath, 500);
                resize($imagePath, 1000);

                if (!isset($data["extra-img-edit-$i"])) {
                    $item->hasManyImages()->create([
                        'image' => $imagePath
                    ]);

                    continue;
                }


                $item->hasManyImages->find($data["extra-img-edit-$i"])->image = $imagePath;
            }
        }

        $item->push();

        return redirect('/admin/index');
    }

    public function destroyItem(\App\Models\Item $item)
    {
        $item->hasManyImages()->delete();
        $item->delete();

        return redirect('/admin/index');
    }

    public function storeType()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'description' => 'string'
        ]);

        return Type::create(['name' => $data['name'], 'description' => $data['description']]);
    }

    public function showType(\App\Models\Type $type)
    {
        return view('admin.show-type')->with('type', $type);
    }

    public function updateType(\App\Models\Type $type)
    {
        $data = request()->validate([
            'name' => 'required|string',
            'description' => 'string'
        ]);

        $type->name = $data['name'];
        $type->description = $data['description'];
        $type->save();

        return redirect('/admin/index');
    }

    public function destroyType(\App\Models\Type $type)
    {
        $type->delete();

        return redirect('/admin/index');
    }
}

function resize($imagePath, $width)
{
    $image = Image::make(public_path("storage/$imagePath"));

    $imagePathResize = str_replace('/', "/$width" . '_', $imagePath);
    $imageResize = $image->resize($width, null, function ($constraint) {
        $constraint->aspectRatio();
    });

    $imageResize->save("storage/$imagePathResize");
}
