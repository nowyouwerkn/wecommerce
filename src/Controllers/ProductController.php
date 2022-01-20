<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Purifier;
use Storage;
use Image;
use DB;

use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\ProductSize;
use Nowyouwerkn\WeCommerce\Models\ProductImage;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\ProductRelationship;

/* Exportar Info */
use Maatwebsite\Excel\Facades\Excel;
use Nowyouwerkn\WeCommerce\Exports\ProductExport;
use Nowyouwerkn\WeCommerce\Exports\InventoryExport;
use Nowyouwerkn\WeCommerce\Imports\ProductImport;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $products = Product::paginate(15);

        return view('wecommerce::back.products.index')->with('products', $products);
    }

    public function create()
    {
        $categories = Category::where('parent_id', NULL)->orWhere('parent_id', '0')->get();

        return view('wecommerce::back.products.create')
        ->with('categories', $categories);
    }

        public function promotions()
    {
        $products = Product::where('has_discount', true)->paginate(15);

        return view('wecommerce::back.products.index')->with('products', $products);
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'unique:products|required|max:255',
            'description' => 'required',
            'price' => 'required',
            'model_image' => 'sometimes|image',
            'sku' => 'required',
        ));

        /* Crear categoría si usuario activó opción */
        if ($request->category_name != NULL) {
            $category = new Category;

            $category->name = $request->category_name;
            $category->slug = Str::slug($request->category_name);

            $category->save();
        }

        // Guardar datos en la base de datos
        $product = new Product;

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->materials = $request->materials;
        $product->color = $request->color;
        $product->pattern = $request->pattern;

        $product->in_index = $request->in_index;
        $product->is_favorite = $request->is_favorite;
        
        $product->price = str_replace(',', '', $request->price);
          if ($request->discount_price != NULL) {
             $product->discount_price = str_replace(',', '',  $request->discount_price);
        }else{
             $product->discount_price = $request->discount_price;
        }

        if ($request->production_cost != NULL) {
              $product->production_cost = str_replace(',', '', $request->production_cost);
        }else{
             $product->production_cost = $request->production_cost;
        }
        $product->has_discount = $request->has_discount;
        $product->discount_start = $request->discount_start;
        $product->discount_end = $request->discount_end;

        $product->has_tax = $request->has_tax;

        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->stock = $request->stock;

        $product->has_variants = $request->has_variants;

        $product->size_chart_file = $request->size_chart_file;
        $product->height = $request->height;
        $product->width = $request->width;
        $product->lenght = $request->lenght;
        $product->weight = $request->weight;

        if ($request->category_name != NULL) {
            $product->category_id= $category->id;
        }else{
            $product->category_id = $request->category_id;
        }
        
        $product->status = $request->status;
        $product->search_tags = $request->search_tags;

        $product->age_group = $request->age_group;
        $product->brand = $request->brand;
        $product->gender = $request->gender;
        $product->availability = $request->availability;
        $product->visibility = $request->visibility;
        $product->condition = $request->condition;
        $product->product_type = $request->product_type;
        $product->fb_product_category = $request->fb_product_category;
        $product->google_product_category = $request->google_product_category;


        $product->available_date_start = $request->available_date_start;

        if ($request->hasFile('model_image')) {
            $model_image = $request->file('model_image');
            $filename = 'model' . time() . '.' . $model_image->getClientOriginalExtension();
            $location = public_path('img/products/' . $filename);

            Image::make($model_image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $product->image = $filename;
        }

        $product->save();

        $product->subCategory()->sync($request->subcategory);

        // Notificación
        $type = 'Producto';
        $by = Auth::user();
        $data = 'creó el nuevo producto con nombre: ' . $product->name;
        $model_action = "create";
        $model_id = $product->id;



        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Tu producto se guardó exitosamente en la base de datos.');

        // Enviar a vista
        return redirect()->route('products.show', $product->id);

    }

    public function show($id)
    {
        
        $product = Product::findOrFail($id);
        $categories = Category::where('parent_id', NULL)->orWhere('parent_id', '0')->get();
        $variant_stock = ProductVariant::where('product_id', $product->id)->get();
        $related_products = Product::where('category_id', $product->category_id)->orWhere('brand', $product->brand)->where('id', '!=' , $product->id)->get();
        $product_is_base = ProductRelationship::where('base_product_id', $product->id)->first();
        $relationship_product = ProductRelationship::where('product_id', $product->id)->first();

        if (!empty($product_is_base)) {
            $base_product = Product::where('id', $product_is_base->base_product_id)->first();
        }elseif(!empty($relationship_product)){
            $base_product = Product::where('id', $relationship_product->base_product_id)->first();
        }
        $base_relationship = ProductRelationship::where('base_product_id', $base_product->id)->first();
        $products_in_relationship = ProductRelationship::where('base_product_id', $base_product->id)->get();

        $total_qty = 0;

        foreach ($variant_stock as $v_stock) {
            $total_qty += $v_stock->stock;
        };

        $total_qty;

        return view('wecommerce::back.products.show')
        ->with('product', $product)
        ->with('variant_stock', $variant_stock)
        ->with('categories', $categories)
        ->with('total_qty', $total_qty)
        ->with('related_products', $related_products)
        ->with('base_product', $base_product)
        ->with('base_relationship', $base_relationship)
        ->with('products_in_relationship', $products_in_relationship)
        ->with('relationship_product', $relationship_product);
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('model_image')) {

            $product = Product::find($request->product_id);

            $model_image = $request->file('model_image');
            $filename = 'model' . time() . '.' . $model_image->getClientOriginalExtension();
            $location = public_path('img/products/' . $filename);

            Image::make($model_image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $product->image = $filename;

            $product->save();
        }

        if ($request->hasFile('image')) {
            // Guardar datos en la base de datos
            $var_imagen = new ProductImage;

            $var_imagen->description = $request->description;
            $var_imagen->product_id = $request->product_id;
            $var_imagen->priority = $request->priority;

            // Esto se logra gracias a la libreria de imagen Intervention de Laravel
            $imagen = $request->file('image');
            $nombre_archivo = Str::random(8) . '_productitem' . '.' . $imagen->getClientOriginalExtension();
            $ubicacion = public_path('img/products/' . $nombre_archivo);

            Image::make($imagen)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($ubicacion);

            $var_imagen->image = $nombre_archivo;

            $var_imagen->save();
        }

        // Mensaje de session
        Session::flash('success', 'Imagen guardada exitosamente para el producto.');

        // Enviar a vista
        return redirect()->back();
    }

       public function updateImage(Request $request)
    {

        $var_imagen = ProductImage::find($request->id);
        $var_imagen->priority = $request->priority;
        $var_imagen->description = $request->description;

        $var_imagen->save();

        Session::flash('success', 'La imagen fue actualizada exitosamente');


        return redirect()->back();
    }

    public function destroyImage($id)
    {
        $var_imagen = ProductImage::find($id);
        $var_imagen->delete();
        Session::flash('success', 'La imagen fue borrada exitosamente');


        return redirect()->back();
    }

    public function storeLifestyle(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'description' => 'nullable',
        ));

        // Guardar datos en la base de datos
        $var_imagen = new ProductLifestyle;

        $var_imagen->description = $request->description;
        $var_imagen->product_id = $request->product_id;

        // Esto se logra gracias a la libreria de imagen Intervention de Laravel
        if ($request->hasFile('image')) {
            $imagen = $request->file('image');
            $nombre_archivo = Str::random(8) . '_lifestyle' . '.' . $imagen->getClientOriginalExtension();
            $ubicacion = public_path('img/products/lifestyle/' . $nombre_archivo);

            Image::make($imagen)->resize(800,null, function($constraint){ $constraint->aspectRatio(); })->save($ubicacion);

            $var_imagen->image = $nombre_archivo;
        }

        $var_imagen->save();

        // Mensaje de session
        Session::flash('success', 'Imagen guardada correctamente y vinculada al producto.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroyLifestyle($id)
    {

        $var_imagen = ProductLifestyle::find($id);

        $var_imagen->delete();

        Session::flash('success', 'Imagen eliminada exitosamente.');


        return redirect()->back();
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        return view('wecommerce::back.products.edit')
        ->with('product', $product)
        ->with('categories', $categories);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'description' => 'required',
            'price' => 'required',
            'model_image' => 'sometimes|image',
            'sku' => 'nullable',
        ));

        // Guardar datos en la base de datos
        $product = Product::find($id);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->materials = $request->materials;
        $product->color = $request->color;
        $product->pattern = $request->pattern;

        $product->in_index = $request->in_index;
        $product->is_favorite = $request->is_favorite;
        
        $product->price = str_replace(',', '', $request->price);
        $product->discount_price = str_replace(',', '',  $request->discount_price);
        $product->production_cost = str_replace(',', '', $request->production_cost);

        $product->has_discount = $request->has_discount;
        $product->discount_start = $request->discount_start;
        $product->discount_end = $request->discount_end;

        $product->has_tax = $request->has_tax;

        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->stock = $request->stock;

        $product->has_variants = $request->has_variants;

        $product->size_chart_file = $request->size_chart_file;
        $product->height = $request->height;
        $product->width = $request->width;
        $product->lenght = $request->lenght;
        $product->weight = $request->weight;

        $product->category_id = $request->category_id;
        
        $product->status = $request->status;
        $product->search_tags = $request->search_tags;

        $product->age_group = $request->age_group;
        $product->brand = $request->brand;
        $product->gender = $request->gender;
        $product->availability = $request->availability;
        $product->visibility = $request->visibility;
        $product->condition = $request->condition;
        $product->product_type = $request->product_type;
        $product->fb_product_category = $request->fb_product_category;
        $product->google_product_category = $request->google_product_category;

        $product->available_date_start = $request->available_date_start;

        if ($request->hasFile('model_image')) {
            $model_image = $request->file('model_image');
            $filename = 'model' . time() . '.' . $model_image->getClientOriginalExtension();
            $location = public_path('img/products/' . $filename);

            Image::make($model_image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $product->image = $filename;
        }

        $product->save();

        if (isset($request->subcategory)) {
            $product->subCategory()->sync($request->subcategory);
        }

        // Notificación
        $type = 'Producto';
        $by = Auth::user();
        $data = 'actualizó el producto ' . $product->name;
        $model_action = "update";
        $model_id = $id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Producto actualizado exitosamente.');

        // Enviar a vista
        return redirect()->route('products.show', $product->id);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        // Notificación
        $type = 'Producto';
        $by = Auth::user();
        $data = 'eliminó permanentemente el producto ' . $product->name;
        $model_action = "delete";
        $model_id = $product->id;



        $this->notification->send($type, $by ,$data, $model_action, $model_id);
        //
        $product->delete();

        Session::flash('success', 'Este producto se eliminó exitosamente.');

        return redirect()->route('products.index');
    }

    public function fetchSubcategory(Request $request)
    {
        $value = $request->get('value');

        return response()->json(Category::where('parent_id', $value)->get());
    }

    public function export() 
    {
        return Excel::download(new ProductExport, 'productos.xlsx');
    }

      public function export_inventory_changes() 
    {
        return Excel::download(new InventoryExport, 'inventario.xlsx');
    }

    public function import(Request $request) 
    {
        Excel::import(new ProductImport, $request->import_file);
        
        return redirect()->back()->with('success', 'Documento importado correctamente.');
    }

    public function stockUpdate(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $product = Product::find($id);
        $by = Auth::user();
        if ($product->stock != $request->stock_variant) {
             $values = array('action_by' => $by->id,'initial_value' => $product->stock, 'final_value' => $request->stock_variant, 'product_id' => $id);
            DB::table('inventory_record')->insert($values);
        }
       
        
        $product->stock = $request->stock_variant;
        //$stock->sku = $request->sku_variant;

          // Notificación
        $type = 'Producto';
        $data = 'Actualizó el inventario del producto:' . $product->name;
        $model_action = "update";
        $model_id = $product->id;



        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        $product->save();

        // Mensaje de session
        Session::flash('success', 'Se actualizó exitosamente tu stock.');

        // Enviar a vista
        return redirect()->back();
    }

        public function search(Request $request)
    {
        $search_query = $request->input('query');
         $products = Product::where('name', 'LIKE', "%{$search_query}%")
        ->where('category_id', '!=', NULL)
        ->orWhere('description', 'LIKE', "%{$search_query}%")
        ->orWhere('search_tags', 'LIKE', "%{$search_query}%")
        ->orWhereHas('category', function ($query) use ($search_query) {
            $query->where(strtolower('name'), 'LIKE', '%' . strtolower($search_query) . '%');
        })->paginate(10);

        return view('wecommerce::back.products.index')->with('products', $products);
    }

      public function filter($order , $filter)
    {

        $products = Product::orderBy($filter, $order)->paginate(15); 
        
        if ($filter == 'sku' && $order == 'desc') {
            $products = Product::orderByRaw('sku * 1 desc')->paginate(15);
        }
        if($filter == 'sku'&& $order == 'asc'){
            $products = Product::orderByRaw('sku * 1 asc')->paginate(15);
        }
        if ($filter == 'price' && $order == 'desc') {
            $products = Product::orderByRaw('price * 1 desc')->paginate(15);
        }
        if($filter == 'price'&& $order == 'asc'){
            $products = Product::orderByRaw('price * 1 asc')->paginate(15);
        }
        if ($filter == 'discount_price' && $order == 'desc') {
            $products = Product::orderByRaw('discount_price * 1 desc')->paginate(15);
        }
        if($filter == 'discount_price'&& $order == 'asc'){
            $products = Product::orderByRaw('discount_price * 1 asc')->paginate(15);
        }
       
        return view('wecommerce::back.products.index')->with('products', $products);

    }

    /*
    public function storeDynamic(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'unique:products|required|max:255',
            'description' => 'required',
            'price' => 'required',
            'model_image' => 'sometimes|image',
            'sku' => 'nullable',
        ));

        // Guardar datos en la base de datos
        $product = new Product;

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->materials = $request->materials;
        $product->color = $request->color;
        $product->pattern = $request->pattern;

        $product->in_index = $request->in_index;
        $product->is_favorite = $request->is_favorite;
        
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->production_cost = $request->production_cost;

        $product->has_discount = $request->has_discount;
        $product->has_tax = $request->has_tax;

        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->stock = $request->stock;

        $product->has_variants = $request->has_variants;

        $product->size_chart_file = $request->size_chart_file;
        $product->height = $request->height;
        $product->width = $request->width;
        $product->lenght = $request->lenght;
        $product->weight = $request->weight;

        $product->category_id = $request->category_id;
        
        $product->status = $request->status;
        $product->search_tags = $request->search_tags;
        $product->available_date_start = $request->available_date_start;

        if ($request->hasFile('model_image')) {
            $model_image = $request->file('model_image');
            $filename = 'model' . time() . '.' . $model_image->getClientOriginalExtension();
            $location = public_path('img/products/' . $filename);

            Image::make($model_image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $product->image = $filename;
        }

        $product->save();

        $product->subCategory()->sync($request->subcategory);

        // Notificación
        $type = 'Producto';
        $by = Auth::user();
        $data = 'creó el nuevo producto con nombre: ' . $product->name;

        $this->notification->send($type, $by ,$data);

        return response()->json([
            'mensaje' => 'Gran Mensaje', 
            'product_id' => $product->id
        ], 200);
    }
    */
}
